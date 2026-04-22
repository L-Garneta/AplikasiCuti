<?php
$file = 'c:\\xampp\\htdocs\\AplikasiCuti\\application\\views\\staf\\index.php';
$content = file_get_contents($file);

$start = strpos($content, '<div class="col-xl-3 col-md-6 mb-4">');
$end = strpos($content, '<!-- Content Row -->', $start);

if ($start !== false && $end !== false) {
    $new_content = substr($content, 0, $start) . substr($content, $end);
    file_put_contents($file, $new_content);
    echo "Successfully removed the card.";
} else {
    echo "Could not find start or end.";
}
?>
