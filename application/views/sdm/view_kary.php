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
        <h5 class="card-header">
            <strong><?= $title; ?></strong>
            <a href="<?php echo base_url('sdm/list_kary'); ?>" class="btn btn-secondary btn-sm float-right">Kembali</a>
        </h5>
        <div class="card-body">
            <button class="btn btn-primary btn-sm mt-2 mb-3" data-toggle="modal" data-target="#edit-kary"><i class="fas fa-edit"></i> Edit Data : <?php echo $pegawai['nama']; ?></button>
            <div class="row mb-3">
                <div class="col-md-6 pr-3">
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>No Induk Kepegawaian</b> <a class="float-right"><?php echo $pegawai['nik']; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Nama Sekolah</b> <a class="float-right"><?php echo $pegawai['nama_sekolah']; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Jurusan</b> <a class="float-right"><?php echo $pegawai['jurusan']; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Tahun Lulus</b> <a class="float-right"><?php echo $pegawai['tahun_lulus']; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Nama Jenjang</b> <a class="float-right"><?php echo $pegawai['nama_jenjang']; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Kota Lahir</b> <a class="float-right"><?php echo $pegawai['kota_lahir']; ?></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 pl-3">
                    <ul class="list-group list-group-unbordered">
                        <?php if ($pegawai['tgl_lahir'] == NULL) : ?>
                            <li class="list-group-item">
                                <b>Tgl Lahir</b> <a class="float-right"></a>
                            </li>
                        <?php else : ?>
                            <li class="list-group-item">
                                <b>Tgl Lahir</b> <a class="float-right"><?php echo format_indo($pegawai['tgl_lahir']); ?></a>
                            </li>
                        <?php endif; ?>
                        <li class="list-group-item">
                            <b>Agama</b> <a class="float-right"><?php echo $pegawai['agama']; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Status Pernikahan</b> <a class="float-right"><?php echo $pegawai['status_nikah']; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Jenis Kelamin</b> <a class="float-right"><?php echo $pegawai['jenis_kelamin']; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Golongan Darah</b> <a class="float-right"><?php echo $pegawai['gol_darah']; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Alamat</b> <a class="float-right"><?php echo $pegawai['alamat']; ?></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-12 mt-5">
                <h5 class="font-weight-bolder">Data Keluarga</h5>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Status Keluarga</th>
                            <th scope="col">Tempat Lahir</th>
                            <th scope="col">Tgl Lahir</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">No Telp</th>
                            <!-- <th scope="col">Opsi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($keluarga as $p) : ?>
                            <tr>
                                <th scope="row"><?php echo $i++; ?></th>
                                <td><?php echo $p['nama_keluarga']; ?></td>
                                <td><?php echo $p['posisi_keluarga']; ?></td>
                                <td><?php echo $p['tempat_lahir_keluarga']; ?></td>
                                <td><?php echo format_indo($p['tgl_lahir_keluarga']); ?></td>
                                <td><?php echo $p['alamat_keluarga']; ?></td>
                                <td><?php echo $p['telp_keluarga']; ?></td>
                                <!-- <td><button class="tombol-edit btn btn-info btn-block btn-sm" data-id="<?php echo $p['id_keluarga']; ?>" data-toggle="modal" data-target="#edit-user"><i class="fas fa-edit"></i> Edit</button></td> -->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->


<div class="modal fade" id="edit-kary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Pegawai</h5>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('sdm/view_kary/' . $pegawai['pegawai_id']); ?>" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Karyawan</label>
                                <input type="hidden" name="id_karyawan" value="<?php echo $pegawai['id_karyawan']; ?>">
                                <input type="hidden" name="pegawai_id" value="<?php echo $pegawai['pegawai_id']; ?>">
                                <input type="text" class="form-control form-control-sm" name="nama" value="<?php echo $pegawai['nama']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control form-control-sm" name="alamat" value="<?php echo $pegawai['alamat']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>No Telp</label>
                                <input type="number" class="form-control form-control-sm" name="telp" value="<?php echo $pegawai['telp']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select class="form-control form-control-sm" name="jenis_kelamin" required>
                                    <option value="<?php echo $pegawai['jenis_kelamin']; ?>"><?php echo $pegawai['jenis_kelamin']; ?></option>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Sekolah</label>
                                <input type="text" class="form-control form-control-sm" name="nama_sekolah" value="<?php echo $pegawai['nama_sekolah']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jurusan</label>
                                <input type="text" class="form-control form-control-sm" name="jurusan" value="<?php echo $pegawai['jurusan']; ?>" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tahun Lulus</label>
                                        <input type="number" class="form-control form-control-sm" name="tahun_lulus" value="<?php echo $pegawai['tahun_lulus']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Jenjang</label>
                                        <input type="text" class="form-control form-control-sm" name="nama_jenjang" value="<?php echo $pegawai['nama_jenjang']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kota Tempat Lahir</label>
                                        <input type="text" class="form-control form-control-sm" name="kota_lahir" value="<?php echo $pegawai['kota_lahir']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" class="form-control form-control-sm" name="tgl_lahir" value="<?php echo $pegawai['tgl_lahir']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Agama</label>
                                <input type="text" class="form-control form-control-sm" name="agama" value="<?php echo $pegawai['agama']; ?>" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status Pernikahan</label>
                                        <select class="form-control form-control-sm" name="status_nikah" required>
                                            <option value="<?php echo $pegawai['status_nikah']; ?>"><?php echo $pegawai['status_nikah']; ?></option>
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
                                            <option value="<?php echo $pegawai['gol_darah']; ?>"><?php echo $pegawai['gol_darah']; ?></option>
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
                    <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                </form>
            </div>
        </div>
    </div>
</div>







<div class="modal fade" id="edit-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('sdm/list_kary'); ?>" method="post">
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
                            <div class="form-group">
                                <label>Jurusan</label>
                                <input type="text" class="form-control form-control-sm" name="jurusan" required>
                            </div>
                            <div class="form-group">
                                <label>Tahun Lulus</label>
                                <input type="text" class="form-control form-control-sm" name="tahun_lulus" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Jenjang</label>
                                <input type="text" class="form-control form-control-sm" name="nama_jenjang" required>
                            </div>
                            <div class="form-group">
                                <label>Kota Tempat Lahir</label>
                                <input type="text" class="form-control form-control-sm" name="kota_lahir" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" class="form-control form-control-sm" name="tgl_lahir" required>
                            </div>
                            <div class="form-group">
                                <label>Agama</label>
                                <input type="text" class="form-control form-control-sm" name="agama" required>
                            </div>
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
            url: '<?php echo base_url('sdm/get_user'); ?>',
            data: {
                id: id
            },
            method: 'post',
            dataType: 'json',
            success: function(data) {
                $('#nama').val(data.nama);
                $('#id').val(data.id);
            }
        });
    });
</script>