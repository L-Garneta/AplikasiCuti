<?php
$files = [
    'application/models/Sdm_model.php',
    'application/models/Kaur_model.php'
];

foreach ($files as $f) {
    if (!file_exists($f)) continue;
    $c = file_get_contents($f);

    // Array of functions to modify
    $funcs = [
        'getListCuti' => 'input',
        'getCutiKaur' => 'input',
        'getCutiSdm' => 'input',
        'getCutiPending' => 'input',
        'getCutiApproved' => 'input',
        'getCutiDitolak' => 'input',
        'getListCutiLuarTanggungan' => 'tgl_input',
        'getCutiLainPending' => 'tgl_input',
        
        // specific to Kaur
        'getListCutiStaf' => 'input',
        'getListCutiLainStaf' => 'tgl_input'
    ];

    foreach ($funcs as $func => $date_col) {
        $c = preg_replace(
            '/public function ' . $func . '\(\)\s*\{/is',
            "public function $func(\$m = null, \$y = null)\n    {\n        if (!empty(\$m) && !empty(\$y)) {\n            \$this->db->where('MONTH($date_col)', \$m);\n            \$this->db->where('YEAR($date_col)', \$y);\n        }",
            $c
        );
    }
    file_put_contents($f, $c);
}

echo "Model arguments and where clauses updated.\n";
