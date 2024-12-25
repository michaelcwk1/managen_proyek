<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\Submission;

class UserController extends Controller
{
    public function dashboard()
    {
        $tasks = Task::all();
        $submissions = Submission::all();  

        return view('user.dashboard', compact('tasks', 'submissions'));
    }
}
