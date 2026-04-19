<?php
$conn = new mysqli("localhost", "root", "", "cuti_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Truncate tables to delete dummy data
$conn->query("TRUNCATE TABLE form_cuti");
$conn->query("TRUNCATE TABLE formcuti_lain");

echo "Dummy data deleted from form_cuti and formcuti_lain.";
$conn->close();
