<!DOCTYPE html>
<html lang="en">
<head>

    {{-- ===================================================== --}}
    {{-- META TAG --}}
    {{-- ===================================================== --}}
    
    {{-- Encoding karakter --}}
    <meta charset="UTF-8">

    {{-- Responsive viewport --}}
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    {{-- Judul website --}}
    <title>Finance App</title>

    {{-- ===================================================== --}}
    {{-- IMPORT CSS --}}
    {{-- ===================================================== --}}

    {{-- Bootstrap CSS --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- Font Awesome Icon --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    {{-- ===================================================== --}}
    {{-- CUSTOM STYLE --}}
    {{-- ===================================================== --}}
    <style>

        /* ================================================= */
        /* BODY STYLE */
        /* ================================================= */

        body {

            /* Warna background utama */
            background: #f5f7fb;

            /* Font utama aplikasi */
            font-family: Arial, sans-serif;
        }

        /* ================================================= */
        /* NAVBAR STYLE */
        /* ================================================= */

        .navbar-custom {

            /* Warna navbar */
            background: #07122b;
        }

        /* Style semua nav link */
        .navbar .nav-link {

            /* Warna text */
            color: #dbe4ff;

            /* Padding tombol */
            padding: 10px 16px;

            /* Rounded sudut */
            border-radius: 8px;

            /* Animasi hover */
            transition: .2s;
        }

        /* Saat cursor diarahkan */
        .navbar .nav-link:hover {

            /* Background hover */
            background: #17326d;

            /* Warna text */
            color: white;
        }

        /* Menu aktif */
        .navbar .nav-link.active {

            /* Background aktif */
            background: #2d63ea;

            /* Warna text */
            color: white;
        }

        /* ================================================= */
        /* CONTENT STYLE */
        /* ================================================= */

        .content {

            /*
                Padding atas dibuat besar
                agar tidak tertutup navbar fixed
            */
            padding: 80px 32px 32px;
        }

        /* ================================================= */
        /* CUSTOM CARD STYLE */
        /* ================================================= */

        .card-custom {

            /* Background putih */
            background: white;

            /* Rounded card */
            border-radius: 16px;

            /* Hilangkan border */
            border: none;

            /* Shadow card */
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
        }

    </style>
</head>

<body>

    {{-- ===================================================== --}}
    {{-- NAVBAR --}}
    {{-- ===================================================== --}}
    
    <nav
        class="
            navbar
            navbar-expand-lg
            navbar-dark
            navbar-custom
            shadow-sm
            fixed-top
        "
    >

        <div class="container-fluid">

            {{-- ================================================= --}}
            {{-- LOGO / BRAND --}}
            {{-- ================================================= --}}
            
            <a
                class="navbar-brand fw-bold fs-3"
                href="/"
            >

                Finance App
            </a>

            {{-- ================================================= --}}
            {{-- TOGGLER MOBILE --}}
            {{-- ================================================= --}}
            
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu"
            >

                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- ================================================= --}}
            {{-- NAVBAR MENU --}}
            {{-- ================================================= --}}
            
            <div
                class="collapse navbar-collapse"
                id="navbarMenu"
            >

                <ul class="navbar-nav ms-auto gap-2">

                    {{-- ========================================= --}}
                    {{-- DASHBOARD MENU --}}
                    {{-- ========================================= --}}
                    
                    <li class="nav-item">

                        <a
                            href="/"
                            class="
                                nav-link
                                {{
                                    request()->is('/')
                                    ? 'active'
                                    : ''
                                }}
                            "
                        >

                            {{-- Icon --}}
                            <i class="fa fa-home me-1"></i>

                            Dashboard
                        </a>
                    </li>

                    {{-- ========================================= --}}
                    {{-- CATEGORY MENU --}}
                    {{-- ========================================= --}}
                    
                    <li class="nav-item">

                        <a
                            href="/categories"
                            class="
                                nav-link
                                {{
                                    request()->is('categories')
                                    ? 'active'
                                    : ''
                                }}
                            "
                        >

                            <i class="fa fa-layer-group me-1"></i>

                            Categories
                        </a>
                    </li>

                    {{-- ========================================= --}}
                    {{-- COA MENU --}}
                    {{-- ========================================= --}}
                    
                    <li class="nav-item">

                        <a
                            href="/coas"
                            class="
                                nav-link
                                {{
                                    request()->is('coas')
                                    ? 'active'
                                    : ''
                                }}
                            "
                        >

                            <i class="fa fa-book me-1"></i>

                            Chart of Accounts
                        </a>
                    </li>

                    {{-- ========================================= --}}
                    {{-- TRANSACTION MENU --}}
                    {{-- ========================================= --}}
                    
                    <li class="nav-item">

                        <a
                            href="/transactions"
                            class="
                                nav-link
                                {{
                                    request()->is('transactions')
                                    ? 'active'
                                    : ''
                                }}
                            "
                        >

                            <i class="fa fa-money-bill me-1"></i>

                            Transactions
                        </a>
                    </li>

                    {{-- ========================================= --}}
                    {{-- REPORT MENU --}}
                    {{-- ========================================= --}}
                    
                    <li class="nav-item">

                        <a
                            href="/reports"
                            class="
                                nav-link
                                {{
                                    request()->is('reports')
                                    ? 'active'
                                    : ''
                                }}
                            "
                        >

                            <i class="fa fa-chart-line me-1"></i>

                            Profit / Loss
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    {{-- ===================================================== --}}
    {{-- MAIN CONTENT --}}
    {{-- ===================================================== --}}
    
    <main class="content">

        {{-- 
            Tempat isi halaman lain dimasukkan.
            Semua halaman seperti dashboard,
            categories, transactions,
            akan tampil di sini.
        --}}
        @yield('content')
    </main>

    {{-- ===================================================== --}}
    {{-- IMPORT JS --}}
    {{-- ===================================================== --}}

    {{-- Bootstrap Bundle JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>