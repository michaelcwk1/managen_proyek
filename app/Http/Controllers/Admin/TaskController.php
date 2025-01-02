<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('project')->paginate(10); // Memuat relasi project
        return view('admin.tasks.index', compact('tasks'));
    }


    public function create()
    {
        $projects = Project::all(); // Mendapatkan daftar project
        $users = User::where('role', 'user')->get(); // Mendapatkan daftar user
        return view('admin.tasks.create', compact('projects', 'users')); // Pastikan $projects ditambahkan
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
            'deadline' => 'required|date',
            'file' => 'nullable|file|mimes:jpeg,png,pdf|max:2048', // Validate file
        ]);

        $task = new Task();
        $task->title = $validated['title'];
        $task->project_id = $validated['project_id'];
        $task->assigned_to = $validated['assigned_to'];
        $task->deadline = $validated['deadline'];

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('task_files', 'public'); // Store the file
            $task->file_path = $filePath; // Store the file path in the database
        }

        $task->save();

        return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully');
    }



    public function edit(Task $task)
    {
        $projects = Project::where('status', 'active')->get();
        $users = User::where('role', 'user')->get();
        return view('admin.tasks.edit', compact('task', 'projects', 'users'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'deadline' => 'required|date',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240', // Validate file types
        ]);

        $task->update([
            'title' => $request->title,
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'deadline' => $request->deadline,
        ]);

        // Handle file upload if new file is uploaded
        if ($request->hasFile('file')) {
            // Delete old file if it exists
            if ($task->file_path && Storage::exists('public/' . $task->file_path)) {
                Storage::delete('public/' . $task->file_path);
            }

            // Store the new file
            $file = $request->file('file');
            $filePath = $file->store('task_files', 'public');
            $task->file_path = $filePath;
            $task->save();
        }

        // Send the file to the user via API or notification

        return redirect()->route('admin.tasks.index')->with('success', 'Task updated successfully.');
    }
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.tasks.index')->with('success', 'Task deleted successfully');
    }
}
