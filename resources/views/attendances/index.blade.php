@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <!-- Header Card with Subtle Animation -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8 transform transition hover:shadow-xl">
            <div class="h-2 bg-gradient-to-r from-blue-500 via-purple-500 to-indigo-500"></div>
            <div class="p-6 md:p-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Absensi Saya
                </h1>
                <p class="text-gray-500">Kelola kehadiran dan lihat riwayat absensi Anda secara lengkap</p>
            </div>
        </div>

        <!-- Today's Status Card (conditionally shown) -->
        @if(isset($todayAttendance) && $todayAttendance && !$todayAttendance->check_out)
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 md:p-6 rounded-lg shadow-md mb-6 flex items-center">
            <div class="mr-4 bg-blue-100 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-blue-800 text-lg">Sedang Bekerja</h3>
                <p class="text-blue-600">Anda check-in pada {{ isset($todayAttendance) ? $todayAttendance->check_in->format('H:i') : '' }} ({{ isset($todayAttendance) ? $todayAttendance->check_in->diffForHumans() : '' }})</p>
            </div>
        </div>
        @endif

        <!-- Check In/Out Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Check In Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all hover:shadow-lg transform hover:-translate-y-1">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Check In
                    </h3>
                </div>
                <form action="{{ route('attendances.checkIn') }}" method="POST" class="p-6">
                    @csrf
                    <div class="mb-4">
                        <label for="notes_in" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                        <textarea id="notes_in" name="notes" rows="3" placeholder="Apa yang akan Anda kerjakan hari ini?" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg shadow transition-colors flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Check In Sekarang
                    </button>
                </form>
            </div>

            <!-- Check Out Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all hover:shadow-lg transform hover:-translate-y-1">
                <div class="bg-gradient-to-r from-red-600 to-red-700 p-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Check Out
                    </h3>
                </div>
                <form action="{{ route('attendances.checkOut') }}" method="POST" class="p-6">
                    @csrf
                    <div class="mb-4">
                        <label for="notes_out" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                        <textarea id="notes_out" name="notes" rows="3" placeholder="Apa yang telah Anda selesaikan hari ini?" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg shadow transition-colors flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Check Out Sekarang
                    </button>
                </form>
            </div>
        </div>

        <!-- Attendance History Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Riwayat Absensi
                </h2>
                
                <!-- Optional Filter -->
                <div class="hidden md:block">
                    <select class="bg-white/20 border-0 rounded-lg px-3 py-1 text-white focus:outline-none">
                        <option value="all">Semua</option>
                        <option value="current">Bulan Ini</option>
                        <option value="last">Bulan Lalu</option>
                    </select>
                </div>
            </div>
            
            <div class="overflow-x-auto p-1">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Check In
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Check Out
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status Kehadiran
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Catatan
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($attendances as $attendance)
                            <tr class="{{ $attendance->check_in->isToday() ? 'bg-blue-50' : '' }} hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center mr-3 font-medium">
                                            {{ $attendance->check_in->format('d') }}
                                        </div>
                                        <span>{{ $attendance->check_in->format('Y-m-d') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-blue-600 font-medium">
                                    {{ $attendance->check_in->format('H:i:s') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($attendance->check_out)
                                        <span class="text-red-600 font-medium">{{ $attendance->check_out->format('H:i:s') }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $attendance->status == 'Hadir' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $attendance->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if(isset($attendance->attendance_status))
                                            @if($attendance->attendance_status == 'Tepat Waktu')
                                                bg-green-100 text-green-800
                                            @elseif($attendance->attendance_status == 'Terlambat')
                                                bg-yellow-100 text-yellow-800
                                            @else
                                                bg-gray-100 text-gray-800
                                            @endif
                                        @else
                                            bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $attendance->attendance_status ?? 'Tidak Tersedia' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                    {{ $attendance->notes ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                {{ $attendances->links() }}
            </div>
        </div>
        
       
            </div>
        </div>
    </div>
</div>
@endsection