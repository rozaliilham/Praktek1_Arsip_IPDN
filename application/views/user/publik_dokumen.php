<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark"><?php echo $title; ?></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class=" table table-bordered table-hover" id="table-id" style="font-size:14px;">
                                    <thead>
                                        <th>#</th>
                                        <th>No Arsip</th>
                                        <th>Tgl / Jam</th>
                                        <th>Nama File</th>
                                        <th>Jenis File</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($list_dokumen as $lu) : ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $lu['kode_arsip']; ?></td>
                                                <td><?php echo format_indo($lu['tgl_upload']) . ' - ' . $lu['jam_upload']; ?></td>
                                                <td><?php echo $lu['nama_file']; ?></td>
                                                <td><?php echo $lu['jenis_file']; ?></td>
                                                <td><a href="<?php echo base_url('user/publik_detail/' . $lu['id_arsip']); ?>" class="btn btn-info btn-block btn-sm"><i class="fas fa-edit"></i> Detail</a>
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
        </div>
    </section>
</div>