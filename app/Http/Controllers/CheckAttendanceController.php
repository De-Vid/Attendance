<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckAttendanceController extends Controller
{
    public function index(Request $request)
    {
        // ========== ATTENDANCE DATA ==========
        $query = Attendance::with(['employee.user', 'attendanceType']);

        // Variable for specific employee
        $specificEmployee = null;
        $isEmployeeSpecific = $request->has('employee_id') && $request->employee_id != '';
        
        // Get selected date
        $selectedDate = $request->get('date', date('Y-m-d'));
        
        // Filter by employee (if specific)
        if ($isEmployeeSpecific) {
            $query->where('employee_id', $request->employee_id);
            $specificEmployee = Employee::with('user')->find($request->employee_id);
            view()->share('specificEmployee', $specificEmployee);
        } else {
            // For general view: filter by date only
            $query->where('date', $selectedDate);
        }

        // Search by name
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('employee.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $attendances = $query->orderBy('scanned_at', 'desc')->paginate(7);
        
        // ========== LEAVE DATA (APPROVED LEAVES) ==========
        // Only show leaves that are currently active
        $leavesOnLeave = collect(); // Empty collection by default
        
        // Only fetch leave data for general view (not when viewing specific employee's attendance)
        if (!$isEmployeeSpecific) {
            $leaveQuery = Leave::with(['user.employee'])
                ->where('status', 'approved')
                ->whereDate('start_date', '<=', $selectedDate)
                ->whereDate('end_date', '>=', $selectedDate);
            
            // Apply search filter to leaves as well
            if ($request->has('search') && $request->search != '') {
                $leaveQuery->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
            }
            
            $leavesOnLeave = $leaveQuery->get();
        }
        
        // For specific employee view, also show their leaves
        if ($isEmployeeSpecific && $specificEmployee) {
            $leaveQuery = Leave::with('user')
                ->where('user_id', $specificEmployee->user_id)
                ->where('status', 'approved')
                ->orderBy('start_date', 'desc');
            
            $leavesOnLeave = $leaveQuery->get();
        }
        
        // Pass both collections to view
        return view('check_attendances.index', compact('attendances', 'leavesOnLeave', 'specificEmployee', 'isEmployeeSpecific', 'selectedDate'));
    }
}