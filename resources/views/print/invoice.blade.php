<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> WI-Mart </title>
    {{-- <link rel="stylesheet" href="{{ asset('ashion/css/pdf.css') }}" type="text/css">  --}}
    <style>
        h4 {
            margin: 0;
        }

        .w-full {
            width: 100%;
        }

        .w-half {
            width: 50%;
        }

        .margin-top {
            margin-top: 1.25rem;
        }

        .footer {
            font-size: 0.875rem;
            padding: 1rem;
            background-color: rgb(241 245 249);
        }

        table {
            width: 100%;
            border-spacing: 0;
        }

        table .hitungan{
            width: 100%;
            border-spacing: 2;
        }

        table.products {
            font-size: 0.875rem;
        }

        table.products tr {
            background-color: rgb(96 165 250);
        }

        table.products th {
            color: #ffffff;
            padding: 0.5rem;
        }

        table tr.items {
            background-color: rgb(241 245 249);
            text-align: center;
        }

        table tr.items td {
            padding: 0.5rem;
        }

        .logo-name-container {
            display: flex; /* Menggunakan flexbox untuk mengatur tata letak */
            text-align: center;
        }

        /* Style untuk logo */
        .logo {
            margin-right: 10px; /* Jarak antara logo dan teks */
        }

        /* Style untuk teks nama */
        .logo-text {
            color: #237B9F; /* Warna teks nama */
            font-weight: bold;
        }
        .border-top td {
            border-top: 1px solid #000; /* Atur warna, ketebalan, dan jenis garis sesuai kebutuhan */
        }
        .text-right{
            text-align: right;
        }
        .border-top-top{
            border-top: 2px solid #237B9F;
        }
    </style>
</head>

<body>
    <table class="w-full border-top-top">
        <tr>
            <td style="width:10%">
                <div class="logo-name-container">
                    <div class="logo">
                        <img src="./img/logo.png" alt="Logo" style="width: 50px; display: inline-block;">
                    </div>
                    <div class="logo-text">WimartIndo</div>
                </div>
            </td>
            <td class="w-half">
                <div class="text-right">
                    <h2>Invoice</h2>
                    No Order : {{ $order->invoice_number }}
                </div>
            </td>
        </tr>
    </table>
    <hr>
    <table class="w-full">
        <tr>
            <td class="w-half">
                <address>
                    <strong>billed to:</strong><br>
                    {{ $order->user->name }}<br>
                    {{ $order->user->email }}<br>
                    {{ $order->phone_number }}<br>
                </address>
            </td>
            <td class="w-half text-right">
                <address>
                    <strong>Shipped to :</strong><br>
                    {{ $order->recipient_name }}<br>
                    {{ $order->address_detail }}<br>
                    {{ $order->destination }}
                </address>
            </td>
        </tr>
        <tr>
            <td class="w-half">
                <address>
                    <strong>Order Status :</strong>
                        {!! $order->status_name !!}
                </address>
            </td>
            <td class="w-half text-right">
                <address>
                    <strong> order date :</strong><br>
                    {{ $order->created_at }}<br><br>
                </address>
            </td>
        </tr>
    </table>
    <div class="margin-top">
        <table class="products">
            <tr>
                <th data-width="40" style="width: 40px;">#</th>
                <th>produk</th>
                <th >Harga</th>
                <th >Jumlah</th>
                <th class="text-right" >Total</th>
            </tr>
            @foreach ($order->orderDetail()->get() as $detail)
                <tr class="items">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail->product->name }}
                        {{ $detail->variasi_warna_id != null ? "Warna :  {$detail->variasiWarna->spesifikasi}" : '' }}
                        {{ $detail->variasi_ukuran_id != null ? 'Size : ' . strtoupper($detail->variasiUkuran->spesifikasi) : '' }}
                    </td>
                    <td class="text-center">{{ rupiah($detail->product->price) }}
                    </td>
                    <td class="text-center">{{ $detail->qty }}</td>
                    <td class="text-right">
                        {{ rupiah($detail->total_price_per_product) }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <br>
    <table class="w-full">
        <tr class="border-bottom">
            <td>
                <p style="color: white">aaaaaaaaaaaaaaaaaaaaa</p>
            </td>
            <td>
                <table class="hitungan">
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
                </table>
            </td>
        </tr>
    </table>
    <hr>
    <table class="w-full">
        <tr class="border-bottom">
            <td class="w-half">
                <address>
                    <strong>Shipping method</strong>
                    <div class="mt-2">
                        <p class="section-lead text-uppercase">{{ $order->courier }}
                            {{ $order->shipping_method }}</p>
                    </div>
                </address>
            </td>
            <td class="w-half">
                @if ($order->receipt_number != null)
                    <address>
                        <strong>receipt number:</strong>
                        <div class="mt-2">
                            <p class="section-lead text-uppercase">
                                {{ $order->receipt_number }}</p>
                        </div>
                    </address>
                @endif
            </td>
        </tr>
    </table>

    <div class="footer margin-top">
        <div>Thank you</div>
        <div>&copy; WimartIndo</div>
    </div>
</body>

</html>
