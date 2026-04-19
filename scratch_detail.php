<?php
$files = [
    'application/views/sdm/approval/cuti_sdm.php' => "<?= base_url('sdm/detail_cuti/' . \$c['id']); ?>",
    'application/views/sdm/approval/cutilain_sdm.php' => "<?= base_url('sdm/detail_cuti_diluartanggungan/' . \$c['id']); ?>",
    'application/views/sdm/approval/cuti_kaur.php' => "<?= base_url('kaur/detail_cuti/' . \$c['id']); ?>",
    'application/views/sdm/approval/cutilain_kaur.php' => "<?= base_url('kaur/detail_cuti_diluartanggungan/' . \$c['id']); ?>"
];

foreach($files as $f => $url) {
    if (!file_exists($f)) {
        echo "$f not found\n";
        continue;
    }
    $c = file_get_contents($f);
    // The approve button:
    // <button class="btn btn-primary btn-sm btn-approve"
    $btn = '<a href="' . $url . '" class="btn btn-info btn-sm">Detail</a>' . "\n" . '                                    <button class="btn btn-primary btn-sm btn-approve"';
    $c = str_replace('<button class="btn btn-primary btn-sm btn-approve"', $btn, $c);
    file_put_contents($f, $c);
}
echo "Buttons added.\n";
