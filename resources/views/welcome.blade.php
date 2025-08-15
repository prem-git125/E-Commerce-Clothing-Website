@extends('layouts.app')

@php
    $images = [
        [
            'image' => 'images/banner-image-1.jpg',
            'title' => 'Soft leather jackets',
            'description' => 'Scelerisque duis aliquam qui lorem ipsum dolor amet, consectetur adipiscing elit.',
        ],

        [
            'image' => 'images/banner-image-2.jpg',
            'title' => 'Soft leather jackets',
            'description' => 'Scelerisque duis aliquam qui lorem ipsum dolor amet, consectetur adipiscing elit.',
        ],

        [
            'image' => 'images/banner-image-3.jpg',
            'title' => 'Soft leather jackets',
            'description' => 'Scelerisque duis aliquam qui lorem ipsum dolor amet, consectetur adipiscing elit.',
        ],

        [
            'image' => 'images/banner-image-4.jpg',
            'title' => 'Soft leather jackets',
            'description' => 'Scelerisque duis aliquam qui lorem ipsum dolor amet, consectetur adipiscing elit.',
        ],

        [
            'image' => 'images/banner-image-5.jpg',
            'title' => 'Soft leather jackets',
            'description' => 'Scelerisque duis aliquam qui lorem ipsum dolor amet, consectetur adipiscing elit.',
        ],

        [
            'image' => 'images/banner-image-6.jpg',
            'title' => 'Soft leather jackets',
            'description' => 'Scelerisque duis aliquam qui lorem ipsum dolor amet, consectetur adipiscing elit.',
        ],
    ];
@endphp

@section('content')
    <section id="billboard" class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <h1 class="section-title text-center mt-4" data-aos="fade-up">New Collections</h1>
                <div class="col-md-6 text-center" data-aos="fade-up" data-aos-delay="300">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe voluptas ut dolorum consequuntur,
                        adipisci
                        repellat! Eveniet commodi voluptatem voluptate, eum minima, in suscipit explicabo voluptatibus
                        harum,
                        quibusdam ex repellat eaque!</p>
                </div>
            </div>
            <div class="row">
                <div class="swiper main-swiper py-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="swiper-wrapper d-flex border-animation-left">
                        @foreach ($images as $image)
                            <div class="swiper-slide">
                                <div class="banner-item image-zoom-effect">
                                    <div class="image-holder">
                                        <a href="#">
                                            <img src="{{ $image['image'] }}" alt="product" class="img-fluid">
                                        </a>
                                    </div>
                                    <div class="banner-content py-4">
                                        <h5 class="element-title text-uppercase">
                                            <a href="index.html" class="item-anchor">{{ $image['title'] }}</a>
                                        </h5>
                                        <p>
                                            {{ $image['description'] }}
                                        </p>
                                        <div class="btn-left">
                                            <a href="#"
                                                class="btn-link fs-6 text-uppercase item-anchor text-decoration-none">Discover
                                                Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="icon-arrow icon-arrow-left"><svg width="50" height="50" viewBox="0 0 24 24">
                        <use xlink:href="#arrow-left"></use>
                    </svg></div>
                <div class="icon-arrow icon-arrow-right"><svg width="50" height="50" viewBox="0 0 24 24">
                        <use xlink:href="#arrow-right"></use>
                    </svg></div>
            </div>
        </div>
    </section>

    <section class="features py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="0">
                    <div class="py-5">
                        <svg width="38" height="38" viewBox="0 0 24 24">
                            <use xlink:href="#calendar"></use>
                        </svg>
                        <h4 class="element-title text-capitalize my-3">Book An Appointment</h4>
                        <p>At imperdiet dui accumsan sit amet nulla risus est ultricies quis.</p>
                    </div>
                </div>
                <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="300">
                    <div class="py-5">
                        <svg width="38" height="38" viewBox="0 0 24 24">
                            <use xlink:href="#shopping-bag"></use>
                        </svg>
                        <h4 class="element-title text-capitalize my-3">Pick up in store</h4>
                        <p>At imperdiet dui accumsan sit amet nulla risus est ultricies quis.</p>
                    </div>
                </div>
                <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="600">
                    <div class="py-5">
                        <svg width="38" height="38" viewBox="0 0 24 24">
                            <use xlink:href="#gift"></use>
                        </svg>
                        <h4 class="element-title text-capitalize my-3">Special packaging</h4>
                        <p>At imperdiet dui accumsan sit amet nulla risus est ultricies quis.</p>
                    </div>
                </div>
                <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="900">
                    <div class="py-5">
                        <svg width="38" height="38" viewBox="0 0 24 24">
                            <use xlink:href="#arrow-cycle"></use>
                        </svg>
                        <h4 class="element-title text-capitalize my-3">free global returns</h4>
                        <p>At imperdiet dui accumsan sit amet nulla risus est ultricies quis.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="categories overflow-hidden">
        <div class="container">
            <div class="open-up" data-aos="zoom-out">
                <div class="row">
                    @foreach ($categories as $item)
                        <div class="col-md-4">
                            <div class="cat-item image-zoom-effect">
                                <div class="image-holder">
                                    <a href="{{ route('user.product.index', $item->id) }}">
                                        <img src="{{ Storage::url($item->img) }}" alt="categories" class="product-image img-fluid">
                                    </a>
                                </div>
                                <div class="category-content">
                                    <div class="product-button">
                                        <a href="{{ route('user.product.index', $item->id)}}" class="btn btn-common text-uppercase">{{ $item->name }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
