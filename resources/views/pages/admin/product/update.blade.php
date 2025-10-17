@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="mb-4">Edit Product</h2>

        <form id="productForm" action="" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <div id="category_id-error" class="invalid-feedback d-block small"></div>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}">
                <div id="name-error" class="invalid-feedback d-block small"></div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control">{{ $product->description }}</textarea>
                <div id="description-error" class="invalid-feedback d-block small"></div>
            </div>

            <div class="mb-3">
                <label for="wearing_type" class="form-label">Wearing Type</label>
                <select class="form-select" name="wearing_type">
                    <option value="">Select Wearing Type</option>
                    <option value="upper" {{ $product->wearing_type == 'upper' ? 'selected' : '' }}>Upper</option>
                    <option value="lower" {{ $product->wearing_type == 'lower' ? 'selected' : '' }}>Lower</option>
                </select>
                <div id="wearing_type-error" class="invalid-feedback d-block small"></div>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-select" name="type">
                    <option value="">Select Type</option>
                    <option value="men" {{ $product->type == 'men' ? 'selected' : '' }}>Men</option>
                    <option value="female" {{ $product->type == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="kids" {{ $product->type == 'kids' ? 'selected' : '' }}>Kids</option>
                    <option value="accessories" {{ $product->type == 'accessories' ? 'selected' : '' }}>Accessories</option>
                    <option value="unisex" {{ $product->type == 'unisex' ? 'selected' : '' }}>Unisex</option>
                </select>
                <div id="type-error" class="invalid-feedback d-block small"></div>
            </div>

            <div class="mb-3">
                <label for="base_image" class="form-label">Base Image</label>
                @if ($product->base_image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->base_image) }}" width="100" class="rounded border">
                    </div>
                @endif
                <input type="file" name="base_image" id="base_image" class="form-control" accept="image/*">
                <div id="base_image-error" class="invalid-feedback d-block small"></div>
            </div>

            <div class="mb-3">
                <label for="images" class="form-label">Additional Images</label>
                <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple>
                <div id="images-error" class="invalid-feedback d-block small"></div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Product</button>
        </form>
    </div>
@endsection

@push('admin-scripts')
    <script>
        $(document).ready(function() {
            $('#productForm').submit(function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.product.update', $product->id) }}",
                    type: "POST", 
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            window.location.href = "{{ route('admin.product.index') }}";
                        }
                    },
                    error: function(xhr) {
                        console.log('xhr ===> ', xhr)
                        console.log(xhr.responseText);

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $('.invalid-feedback').text('');

                            $.each(errors, function(key, value) {
                                $('#' + key + '-error').text(value[0]);
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
