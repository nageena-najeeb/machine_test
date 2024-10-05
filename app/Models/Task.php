<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'description',
        'due_date',
        'status'
    ];

    public function sharedWith()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }
}
