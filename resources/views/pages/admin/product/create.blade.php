@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Add New Product</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Product Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <!-- Type -->
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" name="type" id="type" class="form-control" value="{{ old('type') }}" required>
        </div>

        <!-- Base Image -->
        <div class="mb-3">
            <label for="base_image" class="form-label">Base Image</label>
            <input type="file" name="base_image" id="base_image" class="form-control" accept="image/*" required>
        </div>

        <!-- Multiple Images -->
        <div class="mb-3">
            <label for="images" class="form-label">Additional Images</label>
            <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple>
        </div>

        <!-- Sizes -->
        <div class="mb-3">
            <label for="size_id" class="form-label">Sizes</label>
            <select name="size_id[]" id="select2" class="form-select" multiple required>
                @foreach($sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                @endforeach
            </select>
        </div>

        <div id="priceStockContainer"></div>

        <button type="submit" class="btn btn-primary mt-3">Create Product</button>
    </form>
</div>

@endsection

@section('admin-scripts')
<script>

</script>
@endsection
