<?php
$conn = new mysqli("localhost", "root", "", "cuti_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$hash = password_hash("admin123", PASSWORD_DEFAULT);
$conn->query("UPDATE mst_user SET password='$hash' WHERE role_id=2");
echo "Password for PJ Klinik (role_id=2) has been reset to admin123.\n";

$res = $conn->query("SELECT username FROM mst_user WHERE role_id=2");
while($row = $res->fetch_assoc()) {
    echo "Username: " . $row['username'] . "\n";
}
$conn->close();
