<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Analitik</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<!-- Background halaman -->
<body class="bg-gray-100">

    <!-- ================= NAVBAR ================= -->
    <div class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <!-- ===== Logo / Brand ===== -->
            <h1 class="text-xl font-bold text-gray-800">My App</h1>

            <!-- ===== Menu Navigasi Tengah ===== -->
            <div class="flex gap-8">

                <!-- ===== Menu Dashboard ===== -->
                <a href="/"
                    class="relative px-3 py-2 transition
                    {{ request()->is('/') ? 'text-blue-500 font-bold' : 'text-gray-700 hover:text-blue-500' }}">

                    Dashboard

                    <!-- ===== Efek garis bawah animasi ===== -->
                    <span class="absolute left-0 bottom-0 w-full h-0.5 bg-blue-500 scale-x-0 transition-transform duration-300 origin-left
                        {{ request()->is('/') ? 'scale-x-100' : 'group-hover:scale-x-100' }}">
                    </span>
                </a>

                <!-- ===== Menu Manajemen Data ===== -->
                <a href="/data"
                    class="relative px-3 py-2 transition
                    {{ request()->is('data') ? 'text-blue-500 font-bold' : 'text-gray-700 hover:text-blue-500' }}">

                    Manajemen Data

                    <!-- ===== Efek garis bawah animasi ===== -->
                    <span class="absolute left-0 bottom-0 w-full h-0.5 bg-blue-500 scale-x-0 transition-transform duration-300 origin-left
                        {{ request()->is('data') ? 'scale-x-100' : 'group-hover:scale-x-100' }}">
                    </span>
                </a>

            </div>

            <!-- ===== Spacer kanan (biar layout seimbang) ===== -->
            <div></div>

        </div>
    </div>

    <!-- ================= CONTENT ================= -->
    <div class="p-6">

        <!-- Tempat isi konten dari blade lain -->
        @yield('content')

    </div>

</body>

</html>