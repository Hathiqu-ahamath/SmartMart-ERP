@extends('layouts.app')
@section('title', 'Users')
@section('page-title', 'User Management')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5 class="fw-bold">All Users</h5>
    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> New User</a>
</div>
<div class="table-container">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><span class="badge bg-info">{{ $user->role->name ?? 'N/A' }}</span></td>
                <td>{!! $user->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</td>
                <td>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Deactivate this user?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@endsection
