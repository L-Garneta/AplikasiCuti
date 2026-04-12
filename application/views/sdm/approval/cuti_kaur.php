<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <?= $this->session->flashdata('msg'); ?>

    <?php if (validation_errors()): ?>
        <div class="alert alert-danger">
            <strong><?= strip_tags(validation_errors()); ?></strong>
        </div>
    <?php endif; ?>

    <div class="card">
        <h5 class="card-header">
            <strong><?= $title; ?></strong>
        </h5>

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-hover" id="table-id">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tgl Input</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Tgl Cuti 1</th>
                            <th>Tgl Cuti 2</th>
                            <th>Tgl Masuk</th>
                            <th>Approval 1</th>
                            <th>Approval 2</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($staf_cuti as $sc): ?>

                            <?php if ($sc['approved_kaur'] == 0 && $sc['approved_sdm'] == 1): ?>

                                <tr>
                                    <th><?= $i++; ?></th>
                                    <td><?= format_indo($sc['input']); ?></td>
                                    <td><?= $sc['nama']; ?></td>
                                    <td><?= $sc['nik']; ?></td>
                                    <td><?= format_indo($sc['cuti']); ?></td>
                                    <td><?= format_indo($sc['cuti2']); ?></td>
                                    <td><?= format_indo($sc['masuk']); ?></td>

                                    <!-- APPROVAL KAUR -->
                                    <td>
                                        <span class="badge badge-success">ACC</span>
                                    </td>

                                    <!-- APPROVAL SDM -->
                                    <td>
                                        <span class="badge badge-warning">Menunggu</span>
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
<div class="modal fade" id="modal-approval" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Approval SDM</h5>
            </div>

            <div class="modal-body">
                <form action="<?= base_url('sdm/approve_sdm'); ?>" method="post">

                    <input type="hidden" name="id" id="id">

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" id="nama" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label>Jenis Cuti</label>
                        <input type="text" id="jenis_cuti" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" id="keterangan" class="form-control" readonly>
                    </div>

                    <!-- RADIO BUTTON -->
                    <div class="form-group">
                        <label>Keputusan</label><br>

                        <input type="radio" name="approved_sdm" value="0" required> Terima
                        <input type="radio" name="approved_sdm" value="2" required> Tolak
                    </div>

                    <div class="form-group">
                        <label>Alasan Ditolak</label>
                        <input type="text" name="alasan_ditolak" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

                </form>
            </div>

        </div>
    </div>
</div>