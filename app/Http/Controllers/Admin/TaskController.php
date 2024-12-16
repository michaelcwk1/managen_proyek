<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['project', 'assignee'])->latest()->paginate(10);
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
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'deadline' => 'nullable|date',
        ]);

        Task::create($validated);

        return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        $projects = Project::where('status', 'active')->get();
        $users = User::where('role', 'user')->get();
        return view('admin.tasks.edit', compact('task', 'projects', 'users'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input jika diperlukan
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'deadline' => 'required|date',
        ]);

        // Temukan task berdasarkan ID
        $task = Task::findOrFail($id);

        // Perbarui data task
        $task->update([
            'title' => $request->title,
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'deadline' => $request->deadline,
        ]);

        // Redirect ke halaman index tasks setelah update
        return redirect()->route('admin.tasks.index')->with('success', 'Task updated successfully!');
    }


    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.tasks.index')->with('success', 'Task deleted successfully');
    }
}
