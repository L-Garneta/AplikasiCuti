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
                <a href="javascript:window.history.go(-1);" class="btn btn-secondary btn-sm float-right">Kembali</a></h6>
            </h5>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="table-id">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">NIK</th>
                                <th scope="col">Bagian</th>
                                <th scope="col">Jabatan</th>

                                <th scope="col">Keterangan</th>
                                <th scope="col">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($staf_cuti as $sc) : ?>
                                <?php if ($sc['sisa_cuti'] == 0) : ?>
                                    <tr>
                                        <th scope="row"><?php echo $i++; ?></th>
                                        <td><?php echo $sc['nama']; ?></td>
                                        <td><?php echo $sc['nik']; ?></td>
                                        <td><?php echo $sc['bagian']; ?></td>
                                        <td><?php echo $sc['jabatan']; ?></td>
                                        <td><button class="btn btn-light btn-sm btn-block font-weight-bolder">Cuti Habis</button></td>
                                        <td><a href="<?php echo base_url('kaur/reset_cuti/'); ?><?php echo $sc['id_user'] ?>" class="tombol-reset btn btn-danger btn-sm btn-block" style="font-size:14px;">Reset Cuti</a></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>