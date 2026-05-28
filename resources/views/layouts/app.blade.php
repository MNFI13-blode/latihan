<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance App</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            background: #f5f7fb;
            font-family: Arial, sans-serif;
        }

        .navbar-custom {
            background: #07122b;
        }

        .navbar .nav-link {
            color: #dbe4ff;
            padding: 10px 16px;
            border-radius: 8px;
            transition: .2s;
        }

        .navbar .nav-link:hover {
            background: #17326d;
            color: white;
        }

        .navbar .nav-link.active {
            background: #2d63ea;
            color: white;
        }

        .content {
            padding: 80px 32px 32px;;
        }

        .card-custom {
            background: white;
            border-radius: 16px;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold fs-3" href="/">
                Finance App
            </a>
            <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ms-auto gap-2">
                    <li class="nav-item">
                        <a href="/"
                            class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                            <i class="fa fa-home me-1"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/categories"
                            class="nav-link {{ request()->is('categories') ? 'active' : '' }}">
                            <i class="fa fa-layer-group me-1"></i>
                            Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/coas"
                            class="nav-link {{ request()->is('coas') ? 'active' : '' }}">
                            <i class="fa fa-book me-1"></i>
                            COA
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/transactions"
                            class="nav-link {{ request()->is('transactions') ? 'active' : '' }}">
                            <i class="fa fa-money-bill me-1"></i>
                            Transactions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/reports"
                            class="nav-link {{ request()->is('reports') ? 'active' : '' }}">
                            <i class="fa fa-chart-line me-1"></i>
                            Profit / Loss
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="content">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>