<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Service Motor')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #F1F3F6;
            color: #344253;
        }

        .sidebar {
            width: 245px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #526B89;
            padding: 25px 18px;
            color: white;
        }

        .brand {
            font-size: 19px;
            font-weight: 700;
            margin-bottom: 40px;
            letter-spacing: 0.5px;
        }

        .brand span {
            display: block;
            font-size: 11px;
            font-weight: 400;
            color: #DCE5EF;
            margin-top: 6px;
        }

        .menu-title {
            font-size: 11px;
            color: #DCE5EF;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .menu a {
            display: block;
            text-decoration: none;
            color: #E8EEF5;
            padding: 13px 14px;
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 13px;
            transition: all 0.25s ease;
        }

        .menu a:hover {
            background: #6B829D;
            color: white;
            transform: translateX(4px);
        }

        .menu a.active {
            background: #E8EEF5;
            color: #344253;
            font-weight: 600;
        }

        .main-content {
            margin-left: 245px;
            padding: 35px;
            min-height: 100vh;
            animation: fadeIn 0.6s ease;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .topbar h2 {
            font-size: 22px;
            font-weight: 600;
        }

        .admin {
            background: white;
            padding: 10px 17px;
            border-radius: 8px;
            font-size: 12px;
            color: #526B89;
        }

        .content-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(52, 66, 83, 0.04);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .content-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 20px rgba(52, 66, 83, 0.08);
        }

        button, .btn {
            background: #526B89;
            color: white;
            border: none;
            padding: 11px 18px;
            border-radius: 7px;
            cursor: pointer;
            font-family: inherit;
            font-size: 13px;
            transition: all 0.25s ease;
        }

        button:hover, .btn:hover {
            background: #405875;
            transform: translateY(-1px);
        }

        input, select, textarea {
            width: 100%;
            padding: 11px 13px;
            margin-top: 7px;
            margin-bottom: 17px;
            border: 1px solid #DCE2E9;
            border-radius: 7px;
            outline: none;
            font-family: inherit;
            font-size: 13px;
            background: #FAFBFC;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #8298B2;
            box-shadow: 0 0 0 3px rgba(82, 107, 137, 0.10);
        }

        label {
            font-size: 13px;
            font-weight: 500;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 13px;
        }

        th {
            background: #E8EEF5;
            color: #344253;
            font-weight: 600;
            text-align: left;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #E9EDF2;
        }

        tr:hover td {
            background: #F8FAFC;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .menu {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
            }

            .menu a {
                margin-bottom: 0;
            }
        }
    </style>
</head>

<body>

    <aside class="sidebar">
        <div class="brand">
            SERVICE MOTOR
            <span>Sistem Informasi Bengkel</span>
        </div>

        <div class="menu-title">MENU UTAMA</div>

        <nav class="menu">
            <a href="{{ url('/pelanggan') }}" class="{{ request()->is('pelanggan') ? 'active' : '' }}">
                Data Pelanggan
            </a>

            <a href="{{ url('/kendaraan') }}" class="{{ request()->is('kendaraan') ? 'active' : '' }}">
                Data Kendaraan
            </a>

            <a href="{{ url('/daftar-service') }}" class="{{ request()->is('daftar-service') ? 'active' : '' }}">
                Daftar Service
            </a>

            <a href="{{ url('/data-service') }}" class="{{ request()->is('data-service') ? 'active' : '' }}">
                Data Service
            </a>

            <a href="{{ url('/pembayaran-service') }}" class="{{ request()->is('pembayaran-service') ? 'active' : '' }}">
                Pembayaran Service
            </a>
        </nav>
    </aside>

    <main class="main-content">
        <div class="topbar">
            <h2>@yield('heading', 'Dashboard')</h2>
            <div class="admin">Administrator</div>
        </div>

        @yield('content')
    </main>

</body>
</html>
