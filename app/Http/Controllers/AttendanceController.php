<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Position;
use App\Models\AttendanceType;
use App\Models\AttendanceSetting;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // 1. Show Employees
public function index(Request $request)
{
    $query = Employee::with('user')->latest();
    if ($request->filled('search')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }
    $employees = $query->paginate(7);
    $employees->appends($request->all());
    return view('attendance.index', compact('employees'));
}

public function createEmployee()
{
    $positions = Position::all();

    return view('attendance.create', compact('positions'));
}

    // 2. Create Employee + User + QR Code
public function storeEmployee(Request $request)
{
    $request->validate([
        'staff_id'    => 'required|unique:employees,staff_id',
        'name'        => 'required',
        'salary'      => 'required|numeric|min:0',
        'email'       => 'required|email|unique:users,email',
        'phone'       => 'required',
        'position_id' => 'required',
        'password'    => 'required|min:6|confirmed',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $imageName = null;

    if ($request->hasFile('image')) {

        $imageName = time() . '.' . $request->image->extension();

        $request->image->move(
            public_path('uploads/employees'),
            $imageName
        );
    }

    // Create User
    $user = User::create([
        'name'        => $request->name,
        'email'       => $request->email,
        'password'    => Hash::make($request->password),
        'role'        => 'staff',
        'phone'       => $request->phone,
        'image'       => $imageName,
        'position_id' => $request->position_id,
        'birth_date'  => $request->birth_date,
    ]);

    // Create Employee
    Employee::create([
        'user_id'   => $user->id,
        'staff_id'  => $request->staff_id,
        'scan_code' => $request->staff_id . '_' . bin2hex(random_bytes(4)),
        'salary'    => $request->salary,
    ]);

    return redirect()
        ->route('employees.index')
        ->with('success', 'បុគ្គលិកត្រូវបានបង្កើតដោយជោគជ័យ!');
}

    // 3. Scanner View
public function scannerView()
{
    return view('attendance.scanner');
}

public function scan(Request $request)
{
    $scanCode = $request->input('scan_code');

    $employee = Employee::with('user')
        ->where('scan_code', $scanCode)
        ->first();

    if (!$employee) {
        return response()->json([
            'status'  => 'error',
            'message' => 'រកមិនឃើញបុគ្គលិក!'
        ], 404);
    }

    // ✅ ទាញម៉ោងកំណត់ពី database
    $settings = AttendanceSetting::first();

    if (!$settings) {
        return response()->json([
            'status'  => 'error',
            'message' => 'មិនមានការកំណត់ម៉ោងក្នុង database!'
        ], 500);
    }

    // ✅ ទាញ attendance_types ទាំងអស់ (id => name)
    $types = AttendanceType::pluck('id', 'name');

    $now   = Carbon::now('Asia/Phnom_Penh');
    $today = $now->toDateString();

    // ✅ substr ទាញតែ HH:MM:SS
    $morningCheckIn    = Carbon::parse($today . ' ' . substr($settings->morning_check_in,    0, 8), 'Asia/Phnom_Penh');
    $morningCheckOut   = Carbon::parse($today . ' ' . substr($settings->morning_check_out,   0, 8), 'Asia/Phnom_Penh');
    $afternoonCheckIn  = Carbon::parse($today . ' ' . substr($settings->afternoon_check_in,  0, 8), 'Asia/Phnom_Penh');
    $afternoonCheckOut = Carbon::parse($today . ' ' . substr($settings->afternoon_check_out, 0, 8), 'Asia/Phnom_Penh');

    // ✅ ទាញ attendance ថ្ងៃនេះ តាម type name
    $todayAttendances = Attendance::where('employee_id', $employee->id)
        ->where('date', $today)
        ->join('attendance_types', 'attendances.attendance_type_id', '=', 'attendance_types.id')
        ->pluck('attendance_types.name')
        ->toArray();

    // Guard: បានស្កេនគ្រប់ 4 ប្រភេទ
    $allTypes = [
        'morning_check_in',
        'morning_check_out',
        'afternoon_check_in',
        'afternoon_check_out'
    ];

    if (count(array_intersect($allTypes, $todayAttendances)) >= 4) {
        return response()->json([
            'status'  => 'error',
            'message' => 'បានស្កេនគ្រប់ប្រភេទរួចហើយសម្រាប់ថ្ងៃនេះ!'
        ], 400);
    }

    $type       = null;
    $statusText = null;

    // ─── MORNING CHECK-IN ───────────────────────────────────────────
    if (
        $now->lt($morningCheckOut) &&
        !in_array('morning_check_in', $todayAttendances)
    ) {
        $type       = 'morning_check_in';
        $statusText = $now->lt($morningCheckIn)
            ? 'មកទាន់ពេល'
            : '' . $now->format('H:i');
    }

    // ─── MORNING CHECK-OUT ──────────────────────────────────────────
    elseif (
        $now->gte($morningCheckOut) &&
        $now->lt($afternoonCheckIn) &&
        in_array('morning_check_in', $todayAttendances) &&
        !in_array('morning_check_out', $todayAttendances)
    ) {
        $type       = 'morning_check_out';
        $statusText = 'ចេញទាន់ពេល';
    }

    // ─── AFTERNOON CHECK-IN ─────────────────────────────────────────
    elseif (
        $now->gte($afternoonCheckIn) &&
        $now->lt($afternoonCheckOut) &&
        !in_array('afternoon_check_in', $todayAttendances)
    ) {
        $type       = 'afternoon_check_in';
        $statusText = $now->lte($afternoonCheckIn)
            ? 'មកទាន់ពេល'
            : 'មកយឺត ' . $now->format('H:i');
    }

    // ─── AFTERNOON CHECK-OUT ────────────────────────────────────────
    elseif (
        $now->gte($afternoonCheckOut) &&
        in_array('afternoon_check_in', $todayAttendances) &&
        !in_array('afternoon_check_out', $todayAttendances)
    ) {
        $type       = 'afternoon_check_out';
        $statusText = 'ចេញទាន់ពេល';
    }

    // ─── មិនទាន់ដល់ម៉ោង ឬ បានស្កេនរួចហើយ ──────────────────────────
    else {
        return response()->json([
            'status'  => 'error',
            'message' => 'បានស្កេនរួចហើយ ឬ មិនទាន់ដល់ម៉ោង!'
        ], 400);
    }

    // ─── Double-check ទប់ duplicate ──────────────────────────────────
    $alreadyExists = Attendance::where('employee_id', $employee->id)
        ->where('date', $today)
        ->where('attendance_type_id', $types[$type])
        ->exists();

    if ($alreadyExists) {
        return response()->json([
            'status'  => 'error',
            'message' => 'បានស្កេន ' . $type . ' រួចហើយ!'
        ], 400);
    }

    // ─── រក្សាទុក ─────────────────────────────────────────────────────
    Attendance::create([
        'employee_id'        => $employee->id,
        'attendance_type_id' => $types[$type], // ✅ រក id តាម name
        'date'               => $today,
        'scanned_at'         => $now,
        'status'             => $statusText,
    ]);

    return response()->json([
        'status'            => 'success',
        'message'           => 'ស្កេនជោគជ័យ',
        'employee_name'     => $employee->user->name,
        'type'              => $type,
        'attendance_status' => $statusText,
        'time'              => $now->format('H:i:s')
    ]);
}

public function destroy($id)
{
    $employee = Employee::findOrFail($id);
    if ($employee->user) {
        $employee->user->delete();
    }
    $employee->delete();
        return redirect()->route('employees.index')->with('success', 'លុបទិន្នន័យដោយជោគជ័យ!');
    }
    public function printCard($id)
    {
        // ទាញយកទិន្នន័យបុគ្គលិកជាមួយ User រួមគ្នា
        $employee = Employee::with('user')->findOrFail($id);
        
        // បញ្ជូនទៅកាន់ view ដែលយើងនឹងបង្កើតនៅជំហានបន្ទាប់
        return view('print.index', compact('employee'));
    }
}