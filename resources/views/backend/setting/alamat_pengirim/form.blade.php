         <div class="card p-3">
             <div class="card-body">
                 <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
                     @csrf
                         <h5>Form Alamat Pengirim</h5>
                         <br>
                         <div class="row col-md-12">
                             <div class="col-md-6 mt-2">
                                 <label for="province_id" class="form-label">Provinsi</label><span
                                     class="required">*</span>
                                <input type="hidden" name="id" class="form-control" value="{{($type == 'create' ? '' : $alamat_pengirim->id)}}" >
                                <select name="province_id" id="province_id" class="form-select" required>
                                    <option value="" selected disabled>-- Select Province --</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province['province_id'] }}" data-id="{{ $province['province_id'] }}">{{ $province['province'] }}
                                        </option>
                                    @endforeach
                                </select>
                                 <p class="help-block" style="display: none;"></p>
                             </div>
                             <div class="col-md-6 mt-2">
                                <label for="city_id" class="label1">Kota/Kabupaten</label><span
                                    class="required">*</span>
                                <select name="city_id" id="city_id" class="form-select" disabled required>
                                    <option value="" selected disabled>-- Select City --</option>
                               </select>
                                <p class="help-block" style="display: none;"></p>
                            </div>
                             <div class="col mt-2">
                                <label for="detail_alamat" class="label1">Detail Alamat</label><span class="required">*</span>
                                <input type="text" id="detail_alamat" name="detail_alamat" class="form-control detail_alamat" value="{{ $type == 'create' ? '' : $alamat_pengirim->detail_alamat }}" required>
                                <p class="help-block" style="display: none;"></p>
                            </div>
                         </div>
                         <div class="row mt-3">
                             <div class="col">
                                    <button type="button" id="simpan" class="btn btn-primary btn-data">Simpan</button>
                             </div>
                         </div>
                 </form>
             </div>
         </div>
     
