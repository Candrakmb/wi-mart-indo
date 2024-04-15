@extends('layouts.frontend.app')
@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home&nbsp;</a>
                        <span>Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="shop-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 container_cart">
                    <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
                        @csrf
                    <div class="shop__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['carts'] as $carts)
                                    <tr>
                                        <td class="cart__product__item">
                                            <img src="{{ $carts->Product->thumbnails_path}}" alt="" width="90">
                                            <div class="cart__product__item__title">
                                                <h6> {{ $carts->Product->name }}
                                                    {{ $carts->variasi_warna_id != null ? "Warna :  {$carts->variasiWarna->spesifikasi}" : '' }}
                                                    {{ $carts->variasi_ukuran_id != null ? "Size : " . strtoupper($carts->variasiUkuran->spesifikasi) : '' }} </h6>
                                            </div>
                                        </td>
                                        <td class="cart__price">{{ $carts->Product->price_rupiah }}</td>
                                        <input type="hidden" name="cart_id[]" value="{{ $carts->id }}">
                                        <input type="hidden" name="cart_price[]" value="{{ $carts->Product->price }}">
                                        <td class="cart__quantity">
                                            <div class="pro-qty">
                                                <input type="number" value="{{ $carts->qty }}" id="cart" name="cart_qty[]" readonly>
                                            </div>
                                        </td>
                                        <td class="cart__total">{{ rupiah($carts->total_price_per_product) }}</td>
                                        <td class="cart__close"><a href="{{ route('cart.delete',$carts->id) }}"><span class="icon_close"></span></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row cart_bottom">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn">
                        <a href="{{ route('product.index') }}">Continue Shopping</a>
                    </div>
                </div>
                {{-- <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn update__btn">
                        <button type="submit"><span class="icon_loading"></span> Update cart</button>
                    </form>
                    </div>
                </div> --}}
            </div>
            <div class="row cart_total">
                <div class="col-lg-6">
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <div class="cart__total__procced">
                        <h6>Cart total</h6>
                        <ul>
                            <li>Total <span id="totalpay"> {{ rupiah($data['carts']->sum('total_price_per_product')) }}</span></li>
                        </ul>
                        <a href="{{ route('checkout.index') }}" class="primary-btn">Proceed to checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
<script>
    var data = (function () {
        var updateCart = function() {
            var totalpay = $('#totalpay');
            var proQty = $('.pro-qty');
            proQty.on('click', '.qtybtn', function() {
                var $button = $(this);
                var $input = $button.siblings('input[name="cart_qty[]"]');
                var oldValue = parseFloat($input.val());
                var price = $input.closest('tr').find('input[name="cart_price[]"]').val();

                var totalPrice = oldValue * price;

                // Update tampilan total harga
                var $totalPriceElement = $button.closest('tr').find('.cart__total');
                $totalPriceElement.text(rupiah(totalPrice));
                update();
                updateTotalPrice();
            });
        };

        var  updateTotalPrice = function() {
            var total = 0;
            $('.cart__total').each(function() {
                var priceText = $(this).text().trim(); // Ambil teks total harga per item
                var price = parseFloat(priceText.replace('Rp ', '').replace('.', '').replace(',', '.')); // Konversi teks menjadi angka
                total += price; // Tambahkan ke total
            });

            // Update tampilan total keseluruhan
            $('#totalpay').text(rupiah(total));
        }

        var update = function() {
            var formData = new FormData($('#form-data')[0]);
                                $.ajax({
                                    url: "/cart/update",
                                    type: "POST",
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(result) {
                                    }
                                });
        }


        return {
            init: function(){
                updateCart();
            }
        };
    })();

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        data.init();
    });
</script>
@endpush