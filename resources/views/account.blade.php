<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Dashboard | CourtEase</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }

        .sidebar .nav-link {
            color: #ffffff;
        }

        .sidebar .nav-link:hover {
            background-color: #495057;
        }

        .content-wrapper {
            padding: 2rem;
        }

        .form-collapse-container {
            position: relative;
        }

        .form-collapse-container .collapse {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 10;
        }

        .btn-collapse {
            z-index: 20;
            width: 100%;
            margin-bottom: 10px;
        }

        .collapse.show {
            z-index: 20;
        }
    </style>
</head>
<body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Auto-open password form if there are errors
        if ({{ $errors->has('current_password') || $errors->has('new_password') || $errors->has('new_password_confirmation') ? 'true' : 'false' }}) {
            const passwordForm = new bootstrap.Collapse(document.getElementById('passwordForm'), {
                toggle: true // This will open the collapse
            });
        }

        // Auto-open profile form if there are errors
        if ({{ $errors->has('birthdate') || $errors->has('gender') || $errors->has('phone') || $errors->has('profile_pic') ? 'true' : 'false' }}) {
            const profileForm = new bootstrap.Collapse(document.getElementById('profileForm'), {
                toggle: true // This will open the collapse
            });
        }
    });
</script>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block sidebar px-3 py-4">
            <h4 class="text-white mb-4">CourtEase</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('court-listing') }}"><i class="bi bi-house-door me-2"></i>Home</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('account') }}"><i class="bi bi-person-circle me-2"></i>Account</a>
                </li>
                <li class="nav-item mb-2">
                    <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Are you sure you want to logout?')">
                        @csrf
                        <input type="hidden" name="is_admin" value="{{ session('is_admin') ? 1 : 0 }}">
                        <button type="submit" class="btn btn-outline-light w-100">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 content-wrapper">
            <h2 class="mb-4">Account Details</h2>

            <!-- Success message -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card mb-4">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img 
                            src="{{ $user->profile_pic ? asset($user->profile_pic) : asset('images/default-avatar.png') }}" 
                            alt="Profile Picture" 
                            class="rounded-circle shadow-sm border" 
                            width="120"
                        >
                    </div>

                    <h5>Name:</h5>
                    <p>{{ $user->name }}</p>

                    <h5>Email:</h5>
                    <p>{{ $user->email }}</p>

                    @if ($user->birthdate)
                        <h5>Birthdate:</h5>
                        <p>{{ \Carbon\Carbon::parse($user->birthdate)->format('F d, Y') }}</p>
                    @endif

                    @if ($user->phone)
                        <h5>Phone Number:</h5>
                        <p>{{ $user->phone }}</p>
                    @endif

                    @if ($user->gender)
                        <h5>Gender:</h5>
                        <p class="text-capitalize">{{ $user->gender }}</p>
                    @endif
                </div>
            </div>

            <!-- Flex container for buttons -->
            <div class="d-flex flex-wrap gap-2 mb-3">
                <div>
                    <button class="btn btn-outline-primary btn-collapse w-100" style="width: 160px;" type="button"
                        data-bs-toggle="collapse" data-bs-target="#passwordForm"
                        aria-expanded="{{ session('passwordFormOpen') ? 'true' : 'false' }}"
                        aria-controls="passwordForm">
                        <i class="bi bi-lock me-1"></i>Change Password
                    </button>
                </div>
                <div>
                    <button class="btn btn-outline-primary btn-collapse w-100" style="width: 160px;" type="button"
                        data-bs-toggle="collapse" data-bs-target="#profileForm"
                        aria-expanded="{{ session('profileFormOpen') ? 'true' : 'false' }}"
                        aria-controls="profileForm">
                        <i class="bi bi-person-gear me-1"></i>Update Profile
                    </button>
                </div>
            </div>

            <!-- Accordion Container -->
            <div class="accordion form-collapse-container mt-3" id="formAccordion">

                <!-- Password Collapse -->
                <div>
                    <div id="passwordForm" class="accordion-collapse collapse {{ session('passwordFormOpen') ? 'show' : '' }}" data-bs-parent="#formAccordion">
                        <div class="card">
                            <div class="card-header">
                                Change Password
                            </div>
                            <div class="card-body">
                                <form action="{{ route('account.updatePassword') }}" method="POST">
                                    @csrf

                                    <!-- Current Password -->
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <input type="password" name="current_password" id="current_password" class="form-control" required>
                                        @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <!-- New Password -->
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                                        @if ($errors->has('new_password'))
                                            @foreach ($errors->get('new_password') as $message)
                                                <small class="text-danger d-block">{{ $message }}</small>
                                            @endforeach
                                        @endif
                                    </div>

                                    <!-- Confirm New Password -->
                                    <div class="mb-3">
                                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                                    </div>

                                    <button type="submit" class="btn btn-dark">Update Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Update Section -->
                <div>
                    <div id="profileForm" class="accordion-collapse collapse {{ session('profileFormOpen') ? 'show' : '' }}" data-bs-parent="#formAccordion">
                        <div class="card">
                            <div class="card-header">Update Profile</div>
                            <div class="card-body">
                                <form action="{{ route('account.updateProfile') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Birthdate -->
                                    <div class="mb-3">
                                        <label for="birthdate" class="form-label">Birthdate</label>
                                        <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate', $user->birthdate) }}" class="form-control">
                                        @error('birthdate') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <!-- Gender -->
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select name="gender" id="gender" class="form-select">
                                            <option value="">-- Select --</option>
                                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
                                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <!-- Profile Picture -->
                                    <div class="mb-3">
                                        <label for="profile_pic" class="form-label">Profile Picture</label><br>
                                        @if ($user->profile_pic)
                                            <img src="{{ asset($user->profile_pic) }}" alt="Profile" class="rounded-circle mb-2" style="width: 100px; height: 100px;">
                                        @endif
                                        <input type="file" name="profile_pic" id="profile_pic" class="form-control">
                                        @error('profile_pic') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <button type="submit" class="btn btn-success">Update Profile</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- End Profile Collapse -->
            </div><!-- End Form Collapse Container -->
        </main>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
