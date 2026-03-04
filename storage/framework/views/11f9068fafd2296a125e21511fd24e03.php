

<?php $__env->startSection('content'); ?>

    <div class="container my-5">
        <h1 class="text-center mb-4">Pet Search Results</h1>

        <div class="mb-4 text-center">
            <p class="lead">
                <?php echo e($results->total()); ?> animal<?php echo e($results->total() !== 1 ? 's' : ''); ?> found
            </p>
        </div>

        <?php if($results->isEmpty()): ?>
            <div class="alert alert-info text-center py-5">
                <h4>No matching pets right now, according to your search criteria.</h4>
                <p>Check back at a later time. New friends arrive regularly!</p>
                <a href="<?php echo e(route('search')); ?>" class="btn btn-primary">Clear Filters</a>
            </div>
        <?php else: ?>
            <div class="row justify-content-center">
                <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <?php if($row->image): ?>
                                <img src="<?php echo e(asset('animal_photos/' . $row->image)); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo e($row->name); ?>" 
                                     style="height: 220px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo e($row->name); ?></h5>
                                <p class="card-text">
                                    <strong>Species:</strong> <?php echo e($row->species ?? 'Unknown'); ?><br>
                                    <?php if($row->breed): ?><strong>Breed:</strong> <?php echo e($row->breed); ?><br><?php endif; ?>
                                    <?php if($row->age !== null): ?><strong>Age:</strong> <?php echo e($row->age); ?><br><?php endif; ?>
                                    <?php if($row->location): ?><strong>Location:</strong> <?php echo e($row->location); ?><br><?php endif; ?>
                                    <strong>Status:</strong> 
                                    <span class="badge bg-success"><?php echo e($row->status); ?></span>
                                </p>
                                <a href="#" class="btn btn-outline-primary btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="d-flex justify-content-center mt-5">
                <?php echo e($results->links()); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel-login-system\resources\views/search.blade.php ENDPATH**/ ?>