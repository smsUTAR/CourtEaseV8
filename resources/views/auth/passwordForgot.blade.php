<x-authHeader />

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - CourtEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .brand-section {
            background-color: #6610f2;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
        }

        .form-section {
            padding: 2rem;
        }
    </style>
</head>
<body class="bg-danger">

<div class="container mt-5">
    <div class="row shadow-lg rounded-4 overflow-hidden">
        <!-- Left side: Branding -->
        <div class="col-md-6 brand-section">
            <div>
                <h1 class="display-5 fw-bold">Reset Your Password</h1>
            </div>
        </div>

        <!-- Right side: Form -->
        <div class="col-md-6 form-section bg-white">
            

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

                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                            {{ $errors->first('email') }}
                        </div>
                    @endif

                    <button type="submit" class="btn btn-success w-100">Send Reset Code</button>
                </form>
            @endif

            @if(session('status'))
                <div class="alert alert-success mt-3">{{ session('status') }}</div>
            @endif

            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-primary">Back to Login</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
