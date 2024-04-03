     <!-- MAIN -->
     <div class="row col-md-12" style="margin-bottom: 1em;">
         <div class="col text-left" style="margin: 1em 0 0 -1em;">
         </div>
         <div class="col text-right" style="margin: 0 -3em 0 0;">
             <a href="{{ url()->previous() }}" type="button" class="btn btn-primary btn-data-sec">
                 <i class="fa fa-chevron-left"></i> <span>Kembali</span>
             </a>
         </div>
     </div>
     @if ($type == 'create' || $type == 'update' || $type == 'lihat')
         <div class="card p-3">
             <div class="card-body">
                 <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
                     @csrf
                     <h5>Form Product</h5>
                     <br>
                     <div class="row">
                         <div class="col-md-6 mt-2">
                             <label for="name" class="label1">Nama</label><span class="required">*</span>
                             <input type="hidden" name="id" class="form-control"
                                 value="{{ $type == 'create' ? '' : $data->id }}">
                             <input type="text" placeholder="Silahkan Masukkan nama product" name="name"
                                 id="name" class="form-control name"
                                 value="{{ $type == 'create' ? '' : $data->name }}" required>
                             <p class="help-block" style="display: none;"></p>
                         </div>
                         <div class="col-md-6 mt-2">
                             <label for="categories_id" class="label1">kategori</label><span class="required">*</span>
                             <select name="categories_id" class="form-select" required>
                                 <option value="" {{ $type == 'create' ? 'selected' : '' }} disabled>
                                     pilih kategori....
                                 </option>
                                 @foreach ($data_categori as $category)
                                     <option value="{{ $category->id }}"
                                         {{ $type == 'update' && $data->categories_id == $category->id ? 'selected' : '' }}>
                                         {{ $category->name }}
                                     </option>
                                 @endforeach
                             </select>
                             <p class="help-block" style="display: none;"></p>
                         </div>
                         <div class="col-md-6 mt-2">
                             <label for="slug" class="label1">slug</label><span class="required">*</span>
                             <input type="text" id="slug" name="slug" class="form-control slug"
                                 value="{{ $type == 'create' ? '' : $data->slug }}" readonly required>
                             <p class="help-block" style="display: none;"></p>
                         </div>
                         <div class="col-md-6 mt-2">
                             <label for="price" class="label1">Harga</label><span class="required">*</span>
                             <input type="text" name="price" id="price" class="form-control price"
                                 value="{{ $type == 'create' ? '' : $data->price }}" required>
                             <p class="help-block" style="display: none;"></p>
                         </div>
                         <div class="col-md-6 mt-2">
                            <label for="berat_display" class="label1">Unit produk</label><span class="required">*</span>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="number" name="berat_display" class="form-control berat_display"
                                    value="{{ $type == 'create' ? '' : $data->berat_display }}" required>
                                </div>
                                <div class="col-md-6">
                                    <select name="label" class="form-select" required>
                                        <option value="" {{ $type == 'create' ? 'selected' : '' }} disabled>pilih satuan...</option>
                                        <option value="L" {{ $type == 'update' && $data->label == 'L' ? 'selected' : '' }}>Liter</option>
                                        <option value="KG" {{ $type == 'update' && $data->label == 'KG' ? 'selected' : '' }}>kg</option>
                                        <option value="g" {{ $type == 'update' && $data->label == 'g' ? 'selected' : '' }}>g</option>
                                        <option value="pack" {{ $type == 'update' && $data->label == 'pack' ? 'selected' : '' }}>PACK</option>
                                    </select>
                                </div>
                            </div>
                            <p class="help-block" style="display: none;"></p>
                        </div>
                         <div class="col-md-6 mt-2">
                             <label for="weight" class="label1">Berat</label><span class="required">*</span>
                             <div class="input-group">
                             <input type="number" name="weight" class="form-control weight"
                                 value="{{ $type == 'create' ? '' : $data->weight }}" aria-describedby="basic-addon2" required>
                                 <span class="input-group-text" id="basic-addon2">Gram</span>
                             </div>
                             <p class="help-block" style="display: none;"></p>
                         </div>
                         <div class="col-md-6 mt-2">
                             <label for="stok" class="label1">Stok</label><span class="required">*</span>
                             <input type="number" name="stok" class="form-control stok"
                                 value="{{ $type == 'create' ? '' : $data->stok }}" required>
                             <p class="help-block" style="display: none;"></p>
                         </div>
                         <div class="col-md-6 mt-2">
                            <label for="description" class="label1">Description</label><span class="required">*</span>
                            <textarea type="number" name="description" class="form-control description" required>{{ $type == 'create' ? '' : $data->description }}</textarea>
                            <p class="help-block" style="display: none;"></p>
                        </div>
                     </div>
                     <script>
                         $(document).on('keyup', '#name', function() {
                             let val = $(this).val();
                             let slugformat = val.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
                             $('#slug').val(slugformat);
                         });
                     </script>
                     <div class="row justify-content-md-center mt-3">
                         
                         <div class="col-md-6 mt-2">
                             <div class="d-flex justify-content-center align-items-center mb-2">
                                 <a href="{{ $type == 'create' ? asset('assets/images/no-image.jpg') : asset('storage/image/product/' . $data->thumbnails) }}"
                                     target="_blank" id="imgLink">
                                     <img src="{{ $type == 'create' ? asset('assets/images/no-image.jpg') : asset('storage/image/product/' . $data->thumbnails) }}"
                                         class="rounded" id="output" width="150px">
                                 </a>
                             </div>
                             <label for="gambar_product" class="label1 mt1">Gambar</label>
                             <div class="input-group mb-3">
                                 <input type="file" name="gambar_product" class="form-control"
                                     value="{{ $type == 'create' ? '' : $data->thumbnails }}"
                                     onchange="document.getElementById('output').src=window.URL.createObjectURL(this.files[0]); document.getElementById('imgLink').href=window.URL.createObjectURL(this.files[0])"
                                     {{ $type == 'create' ? 'required' : '' }}>
                             </div>
                             <p class="help-block" style="display: none;"></p>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6 mt-2">
                             <h5>Variasi Produk</h5>
                         </div>
                         <div class="col-md-6 mt-2 text-right">
                             <button type="button" id="add_row" class="btn btn-info"><b>+</b> Add</button>
                         </div>
                         <div class="col-md-12 mt-2">
                            <div class="table-responsive">
                             <table class="table table-sm table-borderless table_variasi">
                                 <tbody>
                                    @if ($type == 'update')
                                     @if ($data_variasi != null)
                                         @for ($i = 0; $i < $count; $i++)
                                             <tr>
                                                 <th scope="row">{{$i + 1}}</th>
                                                 <td>
                                                     <label for="jenis[]" class="label1">jenis</label><span
                                                         class="required">*</span>
                                                         <input type="hidden" name="id_variasi[]" value="{{$data_variasi[$i]->id }}">
                                                         <select name="jenis[]" class="form-select" required>
                                                            <option value="" disabled>Pilih ....</option>
                                                            <option value="ukuran" {{ $data_variasi[$i]->jenis == 'ukuran' ? 'selected' : '' }}>Ukuran</option>
                                                            <option value="warna" {{ $data_variasi[$i]->jenis == 'warna' ? 'selected' : '' }}>Warna</option>
                                                        </select>
                                                 <td>
                                                     <label for="spesifikasi[]"
                                                         class="label1">Spesifikasi</label><span
                                                         class="required">*</span>
                                                     <input type="text" name="spesifikasi[]"
                                                         class="form-control spesifikasi" value="{{$data_variasi[$i]->spesifikasi }}" required>
                                                 </td>
                                                 <td>
                                                     <label for="stok_variasi[]" class="label1">Stok</label><span
                                                         class="required">*</span>
                                                     <input type="number" name="stok_variasi[]"
                                                         class="form-control stok_variasi" value="{{$data_variasi[$i]->stok }}" required>
                                                 </td>
                                                 <td>
                                                     <label for="status[]" class="label1">Status</label><span
                                                         class="required">*</span>
                                                     <select name="status[]" class="form-select" required>
                                                         <option value="" disabled>pilih ....</option>
                                                         <option value="0"  {{ $data_variasi[$i]->status == '0' ? 'selected' : '' }}>Kosong</option>
                                                         <option value="1"  {{ $data_variasi[$i]->status == '1' ? 'selected' : '' }}>Tersedia</option>
                                                     </select>
                                                 </td>
                                                 <td>
                                                     <button style="width: 100%; height: 70px;" type="button"
                                                         class="btn btn-danger btn-raised btn-xs btn-hapus-detail"
                                                         title="Hapus"><i class="icon-trash"></i></button>
                                                 </td>
                                             </tr>
                                         @endfor
                                     @endif
                                     @if ($count == '0')
                                     <tr>
                                         <td colspan="99" class="text-center table-active">Klik ADD</td>
                                     </tr>
                                     @endif
                                     @endif
                                     @if ($type == 'create')
                                     <tr>
                                        <td colspan="99" class="text-center table-active">Klik ADD</td>
                                    </tr>
                                    @endif
                                 </tbody>
                             </table>
                            </div>
                         </div>
                     </div>
                     @if ($type != 'lihat')
                         <div class="row">
                             <div class="col">
                                 <button type="button" id="simpan"
                                     class="btn btn-primary btn-data">Simpan</button>
                             </div>
                         </div>
                     @endif
                 </form>
             </div>
         </div>
     @endif
