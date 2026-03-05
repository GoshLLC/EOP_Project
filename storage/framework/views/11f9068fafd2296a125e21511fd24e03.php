

<?php $__env->startSection('content'); ?>

<div class="container" style="max-width: 700px";>
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


    <div class="container my-5">
        <h1 class="text-center mb-4">Pet Search Results</h1>

        <div class="mb-4 text-center">
            <p class="lead">
                <?php echo e($results->total()); ?> animal<?php echo e($results->total() !== 1 ? 's' : ''); ?> found
            </p>
        </div>

        <div class="toast-container">
               
        
        <?php if(session('success')): ?>
            <div id="flash-message" class="alert alert-success text-center">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('info')): ?>
            <div id="flash-message" class="alert alert-info text-center">
                <?php echo e(session('info')); ?>

            </div>
        <?php endif; ?>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const message = document.getElementById('flash-message');
            if (message) {
                setTimeout(() => {
                    message.style.transition = "opacity 0.5s";
                    message.style.opacity = "0";
                    setTimeout(() => message.remove(), 500);
                }, 2000);
            }
        });
        </script>

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
                 style="height:200px;object-fit:cover; cursor:pointer;"
                 onclick="showImage(this.src)"
                 data-bs-toggle="modal"
                 data-bs-target="#imageModal">
        <?php endif; ?>

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0"><?php echo e($row->name); ?></h5>
                                <?php if(auth()->guard()->check()): ?>
                                <?php if(auth()->user()->role === 'user'): ?>
                                    <?php
                                        $wishlisted = DB::table('wishlists')
                                            ->where('user_id', auth()->id())
                                            ->where('animal_id', $row->id)
                                            ->exists();
                                    ?>
                                    <?php if($wishlisted): ?>
                                        <form action="<?php echo e(route('wishlist.destroy', $row->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button class="btn btn-outline-danger btn-sm">
                                                Remove
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('wishlist.store', $row->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button class="btn btn-outline-primary btn-sm">
                                                Wishlist
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php endif; ?>
                            </div>
                                <div class="row small"> 
                                    <!-- LEFT COLUMN -->
                                    <div class="col-6">
                                        <strong>Species:<?php echo e(ucfirst($row->species ?? 'Unknown')); ?></strong><br>
                                        <strong>Breed: <?php echo e(ucfirst($row->breed ?? '-')); ?></strong><br>
                                        <strong>Age: <?php echo e(ucfirst($row->age ?? '-')); ?></strong><br>
                                        <strong>Location: <?php echo e(ucfirst($row->location ?? '-')); ?></strong><br>

                                        <?php if(auth()->guard()->check()): ?>
                                            <?php if(in_array(auth()->user()->role, ['staff','admin','volunteer'])): ?>
                                                <strong>Health: <?php echo e(ucfirst($row->health_status ?? '-')); ?></strong><br>
                                                <strong>Intake: <?php echo e($row->intake_date ?? '-'); ?></strong><br>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if(auth()->guard()->check()): ?>
                                            <?php if(auth()->user()->role === 'admin'): ?>
                                                <a href="<?php echo e(route('animals.edit', $row->id)); ?>" class="btn btn-warning btn-sm">
                                                    Edit
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>

                                    <!-- RIGHT COLUMN -->
                                    <div class="col-6">
                                        <strong>Fur Color: <?php echo e(ucfirst($row->fur_color) ?? '-'); ?></strong><br>
                                        <strong>Size: <?php echo e(ucfirst($row->size ?? '-')); ?></strong><br>
                                        <strong>Sex: <?php echo e(ucfirst($row->sex ?? '-')); ?></strong><br>

                                        <?php if(auth()->guard()->check()): ?>
                                            <?php if(in_array(auth()->user()->role, ['staff','admin','volunteer'])): ?>
                                                <strong>Vaccines: <?php echo e(ucfirst($row->vaccine_status) ?? '-'); ?></strong><br>
                                                <strong>Spayed/Neutered: <?php echo e(ucfirst($row->spayed_neutered ?? '-')); ?></strong><br>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                            <?php
                                            $statusClass = match(strtolower($row->status ?? '')) {
                                                'available' => 'bg-success',
                                                'pending'   => 'bg-warning text-dark',
                                                'adopted'    => 'bg-primary',
                                                'transfered'   => 'bg-secondary',
                                                'decessed'      => 'bg-danger',
                                            };
                                            ?>
                                        <strong>Status: <span class="badge <?php echo e($statusClass); ?>"><?php echo e(ucfirst($row->status)); ?></span></strong><br>
                                    
                                        <?php if(auth()->guard()->check()): ?>
                                            <?php if(auth()->user()->role === 'admin'): ?>
                                                <form action="<?php echo e(route('animals.destroy', $row->id)); ?>"
                                                      method="POST"
                                                      onsubmit="return confirm('Delete this animal?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button class="btn btn-danger btn-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <!-- <a href="#" class="btn btn-outline-primary btn-sm">View Details</a> -->
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="d-flex justify-content-center mt-5">
            <?php echo e($results->links()); ?>

        </div>
    <?php endif; ?>

<!-- Image Modal (single modal reused for all images) -->
<div class="modal fade" id="imageModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-0">
        <img id="modalImage" class="img-fluid w-100">
      </div>
    </div>
  </div>
</div>

<script>function showImage(src) {document.getElementById('modalImage').src = src;}</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel-login-system\resources\views/search.blade.php ENDPATH**/ ?>