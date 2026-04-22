<?php
$conn = new mysqli("localhost", "root", "", "cuti_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$r = $conn->query("SELECT id,nama,username,role_id FROM mst_user");
while($row = $r->fetch_assoc()) {
    echo json_encode($row) . "\n";
}
