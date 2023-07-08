<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <input name="id" id="id" hidden>
                    <div class="form-group">
                        <label>Cabang</label>
                        <select name="cabang" id="cabang" class="form-control">
                            <option>Pilih Cabang</option>
                            <?php foreach ($cabang as $data) : ?>
                                <option value="<?= $data['kode_cabang'] ?>"><?= $data['nama_cabang'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dana</label>
                        <input type="number" name="dana" id="dana" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Jumlah Nasabah</label>
                        <input type="number" name="nasabah" id="nasabah" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori" id="kategori" class="form-control">
                            <option>Pilih Kategori</option>
                            <option value="sisa_pinjaman_akhir_bulan_lalu">Sisa Pinjaman Akhir Bulan Lalu</option>
                            <option value="dipinjamkan_dalam_bulan_laporan">Dipinjamkan Dalam Bulan Laporan</option>
                            <option value="cicilan_bulan_dalam_bulan_laporan">Cicilan Bulan Dalam Bulan Laporan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Periode</label>
                        <select name="waktu" id="waktu" class="form-control">
                            <option>Pilih Periode</option>
                            <option value="mingguan">Mingguan</option>
                            <option value="bulanan">Bulanan</option>
                            <option value="musiman">Musiman</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="Save()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>