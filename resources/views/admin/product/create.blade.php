@extends('layouts.admin')
@push('title', get_phrase('Create Product'))
@section('content')

<div class="ol-card">
    <div class="ol-card-body">
        <h4 class="mb-4">{{ get_phrase('Create New Product') }}</h4>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Product Category -->
            <div class="mb-3">
                <label for="product_category_id" class="form-label">{{ get_phrase('Category') }}</label>
                <select name="product_category_id" id="product_category_id" class="form-control">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Product Name -->
            <div class="mb-3">
                <label for="name" class="form-label">{{ get_phrase('Product Name') }}</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">{{ get_phrase('Description') }}</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>

            <!-- Price -->
            <div class="mb-3">
                <label for="price" class="form-label">{{ get_phrase('Price') }}</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div>

            <!-- Sale Price -->
            <div class="mb-3">
                <label for="sale_price" class="form-label">{{ get_phrase('Sale Price') }}</label>
                <input type="number" step="0.01" name="sale_price" class="form-control">
            </div>

            <!-- Stock -->
            <div class="mb-3">
                <label for="stock" class="form-label">{{ get_phrase('Stock Quantity') }}</label>
                <input type="number" name="stock" class="form-control" required>
            </div>

            <!-- SKU -->
            <div class="mb-3">
                <label for="sku" class="form-label">{{ get_phrase('SKU') }}</label>
                <input type="text" name="sku" class="form-control">
            </div>

            <!-- Image -->
            <div class="mb-3">
                <label for="image" class="form-label">{{ get_phrase('Product Image') }}</label>
                <input type="file" name="image" class="form-control">
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label">{{ get_phrase('Status') }}</label>
                <select name="status" class="form-control">
                    <option value="active">{{ get_phrase('Active') }}</option>
                    <option value="inactive">{{ get_phrase('Inactive') }}</option>
                </select>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary">{{ get_phrase('Create Product') }}</button>
        </form>
    </div>
</div>

@endsection
