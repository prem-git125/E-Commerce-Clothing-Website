@extends('layouts.app')

@section('content')
    <section id="new-arrival" class="new-arrival py-2 position-relative overflow-hidden">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 mb-3">
                <h4 class="text-uppercase">Our New Arrivals</h4>
            </div>

            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="product-item image-zoom-effect link-effect">
                            <div class="image-holder position-relative">
                                <a href="{{ route('user.product.show', $product->id) }}">
                                    <img src="{{ Storage::url($product->base_image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="product-image img-fluid">
                                </a>
                                <a href="{{ route('user.product.show', $product->id)}}" class="btn-icon btn-wishlist">
                                    <svg width="24" height="24" viewBox="0 0 24 24">
                                        <use xlink:href="#heart"></use>
                                    </svg>
                                </a>
                                <div class="product-content">
                                    <h5 class="text-uppercase fs-5 mt-3">
                                        <a href="#">{{ $product->name }}</a>
                                    </h5>
                                    <a href="{{ route('user.product.show', $product->id) }}" class="text-decoration-none" data-after="Add to cart">
                                        <span>${{ $product->price }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endsection
