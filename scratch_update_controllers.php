<?php
$f = 'application/controllers/Sdm.php';
$c = file_get_contents($f);

// 1. Grab $m and $y at the top of these methods
$methods = [
    'list_cuti_kary',
    'list_cuti_diluartanggungan',
    'cuti_sdm',
    'cutilain_sdm',
    'cuti_kaur',
    'cutilain_kaur'
];

foreach ($methods as $method) {
    $c = preg_replace(
        '/public function ' . $method . '\(\)\s*\{/is',
        "public function $method()\n    {\n        \$m = \$this->input->get('m');\n        \$y = \$this->input->get('y');\n        \$data['m'] = \$m;\n        \$data['y'] = \$y;\n",
        $c
    );
}

// 2. Replace empty model calls with ($m, $y) for the listed functions
$c = preg_replace('/->getListCuti\(\)/is', '->getListCuti($m, $y)', $c);
$c = preg_replace('/->getListCutiLuarTanggungan\(\)/is', '->getListCutiLuarTanggungan($m, $y)', $c);
$c = preg_replace('/->getCutiSdm\(\)/is', '->getCutiSdm($m, $y)', $c);
$c = preg_replace('/->getCutiKaur\(\)/is', '->getCutiKaur($m, $y)', $c);
$c = preg_replace('/->getCutiPending\(\)/is', '->getCutiPending($m, $y)', $c);
$c = preg_replace('/->getCutiLainPending\(\)/is', '->getCutiLainPending($m, $y)', $c);

file_put_contents($f, $c);


$f2 = 'application/controllers/Kaur.php';
$c2 = file_get_contents($f2);

$methods2 = [
    'list_cuti_kary',
    'list_cuti_diluartanggungan',
    'cuti_staf',
    'cutilain_staf'
];

foreach ($methods2 as $method) {
    if (strpos($c2, "public function $method()") !== false) {
        $c2 = preg_replace(
            '/public function ' . $method . '\(\)\s*\{/is',
            "public function $method()\n    {\n        \$m = \$this->input->get('m');\n        \$y = \$this->input->get('y');\n        \$data['m'] = \$m;\n        \$data['y'] = \$y;\n",
            $c2
        );
    }
}

$c2 = preg_replace('/->getListCutiStaf\(\)/is', '->getListCutiStaf($m, $y)', $c2);
$c2 = preg_replace('/->getListCutiLainStaf\(\)/is', '->getListCutiLainStaf($m, $y)', $c2);
$c2 = preg_replace('/->getCutiPending\(\)/is', '->getCutiPending($m, $y)', $c2);
$c2 = preg_replace('/->getCutiLainPending\(\)/is', '->getCutiLainPending($m, $y)', $c2);
$c2 = preg_replace('/->getCutiKaur\(\)/is', '->getCutiKaur($m, $y)', $c2);

file_put_contents($f2, $c2);

echo "Controllers updated.\n";
