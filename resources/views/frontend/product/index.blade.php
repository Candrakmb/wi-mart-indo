@extends('layouts.frontend.app')
@section('content')
     <!-- Breadcrumb Begin -->
     <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.html"><i class="fa fa-home"></i> Home</a>
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
                        @for ($i = 0; $i < 4; $i++)
                        <div class="col-lg-3 col-md-4">
                            @component('components.frontend.product-card')
                                @slot('image', asset('img/product.jpg'))
                                @slot('route', '#')
                                    @slot('name', 'KAOS')
                                    @slot('price', 120000)
                            @endcomponent
                        </div>
                        @endfor
                        <div class="col-lg-12 text-center">
                          {{-- {{ $data['product']->links('vendor.pagination.custom') }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->
@endsection