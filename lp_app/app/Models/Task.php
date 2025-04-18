<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    
    protected $fillable = ['title', 'completed', 'completed_at'];
    protected $casts = [
        'completed' => 'boolean',
        'completed_at' => 'datetime',
    ];
}
