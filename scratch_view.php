<?php
$file = 'application/views/sdm/approval/cuti_sdm.php';
$content = file_get_contents($file);
$content = str_replace('<h5 class="card-header">
            <strong><?= $title; ?></strong>
        </h5>', '<h5 class="card-header">
            <strong><?= $title; ?></strong>
            <a href="<?php echo base_url(\'sdm/cutilain_sdm\'); ?>" class="btn btn-primary btn-sm float-right">Approval Cuti (Menikah, Melahirkan, dll)</a>
        </h5>', $content);
file_put_contents($file, $content);

// Rename SDM / KAUR Views title button to match user text exactly:
$file2 = 'application/views/kaur/cuti_staf.php';
$c2 = file_get_contents($file2);
$c2 = str_replace('<a href="<?php echo base_url(\'kaur/cutilain_staf\'); ?>" class="btn btn-primary btn-sm float-right">Approval Cuti Lain</a>', '<a href="<?php echo base_url(\'kaur/cutilain_staf\'); ?>" class="btn btn-primary btn-sm float-right">Approval Cuti (Menikah, Melahirkan, dll)</a>', $c2);
file_put_contents($file2, $c2);

$conn = new mysqli('localhost', 'root', '', 'cuti_db');
$conn->query("UPDATE user_sub_menu SET title = 'List Cuti Bulanan' WHERE title LIKE 'List Cuti'");
$conn->query("UPDATE user_sub_menu SET title = 'List Cuti Lain (Menikah dsb)' WHERE title LIKE 'List Cuti Lain'");
echo "Updated title texts and added button.\n";
?>
