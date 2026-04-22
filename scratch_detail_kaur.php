<?php
$f = 'application/views/kaur/cuti_staf.php';
$c = file_get_contents($f);
$c = preg_replace(
    '/<button class="btn btn-primary btn-sm btn-approve"/is',
    '<a href="<?= base_url(\'kaur/detail_cuti/\' . $sc[\'id\']); ?>" class="btn btn-info btn-sm">Detail</a>
                                        <button class="btn btn-primary btn-sm btn-approve"',
    $c
);
file_put_contents($f, $c);

$f2 = 'application/views/kaur/cutilain_staf.php';
$c2 = file_get_contents($f2);
$c2 = preg_replace(
    '/(<td>)(<button class="tombol-edit btn btn-info btn-block btn-sm".*?>.*?<\/button>)(<\/td>)/is',
    '$1<a href="<?= base_url(\'kaur/detail_cuti_diluartanggungan/\' . $sc[\'id\']); ?>" class="btn btn-info btn-sm">Detail</a> $2$3',
    $c2
);
file_put_contents($f2, $c2);

// Make sure detail_cuti_diluartanggungan exists in Kaur.php!
echo "Added detail button to kaur views.\n";
