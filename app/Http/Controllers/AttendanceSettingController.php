<?php

namespace App\Http\Controllers;
use App\Models\AttendanceSetting;
use Illuminate\Http\Request;

class AttendanceSettingController extends Controller
{
public function index()
{
    // Change .all() to .paginate() to enable pagination features
    $settings = AttendanceSetting::paginate(10);
    return view('attendance_settings.index', compact('settings'));
}

    // Show create page
    public function create()
    {
        return view('attendance_settings.create');
    }

    // Store data
public function store(Request $request)
{
    $request->validate([
        'morning_check_in' => 'required',
        'morning_check_out' => 'required',
        'afternoon_check_in' => 'required',
        'afternoon_check_out' => 'required',
    ]);

    AttendanceSetting::create([
        'morning_check_in' => $request->morning_check_in,
        'morning_check_out' => $request->morning_check_out,
        'afternoon_check_in' => $request->afternoon_check_in,
        'afternoon_check_out' => $request->afternoon_check_out,
    ]);

    return redirect()->route('attendance-settings.index')
        ->with('success', 'Inserted Successfully');
}

    // Edit page
    public function edit($id)
    {
        $setting = AttendanceSetting::findOrFail($id);

        return view('attendance_settings.edit', compact('setting'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'morning_check_in' => 'required',
            'morning_check_out' => 'required',
            'afternoon_check_in' => 'required',
            'afternoon_check_out' => 'required',
        ]);

        $setting = AttendanceSetting::findOrFail($id);

        $setting->update([
            'morning_check_in' => $request->morning_check_in,
            'morning_check_out' => $request->morning_check_out,
            'afternoon_check_in' => $request->afternoon_check_in,
            'afternoon_check_out' => $request->afternoon_check_out,
        ]);

        return redirect()->route('attendance-settings.index')
                         ->with('success', 'Updated Successfully');
    }

    // Delete
    public function destroy($id)
    {
        $setting = AttendanceSetting::findOrFail($id);

        $setting->delete();

        return redirect()->route('attendance-settings.index')
                         ->with('success', 'Deleted Successfully');
    }
}