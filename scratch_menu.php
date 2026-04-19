<?php
$conn = new mysqli("localhost", "root", "", "cuti_db");
$res = $conn->query("SELECT * FROM user_sub_menu");
while($row = $res->fetch_assoc()) {
    echo $row['menu_id'] . " | " . $row['title'] . " | " . $row['url'] . "\n";
}
