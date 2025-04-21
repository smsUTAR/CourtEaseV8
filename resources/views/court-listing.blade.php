<!DOCTYPE html>
<html lang="en">
<head>
  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to CourtEase</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

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

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <img src="/icons/badminton.png" alt="Badminton Icon" width="50" height="50" class="me-2" >
        <a class="navbar-brand" href="{{ route('court-listing') }}">Welcome to CourtEase!</a>
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

<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
        <img src="https://static.wixstatic.com/media/3f4fbc_10b79366c3534805808474cd874301ab~mv2.png/v1/fill/w_1403,h_687,al_c,q_90,usm_0.66_1.00_0.01,enc_auto/3f4fbc_10b79366c3534805808474cd874301ab~mv2.png" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Badminton Image 1">
        </div>
        <div class="carousel-item">
        <img src="https://images.unsplash.com/photo-1708312604109-16c0be9326cd?q=80&w=2574&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Badminton Image 2">
        </div>
        <div class="carousel-item">
        <img src="https://images.unsplash.com/photo-1633313236093-beebdd1a5e80?q=80&w=2579&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Badminton Image 3">
        </div>
        <div class="carousel-item">
        <img src="https://images.unsplash.com/photo-1708312604093-bafcb2fd6e69?q=80&w=2574&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Badminton Image 4">
        </div>
        <div class="carousel-item">
        <img src="https://images.unsplash.com/photo-1708312604124-0a5ee3381273?q=80&w=2574&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Badminton Image 5">
        </div>
        <div class="carousel-item">
        <img src="https://wallpaperaccess.com/full/1429518.jpg" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Badminton Image 6">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
    </div>

<div class="container mt-4">

    

    <h2>Court Listing</h2>

    <div class="row">
    @forelse($availableCourts as $court)
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $court->name }}</h5>
                <a href="{{ route('court-details', ['id' => $court->id]) }}" class="btn btn-warning">View Details</a>
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
                        <th>Booking Time</th>
                        <th>Hours</th>
                        <th>Total Price (RM)</th>
                        <th>Payment Method</th>
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach($userBookings as $booking)
                        <tr>
                            <td>{{ $booking->court->name }}</td>
                            <td>{{ $booking->booking_date }}</td>
                            <td>{{ $booking->start_time}} - {{$booking->end_time}}</td>
                            <td>{{ $booking->hours }}</td>
                            <td>{{ number_format($booking->totalPrice, 2) }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $booking->payment_method)) }}</td>
                            <td>
                                <form method="POST" action="{{ route('booking.destroy', $booking->id) }}" class="d-inline" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>

    <script>
        // Hide the success alert after 5 seconds
        setTimeout(function() {
            let alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 5000);
    </script>
@endif
</div>

@include('components.contactUs')

<script>
    function confirmDelete(event) {
        event.preventDefault(); // Prevent immediate form submit

        if (confirm("Are you sure you want to delete this booking?")) {
            alert("Booking successfully deleted. The money will be refunded soon.");
            event.target.submit(); // Proceed with form submission
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
