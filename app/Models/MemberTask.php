<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberTask extends Model
{
    use HasFactory;
    public $fillable = ['member_id', 'task_id', 'project_id'];
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
