@extends('layouts.app')

@section('content')

<div class="main-container text-center">
    <h1>Search Results</h1>
    @if($results->isEmpty())
        <p>No results found.</p>
    @else
        @foreach($results as $row)
            <div class="card mb-3 mx-auto" style="max-width: 550px;">
                <div class="card-body">
                    <h3>{{ $row->name }}</h3>
                    <p>Species: {{ $row->species }}</p>

                    @if($row->image)
                        <!--<img style="max-width:525px"src="{{ asset('animal_photos/' . $row->image) }}" class="img-fluid">-->
                        <img src="{{ asset('animal_photos/' . $row->image) }}" class="img-fluid mx-auto d-block">
                    @endif

                    <p>Status: {{ $row->status }}</p>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
