<script>
    var data = function() {
        let valid = true,
            real = '',
            message = '',
            title = '',
            type = '';
        var dt = new Date();
        var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();

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
                                        url: "/alamat_pengirim/createform",
                                    @else
                                        url: "/alamat_pengirim/updateform",
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
                                                location.href = "/alamat_pengirim";
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
                            'option value="" selected>-- Select City --</option>');
                        $.each(data, function(key, city) {
                            $('select[name="city_id"]').append('<option value="' + city
                                .city_id + '" data-id="'+city.city_id+'">' + city.type + ' ' + city.city_name +
                                '</option>');
                        });

                    } else {
                        $('#city_id').empty();
                    }
                }
            });
        });

        return {
            init: function() {
                create();
            }
        }
    }();
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#province_id').select2({
            dropdownParent: $('#province_id').parent()
        });
        $('#city_id').select2({
            dropdownParent: $('#city_id').parent()
        });
        $.fn.dataTable.ext.errMode = 'none';
        data.init();
    });
</script>
