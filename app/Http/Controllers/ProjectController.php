<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $projects = Project::orderByDesc('weight')->paginate(20);
        return Inertia::render('Admin/Projects/Index', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return Inertia::render("Admin/Projects/Form", [
            'form_type' => 'create'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        ddd($request);
        $attr = $request->validate([
            'title' => 'required',
            'desc' => 'nullable|string',
            'html_block' => 'nullable|string',
            'is_public' => 'required|boolean',
        ]);
        Project::create([
            'title' => $attr['title'],
            'slug' => Str::slug($attr['title']),
            'content' => $attr['desc'],
            'html_block' => $attr['html_block'],
            'is_public' => $attr['is_public'] ?? false
        ]);

        return \redirect('/admin/projects');
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(Project $project)
    {
        return Inertia::render("Admin/Projects/Form", [
            'form_type' => 'edit',
            'project' => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, Project $project)
    {
        $attr = $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'desc' => 'nullable|string',
            'html_block' => 'nullable|string',
            'is_public' => 'required|boolean',
        ]);

        $project->update([
            'title' => $attr['title'],
            'slug' => Str::slug($attr['title']),
            'content' => $attr['desc'],
            'html_block' => $attr['html_block'],
            'is_public' => $attr['is_public'] ?? false
        ]);

        return \redirect('admin/projects');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return Redirect::route('projects.index');
    }
}
