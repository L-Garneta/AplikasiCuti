<?php
$f = 'application/views/kaur/index.php';
$c = file_get_contents($f);
$c = str_replace(
"form_open_multipart('kaur/edit_profile');",
"form_open_multipart('kaur/edit');",
$c);
file_put_contents($f, $c);
