<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data Kantor Cabang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <input name="id" id="id" hidden>
                    <div class="form-group">
                        <label>Nama Cabang</label>
                        <input type="text" name="nama_cabang" id="nama_cabang" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Kode Cabang</label>
                        <input type="number" name="kode_cabang" id="kode_cabang" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea type="text" name="alamat" id="alamat" class="form-control"></textarea>
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