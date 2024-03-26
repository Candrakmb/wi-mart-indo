@extends('layouts.frontend.app')
@section('content')
    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 p-0">
                    <div class="categories__item categories__large__item set-bg"
                        data-setbg="{{ asset('img') }}/hero.png">
                        <div class="categories__text">
                            <p>Belanja Hemat Hanya Di WIMART</p>
                            <p class="lorem">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt odit quae quidem sequi eveniet iure totam optio officiis ea voluptas expedita officia aspernatur illum sint, alias asperiores, quasi ratione accusantium! Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam, sequi deleniti. Enim soluta quasi culpa ea, voluptatem, eius magnam perspiciatis, consectetur nisi id assumenda vitae earum recusandae porro quia placeat?</p>
                            <a class="btn btn-light" href="/product_list">Jelajahi Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="section-title">
                        <h4>New product</h4>
                    </div>
                </div>
            </div>
            <div class="row property__gallery">
                @foreach ($data['new_categories'] as $new_categories2)
                    @foreach ($new_categories2->Products()->limit(2)->get() as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 mix {{ $new_categories2->slug }}">
                        @php
                            // Potong nama produk menjadi 10 kata
                            $productName = implode(' ', array_slice(explode(' ', $product->name), 0, 5));
                        @endphp
                            @component('components.frontend.product-card')
                                @slot('image', asset('storage/image/product/' . $product->thumbnails))
                                @slot('route', route('product.show', ['categoriSlug' => trim($product->categori->slug), 'productSlug' =>
                                $product->slug]))
                                    @slot('name', $productName . (str_word_count($product->name) > 10 ? '...' : ''))
                                    @slot('price', rupiah($product->price))
                            @endcomponent
                        </div>
                    @endforeach
                @endforeach
            </div>
        </section>
        <!-- Product Section End -->
    @endsection
