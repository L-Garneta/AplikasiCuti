<div class="container-fluid">

    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>

    <div class="card">
        <h5 class="card-header">
            <strong><?= $title; ?></strong>
        </h5>

        <div class="card-body">
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
                        <?php foreach ($cuti as $c): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $c['nama']; ?></td>
                                <td><?= $c['nik']; ?></td>
                                <td><?= format_indo($c['cuti']); ?></td>
                                <td><?= format_indo($c['cuti2']); ?></td>
                                <td><?= format_indo($c['masuk']); ?></td>

                                <td>
                                    <span class="badge badge-warning">Pending Pj. Klinik</span>
                                </td>

                                <td>
                                    <button class="btn btn-primary btn-sm btn-approve"
                                        data-id="<?= $c['id']; ?>"
                                        data-nama="<?= $c['nama']; ?>"
                                        data-toggle="modal"
                                        data-target="#modal-approval">
                                        Approve
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>

<!-- MODAL SDM -->
<div class="modal fade" id="modal-approval" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Approval Penanggung Jawab Klinik</h5>
            </div>

            <div class="modal-body">
                <form action="<?= base_url('sdm/approve_cuti_sdm'); ?>" method="post">

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
                        <textarea name="alasan_ditolak" class="form-control" placeholder="Wajib diisi jika menolak"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

                </form>
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
