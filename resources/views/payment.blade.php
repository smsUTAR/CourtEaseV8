
<div class="container">
    <div class="header">
        <h1>Booking Confirmation</h1>
        <div class="auth-links">
            <a href="{{ route('court-listing') }}">Home</a>
            <a href="{{ route('account') }}">Account</a>
            <a href="{{ route('logout') }}">Log Out</a>
        </div>
    </div>

    <div class="court-details">
        <h2>Court Name: {{ $court->name }}</h2>
        <img src="{{ asset('storage/' . $court->image) }}" alt="{{ $court->name }}" width="300">
        <p>Price per hour: RM{{ number_format($court->price, 2) }}</p>
        <p>Booking Date: {{ $date }}</p>
        <p>Booked Hours: {{ $hours }} hour(s)</p>
        <p><strong>Total: RM{{ number_format($total, 2) }}</strong></p>
    </div>

    <form action="{{ route('process-payment') }}" method="POST">
        @csrf
        <input type="hidden" name="court_id" value="{{ $court->id }}">
        <input type="hidden" name="date" value="{{ $date }}">
        <input type="hidden" name="hours" value="{{ $hours }}">
        <input type="hidden" name="total" value="{{ $total }}">

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
            <a href="{{ route('contact') }}" class="btn btn-contact">Contact Us</a>
        </div>
    </form>
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
