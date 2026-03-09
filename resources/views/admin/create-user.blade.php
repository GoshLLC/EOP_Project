<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>Eastern Oregon Pets</title>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Eastern Oregon Pets</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
        
                    <!-- Intake for Staff and admin -->
                    @auth
                        @if(in_array(auth()->user()->role, ['staff','admin']))
                            <li class="nav-item"><a class="nav-link" href="{{ route('animals.index') }}">Intake</a></li>
                        @endif
                    @endauth

                    <!-- Logged-in links + Logout -->
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">My Profile</a></li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline m-0">
                                @csrf
                                <button type="submit" class="nav-link shadow-none focus:shadow-none">Logout</button>
                            </form>
                        </li>
                    @endauth

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.deletion.requests') }}">
                                    Deletion Requests
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

<div class="container mt-1 text-center">

    <h2>Create New User</h2>

<form method="POST" action="{{ url('admin/create-user') }}" class="row g-3 mb-5">
    @csrf

    <div class="col-12 col-sm-6 col-md-4">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <input type="email" name="email" class="form-control" placeholder="Email" required>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <select name="role" class="form-select" required>
            <option value="" disabled selected>Select Role</option>
            <option value="user">User</option>
            <option value="staff">Staff</option>
            <option value="volunteer">Volunteer</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-end">
        <button class="btn btn-primary w-100" type="submit">Create Account</button>
    </div>
</form>

    <hr>

    <h2>Existing Users</h2>

    <div class="table-responsive d-flex justify-content-center">
        <table class="table table-bordered table-striped text-center w-auto">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Registered</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->registered }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.user.delete', $user->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit"
                            onclick="return confirm('Delete this user?')">
                            Delete
                        </button>
                        </form>
                     </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
