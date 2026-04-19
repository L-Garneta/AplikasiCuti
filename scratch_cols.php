<?php
$conn = new mysqli("localhost", "root", "", "cuti_db");
$res = $conn->query("SHOW COLUMNS FROM form_cuti");
while($row = $res->fetch_assoc()) {
    echo $row['Field'] . "\n";
}
