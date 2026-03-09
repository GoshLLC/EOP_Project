<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>Eastern Oregon Pets</title>
</head>
<body class="bg-dark text-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Eastern Oregon Pets</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
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
                    <!-- Shown Only to Guests -->
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endguest
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
                        @if(auth()->user()->role === 'user')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('wishlist.index') }}">
                                    Wishlist
                                </a>
                            </li>
                        @endif
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

    <!-- Background Image -->
    <section class="position-relative min-vh-100 d-flex justify-content-center" style="
        background-image: url('/assets/img/bg-masthead.jpg'); /* ← add leading / if in public/assets */
        background-size: cover;
        background-position: center;"
     >

        <!-- Centered Content -->
        <div class="container position-relative z-2 py-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8">
                    <form action="{{ route('search') }}" method="get" class="d-flex flex-column flex-md-row gap-3 ">
                        <input class="form-control form-control-lg" type="search" name="q" placeholder="Search for pets..." aria-label="Search">
                        <button class="btn btn-primary btn-md rounded-pill px-5" type="submit">Search</button>
                        <button class="btn btn-secondary btn-md rounded-pill px-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterPanel">Filters ☰</button>                             
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Options -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filterPanel">
        <div class="offcanvas-header">
            <h5>Search Filters</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('search') }}" method="get">
                <!-- Search -->
                <input class="form-control mb-3" type="search" name="q" placeholder="Search">
                <!-- Species -->
                <label>Species</label>
                <select class="form-select mb-3" name="species">
                    <option value="">Any</option>
                    <option value="dog">Dog</option>
                    <option value="cat">Cat</option>
                    <option value="other">Other</option>
                </select>
                <!-- Location -->
                <label>Location</label>
                <input class="form-control mb-3" type="text" name="location">
                <!-- Age -->
                <label>Age</label>
                <input class="form-control mb-3" type="number" name="age">
                <!-- Size -->
                <label>Size</label>
                <select class="form-select mb-3" name="size">
                    <option value="">Any</option>
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                </select>
                <!-- Fur Color -->
                <label>Fur Color</label>
                <select class="form-select mb-3" name="fur_color">
                    <option value="">Any</option>
                    <option value="Black">Black</option>
                    <option value="Brown">Grey</option>
                    <option value="Cream">Brown</option>
                    <option value="mix">Mix</option>
                    <option value="other">Other</option>
                </select>

                @auth
                    @if(in_array(auth()->user()->role, ['staff','admin','volunteer']))

                        <!-- Health Status -->
                        <label>Health Status</label>
                        <select class="form-control mb-3" name="health_status">
                            <option value="">Any</option>
                            <option value="healthy">Healthy</option>
                            <option value="needs care">Needs Care</option>
                            <option value="critical">Critical</option>
                        </select>

                        <!-- Vaccine Status -->
                        <label>Vaccine Status</label>
                        <select class="form-control mb-3" name="vaccine_status">
                            <option value="">Any</option>
                            <option value="up_to_date">Up to Date</option>
                            <option value="not_up_to_date">Not Up to Date</option>
                        </select>
                        <label>Intake Date From</label>
                            <input type="date" name="intake_date_from" class="form-control mb-2">
                        <label>Intake Date To</label>
                            <input type="date" name="intake_date_to" class="form-control mb-3">
                    @endif
                @endauth 

                	<div class="col-md-3 mb-3">
                    	<label class="form-label">Sort</label>
                    	<select name="sort" class="form-control">
                        	<option value="asc">Name (A → Z)</option>
                        	<option value="desc">Name (Z → A)</option>
                        	<option value="age_asc">Age Low-High</option>
                        	<option value="age_desc">Age High-Low</option>
                    	</select>
                	</div>
                    
                <button class="btn btn-primary w-100" type="submit">Apply Filters</button>
            </form>
        </div>
    </div>
</body>
</html>