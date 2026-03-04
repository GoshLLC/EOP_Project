<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eastern Oregon Pets - <?php echo $__env->yieldContent('title'); ?></title>

    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <?php echo $__env->yieldPushContent('styles'); ?> <!-- optional: for page-specific CSS -->

</head>
<body>

    <!-- Navbar – put it here once -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>">Eastern Oregon Pets</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Admin link -->
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->role === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.create')); ?>">Admin</a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('home')); ?>">Home</a></li>

                    <!-- Guest links -->
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content area – pages will fill this -->
    <main class="py-4">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Scripts at the bottom -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php echo $__env->yieldPushContent('scripts'); ?> <!-- optional: page-specific JS -->

</body>
</html><?php /**PATH C:\xampp\htdocs\laravel-login-system\resources\views/layouts/app.blade.php ENDPATH**/ ?>