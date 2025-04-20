<!-- booking-confirmation.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1>Booking Confirmation</h1>

    @php
        $courtId = request()->get('court');
        $date = request()->get('date');
        $hours = request()->get('hours', 1);
        $pricePerHour = 4;
        $total = $hours * $pricePerHour;
    @endphp

    <div class="card">
        <div class="card-body">
            <p><strong>Court ID:</strong> {{ $courtId }}</p>
            <p><strong>Date:</strong> {{ $date }}</p>
            <p><strong>Hours:</strong> {{ $hours }}</p>
            <p><strong>Price per hour:</strong> RM{{ $pricePerHour }}</p>
            <p><strong>Total:</strong> RM{{ $total }}</p>
        </div>
    </div>

    <a href="{{ route('court-listing') }}" class="btn btn-primary mt-3">Back to Courts</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
