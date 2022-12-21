<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Home');
    }

    public function index_project()
    {
        $projects = Project::public()->get();
        return $projects;
    }

    public function show_project(Project $project)
    {

    }

    public function index_job()
    {
        $job = Job::public()->get();
        return $job;
    }

    public function show_job(Job $job)
    {

    }

    public function index_employees()
    {

    }

}
