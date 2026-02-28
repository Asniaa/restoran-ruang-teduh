<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Ruang Teduh</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/logoo.jpg') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Georgia:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FAF9EE;
            color: #2C4A32;
        }

        .header {
            background: linear-gradient(135deg, #3D6B4F 0%, #2C4A32 100%);
            color: white;
            padding: 0.8rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            gap: 2rem;
        }

        .header-logo-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
        }

        .header-logo {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .header h1 {
            font-family: 'Georgia', serif;
            font-size: 1.6rem;
            margin: 0;
        }

        .logout-btn {
            background: #B85C5C;
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.95rem;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: #a54747;
        }

        .container-wrapper {
            display: flex;
            min-height: calc(100vh - 70px);
        }

        .sidebar {
            width: 250px;
            background: white;
            border-right: 2px solid #C5D89D;
            padding: 2rem 0;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar-item {
            padding: 1rem 1.5rem;
            border-left: 4px solid transparent;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: block;
            color: #2C4A32;
            font-weight: 500;
        }

        .sidebar-item:hover {
            background: #F5F5F0;
            border-left-color: #C5D89D;
        }

        .sidebar-item.active {
            background: #C5D89D;
            border-left-color: #3D6B4F;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #C5D89D 0%, #3D6B4F 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .stat-card h3 {
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
            font-family: 'Georgia', serif;
        }

        .stat-card .value {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #3D6B4F;
            color: white;
        }

        .btn-primary:hover {
            background: #2C4A32;
        }

        .btn-success {
            background: #6B9D7F;
            color: white;
        }

        .btn-success:hover {
            background: #5A8B6D;
        }

        .btn-danger {
            background: #B85C5C;
            color: white;
        }

        .btn-danger:hover {
            background: #a54747;
        }

        .btn-warning {
            background: #E8B84B;
            color: white;
        }

        .btn-warning:hover {
            background: #d9a731;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .table thead {
            background: #C5D89D;
            color: #2C4A32;
        }

        .table th,
        .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #E5E5E5;
        }

        .table tbody tr:hover {
            background: #FAF9EE;
        }

        .badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-info {
            background: #C5D89D;
            color: #2C4A32;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #C5D89D;
            padding-bottom: 1rem;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #2C4A32;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #2C4A32;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #C5D89D;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #3D6B4F;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .main-content {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-logo-section">
            <img src="{{ asset('assets/logoo.jpg') }}" alt="Ruang Teduh" class="header-logo">
            <h1>Ruang Teduh</h1>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="container-wrapper">
        <div class="sidebar">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.index') }}"
                    class="sidebar-item {{ request()->routeIs('admin.index') ? 'active' : '' }}">📊 Dashboard</a>
                <a href="{{ route('admin.menu.index') }}"
                    class="sidebar-item {{ request()->routeIs('admin.menu.*') ? 'active' : '' }}">🍖 Menu Management</a>
                <a href="{{ route('admin.kategori.index') }}"
                    class="sidebar-item {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">🏷️ Kategori</a>
                <a href="{{ route('admin.meja.index') }}"
                    class="sidebar-item {{ request()->routeIs('admin.meja.*') ? 'active' : '' }}">🪑 Table Management</a>
                <a href="{{ route('admin.karyawan.index') }}"
                    class="sidebar-item {{ request()->routeIs('admin.karyawan.*') ? 'active' : '' }}">👥 Employee
                    Management</a>

                <a href="{{ route('admin.laporan.index') }}"
                    class="sidebar-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">📈 Laporan</a>

            @elseif(auth()->user()->role === 'dapur')
                <a href="{{ route('dapur.index') }}"
                    class="sidebar-item {{ request()->routeIs('dapur.index') ? 'active' : '' }}">👨‍🍳 Kitchen</a>
            @elseif(auth()->user()->role === 'pelayan')
                <a href="{{ route('pelayan.index') }}"
                    class="sidebar-item {{ request()->routeIs('pelayan.index') ? 'active' : '' }}">🚶 Waiter</a>
            @elseif(auth()->user()->role === 'kasir')
                <a href="{{ route('kasir.index') }}" class="sidebar-item {{ request()->is('kasir*') ? 'active' : '' }}">💰
                    Cashier</a>
            @endif
        </div>

        <div class="main-content">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-error">
                    {{ $message }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        window.onclick = function (event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
            }
        };

        // Auto-refresh every 30 seconds untuk dapur, pelayan, kasir
        @if (auth()->user()->role !== 'admin')
            setInterval(() => {
                location.reload();
            }, 30000);
        @endif

        // Notifikasi browser
        function showNotification(title, message) {
            if ('Notification' in window) {
                if (Notification.permission === 'granted') {
                    new Notification(title, { body: message });
                }
            }
        }

        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }
    </script>

    @yield('scripts')
</body>

</html>