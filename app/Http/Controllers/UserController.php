<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $users = User::with('roles')->paginate(20);
        foreach ($users as $user) {
            $user->is_admin = $user->hasRole('admin');
        }
        $roles = Role::all();
        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return Inertia::render('Admin/Users/Form', [
            'gen_pass' => substr(md5(mt_rand()), 0, 10),
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (!empty($request->role_slug)) {
            $role = Role::where('slug', $request->role_slug)->first();
            if (!empty($role)) {
                $user->roles()->sync($role->id);
            }
        }
        event(new Registered($user));
        return Redirect::route('users.index');
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, User $user)
    {
        if (empty($request->role_slug)) {
            $user->roles()->detach();
        } else {
            $role = Role::where('slug', $request->role_slug)->first();
            if(!empty($role)){
                $user->roles()->sync($role->id);
            }

        }
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(User $user)
    {
        $user->delete();
        return Redirect::route('users.index');
    }
}
