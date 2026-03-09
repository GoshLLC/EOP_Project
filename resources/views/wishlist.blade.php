@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1>Your Wishlist</h1>

    @if($animals->isEmpty())
        <p>No saved pets yet.</p>
    @else
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
                            <h5>{{ $row->name }}</h5>
                            <p>{{ $row->species }}</p>
<form action="{{ url('/wishlist/' . $row->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger btn-sm">
        Remove
    </button>
</form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection