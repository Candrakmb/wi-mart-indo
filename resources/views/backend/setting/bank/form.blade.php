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
                         <h5>Form Bank</h5>
                         <br>
                         <div class="row">
                             <div class="col-md-6 mt-2">
                                 <label for="nama_bank" class="label1">Nama Bank</label><span
                                     class="required">*</span>
                                <input type="hidden" name="id" class="form-control" value="{{($type == 'create' ? '' : $data->id)}}" >
                                 <input type="text" placeholder="Silahkan Masukkan nama bank" name="nama_bank"
                                     class="form-control nama_bank" value="{{($type == 'create' ? '' : $data->nama_bank)}}" required>
                                 <p class="help-block" style="display: none;"></p>
                             </div>
                             <div class="col-md-6 mt-2">
                                 <label for="no_rekening" class="label1">Nomor Rekening</label><span class="required">*</span>
                                 <input type="text"  name="no_rekening" class="form-control no_rekening" value="{{($type == 'create' ? '' : $data->no_rekening)}}" required>
                                 <p class="help-block" style="display: none;"></p>
                             </div>
                             <div class="col-md-6 mt-2">
                                <label for="atas_nama" class="label1">Atas Nama</label><span class="required">*</span>
                                <input type="text" id="atas_nama" name="atas_nama" class="form-control atas_nama" value="{{($type == 'create' ? '' : $data->atas_nama)}}" required>
                                <p class="help-block" style="display: none;"></p>
                            </div>
                         </div>
                     @if ($type != 'lihat')
                         <div class="row mt-3">
                             <div class="col">
                                 <button type="button" id="simpan" class="btn btn-primary btn-data">Simpan</button>
                             </div>
                         </div>
                     @endif
                 </form>
             </div>
         </div>
     @endif
