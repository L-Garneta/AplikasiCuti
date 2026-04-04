<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card">
        <h5 class="card-header">
            <strong><?= $title; ?></strong>
            <a href="javascript:window.history.go(-1);" class="btn btn-secondary btn-sm float-right">Kembali</a>
        </h5>
        <div class="card-body">
            <!-- Grid column -->
            <!--Panel-->
            <?php foreach ($cuti_pegawai as $cuti) : ?>
                <h5 class="card-header light-blue lighten-1 white-text text-uppercase font-weight-bold text-left mb-2"><?php echo $cuti['nama']; ?>
                    <br><?php echo $cuti['nik']; ?>
                    <br><?php echo $cuti['bagian']; ?>
                </h5>
                <div class="row">
                    <div class="col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Tanggal Pengajuan Cuti
                                <span class="badge badge-light badge-pill" style="font-size:15px;"><?php echo format_indo($cuti['tgl_input']); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Tanggal Cuti
                                <span class="badge badge-light badge-pill" style="font-size:15px;"><?php echo format_indo($cuti['cuti']); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Tanggal Cuti 2
                                <span class="badge badge-light badge-pill" style="font-size:15px;"><?php echo format_indo($cuti['cuti2']); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Tanggal Masuk
                                <span class="badge badge-light badge-pill" style="font-size:15px;"><?php echo format_indo($cuti['masuk']); ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Jenis Cuti
                                <span class="badge badge-light badge-pill" style="font-size:15px;"><?php echo $cuti['jenis_cuti']; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Keterangan
                                <span class="badge badge-light badge-pill" style="font-size:15px;"><?php echo $cuti['keterangan']; ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                No HP / Telp
                                <span class="badge badge-light badge-pill" style="font-size:15px;"><?php echo $cuti['telp']; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Atasan
                                <span class="badge badge-light badge-pill" style="font-size:15px;"><?php echo $cuti['atasan']; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Status
                                <?php if ($cuti['is_approve'] == 1) : ?>
                                    <span class="badge badge-light badge-pill" style="font-size:15px;">Diterima</span>
                                <?php elseif ($cuti['is_approve'] == 2) : ?>
                                    <span class="badge badge-light badge-pill" style="font-size:15px;">Ditolak</span>
                                <?php else : ?>
                                    <span class="badge badge-light badge-pill" style="font-size:15px;">Menunggu</span>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <p class="text-muted mb-0 pt-3" style="font-size:14px;">* Cuti Karyawan Bagian <?php echo $cuti['bagian']; ?>.</p>
        </div>
    <?php endforeach; ?>
    <!--/.Panel-->
    </div>
</div>




</div>
</div>


<!-- Grid column -->
</div>