<!DOCTYPE html>
<html lang="en">
    <head>
<link rel="stylesheet" href="/css/styles.css">
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Eastern Oregon Pets</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                        <!-- Shown Only to Admin -->
                        @auth
                            @if (auth()->user()->role === 'admin')
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.create') }}">Admin</a></li>
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
                </li>
            </ul>
        </div>
    </div>
</nav>


    <body id="page-top">
        <!-- Masthead-->
        <header class="masthead">
            <div class="container px-4 px-lg-5 d-flex h-100 justify-content-center align-items-start" style="padding-top: 5rem;">
                <div class="w-100" style="max-width: 600px;">
                    
                    <!-- Search -->
                    <form action="{{ route('search') }}" method="get" class="d-flex">
                        <input class="form-control me-2" type="search" name="q" placeholder="Search for pets" aria-label="Search">
                        <button class="btn btn-primary rounded-pill ms-2" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </header>        
        </body>

</html>