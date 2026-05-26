<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $staff = User::where('role', User::ROLE_STAFF)->latest()->get();

        return view('leader.dashboard', compact('staff'));
    }
}
