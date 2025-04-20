<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Court Prices - CourtEase</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('admin') }}">Admin Panel</a>
        <div class="collapse navbar-collapse">
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
    <h2 class="mb-4 text-center">Price Change (Change for all courts)</h2>

    @if(session('success'))
        <div class="alert alert-success" id="successMessage">{{ session('success') }}</div>
    @endif

    <form action="{{ route('courts.updatePrice') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Original price per hour:</label>
            <div class="input-group">
                <span class="input-group-text">RM</span>
                <input type="text" class="form-control" value="{{ number_format($originalPrice, 2) }}" disabled>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Now price per hour:</label>
            <div class="input-group">
                <span class="input-group-text">RM</span>
                <input type="number" name="new_price" class="form-control" step="0.01" min="0" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Change</button>
    </form>
</div>

<script>
    setTimeout(function () {
        const msg = document.getElementById('successMessage');
        if (msg) msg.style.display = 'none';
    }, 10000);
</script>

</body>
</html>
