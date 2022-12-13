<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Feedback;
use App\Models\Job;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    private function define_object_type($type)
    {
        switch ($type) {
            case 'project':
                $item = Project::query();
                break;
            case 'feedback':
                $item = Feedback::query();
                break;
            case 'employee':
                $item = Employee::query();
                break;
            case 'job':
                $item = Job::query();
                break;
            default:
                abort(404);
        }

        return $item;
    }

    function update_weight(Request $request)
    {
        $object = $this->define_object_type($request->type);

        $item = $object->find($request->id);
        if (empty($item)) {
            abort(404);
        }
        $item->update([
            'weight' => $request->weight
        ]);

        return redirect()->back();
    }
}
