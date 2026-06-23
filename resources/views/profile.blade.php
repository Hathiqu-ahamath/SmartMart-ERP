@extends('layouts.app')
@section('title', 'My Profile')
@section('page-title', 'My Profile')
@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="table-container text-center">
            <div class="mb-3">
                @if($user->profile_picture)
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}"
                         class="rounded-circle border border-3 border-primary shadow-sm"
                         style="width: 120px; height: 120px; object-fit: cover;">
                @else
                    <div class="display-4 mb-2"><i class="bi bi-person-circle text-primary"></i></div>
                @endif
            </div>
            <h5 class="fw-bold">{{ $user->name }}</h5>
            <span class="badge bg-info mb-3">{{ $user->role->name ?? 'No Role' }}</span>
            <table class="table text-start">
                <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                <tr><th>Employee Code</th><td>{{ $user->employee_code ?? '—' }}</td></tr>
                <tr><th>Member Since</th><td>{{ $user->created_at->format('d M Y') }}</td></tr>
            </table>
        </div>
    </div>
    <div class="col-md-7">
        <div class="table-container">
            <h5 class="fw-bold mb-3">Edit Profile</h5>
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
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
                    <div class="col-12">
                        <label class="form-label">Profile Picture</label>
                        <input type="file" name="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror" accept="image/jpeg,image/png,image/gif,image/webp">
                        @error('profile_picture') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text">Allowed: jpeg, png, gif, webp &mdash; Max: 2MB</div>
                        @if($user->profile_picture)
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="remove_picture" id="remove_picture" value="1">
                                <label class="form-check-label text-danger" for="remove_picture">Remove current picture</label>
                            </div>
                        @endif
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
