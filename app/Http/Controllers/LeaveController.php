<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    // ================================================================
    //  STAFF — មើល + ស្នើរសុំច្បាប់
    // ================================================================

    /**
     * Staff: មើលបញ្ជីច្បាប់ខ្លួនឯង
     */
    public function staffIndex()
    {
        $leaves = Leave::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total'    => Leave::where('user_id', Auth::id())->count(),
            'pending'  => Leave::where('user_id', Auth::id())->where('status', 'pending')->count(),
            'approved' => Leave::where('user_id', Auth::id())->where('status', 'approved')->count(),
            'rejected' => Leave::where('user_id', Auth::id())->where('status', 'rejected')->count(),
        ];

        return view('staff.leaves.index', compact('leaves', 'stats'));
    }

    /**
     * Staff: form ស្នើរសុំច្បាប់
     */
    public function staffCreate()
    {
        return view('staff.leaves.create');
    }

    /**
     * Staff: រក្សាទុកការស្នើរសុំ
     */
    public function staffStore(Request $request)
    {
        $validated = $request->validate([
            'type'       => 'required|in:annual,sick,personal,unpaid',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'reason'     => 'required|string|min:10|max:500',
        ], [
            'type.required'            => 'សូមជ្រើសប្រភេទច្បាប់',
            'start_date.required'      => 'សូមបញ្ចូលកាលបរិច្ឆេទចាប់ផ្តើម',
            'start_date.after_or_equal'=> 'កាលបរិច្ឆេទចាប់ផ្តើមមិនអាចជាអតីតកាល',
            'end_date.required'        => 'សូមបញ្ចូលកាលបរិច្ឆេទបញ្ចប់',
            'end_date.after_or_equal'  => 'កាលបរិច្ឆេទបញ្ចប់ត្រូវតែក្រោយឬស្មើកាលបរិច្ឆេទចាប់ផ្តើម',
            'reason.required'          => 'សូមបញ្ចូលមូលហេតុ',
            'reason.min'               => 'មូលហេតុត្រូវមានយ៉ាងតិច ១០ អក្សរ',
        ]);

        $start     = \Carbon\Carbon::parse($validated['start_date']);
        $end       = \Carbon\Carbon::parse($validated['end_date']);
        $totalDays = $start->diffInWeekdays($end) + 1;

        Leave::create([
            'user_id'    => Auth::id(),
            'type'       => $validated['type'],
            'start_date' => $validated['start_date'],
            'end_date'   => $validated['end_date'],
            'total_days' => $totalDays,
            'reason'     => $validated['reason'],
            'status'     => 'pending',
        ]);

        return redirect()->route('staff.dashboard')
            ->with('success', 'ការស្នើរសុំច្បាប់ត្រូវបានបញ្ជូនដោយជោគជ័យ!');
    }

    /**
     * Staff: លុបការស្នើរសុំ (pending ប៉ុណ្ណោះ)
     */
    public function staffDestroy(Leave $leave)
    {
        if ($leave->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$leave->isPending()) {
            return back()->with('error', 'មិនអាចលុបការស្នើរសុំដែលត្រូវបានដំណើរការហើយ');
        }

        $leave->delete();

        return redirect()->route('staff.dashboard')
            ->with('success', 'ការស្នើរសុំច្បាប់ត្រូវបានលុបដោយជោគជ័យ');
    }

    // ================================================================
    //  LEADER — មើល + Approve/Reject ច្បាប់ Staff
    // ================================================================

    /**
     * Leader: មើលច្បាប់ខ្លួនឯង + ច្បាប់ staff ទាំងអស់
     */
    public function leaderIndex(Request $request)
    {
        // ច្បាប់ខ្លួនឯង
        $myLeaves = Leave::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // filter status
        $statusFilter = $request->get('status', 'all');
        $staffLeavesQuery = Leave::with('user')
            ->whereHas('user', fn($q) => $q->where('role', 'staff'));

        if ($statusFilter !== 'all') {
            $staffLeavesQuery->where('status', $statusFilter);
        }

        $staffLeaves = $staffLeavesQuery->orderBy('created_at', 'desc')->paginate(10);

        $stats = [
            'my_total'        => $myLeaves->count(),
            'my_approved'     => $myLeaves->where('status', 'approved')->count(),
            'staff_pending'   => Leave::whereHas('user', fn($q) => $q->where('role', 'staff'))->where('status', 'pending')->count(),
            'staff_approved'  => Leave::whereHas('user', fn($q) => $q->where('role', 'staff'))->where('status', 'approved')->count(),
            'staff_rejected'  => Leave::whereHas('user', fn($q) => $q->where('role', 'staff'))->where('status', 'rejected')->count(),
        ];

        return view('leader.leaves.index', compact('myLeaves', 'staffLeaves', 'stats', 'statusFilter'));
    }

    /**
     * Leader: មើលលម្អិតការស្នើរសុំ
     */
    public function leaderShow(Leave $leave)
    {
        $leave->load('user', 'approver');
        return view('leader.leaves.show', compact('leave'));
    }

    /**
     * Leader: Approve ច្បាប់
     */
    public function leaderApprove(Request $request, Leave $leave)
    {
        if (!$leave->isPending()) {
            return back()->with('error', 'ច្បាប់នេះត្រូវបានដំណើរការរួចហើយ');
        }

        $request->validate([
            'leader_note' => 'nullable|string|max:300',
        ]);

        $leave->update([
            'status'      => 'approved',
            'approved_by' => Auth::id(),
            'leader_note' => $request->leader_note,
            'approved_at' => now(),
        ]);

        return back()->with('success', 'ច្បាប់ត្រូវបាន Approve ដោយជោគជ័យ!');
    }

    /**
     * Leader: Reject ច្បាប់
     */
    public function leaderReject(Request $request, Leave $leave)
    {
        if (!$leave->isPending()) {
            return back()->with('error', 'ច្បាប់នេះត្រូវបានដំណើរការរួចហើយ');
        }

        $request->validate([
            'leader_note' => 'required|string|max:300',
        ], [
            'leader_note.required' => 'សូមបញ្ចូលមូលហេតុនៃការបដិសេធ',
        ]);

        $leave->update([
            'status'      => 'rejected',
            'approved_by' => Auth::id(),
            'leader_note' => $request->leader_note,
            'approved_at' => now(),
        ]);

        return back()->with('success', 'ច្បាប់ត្រូវបាន Reject រួចហើយ');
    }
}
