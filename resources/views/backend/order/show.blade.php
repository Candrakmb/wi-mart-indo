<div class="row mt-2">
    <div class="col text-left">
        <a href="{{ url()->previous() }}" type="button" class="btn btn-primary btn-data-sec">
            <i class="fa fa-chevron-left"></i> <span>Kembali</span>
        </a>
    </div>
    <div class=" col text-md-right mb-3 px-4">
        @if ($orders->status == '0' && $orders->metode_pembayaran == '0')
            <button class="btn btn-success btn-icon icon-left" id="btn-konfirmasi"><i class="fa fa fa-check"
                    title="konformasi Pembayaran"></i> Konfirmasi</button>
        @endif
        @if ($orders->status == '1' || $orders->status == '2')
            <button type="button" class="btn btn-primary btn-icon icon-left" data-bs-toggle="modal"
                data-bs-target="#inputResi"><i class="fa fa-print"></i> Input Resi</button>
        @endif
        <button type="button" class="btn btn-warning btn-icon icon-left" id="btnPrint"><i class="fa fa-print"></i>
            Print</button>
    </div>
</div>
{{-- <div class="card"> --}}
    {{-- <div class="card-body" > --}}
        <div class="container" id="id-content">
            <div class="row">
                <div class="col-lg-12 invoice">
                    <div class="invoice" style="border-top: 2px solid #6777ef;">
                        <div class="invoice-print">
                            <div class="row">
                                <div class="col-lg-12">
                                        <div class="invoice-title">
                                                <h2>Invoice</h2>
                                                <div class="invoice-number">No Order : {{ $orders->invoice_number }}</div>
                                        </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <address>
                                                <strong>billed to:</strong><br>
                                                {{ $orders->user->name }}<br>
                                                {{ $orders->user->email }}<br>
                                            </address>
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <address>
                                                <strong>Shipped to :</strong><br>
                                                {{ $orders->recipient_name }}<br>
                                                {{ $orders->address_detail }}<br>
                                                {{ $orders->destination }}
                                            </address>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <address>
                                                <strong>Order Status :</strong>
                                                <div class="mt-2 ">
                                                    {!! $orders->status_name !!}
                                                </div>
                                            </address>
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <address>
                                                <strong> order date :</strong><br>
                                                {{ $orders->created_at }}<br><br>
                                            </address>
                                        </div>
                                    </div>
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
                                                @foreach ($orders->orderDetail()->get() as $detail)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $detail->product->name }} {{ $detail->variasi_warna_id != null ? "Warna :  {$detail->variasiWarna->spesifikasi}" : '' }}
                                                            {{ $detail->variasi_ukuran_id != null ? "Size : " . strtoupper($detail->variasiUkuran->spesifikasi) : '' }}
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
                                                    <p class="section-lead text-uppercase">{{ $orders->courier }}
                                                        {{ $orders->shipping_method }}</p>
                                                </div>
                                            </address>
                                            @if ($orders->receipt_number != null)
                                                <address>
                                                    <strong>receipt number:</strong>
                                                    <div class="mt-2">
                                                        <p class="section-lead text-uppercase">
                                                            {{ $orders->receipt_number }}</p>
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
                                                        <td class="text-right">{{ rupiah($orders->subtotal) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>shipping cost</td>
                                                        <td>:</td>
                                                        <td class="text-right">{{ rupiah($orders->shipping_cost) }}</td>
                                                    </tr>
                                                    @if ($orders->kode_unik != null)
                                                    <tr>
                                                        <td>Kode unik</td>
                                                        <td>:</td>
                                                        <td class="text-right">{{ rupiah($orders->kode_unik) }}</td>
                                                    </tr>
                                                    @endif
                                                    <tr class="border-top">
                                                        <td>Total</td>
                                                        <td>:</td>
                                                        <td class="text-right">{{ rupiah($orders->total_pay) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    {{-- </div> --}}
{{-- </div> --}}


<div class="modal fade" id="inputResi" tabindex="-1" aria-labelledby="inputResiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inputResiLabel">Input Resi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <label for="name" class="label1">Nomer Resi</label><span class="required">*</span>
                            <input type="hidden" name="id" value="{{ $orders->id }}"
                                id="name" class="form-control" required>
                            <input type="text" placeholder="Silahkan Masukkan nomer resi" name="resi"
                                id="name" class="form-control name" required>
                            <p class="help-block" style="display: none;"></p>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-resi">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
