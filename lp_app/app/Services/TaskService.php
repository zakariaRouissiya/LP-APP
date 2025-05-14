<?php
namespace App\Services;

use App\Contracts\TaskServiceInterface;
use App\Models\Task;

class TaskService implements TaskServiceInterface
{
    public function getTasks($filters)
    {
        return Task::query()
            ->when($filters['category'] ?? null, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->when($filters['title'] ?? null, function ($query, $title) {
                $query->where('title', 'like', '%' . $title . '%');
            })
            ->when($filters['status'] ?? null, function ($query, $status) {
                if ($status === 'completed') {
                    $query->where('completed', true);
                } elseif ($status === 'in_progress') {
                    $query->where('completed', false);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function completeTask(Task $task)
    {
        $task->update([
            'completed' => true,
            'completed_at' => now(),
        ]);
    }

    public function deleteTask(Task $task)
    {
        $task->delete();
    }
}