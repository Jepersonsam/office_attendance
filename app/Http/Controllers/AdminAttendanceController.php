<?php
namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('user')->latest();

        if ($request->filled('user_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('check_in', $request->date);
        }

        $attendances = $query->paginate(10);
        $users = User::all();

        $chartData = [
            'Tepat Waktu' => $query->clone()->where('attendance_status', 'Tepat Waktu')->count() ?? 0,
            'Terlambat' => $query->clone()->where('attendance_status', 'Terlambat')->count() ?? 0,
        ];

        return view('admin.attendances.index', compact('attendances', 'users', 'chartData'));
    }

    public function edit(Attendance $attendance)
    {
        return view('admin.attendances.edit', compact('attendance'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'nullable|date|after:check_in',
            'status' => 'required|in:present,absent',
            'attendance_status' => 'nullable|in:Tepat Waktu,Terlambat',
            'notes' => 'nullable|string|max:500',
        ]);

        $attendance->update([
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'status' => $request->status,
            'attendance_status' => $request->attendance_status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.attendances.index')->with('success', 'Data absensi berhasil diperbarui!');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('admin.attendances.index')->with('success', 'Data absensi berhasil dihapus!');
    }

    public function absen(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'date' => 'required|date',
        'type' => 'required|in:check_in,check_out',
    ]);

    $userId = $request->user_id;
    $date = Carbon::parse($request->date);
    $type = $request->type;

    $existingAttendance = Attendance::where('user_id', $userId)
        ->whereDate('check_in', $date)
        ->first();

    if ($type === 'check_in') {
        if ($existingAttendance) {
            return redirect()->route('admin.attendances.index')
                ->with('error', 'Karyawan sudah check-in pada tanggal ini.');
        }

        $checkInTime = Carbon::now(); // Gunakan waktu saat ini untuk check-in
        Attendance::create([
            'user_id' => $userId,
            'check_in' => $checkInTime,
            'status' => 'present',
            'attendance_status' => $checkInTime->hour < 9 ? 'Tepat Waktu' : 'Terlambat',
            'notes' => 'Check-in oleh admin',
        ]);
    } elseif ($type === 'check_out') {
        if (!$existingAttendance) {
            return redirect()->route('admin.attendances.index')
                ->with('error', 'Karyawan belum check-in pada tanggal ini.');
        }

        if ($existingAttendance->check_out) {
            return redirect()->route('admin.attendances.index')
                ->with('error', 'Karyawan sudah check-out pada tanggal ini.');
        }

        $checkOutTime = Carbon::now(); // Gunakan waktu saat ini untuk check-out
        $existingAttendance->update([
            'check_out' => $checkOutTime,
        ]);
    }

    return redirect()->route('admin.attendances.index')
        ->with('success', 'Absensi karyawan berhasil dicatat!');
}
}