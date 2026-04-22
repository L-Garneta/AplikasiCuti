<?php
$f = 'application/views/staf/history.php';
$c = file_get_contents($f);

// Remove var_dump and die
$c = preg_replace('/<\?php\s*var_dump\(\$uc\);\s*die;\s*\?>/is', '', $c);

// Fix headers
$c = str_replace(
    '<th scope="col">Status</th>',
    '<th scope="col">Status</th>
                             <th scope="col">Alasan Ditolak</th>',
    $c
);

// Fix table rows
$c = preg_replace(
    '/<td><span class="btn btn-light btn-sm btn-block font-weight-bolder">Diterima<\/span><\/td>\s*<\?php endif; \?>\s*<\/tr>\s*<td>\s*<a href="<\?= base_url\(\'staf\/cetak_data\/\' \. \$uc\[\'id_cuti\'\]\); \?>" class="btn btn-danger btn-sm"\s*target="_blank">\s*PDF\s*<\/a>\s*<\/td>\s*<\/tr>/is',
    '<td><span class="btn btn-light btn-sm font-weight-bolder btn-block">Diterima</span></td>
                                <?php endif; ?>
                                <td><?php echo isset($uc[\'alasan_ditolak\']) ? $uc[\'alasan_ditolak\'] : \'-\'; ?></td>
                                <td>
                                    <a href="<?= base_url(\'staf/cetak_data/\' . $uc[\'id_cuti\']); ?>" class="btn btn-danger btn-sm" target="_blank">PDF</a>
                                </td>
                            </tr>',
    $c
);
file_put_contents($f, $c);

$f2 = 'application/views/staf/history_cutilain.php';
if (file_exists($f2)) {
    $c2 = file_get_contents($f2);
    $c2 = str_replace(
        '<th scope="col">Status</th>',
        '<th scope="col">Status</th>
                                <th scope="col">Alasan Ditolak</th>',
        $c2
    );
    // Find where the row ends
    $c2 = preg_replace(
        '/<td><span class="btn btn-light btn-sm font-weight-bolder">Diterima<\/span><\/td>\s*<\?php endif; \?>\s*<\/tr>/is',
        '<td><span class="btn btn-light btn-sm font-weight-bolder">Diterima</span></td>
                                    <?php endif; ?>
                                    <td><?php echo isset($ucl[\'alasan_ditolak\']) ? $ucl[\'alasan_ditolak\'] : \'-\'; ?></td>
                                </tr>',
        $c2
    );
    file_put_contents($f2, $c2);
}

echo "History views updated.";
