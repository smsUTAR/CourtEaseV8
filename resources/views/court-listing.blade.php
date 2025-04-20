<!DOCTYPE html>
<html lang="en">
<head>
  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to CourtEase</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('welcome') }}">Welcome to CourtEase!</a>
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

<div class="container mt-4">
    <h2>Court Listing</h2>

    <div class="row">
    @forelse($availableCourts as $court)
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $court->name }}</h5>
                <a href="{{ route('court-details', ['id' => $court->id]) }}" class="btn btn-primary">View Details</a>
            </div>
        </div>
    </div>
    @empty
        <p>No available courts at the moment.</p>
    @endforelse
    </div>

    <h3 class="mt-5">Your Bookings</h3>

    @if($userBookings->isEmpty())
        <p>You have no bookings yet.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Court Name</th>
                        <th>Date</th>
                        <th>Hours</th>
                        <th>Total Price (RM)</th>
                        <th>Payment Method</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userBookings as $booking)
                        <tr>
                            <td>{{ $booking->court->name }}</td>
                            <td>{{ $booking->booking_date }}</td>
                            <td>{{ $booking->hours }}</td>
                            <td>{{ number_format($booking->totalPrice, 2) }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $booking->payment_method)) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <footer class="mt-4">
    <a href="{{ route('contact') }}">Contact Us</a>
    </footer>
</div>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
