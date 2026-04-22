<?php

// 1. Remove Edit Button for Staf
$f1 = 'c:\\xampp\\htdocs\\AplikasiCuti\\application\\views\\staf\\index.php';
$c1 = file_get_contents($f1);
$c1 = preg_replace('/<strong><a href="<\?php echo base_url\(\); \?'.'>staf\/edit_cuti.*?<\/strong>/s', '', $c1);
file_put_contents($f1, $c1);

$f2 = 'c:\\xampp\\htdocs\\AplikasiCuti\\application\\views\\staf\\history_cutilain.php';
$c2 = file_get_contents($f2);
$c2 = preg_replace('/<td><a href="<\?php echo base_url\(\'staf\/edit_cutilain\/\'\); \?'.'>.*?<\/a><\/td>/s', '', $c2);
file_put_contents($f2, $c2);

// 2. Wrap table in table-responsive in kaur/list_cuti_kary.php
$f3 = 'c:\\xampp\\htdocs\\AplikasiCuti\\application\\views\\kaur\\list_cuti_kary.php';
$c3 = file_get_contents($f3);
if (strpos($c3, '<div class="table-responsive">') === false) {
    $c3 = str_replace('<table class="table table-hover" id="table-id">', '<div class="table-responsive"><table class="table table-hover" id="table-id">', $c3);
    $c3 = str_replace('</table>', '</table></div>', $c3);
    file_put_contents($f3, $c3);
}

// 3. Text wrap for detail_cuti_diluartanggungan.php
$f4 = 'c:\\xampp\\htdocs\\AplikasiCuti\\application\\views\\kaur\\detail_cuti_diluartanggungan.php';
if (file_exists($f4)) {
    $c4 = file_get_contents($f4);
    $c4 = preg_replace('/<td>(<\?php echo \$cuti_pegawai\[0\]\[\'keterangan\'\].*?)<\/td>/is', '<td style="white-space: normal; word-wrap: break-word; min-width: 200px;">$1</td>', $c4);
    file_put_contents($f4, $c4);
}

// 4. Batasan 20 kata saat pengisian alasan cuti
$views_to_limit = [
    'c:\\xampp\\htdocs\\AplikasiCuti\\application\\views\\kaur\\add_cuti.php',
    'c:\\xampp\\htdocs\\AplikasiCuti\\application\\views\\staf\\add_cuti.php'
];

foreach ($views_to_limit as $fv) {
    if (file_exists($fv)) {
        $cv = file_get_contents($fv);
        if (strpos($cv, 'name="keterangan"') !== false && strpos($cv, 'maxlength="150"') === false) {
            $cv = str_replace('name="keterangan"', 'name="keterangan" id="inputKeterangan" maxlength="150" oninput="limitWords(this, 20)"', $cv);
        }
        $js = "\n<script>\nfunction limitWords(field, maxWords) {\n    var text = field.value;\n    var words = text.split(/\\s+/);\n    if (words.length > maxWords) {\n        field.value = words.slice(0, maxWords).join(' ');\n        alert('Keterangan maksimal ' + maxWords + ' kata.');\n    }\n}\n</script>\n";
        if (strpos($cv, 'limitWords') === false) {
            $cv .= $js;
        }
        file_put_contents($fv, $cv);
    }
}

// 5. Order list cuti by newest first in Kaur.php
$f5 = 'c:\\xampp\\htdocs\\AplikasiCuti\\application\\controllers\\Kaur.php';
$c5 = file_get_contents($f5);
$c5 = str_replace("\$data['cuti_kary'] = \$this->db->get('form_cuti')->result_array();", "\$this->db->order_by('id', 'DESC');\n        \$data['cuti_kary'] = \$this->db->get('form_cuti')->result_array();", $c5);
$c5 = str_replace("\$data['cuti_kary'] = \$this->db->get('formcuti_lain')->result_array();", "\$this->db->order_by('id', 'DESC');\n        \$data['cuti_kary'] = \$this->db->get('formcuti_lain')->result_array();", $c5);

// 6. Cetak Rekap FPDF column widths (make keterangan wider)
// Old: 10, 30, 50, 35, 25, 25, 25, 15, 25, 37  (Total 277)
// We will change width to fit 20 words better. Let's make Keterangan 52.
// New: 10, 25, 45, 25, 20, 20, 20, 15, 20, 52 (Wait, sum = 10+25+45+25+20+20+20+15+20+52 = 252. Wait, total width is 277. Let's use 277)
// New: No 10 | NIK 20 | Nama 45 | Bagian 20 | Tgl Inp 22 | Tgl Cuti 22 | Sampai 22 | Tot 15 | Tgl Msk 22 | Ket 79
// 10+20+45+20+22+22+22+15+22+79 = 277.

$c5 = str_replace(
    "\$pdf->Cell(10, 7, 'No', 1, 0, 'C');\n        \$pdf->Cell(30, 7, 'NIK', 1, 0, 'C');\n        \$pdf->Cell(50, 7, 'Nama', 1, 0, 'C');\n        \$pdf->Cell(35, 7, 'Bagian', 1, 0, 'C');\n        \$pdf->Cell(25, 7, 'Tgl Input', 1, 0, 'C');\n        \$pdf->Cell(25, 7, 'Tgl Cuti', 1, 0, 'C');\n        \$pdf->Cell(25, 7, 'Sampai', 1, 0, 'C');\n        \$pdf->Cell(15, 7, 'Total', 1, 0, 'C');\n        \$pdf->Cell(25, 7, 'Tgl Masuk', 1, 0, 'C');\n        \$pdf->Cell(37, 7, 'Keterangan', 1, 1, 'C');",
    "\$pdf->Cell(10, 7, 'No', 1, 0, 'C');\n        \$pdf->Cell(20, 7, 'NIK', 1, 0, 'C');\n        \$pdf->Cell(45, 7, 'Nama', 1, 0, 'C');\n        \$pdf->Cell(20, 7, 'Bagian', 1, 0, 'C');\n        \$pdf->Cell(22, 7, 'Tgl Input', 1, 0, 'C');\n        \$pdf->Cell(22, 7, 'Tgl Cuti', 1, 0, 'C');\n        \$pdf->Cell(22, 7, 'Sampai', 1, 0, 'C');\n        \$pdf->Cell(15, 7, 'Total', 1, 0, 'C');\n        \$pdf->Cell(22, 7, 'Tgl Masuk', 1, 0, 'C');\n        \$pdf->Cell(79, 7, 'Keterangan', 1, 1, 'C');",
    $c5
);

$c5 = str_replace(
    "\$pdf->Cell(10, 6, \$no++, 1, 0, 'C');\n            \$pdf->Cell(30, 6, \$c['nik'], 1, 0, 'C');\n            \$pdf->Cell(50, 6, substr(\$c['nama'], 0, 25), 1, 0, 'L');\n            \$pdf->Cell(35, 6, substr(\$c['bagian'], 0, 20), 1, 0, 'C');\n            \$pdf->Cell(25, 6, format_indo(\$c[\$tgl_field] ?? date('Y-m-d')), 1, 0, 'C');\n            \$pdf->Cell(25, 6, format_indo(\$c['cuti']), 1, 0, 'C');\n            \$pdf->Cell(25, 6, format_indo(\$c['cuti2']), 1, 0, 'C');\n            \$pdf->Cell(15, 6, \$c['jml_cuti'] . ' Hr', 1, 0, 'C');\n            \$pdf->Cell(25, 6, format_indo(\$c['masuk']), 1, 0, 'C');\n            \$pdf->Cell(37, 6, substr(\$c['keterangan'], 0, 20), 1, 1, 'L');",
    "\$pdf->Cell(10, 6, \$no++, 1, 0, 'C');\n            \$pdf->Cell(20, 6, \$c['nik'], 1, 0, 'C');\n            \$pdf->Cell(45, 6, substr(\$c['nama'], 0, 25), 1, 0, 'L');\n            \$pdf->Cell(20, 6, substr(\$c['bagian'], 0, 15), 1, 0, 'C');\n            \$pdf->Cell(22, 6, format_indo(\$c[\$tgl_field] ?? date('Y-m-d')), 1, 0, 'C');\n            \$pdf->Cell(22, 6, format_indo(\$c['cuti']), 1, 0, 'C');\n            \$pdf->Cell(22, 6, format_indo(\$c['cuti2']), 1, 0, 'C');\n            \$pdf->Cell(15, 6, \$c['jml_cuti'] . ' Hr', 1, 0, 'C');\n            \$pdf->Cell(22, 6, format_indo(\$c['masuk']), 1, 0, 'C');\n            \$pdf->Cell(79, 6, substr(\$c['keterangan'], 0, 45), 1, 1, 'L');",
    $c5
);

// Add Alpha logic to Kaur.php hitung_gaji_ajax
$c5 = str_replace(
    "\$gaji_pokok = \$this->input->post('gaji_pokok');",
    "\$gaji_pokok = \$this->input->post('gaji_pokok');\n        \$hari_bolos = (int) \$this->input->post('hari_bolos');",
    $c5
);
$c5 = str_replace(
    "\$potongan = round((\$gaji_pokok / 30) * \$total_hari);",
    "\$total_hari += \$hari_bolos;\n        \$potongan = round((\$gaji_pokok / 30) * \$total_hari);",
    $c5
);

file_put_contents($f5, $c5);

// 7. Add UI for Alpha and Guide pop-up to views/kaur/list_kary.php
$f6 = 'c:\\xampp\\htdocs\\AplikasiCuti\\application\\views\\kaur\\list_kary.php';
$c6 = file_get_contents($f6);
$c6 = str_replace(
    '<button class="btn btn-success mb-3" data-toggle="modal" data-target="#hitung-gaji"><i class="fas fa-calculator"></i> Hitung Gaji Karyawan</button>',
    '<button class="btn btn-success mb-3" data-toggle="modal" data-target="#hitung-gaji"><i class="fas fa-calculator"></i> Hitung Gaji Karyawan</button>
<button class="btn btn-info mb-3 ml-2" data-toggle="modal" data-target="#guide-kalkulator"><i class="fas fa-info-circle"></i> Guide Kalkulator</button>',
    $c6
);

$c6 = str_replace(
    '<div class="form-group">
                        <label>Gaji Pokok (Rp)</label>
                        <input type="number" class="form-control" name="gaji_pokok" placeholder="Contoh: 3000000" required>
                    </div>',
    '<div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gaji Pokok (Rp)</label>
                                <input type="number" class="form-control" name="gaji_pokok" placeholder="Contoh: 3000000" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Hari Alpha/Mangkir</label>
                                <input type="number" class="form-control" name="hari_bolos" placeholder="Contoh: 2" value="0" required>
                            </div>
                        </div>
                    </div>',
    $c6
);

// Add the Guide Modal
$guideModal = <<<HTML

<!-- Modal Guide Kalkulator -->
<div class="modal fade" id="guide-kalkulator" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-info-circle"></i> Cara Kerja Kalkulator Gaji</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda tinggal memilih nama Karyawan, Bulan, Tahun, dan memasukkan Gaji Pokok (serta mengisi Hari Alpha jika membolos dan tidak melakukan input izin cuti).</p>
                <p>Sistem akan secara otomatis menghitung berapa jumlah hari "Cuti Diluar Tanggungan" (otomatis mengabaikan Cuti Melahirkan, Menikah, Sakit, dan Jatah cuti bulanan(satu hari)).</p>
                <p>Kemudian sistem menampilkan total potongan hari, nilai potongan (Gaji Pokok / 30 x Total Hari), dan Gaji Bersih.</p>
                <ul>
                    <li><strong>Untuk Cuti Bulanan:</strong> Sistem akan memberikan "jatah" gratis 1 hari dalam sebulan. Jika karyawan mengambil cuti bulanan lebih dari 1 hari di bulan tersebut, maka hanya kelebihannya saja yang akan dihitung sebagai hari terpotong. (Contoh: Total ambil cuti bulanan 3 hari -> yang terpotong hanya 2 hari).</li>
                    <li><strong>Untuk Cuti Lain di luar tanggungan:</strong> Akan langsung dihitung sebagai potongan hari (dengan mengabaikan jenis Cuti Melahirkan, Menikah, dan Sakit).</li>
                    <li><strong>Alpha/Bolos:</strong> Akan langsung ditambahkan ke jumlah potongan hari.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
HTML;

if (strpos($c6, 'id="guide-kalkulator"') === false) {
    $c6 = preg_replace('/<\/script>\s*$/', "</script>\n" . $guideModal, $c6);
}

file_put_contents($f6, $c6);

echo "UI modifications applied.";
?>
