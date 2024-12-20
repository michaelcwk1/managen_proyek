<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'client_name', 'description', 'status', 'start_date', 'end_date','total_tasks', 'completed_tasks',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Update total tasks
    public function updateTaskCounts()
    {
        $this->total_tasks = $this->tasks()->count();
        $this->completed_tasks = $this->tasks()->where('status', 'completed')->count();
        $this->save();
    }
}
