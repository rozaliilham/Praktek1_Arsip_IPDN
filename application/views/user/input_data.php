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
                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                    <?php if (validation_errors()) { ?>
                        <div class="alert alert-danger">
                            <a class="close" data-dismiss="alert">x</a>
                            <strong><?php echo strip_tags(validation_errors()); ?></strong>
                        </div>
                    <?php } ?>

                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <?php echo form_open_multipart('user/input_data'); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kategori Arsip</label>
                                        <select class="form-control" name="kategori_id" required>
                                            <option value="">- Pilih Kategori</option>
                                            <?php foreach ($kategori_sidebar as $lu) : ?>
                                                <option value="<?= $lu['id_kategori']; ?>"><?= $lu['nama_kategori']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Kode Arsip</label>
                                        <input type="text" class="form-control" name="kode_arsip" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Upload</label>
                                                <?php $tgl = date('Y-m-d'); ?>
                                                <input type="date" class="form-control" name="tgl_upload" value="<?php echo $tgl; ?>" required>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jam Upload</label>
                                                <?php $jam = date('h:i:s'); ?>
                                                <input type="time" class="form-control" name="jam_upload" value="<?php echo $jam; ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama File</label>
                                        <input type="text" class="form-control" name="nama_file" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Jenis File</label>
                                                <select class="form-control" name="jenis_file" required>
                                                    <option value="">- Pilih Jenis File -</option>
                                                    <option value="pdf">PDF</option>
                                                    <option value="zip">ZIP/RAR</option>
                                                    <option value="doc">DOC</option>
                                                    <option value="xls">XLS</option>
                                                    <option value="ppt">PPT</option>
                                                    <option value="txt">TXT</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>File</label>
                                                <input type="file" class="form-control-file" name="file_arsip" required>
                                                <small class="font-weight-bolder">Ekstensi file xls,xlsx,doc,docx,ppt,pptx,pdf,zip,rar,txt dan ukuran file tidak lebih dari 5 MB</small>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea class="summernote" name="keterangan" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Simpan Data</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>