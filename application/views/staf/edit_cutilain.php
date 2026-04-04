     <!-- Begin Page Content -->
     <div class="container-fluid">
         <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
         <?php echo $this->session->flashdata('msg'); ?>
         <?php if (validation_errors()) { ?>
             <div class="alert alert-danger">
                 <a class="close" data-dismiss="alert">x</a>
                 <strong><?php echo strip_tags(validation_errors()); ?></strong>
             </div>
         <?php } ?>
         <div class="card">
             <div class="card-header">
                 <strong><?= $title; ?></strong>
                 <a href="javascript:window.history.go(-1);" class="btn btn-secondary btn-sm float-right">Kembali</a>
             </div>
             <div class="card-body">
                 <div class="row">
                     <div class="col-md-12">
                         <form action="<?php echo base_url('staf/edit_cutilain/'); ?><?php echo $user_cuti['id']; ?>" method="post">
                             <div class="form-row">
                                 <input type="hidden" name="id" value="<?php echo $user_cuti['id']; ?>">
                                 <input type="hidden" name="id_user" value="<?php echo $user_cuti['id_user']; ?>">
                                 <div class="form-group col-md-3">
                                     <label for="tglInput">Tanggal Input</label>
                                     <input type="date" class="form-control" id="tglInput" name="tgl_input" value="<?php echo $user_cuti['tgl_input']; ?>" readonly>
                                 </div>
                                 <div class="form-group col-md-3">
                                     <label for="nik">NIK</label>
                                     <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $user_cuti['nik']; ?>" readonly>
                                 </div>
                                 <div class="form-group col-md-6">
                                     <label for="nama">Nama</label>
                                     <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $user_cuti['nama']; ?>" readonly>
                                 </div>
                             </div>
                             <div class="form-row">
                                 <div class="form-group col-md-3">
                                     <label for="jabatan">Jabatan</label>
                                     <input type="text" class="form-control" id="tglInput" name="jabatan" value="<?php echo $user_cuti['jabatan']; ?>" readonly>
                                 </div>
                                 <div class="form-group col-md-3">
                                     <label for="bagian">Bagian</label>
                                     <input type="text" class="form-control" id="bagian" name="bagian" value="<?php echo $user_cuti['bagian']; ?>" readonly>
                                 </div>
                                 <div class="form-group col-md-6">
                                     <label for="keterangan">Jenis Cuti</label>
                                     <input type="text" class="form-control" id="keterangan" name="keterangan" value="Cuti Diluar Tanggungan" readonly>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label for="alamat">Alamat</label>
                                 <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $user_cuti['alamat']; ?>">
                             </div>
                             <div class="form-row">
                                 <div class="form-group col-md-8">
                                     <label for="jenisCuti">Jenis Cuti</label>
                                     <input type="text" class="form-control" id="jenisCuti" name="jenis_cuti" value="<?php echo $user_cuti['keterangan']; ?>">
                                 </div>
                                 <div class="form-group col-md-4">
                                     <label for="jenisCuti">No Telp / Handphone</label>
                                     <input type="text" class="form-control" id="jenisCuti" name="telp" value="<?php echo $user_cuti['telp']; ?>">
                                 </div>
                             </div>
                             <div class="form-row">
                                 <div class="form-group col-md-4">
                                     <label for="cuti1">Tanggal Cuti</label>
                                     <input type="date" class="form-control" id="cuti1" name="cuti" value="<?php echo $user_cuti['cuti']; ?>">
                                 </div>
                                 <div class="form-group col-md-4">
                                     <label for="cuti2">Tanggal Cuti 2</label>
                                     <input type="date" class="form-control" id="cuti1" name="cuti2" value="<?php echo $user_cuti['cuti2']; ?>">
                                 </div>
                                 <div class="form-group col-md-4">
                                     <label for="tglMasuk">Tanggal Masuk</label>
                                     <input type="date" class="form-control" id="tglMasuk" name="masuk" value="<?php echo $user_cuti['masuk']; ?>">
                                 </div>
                             </div>
                             <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </div>