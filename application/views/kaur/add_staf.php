<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">
                    <strong><?= $title; ?></strong>
                </h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                            <!-- Page Content -->
                            <form action="<?php echo base_url('kaur/add_staf'); ?>" method="post">
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tglInput">Nama Lengkap :</label>
                                            <input type="hidden" name="date_created" value="<?php echo date('Y/m/d'); ?>">
                                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo set_value('nama'); ?>">
                                            <?php echo form_error('nama', '<small class="text-danger pl-2">', '</small>'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="tglInput">Jabatan :</label>
                                            <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo set_value('jabatan'); ?>">
                                            <?php echo form_error('jabatan', '<small class="text-danger pl-2">', '</small>'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="bagian">Bagian :</label>
                                            <select name="bagian" id="bagian" class="form-control">
                                                <option value="">Pilih Bagian</option>
                                                <?php foreach ($user_list as $ul) : ?>
                                                    <option value="<?php echo $ul['bagian']; ?>">
                                                        <?php echo $ul['bagian']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="nik">NIK :</label>
                                            <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $kode_nik; ?>" readonly>
                                            <?php echo form_error('nik', '<small class="text-danger pl-2">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="level">Level Akses :</label>
                                            <select class="form-control" name="role_id" id="level">
                                                <option value="">- Pilih Level -</option>
                                                <option value="3">KOORDINATOR</option>
                                                <option value="4">STAF</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tglInput">Username :</label>
                                            <input type="varchar" class="form-control" id="nama" name="username" value="<?php echo set_value('username'); ?>">
                                            <?php echo form_error('username', '<small class="text-danger pl-2">', '</small>'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="tglInput">Password :</label>
                                            <input type="password" class="form-control" id="nama" name="password1">
                                            <?php echo form_error('password1', '<small class="text-danger pl-2">', '</small>'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="tglInput">Password :</label>
                                            <input type="password" class="form-control" id="nama" name="password2" placeholder="Tulis ulang password">
                                        </div>
                                        <button type="submit" name="add_user" class="btn btn-primary float-right mb-3">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->