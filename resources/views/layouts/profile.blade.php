@extends('layouts.app')

@section('content')

<!-- Main centered content -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <!-- Page title centered -->
            <div class="text-center mb-5">
                <h2 class="fw-bold">Your Profile</h2>
                <p class="text-muted">Manage your account details below.</p>
            </div>

            <!-- Success / error messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Profile View + Edit Card -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h4 class="mb-0">Account Information</h4>
                </div>

                <div class="card-body p-4 p-md-5">

                    <!-- View-only details (shown always) -->
                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Username</label>
                            <p class="fs-5 mb-0">{{ $account->username ?? 'Not set' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Email</label>
                            <p class="fs-5 mb-0">{{ $account->email }}</p>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-muted">Registered On</label>
                            <p class="fs-5 mb-0">{{ $account->registered?->format('F j, Y') ?? 'Unknown' }}</p>
                        </div>
                    </div>

                    <!-- Edit Form -->
                    <hr class="my-5">

                    <h5 class="mb-4 text-center">Update Your Profile</h5>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                   value="{{ old('name', $account->name ?? '') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   value="{{ old('email', $account->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">New Password (leave blank to keep current)</label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="password_confirmation" class="form-label fw-bold">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Save Changes</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection