@extends('layouts.app')

@section('content')
<div class="container my-5">

    <h1>Edit Animal</h1>

    <form action="{{ route('animals.update', $animal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $animal->name }}" required>
        </div>

        <div class="mb-3">
            <label>Species</label>
			<select name="species" class="form-control" required>
 	   			<option value="dog" {{ $animal->species=='dog'?'selected':'' }}>Dog</option>
    			<option value="cat" {{ $animal->species=='cat'?'selected':'' }}>Cat</option>
    			<option value="other" {{ $animal->species=='other'?'selected':'' }}>Other</option>
			</select>
        </div>

        <div class="mb-3">
            <label>Breed</label>
            <input type="text" name="breed" class="form-control" value="{{ $animal->breed }}">
        </div>

        <div class="mb-3">
            <label>Sex</label>
            <input type="text" name="sex" class="form-control" value="{{ $animal->sex }}">
        </div>

        <div class="mb-3">
            <label>Age</label>
            <input type="number" name="age" class="form-control" value="{{ $animal->age }}">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="available" {{ $animal->status=='available'?'selected':'' }}>Available</option>
                <option value="pending" {{ $animal->status=='pending'?'selected':'' }}>Pending</option>
                <option value="adopted" {{ $animal->status=='adopted'?'selected':'' }}>Adopted</option>
    			<option value="transferred  {{ $animal->status=='transferred'?'selected':'' }}">Transferred</option>
    			<option value="decessedd  {{ $animal->status=='hold'?'decessed':'' }}">Decessed</option>   
            </select>
        </div>

        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control" value="{{ $animal->location }}">
		</div>
    
    	<div class="mb-3">
    		<label>Health Status</label>
    		<select name="size" class="form-control">
        		<option value="healthy" {{ trim($animal->health_status ?? '') === 'healthy' ? 'selected' : '' }}>Healthy</option>
        		<option value="needs care" {{ trim($animal->health_status ?? '') === 'needs care' ? 'selected' : '' }}>Needs Care</option>
        		<option value="critical" {{ trim($animal->health_status ?? '') === 'critical' ? 'selected' : '' }}>Critical</option>
    		</select>
		</div>
       
        	<div class="mb-3">
    		<label>Fur Color</label>
    		<select name="fur_color" class="form-control">
        		<option value="black" {{ trim($animal->health_status ?? '') === 'black' ? 'selected' : '' }}>Black</option>
        		<option value="brown" {{ trim($animal->health_status ?? '') === 'brown' ? 'selected' : '' }}>Brown Care</option>
        		<option value="cream" {{ trim($animal->health_status ?? '') === 'cream' ? 'selected' : '' }}>Cream</option>
            	<option value="mix" {{ trim($animal->health_status ?? '') === 'mix' ? 'selected' : '' }}>Mix</option>
        		<option value="other" {{ trim($animal->health_status ?? '') === 'other' ? 'selected' : '' }}>Other</option>
    		</select>
		</div>

		<div class="mb-3">
    		<label>Size</label>
    		<select name="size" class="form-control">
        		<option value="small" {{ trim($animal->size ?? '') === 'small' ? 'selected' : '' }}>Small</option>
        		<option value="medium" {{ trim($animal->size ?? '') === 'medium' ? 'selected' : '' }}>Medium</option>
        		<option value="large" {{ trim($animal->size ?? '') === 'large' ? 'selected' : '' }}>Large</option>
    		</select>
		</div>

        <div class="mb-3">
            <label>Spayed/Neutered</label>
            <select name="spayed_neutered" class="form-control">
				<option value="y" {{ $animal->spayed_neutered=='y'?'selected':'' }}>Yes</option>
				<option value="n" {{ $animal->spayed_neutered=='n'?'selected':'' }}>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Vaccine Status</label>
            <select name="vaccine_status" class="form-control">
				<option value="current" {{ $animal->vaccine_status=='current'?'selected':'' }}>Up to Date</option>
				<option value="expired" {{ $animal->vaccine_status=='expired'?'selected':'' }}>Not Up to Date</option>
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