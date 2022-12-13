<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $employees = Employee::orderByDesc('weight')->paginate(20);
        return Inertia::render('Admin/Employees/Index', ['employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return Inertia::render('Admin/Employees/Form', [
            'form_type' => 'create'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'job_position' => 'nullable|string',
            'content' => 'nullable|string',
            'image'=> 'nullable|string',
            'is_public' => 'nullable|boolean',
        ]);

        Employee::create([
            'name' => $request->name,
            'job_position' => $request->job_position,
            'content' => $request->content,
            'image'  => $request->image,
            'is_public' => $request->is_public ?? false
        ]);

        return Redirect::route('employees.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(Employee $employee)
    {
        return Inertia::render('Admin/Employees/Form', [
            'form_type' => 'edit',
            'employee' => $employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string',
            'job_position' => 'nullable|string',
            'content' => 'nullable|string',
            'image'=> 'nullable|string',
            'is_public' => 'nullable|boolean',
        ]);

        $employee->update([
            'name' => $request->name,
            'job_position' => $request->job_position,
            'content' => $request->content,
            'image'  => $request->image,
            'is_public' => $request->is_public ?? false
        ]);

        return Redirect::route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return Redirect::route('employees.index');
    }
}
