

<?php $__env->startSection('content'); ?>
<div class="container my-5">

    <h1>Edit Animal</h1>

    <form action="<?php echo e(route('animals.update', $animal->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control"
                   value="<?php echo e($animal->name); ?>" required>
        </div>

        <div class="mb-3">
            <label>Species</label>
            <input type="text" name="species" class="form-control"
                   value="<?php echo e($animal->species); ?>" required>
        </div>

        <div class="mb-3">
            <label>Breed</label>
            <input type="text" name="breed" class="form-control"
                   value="<?php echo e($animal->breed); ?>">
        </div>

        <div class="mb-3">
            <label>Sex</label>
            <input type="text" name="sex" class="form-control"
                   value="<?php echo e($animal->sex); ?>">
        </div>

        <div class="mb-3">
            <label>Age</label>
            <input type="number" name="age" class="form-control"
                   value="<?php echo e($animal->age); ?>">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="available" <?php echo e($animal->status=='available'?'selected':''); ?>>Available</option>
                <option value="pending" <?php echo e($animal->status=='pending'?'selected':''); ?>>Pending</option>
                <option value="adopted" <?php echo e($animal->status=='adopted'?'selected':''); ?>>Adopted</option>
                <option value="hold" <?php echo e($animal->status=='hold'?'selected':''); ?>>On Hold</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control"
                   value="<?php echo e($animal->location); ?>">
        </div>

        <div class="mb-3">
            <label>Health Status</label>
            <input type="text" name="health_status" class="form-control"
                   value="<?php echo e($animal->health_status); ?>">
        </div>

        <div class="mb-3">
            <label>Fur Color</label>
            <input type="text" name="fur_color" class="form-control"
                   value="<?php echo e($animal->fur_color); ?>">
        </div>

        <div class="mb-3">
            <label>Size</label>
            <input type="text" name="size" class="form-control"
                   value="<?php echo e($animal->size); ?>">
        </div>

        <div class="mb-3">
            <label>Spayed/Neutered</label>
            <select name="spayed_neutered" class="form-control">
                <option value="yes" <?php echo e($animal->spayed_neutered=='yes'?'selected':''); ?>>Yes</option>
                <option value="no" <?php echo e($animal->spayed_neutered=='no'?'selected':''); ?>>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Vaccine Status</label>
            <select name="vaccine_status" class="form-control">
                <option value="up_to_date" <?php echo e($animal->vaccine_status=='up_to_date'?'selected':''); ?>>Up to Date</option>
                <option value="not_up_to_date" <?php echo e($animal->vaccine_status=='not_up_to_date'?'selected':''); ?>>Not Up to Date</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Intake Date</label>
            <input type="date" name="intake_date" class="form-control"
                   value="<?php echo e($animal->intake_date); ?>" required>
        </div>

        <button class="btn btn-primary">Save Changes</button>
    </form>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel-login-system\resources\views/animaledit.blade.php ENDPATH**/ ?>