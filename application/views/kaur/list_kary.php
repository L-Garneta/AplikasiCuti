<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <?php echo $this->session->flashdata('msg'); ?>
    <?php if (validation_errors()) { ?>
        <div class="alert alert-danger font-weight-bolder text-center">
            <a class="close" data-dismiss="alert">x</a>
            <strong><?php echo strip_tags(validation_errors()); ?></strong>
        </div>
    <?php } ?>
    <div class="card">
        <h5 class="card-header"> <strong><?= $title; ?></strong></h5>
        <div class="card-body">
            <div class="col-md-12">
                <table class="table table-hover" id="table-id">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIK</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Bagian</th>
                            <th scope="col">Jabatan</th>
                            <th scope="col">Detail</th>
                            <th scope="col">Data</th>
                            <th scope="col">Keluarga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($pegawai as $p) : ?>
                            <tr>
                                <th scope="row"><?php echo $i++; ?></th>
                                <td><?php echo $p['nik']; ?></td>
                                <td><?php echo $p['nama']; ?></td>
                                <td><?php echo $p['bagian']; ?></td>
                                <td><?php echo $p['jabatan']; ?></td>
                                <?php if (!isset($p['pegawai_id']) || $p['pegawai_id'] == NULL) : ?>
                                    <td><button class="btn btn-light btn-block btn-sm"><i class="far fa-times-circle"></i> No Data</button></td>
                                <?php else : ?>
                                    <td><a href="<?php echo base_url('kaur/view_kary/' . $p['id']); ?>" class="btn btn-info btn-sm btn-block"><i class="fas fa-info-circle"></i> Detail</td>
                                <?php endif; ?>
                                <?php if (!isset($p['pegawai_id']) || $p['pegawai_id'] == NULL) : ?>
                                    <td><button class="tombol-edit btn btn-info btn-block btn-sm" data-id="<?php echo $p['id']; ?>" data-toggle="modal" data-target="#edit-user"><i class="fas fa-plus-circle"></i> Data</button></td>
                                <?php else : ?>
                                    <td><button class="btn btn-light btn-block btn-sm"><i class="far fa-check-circle"></i> Sudah Input</button></td>
                                <?php endif; ?>
                                <td><button class="tombol-edit btn btn-info btn-block btn-sm" data-id="<?php echo $p['id']; ?>" data-toggle="modal" data-target="#keluarga"><i class="fas fa-plus-circle"></i> Keluarga</button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->


<div class="modal fade" id="edit-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Karyawan</h5>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('kaur/list_kary'); ?>" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Karyawan</label>
                                <input type="hidden" name="pegawai_id" id="id">
                                <input type="text" class="form-control form-control-sm" name="nama" id="nama" readonly>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control form-control-sm" name="alamat" required>
                            </div>
                            <div class="form-group">
                                <label>No Telp</label>
                                <input type="number" class="form-control form-control-sm" name="telp" required>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select class="form-control form-control-sm" name="jenis_kelamin" required>
                                    <option value="">- Pilih Jenis Kelamin</option>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Sekolah</label>
                                <input type="text" class="form-control form-control-sm" name="nama_sekolah" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jurusan</label>
                                <input type="text" class="form-control form-control-sm" name="jurusan" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tahun Lulus</label>
                                        <input type="number" class="form-control form-control-sm" name="tahun_lulus" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Jenjang</label>
                                        <input type="text" class="form-control form-control-sm" name="nama_jenjang" placeholder="Cth: SMU, S1, dll" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kota Tempat Lahir</label>
                                        <input type="text" class="form-control form-control-sm" name="kota_lahir" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" class="form-control form-control-sm" name="tgl_lahir" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Agama</label>
                                <input type="text" class="form-control form-control-sm" name="agama" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status Pernikahan</label>
                                        <select class="form-control form-control-sm" name="status_nikah" required>
                                            <option value="">- Pilih Status -</option>
                                            <option value="Belum Menikah">Belum Menikah</option>
                                            <option value="Menikah">Menikah</option>
                                            <option value="Janda">Janda</option>
                                            <option value="Duda">Duda</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Gol. Darah</label>
                                        <select class="form-control form-control-sm" name="gol_darah" required>
                                            <option value="">- Pilih -</option>
                                            <option value="O">O</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="AB">AB</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Simpan Data</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="keluarga" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Keluarga</h5>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('kaur/add_keluarga'); ?>" method="post">
                    <div class="form-group">
                        <label>Nama Karyawan</label>
                        <input type="hidden" name="pegawai_id" id="id_pegawai">
                        <input type="text" class="form-control form-control-sm" name="nama" id="nama_pegawai" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nama Keluarga</label>
                        <input type="text" class="form-control form-control-sm" name="nama_keluarga" required>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status Keluarga</label>
                                <select class="form-control form-control-sm" name="posisi_keluarga" required>
                                    <option value="">- Pilih Status -</option>
                                    <option value="Ayah">Ayah</option>
                                    <option value="Ibu">Ibu</option>
                                    <option value="Istri">Istri</option>
                                    <option value="Anak">Anak</option>
                                    <option value="Saudara">Saudara</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tempat Lahir</label>
                                <input type="text" class="form-control form-control-sm" name="tempat_lahir_keluarga" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tgl Lahir</label>
                                <input type="date" class="form-control form-control-sm" name="tgl_lahir_keluarga" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control form-control-sm" name="alamat_keluarga" required>
                    </div>
                    <div class="form-group">
                        <label>No Telp</label>
                        <input type="number" class="form-control form-control-sm" name="telp_keluarga" required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Simpan Data</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                </form>
            </div>
        </div>
    </div>
</div>





<script>
    $('.tombol-edit').on('click', function() {
        const id = $(this).data('id');
        $.ajax({
            url: '<?php echo base_url('kaur/get_user'); ?>',
            data: {
                id: id
            },
            method: 'post',
            dataType: 'json',
            success: function(data) {
                $('#nama').val(data.nama);
                $('#nama_pegawai').val(data.nama);
                $('#id').val(data.id);
                $('#id_pegawai').val(data.id);
            }
        });
    });
</script>
