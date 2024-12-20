<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['assignedUser', 'project'])
            ->latest()
            ->paginate(10);

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

            $task->status = 'in_progress';
            $task->assigned_to = Auth::id();
            $task->save();

            return redirect()->route('user.tasks.report')
                ->with('success', 'Task successfully taken!');
        } catch (\Exception $e) {
            Log::error('Take Task Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function report()
    {
        $tasks = Task::where('assigned_to', Auth::id())
            ->where('status', 'in_progress')
            ->with('project')
            ->get();
        
        return view('user.tasks.report', compact('tasks'));
    }
    
    public function submitTask(Request $request, Task $task)
    {
        try {
            // Validate request
            $request->validate([
                'submission_file' => 'required|file|mimes:zip,rar|max:10240', // Max 10MB
            ]);

            // Check if task belongs to user
            if ($task->assigned_to !== Auth::id()) {
                return back()->with('error', 'You are not authorized to submit this task.');
            }

            // Handle file upload
            if ($request->hasFile('submission_file')) {
                $file = $request->file('submission_file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('public/submissions', $fileName);  


                

                // Update task status
                $task->status = 'completed';
                $task->save();

                // Create submission
                Submission::create([
                    'task_id' => $task->id,
                    'user_id' => Auth::id(),
                    'file_path' => $filePath,
                    'status' => 'pending',
                    'submission_date' => now(),
                ]);

                return redirect()->route('user.submissions.index')
                    ->with('success', 'Task submitted successfully!');
            }

            return back()->with('error', 'No file was uploaded.');
        } catch (\Exception $e) {
            Log::error('Task Submission Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while submitting the task.');
        }
    }

    public function submissionIndex()
    {
        $submissions = Submission::with(['task.project'])
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($submission) {
                return [
                    'task_title' => $submission->task->title,
                    'project_name' => $submission->task->project->name ?? 'No Project',
                    'file_path' => $submission->file_path,
                    'status' => $submission->status
                ];
            });

        return view('user.submissions.index', compact('submissions'));
    }

    
}