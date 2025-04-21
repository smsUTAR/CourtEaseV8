<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Court Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

@if(session('error'))
    <div class="alert alert-danger" id="error-alert">
        {{ session('error') }}
    </div>

    <script>
        setTimeout(function() {
            let alert = document.getElementById('error-alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 5000);
    </script>
@endif

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
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

<div class="container mt-4">
    <h1>{{ $court->name }}</h1>
    <h2>Court Details</h2>

    <div class="card">
        <div class="card-body">
        <img src="{{ asset('storage/' . $court->image) }}" alt="Court Image" class="img-fluid mb-3" style="max-height: 300px; object-fit: cover;">
            <p><strong>Status:</strong> {{ $court->status }}</p>

            <form id="rentForm" method="POST" action="{{ route('payment') }}">
                @csrf
                <input type="hidden" name="court_id" value="{{ $court->id }}">
                <input type="hidden" name="date" id="hidden_date">
                <input type="hidden" name="start_time" id="hidden_start_time">
                <input type="hidden" name="end_time" id="hidden_end_time">
                <input type="hidden" name="hours" id="hidden_hours">
                <input type="hidden" name="total" id="hidden_total">

                <label for="date">Date:</label>
                <input type="date" id="date" class="form-control mb-2" required onchange="fetchAvailability()">

                <label for="start_time">Start Time:</label>
                <input type="time" id="start_time" class="form-control mb-2" required>

                <label for="end_time">End Time:</label>
                <input type="time" id="end_time" class="form-control mb-2" required>

                <p><strong>Price per hour:</strong> RM{{ $court->price }}</p>
                <p><strong>Total Hours:</strong> <span id="total_hours">1</span></p>
                <p><strong>Total:</strong> RM <span id="total">{{ $court->price }}</span></p>

                <button id="rent_button" type="submit" class="btn btn-success" disabled>Rent</button>
            </form>
        </div>
    </div>

    <footer class="mt-4">
        <a href="#">Contact Us</a>
    </footer>
</div>

<script>
    let bookedSlots = [];

    function fetchAvailability() {
        const date = document.getElementById('date').value;
        const courtId = {{ $court->id }};

        if (!date) return;

        fetch(`/check-availability?court_id=${courtId}&date=${date}`)
            .then(response => response.json())
            .then(data => {
                bookedSlots = data;
                alertBookedSlots(); // Optional: show alert
                calculateTotal();   // Recalculate in case user selected time before date
            })
            .catch(error => {
                console.error('Error fetching availability:', error);
            });
    }

    function alertBookedSlots() {
        if (bookedSlots.length === 0) {
            alert("All time slots are available.");
        } else {
            let message = "Booked slots:\n";
            bookedSlots.forEach(slot => {
                message += `• ${slot.start_time} - ${slot.end_time}\n`;
            });
            alert(message);
        }
    }

    function calculateTotal() {
    const startTime = document.getElementById('start_time').value;
    const endTime = document.getElementById('end_time').value;
    const rentButton = document.getElementById('rent_button');

    // Disable by default
    rentButton.disabled = true;

    if (startTime && endTime) {
        const [startHour, startMin] = startTime.split(':').map(Number);
        const [endHour, endMin] = endTime.split(':').map(Number);

        const start = startHour + startMin / 60;
        const end = endHour + endMin / 60;
        const hours = end - start;

        if (hours <= 0) {
            alert("End time must be later than start time.");
            return;
        }

        // Check for overlap
        for (let slot of bookedSlots) {
            const [bStartHour, bStartMin] = slot.start_time.split(':').map(Number);
            const [bEndHour, bEndMin] = slot.end_time.split(':').map(Number);
            const bStart = bStartHour + bStartMin / 60;
            const bEnd = bEndHour + bEndMin / 60;

            if (start < bEnd && end > bStart) {
                alert(`❌ Selected time overlaps with a booking: ${slot.start_time} - ${slot.end_time}`);
                return;
            }
        }

        // No conflict — proceed
        const pricePerHour = {{ $court->price }};
        const total = hours * pricePerHour;

        document.getElementById('total_hours').innerText = hours.toFixed(2);
        document.getElementById('total').innerText = total.toFixed(2);
        document.getElementById('hidden_total').value = total.toFixed(2);
        document.getElementById('hidden_hours').value = hours.toFixed(2);
        document.getElementById('hidden_date').value = document.getElementById('date').value;
        document.getElementById('hidden_start_time').value = startTime;
        document.getElementById('hidden_end_time').value = endTime;

        // ✅ Enable only if all checks pass
        rentButton.disabled = false;
    }
}

    document.addEventListener('DOMContentLoaded', function () {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById("date").setAttribute('min', today);

        document.getElementById('start_time').addEventListener('change', calculateTotal);
        document.getElementById('end_time').addEventListener('change', calculateTotal);
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
