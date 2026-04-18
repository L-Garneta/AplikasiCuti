<?php
$conn = new mysqli('localhost', 'root', '', 'cuti_db');
$res = $conn->query('SHOW COLUMNS FROM formcuti_lain');
while($r = $res->fetch_assoc()){ echo $r['Field'].' '; }
?>
