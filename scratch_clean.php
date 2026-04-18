<?php
$file = 'application/controllers/Kaur.php';
$content = file_get_contents($file);

// Find my injected function
$newFuncStr = "public function approvecuti_lain()\n\t{\n\t\t\$nama_atasan";
$startInjected = strpos($content, $newFuncStr);

if ($startInjected !== false) {
    // Find the end of my injected function
    $endInjected = strpos($content, "redirect('kaur/cutilain_staf');\n\t}", $startInjected);
    if ($endInjected !== false) {
        $endInjected += strlen("redirect('kaur/cutilain_staf');\n\t}");

        // Now find add_staf() which comes somewhere AFTER $endInjected
        $addStafPos = strpos($content, "public function add_staf()", $endInjected);
        
        if ($addStafPos !== false) {
            $cleaned = substr($content, 0, $endInjected) . "\n\n\t" . substr($content, $addStafPos);
            file_put_contents($file, $cleaned);
            echo "Cleaned file!\n";
        } else {
            echo "add_staf() not found!\n";
        }
    } else {
        echo "End of injected function not found!\n";
    }
} else {
    echo "Injected function not found!\n";
}
?>
