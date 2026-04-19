<?php
$conn = new mysqli('localhost', 'root', '', 'cuti_db');
$conn->query("INSERT IGNORE INTO user_access_menu (role_id, menu_id) VALUES (3, 2)");
echo "Akses menu SDM diberikan ke KAUR.\n";
?>
