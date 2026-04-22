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
            <a href="<?php echo base_url('staf/history'); ?>" class="btn btn-info btn-sm float-right ml-2">View Cuti Tahunan</a>
            <a href="javascript:window.history.go(-1);" class="btn btn-secondary btn-sm float-right">Kembali</a>
        </h5>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="table-id" style="font-size:13px;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tgl Input</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Jenis Cuti</th>
                            <th scope="col">Cuti 1</th>
                            <th scope="col">Cuti 2</th>
                            <th scope="col">Masuk Kerja</th>
                            <th scope="col">Status</th>
                                <th scope="col">Alasan Ditolak</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($user_cuti as $uc) : ?>
                            <tr>
                                <th scope="row"><?php echo $i++; ?></th>
                                <td><?php echo format_indo($uc['tgl_input']); ?></td>
                                <td><?php echo ucfirst($uc['keterangan']); ?></td>
                                <td><?php echo $uc['jenis_cuti']; ?></td>
                                <td><?php echo format_indo($uc['cuti']); ?></td>
                                <td><?php echo format_indo($uc['cuti2']); ?></td>
                                <td><?php echo format_indo($uc['masuk']); ?></td>
                                <?php if ($uc['is_approve'] == 1) : ?>
                                    <td><span class="btn btn-light btn-sm btn-block font-weight-bolder">Menunggu</span></td>
                                    
                                <?php elseif ($uc['is_approve'] == 2) : ?>
                                    <td><span class="btn btn-light btn-sm btn-block font-weight-bolder">Ditolak</span></td>
                                    <td><span class="badge badge-danger">Closed</span></td>
                                <?php else : ?>
                                    <td><span class="btn btn-light btn-sm btn-block font-weight-bolder">Diterima</span></td>
                                    <td><a href="<?php echo base_url('staf/cetak_cutilain/'); ?><?php echo $uc['id']; ?>" class="btn btn-info btn-sm btn-block" target="_blank">Cetak Data</a></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->