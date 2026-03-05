

<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <h1>Your Wishlist</h1>

    <?php if($animals->isEmpty()): ?>
        <p>No saved pets yet.</p>
    <?php else: ?>
        <div class="row">
            <?php $__currentLoopData = $animals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php if($row->image): ?>
                            <img src="<?php echo e(asset('animal_photos/' . $row->image)); ?>"
                                 class="card-img-top"
                                 style="height:200px;object-fit:cover;">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5><?php echo e($row->name); ?></h5>
                            <p><?php echo e($row->species); ?></p>
<form action="<?php echo e(url('/wishlist/' . $row->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
    <button type="submit" class="btn btn-outline-danger btn-sm">
        Remove
    </button>
</form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel-login-system\resources\views/wishlist.blade.php ENDPATH**/ ?>