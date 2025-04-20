<!-- resources/views/auth/login.blade.php -->
<x-authHeader />

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CourtEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

@if(session('error'))
    <div class="alert alert-danger" id="error-alert">
        {{ session('error') }}
    </div>

    <script>
        // Hide the error alert after 5 seconds (5000ms)
        setTimeout(function() {
            let alert = document.getElementById('error-alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 5000);
    </script>
@endif

<div class="container mt-5">
    <h2 class="text-center mb-4">
        {{ $isAdmin ? 'Admin Login to CourtEase' : 'Login to CourtEase' }}
    </h2>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2 text-end">
                    <a href="{{ route('passwordForgot') }}" class="text-decoration-none">Forgot your password?</a>
                </div>

                <button type="submit" class="btn btn-dark w-100">Login</button>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>

                @if ($registerRoute)
                <div class="text-center mt-3">
                    <a href="{{ $registerRoute }}">
                        {{ $isAdmin ? 'Register as Admin' : "Don't have an account? Register" }}
                    </a>
                </div>
@endif
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>