<?php
$conn = new mysqli('localhost', 'root', '', 'cuti_db');
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$conn->query("UPDATE user_menu SET menu = 'sdm' WHERE id = 2");
$conn->query("UPDATE user_menu SET menu = 'kaur' WHERE id = 3");

echo "DB reverted menu column!\n";
?>
