<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Court</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

<div class="container mt-4">
    <h2>Manage Courts</h2>

    @if($courts->isEmpty())
        <p>No courts available to manage.</p>
    @else
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Court Name</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courts as $court)
                        <tr>
                            <td>{{ $court->name }}</td>
                            <td>
                                @if($court->image)
                                    <img src="{{ asset('storage/' . $court->image) }}" alt="Court Image"
                                         style="max-height: 150px; width: auto;">
                                @else
                                    <span>No image</span>
                                @endif
                            </td>
                            <td>
                            <a href="{{ route('admin-court-manage.editCourt', $court->id) }}" class="btn btn-primary btn-sm">Edit</a>

                                <form action="{{ route('admin-court-manage.destroyCourt', $court->id) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Are you sure you want to delete this court?')">
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
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) alert.style.display = 'none';
            }, 5000);
        </script>
    @endif
</div>

</body>
</html>