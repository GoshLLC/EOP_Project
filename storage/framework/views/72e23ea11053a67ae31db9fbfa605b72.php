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
                            
                            <!-- Intake for Staff and admin -->
                            <?php if(auth()->guard()->check()): ?>
                                <?php if(in_array(auth()->user()->role, ['staff','admin'])): ?>
                                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('animals.index')); ?>">Intake</a></li>
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

                            <?php if(auth()->guard()->check()): ?>
                                <?php if(auth()->user()->role === 'user'): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo e(route('wishlist.index')); ?>">
                                            Wishlist
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if(auth()->guard()->check()): ?>
                                <?php if(auth()->user()->role === 'admin'): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo e(route('admin.deletion.requests')); ?>">
                                            Deletion Requests
                                        </a>
                                    </li>
                                <?php endif; ?>
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

                            <!-- Fur Color -->
                            <label>Fur Color</label>
                            <select class="form-select mb-3" name="size">
                                <option value="">Any</option>
                                <option value="small">Black</option>
                                <option value="medium">Grey</option>
                                <option value="large">Brown</option>
                                <option value="large">Creame</option>
                                <option value="large">Mix</option>
                            </select>
                            
                            <?php if(auth()->guard()->check()): ?>
                                <?php if(in_array(auth()->user()->role, ['staff','admin','volunteer'])): ?>

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
                                <?php endif; ?>
                            <?php endif; ?> 
                            
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
            </div>
        </div>
    </header>        
</body>

</html><?php /**PATH C:\xampp\htdocs\laravel-login-system\resources\views/layouts/home.blade.php ENDPATH**/ ?>