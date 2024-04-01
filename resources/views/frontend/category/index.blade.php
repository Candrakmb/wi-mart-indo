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
    <section class="categories">
        <div class="container">
            <div class="row">
                @foreach ($data['category'] as $category)
                <div class="col-lg-3 col-md-6 kategori">
                    <a href="{{ route('category.show',$category->slug) }}">
                        <div class="categories__item set-bg" data-setbg="{{ asset('storage/image/kategori/' . $category->thumbnails) }}">
                            <p>{{ $category->name }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
