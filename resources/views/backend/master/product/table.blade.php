<div class="col text-right" style="margin: 0 -3em 0 0;">
    <a href="/product/create" type="button" class="btn btn-primary btn-data" id="btn-create" style="margin: 1em 0 0 0;">
        <i class="fa fa-plus-square"></i> <span>Tambah</span>
    </a>
</div>
<div class="card mt-3">
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <h3 class="card-title">Data Product</h3>
            </div>
            <div class="col-6 text-right">
            <button type="button" class="btn btn-data-sec" id="btn-muat-ulang" style="margin: 1em 0 0 0;">
                <i class="fa fa-refresh"></i>
            </button>
            <button type="button" class="btn btn-data-sec" id="btn-cetak" style="margin: 1em 0 0 0;">
                <i class="fa fa-file-excel-o"></i>
            </button>
            <div class="btn dropdown" >
                <button style="margin: 1em 0 0 0" class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-filter"></i>
                </button>
                <div class="dropdown-menu">
                    <label class="dropdown-item"><input class="toggle-vis" data-column="2" type="checkbox" checked> Nama </label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="3" type="checkbox" checked> kategori </label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="4" type="checkbox" checked> Slug </label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="5" type="checkbox" checked> Harga </label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="6" type="checkbox" checked> Berat </label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="7" type="checkbox" checked> Stok </label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="8" type="checkbox"> Deskripsi </label>
                </div>
            </div>
        </div>
        </div>
    <div class="table-responsive mt-2">
        <table id="table" class="table stripe" style="width: 100%;">
            <thead>
                <tr class="tr-table">
                    <th class="th-table" style="font-size: 12px;">No</th>
                    <th class="th-table" style="font-size: 12px;">Aksi</th>
                    <th class="th-table" style="font-size: 12px;">Nama</th>
                    <th class="th-table" style="font-size: 12px;">Kategori</th>
                    <th class="th-table" style="font-size: 12px;">Slug</th>
                    <th class="th-table" style="font-size: 12px;">Harga</th>
                    <th class="th-table" style="font-size: 12px;">Berat</th>
                    <th class="th-table" style="font-size: 12px;">Stok</th>
                    <th class="th-table" style="font-size: 12px; max-width: 40px;" >Deskripsi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td colspan="99" class="text-center">Data Tidak Ditemukan</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>