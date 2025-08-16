@extends('layouts.admin')

@section('content')
    <h3>Edit Product</h3>
    <hr>
    <form class="row g-3" 
          method="POST" 
          action="{{ route('admin.product.update', $product->id) }}" 
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="col-md-4">
            <label for="produtName" class="form-label">Name</label>
            <input type="text" name="name" 
                   value="{{ old('name', $product->name) }}"
                   class="form-control @error('name') is-invalid @enderror" 
                   id="produtName" 
                   placeholder="Product Name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label for="productPrice" class="form-label">Price</label>
            <input type="number" step="0.01" name="price" 
                   value="{{ old('price', $product->price) }}"
                   class="form-control @error('price') is-invalid @enderror" 
                   id="productPrice" 
                   placeholder="Price">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label for="category" class="form-label">Select Category</label>
            <select class="form-select @error('category_id') is-invalid @enderror" name="category_id">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-12">
            <label for="productDesc" class="form-label">Description</label>
            <textarea name="description" 
                      class="form-control @error('description') is-invalid @enderror" 
                      id="productDesc"
                      rows="3" 
                      placeholder="Description">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label for="productCategory" class="form-label">Type</label>
            <select class="form-select @error('type') is-invalid @enderror" name="type">
                <option value="">Select Type</option>
                <option value="men" {{ old('type', $product->type) == 'men' ? 'selected' : '' }}>Men</option>
                <option value="female" {{ old('type', $product->type) == 'female' ? 'selected' : '' }}>Female</option>
                <option value="kids" {{ old('type', $product->type) == 'kids' ? 'selected' : '' }}>Kids</option>
                <option value="unisex" {{ old('type', $product->type) == 'unisex' ? 'selected' : '' }}>Unisex</option>
                <option value="accessories" {{ old('type', $product->type) == 'accessories' ? 'selected' : '' }}>Accessories</option>
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label for="productBaseImg" class="form-label">Base Image</label>
            <input type="file" name="base_image" 
                   class="form-control @error('base_image') is-invalid @enderror"
                   id="productBaseImg">
            @if ($product->base_image)
                <small class="d-block mt-2">
                    Current: <img src="{{ asset('storage/app/public/products/' . $product->base_image) }}" width="80" alt="Product Image">
                </small>
            @endif
            @error('image_url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label for="productStock" class="form-label">Stock</label>
            <input type="number" name="stock" 
                   value="{{ old('stock', $product->stock) }}"
                   class="form-control @error('stock') is-invalid @enderror" 
                   id="productStock" 
                   placeholder="Stock">
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 d-flex justify-content-center mt-5">
            <button type="submit" class="btn btn-outline-primary w-50">Update</button>
        </div>
    </form>
@endsection

@push('admin-scripts')
    <!-- Include CKEditor CDN -->
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('productDesc', {
            height: 200,
            removeButtons: 'PasteFromWord'
        });
    </script>
@endpush
