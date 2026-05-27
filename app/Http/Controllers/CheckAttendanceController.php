<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class CheckAttendanceController extends Controller
{
    public function index(Request $request)
    {
        // ទាញយកទិន្នន័យ Attendance ភ្ជាប់ជាមួយ Employee និង User
        $query = Attendance::with(['employee.user', 'attendanceType']);

        // ១. ករណីចុចប៊ូតុងមើលវត្តមានទាំងអស់របស់បុគ្គលិកជាក់លាក់ណាម្នាក់ (Employee ID)
        if ($request->has('employee_id') && $request->employee_id != '') {
            $query->where('employee_id', $request->employee_id);
            
            // ទាញយកទិន្នន័យបុគ្គលិកនោះដើម្បីយកទៅបង្ហាញឈ្មោះនៅលើ Alert នៃទំព័រ Blade
            $specificEmployee = Employee::with('user')->find($request->employee_id);
            view()->share('specificEmployee', $specificEmployee);
        } else {
            // ២. ករណីមើលទូទៅ៖ តម្រូវឱ្យ Filter តាមថ្ងៃខែ (Default យកថ្ងៃនេះ)
            $selectedDate = $request->get('date', date('Y-m-d'));
            $query->where('date', $selectedDate);
        }

        // មុខងារស្វែងរកតាមឈ្មោះ (Search by Name)
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('employee.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // រៀបចំលំដាប់ពីថ្មីទៅចាស់ និងធ្វើ Pagination 15 កំណត់ត្រា
        $attendances = $query->orderBy('scanned_at', 'desc')->paginate(7);

        return view('check_attendances.index', compact('attendances'));
    }
}