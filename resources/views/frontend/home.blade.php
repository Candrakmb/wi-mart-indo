@extends('layouts.frontend.app')
@section('content')
    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-0">
                    <div class="categories__item categories__large__item set-bg"
                        data-setbg="{{ asset('img') }}/goku.png">
                        <div class="categories__text">
                            <p>Beragam Merchandise Anime Mulai Dari Tshirt, Hoddie, Action Figure Semuanya Tersedia Di Anime
                                Store.</p>
                            <a href="#">Jelajahi Sekarang</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        @for ($i = 0; $i < 4; $i++)
                            <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                                <div class="categories__item set-bg"
                                    data-setbg="{{ asset('img') }}/goku.png">
                                    <div class="categories__text">
                                        <h4>KAOS</h4>
                                        <p>10 item</p>
                                        <a href="#">Jelajahi</a>
                                    </div>
                                </div>
                            </div>
                        @endfor
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
                <div class="col-lg-8 col-md-8">
                    <ul class="filter__controls">
                        <li class="active" data-filter="*">All</li>
                        {{-- @foreach ($data['new_categories'] as $new_categories) --}}
                            {{-- <li data-filter=".{{ $new_categories->slug }}">{{ $new_categories->name }}</li> --}}
                        {{-- @endforeach --}}
                    </ul>
                </div>
            </div>
            <div class="row property__gallery">
                {{-- @foreach ($data['new_categories'] as $new_categories2) --}}
                    {{-- @foreach ($new_categories2->Products()->limit(4)->get() as $product) --}}
                    @for ($i = 0; $i < 4; $i++)
                        <div class="col-lg-3 col-md-4 col-sm-6 mix {{-- $new_categories2->slug --}}">
                            @component('components.frontend.product-card')
                                @slot('image', asset('img/product.jpg'))
                                @slot('route', '#')
                                    @slot('name', 'KAOS')
                                    @slot('price', 120000)
                                @endcomponent
                            </div>
                        {{-- @endforeach --}}
                    {{-- @endforeach --}}
                    @endfor
                </div>
            </div>
        </section>
        <!-- Product Section End -->
    @endsection
