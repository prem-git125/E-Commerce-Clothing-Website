@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="mb-4">Add New Product</h2>

        <form id="productForm" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-select" name="type">
                    <option selected>Open this select menu</option>
                    <option value="men">Men</option>
                    <option value="female">Female</option>
                    <option value="kids">Kids</option>
                    <option value="accessories">Accessories</option>
                    <option value="unisex">Unisex</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="base_image" class="form-label">Base Image</label>
                <input type="file" name="base_image" id="base_image" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="images" class="form-label">Additional Images</label>
                <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple>
            </div>

            <div class="mb-3">
                <label for="size_id" class="form-label">Sizes</label>
                <select name="size_id[]" id="select2" class="form-select" multiple>
                    @foreach ($sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="priceStockContainer"></div>

            <button type="submit" class="btn btn-primary mt-3">Create Product</button>
        </form>
    </div>
@endsection

@push('admin-scripts')
    <script>
        $(document).ready(function() {
            $('#select2').on('change', function() {
                let selectedSizes = $(this).find('option:selected');
                let container = $('#priceStockContainer');

                container.empty();

                selectedSizes.each(function() {
                    let sizeId = $(this).val();
                    let sizeName = $(this).text();

                    let fields = `
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="price_${sizeId}" class="form-label">${sizeName} - Price</label>
                                <input type="number" step="0.01" class="form-control" name="price[${sizeId}]" id="price_${sizeId}">
                            </div>
                            <div class="col-md-6">
                                <label for="stock_${sizeId}" class="form-label">${sizeName} - Stock</label>
                                <input type="number" class="form-control" name="stock[${sizeId}]" id="stock_${sizeId}">
                            </div>
                        </div>
                    `;

                    container.append(fields);
                })
            });

            $('#productForm').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $('.text-danger').remove();
                $('.is-invalid').removeClass('is-invalid');

                $.ajax({
                    url: "{{ route('admin.product.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if(response.success) {
                           toastr.success(response.message);
                           window.location.href = "{{ route('admin.product.index') }}";
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;

                            $.each(errors, function(key, messages) {
                                let input = $('[name="' + key + '"]');

                                if (key.includes('.')) {
                                    key = key.replace(/\./g, '\\.');
                                    input = $('[name="' + key + '"]');
                                }

                                if (input.length > 0) {
                                    input.addClass('is-invalid');
                                    input.after('<div class="text-danger">' + messages[
                                        0] + '</div>');
                                }
                            });

                            let firstError = $('.is-invalid').first();

                            if (firstError.length) {
                                $('html, body').animate({
                                    scrollTop: firstError.offset().top - 100
                                }, 500);
                            }
                        }
                    }
                });
            })
        });
    </script>
@endpush
