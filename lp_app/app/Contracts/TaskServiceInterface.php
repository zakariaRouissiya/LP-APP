<?php
namespace App\Contracts;

use App\Models\Task;

interface TaskServiceInterface
{
    public function getTasks($filters);
    public function completeTask(Task $task);
    public function deleteTask(Task $task);
}