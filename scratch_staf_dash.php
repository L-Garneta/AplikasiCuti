<?php
$f = 'application/views/staf/index.php';
$c = file_get_contents($f);

// 1. Remove the 3 cards (History Cuti, Cuti Lain, Info Saya)
// They are between <!-- Earnings (Monthly) Card Example --> and <!-- Content Row -->
// I will use regex to remove them.
$c = preg_replace(
    '/<!-- Earnings \(Monthly\) Card Example -->\s*<div class="col-xl-3 col-md-6 mb-4">.*?<!-- Content Row -->/is',
    '<!-- Content Row -->',
    $c
);

// 2. Add alasan_ditolak to the Ditolak alert
// Look for: <h5 class="text-danger" style="font-weight:700;"> <strong>CUTI DITOLAK</strong> </h5>
$c = str_replace(
    '<h5 class="text-danger" style="font-weight:700;"> <strong>CUTI DITOLAK</strong> </h5>',
    '<h5 class="text-danger" style="font-weight:700;"> <strong>CUTI DITOLAK</strong> </h5>' . "\n" .
    '                                           <p class="text-dark mb-2"><strong>Alasan:</strong> <?php echo $sisa_cuti[\'alasan_ditolak\'] ?? \'-\'; ?></p>',
    $c
);

file_put_contents($f, $c);
echo "Cards removed and alasan_ditolak added.\n";
