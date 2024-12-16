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
            'description' => 'required',
            'client_name' => 'required|string|max:255',
            'deadline' => 'required|date',
            'status' => 'required|in:active,completed,on_hold'
        ]);


        Project::create($validated);
        
        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,completed,on_hold',
        ]);
    
        $project->update([
            'name' => $request->name,
            'client_name' => $request->client_name,
            'description' => $request->description,
            'status' => $request->status,
        ]);
    
        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully!');
    }
    
    

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully');
    }
}