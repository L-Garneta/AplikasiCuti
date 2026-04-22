<?php
$file = 'c:\\xampp\\htdocs\\AplikasiCuti\\application\\views\\sdm\\list_kary.php';
$content = file_get_contents($file);

$content = str_replace(
    '<h5 class="card-header"> <strong><?= $title; ?></strong> <button class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#hitung-gaji"><i class="fas fa-calculator"></i> Hitung Gaji</button></h5>',
    '<h5 class="card-header"> <strong><?= $title; ?></strong></h5>',
    $content
);

$content = str_replace(
    '<div class="col-md-12">',
    '<button class="btn btn-success mb-3" data-toggle="modal" data-target="#hitung-gaji"><i class="fas fa-calculator"></i> Hitung Gaji Karyawan</button>' . "\n            " . '<div class="col-md-12">',
    $content
);

file_put_contents($file, $content);
echo "Moved button.";
?>
