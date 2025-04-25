<?php
namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::where('user_id', Auth::id())->latest()->paginate(10);
        return view('attendances.index', compact('attendances'));
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'notes' => 'nullable|string|max:255',
        ]);

        $today = Carbon::today();
        $existing = Attendance::where('user_id', Auth::id())
            ->whereDate('check_in', $today)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Anda sudah check-in hari ini!');
        }

        $checkInTime = Carbon::now();
        $attendanceStatus = $checkInTime->hour >= 8 && $checkInTime->minute > 0 ? 'Terlambat' : 'Tepat Waktu';

        Attendance::create([
            'user_id' => Auth::id(),
            'check_in' => $checkInTime,
            'status' => 'present',
            'attendance_status' => $attendanceStatus,
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Check-in berhasil!');
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'notes' => 'nullable|string|max:255',
        ]);

        $attendance = Attendance::where('user_id', Auth::id())
            ->whereDate('check_in', Carbon::today())
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'Anda belum check-in hari ini!');
        }

        if ($attendance->check_out) {
            return redirect()->back()->with('error', 'Anda sudah check-out hari ini!');
        }

        $attendance->update([
            'check_out' => Carbon::now(),
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Check-out berhasil!');
    }
}