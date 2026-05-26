<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * បង្ហាញទំព័រ Login
     */
    public function showLoginForm()
    {
        // បើ login រួចហើយ កុំឱ្យចូលទំព័រ login ម្តងទៀត
        if (Auth::check()) {
            return redirect()->route(Auth::user()->getDashboardRoute());
        }

        return view('auth.login');
    }

    /**
     * ដំណើរការ Login
     */
    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // ព្យាយាម Login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect តាម role
            return redirect()->route($user->getDashboardRoute())
                ->with('success', 'ស្វាគមន៍មក ' . $user->name . '!');
        }

        // Login បរាជ័យ
        return back()->withErrors([
            'email' => 'អ៊ីមែល ឬ លេខសំងាត់មិនត្រឹមត្រូវ។',
        ])->onlyInput('email');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'អ្នកបានចេញពីប្រព័ន្ធដោយជោគជ័យ។');
    }
}