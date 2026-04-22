<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <?= $this->session->flashdata('msg'); ?>

    <div class="card">
        <h5 class="card-header">
            <strong><?= $title; ?></strong>
            <a href="<?php echo base_url('kaur/cutilain_staf'); ?>" class="btn btn-primary btn-sm float-right">Approval Cuti (Menikah, Melahirkan, dll)</a>
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

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Cuti</th>
                            <th>Sampai</th>
                            <th>Masuk</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($staf_cuti as $sc): ?>
                            <!-- 🔥 Tahap 1: hanya yang Pending SDM -->
                            <?php if ($sc['approved_kaur'] == 1 && $sc['approved_sdm'] == 1): ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $sc['nama']; ?></td>
                                    <td><?= $sc['nik']; ?></td>
                                    <td><?= format_indo($sc['cuti']); ?></td>
                                    <td><?= format_indo($sc['cuti2']); ?></td>
                                    <td><?= format_indo($sc['masuk']); ?></td>

                                    <td>
                                        <span class="badge badge-warning">Pending SDM</span>
                                    </td>

                                    <td>
                                        <a href="<?= base_url('kaur/detail_cuti/' . $sc['id']); ?>" class="btn btn-info btn-sm">Detail</a>
                                        <button class="btn btn-primary btn-sm btn-approve"
                                            data-id="<?= $sc['id']; ?>"
                                            data-nama="<?= $sc['nama']; ?>"
                                            data-toggle="modal"
                                            data-target="#modal-approval">
                                            Approve
                                        </button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>

<!-- MODAL KAUR -->
<div class="modal fade" id="modal-approval" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Approval SDM</h5>
            </div>

            <div class="modal-body">
                <form action="<?= base_url('kaur/approve_cuti'); ?>" method="post">

                    <input type="hidden" name="id" id="id">

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" id="nama" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label>Keputusan</label><br>

                        <input type="radio" name="is_approve" value="0" required> Terima
                        <input type="radio" name="is_approve" value="2" required> Tolak
                    </div>

                    <!-- 🔥 ALASAN PENOLAKAN -->
                    <div class="form-group">
                        <label>Alasan Ditolak</label>
                        <textarea name="alasan_ditolak" class="form-control" placeholder="Abaikan jika cuti diterima"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <!-- Tombol Kalender -->
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="far fa-calendar-alt"></i> Kalender</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

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
$('.btn-approve').on('click', function() {
    $('#id').val($(this).data('id'));
    $('#nama').val($(this).data('nama'));
});
</script>
