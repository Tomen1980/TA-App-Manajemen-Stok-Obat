<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    @if (Auth::check())
    <div class="flex">
            <!-- Sertakan Sidebar -->
            @include('layouts.partials.sidebar')
        
        <!-- Konten Utama -->
        <div class="flex-1 p-4">
            <!-- Tombol Toggle untuk Mobile -->
            <button class="md:hidden p-2 bg-blue-800 text-white rounded" onclick="toggleSidebar()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Konten Dinamis -->
            @yield('content')
        </div>
    </div>

    <!-- Script untuk Toggle Sidebar dan Dropdown -->
    <script>
        // Toggle Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }

        // Toggle Dropdown
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
        }
    </script>

    @else
    @yield('content')
    @endif
</body>
</html>