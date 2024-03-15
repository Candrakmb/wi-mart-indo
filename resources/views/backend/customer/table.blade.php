<div class="card mt-3">
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <h3 class="card-title">Data Pelanggan</h3>
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
                    <label class="dropdown-item"><input class="toggle-vis" data-column="3" type="checkbox" checked> Nama </label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="4" type="checkbox" checked> Email </label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="5" type="checkbox" checked> Alamat </label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="6" type="checkbox" checked> No.TLP </label>
                </div>
            </div>
        </div>
        </div>
    <div class="table-responsive mt-2">
        <table id="table" class="table stripe" style="width: 100%;">
            <thead>
                <tr class="tr-table">
                    <th class="th-table" style="font-size: 12px;">No</th>
                    <th class="th-table" style="font-size: 12px;">Nama</th>
                    <th class="th-table" style="font-size: 12px;">Email</th>
                    <th class="th-table" style="font-size: 12px;">Alamat</th>
                    <th class="th-table" style="font-size: 12px;">No.Tlp</th>
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