<div class="modal fade" id="categoryDate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Export Laporan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <input name="id" id="id" hidden>
                    <div class="form-group">
                        <label>Mulai Bulan Tahun</label>
                        <input type="date" name="start" id="start" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Sampai Bulan Tahun</label>
                        <input type="date" name="end" id="end" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="category" id="category" class="form-control">
                            <option value="all">Pilih Kategori</option>
                            <option value="pendapatan_operasional">Pendapatan Operasional</option>
                            <option value="beban_operasional">Beban Operasional</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="exportBtn">Export</button>
                </div>
            </form>
        </div>
    </div>
</div>