<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventify - Daftar Event</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F3F4F6; }
    </style>
</head>
<body class="flex flex-col min-h-screen">
    <!-- Updated Layout V2 -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo Home -->
                <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600 tracking-tighter hover:text-indigo-800 transition">
                    Eventify.
                </a>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-gray-600 hover:text-indigo-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <!-- Menu Admin -->
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-indigo-600 font-medium text-sm">Dashboard</a>
                        <a href="{{ route('admin.events.table') }}" class="text-gray-600 hover:text-indigo-600 font-medium text-sm">Kelola Event</a>
                        <a href="{{ route('admin.registrations.index') }}" class="text-gray-600 hover:text-indigo-600 font-medium text-sm">Kelola Pesanan</a>
                        <a href="{{ route('admin.attendance.index') }}" class="text-indigo-600 font-bold bg-indigo-50 px-3 py-1 rounded-lg text-sm border border-indigo-200 hover:bg-indigo-100 transition">Absensi Hari-H</a>
                        
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-600 transition shadow-md">
                                Logout
                            </button>
                        </form>
                    @else
                        <!-- Menu Public -->
                        <a href="{{ route('public.orders.check') }}" class="text-gray-600 hover:text-indigo-600 font-medium text-sm">Cek Pesanan</a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 shadow-lg absolute w-full left-0 z-40">
            <div class="px-4 py-4 space-y-3 flex flex-col">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-indigo-600 font-medium text-sm block">Dashboard</a>
                    <a href="{{ route('admin.events.table') }}" class="text-gray-600 hover:text-indigo-600 font-medium text-sm block">Kelola Event</a>
                    <a href="{{ route('admin.registrations.index') }}" class="text-gray-600 hover:text-indigo-600 font-medium text-sm block">Kelola Pesanan</a>
                    <a href="{{ route('admin.attendance.index') }}" class="text-indigo-600 font-bold bg-indigo-50 px-3 py-2 rounded-lg text-sm block border border-indigo-200">Absensi Hari-H</a>
                    
                    <div class="pt-2 border-t border-gray-100">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left text-red-500 hover:text-red-700 font-medium text-sm">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('public.orders.check') }}" class="text-gray-600 hover:text-indigo-600 font-medium text-sm block">Cek Pesanan</a>
                @endauth
            </div>
        </div>
    </nav>

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

    <main class="flex-grow py-10 px-4">
        <div class="max-w-6xl mx-auto">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto py-6">
        <div class="max-w-6xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Eventify Project.
            @guest
                <br><a href="{{ route('login') }}" class="text-gray-300 hover:text-gray-500 text-xs mt-2 inline-block">Login Admin</a>
            @endguest
        </div>
    </footer>

    @stack('scripts')
</body>
</html>