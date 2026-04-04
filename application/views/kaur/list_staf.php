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
                <strong><?= $title; ?> <?php echo $user['bagian']; ?>
            </h5>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="table-id">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">NIK</th>
                                <th scope="col">Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($pegawai as $lu) : ?>
                                <tr>
                                    <th scope="row"><?php echo $i++; ?></th>
                                    <td><?php echo $lu['nama']; ?></td>
                                    <td><?php echo $lu['nik']; ?></td>
                                    <td><?php echo $lu['jabatan']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>