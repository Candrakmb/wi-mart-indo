@extends('layouts.frontend.app')
@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <form action="{{ route('checkout.process') }}" class="checkout__form" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-8 mb-4 checkout_container">
                        <h5>Billing detail</h5>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="checkout__form__input">
                                    <p>Recipient Name <span>*</span></p>
                                    <input type="text" name="recipient_name" value="{{ auth()->user()->name }}" >
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" >
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="checkout__form__input">
                                    <p>Phone Number <span>*</span></p>
                                    <input type="text" name="phone_number" value="{{ auth()->user()->no_whatsapp }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input drop1">
                                    <p>Province <span>*</span></p>
                                    <select name="province_id" id="province_id" class="select-2" >
                                        <option value="" selected disabled>-- Select Province --</option>
                                        @foreach ($data['provinces'] as $province)
                                            <option value="{{ $province['province'] }}" data-id="{{ $province['province_id'] }}">{{ $province['province'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input drop2">
                                    <p class="city_name">City <span>*</span></p>
                                    <select name="city_id" id="city_id" class="select-2" disabled >
                                        <option value="" selected disabled>-- Select City --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="checkout__form__input">
                                    <p>Address Detail <span>*</span></p>
                                    <input type="text" name="address_detail" >
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="checkout__form__input">
                                    <p>Courier <span>*</span></p>
                                    <select name="courier" id="courier">
                                        {{-- <option value="jne" selected>JNE</option>
                                        <option value="tiki">TIKI</option>
                                        <option value="pos">POS INDONESIA</option> --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="checkout__form__input">
                                    <p>Shipment Method <span>*</span></p>
                                    <select name="shipping_method" id="shipping_method" >
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 container_order">
                        <div class="checkout__order">
                            <h5>Your order</h5>
                            <div class="checkout__order__product">
                                <ul>
                                    <li>
                                        <span class="top__text">Product</span>
                                        <span class="top__text__right">Total</span>
                                    </li>
                                    @foreach ($data['carts'] as $cart)
                                        <li>{{ $loop->iteration }}. {{ $cart->Product->name }}
                                            {{ $cart->variasi_warna_id != null ? $cart->variasiWarna->spesifikasi : '' }}
                                            {{ $cart->variasi_ukuran_id != null ? strtoupper($cart->variasiUkuran->spesifikasi) : '' }}
                                             x
                                            {{-- $cart->Product->categori()->first()->name --}}
                                            {{ $cart->qty }}<span>{{ rupiah($cart->total_price_per_product) }}</span>
                                        </li>
                                    @endforeach
                                    <li>
                                        <span class="top__text">Total Weight</span>
                                        <span class="top__text__right">{{ $data['carts']->sum('total_weight_per_product') / 1000 }} Kg</span>
                                        <input type="hidden" name="total_weight" id="total_weight" value="{{ $data['carts']->sum('total_weight_per_product') }}">
                                    </li>
                                </ul>
                            </div>
                            <div class="checkout__order__total">
                                <ul>
                                    <li>Subtotal <span> {{ rupiah($data['carts']->sum('total_price_per_product')) }} </span>
                                    </li>
                                    <li>Shipping Cost <span id="text-cost">Rp 0</span></li>
                                    <li>Total <span id="total">{{ rupiah($data['carts']->sum('total_price_per_product')) }}</span></li>
                                    <input type="hidden" name="shipping_cost" id="shipping_cost" >
                                </ul>
                            </div>
                            <button type="submit" class="site-btn">Place oder</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Checkout Section End -->
@endsection
@push('js')
    <script>
        function checkCost() {
            var origin = '{{ $data["shipping_address"]->city_id }}';
            var destination = $('#city_id option:selected').data('id');
            var weight = "{{ $data['carts']->sum('total_weight_per_product') }}";
            var courier = $('#courier option:selected').val();
            let _url = `/rajaongkir/cost`;
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: "POST",
                data: {
                    origin: origin,
                    destination: destination,
                    weight: weight,
                    courier: courier,
                    _token: _token
                },
                dataType: "json",
                success: function(response) {
                    if (response) {
                        $('#shipping_method').empty();
                        $('#shipping_method').append(
                            'option value="" selected disabled>-- Select Shipment Service --</option>');
                        $.each(response[0].costs, function(key, cost) {
                            $('select[name="shipping_method"]').append('<option value="' + cost.service + ' Rp.' + cost.cost[0].value + ' Estimasi ' +
                                cost.cost[0].etd +
                                '" data-ongkir="'+cost.cost[0].value+'">' + cost.service + ' Rp.' + cost.cost[0].value + ' Estimasi ' +
                                cost.cost[0].etd +
                                '</option>');
                            if (key == 0) {
                                countCost(cost.cost[0].value)
                            }
                        });
                    } else {
                        $('#shipping_method').append(
                            'option value="" selected disabled>-- Select Shipment Service --</option>');
                    }
                },
            });
        }

        function kurirWimart() {
            var idKategori = '{{ $data["kategori"]->id }}';
            var minFreeOngkir = 50000;
            var totalHarga = 0;
            
            @foreach ($data['carts'] as $cart)
        // Periksa apakah produk memiliki kategori dengan ID yang sesuai
                @if ($cart->Product->categories_id == $data['kategori']->id)
                    totalHarga += {{ $cart->total_price_per_product }};
                @endif
            @endforeach
            if( totalHarga >= minFreeOngkir){
                $('#shipping_method').empty();
                $('#shipping_method').append(
                            'option value="" selected disabled>-- Select Shipment Service --</option>');
                $('select[name="shipping_method"]').append('<option value="Free Ongkir Rp0 estimasi 2-4" data-ongkir="0"> Free Ongkir Rp 0 estimasi 2-4</option>')
                var ongkir = parseInt($('#shipping_method option:selected').data('ongkir'));
                countCost(ongkir);
            }else{
                $('#shipping_method').empty();
                $('#shipping_method').append(
                            'option value="" selected disabled>-- Select Shipment Service --</option>');
                $('select[name="shipping_method"]').append('<option value="REG Rp10.000 estimasi 2-4" data-ongkir="10000" > REG Rp10.000 estimasi 2-4</option>')
                var ongkir = parseInt($('#shipping_method option:selected').data('ongkir'));
                countCost(ongkir);
            }
            // console.log('Total harga produk dengan kategori ID 1: ' + totalHarga);
        }

        $('#province_id').on('change', function() {
            var provinceId = $('#province_id option:selected').data('id');
            $('#city_id').empty();
            $('#city_id').append('<option value="">-- Loading Data --</option>');
            $.ajax({
                url: '/rajaongkir/province/' + provinceId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#city_id').empty();
                        $('#city_id').removeAttr('disabled');
                        $('select[name="city_id"]').append(
                            '<option value="" selected>-- Select City --</option>');
                        $.each(data, function(key, city) {
                            $('select[name="city_id"]').append('<option value="' + city
                                .city_name + '" data-id="'+city.city_id+'">' + city.type + ' ' + city.city_name +
                                '</option>');
                        });
                        // checkCost();
                    } else {
                        $('#city_id').empty();
                    }
                }
            });
        });

        $('#city_id').on('change', function() {
            var alamatPengirim = '{{ $data["shipping_address"]->city_id }}';
            var cityId = $('#city_id option:selected').data('id');
            if(alamatPengirim == cityId){
                $('#courier').empty();
                $('#courier').append(
                '<option value="wimart" selected>WIMART</option>');
                kurirWimart()
            }else{
                $('#courier').empty();
                $('#courier').append(
                '<option value="" selected disabled>-- Select Kurir --</option><option value="jne" selected>JNE</option><option value="tiki">TIKI</option><option value="pos">POS INDONESIA</option>');
                checkCost();
            }
        });
        $('#courier').on('change', function() {
            var alamatPengirim = '{{ $data["shipping_address"]->city_id }}';
            var cityId = $('#city_id option:selected').data('id');
            if(alamatPengirim == cityId){
                kurirWimart()
            }else{
                checkCost();
            }
           
        });

        $('#shipping_method').on('change',function(){
                var ongkir = parseInt($('#shipping_method option:selected').data('ongkir'));
                countCost(ongkir);
        })

        function countCost(ongkir)
        {
            var subtotal = `{{$data['carts']->sum('total_price_per_product')}}`;
            var total = parseInt(subtotal) + ongkir;
            // console.log(ongkir)
            $('#text-cost').text(rupiah(ongkir));
            $('#shipping_cost').val(ongkir);
            $('#total').text(rupiah(total))
        }

    </script>
@endpush
