<?php
$files = [
    'application/views/sdm/approval/cuti_sdm.php',
    'application/views/sdm/approval/cuti_kaur.php',
    'application/views/sdm/approval/cutilain_sdm.php',
    'application/views/sdm/approval/cutilain_kaur.php',
    'application/views/sdm/list_cuti_kary.php',
    'application/views/sdm/list_cuti_diluartanggungan_kary.php',
    'application/views/kaur/cuti_staf.php',
    'application/views/kaur/cutilain_staf.php',
    'application/views/kaur/list_cuti_kary.php',
    'application/views/kaur/list_cuti_diluartanggungan_kary.php'
];

$form = '
            <!-- FORM FILTER BULAN/TAHUN -->
            <form action="" method="get" class="form-inline mb-3">
                <select name="m" class="form-control form-control-sm mr-2" required>
                    <option value="">-- Pilih Bulan --</option>
                    <option value="01" <?= ($this->input->get(\'m\') == \'01\') ? \'selected\' : \'\' ?>>Januari</option>
                    <option value="02" <?= ($this->input->get(\'m\') == \'02\') ? \'selected\' : \'\' ?>>Februari</option>
                    <option value="03" <?= ($this->input->get(\'m\') == \'03\') ? \'selected\' : \'\' ?>>Maret</option>
                    <option value="04" <?= ($this->input->get(\'m\') == \'04\') ? \'selected\' : \'\' ?>>April</option>
                    <option value="05" <?= ($this->input->get(\'m\') == \'05\') ? \'selected\' : \'\' ?>>Mei</option>
                    <option value="06" <?= ($this->input->get(\'m\') == \'06\') ? \'selected\' : \'\' ?>>Juni</option>
                    <option value="07" <?= ($this->input->get(\'m\') == \'07\') ? \'selected\' : \'\' ?>>Juli</option>
                    <option value="08" <?= ($this->input->get(\'m\') == \'08\') ? \'selected\' : \'\' ?>>Agustus</option>
                    <option value="09" <?= ($this->input->get(\'m\') == \'09\') ? \'selected\' : \'\' ?>>September</option>
                    <option value="10" <?= ($this->input->get(\'m\') == \'10\') ? \'selected\' : \'\' ?>>Oktober</option>
                    <option value="11" <?= ($this->input->get(\'m\') == \'11\') ? \'selected\' : \'\' ?>>November</option>
                    <option value="12" <?= ($this->input->get(\'m\') == \'12\') ? \'selected\' : \'\' ?>>Desember</option>
                </select>
                <select name="y" class="form-control form-control-sm mr-2" required>
                    <option value="">-- Pilih Tahun --</option>
                    <?php 
                        $yr = date(\'Y\');
                        for($i=0; $i<5; $i++): 
                    ?>
                        <option value="<?= $yr-$i ?>" <?= ($this->input->get(\'y\') == ($yr-$i)) ? \'selected\' : \'\' ?>><?= $yr-$i ?></option>
                    <?php endfor; ?>
                </select>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Filter</button>
                <a href="<?= current_url() ?>" class="btn btn-secondary btn-sm ml-1"><i class="fas fa-sync"></i> Reset</a>
            </form>
';

foreach ($files as $f) {
    if (!file_exists($f)) continue;
    $c = file_get_contents($f);
    // Insert after <div class="card-body">
    // Some files might have spaces or newlines
    $c = preg_replace('/<div class="card-body">\s*/is', '<div class="card-body">' . "\n" . $form, $c);
    file_put_contents($f, $c);
}

echo "Filter forms added to views.\n";
