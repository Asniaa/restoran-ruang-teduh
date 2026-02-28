<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ruang Teduh</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Georgia:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #3D6B4F 0%, #2C4A32 100%); display: flex; justify-content: center; align-items: center; min-height: 100vh; color: #2C4A32; }
        .login-container { background: white; border-radius: 12px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3); width: 100%; max-width: 400px; padding: 3rem 2rem; text-align: center; }
        .logo-section { display: flex; justify-content: center; margin-bottom: 1rem; }
        .logo-img { width: 80px; height: 80px; object-fit: contain; }
        .login-container h1 { font-family: 'Georgia', serif; font-size: 2rem; margin-bottom: 0.5rem; color: #3D6B4F; }
        .login-container p { color: #999; margin-bottom: 2rem; font-size: 0.9rem; }
        .form-group { margin-bottom: 1.5rem; text-align: left; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #2C4A32; }
        input { width: 100%; padding: 0.8rem; border: 2px solid #C5D89D; border-radius: 8px; font-family: 'Poppins', sans-serif; font-size: 1rem; transition: border-color 0.3s; }
        input:focus { outline: none; border-color: #3D6B4F; }
        .btn { width: 100%; padding: 0.8rem; background: #3D6B4F; color: white; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background 0.3s; }
        .btn:hover { background: #2C4A32; }
        .error { color: #B85C5C; font-size: 0.9rem; margin-top: 0.3rem; }
        .errors { background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-section">
            <img src="{{ asset('assets/logoo.jpg') }}" alt="Ruang Teduh" class="logo-img">
        </div>
        <h1>Ruang Teduh</h1>
        <p>Sistem Manajemen Restoran</p>

        @if ($errors->any())
            <div class="errors">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                @error('email')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                @error('password')<div class="error">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>