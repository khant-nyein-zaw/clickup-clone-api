<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['task_name', 'description', 'project_id', 'priority', 'task_stage', 'assignee_id', 'started_at', 'ended_at'];
}
