<?php
$conn = new mysqli('localhost', 'root', '', 'cuti_db');
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// 1. user_role
$conn->query("UPDATE user_role SET role = 'Penanggung Jawab Klinik' WHERE id = 2");
$conn->query("UPDATE user_role SET role = 'SDM' WHERE id = 3");

// 2. user_menu (Sidebar Utama)
$conn->query("UPDATE user_menu SET menu = 'Penanggung Jawab Klinik' WHERE id = 2");
$conn->query("UPDATE user_menu SET menu = 'SDM' WHERE id = 3");

// 3. user_sub_menu (Sidebar SubMenu)
$conn->query("UPDATE user_sub_menu SET title = 'Approval Pj. Klinik' WHERE menu_id = 2 AND title LIKE '%Approval%'");
$conn->query("UPDATE user_sub_menu SET title = 'Approval SDM' WHERE menu_id = 3 AND title LIKE '%Approval%'");

echo "Database labels updated!\n";
?>
