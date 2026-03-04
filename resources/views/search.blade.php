@extends('layouts.app')

@section('content')

    <div class="container my-5">
        <h1 class="text-center mb-4">Pet Search Results</h1>

        <div class="mb-4 text-center">
            <p class="lead">
                {{ $results->total() }} animal{{ $results->total() !== 1 ? 's' : '' }} found
            </p>
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
                                     alt="{{ $row->name }}" 
                                     style="height: 220px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $row->name }}</h5>
                                <p class="card-text">
                                    <strong>Species:</strong> {{ $row->species ?? 'Unknown' }}<br>
                                    @if($row->breed)<strong>Breed:</strong> {{ $row->breed }}<br>@endif
                                    @if($row->age !== null)<strong>Age:</strong> {{ $row->age }}<br>@endif
                                    @if($row->location)<strong>Location:</strong> {{ $row->location }}<br>@endif
                                    <strong>Status:</strong> 
                                    <span class="badge bg-success">{{ $row->status }}</span>
                                </p>
                                <a href="#" class="btn btn-outline-primary btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $results->links() }}
            </div>
        @endif
    </div>
@endsection
