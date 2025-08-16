@extends('layouts.app')

@section('content')
    <section class="section py-4">
        <div class="container">
            <div class="row">

                <!-- Main Image -->
                <div class="col-md-5 mb-4">
                    <div class="rounded p-2 mb-3">
                        <img src="{{ asset('storage/' . $product->base_image) }}" 
                             alt="{{ $product->name }}"
                             class="img-fluid main-image shadow-sm"
                        >
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-md-7">
                    <h3 class="mb-2">{{ $product->name }}</h3>
                    <h5 class="text-primary mb-2">₹{{ number_format($product->price, 2) }}</h5>

                    <!-- Thumbnails -->
                    <div class="d-flex gap-2 mb-3 flex-wrap">
                        @foreach ($product->images as $image)
                            <div class="thumbnail-wrapper border rounded p-1"
                                 style="width: 70px; height: 70px; overflow: hidden; cursor: pointer;">
                                <img src="{{ asset('storage/' . $image->image_url) }}" 
                                     alt="{{ $product->name }}"
                                     class="img-fluid h-100 w-100" style="object-fit: cover;">
                            </div>
                        @endforeach
                    </div>

                    <div class="text-muted mb-1" style="font-size: 0.95rem;">
                        {!! $product->description !!}
                    </div>

                    <!-- Buttons -->
                    <div class="mb-4">
                        <button class="btn btn-primary me-2 px-4 py-2 rounded">
                            <i class="bi bi-cart"></i> Add to Cart
                        </button>
                        <button class="btn btn-outline-secondary px-4 py-2 rounded">
                            Buy Now
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.thumbnail-wrapper').on('click', function() {
                let new_src = $(this).find('img').attr('src');

                $('.main-image').fadeOut(300, function() {
                    $(this).attr('src', new_src).fadeIn(300);
                });

                $('.thumbnail-wrapper').removeClass('border-primary');
                $(this).closest('.thumbnail-wrapper').addClass('border-primary');
            })
        });
    </script>
@endpush
