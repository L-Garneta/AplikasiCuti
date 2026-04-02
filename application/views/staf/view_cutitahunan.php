<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="card">
        <h5 class="card-header">
            <strong><?= $title; ?></strong>
            <form class="form-inline float-right" action="<?php echo base_url('staf/view_cutitahunan1'); ?>"
                method="post">
                <div class="form-group">
                    <label for="inputPassword2" class="sr-only">Tahun</label>
                    <input type="number" class="form-control form-control-sm" id="inputPassword2" name="tahun"
                        placeholder="Masukkan Tahun" required>
                </div>
                <button type="submit" class="btn btn-primary btn-sm ml-2"><i class="fas fa-search"></i> Cari</button>
            </form>
        </h5>
        <div class="card-body">
            <table class="table table-hover mt-2" id="table-id">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tgl Input</th>
                        <th scope="col">Jenis Cuti</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Cuti Diambil</th>
                        <th scope="col">Sisa Cuti</th>
                        <th scope="col">Cuti 1</th>
                        <th scope="col">Cuti 2</th>
                        <th scope="col">Masuk Kerja</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <?php $i = 1; ?>
                <?php foreach ($cuti_saya as $uc): ?>
                    <tbody>
                        <tr>
                            <th scope="row"><?php echo $i++; ?></th>
                            <td><?php echo format_indo($uc['input']); ?></td>
                            <td><?php echo $uc['jenis_cuti']; ?></td>
                            <td><?php echo $uc['keterangan']; ?></td>
                            <td><?php echo $uc['jml_cuti']; ?></td>
                            <td><?php echo $uc['sisa_cuti']; ?></td>
                            <td><?php echo format_indo($uc['cuti']); ?></td>
                            <td><?php echo format_indo($uc['cuti2']); ?></td>
                            <td><?php echo format_indo($uc['masuk']); ?></td>
                            <td>
                                <a href="<?= base_url('staf/cetak_data/' . $uc['id']); ?>" 
                                class="btn btn-danger btn-sm" target="_blank">
                                    PDF
                                </a>
                            </td>
                        </tr>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->

<!-- End of Main Content -->