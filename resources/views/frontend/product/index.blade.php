@extends('layouts.frontend.app')
@section('content')
     <!-- Breadcrumb Begin -->
     <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.html"><i class="fa fa-home"></i> Home &nbsp;</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="row">
                        @foreach ($data['product'] as $product)
                        <div class="col-lg-2 col-md-6">
                            @component('components.frontend.product-card')
                                @slot('image', asset('storage/image/product/' . $product->thumbnails))
                                @slot('route', route('product.show', ['categoriSlug' => trim($product->categori->slug), 'productSlug' =>
                                $product->slug]))
                                    @slot('name', $product->name)
                                    @slot('price', rupiah($product->price))
                            @endcomponent
                        </div>
                        @endforeach
                        <div class="col-lg-12 text-center">
                          {{ $data['product']->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->
@endsection