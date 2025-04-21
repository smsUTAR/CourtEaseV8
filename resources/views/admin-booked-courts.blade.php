<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booked Courts</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<!--  Responsive Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('admin') }}">Admin Panel</a>
        
        <!-- Toggler for mobile view -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible navbar links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin') }}">Admin</a>
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

<div class="container mt-5">
    <h2>Booked Courts</h2>

    <!-- Search Filter Form -->
    <form action="{{ route('admin-booked-courts') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by court name" value="{{ old('search', $search) }}">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <!-- Booked Courts Table -->
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Court Name</th>
                <th>Booking Date</th>
                <th>Booking Time</th>
                <th>Booking Duration (Hours)</th>
                <th>Total Price (RM)</th>
                <th>Payment Method</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookedCourts as $booking)
                <tr>
                    <td>{{ $booking->court->name }}</td>
                    <td>{{ $booking->booking_date }}</td>
                    <td>{{ $booking->start_time }} - {{ $booking->end_time }}</td>
                    <td>{{ $booking->hours }}</td>
                    <td>{{ number_format($booking->totalPrice, 2) }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $booking->payment_method)) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No booked courts found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>