<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        // Change .all() to .paginate() to enable pagination features
        $users = User::paginate(8);
        return view('users.index', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        // This will now work perfectly without errors:
        return redirect()->route('users.index')->with('success', 'Role updated successfully');
    }
}