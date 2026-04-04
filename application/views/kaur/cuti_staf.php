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
         <h5 class="card-header">
             <strong><?= $title; ?></strong>
             <a href="<?php echo base_url('kaur/cutilain_staf'); ?>" class="btn btn-primary btn-sm float-right">Approval Cuti Lain</a>
         </h5>
         <div class="card-body">
             <div class="table-responsive">
                 <table class="table table-hover" id="table-id">
                     <thead>
                         <tr>
                             <th>#</th>
                             <th>Tgl.Input</th>
                             <th>Nama</th>
                             <th>NIK</th>
                             <th>Tgl Cuti 1</th>
                             <th>Tgl Cuti 2</th>
                             <th>Tgl Masuk</th>
                             <th>Approval</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php $i = 1; ?>
                         <?php foreach ($staf_cuti as $sc) : ?>
                             <?php if ($sc['is_approve'] == 1) : ?>
                                 <tr>
                                     <th scope="row"><?php echo $i++; ?></th>
                                     <td><?php echo format_indo($sc['input']); ?></td>
                                     <td><?php echo $sc['nama']; ?></td>
                                     <td><?php echo $sc['nik']; ?></td>
                                     <td><?php echo format_indo($sc['cuti']); ?></td>
                                     <td><?php echo format_indo($sc['cuti2']); ?></td>
                                     <td><?php echo format_indo($sc['masuk']); ?></td>
                                     <td><button class="tombol-edit btn btn-info btn-block btn-sm" data-id="<?php echo $sc['id']; ?>" data-toggle="modal" data-target="#edit-user"><i class="fas fa-edit"></i> Approval</button></td>
                                 <?php endif; ?>
                                 </tr>
                             <?php endforeach; ?>
                     </tbody>
                 </table>
             </div>
         </div>
     </div>
 </div>



 <div class="modal fade" id="edit-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Approval Cuti Tahunan</h5>
             </div>
             <div class="modal-body">
                 <form action="<?php echo base_url('kaur/approve_cuti'); ?>" method="post">
                     <div class="form-group">
                         <label>Nama Lengkap</label>
                         <input type="hidden" name="id" id="id">
                         <input type="text" name="nama" class="form-control form-control-sm" id="nama" readonly>
                     </div>
                     <div class="row">
                         <div class="col-md-4">
                             <div class="form-group">
                                 <label>Jenis Cuti</label>
                                 <input type="text" name="nama" class="form-control form-control-sm" id="jenis_cuti" readonly>
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-4">
                             <div class="form-group">
                                 <label>Cuti Diambil</label>
                                 <input type="text" name="jml_cuti" class="form-control form-control-sm" id="jml_cuti" readonly>
                             </div>
                         </div>
                         <div class="col-md-4">
                             <div class="form-group">
                                 <label>Sisa Sekarang </label>
                                 <input type="text" name="sisa_cuti" class="form-control form-control-sm" id="sisa_cuti" readonly>
                             </div>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-md-4">
                             <div class="form-group">
                                 <label>Tanggal Cuti 1</label>
                                 <input type="text" name="cuti" class="form-control form-control-sm" id="cuti" readonly>
                             </div>
                         </div>
                         <div class="col-md-4">
                             <div class="form-group">
                                 <label>Tanggal Cuti 2</label>
                                 <input type="text" name="cuti2" class="form-control form-control-sm" id="cuti2" readonly>
                             </div>
                         </div>
                         <div class="col-md-4">
                             <div class="form-group">
                                 <label>Tanggal Masuk</label>
                                 <input type="text" name="masuk" class="form-control form-control-sm" id="masuk" readonly>
                             </div>
                         </div>
                     </div>
                     <div class="form-group">
                         <label>Keterangan</label>
                         <input type="text" name="keterangan" class="form-control form-control-sm" id="keterangan" readonly>
                     </div>
                     <div class="form-group">
                         <label>Nama Kepala Bidang</label>
                         <input type="text" name="nama_kabid" class="form-control form-control-sm" required>
                     </div>
                     <div class="form-group">
                         <label>Alasan Ditolak</label>
                         <input type="text" name="alasan_ditolak" class="form-control form-control-sm" placeholder="Abaikan jika cuti diterima">
                     </div>
                     <div class="form-group">
                         <div class="custom-control custom-radio custom-control-inline">
                             <input type="radio" id="customRadioInline1" name="is_approve" class="custom-control-input" value="0" required>
                             <label class="custom-control-label" for="customRadioInline1">Terima</label>
                         </div>
                         <div class="custom-control custom-radio custom-control-inline">
                             <input type="radio" id="customRadioInline2" name="is_approve" class="custom-control-input" value="2" required>
                             <label class="custom-control-label" for="customRadioInline2">Tolak</label>
                         </div>
                     </div>
                     <button type="submit" name="simpan" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
                     <button type="button" class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="far fa-calendar-alt"></i>
                         Kalender
                     </button>
                     <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Modal Kalender -->
 <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLongTitle">Kalendar</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <br>
             <center>
                 <iframe src="https://calendar.google.com/calendar/embed?height=400&amp;wkst=1&amp;bgcolor=%23ffffff&amp;ctz=Asia%2FBangkok&amp;showTitle=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;hl=id&amp;src=ZW4uaW5kb25lc2lhbiNob2xpZGF5QGdyb3VwLnYuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&amp;color=%237986CB" style="border-width:0" width="700" height="400" frameborder="0" scrolling="no"></iframe>
             </center>
             <br>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
             </div>
         </div>
     </div>
 </div>


 <script>
     $('.tombol-edit').on('click', function() {
         const id = $(this).data('id');
         $.ajax({
             url: '<?php echo base_url('kaur/get_cuti_staf'); ?>',
             data: {
                 id: id
             },
             method: 'post',
             dataType: 'json',
             success: function(data) {
                 $('#nama').val(data.nama);
                 $('#jenis_cuti').val(data.jenis_cuti);
                 $('#jml_cuti').val(data.jml_cuti);
                 $('#sisa_cuti').val(data.sisa_cuti);
                 $('#cuti').val(data.cuti);
                 $('#cuti2').val(data.cuti2);
                 $('#masuk').val(data.masuk);
                 $('#keterangan').val(data.keterangan);
                 $('#id').val(data.id);
             }
         });
     });
 </script>