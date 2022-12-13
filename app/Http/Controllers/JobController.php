<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $job = Job::orderByDesc('weight')->paginate(20);
        return Inertia::render('Admin/Job/Index', ['job' => $job]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return Inertia::render('Admin/Job/Form', ['form_type' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $attr = $request->validate([
            'title'=> 'required',
            'description'=> 'nullable|string',
            'salary'=>'nullable|string',
            'hh_link' =>'nullable|string',
            'is_public' => 'required|boolean',
        ]);
        Job::create([
            'title' => $attr['title'],
            'description' => $attr['description'],
            'salary' => $attr['salary'],
            'hh_link' => $attr['hh_link'],
            'is_public' => $attr['is_public'] ?? false
        ]);

        return Redirect::route('job.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(Job $job)
    {
        return Inertia::render('Admin/Job/Form', ['form_type' => 'edit', 'job' => $job]);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, Job $job)
    {
        $attr = $request->validate([
            'title'=> 'required',
            'description'=> 'nullable|string',
            'salary'=>'nullable|string',
            'hh_link' =>'nullable|string',
            'is_public' => 'required|boolean',
        ]);
        $job->update([
            'title' => $attr['title'],
            'description' => $attr['description'],
            'salary' => $attr['salary'],
            'hh_link' => $attr['hh_link'],
            'is_public' => $attr['is_public'] ?? false
        ]);

        return Redirect::route('job.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Job $job)
    {
        $job->delete();
        return Redirect::route('job.index');
    }
}
