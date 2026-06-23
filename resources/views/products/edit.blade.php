@extends('layouts.app')
@section('title', 'Edit Product')
@section('page-title', 'Edit Product')
@section('content')
<div class="table-container">
    <form method="POST" action="{{ route('products.update', $product->id) }}">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Product Code</label>
                <input type="text" name="product_code" class="form-control" value="{{ old('product_code', $product->product_code) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Product Name</label>
                <input type="text" name="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Cost Price</label>
                <input type="number" step="0.01" name="cost_price" class="form-control" value="{{ old('cost_price', $product->cost_price) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Selling Price</label>
                <input type="number" step="0.01" name="selling_price" class="form-control" value="{{ old('selling_price', $product->selling_price) }}" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Reorder Level</label>
                <input type="number" name="reorder_level" class="form-control" value="{{ old('reorder_level', $product->reorder_level) }}" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Expiry Date</label>
                <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date', $product->expiry_date ? $product->expiry_date->format('Y-m-d') : '') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Barcode</label>
                <input type="text" name="barcode" class="form-control" value="{{ old('barcode', $product->barcode) }}">
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="2">{{ old('description', $product->description) }}</textarea>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
