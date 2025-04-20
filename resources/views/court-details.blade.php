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
                    <a class="nav-link" href="{{ route('welcome') }}">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h1>Court {{ $id }}</h1>
    <h2>Court Details</h2>

    <div class="card">
        <div class="card-body">
            <img src="https://via.placeholder.com/400x200" alt="Court Image" class="img-fluid">
            <p><strong>Status:</strong> <span>Available / Not available</span></p>
            
            <label for="date">Date:</label>
            <input type="date" id="date" class="form-control mb-2">
            
            <label for="hours">Hours:</label>
            <input type="number" id="hours" class="form-control mb-2" min="1" value="1" oninput="calculateTotal()">
            
            <p><strong>Price per hour:</strong> RM4</p>
            <p><strong>Total:</strong> RM <span id="total">4</span></p>
            
            <a href="{{ route('payment', ['court' => $id]) }}" class="btn btn-success">Rent</a>
            
        </div>
    </div>

    <footer class="mt-4">
        <a href="contact">Contact Us</a>
    </footer>
</div>

<script>
    function calculateTotal() {
        let hours = document.getElementById('hours').value;
        let pricePerHour = 4;
        let total = hours * pricePerHour;
        document.getElementById('total').innerText = total;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
