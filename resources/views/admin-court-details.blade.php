<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Court Status</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .w-5 {
            display: none;
        }
    </style>
</head>
<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <img src="/icons/badminton.png" alt="Badminton Icon" width="50" height="50" class="me-2" >
        <a class="navbar-brand" href="{{ route('admin') }}">CourtEase Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
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

<!-- ✅ Main Content -->
<div class="container mt-5">
    <h1 class="mb-4">Manage Court Status</h1>

    @if(session('success'))
        <div class="alert alert-success" id="success-message">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('courts.updateStatus') }}" method="POST">
        @csrf
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courts as $court)
                <tr>
                    <td>{{ $court->name }}</td>
                    <td>
                        <select class="form-select" name="status[{{ $court->id }}]">
                            <option value="available" {{ $court->status == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="not_available" {{ $court->status == 'not_available' ? 'selected' : '' }}>Not Available</option>
                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <!-- Save Button -->
            <button type="submit" class="btn btn-primary" style="height: 40px;">Save</button>

            <!-- Pagination -->
            <div class="d-flex align-items-center ms-auto" style="transform: translateY(-2px);">
                <span class="me-3">
                    Showing {{ $courts->firstItem() }} to {{ $courts->lastItem() }} of {{ $courts->total() }} results
                </span>

                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item {{ $courts->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $courts->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $courts->lastPage(); $i++)
                            <li class="page-item {{ $i == $courts->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $courts->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li class="page-item {{ $courts->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $courts->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </form>
</div>

</div>
<script>
    // Hide the success message after 10 seconds (10000 milliseconds)
    setTimeout(function() {
        const message = document.getElementById('success-message');
        if (message) {
            message.style.display = 'none';
        }
    }, 10000);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>