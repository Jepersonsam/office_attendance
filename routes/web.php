<?php
use App\Http\Controllers\AdminAttendanceController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('attendances.index');
    }
    return view('landing');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::post('/attendances/check-in', [AttendanceController::class, 'checkIn'])->name('attendances.checkIn');
    Route::post('/attendances/check-out', [AttendanceController::class, 'checkOut'])->name('attendances.checkOut');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware('admin')->group(function () {
        Route::get('/admin/attendances/report', [AdminAttendanceController::class, 'report'])->name('admin.attendances.report');
        Route::get('/admin/attendances', [AdminAttendanceController::class, 'index'])->name('admin.attendances.index');
        Route::get('/admin/attendances/{attendance}/edit', [AdminAttendanceController::class, 'edit'])->name('admin.attendances.edit');
        Route::put('/admin/attendances/{attendance}', [AdminAttendanceController::class, 'update'])->name('admin.attendances.update');
        Route::delete('/admin/attendances/{attendance}', [AdminAttendanceController::class, 'destroy'])->name('admin.attendances.destroy');
        Route::post('/admin/attendances/absen', [AdminAttendanceController::class, 'absen'])->name('admin.attendances.absen');
    });
});

require __DIR__.'/auth.php';