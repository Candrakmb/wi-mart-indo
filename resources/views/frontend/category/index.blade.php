@extends('layouts.frontend.app')
@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Category</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Categories Section Begin -->
    <section class="categories kategori_container">
        <div class="container">
            <div class="row">
                @foreach ($data['category'] as $category)
                    <div class="col-lg-4 col-md-6 kategori">
                        <div class="categories__item set-bg" data-setbg="{{ asset('storage/image/kategori/' . $category->thumbnails) }}">
                            <div class="categories__card">
                                <h4>{{ $category->name }}</h4>
                                <p>{{ $category->Products()->count() }} Item</p>
                                <a href="{{ route('category.show',$category->slug) }}">Jelajahi</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endsection
