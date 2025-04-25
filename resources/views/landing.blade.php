<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Absensi Kantor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 to-white min-h-screen flex items-center justify-center font-sans">
    <div class="bg-white shadow-2xl rounded-2xl p-10 max-w-xl text-center animate-fade-in-up">
        <div class="mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m4-5V7a4 4 0 00-4-4H7a4 4 0 00-4 4v5m16 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2" />
            </svg>
        </div>
        <h1 class="text-4xl font-extrabold text-gray-800 mb-4">Selamat Datang</h1>
        <p class="text-lg text-gray-600 mb-8">Kelola absensi karyawan dengan mudah dan efisien.</p>

        <!-- Jam Digital dan Tanggal -->
        <div class="mb-8">
            <div id="digitalClock" class="text-2xl font-semibold text-gray-700 bg-gray-100 p-3 rounded-xl shadow-inner animate-pulse">
                00:00:00
            </div>
            <div id="dateDisplay" class="text-lg font-medium text-gray-600 mt-2">
                2025-01-01
            </div>
        </div>

        @auth
            <a href="{{ route('attendances.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300 shadow-lg">
                📋 Lihat Absensi
            </a>
        @else
            <div class="flex justify-center gap-4">
                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300 shadow-md">
                    🔐 Login
                </a>
                <a href="{{ route('register') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300 shadow-md">
                    📝 Daftar
                </a>
            </div>
        @endauth
    </div>

    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out both;
        }
    </style>

    <!-- JavaScript untuk Jam Digital dan Tanggal -->
    <script>
        function updateDigitalClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;
            document.getElementById('digitalClock').textContent = timeString;

            // Update tanggal
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const dateString = `${year}-${month}-${day}`;
            document.getElementById('dateDisplay').textContent = dateString;
        }

        // Perbarui jam setiap detik
        setInterval(updateDigitalClock, 1000);

        // Panggil sekali saat halaman dimuat
        updateDigitalClock();
    </script>
</body>
</html>