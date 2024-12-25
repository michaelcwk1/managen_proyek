<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;
class Submission extends Model
{
    use Notifiable, HasRoles;
    protected $fillable = ['task_id', 'user_id', 'file_path', 'notes', 'status', 'reviewed_by', 'submission_date'];

    protected $dates = [
        'submission_date'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
    public function scopeComplete($query)
    {
        return $query->where('status', 'complete');
    }
}
