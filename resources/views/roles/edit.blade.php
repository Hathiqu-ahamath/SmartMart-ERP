@extends('layouts.app')
@section('title', 'Edit Role')
@section('page-title', 'Edit Role')
@section('content')
<div class="table-container">
    <form method="POST" action="{{ route('roles.update', $role) }}">
        @csrf @method('PUT')
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Role Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $role->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Description</label>
                <input type="text" name="description" class="form-control" value="{{ old('description', $role->description) }}">
            </div>
        </div>
        <h6 class="fw-bold mb-3">Permissions</h6>
        <div class="row">
            @foreach($permissions as $group => $perms)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header bg-light">{{ ucfirst($group) }}</div>
                    <div class="card-body">
                        @foreach($perms as $perm)
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" class="form-check-input" id="perm_{{ $perm->id }}"
                                {{ in_array($perm->id, $rolePermissions) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_{{ $perm->id }}">{{ $perm->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Update Role</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
