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
                    "url": "/product/table",
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
                        data: 'name',
                        name: 'name',
                        class: 'text-left'
                    },
                    {
                        data: 'slug',
                        name: 'slug',
                        class: 'text-left'
                    },
                    {
                        data: 'categori.name',
                        name: 'categori.name',
                        class: 'text-left'
                    },
                    {
                        data: 'price',
                        name: 'price',
                        class: 'text-left'
                    },
                    {
                        data: 'weight',
                        name: 'weight',
                        class: 'text-left'
                    },
                    {
                        data: 'stok',
                        name: 'stok',
                        class: 'text-left'
                    },
                    {
                        data: 'description',
                        name: 'description',
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
        var addRow = function(){
            $('#add_row').on('click', function(){
                var no = $('.spesifikasi').length;
                var html = "";
                if(no == 0){
                    $('.table_variasi tbody').html("");
                }
                html += ` 
                <tr>
                <th scope="row">${no + 1}</th>
                <td>
                    <label for="jenis[]" class="label1">jenis</label><span class="required">*</span>
                    <select name="jenis[]" class="form-select" required>
                    <option value="" selected disabled>pilih ....</option>
                    <option value="ukuran" >Ukuran</option>
                    <option value="warna" >Warna</option>
                     </select>
                <td>
                    <label for="spesifikasi[]" class="label1">Spesifikasi</label><span class="required">*</span>
                    <input type="text" name="spesifikasi[]" class="form-control spesifikasi"  required>
                </td>
                <td>
                    <label for="stok_variasi[]" class="label1">Stok</label><span class="required">*</span>
                    <input type="number" name="stok_variasi[]" class="form-control stok_variasi"  required>
                </td>
                <td>
                    <label for="status[]" class="label1">Status</label><span class="required">*</span>
                    <select name="status[]" class="form-select" required>
                    <option value="" selected disabled>pilih ....</option>
                    <option value="0" >Kosong</option>
                    <option value="1" >Tersedia</option>
                     </select>
                </td>
                <td>
                <button style="width: 100%; height: 70px;" type="button" class="btn btn-danger btn-raised btn-xs btn-hapus-detail" title="Hapus"><i class="icon-trash"></i></button>
                </td>
                </tr>
                    `;
                $('.table_variasi tbody').append(html);
                deleteRow();
            });
        }
        var deleteRow = function(){
            $('.btn-hapus-detail').unbind().click(function(){
                $(this).parent().parent().remove();
                var html = "";
                var jmlrow = $('.spesifikasi').length;
                if(jmlrow == 0){
                    html += `<tr>
                                <td colspan="99" class="text-center">klik add</td>
                            </tr>`;
                    $('.table_variasi tbody').html(html);
                }
            });
        }
        var create = function() {
            $('#simpan').click(function(e) {
                e.preventDefault();
                swal.fire({
                        title: 'Apakah Anda Yakin?',
                        text: 'Menyimpan Data Ini',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#2196F3',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Tidak'
                    })
                    .then((result) => {
                        if (result.value) {
                            var formdata = $(this).serialize();
                            valid = true
                            var err = 0;
                            $('.help-block').hide();
                            $('.form-error').removeClass('form-error');
                            $('#form-data').find('input, select').each(function() {
                                if ($(this).prop('required')) {
                                    if (err == 0) {
                                        if ($(this).val() == "") {
                                            valid = false;
                                            real = this.name;
                                            title = $('label[for="' + this.name + '"]')
                                                .html();
                                            type = '';
                                            if ($(this).is("input")) {
                                                type = 'diisi';
                                            } else {
                                                type = 'dipilih';
                                            }
                                            err++;
                                        }
                                    }
                                }
                            })
                            if (!valid) {
                                if (type == 'diisi') {
                                    $("input[name=" + real + "]").addClass('form-error');
                                    $($("input[name=" + real + "]").closest('div').find(
                                        '.help-block')).html(title + 'belum ' + type);
                                    $($("input[name=" + real + "]").closest('div').find(
                                        '.help-block')).show();
                                } else {
                                    $("select[name=" + real + "]").closest('div').find(
                                        '.select2-selection--single').addClass('form-error');
                                    $($("select[name=" + real + "]").closest('div').find(
                                        '.help-block')).html(title + 'belum ' + type);
                                    $($("select[name=" + real + "]").closest('div').find(
                                        '.help-block')).show();
                                }

                                swal.fire({
                                    text: title + 'belum ' + type,
                                    type: "error",
                                    confirmButtonColor: "#EF5350",
                                });
                            } else {
                                var formData = new FormData($('#form-data')[0]);
                                $.ajax({
                                    @if ($type == 'create')
                                        url: "/product/createform",
                                    @else
                                        url: "/product/updateform",
                                    @endif
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
                                                location.href = "/product";
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
                            }
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

        var hapus = function(){
            $('#table').on('click', '#btn-hapus', function () {
                var baris = $(this).parents('tr')[0];
                var table = $('#table').DataTable();
                var data = table.row(baris).data();

                swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: 'Menghapus Data Ini',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2196F3',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                })
                .then((result) => {
                    if (result.value) {
                        var fd = new FormData();
                        fd.append('_token','{{ csrf_token() }}');
                        fd.append('id', data.id);

                        $.ajax({
                            url : "/product/deleteform",
                            type : "POST",
                            data : fd,
                            dataType: "json",
                            contentType: false,
                            processData: false,
                            beforeSend: function(){
                                swal.fire({
                                    html: '<h5>Loading...</h5>',
                                    showConfirmButton: false
                                });
                            },
                            success: function(result){
                                swal.fire({
                                    title: result.title,
                                    text : result.text,
                                    confirmButtonColor: result.ButtonColor,
                                    type : result.type,
                                });

                                if(result.type == 'success'){
                                    swal.fire({
                                        title: result.title,
                                        text : result.text,
                                        confirmButtonColor: result.ButtonColor,
                                        type : result.type,
                                    }).then((result) => {
                                        $('#table').DataTable().ajax.reload();
                                    });
                                }else{
                                    swal.fire({
                                        title: result.title,
                                        text : result.text,
                                        confirmButtonColor: result.ButtonColor,
                                        type : result.type,
                                    });
                                }
                            }
                        });
                    } else {
                        swal.fire({
                            text : 'Aksi Dibatalkan!',
                            type : "info",
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
                create();
                hapus();
                addRow();
                deleteRow();
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

    var dengan_rupiah = document.getElementById('price');
    dengan_rupiah.addEventListener('keyup', function(e)
    {
        dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
    });
    
    /* Fungsi */
    function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
    });
</script>
