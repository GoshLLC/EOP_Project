<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body id="page-top">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>">Eastern Oregon Pets</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                            <!-- Shown Only to Admin -->
                            <?php if(auth()->guard()->check()): ?>
                                <?php if(auth()->user()->role === 'admin'): ?>
                                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('admin.create')); ?>">Admin</a></li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <!-- Shown Only to Guests -->
                            <?php if(auth()->guard()->guest()): ?>
                                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('login')); ?>">Login</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('register')); ?>">Register</a></li>
                            <?php endif; ?>

                            <!-- Logged-in links + Logout -->
                            <?php if(auth()->guard()->check()): ?>
                                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('profile.edit')); ?>">My Profile</a></li>
                                <li class="nav-item">
                                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline m-0">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="nav-link shadow-none focus:shadow-none">Logout</button>
                                    </form>
                                </li>
                            <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Masthead-->
    <header class="masthead">
        <div class="container px-4 px-lg-5 d-flex h-100 justify-content-center align-items-start" style="padding-top: 5rem;">
            <div class="w-100" style="max-width: 600px;">

                <!-- Search -->
                <form action="<?php echo e(route('search')); ?>" method="get" class="d-flex">

                    

                    <input class="form-control me-2" type="search" name="q" placeholder="Search for pets" aria-label="Search">
                    
                    <button class="btn btn-primary rounded-pill ms-2" type="submit">Search</button>

                    <!-- Filter Button -->
                    <button class="btn btn-dark rounded-pill ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterPanel">☰</button>
                </form>

                <!-- Filter Options -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="filterPanel">
                    <div class="offcanvas-header">
                        <h5>Search Filters</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>

                    <div class="offcanvas-body">

                        <form action="<?php echo e(route('search')); ?>" method="get">

                            <!-- Search -->
                            <input class="form-control mb-3" type="search" name="q" placeholder="Search">

                            <!-- Species -->
                            <label>Species</label>
                            <select class="form-select mb-3" name="species">
                                <option value="">Any</option>
                                <option value="dog">Dog</option>
                                <option value="cat">Cat</option>
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

                            <button class="btn btn-primary w-100" type="submit">Apply Filters</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </header>        
</body>

</html><?php /**PATH C:\xampp\htdocs\laravel-login-system\resources\views/layouts/home.blade.php ENDPATH**/ ?>