@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white p-8 rounded-xl shadow-lg">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Manajemen Absensi</h1>

            <!-- Tampilkan pesan sukses atau error -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form untuk Admin Mengabsen Karyawan -->
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Absen Karyawan</h2>
                <form method="POST" action="{{ route('admin.attendances.absen') }}" class="flex flex-col sm:flex-row sm:space-x-6 space-y-4 sm:space-y-0">
                    @csrf
                    <div class="flex-1">
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Karyawan</label>
                        <select name="user_id" id="user_id" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                        <input type="date" name="date" id="date" value="{{ now()->format('Y-m-d') }}" 
                               class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                    </div>
                    <div class="flex-1">
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Absensi</label>
                        <select name="type" id="type" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                            <option value="check_in">Check-In</option>
                            <option value="check_out">Check-Out</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200 ease-in-out shadow-md">
                            Absen
                        </button>
                    </div>
                </form>
            </div>

            <!-- Form Filter -->
            <form method="GET" action="{{ route('admin.attendances.index') }}" class="mb-8 flex flex-col sm:flex-row sm:space-x-6 space-y-4 sm:space-y-0">
                <div class="flex-1">
                    <label for="user_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Karyawan</label>
                    <select name="user_name" id="user_name" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                        <option value="">Semua Karyawan</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->name }}" {{ $user->name == request('user_name') ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="date" id="date" value="{{ request('date') }}" 
                           class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 ease-in-out shadow-md">
                        Filter
                    </button>
                </div>
            </form>

            <!-- Tabel Absensi -->
            <div class="overflow-x-auto">
                <table class="w-full border-collapse bg-white rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-blue-50 text-gray-700">
                            <th class="border-b border-gray-200 p-4 text-left">Nama Karyawan</th>
                            <th class="border-b border-gray-200 p-4 text-left">Check-In</th>
                            <th class="border-b border-gray-200 p-4 text-left">Check-Out</th>
                            <th class="border-b border-gray-200 p-4 text-left">Status</th>
                            <th class="border-b border-gray-200 p-4 text-left">Status Kehadiran</th>
                            <th class="border-b border-gray-200 p-4 text-left">Catatan</th>
                            <th class="border-b border-gray-200 p-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendances as $attendance)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="border-b border-gray-200 p-4 text-gray-600">{{ $attendance->user->name }}</td>
                                <td class="border-b border-gray-200 p-4 text-gray-600">{{ $attendance->check_in->format('Y-m-d H:i:s') }}</td>
                                <td class="border-b border-gray-200 p-4 text-gray-600">{{ $attendance->check_out ? $attendance->check_out->format('Y-m-d H:i:s') : '-' }}</td>
                                <td class="border-b border-gray-200 p-4 text-gray-600">{{ $attendance->status }}</td>
                                <td class="border-b border-gray-200 p-4 text-gray-600">{{ $attendance->attendance_status ?? '-' }}</td>
                                <td class="border-b border-gray-200 p-4 text-gray-600">{{ $attendance->notes ?? '-' }}</td>
                                <td class="border-b border-gray-200 p-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.attendances.edit', $attendance->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold">✏️ Edit</a>
                                        <form action="{{ route('admin.attendances.destroy', $attendance->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">🗑️ Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border-b border-gray-200 p-4 text-center text-gray-500"> Tidak ada data absensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection