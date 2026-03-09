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
    
                       	<!-- Shown Only to Admin -->
                    @auth
                        @if (auth()->user()->role === 'admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.create') }}">Admin</a></li>
                        @endif
                    @endauth
        
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
                </ul>
            </div>
        </div>
    </nav>

<div class="container my-5">
    <h1>Deletion Requests</h1>

    @if($requests->isEmpty())
        <p>No requests.</p>
    @else
        <div class="row">
            @foreach($requests as $req)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        @if($req->animal && $req->animal->image)
                            <img src="{{ asset('animal_photos/' . $req->animal->image) }}"
                                 class="card-img-top"
                                 style="height:200px;object-fit:cover;">
                        @endif

                        <div class="card-body">

                            <h5>{{ $req->animal->name ?? 'Unknown' }}</h5>
                            <p><strong>Status:</strong> {{ ucfirst($req->status) }}</p>
                            <p><strong>Reason:</strong> {{ $req->reason ?? '-' }}</p>

                            @if($req->status === 'pending')
                                <form action="{{ route('deletion.approve', $req->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm">
                                        Approve (Delete)
                                    </button>
                                </form>

                                <form action="{{ route('deletion.reject', $req->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">
                                        Decline
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($req->status) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
