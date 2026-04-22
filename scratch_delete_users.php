<?php
$conn = new mysqli("localhost", "root", "", "cuti_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$allowed = ['ivon', 'Azzahra:2004', 'admin', 'PJklinik', 'SDM', 'staf'];

// Build string for IN clause
$escaped = array_map(function($u) use ($conn) { return "'" . $conn->real_escape_string($u) . "'"; }, $allowed);
$list = implode(',', $escaped);

// Delete from data_pegawai where pegawai_id not in the allowed list
// Wait, data_pegawai maps to mst_user id. We delete where id not in (SELECT id FROM mst_user WHERE username IN (...))
$ids_query = $conn->query("SELECT id FROM mst_user WHERE username IN ($list)");
$keep_ids = [];
while($r = $ids_query->fetch_assoc()){
    $keep_ids[] = $r['id'];
}
$keep_ids_str = implode(',', $keep_ids);

if(!empty($keep_ids_str)) {
    $conn->query("DELETE FROM data_pegawai WHERE pegawai_id NOT IN ($keep_ids_str)");
    $conn->query("DELETE FROM mst_user WHERE id NOT IN ($keep_ids_str)");
}

echo "Deleted dummy users.";
$conn->close();
