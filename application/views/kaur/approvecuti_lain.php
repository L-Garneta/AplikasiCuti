<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="card">
        <div class="card-header">
            <strong><?= $title; ?></strong>
            <a href="javascript:window.history.go(-1);" class="btn btn-secondary btn-sm float-right">Kembali</a>
        </div>
        <div class="card-body">
            <h5><?php echo $staf_approve['nama']; ?></h5>
            <form action="<?php echo base_url('kaur/approvecuti_lain/'); ?><?php echo $staf_approve['id']; ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $staf_approve['id']; ?>">
                <input type="hidden" name="id_user" value="<?php echo $staf_approve['id_user']; ?>">
                <input type="hidden" id="nama" name="nama" value="<?php echo $staf_approve['nama']; ?>">
                <input type="hidden" name="bagian" value="<?php echo $staf_approve['bagian']; ?>">
                <input type="hidden" name="jabatan" value="<?php echo $staf_approve['jabatan']; ?>">
                <input type="hidden" name="jenis_cuti" value="<?php echo $staf_approve['jenis_cuti']; ?>">
                <input type="hidden" name="alamat" value="<?php echo $staf_approve['alamat']; ?>">
                <input type="hidden" name="telp" value="<?php echo $staf_approve['telp']; ?>">
                <input type="hidden" name="atasan" value="<?php echo $user['nama']; ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-1 mt-1">
                            <label for="kabag" style="font-size:14px;">Kepala Bidang /Bagian :</label>
                            <input type="text" id="kabag" class="form-control" name="kabag" placeholder="Cth: Keuangan, Gudang, dll" value="<?php echo set_value('kabag'); ?>">
                            <?php echo form_error('kabag', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-1 mt-1">
                            <label for="namaKabag" style="font-size:14px;">Nama Kabid / Kabag :</label>
                            <input type="text" id="namaKabag" name="nama_kabag" class="form-control" value="<?php echo set_value('nama_kabag'); ?>">
                            <?php echo form_error('nama_kabag', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="direktur" style="font-size:14px;">Direktur</label>
                            <select class="form-control" id="direktur" name="direktur">
                                <option value="Utama">Direktur Utama</option>
                                <option value="Keuangan">Direktur Keuangan</option>
                                <option value="Sumber Daya & Umum">Direktur SDU</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="namaDirektur" style="font-size:14px;">Nama Direktur :</label>
                            <input type="text" id="namaDirektur" name="nama_direktur" class="form-control" value="<?php echo set_value('nama_direktur'); ?>">
                            <?php echo form_error('nama_direktur', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group mb-3 mt-3">
                            <label for="input" style="font-size:14px;">Tgl Input :</label>
                            <input type="text" id="input" value="<?php echo format_indo($staf_approve['tgl_input']); ?>" readonly class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3 mt-3">
                            <label for="nik" style="font-size:14px;">NIK :</label>
                            <input type="text" id="nik" name="nik" value="<?php echo $staf_approve['nik']; ?>" readonly class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3 mt-3">
                            <label for="cuti" style="font-size:14px;">Tanggal Cuti 1 :</label>
                            <input type="text" id="cuti" value="<?php echo format_indo($staf_approve['cuti']); ?>" readonly class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3 mt-3">
                            <label for="cuti2" style="font-size:14px;">Tanggal Cuti 2 :</label>
                            <input type="text" id="cuti2" name="cuti2" value="<?php echo format_indo($staf_approve['cuti2']); ?>" readonly class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3 mt-3">
                            <label for="keterangan">Tanggal Masuk :</label>
                            <input type="text" id="nama" value="<?php echo format_indo($staf_approve['masuk']); ?>" readonly class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Keterangan : </label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $staf_approve['keterangan']; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_approve" id="inlineRadio1" value="0">
                        <label class="form-check-label" for="inlineRadio1"><strong>TERIMA</strong></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_approve" id="inlineRadio2" value="2">
                        <label class="form-check-label" for="inlineRadio2"><strong>TOLAK</strong></label>
                    </div>
                </div>
                <?php echo form_error('is_approve', '<medium class="text-danger pl-2">', '</medium>'); ?>
                <hr>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary mr-2">Approve</button>
                    <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target=".bd-example-modal-lg">
                        Kalender
                    </button>
                </div>
            </form>



        </div>
    </div>








</div>

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