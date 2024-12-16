<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Add this line

class TaskController extends Controller
{


    public function index()
    {
        $tasks = Task::latest()->paginate(10);

        // Eager load the assigned user (though this doesn't seem to be used)
        foreach ($tasks as $task) {
            $assignedUser = $task->assignedUser;
        }

        return view('user.tasks.index', compact('tasks'));
    }

    public function takeTask(Request $request, Task $task)
    {
        try {
            if ($task->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Task cannot be taken.'
                ], 400);
            }
    
            $task->status = 'in-progress';
            $task->assigned_to = Auth::id();
            $task->save();
    
            // Redirect with success message
            return redirect()->route('user.tasks.report')->with('success', 'Task successfully taken!');
        } catch (\Exception $e) {
            Log::error('Take Task Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    
    public function show($taskId)
    {
        $task = Task::with('project')->findOrFail($taskId);
        return response()->json([
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'project' => $task->project->name ?? 'No Project',
            'deadline' => $task->deadline,
            'status' => $task->status
        ]);
    }

    public function report()
    {
        $tasks = Task::where('assigned_to', Auth::id())
            ->where('status', 'in-progress')
            ->with('project')
            ->get();

        return view('user.tasks.report', compact('tasks'));
    }
    public function takeAndReport(Request $request)
    {
        $taskId = $request->input('task_id');

        try {
            $task = Task::findOrFail($taskId);

            if ($task->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Task cannot be taken.'
                ], 400);
            }

            $task->status = 'in-progress';
            $task->assigned_to = Auth::id();
            $task->save();

            // Redirect to report page
            return response()->json([
                'success' => true,
                'redirectUrl' => route('user.tasks.report')
            ]);
        } catch (\Exception $e) {
            Log::error('Take Task Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}
