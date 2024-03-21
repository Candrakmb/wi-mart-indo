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
     @if ($type == 'create' || $type == 'update' || $type == 'lihat')
         <div class="card p-3">
             <div class="card-body">
                 <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
                     @csrf
                     @if ($type == 'create' || $type == 'update')
                         <h5>Form Categori</h5>
                         <br>
                         <div class="row">
                             <div class="col mt1">
                                 <label for="name" class="label1">Nama kategori</label><span
                                     class="required">*</span>
                                <input type="hidden" name="id" class="form-control" value="{{($type == 'create' ? '' : $data->id)}}" >
                                 <input type="text" placeholder="Silahkan Masukkan nama kategori" name="name"
                                     id="name" class="form-control name" value="{{($type == 'create' ? '' : $data->name)}}" required>
                                 <p class="help-block" style="display: none;"></p>
                             </div>
                             <div class="col mt1">
                                 <label for="slug" class="label1">slug</label><span class="required">*</span>
                                 <input type="text" id="slug" name="slug" class="form-control slug" value="{{($type == 'create' ? '' : $data->slug)}}" readonly
                                     required>
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
                             <div class="col-md-auto">
                                 <div class="d-flex justify-content-center align-items-center mb-2">
                                     <a href="{{ ($type == 'create' ? asset('assets/images/no-image.jpg') : asset('storage/image/kategori/'.$data->thumbnails))}}" target="_blank"
                                         id="imgLink">
                                         <img src="{{ ($type == 'create' ? asset('assets/images/no-image.jpg') : asset('storage/image/kategori/'.$data->thumbnails))}}" class="rounded"
                                             id="output" width="150px">
                                     </a>
                                 </div>
                                 <label for="gambar_kategori" class="label1 mt1">Gambar</label>
                                 <div class="input-group mb-3">
                                     <input type="file" name="gambar_kategori" class="form-control"
                                         value="{{($type == 'create' ? '' : $data->thumbnails)}}"
                                         onchange="document.getElementById('output').src=window.URL.createObjectURL(this.files[0]); document.getElementById('imgLink').href=window.URL.createObjectURL(this.files[0])"
                                         {{($type == 'create' ? 'required' : '')}}>
                                 </div>
                                 <p class="help-block" style="display: none;"></p>
                             </div>
                         </div>
                     @endif
                     @if ($type == 'lihat')
                     <div class="row justify-content-md-center" >
                        <div class="card text-white bg-primary"  style="width: 70%; height:20%">
                            <img src="{{ asset('storage/image/kategori/'.$data->thumbnails)}}" class="right" alt="...">
                            <div class="card-img-overlay">
                              <h5 class="card-title">Card title</h5>
                              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                              <p class="card-text">Last updated 3 mins ago</p>
                            </div>
                          </div>
                        <div class="col-md-auto">
                            <div class="categories__item set-bg"
                                data-setbg="">
                                <div class="categories__text">
                                    <h4>{{ $data->slug }}</h4>
                                    <p>{{ $data->slug }}</p>
                                    <a href="#">Jelajahi</a>
                                </div>
                            </div>
                        </div>
                    </div>
                     @endif
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
