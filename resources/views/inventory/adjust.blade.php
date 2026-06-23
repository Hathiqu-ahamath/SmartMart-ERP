@extends('layouts.app')
@section('title', 'Stock Adjustment')
@section('page-title', 'Stock Adjustment')
@section('content')
<div class="table-container">
    <form method="POST" action="{{ route('inventory.adjust') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Product</label>
                <select name="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                    <option value="">Select Product</option>
                    @foreach($products as $p)
                    <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>{{ $p->product_name }} (Stock: {{ $p->quantity }})</option>
                    @endforeach
                </select>
                @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Quantity Change</label>
                <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" placeholder="Use + or -" required>
                <small class="text-muted">Use positive for addition, negative for deduction</small>
                @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Reason</label>
                <input type="text" name="reason" class="form-control @error('reason') is-invalid @enderror" value="{{ old('reason') }}" required>
                @error('reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-warning">Adjust Stock</button>
            <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
