(Get-Content application/views/kaur/cuti_staf.php) -replace 'Pending KAUR', 'Pending SDM' -replace 'Approval KAUR', 'Approval SDM' | Set-Content application/views/kaur/cuti_staf.php

(Get-Content application/views/sdm/approval/cuti_sdm.php) -replace 'Pending', 'Pending Pj. Klinik' -replace 'Approval SDM', 'Approval Penanggung Jawab Klinik' | Set-Content application/views/sdm/approval/cuti_sdm.php

(Get-Content application/controllers/Sdm.php) -replace "'Approval SDM'", "'Approval Penanggung Jawab Klinik'" -replace "Approval SDM berhasil", "Approval Penanggung Jawab Klinik berhasil" | Set-Content application/controllers/Sdm.php

(Get-Content application/controllers/Kaur.php) -replace "'Approval KAUR'", "'Approval SDM'" -replace "Approval KAUR berhasil", "Approval SDM berhasil" | Set-Content application/controllers/Kaur.php
