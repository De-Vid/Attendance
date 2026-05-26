<?php

namespace App\Http\Controllers;
use App\Models\AttendanceType;
use Illuminate\Http\Request;

class AttendanceTypeController extends Controller
{
        public function index()
    {
        $settings_type = AttendanceType::all();
        return view('attendance_types.index', compact('settings_type'));
    }

    // Show create page
    public function create()
    {
        return view('attendance_types.create');
    }

    // Store data
public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'label' => 'required',
    ]);

    AttendanceType::create([
        'name' => $request->name,
        'label' => $request->label,
    ]);

    return redirect()->route('attendance_types.index')
        ->with('success', 'Inserted Successfully');
}

    // Edit page
    public function edit($id)
    {
        $settings_type = AttendanceType::findOrFail($id);

        return view('attendance_types.edit', compact('settings_type'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'label' => 'required',
        ]);

        $settings_type = AttendanceType::findOrFail($id);

        $settings_type->update([
            'name' => $request->name,
            'label' => $request->label,
        ]);

        return redirect()->route('attendance_types.index')
                         ->with('success', 'Updated Successfully');
    }

    // Delete
    public function destroy($id)
    {
        $settings_type = AttendanceType::findOrFail($id);

        $settings_type->delete();

        return redirect()->route('attendance_types.index')
                         ->with('success', 'Deleted Successfully');
    }
}
