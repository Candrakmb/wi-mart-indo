     <!-- MAIN -->
     <div class="row col-md-12" style="margin-bottom: 1em;">
         <div class="col text-left" style="margin: 1em 0 0 -1em;">
         </div>
         <div class="col text-right" style="margin: 0 -3em 0 0;">
             <a href="{{ url()->previous()}}" type="button" class="btn btn-primary btn-data-sec">
                 <i class="fa fa-chevron-left"></i> <span>Kembali</span>
             </a>
         </div>
     </div>
     @if($type == 'create' || $type == 'update' || $type == 'lihat')
         <div class="card p-3">
             <div class="card-body">
                 <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
                     @csrf
                         <h5>Form Product</h5>
                         <br>
                         <div class="row">
                             <div class="col-md-6 mt-2">
                                 <label for="name" class="label1">Nama</label><span
                                     class="required">*</span>
                                <input type="hidden" name="id" class="form-control" value="{{($type == 'create' ? '' : $data->id)}}" >
                                 <input type="text" placeholder="Silahkan Masukkan nama product" name="name"
                                     id="name" class="form-control name" value="{{($type == 'create' ? '' : $data->name)}}" required>
                                 <p class="help-block" style="display: none;"></p>
                             </div>
                             <div class="col-md-6 mt-2">
                                <label for="categories_id" class="label1">kategori</label><span
                                    class="required">*</span>
                                    <select name="categories_id" class="form-select" required>
                                        <option value="" {{$type == 'create' ? 'selected' : ''}}>
                                            pilih kategori....
                                        </option>
                                        @foreach($data_categori as $category)
                                            <option value="{{$category->id}}" {{$type == 'update' && $data->categories_id == $category->id ? 'selected' : ''}}>
                                                {{$category->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                <p class="help-block" style="display: none;"></p>
                            </div>
                             <div class="col-md-6 mt-2">
                                 <label for="slug" class="label1">slug</label><span class="required">*</span>
                                 <input type="text" id="slug" name="slug" class="form-control slug" value="{{($type == 'create' ? '' : $data->slug)}}" readonly
                                     required>
                                 <p class="help-block" style="display: none;"></p>
                             </div>
                             <div class="col-md-6 mt-2">
                                <label for="price" class="label1">Harga</label><span class="required">*</span>
                                <input type="number" name="price" class="form-control price" value="{{($type == 'create' ? '' : $data->price)}}" required>
                                <p class="help-block" style="display: none;"></p>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="weight" class="label1">Berat</label><span class="required">*</span>
                                <input type="number"  name="weight" class="form-control weight" value="{{($type == 'create' ? '' : $data->weight)}}" required>
                                <p class="help-block" style="display: none;"></p>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="stok" class="label1">Stok</label><span class="required">*</span>
                                <input type="number" name="stok" class="form-control stok" value="{{($type == 'create' ? '' : $data->stok)}}" required>
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
                                <label for="description" class="label1">Description</label><span class="required">*</span>
                                <textarea type="number" name="description" class="form-control description"  required>{{($type == 'create' ? '' : $data->description)}}</textarea>
                                <p class="help-block" style="display: none;"></p>
                            </div>
                             <div class="col-md-6 mt-2">
                                 <div class="d-flex justify-content-center align-items-center mb-2">
                                     <a href="{{ ($type == 'create' ? asset('assets/images/no-image.jpg') : asset('storage/image/product/'.$data->thumbnails))}}" target="_blank"
                                         id="imgLink">
                                         <img src="{{ ($type == 'create' ? asset('assets/images/no-image.jpg') : asset('storage/image/product/'.$data->thumbnails))}}" class="rounded"
                                             id="output" width="150px">
                                     </a>
                                 </div>
                                 <label for="gambar_product" class="label1 mt1">Gambar</label>
                                 <div class="input-group mb-3">
                                     <input type="file" name="gambar_product" class="form-control"
                                         value="{{($type == 'create' ? '' : $data->thumbnails)}}"
                                         onchange="document.getElementById('output').src=window.URL.createObjectURL(this.files[0]); document.getElementById('imgLink').href=window.URL.createObjectURL(this.files[0])"
                                         {{($type == 'create' ? 'required' : '')}}>
                                 </div>
                                 <p class="help-block" style="display: none;"></p>
                             </div>
                         </div>
                     @if ($type != 'lihat')
                         <div class="row">
                             <div class="col">
                                 <button type="button" id="simpan" class="btn btn-primary btn-data">Simpan</button>
                             </div>
                         </div>
                     @endif
                 </form>
             </div>
         </div>
         @endif
