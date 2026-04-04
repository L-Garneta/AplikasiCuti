<h2>Perhitungan Gaji</h2>

<p>Nama: <?= $gaji['nama']; ?></p>
<p>Gaji Pokok: Rp <?= number_format($gaji['gaji_pokok']); ?></p>
<p>Izin: <?= $gaji['izin']; ?> hari</p>
<p>Potongan: Rp <?= number_format($gaji['potongan']); ?></p>

<hr>

<h3>Gaji Bersih: Rp <?= number_format($gaji['gaji_bersih']); ?></h3>