<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Kantor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow p-4">
        <div class="container mx-auto flex justify-between">
            <a href="/" class="text-lg font-bold">Absensi Kantor</a>
            @auth
                <div>
                    <span>{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="ml-4 text-red-500">Logout</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endauth
        </div>
        <!-- Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('attendances.index')" :active="request()->routeIs('attendances.index')">
        {{ __('Absensi Saya') }}
    </x-nav-link>

    @if (Auth::user()->role === 'admin')
        <x-nav-link :href="route('admin.attendances.index')" :active="request()->routeIs('admin.attendances.index')">
            {{ __('Manajemen Absensi') }}
        </x-nav-link>
    @endif
</div>
    </nav>

    <main class="container mx-auto mt-8">
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>