<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data Kode Akun</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <input name="id" id="id" hidden>
                    <div class="form-group">
                        <label>Nama Akun</label>
                        <input type="text" name="nama_akun" id="nama_akun" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Kode Akun</label>
                        <input type="number" name="kode_akun" id="kode_akun" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" id="keterangan" class="form-control">
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