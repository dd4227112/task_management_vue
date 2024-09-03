<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task_progress extends Model
{
    use HasFactory;
    protected $fillable = ['task_id', 'pinned_on_dashboard', 'progress'];

    public function task()
    {
        return $this->hasOne(Task::class, 'task_id');
    }
}
