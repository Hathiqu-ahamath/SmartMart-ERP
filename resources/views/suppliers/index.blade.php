@extends('layouts.app')
@section('title', 'Suppliers')
@section('page-title', 'Supplier Management')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5 class="fw-bold">All Suppliers</h5>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> New Supplier</a>
</div>
<div class="table-container">
    <table class="table table-hover table-sm">
        <thead><tr><th>Code</th><th>Company</th><th>Contact</th><th>Phone</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($suppliers as $s)
            <tr>
                <td><code>{{ $s->supplier_code }}</code></td>
                <td>{{ $s->company_name }}</td>
                <td>{{ $s->contact_person ?? 'N/A' }}</td>
                <td>{{ $s->phone ?? 'N/A' }}</td>
                <td>{!! $s->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</td>
                <td>
                    <a href="{{ route('suppliers.show', $s->id) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('suppliers.edit', $s->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('suppliers.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete supplier?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $suppliers->links() }}
</div>
@endsection
