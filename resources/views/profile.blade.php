@extends('layouts.app')
@section('title', 'My Profile')
@section('page-title', 'My Profile')
@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="table-container">
            <div class="text-center mb-4">
                <div class="display-6 mb-2"><i class="bi bi-person-circle text-primary"></i></div>
                <h5 class="fw-bold">{{ $user->name }}</h5>
                <span class="badge bg-info">{{ $user->role->name ?? 'No Role' }}</span>
            </div>
            <table class="table">
                <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                <tr><th>Member Since</th><td>{{ $user->created_at->format('d M Y') }}</td></tr>
            </table>
        </div>
    </div>
    <div class="col-md-7">
        <div class="table-container">
            <h5 class="fw-bold mb-3">Edit Profile</h5>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <hr class="my-2">
                    <h6 class="fw-bold">Change Password (optional)</h6>
                    <div class="col-md-4">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                        @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror">
                        @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Update Profile</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
