<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    // public $incrementing = false;

    protected $fillable = ['project_name', 'description', 'started_at', 'ended_at'];

    public function users () : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_users');
    }
}
