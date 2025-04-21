<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        
        $tasks = Task::query()
            ->when($request->category, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->when($request->title, function ($query, $title) {
                $query->where('title', 'like', '%' . $title . '%');
            })
            ->orderBy('priority', 'desc')
            ->paginate(5);

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
        $task->update([
            'completed' => true,
            'completed_at' => now(),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tâche marquée comme terminée.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tâche supprimée avec succès.');
    }
}
