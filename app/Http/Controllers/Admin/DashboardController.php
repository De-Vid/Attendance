<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'   => User::count(),
            'total_admin'   => User::where('role', User::ROLE_ADMIN)->count(),
            'total_leader'  => User::where('role', User::ROLE_LEADER)->count(),
            'total_staff'   => User::where('role', User::ROLE_STAFF)->count(),
        ];

        $users = User::latest()->paginate(10);

        return view('admin.dashboard', compact('stats', 'users'));
    }
}
