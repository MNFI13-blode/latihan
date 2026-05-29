<!DOCTYPE html>
<html lang="en">

<head>

    <!-- {{-- ===================================================== --}}
    {{-- META TAG --}}
    {{-- ===================================================== --}} -->

    <meta charset="UTF-8">

    <!-- {{-- Responsive mobile --}} -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- {{-- Judul website --}} -->
    <title>Finance App</title>

    <!-- {{-- ===================================================== --}}
    {{-- BOOTSTRAP CSS --}}
    {{-- ===================================================== --}} -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- {{-- ===================================================== --}}
    {{-- FONT AWESOME ICON --}}
    {{-- ===================================================== --}} -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- {{-- ===================================================== --}}
    {{-- CUSTOM CSS --}}
    {{-- ===================================================== --}} -->

    <style>
        /* 
            Style body utama
        */
        body {

            /* Background halaman */
            background: #f5f7fb;

            /* Font default */
            font-family: Arial, sans-serif;
        }

        /* ===================================================== */
        /* NAVBAR */
        /* ===================================================== */

        .navbar-custom {

            /* Warna navbar */
            background: #07122b;
        }

        /* Style semua nav-link */
        .navbar .nav-link {

            /* Warna text */
            color: #dbe4ff;

            /* Padding */
            padding: 10px 16px;

            /* Rounded */
            border-radius: 8px;

            /* Animasi hover */
            transition: .2s;
        }

        /* Hover nav-link */
        .navbar .nav-link:hover {

            background: #17326d;
            color: white;
        }

        /* Nav-link aktif */
        .navbar .nav-link.active {

            background: #2d63ea;
            color: white;
        }

        /* ===================================================== */
        /* CONTENT */
        /* ===================================================== */

        .content {

            /* 
                Padding:
                atas kanan-kiri bawah
                
                80px atas:
                agar tidak tertutup navbar fixed
            */
            padding: 80px 32px 32px;
        }

        /* ===================================================== */
        /* CARD CUSTOM */
        /* ===================================================== */

        .card-custom {

            /* Background putih */
            background: white;

            /* Rounded card */
            border-radius: 16px;

            /* Hilangkan border */
            border: none;

            /* Shadow */
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }
    </style>
</head>

<body>

    <!-- {{-- ===================================================== --}}
    {{-- NAVBAR --}}
    {{-- ===================================================== --}} -->

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm fixed-top">

        <div class="container-fluid">

            {{-- Logo / Brand --}}
            <a class="navbar-brand fw-bold fs-3" href="/">

                Finance App
            </a>

            <!-- {{-- ===================================================== --}}
            {{-- TOGGLER MOBILE --}}
            {{-- ===================================================== --}} -->

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu">

                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- {{-- ===================================================== --}}
            {{-- MENU NAVBAR --}}
            {{-- ===================================================== --}} -->

            <div class="collapse navbar-collapse" id="navbarMenu">

                <ul class="navbar-nav ms-auto gap-2">

                    <!-- {{-- ===================================================== --}}
                    {{-- DASHBOARD --}}
                    {{-- ===================================================== --}} -->

                    <li class="nav-item">
                        <!-- {{--
                                request()->is('/')
                                mengecek apakah halaman aktif
                            --}} -->
                        <a
                            href="/"class="nav-link {{ request()->is('/') ? 'active' : '' }}">

                            {{-- Icon --}}
                            <i class="fa fa-home me-1"></i>

                            Dashboard
                        </a>
                    </li>

                    <!-- {{-- ===================================================== --}}
                    {{-- CATEGORY --}}
                    {{-- ===================================================== --}} -->

                    <li class="nav-item">

                        <a
                            href="/categories"
                            class="nav-link {{ request()->is('categories') ? 'active' : '' }}">

                            <i class="fa fa-layer-group me-1"></i>

                            Categories
                        </a>
                    </li>

                    <!-- {{-- ===================================================== --}}
                    {{-- COA --}}
                    {{-- ===================================================== --}} -->

                    <li class="nav-item">

                        <a
                            href="/coas"
                            class="nav-link {{ request()->is('coas') ? 'active' : '' }}">

                            <i class="fa fa-book me-1"></i>

                            COA
                        </a>
                    </li>

                    <!-- {{-- ===================================================== --}}
                    {{-- TRANSACTIONS --}}
                    {{-- ===================================================== --}} -->

                    <li class="nav-item">

                        <a
                            href="/transactions"
                            class="nav-link {{ request()->is('transactions') ? 'active' : '' }}">

                            <i class="fa fa-money-bill me-1"></i>

                            Transactions
                        </a>
                    </li>

                    <!-- {{-- ===================================================== --}}
                    {{-- REPORT --}}
                    {{-- ===================================================== --}} -->

                    <li class="nav-item">

                        <a
                            href="/reports"
                            class="nav-link {{ request()->is('reports') ? 'active' : '' }}">

                            <i class="fa fa-chart-line me-1"></i>

                            Profit / Loss
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- {{-- ===================================================== --}}
    {{-- MAIN CONTENT --}}
    {{-- ===================================================== --}} -->

    <main class="content">

        <!-- {{-- 
            @yield('content')
            
            Tempat halaman lain ditampilkan
            
            Contoh:
            - dashboard
            - categories
            - coas
            - transactions
        --}} -->
        @yield('content')
    </main>

    <!-- {{-- ===================================================== --}}
    {{-- BOOTSTRAP JS --}}
    {{-- ===================================================== --}} -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>