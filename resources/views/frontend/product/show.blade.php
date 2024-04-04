@extends('layouts.frontend.app')
@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <a href="">{{ $data['product']->categori->name }}</a>
                        <span>{{ $data['product']->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product__details__pic">
                        <div class="product__details__slider__content">
                            <div class="product__details__pic__slider owl-carousel">
                                <img data-hash="product-1" class="product__big__img"
                                    src="{{ asset('storage/image/product/' . $data['product']->thumbnails) }}"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product__details__text">
                        <h3>{{ $data['product']->name }} <span>Kategori: {{ $data['product']->categori->name }}</span></h3>
                            <div class="product__details__price">{{ rupiah($data['product']->price) }}<span></div>
                        <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
                                    @csrf
                            <div class="product__details__button">
                                @if ($data['variasi_produk']->isNotEmpty())
                                    @php
                                        $warnaExist = false;
                                        $ukuranExist = false;
                                    @endphp

                                    @foreach ($data['variasi_produk'] as $item)
                                        @if ($item->jenis == 'warna')
                                            @php
                                                $warnaExist = true;
                                            @endphp
                                        @elseif ($item->jenis == 'ukuran')
                                            @php
                                                $ukuranExist = true;
                                            @endphp
                                        @endif
                                    @endforeach

                                    @if ($warnaExist)
                                        <div class="row">
                                            <div class="col">
                                                <div class="quantity">
                                                    <span>Warna:</span>
                                                    @foreach ($data['variasi_produk'] as $warna)
                                                        @if ($warna->jenis == 'warna' && $warna->status == '1' )
                                                            <button type="button" class="btn btn-outline-primary btn-warna"
                                                                data-id="{{ $warna->id }}">{{ $warna->spesifikasi }}</button>
                                                        @endif
                                                    @endforeach
                                                    <input type="hidden" id="warna" name="warna">
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($ukuranExist)
                                        <div class="row">
                                            <div class="col">
                                                <div class="quantity">
                                                    <span>Size:</span>
                                                    @foreach ($data['variasi_produk'] as $size)
                                                        @if ($size->jenis == 'ukuran' && $size->status == '1')
                                                            <button type="button" class="btn btn-outline-primary btn-size"
                                                                data-id="{{ $size->id }}">{{ $size->spesifikasi }}</button>
                                                        @endif
                                                    @endforeach
                                                    <input type="hidden" id="size" name="size">
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                @endif

                                <div class="quantity">
                                    <span>Jumlah:</span>
                                    <div class="pro-qty">
                                        <input type="text" name="cart_qty" value="1">
                                    </div>
                                    <input type="hidden" name="cart_product_id" value="{{ $data['product']->id }}">
                                </div>
                                <button type="submit" class="cart-btn" id="simpan"><span class="icon_bag_alt"></span><span
                                        class="text"> Tambah Ke Keranjang</span></button>
                            </div>
                            <div class="product__details__widget">
                        </form>
                        <ul>
                            <li>
                                <span>Berat : </span>
                                <p>{{ $data['product']->weight }} Gram</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Deskripsi Produk</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <h6>Deskripsi Produk</h6>
                            {!! $data['product']->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="related__title">
                    <h5>Produk Lainnya</h5>
                </div>
            </div>
            @foreach ($data['product_related'] as $product_related)
                <div class="col-lg-2 col-md-6 produk produk_show">
                    @component('components.frontend.product-card')
                        @slot('image', asset('storage/image/product/' . $product_related->thumbnails))
                        @slot('route', route('product.show', ['categoriSlug' => trim($product_related->categori->slug),
                            'productSlug' => $product_related->slug]))
                            @slot('name', $product_related->name)
                            @slot('price', rupiah($product_related->price))
                        @endcomponent
                    </div>
                @endforeach
            </div>
            </div>
        </section>
        <!-- Product Details Section End -->
    @endsection
    @push('js')
      
            <script>

                document.addEventListener('DOMContentLoaded', function() {
                    @if (!$data['variasi_produk']->isEmpty())
                    const sizeButtons = document.querySelectorAll('.btn-size');
                    const colorButtons = document.querySelectorAll('.btn-warna');
                    const selectedSizeInput = document.getElementById('size');
                    const selectedColorInput = document.getElementById('warna');

                    // Tambahkan event listener untuk tombol ukuran
                    sizeButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            // Menghapus kelas 'active' dari semua tombol ukuran baju
                            sizeButtons.forEach(btn => {
                                btn.classList.remove('active');
                            });

                            // Menambahkan kelas 'active' ke tombol yang diklik
                            this.classList.add('active');

                            // Mengatur nilai input tersembunyi dengan ukuran yang dipilih
                            const selectedSize = this.getAttribute('data-id');
                            selectedSizeInput.value = selectedSize;
                        });
                    });

                    // Tambahkan event listener untuk tombol warna
                    colorButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            // Menghapus kelas 'active' dari semua tombol warna baju
                            colorButtons.forEach(btn => {
                                btn.classList.remove('active');
                            });

                            // Menambahkan kelas 'active' ke tombol yang diklik
                            this.classList.add('active');

                            // Mengatur nilai input tersembunyi dengan warna yang dipilih
                            const selectedColor = this.getAttribute('data-id');
                            selectedColorInput.value = selectedColor;
                        });
                    }); 
                    @endif
                    $('#simpan').click(function(e) {
                    e.preventDefault();
                    var formData = new FormData($('#form-data')[0]);
                    $.ajax({
                        url: "/cart/store",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            swal.fire({
                                html: '<h5>Loading...</h5>',
                                showConfirmButton: false
                            });
                        },
                        success: function(result) {
                            if (result.type == 'success') {
                                location.href = "/cart";
                            } else {
                                swal.fire({
                                    title: result.title,
                                    text: result.text,
                                    confirmButtonColor: result
                                        .ButtonColor,
                                    type: result.type,
                                });
                            }
                        }
                    });
                });

                });
            </script>
       
    @endpush
