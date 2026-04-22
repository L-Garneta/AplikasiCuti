<?php

$f = 'application/controllers/Staf.php';
$c = file_get_contents($f);

// 1. Remove validation for sisa_cuti
$c = preg_replace(
    '/\$this->form_validation->set_rules\(\'sisa_cuti\', \'Sisa Cuti\', \'required\|trim\|greater_than\[-[0-9]+\]\'\);\s*/is',
    '',
    $c
);

// 2. Fix the insertion data to calculate sisa_cuti correctly
$c = preg_replace(
    '/\'sisa_cuti\' => \$this->input->post\(\'sisa_cuti\'\),/is',
    '\'sisa_cuti\' => ($this->user_cuti->getSisaCuti() ? $this->user_cuti->getSisaCuti()[\'sisa_cuti\'] : 12) - $this->input->post(\'jml_cuti\'),',
    $c
);

file_put_contents($f, $c);
echo "Sisa_cuti validation removed and auto-calculation added.\n";
