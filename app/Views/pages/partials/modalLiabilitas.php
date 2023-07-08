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
                        <label>Keterangan</label>
                        <select name="keterangan" id="keterangan" class="form-control">
                            <option>Pilih Keterangan</option>
                            <option value="tabungan_desa">Tabungan Desa</option>
                            <option value="simpanan_wajib">Simpanan Wajib</option>
                            <option value="simasya_tapel">Simasya & Tapel</option>
                            <option value="tabanas_pmk">Tabanas PMK</option>
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