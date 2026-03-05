@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1>Deletion Requests</h1>

    @if($requests->isEmpty())
        <p>No requests.</p>
    @else
        <div class="row">
            @foreach($requests as $req)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        @if($req->animal && $req->animal->image)
                            <img src="{{ asset('animal_photos/' . $req->animal->image) }}"
                                 class="card-img-top"
                                 style="height:200px;object-fit:cover;">
                        @endif

                        <div class="card-body">

                            <h5>{{ $req->animal->name ?? 'Unknown' }}</h5>
                            <p><strong>Status:</strong> {{ ucfirst($req->status) }}</p>
                            <p><strong>Reason:</strong> {{ $req->reason ?? '-' }}</p>

                            @if($req->status === 'pending')
                                <form action="{{ route('deletion.approve', $req->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm">
                                        Approve (Delete)
                                    </button>
                                </form>

                                <form action="{{ route('deletion.reject', $req->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">
                                        Decline
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($req->status) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection