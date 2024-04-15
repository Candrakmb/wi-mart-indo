<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    {{-- @include('layouts.frontend.data.styles') --}}
    {{-- <link rel="stylesheet" href="{{ asset('ashion') }}/css/bootstrap.min.css" type="text/css"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

</head>

<body>
    <div class="row p-3">
        <div class="row" style="border-top: 2px solid #6777ef;">
            <div class="col-lg-12">
                <table class="table table-borderless">
                    <tbody>
                        <tr class="border-bottom">
                            <td>
                                <h2>Invoice</h2>
                            </td>
                            <td>
                                <div class="text-right">No Order : {{ $order->invoice_number }}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>
                                <div class="text-left">
                                    <address>
                                        <strong>billed to:</strong><br>
                                        {{ $order->user->name }}<br>
                                        {{ $order->user->email }}<br>
                                    </address>
                                </div>
                            </td>
                            <td>
                                <div class="text-right">
                                    <address>
                                        <strong>Shipped to :</strong><br>
                                        {{ $order->recipient_name }}<br>
                                        {{ $order->address_detail }}<br>
                                        {{ $order->destination }}
                                    </address>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>
                                    <address>
                                        <strong>Order Status :</strong>
                                        <div class="mt-2 ">
                                            {!! $order->status_name !!}
                                        </div>
                                    </address>
                                </div>
                            </td>
                            <td>
                                <div class="text-right">
                                    <address>
                                        <strong> order date :</strong><br>
                                        {{ $order->created_at }}<br><br>
                                    </address>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="section-title font-weight-bold">Rincian Order</div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-md">
                        <tbody>
                            <tr>
                                <th data-width="40" style="width: 40px;">#</th>
                                <th>produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-right">Total</th>
                            </tr>
                            @foreach ($order->orderDetail()->get() as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $detail->product->name }}
                                        {{ $detail->variasi_warna_id != null ? "Warna :  {$detail->variasiWarna->spesifikasi}" : '' }}
                                        {{ $detail->variasi_ukuran_id != null ? 'Size : ' . strtoupper($detail->variasiUkuran->spesifikasi) : '' }}
                                        {{-- <a>
                                                        href="{{ route('product.show', ['categoriSlug' => $detail->Product->category->slug, 'productSlug' => $detail->Product->slug]) }}">{{ $detail->product->name }}
                                                    </a> --}}
                                    </td>
                                    <td class="text-center">{{ rupiah($detail->product->price) }}
                                    </td>
                                    <td class="text-center">{{ $detail->qty }}</td>
                                    <td class="text-right">
                                        {{ rupiah($detail->total_price_per_product) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mt-4">
                    <div class="col-md-7">
                        <address>
                            <strong>Shipping method</strong>
                            <div class="mt-2">
                                <p class="section-lead text-uppercase">{{ $order->courier }}
                                    {{ $order->shipping_method }}</p>
                            </div>
                        </address>
                        @if ($order->receipt_number != null)
                            <address>
                                <strong>receipt number:</strong>
                                <div class="mt-2">
                                    <p class="section-lead text-uppercase">
                                        {{ $order->receipt_number }}</p>
                                </div>
                            </address>
                        @endif
                    </div>
                    <div class="col-md-5">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-left">Subtotal</td>
                                    <td>:</td>
                                    <td class="text-right">{{ rupiah($order->subtotal) }}</td>
                                </tr>
                                <tr>
                                    <td>shipping cost</td>
                                    <td>:</td>
                                    <td class="text-right">{{ rupiah($order->shipping_cost) }}</td>
                                </tr>
                                @if ($order->kode_unik != null)
                                    <tr>
                                        <td>Kode unik</td>
                                        <td>:</td>
                                        <td class="text-right">{{ rupiah($order->kode_unik) }}</td>
                                    </tr>
                                @endif
                                <tr class="border-top">
                                    <td>Total</td>
                                    <td>:</td>
                                    <td class="text-right">{{ rupiah($order->total_pay) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>
    {{-- @include('layouts.frontend.data.scripts') --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
</body>

</html>
