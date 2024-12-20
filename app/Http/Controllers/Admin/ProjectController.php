<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|in:active,completed,on_hold',
        ]);

        Project::create($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }


    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:not_started,ongoing,completed,active',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'total_tasks' => 'nullable|integer|min:0',
            'completed_tasks' => 'nullable|integer|min:0|max:' . $request->input('total_tasks', 0),
        ]);

        $project->update($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully');
    }
}
