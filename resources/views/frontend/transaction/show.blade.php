@extends('layouts.frontend.app')
@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <a href="{{ route('transaction.index') }}"> Transaction</a>
                        <span>{{ $data['order']->invoice_number }}</span>
                        <span>Nomor Invoice</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="shop-cart spad">
        <div class="card p-3">
            <div class="card-body" id="id-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice" style="border-top: 2px solid #6777ef;">
                                <div class="invoice-print">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="invoice-title">
                                                <h2>Invoice</h2>
                                                <div class="invoice-number">No Order : {{ $data['order']->invoice_number }}
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <address>
                                                        <strong>{{ __('text.billed_to') }}:</strong><br>
                                                        {{ $data['order']->user->name }}<br>
                                                        {{ $data['order']->user->email }}<br>
                                                    </address>
                                                </div>
                                                <div class="col-md-6 text-md-right">
                                                    <address>
                                                        <strong>{{ __('text.shipped_to') }} :</strong><br>
                                                        {{ $data['order']->recipient_name }}<br>
                                                        {{ $data['order']->address_detail }}<br>
                                                        {{ $data['order']->destination }}
                                                    </address>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <address>
                                                        <strong>{{ __('text.order_status') }} :</strong>
                                                        <div class="mt-2 ">
                                                            {!! $data['order']->status_name !!}
                                                        </div>
                                                    </address>
                                                </div>
                                                <div class="col-md-6 text-md-right">
                                                    <address>
                                                        <strong> {{ __('text.order_date') }}:</strong><br>
                                                        {{ $data['order']->created_at }}<br><br>
                                                    </address>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <div class="section-title font-weight-bold">{{ __('text.order_summary') }}
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover table-md">
                                                    <tbody>
                                                        <tr>
                                                            <th data-width="40" style="width: 40px;">#</th>
                                                            <th>{{ __('field.product_name') }}</th>
                                                            <th class="text-center">{{ __('field.price') }}</th>
                                                            <th class="text-center">{{ __('text.quantity') }}</th>
                                                            <th class="text-right">Total</th>
                                                        </tr>
                                                        @foreach ($data['order']->orderDetail()->get() as $detail)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $detail->product->name }}
                                                                    {{-- <a>
                                                                    href="{{ route('product.show', ['categoriSlug' => $detail->Product->category->slug, 'productSlug' => $detail->Product->slug]) }}">{{ $detail->product->name }}
                                                                </a> --}}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ rupiah($detail->product->price) }}
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
                                                        <strong>{{ __('text.shipping_method') }}</strong>
                                                        <div class="mt-2">
                                                            <p class="section-lead text-uppercase">
                                                                {{ $data['order']->courier }}
                                                                {{ $data['order']->shipping_method }}</p>
                                                        </div>
                                                    </address>
                                                    @if ($data['order']->receipt_number != null)
                                                        <address>
                                                            <strong>{{ __('text.receipt_number') }}:</strong>
                                                            <div class="mt-2">
                                                                <p class="section-lead text-uppercase">
                                                                    {{ $data['order']->receipt_number }}</p>
                                                            </div>
                                                        </address>
                                                    @endif
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="table-responsive">
                                                        <table class="table table-borderless">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-left">Subtotal</td>
                                                                    <td>:</td>
                                                                    <td class="text-right">
                                                                        {{ rupiah($data['order']->subtotal) }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>shipping cost</td>
                                                                    <td>:</td>
                                                                    <td class="text-right">
                                                                        {{ rupiah($data['order']->shipping_cost) }}</td>
                                                                </tr>
                                                                @if ($data['order']->kode_unik != null)
                                                                    <tr>
                                                                        <td>Kode unik</td>
                                                                        <td>:</td>
                                                                        <td class="text-right">
                                                                            {{ rupiah($data['order']->kode_unik) }}</td>
                                                                    </tr>
                                                                @endif
                                                                <tr class="border-top">
                                                                    <td>Total</td>
                                                                    <td>:</td>
                                                                    <td class="text-right">
                                                                        {{ rupiah($data['order']->total_pay) }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="text-md-right">
                                            <div class="float-lg-left mb-lg-0 mb-3">
                                                @if ($data['order']->status == 0)
                                                    <button class="btn btn-primary btn-icon icon-left" data-toggle="modal"
                                                        data-target="#pilihMetodePay" id="payment"><i
                                                            class="fa fa-credit-card"></i>
                                                        Process Payment</button>
                                                    <a href="{{ route('transaction.canceled', $data['order']->invoice_number) }}"
                                                        class="btn btn-danger btn-icon icon-left"><i
                                                            class="fa fa-times"></i>
                                                        Cancel Order</a>
                                                @elseif ($data['order']->status == 2)
                                                    <a href="{{ route('transaction.received', $data['order']->invoice_number) }}"
                                                        class="btn btn-primary text-white btn-icon icon-left"><i
                                                            class="fa fa-credit-card"></i>
                                                        Order Received</a>
                                                @endif
                                            </div>
                                            <button class="btn btn-warning btn-icon icon-left" id="btnPrint"><i
                                                    class="fa fa-print"></i>
                                                Print</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container" id="content-print">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="card-title">Order Track</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="activities">
                                        @foreach ($data['order']->OrderTrack()->get() as $orderTrack)
                                            <div class="activity">
                                                <div class="activity-icon bg-primary text-white shadow-primary">
                                                    <i class="{{ $orderTrack->icon }}"></i>
                                                </div>
                                                <div class="activity-detail bg-primary text-white">
                                                    <div class="mb-2">
                                                        <span
                                                            class="text-job text-white">{{ $orderTrack->created_at->diffForHumans() }}</span>
                                                        <span class="bullet"></span>
                                                    </div>
                                                    <p>{{ __($orderTrack->description) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal pilih pembayaran -->
        <div class="modal fade" id="pilihMetodePay" tabindex="-1" aria-labelledby="pilihMetodePayLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pilihMetodePayLabel">Metode Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="sidenav">
                            <button class="dropdown-btn" id="manualPay">Transfer Bank
                                <i class="fa fa-caret-down"></i>
                            </button>
                            <div class="dropdown-container" id="listBank">
                                @foreach ($data['bank'] as $bank)
                                    <button class="down payManual" data-id="{{ $bank->id }}"
                                        data-nama="{{ $bank->nama_bank }}" data-atasNama="{{ $bank->atas_nama }}"
                                        data-rek="{{ $bank->no_rekening }}"
                                        data-total="{{ $data['order']->total_pay }}">{{ strtoupper($bank->nama_bank) }}</button>
                                @endforeach
                            </div>
                            <button class="down" id="pay-button">Transfer Online</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal proses pembayran offline -->
        <div class="modal fade" id="prosesPembayaran" tabindex="-1" aria-labelledby="prosesPembayaran"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="prosesPembayaran">Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="contenModel">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
@endsection
@push('js')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script>
        const payButton = document.querySelector('#pay-button');
        

        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        document.addEventListener('DOMContentLoaded', function() {
            let pembayaran = JSON.parse(localStorage.getItem('pembayaran'));
            // Jika nilai tidak ada di Local Storage, inisialisasi dengan nilai default
            if (!pembayaran) {
                pembayaran = {
                    statusMetodePembayaran: '0',
                    idBank: '',
                    namaBank: '',
                    noRek: '',
                    total: '',
                    nRandom: '',
                    atasNama: '',
                    startTime: '',
                    sudahBayar: false
                };
                localStorage.setItem('pembayaran', JSON.stringify(pembayaran));
            }
            if ('{{ $data['order']->status }}' != 0) {
                // Mengecek status pembayaran

                // Memastikan pembayaran ada dalam local storage sebelum dihapus
                if (pembayaran) {
                    localStorage.removeItem('pembayaran');
                }
            }

        });

        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        };

        document.addEventListener('DOMContentLoaded', function() {
            const payment = document.querySelector('#payment');
            if (payment) {
                payment.addEventListener('click', function(e) {

                    const pembayaran = JSON.parse(localStorage.getItem('pembayaran'));
                    const statusMetodePembayaran = pembayaran.statusMetodePembayaran;

                    const payButton = document.getElementById('pay-button');
                    const listBank = document.getElementById('listBank');
                    const manualPayButton = document.getElementById('manualPay');
                    if (statusMetodePembayaran === '1') {
                        manualPayButton.style.display = 'block';
                        listBank.innerHTML = '';
                        payButton.style.display = 'none';
                        const pembayaran = JSON.parse(localStorage.getItem('pembayaran'));
                        const statusMetodePembayaran = pembayaran.statusMetodePembayaran;
                        const idBank = pembayaran.idBank;
                        const nRandom = pembayaran.nRandom;
                        const nama_bank = pembayaran.namaBank;
                        const no_rekening = pembayaran.noRek;
                        const atas_nama = pembayaran.atasNama;
                        const total = pembayaran.total;
                        const sudahBayar = pembayaran.sudahBayar;
                        pembayaran.startTime = '{{ $data['order']->updated_at }}';
                        localStorage.setItem('pembayaran', JSON.stringify(pembayaran));
                        manualPayButton.addEventListener('click', function(e) {
                            $('#pilihMetodePay').modal('hide');
                            if (!sudahBayar) {
                                createModalDetail(idBank, nama_bank, atas_nama, no_rekening, total,
                                    nRandom);
                            } else {
                                createKonfirmasi();
                            }

                        })
                    } else if (statusMetodePembayaran === '2') {
                        payButton.style.display = 'block';
                        manualPayButton.style.display = 'none';
                        listBank.style.display = 'none';

                    } else {
                        payButton.style.display = 'block';
                        manualPayButton.style.display = 'block';
                    }
                });
            }
        });



        document.querySelectorAll('.payManual').forEach(function(button) {
            button.addEventListener('click', function() {
                var dataId = this.getAttribute('data-id');
                var nama = this.getAttribute('data-nama');
                var atasNama = this.getAttribute('data-atasNama');
                var noRek = this.getAttribute('data-rek');
                var total = parseInt(this.getAttribute('data-total'));
                var nRandom = Math.floor(Math.random() * 81) + 20;
                total = total + nRandom;
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var startTime = new Date();
                console.log(dataId, nama, atasNama, noRek, total);

                let pembayaran = JSON.parse(localStorage.getItem('pembayaran'));
                pembayaran.statusMetodePembayaran = '1';
                pembayaran.idBank = dataId;
                pembayaran.nRandom = nRandom;
                pembayaran.namaBank = nama;
                pembayaran.noRek = noRek;
                pembayaran.atasNama = atasNama;
                pembayaran.total = total;
                pembayaran.startTime = startTime;
                localStorage.setItem('pembayaran', JSON.stringify(pembayaran));

                $.ajax({
                    type: "POST",
                    url: "/transaction/metodePembayaran",
                    data: {
                        invoice: '{{ $data['order']->invoice_number }}',
                        method: '0',
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        var timeStart = '{{ $data['order']->updated_at }}';
                        console.log(timeStart);
                        // Lakukan tindakan tambahan jika diperlukan setelah permintaan berhasil
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });

                // Menutup modal jika diperlukan
                $('#pilihMetodePay').modal('hide');
                // Membuat modal detail jika diperlukan
                createModalDetail(dataId, nama, atasNama, noRek, total, nRandom);
            });
        });

        function createModalDetail(dataId, nama, atasNama, noRek, total, nRandom) {
            var modalBody = document.querySelector('#prosesPembayaran .modal-body');
            modalBody.innerHTML = '';
            const pembayaran = JSON.parse(localStorage.getItem('pembayaran'));
            var startTime = new Date(pembayaran.startTime);
            // Menambahkan 5 menit ke waktu awal untuk mendapatkan waktu akhir
            var endTime = new Date(startTime.getTime() + 5 * 60000);
            var endTimeFormatted = endTime.toLocaleString();
            // 5 menit dalam milidetik
            console.log(startTime);
            var html = "";
            var totalRupiah = formatRupiah(total);
            var upBank = nama.toUpperCase();
            html += `
            <div class="row justify-content-md-center">
            <div class="col-md-auto" style="width: 80%;">
            <div class="card" style="width: auto;">
                <div class="card-body">
                    <div id="alertMessage" class="alert alert-success" style="display: none;">Copied!</div>
                    <div class="row col-md-12 ">
                        <div class="col-md-12 mb-3">
                            <p style="font-size: 12px; margin: 0; padding: 0;">Bayar sebelum ${endTimeFormatted}</p>
                            <div style="color: red;" id="countdown"></div>
                            <hr>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                           <img src="{{ asset('/img/bill.gif') }}">
                        </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5> Bank ${upBank} </h5>
                            <h5> ${atasNama}</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control" id="myInput" value="${noRek}" aria-describedby="button-addon2" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="button" id="button-addon2"  onclick="copyText('myInput')">Salin</button>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p>Jumlah Transfer</p>
                            <div class="input-group mb-3">
                            <input type="text" class="form-control" id="myInputTotal" value="${totalRupiah}" aria-describedby="button-addon2" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="button" id="button-addon2"  onclick="copyText('myInputTotal')">Salin</button>
                            </div>
                            </div>
                        </div>
                        <p style="font-size: 10px;"> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> pastikan jumlahnya benar hingga digit terakhir</p>
                        
                    </div>
                </div>
            </div>
            <div class="text-center">
            <button class="btn btn-primary" style="width: 100%" id="konfirmasi">saya sudah transfer</button>
            </div>
            </div>
            </div>
            `;
            $('#contenModel').append(html);
            startCountdown(endTime);
            $('#prosesPembayaran').modal('show');

            document.querySelectorAll('#konfirmasi').forEach(function(buttonKonfirmasi) {
                buttonKonfirmasi.addEventListener('click', function() {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    console.log(dataId, nama, atasNama, noRek, total, nRandom);
                    $('#pilihMetodePay').modal('hide');
                    let pembayaran = JSON.parse(localStorage.getItem('pembayaran'));
                    pembayaran.sudahBayar = true;
                    localStorage.setItem('pembayaran', JSON.stringify(pembayaran));
                    $.ajax({
                        type: "POST",
                        url: "/transaction/updatePembayaranManual",
                        data: {
                            invoice: '{{ $data['order']->invoice_number }}',
                            nRandom: nRandom,
                            total: total,
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            console.log(response);
                            // Lakukan tindakan tambahan jika diperlukan setelah permintaan berhasil
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "/notifikasi",
                        data: {
                            invoice: '{{ $data['order']->invoice_number }}',
                            total: total,
                            idBank: dataId,
                            tipe: '0',
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            console.log(response);
                            // Lakukan tindakan tambahan jika diperlukan setelah permintaan berhasil
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                    createKonfirmasi();
                });
            });
        }

        function createKonfirmasi() {
            var modalBody = document.querySelector('#prosesPembayaran .modal-body');
            modalBody.innerHTML = '';
            var html = "";
            html += `
            <div class="row justify-content-md-center">
                <div class="col-md-auto" style="width: 80%;">
                    <div class="card" style="width: auto;">
                         <div class="card-body">
                            <div class="text-center">
                            <p class="card-text">Wi-Mart sedang memvalidasi pembayaranmu. Mohon tunggu hingga proses validasi selesai</p>
                            <img class="img-fluid"  src="{{ asset('/img/bill.gif') }}">
                            </div>
                        </div>
                     </div>
                </div>
             </div>
            `;
            $('#contenModel').append(html);
            $('#prosesPembayaran').modal('show');
        }

        function copyText(inputId) {
            // Get the text field based on inputId parameter
            var copyText = document.getElementById(inputId);
            if (inputId === 'myInputTotal') {
                // Remove "Rp" and dots (.) from total value
                var totalValue = copyText.value.replace(/Rp|\./g, '');
                copyText.value = totalValue;
            }
            // Select the text in the field
            copyText.select();
            copyText.setSelectionRange(0, copyText.value.length); // Select all text in the field

            // Copy the text to clipboard
            document.execCommand("copy");
            var alertMessage = document.getElementById("alertMessage");
            alertMessage.style.display = "block";

            // Hide the alert message after 2 seconds
            setTimeout(function() {
                alertMessage.style.display = "none";
            }, 1500);
        }

        payButton.addEventListener('click', function(e) {
            $('#pilihMetodePay').modal('hide');
            adminMidtrans();
        });

        function adminMidtrans() {
            var totalPay = parseInt('{{$data['order']->total_pay}}');
            var adminBank = 5000;
            var totalMidtrans = rupiah(totalPay + adminBank);
            var modalBody = document.querySelector('#prosesPembayaran .modal-body');
            modalBody.innerHTML = '';
            var html = "";
            html += `
            <div class="row justify-content-md-center">
                <div class="col-md-auto" style="width: auto;">
                    <div class="card" style="width: auto;">
                         <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                        <td class="text-left">Total</td>
                                        <td>:</td>
                                        <td class="text-right">{{ rupiah($data['order']->total_pay) }}</td>
                                        </tr>
                                        <tr>
                                        <td class="text-left">Admin Bank</td>
                                        <td>:</td>
                                        <td class="text-right">Rp5.000</td>
                                        </tr>
                                        <tr class="border-top">
                                        <td class="text-left">Total Bayar</td>
                                        <td>:</td>
                                        <td class="text-right">${totalMidtrans}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-primary" style="width: 100%" id="midtrans-pay">Bayar</button>
                        </div>
                     </div>
                </div>
             </div>
            `;
            $('#contenModel').append(html);
            $('#prosesPembayaran').modal('show');
            const midtransPay = document.querySelector('#midtrans-pay');
            midtransPay.addEventListener('click', function(e) {
                e.preventDefault();
                let pembayaran = JSON.parse(localStorage.getItem('pembayaran'));
                // Mengubah nilai statusMetodePembayaran menjadi '1'
                pembayaran.statusMetodePembayaran = '2';

                // Menyimpan objek pembayaran yang sudah diubah kembali ke local storage
                localStorage.setItem('pembayaran', JSON.stringify(pembayaran));
                $('#prosesPembayaran').modal('hide');
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: "POST",
                    url: "/transaction/metodePembayaran",
                    data: {
                        invoice: '{{ $data['order']->invoice_number }}',
                        method: '1',
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        console.log(response);
                        // Lakukan tindakan tambahan jika diperlukan setelah permintaan berhasil
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });

                snap.pay('{{ $data['order']->snap_token }}', {
                    // Optional
                    onSuccess: function(result) {
                        console.log(result.order_id);
                        $.ajax({
                            type: "POST",
                            url: "/notifikasi",
                            data: {
                                invoice: result.order_id,
                                tipe: '1',
                            },
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function(response) {
                                console.log(response);
                                // Lakukan tindakan tambahan jika diperlukan setelah permintaan berhasil
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                        localStorage.removeItem('pembayaran');
                    },
                    // Optional
                    onPending: function(result) {
                        /* You may add your own js here, this is just example */
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        console.log(result)
                    },
                    // Optional
                    onError: function(result) {
                        /* You may add your own js here, this is just example */
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        console.log(result)
                    }
                });
            });
        }

        function startCountdown(endTime) {
            // Mendapatkan elemen tempat timer akan ditampilkan
            var countdownElement = document.getElementById('countdown');

            // Perbarui tampilan awal timer
            updateCountdown();

            // Tetapkan interval untuk memperbarui timer setiap detik
            var countdownInterval = setInterval(updateCountdown, 1000);

            function updateCountdown() {
                // Hitung selisih antara waktu sekarang dan waktu akhir
                var timeDifference = endTime - new Date().getTime();

                // Hitung sisa waktu dalam jam, menit, dan detik
                var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

                // Format tampilan timer
                var countdownText = hours + ' jam ' + minutes + ' menit ' + seconds + ' detik';

                // Perbarui tampilan timer
                countdownElement.textContent = countdownText;

                // Hentikan hitungan mundur jika waktu sudah habis
                if (timeDifference <= 0) {
                    clearInterval(countdownInterval);
                    const tombolKonfirmasi = document.getElementById('konfirmasi');
                    tombolKonfirmasi.disabled = true;
                    localStorage.removeItem('pembayaran');
                    window.location.href = '{{ route('transaction.expired', $data['order']->invoice_number) }}'
                    countdownElement.textContent = 'Waktu pembayaran habis';
                    // Tindakan tambahan jika diperlukan saat waktu habis
                }
            }
        }

        function formatRupiah(angka) {
            var number_string = angka.toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang diinput sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return 'Rp ' + rupiah;
        }

        $(document).on('click', '#btnPrint', function() {
            var data = $('#id-content').html();
            var opt = {
                filename: 'Laporan Bulan.pdf',
                margin: [5, 5, 5, 10],
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    dpi: 500,
                    scale: 4,
                    letterRendering: true,
                    useCORS: true
                },
                pagebreak: {
                    mode: ['avoid-all', 'css', 'legacy']
                },
            };
            html2pdf().set(opt).from(data).toPdf().get('pdf').then((pdf) => {
                var totalPages = pdf.internal.getNumberOfPages();

                for (let i = 1; i <= totalPages; i++) {
                    // set footer to every page
                    pdf.setPage(i);
                    // set footer font
                    pdf.setFontSize(10);
                    pdf.setTextColor(150);
                    // this example gets internal pageSize just as an example to locate your text near the borders in case 
                }

            }).save();
        })
    </script>
@endpush
@push('style')
    <style>
        /* Fixed sidenav, full height */
        .sidenav {
            padding-top: 20px;
        }

        /* Style the sidenav links and the dropdown button */
        .sidenav .down,
        .dropdown-btn {
            padding: 6px 8px 6px 16px;
            text-decoration: none;
            font-size: 20px;
            color: #030303;
            display: block;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            outline: none;
        }

        /* On mouse-over */
        .sidenav .down:hover,
        .dropdown-btn:hover {
            color: #f1f1f1;
        }

        /* Main content */
        .main {
            margin-left: 200px;
            /* Same as the width of the sidenav */
            font-size: 20px;
            /* Increased text to enable scrolling */
            padding: 0px 10px;
        }

        /* Add an active class to the active dropdown button */
        .active {
            background-color: rgb(23, 10, 206);
            color: white;
        }

        /* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
        .dropdown-container {
            display: none;
            background-color: rgb(94, 92, 89);
            padding-left: 8px;
        }

        /* Optional: Style the caret down icon */
        .fa-caret-down {
            float: right;
            padding-right: 8px;
        }
    </style>
@endpush
