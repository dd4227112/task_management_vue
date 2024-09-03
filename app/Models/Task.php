<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'project_id', 'status'];
    const NOT_STATED = 0;
    const PENDING = 1;
    const COMPLETED = 2;

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function task_progress()
    {
        return $this->hasOne(Task_progress::class);
    }
    public function member_task()
    {
        return $this->hasMany(MemberTask::class);
    }
}
