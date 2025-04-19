<x-authHeader />

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - CourtEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">Reset Your Password</h2>

    <div class="row justify-content-center">
        <div class="col-md-6">
            @if (session('step') === 'verify-code')
                <!-- STEP 2: Enter Verification Code -->
                <form method="POST" action="{{ route('verifyResetCode') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('email') }}">

                    <div class="mb-3">
                        <label for="code" class="form-label">Enter the verification code sent to your email</label>
                        <input type="text" name="code" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Verify Code</button>
                </form>
            @else
                <!-- STEP 1: Request Reset Code -->
                <form method="POST" action="{{ route('sendResetCode') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Enter your email address</label>
                        <input 
                            type="email" 
                            class="form-control" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Send Reset Code</button>
                </form>
            @endif

            <div class="text-center mt-3">
                <a href="{{ route('login') }}">Back to Login</a>
            </div>

            @if(session('status'))
                <div class="alert alert-success mt-3">{{ session('status') }}</div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
