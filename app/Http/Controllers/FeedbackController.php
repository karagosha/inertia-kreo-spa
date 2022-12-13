<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $feedback = Feedback::orderByDesc('weight')->paginate(20);
        return Inertia::render('Admin/Feedback/Index', ['feedback' => $feedback]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return Inertia::render('Admin/Feedback/Form', ['form_type' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        Feedback::create([
            'client' => $request->client,
            'text' => $request->text,
            'is_public' => $request->is_public,
        ]);
        return Redirect::route('feedback.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(Feedback $feedback)
    {
        return Inertia::render('Admin/Feedback/Form', ['form_type' => 'edit', 'feedback' => $feedback]);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, Feedback $feedback)
    {
        $feedback->update([
            'client' => $request->client,
            'text' => $request->text,
            'is_public' => $request->is_public,
        ]);
        return Redirect::route('feedback.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return Redirect::route('feedback.index');
    }
}
