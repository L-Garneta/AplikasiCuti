<?php
$conn = new mysqli('localhost', 'root', '', 'cuti_db');
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$conn->query("DELETE FROM user_sub_menu WHERE menu_id = 3 AND title IN ('Input Cuti', 'List Staf', 'History')");
$conn->query("UPDATE user_sub_menu SET title = 'Beranda' WHERE menu_id = 3 AND title = 'Dashboard'");

echo "Menu lama dihapus dan Dashboard di-rename menjadi Beranda.\n";
?>
