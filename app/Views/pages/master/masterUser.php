<?= $this->extend('layout/Layout') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Data User</h4>
                <div class="card-header-action">
                    <?php if (session()->get('role') != 'employee') : ?>
                        <button type="button" class="btn btn-primary" onclick="tambahItem()">
                            Tambah Data
                        </button>
                    <?php endif ?>
                </div>
            </div>
            <?= $this->include('pages/partials/modalUser') ?>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <?php if (session()->get('role') != 'employee') : ?>
                                    <th>Action</th>
                                <?php endif ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($content as $data) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data['name'] ?></td>
                                    <td><?= $data['email'] ?></td>
                                    <td><span class="badge badge-success"><?= $data['role'] ?></span></td>
                                    <?php if (session()->get('role') != 'employee') : ?>
                                        <td>
                                            <button class="btn btn-primary" onclick="updateItem(<?= $data['id'] ?>)">Update</button>
                                            <button class="btn btn-danger" onclick="deleteItem(<?= $data['id'] ?>)">Delete</button>
                                        </td>
                                    <?php endif ?>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    function Save() {
        const id = $('#id').val();
        const url = id ? `${base_url}dashboard/master/user/update/${id}` : `${base_url}dashboard/master/user`;

        $.ajax({
            url,
            type: 'POST',
            data: $('#form').serialize(),
            dataType: 'JSON',
            success: (response) => {
                showAlert(response.icon, response.title, response.text);
                location.reload();
            },
            error: () => {
                alert('An error occurred while processing your request.');
            },
        });
    }

    function tambahItem() {
        $('#myModal').modal({
            backdrop: false
        });
        $('#myModal').modal('show');
        $('.modal-header button.close, .modal-footer button[data-dismiss="modal"]').on('click', function() {
            $('#myModal').modal('hide');
        });
        $('.modal-title').text(`Tambah Data`);
        $('#myModal').on('hidden.bs.modal', function() {
            $('#form')[0].reset();
        });
    }

    function updateItem(id) {
        $.ajax({
            url: `${base_url}dashboard/master/user/update/${id}`,
            type: 'GET',
            dataType: 'JSON',
            success: function(respond) {
                $('#id').val(respond.id);
                $('#name').val(respond.name);
                $('#email').val(respond.email);
                $('#role').val(respond.role);
                $('#myModal').modal({
                    backdrop: false
                });
                $('#myModal').modal('show');
                $('.modal-header button.close, .modal-footer button[data-dismiss="modal"]').on('click', function() {
                    $('#myModal').modal('hide');
                });
                $('.modal-title').text(`Update Data`);
                $('#myModal').on('hidden.bs.modal', function() {
                    $('#form')[0].reset();
                });
            },
            error: function(textStatus) {
                showAlert('error', 'Error!', textStatus)
            }
        });
    }

    function deleteItem(id) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Anda yakin ingin melakukan operasi ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${base_url}dashboard/master/user/delete/${id}`,
                    type: 'GET',
                    dataType: 'JSON',
                    success: (respond) => {
                        Swal.fire(respond.icon, respond.title, respond.text);
                        location.reload();
                    },
                    error: function(textStatus) {
                        Swal.fire('error', 'Error!', textStatus);
                    }
                });
            }
        });
    }
</script>
<?= $this->endSection() ?>