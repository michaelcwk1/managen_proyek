<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Task extends Model
{
    use Notifiable, HasRoles;
    protected $fillable = ['project_id', 'title', 'description', 'status', 'assigned_to', 'difficulty_level', 'estimated_hours', 'actual_hours', 'deadline'];
    

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
 
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
