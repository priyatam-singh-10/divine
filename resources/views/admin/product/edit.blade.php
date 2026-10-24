@extends('layouts.admin')
@push('title', get_phrase('Edit Product'))
@section('content')

<div class="ol-card">
    <div class="ol-card-body">
        <h4 class="mb-4">{{ get_phrase('Edit Product') }}</h4>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Product Category -->
            <div class="mb-3">
                <label for="product_category_id" class="form-label">{{ get_phrase('Category') }}</label>
                <select name="product_category_id" id="product_category_id" class="form-control">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->product_category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Product Name -->
            <div class="mb-3">
                <label for="name" class="form-label">{{ get_phrase('Product Name') }}</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">{{ get_phrase('Description') }}</label>
                <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
            </div>

            <!-- Price -->
            <div class="mb-3">
                <label for="price" class="form-label">{{ get_phrase('Price') }}</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}" required>
            </div>

            <!-- Sale Price -->
            <div class="mb-3">
                <label for="sale_price" class="form-label">{{ get_phrase('Sale Price') }}</label>
                <input type="number" step="0.01" name="sale_price" class="form-control" value="{{ $product->sale_price }}">
            </div>

            <!-- Stock -->
            <div class="mb-3">
                <label for="stock" class="form-label">{{ get_phrase('Stock Quantity') }}</label>
                <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
            </div>

            <!-- SKU -->
            <div class="mb-3">
                <label for="sku" class="form-label">{{ get_phrase('SKU') }}</label>
                <input type="text" name="sku" class="form-control" value="{{ $product->sku }}">
            </div>

            <!-- Image -->
            <!-- Image -->
            <div class="mb-3">
                <label for="image" class="form-label">{{ get_phrase('Product Image') }}</label>
                <input type="file" name="image" class="form-control">
                
                @if(!empty($product->image))
               
                    <div class="mt-2">
                        <img src="{{ url($product->image) }}" alt="Product Image" height="80">
                    </div>
                @endif
            </div>


            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label">{{ get_phrase('Status') }}</label>
                <select name="status" class="form-control">
                    <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>{{ get_phrase('Active') }}</option>
                    <option value="inactive" {{ $product->status === 'inactive' ? 'selected' : '' }}>{{ get_phrase('Inactive') }}</option>
                </select>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-success">{{ get_phrase('Update Product') }}</button>
        </form>
    </div>
</div>

@endsection
