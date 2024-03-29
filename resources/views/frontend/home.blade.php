@extends('layouts.frontend.app')
@section('content')
    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 p-0">
                    <div class="categories__large__item set-bg"
                        data-setbg="{{ asset('img') }}/hero.png">
                        <div class="categories__text">
                            <p>Belanja Hemat Hanya Di WIMART</p>
                            <p class="lorem">Temukan produk berkualitas dengan harga terbaik hanya di WIMART, Jadilah bagian dari komunitas kami yang penuh semangat, Raih kepuasan belanja yang tak terlupakan,Kami tidak hanya menjual produk, tapi juga solusi untuk kebutuhan Anda.Bersama WIMART kita membangun pengalaman belanja yang luar biasa.</p>
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
                        <h4>New Categories</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($data['category'] as $category)
                    <div class="col-lg-4 col-md-6 kategori">
                        <div class="categories__item set-bg" data-setbg="{{ asset('storage/image/kategori/' . $category->thumbnails) }}">
                            <a href="{{ route('category.show',$category->slug) }}">{{ $category->name }}</a>
                        </div>
                    </div>
                @endforeach
            </div>

        <!-- Product Section End -->
    @endsection
