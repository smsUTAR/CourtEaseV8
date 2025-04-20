
<div class="container">
    <div class="header">
        <h1>Booking Successful</h1>
        <div class="auth-links">
            <a href="{{ route('court-listing') }}">Home</a>
            <a href="{{ route('account') }}">Account</a>
            <a href="{{ route('logout') }}">Log Out</a>
        </div>
    </div>

    <div class="booking-details">
        <p><strong>Booking ID:</strong> {{ $booking->id }}</p>

        <!-- Check if court exists and display court name -->
        <p><strong>Court Name:</strong> 
            {{ $booking->court ? $booking->court->name : 'N/A' }}
        </p>

        <!-- Check if user exists and display user name and phone -->
        <p><strong>User Name:</strong> 
            {{ $booking->user ? $booking->user->name : 'N/A' }}
        </p>
        <p><strong>Phone Number:</strong> 
            {{ $booking->user && $booking->user->phone ? $booking->user->phone : 'N/A' }}
        </p>

        <!-- Display court price -->
        <p><strong>Price:</strong> RM{{ number_format($booking->totalPrice, 2) }}</p>

        <p><strong>Payment Method:</strong> 
            {{ $booking->payment_method === 'credit_debit' ? 'Credit/Debit Card' : 'E-Wallet' }}
        </p>
    </div>

    <div class="footer-buttons">
        <a href="{{ route('contact') }}" class="btn btn-contact">Contact Us</a>
    </div>
</div>

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
    .booking-details {
        margin: 20px 0;
        line-height: 2;
    }
    .footer-buttons {
        text-align: right;
        margin-top: 30px;
    }
    .btn-contact {
        padding: 10px 20px;
        background: #2196F3;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>
