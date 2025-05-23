<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected $fillable = ['title', 'completed', 'completed_at', 'category_id', 'priority'];
    protected $casts = [
        'completed' => 'boolean',
        'completed_at' => 'datetime',
    ];
}
