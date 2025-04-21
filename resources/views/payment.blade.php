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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Court Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <img src="/icons/badminton.png" alt="Badminton Icon" width="50" height="50" class="me-2" >
        <a class="navbar-brand" href="{{ route('court-listing') }}">CourtEase</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('court-listing') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('account') }}">Account</a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Are you sure you want to logout?')" class="d-inline">
                        @csrf
                        <input type="hidden" name="is_admin" value="{{ session('is_admin') ? 1 : 0 }}">
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="header">
        <h1>Booking Confirmation</h1>
    </div>

    <div class="court-details">
        <h2>Court Name: {{ $court->name }}</h2>
        <img src="{{ asset('storage/' . $court->image) }}" alt="{{ $court->name }}" width="300">
        <p>Price per hour: RM{{ number_format($court->price, 2) }}</p>
        <p>Booking Date: {{ $date }}</p>
        <p>Booking Start Time: {{ $startTime }}</p>
        <p>Booking End Time: {{ $endTime }}</p>
        <p>Booked Hours: {{ $hours }} hour(s)</p>
        <p><strong>Total: RM{{ number_format($total, 2) }}</strong></p>
    </div>

    <form action="{{ route('process-payment') }}" method="POST">
        @csrf
        <input type="hidden" name="court_id" value="{{ $court->id }}">
        <input type="hidden" name="date" value="{{ $date }}">
        <input type="hidden" name="hours" value="{{ $hours }}">
        <input type="hidden" name="total" value="{{ $total }}">
        <input type="hidden" name="start_time" value="{{ $startTime }}">
        <input type="hidden" name="end_time" value="{{ $endTime }}">

        <div class="payment-methods">
            <h3>Payment Method:</h3>
            <label>
                <input type="radio" name="payment_method" value="credit_debit" checked>
                Credit/Debit Card
            </label><br>
            <label>
                <input type="radio" name="payment_method" value="e_wallet">
                E-Wallet
            </label>
        </div>

        <div class="footer-buttons">
            <a href="{{ route('court-details', $court->id) }}" class="btn btn-back">Back</a>
            <button type="submit" class="btn btn-confirm">Confirm Payment</button>
        </div>
    </form>
</div>
</body>
</html>

@include('components.contactUs')

<style>
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .auth-links a {
        margin-left: 15px;
    }
    .court-details {
        text-align: center;
        margin: 20px 0;
    }
    .payment-methods {
        margin: 20px 0;
    }
    .footer-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }
    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
    }
    .btn-back {
        background: #f0f0f0;
    }
    .btn-confirm {
        background: #4CAF50;
        color: white;
    }
    .btn-contact {
        background: #2196F3;
        color: white;
    }
</style>
