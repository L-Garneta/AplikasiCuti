Copy-Item "application\views\sdm\detail_cuti.php" -Destination "application\views\kaur\detail_cuti.php" -ErrorAction SilentlyContinue
Copy-Item "application\views\sdm\detail_cuti_diluartanggungan.php" -Destination "application\views\kaur\detail_cuti_diluartanggungan.php" -ErrorAction SilentlyContinue

(Get-Content "application\views\kaur\detail_cuti.php") -replace 'sdm/', 'kaur/' | Set-Content "application\views\kaur\detail_cuti.php"
(Get-Content "application\views\kaur\detail_cuti_diluartanggungan.php") -replace 'sdm/', 'kaur/' | Set-Content "application\views\kaur\detail_cuti_diluartanggungan.php"

(Get-Content "application\views\sdm\detail_cuti.php") -replace 'Approval Kaur', 'Approval SDM' -replace 'Approval SDM\s*<', 'Approval Pj. Klinik<' | Set-Content "application\views\sdm\detail_cuti.php"
(Get-Content "application\views\kaur\detail_cuti.php") -replace 'Approval Kaur', 'Approval SDM' -replace 'Approval SDM\s*<', 'Approval Pj. Klinik<' | Set-Content "application\views\kaur\detail_cuti.php"
