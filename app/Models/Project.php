<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'startDate', 'endDate', 'slug', 'status'];
    public $table = 'projects';

    public static function createSlug($name)
    {
        $code = Str::random(10).time();
        $slug = Str::slug($name).'_'.$code;
        return $slug;
    }
    public function tasks(){
        return $this->hasMany(Task::class);
    }
}
