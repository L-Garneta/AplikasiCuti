<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="card">
    <h5 class="card-header">
      <strong><?= $title; ?></strong>
    </h5>
    <div class="card-body">

            <!-- FORM FILTER BULAN/TAHUN -->
            <form action="" method="get" class="form-inline mb-3">
                <select name="m" class="form-control form-control-sm mr-2" required>
                    <option value="">-- Pilih Bulan --</option>
                    <option value="01" <?= ($this->input->get('m') == '01') ? 'selected' : '' ?>>Januari</option>
                    <option value="02" <?= ($this->input->get('m') == '02') ? 'selected' : '' ?>>Februari</option>
                    <option value="03" <?= ($this->input->get('m') == '03') ? 'selected' : '' ?>>Maret</option>
                    <option value="04" <?= ($this->input->get('m') == '04') ? 'selected' : '' ?>>April</option>
                    <option value="05" <?= ($this->input->get('m') == '05') ? 'selected' : '' ?>>Mei</option>
                    <option value="06" <?= ($this->input->get('m') == '06') ? 'selected' : '' ?>>Juni</option>
                    <option value="07" <?= ($this->input->get('m') == '07') ? 'selected' : '' ?>>Juli</option>
                    <option value="08" <?= ($this->input->get('m') == '08') ? 'selected' : '' ?>>Agustus</option>
                    <option value="09" <?= ($this->input->get('m') == '09') ? 'selected' : '' ?>>September</option>
                    <option value="10" <?= ($this->input->get('m') == '10') ? 'selected' : '' ?>>Oktober</option>
                    <option value="11" <?= ($this->input->get('m') == '11') ? 'selected' : '' ?>>November</option>
                    <option value="12" <?= ($this->input->get('m') == '12') ? 'selected' : '' ?>>Desember</option>
                </select>
                <select name="y" class="form-control form-control-sm mr-2" required>
                    <option value="">-- Pilih Tahun --</option>
                    <?php 
                        $yr = date('Y');
                        for($i=0; $i<5; $i++): 
                    ?>
                        <option value="<?= $yr-$i ?>" <?= ($this->input->get('y') == ($yr-$i)) ? 'selected' : '' ?>><?= $yr-$i ?></option>
                    <?php endfor; ?>
                </select>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Filter</button>
                <a href="<?= current_url() ?>" class="btn btn-secondary btn-sm ml-1"><i class="fas fa-sync"></i> Reset</a>
                
            </form>
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