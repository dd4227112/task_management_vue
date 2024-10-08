<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    public $fillable = ['name', 'email'];
    public function memberTask()
    {
        return $this->hasMany(MemberTask::class);
    }
}
