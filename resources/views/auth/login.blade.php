<x-authHeader />

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CourtEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .full-bg {
            background-image: url('/images/login-bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 500px;
        }
    </style>
</head>
<body>

@if(session('error'))
    <div class="alert alert-danger" id="error-alert">
        {{ session('error') }}
    </div>

    <script>
        setTimeout(() => {
            let alert = document.getElementById('error-alert');
            if (alert) alert.style.display = 'none';
        }, 5000);
    </script>
@endif

<div class="full-bg">
    <div class="login-card">
        <h2 class="text-center mb-4">
            {{ $isAdmin ? 'Admin Login' : 'Login' }}
        </h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password" required>
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2 text-end">
                <a href="{{ route('passwordForgot') }}" class="text-decoration-none">Forgot your password?</a>
            </div>

            <button type="submit" class="btn btn-dark w-100 mb-3">Login</button>

            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>

            @if ($registerRoute)
                <div class="text-center">
                    <a href="{{ $registerRoute }}">
                        {{ $isAdmin ? 'Register as Admin' : "Don't have an account? Register" }}
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
