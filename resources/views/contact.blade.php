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

<div class="container">
    <div class="header">
        <h1>Contact Us</h1>
    </div>

    <div class="contact-us">
        <h2>Contact us if you need our assistance!</h2>
        <h3>Phone Number: Whatsapp 012-3358492</h3>
        <h3>Email: courtease@gmail.com</h3>
    </div>

    <div class="footer-buttons">
            <a href="{{ route('contact') }}" class="btn btn-contact">Contact Us</a>
    </div>
</div>

</body>
</html>


<style>
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
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

