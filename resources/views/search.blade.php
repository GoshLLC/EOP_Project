@extends('layouts.app')

@section('content')

<div class="container" style="max-width: 700px";>
    <!-- Search -->
    <form action="{{ route('search') }}" method="get" class="d-flex">
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
            <form action="{{ route('search') }}" method="get">
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
                
                @auth
                    @if(in_array(auth()->user()->role, ['staff','admin','volunteer']))
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
                    @endif
                @endauth 
                
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
                {{ $results->total() }} animal{{ $results->total() !== 1 ? 's' : '' }} found
            </p>
        </div>

        <div class="toast-container">
               
        
        @if(session('success'))
            <div id="flash-message" class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div id="flash-message" class="alert alert-info text-center">
                {{ session('info') }}
            </div>
        @endif

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

        @if($results->isEmpty())
            <div class="alert alert-info text-center py-5">
                <h4>No matching pets right now, according to your search criteria.</h4>
                <p>Check back at a later time. New friends arrive regularly!</p>
                <a href="{{ route('search') }}" class="btn btn-primary">Clear Filters</a>
            </div>
        @else
            <div class="row justify-content-center">
                @foreach($results as $row)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">

        @if($row->image)
            <img src="{{ asset('animal_photos/' . $row->image) }}"
                 class="card-img-top"
                 style="height:200px;object-fit:cover; cursor:pointer;"
                 onclick="showImage(this.src)"
                 data-bs-toggle="modal"
                 data-bs-target="#imageModal">
        @endif

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">{{ $row->name }}</h5>
                                @auth
                                    @if(auth()->user()->role === 'user')
                                        @php
                                            $wishlisted = DB::table('wishlists')
                                                ->where('user_id', auth()->id())
                                                ->where('animal_id', $row->id)
                                                ->exists();
                                        @endphp
                                        @if($wishlisted)
                                            <form action="{{ route('wishlist.destroy', $row->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm">
                                                    Remove
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('wishlist.store', $row->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-outline-primary btn-sm">
                                                    Wishlist
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                @endauth
                            </div>
                                <div class="row small"> 
                                    <!-- LEFT COLUMN -->
                                    <div class="col-6">
                                        <strong>Species:{{ ucfirst($row->species ?? 'Unknown') }}</strong><br>
                                        <strong>Breed: {{ ucfirst($row->breed ?? '-') }}</strong><br>
                                        <strong>Age: {{ ucfirst($row->age ?? '-') }}</strong><br>
                                        <strong>Location: {{ ucfirst($row->location ?? '-') }}</strong><br>

                                        @auth
                                            @if(in_array(auth()->user()->role, ['staff','admin','volunteer']))
                                                <strong>Health: {{ ucfirst($row->health_status ?? '-') }}</strong><br>
                                                <strong>Intake: {{ $row->intake_date ?? '-' }}</strong><br>
                                            @endif
                                        @endauth

                                        @auth
                                            @if(auth()->user()->role === 'admin')
                                                <a href="{{ route('animals.edit', $row->id) }}" class="btn btn-warning btn-sm">
                                                    Edit
                                                </a>
                                            @endif
                                        @endauth
                                    </div>

                                    <!-- RIGHT COLUMN -->
                                    <div class="col-6">
                                        <strong>Fur Color: {{ ucfirst($row->fur_color) ?? '-' }}</strong><br>
                                        <strong>Size: {{ ucfirst($row->size ?? '-') }}</strong><br>
                                        <strong>Sex: {{ ucfirst($row->sex ?? '-') }}</strong><br>

                                        @auth
                                            @if(in_array(auth()->user()->role, ['staff','admin','volunteer']))
                                                <strong>Vaccines: {{ ucfirst($row->vaccine_status) ?? '-' }}</strong><br>
                                                <strong>Spayed/Neutered: {{ ucfirst($row->spayed_neutered ?? '-') }}</strong><br>
                                            @endif
                                        @endauth
                                            @php
                                            $statusClass = match(strtolower($row->status ?? '')) {
                                                'available' => 'bg-success',
                                                'pending'   => 'bg-warning text-dark',
                                                'adopted'    => 'bg-primary',
                                                'transfered'   => 'bg-secondary',
                                                'decessed'      => 'bg-danger',
                                            };
                                            @endphp
                                        <strong>Status: <span class="badge {{ $statusClass }}">{{ ucfirst($row->status) }}</span></strong><br>
                                    
                                        @auth
                                            @if(auth()->user()->role === 'admin')
                                                <form action="{{ route('animals.destroy', $row->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Delete this animal?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            <!-- <a href="#" class="btn btn-outline-primary btn-sm">View Details</a> -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-5">
            {{ $results->links() }}
        </div>
    @endif

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

@endsection
