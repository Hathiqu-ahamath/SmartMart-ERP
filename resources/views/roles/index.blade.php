@extends('layouts.app')
@section('title', 'Roles')
@section('page-title', 'Role Management')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5 class="fw-bold">All Roles</h5>
    <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> New Role</a>
</div>
<div class="table-container">
    <table class="table table-hover">
        <thead>
            <tr><th>Name</th><th>Slug</th><th>Permissions</th><th>Users</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td><code>{{ $role->slug }}</code></td>
                <td>
                    @foreach($role->permissions->take(3) as $perm)
                        <span class="badge bg-secondary">{{ $perm->name }}</span>
                    @endforeach
                    @if($role->permissions->count() > 3)
                        <span class="badge bg-info">+{{ $role->permissions->count() - 3 }} more</span>
                    @endif
                </td>
                <td>{{ $role->users_count ?? $role->users->count() }}</td>
                <td>
                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this role?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $roles->links() }}
</div>
@endsection
