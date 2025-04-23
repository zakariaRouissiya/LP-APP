<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $categories = Category::all();
        $tasks = $this->taskService->getTasks($request->all());

        return view('tasks.index', compact('tasks', 'categories'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'priority' => 'required|in:faible,moyenne,élevée',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Tâche ajoutée avec succès.');
    }

    public function complete(Task $task)
    {
        $this->taskService->completeTask($task);

        return redirect()->route('tasks.index')->with('success', 'Tâche marquée comme terminée.');
    }

    public function destroy(Task $task)
    {
        $this->taskService->deleteTask($task);

        return redirect()->route('tasks.index')->with('success', 'Tâche supprimée avec succès.');
    }
}
