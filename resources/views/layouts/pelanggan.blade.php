<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Ruang Teduh</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Georgia:wght@400;700&display=swap" rel="stylesheet">
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
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .header-logo {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .header-info {
            flex: 1;
        }

        .header h1 {
            font-family: 'Georgia', serif;
            font-size: 1.6rem;
            margin: 0 0 0.2rem 0;
        }

        .header p {
            font-size: 0.9rem;
            opacity: 0.9;
            margin: 0;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .menu-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            border: 2px solid transparent;
        }

        .menu-card:hover {
            transform: translateY(-4px);
            border-color: #C5D89D;
        }

        .menu-header {
            background: #C5D89D;
            padding: 1rem;
        }

        .menu-header h3 {
            font-size: 1.2rem;
            color: #2C4A32;
        }

        .menu-body {
            padding: 1rem;
        }

        .menu-body p {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .menu-price {
            font-size: 1.4rem;
            font-weight: bold;
            color: #3D6B4F;
            margin: 1rem 0;
        }

        .menu-actions {
            display: flex;
            gap: 0.5rem;
        }

        input[type="number"] {
            width: 70px;
            padding: 0.5rem;
            border: 2px solid #C5D89D;
            border-radius: 8px;
            font-size: 1rem;
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
            flex: 1;
        }

        .btn-primary:hover {
            background: #2C4A32;
        }

        .filter-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.6rem 1.2rem;
            border: 2px solid #C5D89D;
            background: white;
            color: #2C4A32;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .filter-btn.active {
            background: #C5D89D;
            color: #2C4A32;
        }

        .filter-btn:hover {
            background: #C5D89D;
        }

        .cart-sidebar {
            position: sticky;
            top: 2rem;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.8rem;
            border-bottom: 1px solid #E5E5E5;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .cart-item-qty {
            font-size: 0.8rem;
            color: #999;
        }

        .cart-item-price {
            font-weight: bold;
            color: #3D6B4F;
        }

        .cart-total {
            padding: 1rem;
            background: #C5D89D;
            border-radius: 8px;
            text-align: right;
            font-size: 1.2rem;
            font-weight: bold;
            color: #2C4A32;
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

        @media (max-width: 768px) {
            .menu-grid {
                grid-template-columns: 1fr;
            }

            .cart-sidebar {
                position: static;
                margin-top: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('assets/logoo.jpg') }}" alt="Ruang Teduh" class="header-logo">
        <div class="header-info">
            <h1>Ruang Teduh</h1>
            <p>Meja <strong>{{ $meja_id ?? '-' }}</strong></p>
        </div>
    </div>

    <div class="container">
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

        <div style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem;">
            <div>
                @yield('content')
            </div>

            <div class="cart-sidebar">
                <div class="card">
                    <h2 style="margin-bottom: 1rem; color: #3D6B4F;">📋 Pesanan Anda</h2>
                    @yield('cart')
                </div>
            </div>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
