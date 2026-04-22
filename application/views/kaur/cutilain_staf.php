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
             <a href="<?php echo base_url('kaur/cuti_staf'); ?>" class="btn btn-primary btn-sm float-right">Approval Cuti Bulanan</a>
         </h5>
         <div class="card-body">

            <!-- FORM FILTER BULAN/TAHUN -->
            <form action="" method="get" class="form-inline mb-3">
                <select name="m" class="form-control form-control-sm mr-2" required>
                    <option value="">-- Pilih Bulan --</option>
                    <option value="01" <?= ($this->input->get('m') == '01') ? 'selected' : '' ?>>Januari</option>
                    <option value="02" <?= ($this->input->get('m') == '02') ? 'selected' : '' ?>>Februari</option>
                    <option value="03" <?= ($this->input->get('m') == '03') ? 'selected' : '' ?>>Maret</option>
                    <option value="04" <?= ($this->input->get('m') == '04') ? 'selected' : '' ?>>April</option>
                    <option value="05" <?= ($this->input->get('m') == '05') ? 'selected' : '' ?>>Mei</option>
                    <option value="06" <?= ($this->input->get('m') == '06') ? 'selected' : '' ?>>Juni</option>
                    <option value="07" <?= ($this->input->get('m') == '07') ? 'selected' : '' ?>>Juli</option>
                    <option value="08" <?= ($this->input->get('m') == '08') ? 'selected' : '' ?>>Agustus</option>
                    <option value="09" <?= ($this->input->get('m') == '09') ? 'selected' : '' ?>>September</option>
                    <option value="10" <?= ($this->input->get('m') == '10') ? 'selected' : '' ?>>Oktober</option>
                    <option value="11" <?= ($this->input->get('m') == '11') ? 'selected' : '' ?>>November</option>
                    <option value="12" <?= ($this->input->get('m') == '12') ? 'selected' : '' ?>>Desember</option>
                </select>
                <select name="y" class="form-control form-control-sm mr-2" required>
                    <option value="">-- Pilih Tahun --</option>
                    <?php 
                        $yr = date('Y');
                        for($i=0; $i<5; $i++): 
                    ?>
                        <option value="<?= $yr-$i ?>" <?= ($this->input->get('y') == ($yr-$i)) ? 'selected' : '' ?>><?= $yr-$i ?></option>
                    <?php endfor; ?>
                </select>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Filter</button>
                <a href="<?= current_url() ?>" class="btn btn-secondary btn-sm ml-1"><i class="fas fa-sync"></i> Reset</a>
            </form>
<div class="table-responsive">
                 <table class="table table-hover" id="table-id">
                     <thead>
                         <tr>
                             <th scope="col">#</th>
                             <th scope="col">Tgl.Input</th>
                             <th scope="col">Nama</th>
                             <th scope="col">Keterangan</th>
                             <th scope="col">Tgl Cuti 1</th>
                             <th scope="col">Tgl Cuti 2</th>
                             <th scope="col">Tgl Masuk</th>
                             <th scope="col">Opsi</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php $i = 1; ?>
                         <?php foreach ($staf_cutilain as $sc) : ?>
                             <?php if ($sc['is_approve'] == 1) : ?>
                                 <tr>
                                     <th scope="row"><?php echo $i++; ?></th>
                                     <td><?php echo format_indo($sc['tgl_input']); ?></td>
                                     <td><?php echo $sc['nama']; ?></td>
                                     <td><?php echo $sc['keterangan']; ?></td>
                                     <td><?php echo format_indo($sc['cuti']); ?></td>
                                     <td><?php echo format_indo($sc['cuti2']); ?></td>
                                     <td><?php echo format_indo($sc['masuk']); ?></td>
                                     <td><a href="<?= base_url('kaur/detail_cuti_diluartanggungan/' . $sc['id']); ?>" class="btn btn-info btn-sm">Detail</a> <button class="tombol-edit btn btn-info btn-block btn-sm" data-id="<?php echo $sc['id']; ?>" data-toggle="modal" data-target="#edit-user"><i class="fas fa-edit"></i> Approval</button></td>
                                 </tr>
                             <?php endif; ?>
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
                 <h5 class="modal-title" id="exampleModalLabel">Approval Cuti Lain</h5>
             </div>
             <div class="modal-body">
                 <form action="<?php echo base_url('kaur/approvecuti_lain'); ?>" method="post">
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Nama Lengkap</label>
                                 <input type="hidden" name="id" id="id">
                                 <input type="text" name="nama" class="form-control form-control-sm" id="nama" readonly>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Jenis Cuti</label>
                                 <input type="text" name="nama" class="form-control form-control-sm" id="jenis_cuti" readonly>
                                 </select>
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
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Kepala Bidang / Bagian</label>
                                 <input type="text" class="form-control form-control-sm" name="kabag" placeholder="Cth: Keuangan, Gudang, dll" required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Nama Kabid / Kabag</label>
                                 <input type="text" name="nama_kabag" class="form-control form-control-sm" required>
                             </div>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Direktur</label>
                                 <select class="form-control form-control-sm" name="direktur" required>
                                     <option value="">- Pilih -</option>
                                     <option value="Utama">Direktur Utama</option>
                                     <option value="Keuangan">Direktur Keuangan</option>
                                     <option value="Sumber Daya & Umum">Direktur SDU</option>
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Nama Direktur :</label>
                                 <input type="text" name="nama_direktur" class="form-control form-control-sm" required>
                             </div>
                         </div>
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
             url: '<?php echo base_url('kaur/get_cutilain_staf'); ?>',
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