<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="card">
    <h5 class="card-header">
      <strong><?= $title; ?></strong>
    </h5>
    <div class="card-body">
      <table class="table table-hover" id="table-id">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Tgl Input</th>
            <th scope="col">NIK</th>
            <th scope="col">Nama</th>
            <th scope="col">Jabatan</th>
            <th scope="col">Bagian</th>
            <th scope="col">Tgl Cuti</th>
            <th scope="col">Tgl Cuti 2</th>
            <th scope="col">Tgl Masuk</th>
            <th scope="col">Sisa Cuti</th>
            <th scope="col">Status</th>
            <th scope="col">Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($cuti_kary as $ck) : ?>
            <tr>
              <th scope="row"><?php echo $i++;  ?></th>
              <td><?php echo format_indo($ck['input']); ?></td>
              <td><?php echo $ck['nik']; ?></td>
              <td><?php echo $ck['nama']; ?></td>
              <td><?php echo $ck['jabatan']; ?></td>
              <td><?php echo $ck['bagian']; ?></td>
              <td><?php echo format_indo($ck['cuti']); ?></td>
              <td><?php echo format_indo($ck['cuti2']); ?></td>
              <td><?php echo format_indo($ck['masuk']); ?></td>
              <td><?php echo $ck['sisa_cuti']; ?></td>
              <?php if ($ck['is_approve'] == 0) : ?>
                <td><strong>Diterima</strong></td>
              <?php elseif ($ck['is_approve'] == 2) : ?>
                <td><strong>Ditolak</strong></td>
              <?php else : ?>
                <td><strong>Menunggu</strong></td>
              <?php endif; ?>
              <td><a href="<?php echo base_url('sdm/detail_cuti/'); ?><?php echo $ck['id']; ?>" class="btn btn-info btn-sm btn-block">Detail</a>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


</div>
<!-- /.container-fluid -->