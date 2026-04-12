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
            <th scope="col">Approval 1</th>
            <th scope="col">Approval 2</th>
            <th scope="col">Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($cuti_kary as $ck): ?>
            <tr>
              <th scope="row"><?php echo $i++; ?></th>
              <td><?php echo format_indo($ck['input']); ?></td>
              <td><?php echo $ck['nik']; ?></td>
              <td><?php echo $ck['nama']; ?></td>
              <td><?php echo $ck['jabatan']; ?></td>
              <td><?php echo $ck['bagian']; ?></td>
              <td><?php echo format_indo($ck['cuti']); ?></td>
              <td><?php echo format_indo($ck['cuti2']); ?></td>
              <td><?php echo format_indo($ck['masuk']); ?></td>
              <td><?php echo $ck['sisa_cuti']; ?></td>
              <!-- APPROVAL 1 -->
              <td>
                <?php if ($ck['approved_kaur'] == 0): ?>
                  <span class="badge badge-success">ACC</span>
                <?php elseif ($ck['approved_kaur'] == 2): ?>
                  <span class="badge badge-danger">Ditolak</span>
                <?php else: ?>
                  <span class="badge badge-warning">Menunggu</span>
                <?php endif; ?>
              </td>

              <!-- APPROVAL 2 -->
              <td>
                <?php if ($ck['approved_sdm'] == 0): ?>
                  <span class="badge badge-success">ACC</span>
                <?php elseif ($ck['approved_sdm'] == 2): ?>
                  <span class="badge badge-danger">Ditolak</span>
                <?php else: ?>
                  <span class="badge badge-warning">Menunggu</span>
                <?php endif; ?>
              </td>

              <!-- OPSI -->
              <td>
                <a href="<?= base_url('sdm/detail_cuti/' . $ck['id']); ?>" class="btn btn-info btn-sm">
                  Detail
                </a>
              </td>

            </tr>
          <?php endforeach; ?>
        </tbody>