<?php
$f = 'application/controllers/Sdm.php';
$c = file_get_contents($f);

// Fix dashboard stats for SDM
$c = preg_replace(
    '/\$data\[\'count_cuti_tahunan\'\] = \$this->db\s*->where\(\'is_approve\', 0\)\s*->count_all_results\(\'form_cuti\'\);/is',
    '$data[\'count_cuti_tahunan\'] = $this->db->where(\'approved_kaur\', 0)->where(\'approved_sdm\', 1)->count_all_results(\'form_cuti\');',
    $c
);

$c = preg_replace(
    '/\$data\[\'count_cuti_luartanggungan\'\] = \$this->db\s*->where\(\'is_approve\', 0\)\s*->count_all_results\(\'formcuti_lain\'\);/is',
    '$data[\'count_cuti_luartanggungan\'] = $this->db->where(\'approved_kaur\', 0)->where(\'approved_sdm\', 1)->count_all_results(\'formcuti_lain\');',
    $c
);

file_put_contents($f, $c);

// Also need to check Kaur.php index()
$f2 = 'application/controllers/Kaur.php';
if (file_exists($f2)) {
    $c2 = file_get_contents($f2);
    // Kaur only approves if approved_kaur = 1
    $c2 = preg_replace(
        '/\$data\[\'count_cuti_tahunan\'\] = \$this->db\s*->where\(\'is_approve\', 0\)\s*->count_all_results\(\'form_cuti\'\);/is',
        '$data[\'count_cuti_tahunan\'] = $this->db->where(\'approved_kaur\', 1)->count_all_results(\'form_cuti\');',
        $c2
    );

    $c2 = preg_replace(
        '/\$data\[\'count_cuti_luartanggungan\'\] = \$this->db\s*->where\(\'is_approve\', 0\)\s*->count_all_results\(\'formcuti_lain\'\);/is',
        '$data[\'count_cuti_luartanggungan\'] = $this->db->where(\'approved_kaur\', 1)->count_all_results(\'formcuti_lain\');',
        $c2
    );
    file_put_contents($f2, $c2);
}

echo "Dashboard stats matched to pending items.\n";
