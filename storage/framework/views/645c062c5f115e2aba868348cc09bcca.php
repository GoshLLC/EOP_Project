<link rel="stylesheet" href="/css/styles.css">
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?php echo e(route('home')); ?>">Eastern Oregon Pets</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('home')); ?>">Home</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="login">

<div class="container d-flex justify-content-center">
    <div class="card p-4 mt-5" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4">Login</h2>

        <form action="<?php echo e(route('login')); ?>" method="post">

            <?php echo csrf_field(); ?>

            <div class="mb-3">
                <label class="form-label" for="username">Username</label>
                <input class="form-control" type="text" name="username" id="username"
                       value="<?php echo e(old('username')); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input class="form-control" type="password" name="password" id="password" required>
            </div>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div><?php echo e($error); ?></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary w-100">Login</button>

            <p class="text-center mt-3">
                Don't have an account?
                <a href="<?php echo e(route('register')); ?>">Register</a>
            </p>

        </form>
    </div>
</div>

<?php /**PATH C:\xampp\htdocs\laravel-login-system\resources\views/layouts/login.blade.php ENDPATH**/ ?>