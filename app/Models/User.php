<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasRoles; use HasFactory;

    protected $fillable = ['name', 'email', 'password','role'];  


    public function projects()
    {
        return $this->hasMany(Project::class, 'created_by');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }
    

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function reviewedSubmissions()
    {
        return $this->hasMany(Submission::class, 'reviewed_by');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
