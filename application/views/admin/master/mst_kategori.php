<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark"><?php echo $title; ?></h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Default box -->
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                    <?php if (validation_errors()) { ?>
                        <div class="alert alert-danger">
                            <a class="close" data-dismiss="alert">x</a>
                            <strong><?php echo strip_tags(validation_errors()); ?></strong>
                        </div>
                    <?php } ?>
                    <!-- general form elements -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-user">
                                <i class="fas fa-plus-circle"></i> Tambah Kategori
                            </button>
                        </div> <!-- /.card-body -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class=" table table-bordered table-hover" id="table-id" style="font-size:14px;">
                                    <thead>
                                        <th>#</th>
                                        <th>Nama Kategori</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($list_kategori as $lu) : ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $lu['nama_kategori']; ?></td>
                                                <?php if ($lu['status_kategori'] == 1) : ?>
                                                    <td>Aktif</td>
                                                <?php else : ?>
                                                    <td><button class="badge badge-danger" style="font-size:14px;">Tidak
                                                            Aktif</button></td>
                                                <?php endif; ?>
                                                <td><button type="button" class="tombol-edit btn btn-info btn-block btn-sm" data-id="<?php echo $lu['id_kategori']; ?>" data-toggle="modal" data-target="#edit-user"><i class="fas fa-edit"></i> Edit</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="add-user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Kategori</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <form action="<?php echo base_url('admin/mst_kategori'); ?>" method="post" id="form_id">
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" class="form-control form-control-sm" name="nama_kategori" required>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Simpan Data</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Kategori</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <form action="<?php echo base_url('admin/edit_kategori'); ?>" method="post" id="form_id">
                        <input type="hidden" name="id_kategori" id="id_kategori">
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" class="form-control form-control-sm" name="nama_kategori" id="nama_kategori" required>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_kategori" value="1" checked>
                                <label class="form-check-label">
                                    Aktif
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_kategori" value="0">
                                <label class="form-check-label">
                                    Tidak Aktif
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.tombol-edit').on('click', function() {
        const id_kategori = $(this).data('id');
        $.ajax({
            url: '<?php echo base_url('admin/get_kategori'); ?>',
            data: {
                id_kategori: id_kategori
            },
            method: 'post',
            dataType: 'json',
            success: function(data) {
                $('#nama_kategori').val(data.nama_kategori);
                $('#id_kategori').val(data.id_kategori);
            }
        });
    });
</script>