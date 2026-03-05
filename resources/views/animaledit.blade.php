@extends('layouts.app')

@section('content')
<div class="container my-5">

    <h1>Edit Animal</h1>

    <form action="{{ route('animals.update', $animal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control"
                   value="{{ $animal->name }}" required>
        </div>

        <div class="mb-3">
            <label>Species</label>
            <input type="text" name="species" class="form-control"
                   value="{{ $animal->species }}" required>
        </div>

        <div class="mb-3">
            <label>Breed</label>
            <input type="text" name="breed" class="form-control"
                   value="{{ $animal->breed }}">
        </div>

        <div class="mb-3">
            <label>Sex</label>
            <input type="text" name="sex" class="form-control"
                   value="{{ $animal->sex }}">
        </div>

        <div class="mb-3">
            <label>Age</label>
            <input type="number" name="age" class="form-control"
                   value="{{ $animal->age }}">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="available" {{ $animal->status=='available'?'selected':'' }}>Available</option>
                <option value="pending" {{ $animal->status=='pending'?'selected':'' }}>Pending</option>
                <option value="adopted" {{ $animal->status=='adopted'?'selected':'' }}>Adopted</option>
                <option value="hold" {{ $animal->status=='hold'?'selected':'' }}>On Hold</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control"
                   value="{{ $animal->location }}">
        </div>

        <div class="mb-3">
            <label>Health Status</label>
            <input type="text" name="health_status" class="form-control"
                   value="{{ $animal->health_status }}">
        </div>

        <div class="mb-3">
            <label>Fur Color</label>
            <input type="text" name="fur_color" class="form-control"
                   value="{{ $animal->fur_color }}">
        </div>

        <div class="mb-3">
            <label>Size</label>
            <input type="text" name="size" class="form-control"
                   value="{{ $animal->size }}">
        </div>

        <div class="mb-3">
            <label>Spayed/Neutered</label>
            <select name="spayed_neutered" class="form-control">
                <option value="yes" {{ $animal->spayed_neutered=='yes'?'selected':'' }}>Yes</option>
                <option value="no" {{ $animal->spayed_neutered=='no'?'selected':'' }}>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Vaccine Status</label>
            <select name="vaccine_status" class="form-control">
                <option value="up_to_date" {{ $animal->vaccine_status=='up_to_date'?'selected':'' }}>Up to Date</option>
                <option value="not_up_to_date" {{ $animal->vaccine_status=='not_up_to_date'?'selected':'' }}>Not Up to Date</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Intake Date</label>
            <input type="date" name="intake_date" class="form-control"
                   value="{{ $animal->intake_date }}" required>
        </div>

        <button class="btn btn-primary">Save Changes</button>
    </form>

</div>
@endsection