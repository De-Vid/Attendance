<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
public function index(Request $request)
{
    $query = User::query();
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }
    $users = $query->paginate(10);
    $users->appends($request->all());
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