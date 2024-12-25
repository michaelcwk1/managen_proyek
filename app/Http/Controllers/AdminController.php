<?php
namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Submission;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Fetch all tasks
        $tasks = Task::all();
        $submissions = Submission::all();  

        return view('admin.dashboard', compact('tasks', 'submissions'));
    }
}
