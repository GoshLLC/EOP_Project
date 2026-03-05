

<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <h1>Deletion Requests</h1>

    <?php if($requests->isEmpty()): ?>
        <p>No requests.</p>
    <?php else: ?>
        <div class="row">
            <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php if($req->animal && $req->animal->image): ?>
                            <img src="<?php echo e(asset('animal_photos/' . $req->animal->image)); ?>"
                                 class="card-img-top"
                                 style="height:200px;object-fit:cover;">
                        <?php endif; ?>

                        <div class="card-body">

                            <h5><?php echo e($req->animal->name ?? 'Unknown'); ?></h5>
                            <p><strong>Status:</strong> <?php echo e(ucfirst($req->status)); ?></p>
                            <p><strong>Reason:</strong> <?php echo e($req->reason ?? '-'); ?></p>

                            <?php if($req->status === 'pending'): ?>
                                <form action="<?php echo e(route('deletion.approve', $req->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button class="btn btn-success btn-sm">
                                        Approve (Delete)
                                    </button>
                                </form>

                                <form action="<?php echo e(route('deletion.reject', $req->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button class="btn btn-danger btn-sm">
                                        Decline
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?php echo e(ucfirst($req->status)); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel-login-system\resources\views/admin/deletion-requests.blade.php ENDPATH**/ ?>