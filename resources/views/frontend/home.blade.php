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
                            <p>Mulai Belanja Sekarang di Wi Mart</p>
                            <a  href="/product_list">Jelajahi Sekarang</a>
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
                            @component('components.frontend.product-card')
                                @slot('image', asset('storage/image/product/' . $product->thumbnails))
                                @slot('route', route('product.show', ['categoriSlug' => trim($product->categori->slug), 'productSlug' =>
                                $product->slug]))
                                    @slot('name', $product->name)
                                    @slot('price', $product->price)
                            @endcomponent
                        </div>
                    @endforeach
                @endforeach
            </div>
        </section>
        <!-- Product Section End -->
    @endsection
