 <div class="content-wrapper">
     <section class="content-header">
         <div class="container-fluid">
             <div class="row mb-2">
                 <div class="col-sm-6">

                 </div>
                 <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                         <li class="breadcrumb-item">
                             <a href="<?php echo base_url('user/publik_dokumen/' . $detail['kategori_id']); ?>" class="btn btn-light btn-sm">Kembali</a>
                         </li>
                     </ol>
                 </div>
             </div>
         </div>
     </section>

     <section class="content">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-md-4">
                     <div class="card">
                         <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                         <?php if (validation_errors()) { ?>
                             <div class="alert alert-danger">
                                 <a class="close" data-dismiss="alert">x</a>
                                 <strong><?php echo strip_tags(validation_errors()); ?></strong>
                             </div>
                         <?php } ?>
                         <div class="card-header">
                             <h4 class="card-title font-weight-bolder">Detail Arsip</h4>
                             <div class="card-tools">
                                 <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                 </button>
                             </div>
                         </div>
                         <div class="card-body p-0">
                             <ul class="nav nav-pills flex-column">
                                 <li class="nav-item active">
                                     <a href="#" class="nav-link">
                                         <i class="fas fa-cubes"></i> Kategori
                                         <span class="float-right"><?php echo $detail['nama_kategori']; ?></span>
                                     </a>
                                 </li>
                                 <li class="nav-item active">
                                     <a href="#" class="nav-link">
                                         <i class="fas fa-stream"></i> Kode Arsip
                                         <span class="float-right"><?php echo $detail['kode_arsip']; ?></span>
                                     </a>
                                 </li>
                                 <li class="nav-item active">
                                     <a href="#" class="nav-link">
                                         <i class="fas fa-file-signature"></i> Nama File
                                         <span class="float-right"><?php echo $detail['nama_file']; ?></span>
                                     </a>
                                 </li>
                                 <li class="nav-item active">
                                     <a href="#" class="nav-link">
                                         <i class="fas fa-file-prescription"></i> Jenis File
                                         <span class="float-right"><?php echo $detail['jenis_file']; ?></span>
                                     </a>
                                 </li>
                                 <li class="nav-item active">
                                     <a href="#" class="nav-link">
                                         <i class="fas fa-save"></i> Doc
                                         <span class="float-right"><?php echo $detail['file_arsip']; ?></span>
                                     </a>
                                 </li>
                                 <li class="nav-item active">
                                     <a href="#" class="nav-link">
                                         <i class="fas fa-user"></i> Operator
                                         <span class="float-right"><?php echo $detail['nama']; ?></span>
                                     </a>
                                 </li>
                                 <li class="nav-item active">
                                     <a href="#" class="nav-link">
                                         <?php if ($detail['status_arsip'] == '1') : ?>
                                             <i class="fas fa-toggle-off"></i> Status
                                             <span class="float-right">Pribadi</span>
                                         <?php else : ?>
                                             <i class="fas fa-toggle-on"></i> Status
                                             <span class="float-right">Publik</span>
                                         <?php endif; ?>
                                     </a>
                                 </li>
                             </ul>
                         </div>
                     </div>
                 </div>

                 <div class="col-md-8">
                     <div class="card card-primary card-outline">
                         <div class="card-body p-0">
                             <div class="mailbox-read-info">
                                 <h5><?php echo $detail['nama_file']; ?></h5>
                                 <h6>Kategori : <?php echo $detail['nama_kategori']; ?>
                                     <span class="mailbox-read-time float-right"><?php echo format_indo($detail['tgl_upload']); ?> <?php echo $detail['jam_upload']; ?></span>
                                 </h6>
                             </div>

                             <div class="mailbox-read-message">
                                 <?php echo $detail['keterangan']; ?>
                             </div>
                         </div>
                         <div class="card-footer bg-white">
                             <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                 <li>
                                     <?php if ($detail['jenis_file'] == 'pdf') : ?>
                                         <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>
                                     <?php else : ?>
                                         <span class="mailbox-attachment-icon"><i class="far fa-file-archive"></i></span>
                                     <?php endif; ?>
                                     <div class="mailbox-attachment-info">
                                         <center><a href="<?php echo base_url('user/detail/' . $detail['id_arsip']); ?>" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> <?php echo $detail['file_arsip']; ?></a>
                                         </center>
                                         <span class="mailbox-attachment-size clearfix mt-1">
                                             <a href="<?php echo base_url('user/unduh_arsip/' . $detail['id_arsip']); ?>" class="btn btn-primary btn-sm btn-block"><i class="fas fa-cloud-download-alt"></i> Unduh</a>
                                         </span>
                                     </div>
                                 </li>
                             </ul>
                         </div>
                         <div class="card-footer">
                         </div>
                     </div>
                 </div>
             </div>
     </section>
 </div>