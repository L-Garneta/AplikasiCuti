     <!-- Begin Page Content -->
     <div class="container-fluid">
         <!-- Page Heading -->
         <h5 class="h5 mb-3 text-gray-800"></h5>
         <div class="card">
             <div class="card-header">
                 <strong><?= $title; ?></strong>
                 <a href="javascript:window.history.go(-1);" class="btn btn-secondary btn-sm float-right">Kembali</a>
             </div>
             <div class="card-body">
                 <form action="<?php echo base_url('sdm/edit_kary/'); ?><?php echo $pegawai['nik']; ?>" method="post">
                     <div class="form-row">
                         <div class="col-md-3">
                             <div class="form-group">
                                 <input type="hidden" name="id_pegawai" value="<?php echo $pegawai['id_pegawai']; ?>">
                                 <label for="nik">NIK</label>
                                 <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $pegawai['nik']; ?>" readonly>
                             </div>
                             <div class="form-group">
                                 <label for="agama">Agama</label>
                                 <input type="text" class="form-control" id="agama" name="agama" value="<?php echo $pegawai['agama']; ?>">
                                 <?php echo form_error('agama', '<small class="text-danger pl-2">', '</small>'); ?>
                             </div>
                             <div class="form-group">
                                 <label for="kotaLahir">Kota Lahir</label>
                                 <input type="text" class="form-control" id="kotaLahir" name="kota_lahir" value="<?php echo $pegawai['kota_lahir']; ?>">
                                 <?php echo form_error('kota_lahir', '<small class="text-danger pl-2">', '</small>'); ?>
                             </div>
                             <div class="form-group">
                                 <label for="statusNikah">Status Pernikahan</label>
                                 <input type="text" class="form-control" id="statusNikah" name="status_nikah" value="<?php echo $pegawai['status_nikah']; ?>">
                                 <?php echo form_error('status_nikah', '<small class="text-danger pl-2">', '</small>'); ?>
                             </div>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                 <label for="nama">Nama Lengkap</label>
                                 <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $pegawai['nama']; ?>">
                                 <?php echo form_error('nama', '<small class="text-danger pl-2">', '</small>'); ?>
                             </div>
                             <div class="form-group">
                                 <label for="bagian">Bagian :</label>
                                 <select name="bagian" id="bagian" class="form-control">

                                     <?php foreach ($pegawaiegawai as $pegawai) : ?>
                                         <option value="<?php echo $pegawai['bagian']; ?>">
                                             <?php echo $pegawai['bagian']; ?>
                                         </option>
                                     <?php endforeach; ?>
                                 </select>
                             </div>
                             <?php
                                $time = strtotime($pegawai['tgl_lahir']);
                                $tgllahir = date('Y-m-d', $time);
                                ?>
                             <div class="form-group">
                                 <label for="tglLahir">Tgl Lahir</label>
                                 <input type="date" class="form-control" id="tglLahir" name="tgl_lahir" value="<?php echo $tgllahir; ?>">
                             </div>
                             <div class="form-group">
                                 <label for="namaJenjang">Pendidikan Terakhir</label>
                                 <input type="text" class="form-control" id="namaJenjang" name="nama_jenjang" value="<?php echo $pegawai['nama_jenjang']; ?>">
                                 <?php echo form_error('nama_jenjang', '<small class="text-danger pl-2">', '</small>'); ?>
                             </div>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                 <label for="jabatan">Jabatan</label>
                                 <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo $pegawai['jabatan']; ?>">
                             </div>
                             <div class="form-group">
                                 <label for="jurusan">Jurusan</label>
                                 <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?php echo $pegawai['jurusan']; ?>">
                                 <?php echo form_error('jurusan', '<small class="text-danger pl-2">', '</small>'); ?>
                             </div>
                             <div class="form-group">
                                 <label for="golDarah">Golongan Darah</label>
                                 <input type="text" class="form-control" id="golDarah" name="gol_darah" value="<?php echo $pegawai['gol_darah']; ?>">
                             </div>

                             <div class="form-group">
                                 <label for="alamat">Alamat</label>
                                 <textarea name="alamat" id="alamat" cols="40" class="form-control"><?php echo $pegawai['alamat']; ?></textarea>
                             </div>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                 <label for="namaSekolah">Nama Sekolah</label>
                                 <input type="text" class="form-control" id="namaSekolah" name="nama_sekolah" value="<?php echo $pegawai['nama_sekolah']; ?>">
                                 <?php echo form_error('nama_sekolah', '<small class="text-danger pl-2">', '</small>'); ?>
                             </div>
                             <div class="form-group">
                                 <label for="thnLulus">Tahun Lulus</label>
                                 <input type="text" class="form-control" id="thnLulus" name="tahun_lulus" value="<?php echo $pegawai['tahun_lulus']; ?>">
                                 <?php echo form_error('tahun_lulus', '<small class="text-danger pl-2">', '</small>'); ?>
                             </div>
                             <div class="form-group">
                                 <label for="sex">Jenis Kelamin</label>
                                 <input type="text" class="form-control" id="sex" name="jenis_kelamin" value="<?php echo $pegawai['jenis_kelamin']; ?>">
                             </div>
                             <a href="javascript:window.history.go(-1);" class="btn btn-secondary mr-1 mt-3">Kembali</a>
                             <button type="reset" class="btn btn-danger mr-1 mt-3">Reset</button>
                             <button type="submit" class="btn btn-primary mt-3" name="submit">Update</button>
                         </div>
                 </form>

             </div>


         </div>
     </div>








     </div>
     <!-- /.container-fluid -->