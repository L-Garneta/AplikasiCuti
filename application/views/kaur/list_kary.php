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
            <button class="btn btn-success mb-3" data-toggle="modal" data-target="#hitung-gaji"><i class="fas fa-calculator"></i> Hitung Gaji Karyawan</button>
            <button class="btn btn-info mb-3 ml-2" data-toggle="modal" data-target="#guide-kalkulator"><i class="fas fa-info-circle"></i> Guide Kalkulator</button>
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
                                <td><button class="tombol-edit btn btn-info btn-block btn-sm" data-id="<?php echo $p['id']; ?>" data-toggle="modal" data-target="#edit-user"><i class="fas fa-edit"></i> Edit</button></td>
                                <td><button class="tombol-edit btn btn-secondary btn-block btn-sm" data-id="<?php echo $p['id']; ?>" data-toggle="modal" data-target="#keluarga"><i class="fas fa-users"></i> Keluarga</button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- Modal Edit User -->
<div class="modal fade" id="edit-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Edit Data Karyawan (NIK & Jabatan)</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('kaur/list_kary'); ?>" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Karyawan</label>
                                <input type="hidden" name="pegawai_id" id="id">
                                <input type="text" class="form-control form-control-sm" name="nama" id="nama" required>
                            </div>
                            <div class="form-group">
                                <label>NIK</label>
                                <input type="text" class="form-control form-control-sm" name="nik" id="nik_edit" required>
                            </div>
                            <div class="form-group">
                                <label>Jabatan</label>
                                <input type="text" class="form-control form-control-sm" name="jabatan" id="jabatan_edit" required>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control form-control-sm" name="alamat" id="alamat_edit">
                            </div>
                            <div class="form-group">
                                <label>No Telp</label>
                                <input type="number" class="form-control form-control-sm" name="telp" id="telp_edit">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select class="form-control form-control-sm" name="jenis_kelamin" id="jk_edit">
                                    <option value="">- Pilih Jenis Kelamin -</option>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Agama</label>
                                <input type="text" class="form-control form-control-sm" name="agama" id="agama_edit">
                            </div>
                            <div class="form-group">
                                <label>Kota Tempat Lahir</label>
                                <input type="text" class="form-control form-control-sm" name="kota_lahir" id="kota_lahir_edit">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" class="form-control form-control-sm" name="tgl_lahir" id="tgl_lahir_edit">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                    </div>
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
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
                $('#nik_edit').val(data.nik);
                $('#jabatan_edit').val(data.jabatan);
                $('#alamat_edit').val(data.alamat);
                $('#telp_edit').val(data.telp);
                $('#jk_edit').val(data.jenis_kelamin);
                $('#agama_edit').val(data.agama);
                $('#kota_lahir_edit').val(data.kota_lahir);
                $('#tgl_lahir_edit').val(data.tgl_lahir);
            }
        });
    });
</script>

<!-- Modal Hitung Gaji -->
<div class="modal fade" id="hitung-gaji" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-calculator"></i> Kalkulator & Slip Gaji Karyawan</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formHitungGaji" action="<?= base_url('kaur/cetak_slip_gaji') ?>" method="POST" target="_blank">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Pilih Pegawai</label>
                                <select name="id_pegawai" class="form-control" required>
                                    <option value="">- Pilih -</option>
                                    <?php foreach ($pegawai as $p) : ?>
                                        <option value="<?= $p['id'] ?>"><?= $p['nama'] ?> (<?= $p['nik'] ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bulan</label>
                                <select name="bulan" class="form-control" required>
                                    <option value="">- Bulan -</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tahun</label>
                                <select name="tahun" class="form-control" required>
                                    <option value="">- Tahun -</option>
                                    <?php 
                                        $yr = date('Y');
                                        for($i=0; $i<5; $i++): 
                                    ?>
                                        <option value="<?= $yr-$i ?>"><?= $yr-$i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <!-- KOLOM KIRI: PENDAPATAN -->
                        <div class="col-md-6 border-right">
                            <h6 class="font-weight-bold text-primary mb-3">Penerimaan (THP)</h6>
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label">Gaji Pokok</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control form-control-sm" name="gaji_pokok" value="0" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label">Gaji Lembur</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control form-control-sm" name="gaji_lembur" value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label text-info">Tunj. Kinerja</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control form-control-sm" name="tunj_kinerja" value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label text-info">Tunj. Jabatan</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control form-control-sm" name="tunj_jabatan" value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label text-info">Tunj. Makan</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control form-control-sm" name="tunj_makan" value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label text-info">Tunj. Beras</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control form-control-sm" name="tunj_beras" value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label text-info">Jasa Pelayanan</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control form-control-sm" name="jasa_pelayanan" value="0">
                                </div>
                            </div>
                        </div>

                        <!-- KOLOM KANAN: POTONGAN -->
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-danger mb-3">Potongan</h6>
                            <div class="form-group row bg-light py-1">
                                <label class="col-sm-6 col-form-label font-weight-bold">Pot. Absensi</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control form-control-sm" name="pot_absensi" id="pot_absensi" value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label">BPJS</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control form-control-sm" name="pot_bpjs" value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label">Kesejahteraan</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control form-control-sm" name="pot_kesehatan" value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label text-wrap">Pot. Keterlambatan</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control form-control-sm" name="pot_telat" value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label">Pot. Pajak (PPh)</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control form-control-sm" name="pot_pajak" value="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-secondary mt-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary btn-block" id="btnHitung">
                                    <i class="fas fa-sync-alt"></i> Cek & Hitung Otomatis
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-print"></i> Cetak Slip Gaji (PDF)
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <div id="hasilHitung" class="mt-4" style="display:none;">
                    <div class="card card-body bg-light">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <small>Total THP + Lembur</small>
                                <h5 class="font-weight-bold text-primary">Rp <span id="res_total_thp">0</span></h5>
                            </div>
                            <div class="col-md-4 border-left border-right">
                                <small>Total Potongan</small>
                                <h5 class="font-weight-bold text-danger">Rp <span id="res_total_pot">0</span></h5>
                            </div>
                            <div class="col-md-4">
                                <small>Gaji Dibayarkan</small>
                                <h5 class="font-weight-bold text-success h4">Rp <span id="res_gaji_bersih">0</span></h5>
                            </div>
                        </div>
                        <small class="text-center text-muted mt-2">Auto-count: <span id="res_total_cuti">0</span> hari cuti terhitung sebagai potongan absensi.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#formHitungGaji #btnHitung').on('click', function(e) {
    e.preventDefault();
    const btn = $(this);
    btn.html('<i class="fas fa-spinner fa-spin"></i> Loading...').prop('disabled', true);
    
    $.ajax({
        url: '<?= base_url('kaur/hitung_gaji_ajax') ?>',
        method: 'POST',
        data: $('#formHitungGaji').serialize(),
        dataType: 'json',
        success: function(res) {
            if(res.status == 'success') {
                // Auto-fill Potongan Absensi
                $('#pot_absensi').val(res.potongan_raw);
                
                // Update Summary
                $('#res_total_cuti').text(res.total_cuti);
                $('#res_total_thp').text(res.total_thp);
                $('#res_total_pot').text(res.total_potongan);
                $('#res_gaji_bersih').text(res.gaji_bersih);
                
                $('#hasilHitung').slideDown();
            } else {
                alert(res.message);
            }
            btn.html('<i class="fas fa-sync-alt"></i> Cek & Hitung Otomatis').prop('disabled', false);
        },
        error: function() {
            alert('Terjadi kesalahan sistem.');
            btn.html('<i class="fas fa-sync-alt"></i> Cek & Hitung Otomatis').prop('disabled', false);
        }
    });
});
</script>

<!-- Modal Guide Kalkulator -->
<div class="modal fade" id="guide-kalkulator" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-info-circle"></i> Cara Kerja Kalkulator Gaji</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda tinggal memilih nama Karyawan, Bulan, Tahun, dan memasukkan Gaji Pokok.</p>
                <p>Sistem akan secara otomatis menghitung berapa jumlah hari "Cuti Diluar Tanggungan" (otomatis mengabaikan Cuti Melahirkan, Menikah, Sakit, dan Jatah cuti bulanan(satu hari)).</p>
                <p>Kemudian sistem menampilkan total potongan hari, nilai potongan (Gaji Pokok / 30 x Total Hari), dan Gaji Bersih.</p>
                <ul>
                    <li><strong>Untuk Cuti Bulanan:</strong> Sistem akan memberikan "jatah" gratis 1 hari dalam sebulan. Jika karyawan mengambil cuti bulanan lebih dari 1 hari di bulan tersebut, maka hanya kelebihannya saja yang akan dihitung sebagai hari terpotong. (Contoh: Total ambil cuti bulanan 3 hari -> yang terpotong hanya 2 hari).</li>
                    <li><strong>Untuk Cuti Lain (Lain-Lain):</strong> Akan langsung dihitung sebagai potongan hari (dengan mengabaikan jenis Cuti Melahirkan, Menikah, dan Sakit).</li>
                    <li><strong>Sinkronisasi:</strong> Pastikan semua pengajuan cuti (Bulanan maupun Lain-Lain) sudah di-approve agar terhitung otomatis di sini.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>