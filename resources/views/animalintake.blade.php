@extends('layouts.app')

@section('content')



@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif




<div class="container my-5">

    <h1>Animals</h1>
    @auth
        @if(in_array(auth()->user()->role, ['staff','admin']))
            <div class="card mb-4">
                <div class="card-body">
                    <h4>Add New Animal</h4>

                    <form action="{{ route('animals.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <!-- Species -->
                        <div class="mb-3">
                            <label>Species</label>
                            <select name="species" class="form-control" required>
                                <option value="">Select species</option>
                                <option value="dog">Dog</option>
                                <option value="cat">Cat</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!-- Breed -->
                        <div class="mb-3">
                            <label>Breed</label>
                            <input type="text" name="breed" class="form-control">
                        </div>

                        <!-- Age -->
                        <div class="mb-3">
                            <label>Age (years)</label>
                            <input type="number" name="age" class="form-control" min="0">
                        </div>

                        <!-- Sex -->
                        <div class="mb-3">
                            <label>Sex</label>
                            <select name="sex" class="form-control">
                                <option value="">Select Sex</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="">Select status</option>
                                <option value="available">Available</option>
                                <option value="pending">Pending</option>
                                <option value="adopted">Adopted</option>
                                <option value="transferred">transferred</option>
                                <option value="decessed">decessed</option>
                            </select>
                        </div>

                        <!-- Health Status -->
                        <div class="mb-3">
                            <label>Health Status</label>
                            <select name="health_status" class="form-control">
                                <option value="">Select health status</option>
                                <option value="healthy">Healthy</option>
                                <option value="needs care">Needs Care</option>
                                <option value="critical">Critical</option>
                            </select>
                        </div>

                        <!-- Spayed/Nuetered -->
                        <div class="mb-3">
                            <label>Spayed/Neutered</label>
                            <select name="spayed_neutered" class="form-control" required>
                                <option value="">Select option</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Vaccine Status</label>
                            <select name="vaccine_status" class="form-control" required>
                                <option value="">Select option</option>
                                <option value="up_to_date">Up to Date</option>
                                <option value="not_up_to_date">Not Up to Date</option>
                            </select>
                        </div>

                        <!-- Fur Color -->
                        <label>Fur Color</label>
                            <select class="form-select mb-3" name="fur_color">
                                <option value="">Choose A Color</option>
                                <option value="black">Black</option>
                                <option value="grey">Grey</option>
                                <option value="brown">Brown</option>
                                <option value="cream">Cream</option>
                                <option value="other">Other</option>
                            </select>

                        <!-- Size -->
                        <div class="mb-3">
                            <label>Size</label>
                            <select name="size" class="form-control">
                                <option value="">Select Size</option>
                                <option value="Small">Small</option>
                                <option value="Medium">Medium</option>
                                <option value="Large">Large</option>
                            </select>
                        </div>

                        <!-- Location -->
                        <div class="mb-3">
                            <label>Location</label>
                            <input type="text" name="location" class="form-control">
                        </div>

                        <!-- Intake Date -->
                        <div class="mb-3">
                            <label>Intake Date</label>
                            <input type="date" name="intake_date" class="form-control" required>
                        </div>

                        <!-- Picture -->
                        <div class="mb-3">
                            <label>Picture (required)</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success">Upload Animal</button>
                    </form>
                </div>
            </div>
        @endif
    @endauth

    <!-- SEARCH -->
    <form action="{{ route('search') }}" method="get" class="d-flex mb-3">
        <input class="form-control me-2" type="search" name="q" placeholder="Search">
        <button class="btn btn-primary">Search</button>
        <button class="btn btn-dark ms-2" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#filterPanel">
            ☰
        </button>
    </form>

    <!-- OFFCANVAS FILTERS -->
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
                    <option value="Black">Black</option>
                    <option value="Grey">Grey</option>
                    <option value="Brown">Brown</option>
                    <option value="Creame">Creame</option>
                    <option value="Other">Other</option>
                </select>
                <!-- Health Status -->
                <label>Health Status</label>
                <select class="form-control mb-3" name="health_status">
                    <option value="">Any</option>
                    <option value="Healthy">Healthy</option>
                    <option value="Needs Care">Needs Care</option>
                    <option value="Critical">Critical</option>
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

<!-- Animal Cards -->
<div class="row">
    @foreach($animals as $row)
        <div class="col-md-4 mb-4">
            <div class="card">

                @if($row->image)
                    <img src="{{ asset('animal_photos/' . $row->image) }}"
                         class="card-img-top"
                         style="height:200px;object-fit:cover;">
                @endif

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">{{ $row->name }}</h5>

                        <!-- Deletion Request (staff only) -->
                        @auth
                            @if(auth()->user()->role === 'staff')
                                <button class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $row->id }}">
                                    Request Deletion
                                </button>
                            @endif
                        @endauth
                    </div>

                    <!-- Modal -->
                    @auth
                        @if(auth()->user()->role === 'staff')
                            <div class="modal fade" id="deleteModal{{ $row->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Request Deletion</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="{{ route('animal.delete.request', $row->id) }}" method="POST">
                                                @csrf

                                                <label>Reason (optional)</label>
                                                <textarea name="reason" class="form-control"></textarea>

                                                <button class="btn btn-danger mt-3">
                                                    Submit Request
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                    @endauth

                    <div class="row small mt-3">

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
                                'available'  => 'bg-success',
                                'pending'    => 'bg-warning text-dark',
                                'adopted'     => 'bg-primary',
                                'transfered'  => 'bg-secondary',
                                'deceased'    => 'bg-danger',
                                default       => 'bg-dark',
                            };
                            @endphp

                            <strong>Status:</strong>
                            <span class="badge {{ $statusClass }}">
                                {{ ucfirst($row->status ?? 'unknown') }}
                            </span><br>

                            @auth
                                @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('animals.destroy', $row->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this animal?');">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm mt-2">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="d-flex justify-content-center">
    {{ $animals->links() }}
</div>
@endsection