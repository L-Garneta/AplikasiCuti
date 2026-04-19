<?php
$conn = new mysqli("localhost", "root", "", "cuti_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Add jml_cuti to formcuti_lain after keterangan
$sql = "ALTER TABLE formcuti_lain ADD COLUMN jml_cuti INT(11) DEFAULT 0 AFTER keterangan";
if ($conn->query($sql) === TRUE) {
    echo "Column jml_cuti added successfully.";
} else {
    echo "Error adding column: " . $conn->error;
}
$conn->close();
