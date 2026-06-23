@extends('layouts.app')
@section('title', 'Create Role')
@section('page-title', 'Create New Role')
@section('content')
<div class="table-container">
    <form method="POST" action="{{ route('roles.store') }}">
        @csrf
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Role Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Description</label>
                <input type="text" name="description" class="form-control" value="{{ old('description') }}">
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
                                {{ in_array($perm->id, old('permissions', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_{{ $perm->id }}">{{ $perm->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Create Role</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
