<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to CourtEase</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color:rgb(88, 120, 167); /* or any other color you want */
        }
        .center-buttons {
            min-height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 20px;
        }
        .btn-blue {
            background-color:rgb(238, 202, 84);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 15px;
            font-size: 25px;
            width: 40%;
            
        }
        .btn-blue:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<!-- ✅ Responsive Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <img src="/icons/badminton.png" alt="Badminton Icon" width="50" height="50" class="me-2" >
        <a class="navbar-brand" href="{{ route('admin') }}">CourtEase Admin Panel</a>
        
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

<!-- ✅ Centered Buttons -->
<div class="container center-buttons">
    <a href="{{ url('admin-court') }}" class="btn btn-blue">Court Status</a>
    <a href="{{ url('admin-adjust-pricing') }}" class="btn btn-blue">Adjust Pricing</a>
    <a href="{{ url('admin-court/create') }}" class="btn btn-blue">Add New Court</a> 
    <a href="{{ route('admin-court-manage.showManageCourt') }}" class="btn btn-blue">Manage Courts</a>
    <a href="{{ route('admin-booked-courts') }}" class="btn btn-blue">Booked Court</a>
</div>

<!-- Bootstrap Bundle JS (for toggler) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
