<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h5 class="h5 mb-4 text-gray-800"><strong><?= $title; ?></strong></h5>
    <?php foreach ($detail_staf as $ds) : ?>
        <div class="card mr-1">
            <div class="card-header">
                <?php echo $ds['nama']; ?>
                <br><?php echo $ds['alamat']; ?>
            </div>
            <div class="card-body ml-0 mr-0">
                <div class="row">
                    <div class="col-6 col-md-3">Username : <?php echo $ds['username']; ?></div>
                    <div class="col-6 col-md-3">Bagian : <?php echo $ds['bagian']; ?></div>
                    <div class="col-6 col-md-3">Jabatan : <?php echo $ds['jabatan']; ?></div>
                    <div class="col-6 col-md-3">Nama Sekolah : <?php echo $ds['nama_sekolah']; ?></div>
                    <div class="col-6 col-md-3">Jurusan : <?php echo $ds['jurusan']; ?></div>
                    <div class="col-6 col-md-3">Tahun Lulus : <?php echo $ds['tahun_lulus']; ?></div>
                    <div class="col-6 col-md-3">Nama Jenjang : <?php echo $ds['nama_jenjang']; ?></div>
                    <div class="col-6 col-md-3">Kota Kelahiran: <?php echo $ds['kota_lahir']; ?></div>
                    <div class="col-6 col-md-3">Tanggal Lahir : <?php echo $ds['tgl_lahir']; ?></div>
                    <div class="col-6 col-md-3">Agama : <?php echo $ds['agama']; ?></div>
                    <div class="col-6 col-md-3">Status Pernikahan : <?php echo $ds['status_nikah']; ?></div>
                    <div class="col-6 col-md-3">Golongan Darah : <?php echo $ds['gol_darah']; ?></div>
                    <div class="col-6 col-md-3">Jenis Kelamin : <?php echo $ds['jenis_kelamin']; ?></div>
                    <div class="col-6 col-md-3">Nama Suami / Istri: <?php echo $ds['nama_suami']; ?></div>
                </div>
                <hr>
                <a href="javascript:window.history.go(-1);" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<!-- /.container-fluid -->