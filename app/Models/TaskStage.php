<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStage extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'task_stage'];
}
