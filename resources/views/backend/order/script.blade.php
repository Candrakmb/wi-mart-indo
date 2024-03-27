<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script>
    var data = function() {
        let valid = true,
            real = '',
            message = '',
            title = '',
            type = '';
        var dt = new Date();
        var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
        let scannedContents = [];
        var table = function() {
            swal.fire({
                html: '<h5>Loading...</h5>',
                showConfirmButton: false
            });
            var t = $('#table').DataTable({
                processing: true,
                pageLength: 10,
                serverSide: true,
                searching: true,
                bLengthChange: true,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Semua"]
                ],
                destroy: true,
                dom: 'Blfrtip',
                buttons: [{
                    extend: 'excel',
                    title: '{{ $title }} - ' + time,
                    text: '<i class="fa fa-file-excel-o"></i> Cetak',
                    titleAttr: 'Cetak',
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            page: 'current'
                        }
                    }
                }, ],
                'ajax': {
                    "url": "/order/table/{{ isset($status) ? $status : 'default' }}",
                    "method": "POST",
                    "complete": function() {
                        $('.buttons-excel').hide();
                        swal.close();
                    }
                },
                'columns': [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        class: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        class: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'invoice_number',
                        name: 'invoice_number',
                        class: 'text-left'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name',
                        class: 'text-left'
                    },
                    {
                        data: 'status_name',
                        name: 'status_name',
                        class: 'text-left',
                        orderable: false,
                    },
                    {
                        data: 'metode_pembayaran_name',
                        name: 'metode_pembayaran_name',
                        class: 'text-left',
                        orderable: false,
                    },
                    {
                        data: 'total_pay',
                        name: 'total_pay',
                        class: 'text-left'
                    },
                    {
                        data: 'formatted_created_at',
                        name: 'formatted_created_at',
                        class: 'text-left'
                    },
                ],
                "order": [],
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0]
                }],
                "language": {
                    "lengthMenu": "Menampilkan _MENU_ data",
                    "search": "Cari:",
                    "zeroRecords": "Data tidak ditemukan",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    },
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Data kosong",
                    "infoFiltered": "(Difilter dari _MAX_ total data)"
                }
            });
            filterKolom(t);
            hideKolom(t);
            cetak(t);

        };


        var filterKolom = function(t) {
            $('.toggle-vis').on('change', function(e) {
                e.preventDefault();
                var column = t.column($(this).attr('data-column'));
                console.log(column);
                column.visible(!column.visible());
            });
        }

        var hideKolom = function(t) {
            var arrKolom = [];
            $('.toggle-vis').each(function(i, value) {
                if (!$(value).is(":checked")) {
                    arrKolom.push(i + 2);
                }
            });
            arrKolom.forEach(function(val) {
                var column = t.column(val);
                column.visible(!column.visible());
            });
        }

        var cetak = function(t) {
            $("#btn-cetak").on("click", function() {
                t.button('.buttons-excel').trigger();
            });
        }

        var setData = function() {
            $('#table_processing').html('Loading...');
            $("select[name='name_id']").val('{{ $data == null ? '' : $data->id_orangtua }}').change();
        }

        var muatUlang = function() {
            $('#btn-muat-ulang').on('click', function() {
                $('#table').DataTable().ajax.reload();
            });
        }

        var konfirmasi = function() {
            $('#btn-konfirmasi').click(function(e) {
                e.preventDefault();
                swal.fire({
                        title: 'Apakah Anda Yakin?',
                        text: 'konfirmasi pembayaran ini',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#2196F3',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Tidak'
                    })
                    .then((result) => {
                        if (result.value) {
                                $.ajax({
                                    url: "/order/konfirmasiform",
                                    type: "POST",
                                    data: {
                                        id: "{{ isset($orders) ? $orders->id : 'default' }}",
                                    },
                                    beforeSend: function() {
                                        swal.fire({
                                            html: '<h5>Loading...</h5>',
                                            showConfirmButton: false
                                        });
                                    },
                                    success: function(result) {
                                        if (result.type == 'success') {
                                            swal.fire({
                                                title: result.title,
                                                text: result.text,
                                                confirmButtonColor: result
                                                    .ButtonColor,
                                                type: result.type,
                                            }).then((result) => {
                                                location.href = "/order/all";
                                            });
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
                        } else {
                            swal.fire({
                                text: 'Aksi Dibatalkan!',
                                type: "info",
                                confirmButtonColor: "#EF5350",
                            });
                        }
                    });
            });
        }

        var resi = function() {
            $('#btn-resi').click(function(e) {
                e.preventDefault();
                swal.fire({
                        title: 'Apakah Anda Yakin?',
                        text: 'konfirmasi pembayaran ini',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#2196F3',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Tidak'
                    })
                    .then((result) => {
                        if (result.value) {
                                var formData = new FormData($('#form-data')[0]);
                                $.ajax({
                                    url: "/order/resiform",
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
                                            swal.fire({
                                                title: result.title,
                                                text: result.text,
                                                confirmButtonColor: result
                                                    .ButtonColor,
                                                type: result.type,
                                            }).then((result) => {
                                                window.location.reload();
                                            });
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
                        } else {
                            swal.fire({
                                text: 'Aksi Dibatalkan!',
                                type: "info",
                                confirmButtonColor: "#EF5350",
                            });
                        }
                    });
            });
        }


        return {
            init: function() {
                @if ($type == 'index')
                    table();
                    muatUlang();
                @endif
                setData();
                konfirmasi();
                resi();
            }
        }
    }();
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.fn.dataTable.ext.errMode = 'none';
        data.init();
        
    });

    $(document).on('click', '#btnPrint', function(){
        var data = $('#id-content').html();
        var opt = { filename: 'Laporan Bulan.pdf',
                    margin: [5, 5, 5, 10],
                    image: { type: 'jpeg', quality: 1 },
                    html2canvas:  { dpi: 500,
                                    scale:4,
                                    letterRendering: true,
                                    useCORS: true},
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
