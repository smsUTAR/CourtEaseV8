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
    <h1>Court {{ $court->id }}</h1>
    <h2>Court Details</h2>

    <div class="card">
    <div class="card-body">
        <img src="{{ asset('storage/' . $court->image) }}" alt="Court Image" class="img-fluid mb-3" style="max-height: 300px; object-fit: cover;">
        <p><strong>Status:</strong> {{ $court->status }}</p>

        <form id="rentForm" method="POST" action="{{ route('payment') }}">
            @csrf
            <input type="hidden" name="court_id" value="{{ $court->id }}">
            <input type="hidden" name="date" id="hidden_date">
            <input type="hidden" name="hours" id="hidden_hours">
            <input type="hidden" name="total" id="hidden_total">

            <label for="date">Date:</label>
            <input type="date" id="date" class="form-control mb-2" required onchange="updateHiddenFields()">

            <label for="hours">Hours:</label>
            <input type="number" id="hours" class="form-control mb-2" min="1" value="1" required oninput="calculateTotal()">

            <p><strong>Price per hour:</strong> RM{{ $court->price }}</p>
            <p><strong>Total:</strong> RM <span id="total">{{ $court->price }}</span></p>

            <button type="submit" class="btn btn-success">Rent</button>
        </form>
    </div>
</div>

    <footer class="mt-4">
        <a href="#">Contact Us</a>
    </footer>
</div>

<script>
function calculateTotal() {
    let hours = document.getElementById('hours').value;
    let pricePerHour = {{ $court->price }};
    let total = hours * pricePerHour;

    document.getElementById('total').innerText = total;

    // Update hidden fields
    document.getElementById('hidden_total').value = total;
    document.getElementById('hidden_hours').value = hours;
    document.getElementById('hidden_date').value = document.getElementById('date').value;
}

document.addEventListener('DOMContentLoaded', function () {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById("date").setAttribute('min', today);

    // Set initial values
    calculateTotal();
});

document.getElementById('date').addEventListener('change', function () {
    document.getElementById('hidden_date').value = this.value;
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
