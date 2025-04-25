@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white p-8 rounded-xl shadow-lg max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Absensi</h1>

            <form method="POST" action="{{ route('admin.attendances.update', $attendance->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="check_in" class="block text-sm font-medium text-gray-700 mb-2">Check In</label>
                    <input type="datetime-local" name="check_in" id="check_in" value="{{ $attendance->check_in->format('Y-m-d\TH:i') }}" 
                           class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" required>
                    @error('check_in')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="check_out" class="block text-sm font-medium text-gray-700 mb-2">Check Out</label>
                    <input type="datetime-local" name="check_out" id="check_out" value="{{ $attendance->check_out ? $attendance->check_out->format('Y-m-d\TH:i') : '' }}" 
                           class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                    @error('check_out')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" required>
                        <option value="present" {{ $attendance->status == 'present' ? 'selected' : '' }}>Hadir</option>
                        <option value="absent" {{ $attendance->status == 'absent' ? 'selected' : '' }}>Tidak Hadir</option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="attendance_status" class="block text-sm font-medium text-gray-700 mb-2">Status Kehadiran</label>
                    <select name="attendance_status" id="attendance_status" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                        <option value="Tepat Waktu" {{ $attendance->attendance_status == 'Tepat Waktu' ? 'selected' : '' }}>Tepat Waktu</option>
                        <option value="Terlambat" {{ $attendance->attendance_status == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                    </select>
                    @error('attendance_status')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                    <textarea name="notes" id="notes" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition resize-y" rows="4">{{ $attendance->notes }}</textarea>
                    @error('notes')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 ease-in-out shadow-md">
                        Simpan
                    </button>
                    <a href="{{ route('admin.attendances.index') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition duration-200 ease-in-out shadow-md">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection