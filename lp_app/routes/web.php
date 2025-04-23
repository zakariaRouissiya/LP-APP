<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;


Route::get('/', [TaskController::class, 'index'])->name('tasks.index');


Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');


Route::resource('tasks', TaskController::class);


Route::patch('tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
