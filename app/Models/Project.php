<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Project extends Model
{
    use Notifiable, HasRoles;
    protected $fillable = ['name', 'client_name', 'description', 'status', 'start_date', 'end_date', 'created_by', 'total_tasks', 'completed_tasks'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
