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
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('home')); ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('profile')); ?>">Profile</a></li>
                <li class="nav-item">
                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline m-0">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="nav-link shadow-none focus:shadow-none">Logout</button></form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-1 text-center">

    <h2>Create New User</h2>

    <form method="POST" action="<?php echo e(url('admin/create-user')); ?>" class="d-flex justify-content-center gap-2 mb-4">
        <?php echo csrf_field(); ?>

        <input type="text" name="username" class="form-control w-auto" placeholder="Username" required>
        <input type="email" name="email" class="form-control w-auto" placeholder="Email" required>
        <input type="password" name="password" class="form-control w-auto" placeholder="Password" required>

        <select name="role" class="form-select w-auto" required>
            <option value="user">User</option>
            <option value="staff">Staff</option>
            <option value="volunteer">Volunteer</option>
            <option value="admin">Admin</option>
        </select>

        <button class="btn btn-primary" type="submit">Create Account</button>
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
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($user->id); ?></td>
                    <td><?php echo e($user->username); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td><?php echo e($user->role); ?></td>
                    <td><?php echo e($user->registered); ?></td>
                    <td>
                        <form method="POST" action="<?php echo e(route('admin.user.delete', $user->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-danger btn-sm" type="submit"
                            onclick="return confirm('Delete this user?')">
                            Delete
                        </button>
                        </form>
                     </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

</div>
<?php /**PATH C:\xampp\htdocs\laravel-login-system\resources\views/admin/create-user.blade.php ENDPATH**/ ?>