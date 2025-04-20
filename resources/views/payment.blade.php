<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .auth-links a,
        .auth-links form button {
            margin-left: 15px;
            text-decoration: none;
            color: #007BFF;
            background: none;
            border: none;
            font: inherit;
            cursor: pointer;
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
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Booking Confirmation</h1>
        <div class="auth-links">
            <a href="{{ route('court-listing') }}">Home</a>
            <a href="{{ route('account') }}">Account</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Log Out</button>
            </form>
        </div>
    </div>

    <div class="court-details">
        <h2>Court Name: {{ $court->name }}</h2>
        <img src="{{ asset('storage/' . $court->image) }}" alt="{{ $court->name }}" width="300">

        @php
            $hours = request()->get('hours', 1);
            $total = $court->price * $hours;
        @endphp

        <p>Price per Hour: RM{{ number_format($court->price, 2) }}</p>
        <p>Hours Booked: {{ $hours }}</p>
        <p><strong>Total: RM{{ number_format($total, 2) }}</strong></p>
    </div>

    <form action="{{ route('process.payment') }}" method="POST">
        @csrf
        <input type="hidden" name="court_id" value="{{ $court->id }}">
        <input type="hidden" name="hours" value="{{ $hours }}">
        <input type="hidden" name="total" value="{{ $total }}">

        <div class="payment-methods">
            <h3>Payment Method:</h3>
            <label>
                <input type="radio" name="payment_method" value="credit_debit" checked>
                Credit/Debit Card
            </label>
            <label>
                <input type="radio" name="payment_method" value="e_wallet">
                E-Wallet
            </label>
        </div>

        <div class="footer-buttons">
            <a href="{{ route('court-details', $court->id) }}" class="btn btn-back">Back</a>
            <button type="submit" class="btn btn-confirm">Confirm Payment</button>
            <a href="{{ route('contact') }}" class="btn btn-contact">Contact Us</a>
        </div>
    </form>
</div>
</body>
</html>
