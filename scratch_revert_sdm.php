<?php
// 1. REVERT SDM CHANGES

// Revert list_cuti_kary.php (SDM)
$f = 'c:\\xampp\\htdocs\\AplikasiCuti\\application\\views\\sdm\\list_cuti_kary.php';
$c = file_get_contents($f);
$c = str_replace('<a href="<?= base_url(\'sdm/cetak_rekap/bulanan?m=\' . $this->input->get(\'m\') . \'&y=\' . $this->input->get(\'y\')) ?>" target="_blank" class="btn btn-success btn-sm ml-1"><i class="fas fa-print"></i> Cetak Rekap</a>', '', $c);
file_put_contents($f, $c);

// Revert list_cuti_diluartanggungan_kary.php (SDM)
$f = 'c:\\xampp\\htdocs\\AplikasiCuti\\application\\views\\sdm\\list_cuti_diluartanggungan_kary.php';
$c = file_get_contents($f);
$c = str_replace('<a href="<?= base_url(\'sdm/cetak_rekap/lain?m=\' . $this->input->get(\'m\') . \'&y=\' . $this->input->get(\'y\')) ?>" target="_blank" class="btn btn-success btn-sm ml-1"><i class="fas fa-print"></i> Cetak Rekap</a>', '', $c);
file_put_contents($f, $c);

// Revert list_kary.php (SDM)
$f = 'c:\\xampp\\htdocs\\AplikasiCuti\\application\\views\\sdm\\list_kary.php';
$c = file_get_contents($f);
$c = str_replace('<button class="btn btn-success mb-3" data-toggle="modal" data-target="#hitung-gaji"><i class="fas fa-calculator"></i> Hitung Gaji Karyawan</button>' . "\n            ", '', $c);
$c = preg_replace('/<!-- Modal Hitung Gaji -->.*<\/script>/s', '', $c);
file_put_contents($f, $c);

// Revert Sdm.php
$f = 'c:\\xampp\\htdocs\\AplikasiCuti\\application\\controllers\\Sdm.php';
$c = file_get_contents($f);
$c = preg_replace('/public function cetak_rekap.*?public function hitung_gaji_ajax.*?\n    }/s', '', $c);
// clean trailing spaces if any
$c = rtrim($c) . "\n}\n";
file_put_contents($f, $c);


// 2. APPLY TO KAUR (SDM Role)

// Apply list_cuti_kary.php (KAUR)
$f = 'c:\\xampp\\htdocs\\AplikasiCuti\\application\\views\\kaur\\list_cuti_kary.php';
if(file_exists($f)){
    $c = file_get_contents($f);
    $c = str_replace(
        '<a href="<?= current_url() ?>" class="btn btn-secondary btn-sm ml-1"><i class="fas fa-sync"></i> Reset</a>',
        '<a href="<?= current_url() ?>" class="btn btn-secondary btn-sm ml-1"><i class="fas fa-sync"></i> Reset</a>' . "\n                " . '<a href="<?= base_url(\'kaur/cetak_rekap/bulanan?m=\' . $this->input->get(\'m\') . \'&y=\' . $this->input->get(\'y\')) ?>" target="_blank" class="btn btn-success btn-sm ml-1"><i class="fas fa-print"></i> Cetak Rekap</a>',
        $c
    );
    file_put_contents($f, $c);
}

// Apply list_cuti_diluartanggungan_kary.php (KAUR)
$f = 'c:\\xampp\\htdocs\\AplikasiCuti\\application\\views\\kaur\\list_cuti_diluartanggungan_kary.php';
if(file_exists($f)){
    $c = file_get_contents($f);
    $c = str_replace(
        '<a href="<?= current_url() ?>" class="btn btn-secondary btn-sm ml-1"><i class="fas fa-sync"></i> Reset</a>',
        '<a href="<?= current_url() ?>" class="btn btn-secondary btn-sm ml-1"><i class="fas fa-sync"></i> Reset</a>' . "\n                " . '<a href="<?= base_url(\'kaur/cetak_rekap/lain?m=\' . $this->input->get(\'m\') . \'&y=\' . $this->input->get(\'y\')) ?>" target="_blank" class="btn btn-success btn-sm ml-1"><i class="fas fa-print"></i> Cetak Rekap</a>',
        $c
    );
    file_put_contents($f, $c);
}

// Apply list_kary.php (KAUR)
$f = 'c:\\xampp\\htdocs\\AplikasiCuti\\application\\views\\kaur\\list_kary.php';
if(file_exists($f)){
    $c = file_get_contents($f);
    $c = str_replace(
        '<div class="col-md-12">',
        '<button class="btn btn-success mb-3" data-toggle="modal" data-target="#hitung-gaji"><i class="fas fa-calculator"></i> Hitung Gaji Karyawan</button>' . "\n            " . '<div class="col-md-12">',
        $c
    );
    
    $append = <<<'EOD'

<!-- Modal Hitung Gaji -->
<div class="modal fade" id="hitung-gaji" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-calculator"></i> Kalkulator Gaji Bersih</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formHitungGaji">
                    <div class="form-group">
                        <label>Pilih Pegawai</label>
                        <select name="id_pegawai" class="form-control" required>
                            <option value="">- Pilih -</option>
                            <?php foreach ($pegawai as $p) : ?>
                                <option value="<?= $p['id'] ?>"><?= $p['nama'] ?> (<?= $p['nik'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bulan</label>
                                <select name="bulan" class="form-control" required>
                                    <option value="">- Bulan -</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tahun</label>
                                <select name="tahun" class="form-control" required>
                                    <option value="">- Tahun -</option>
                                    <?php 
                                        $yr = date('Y');
                                        for($i=0; $i<5; $i++): 
                                    ?>
                                        <option value="<?= $yr-$i ?>"><?= $yr-$i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Gaji Pokok (Rp)</label>
                        <input type="number" class="form-control" name="gaji_pokok" placeholder="Contoh: 3000000" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block" id="btnHitung">Hitung</button>
                </form>

                <div id="hasilHitung" class="mt-4" style="display:none;">
                    <h6 class="font-weight-bold text-center border-bottom pb-2">Hasil Perhitungan</h6>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td>Total Cuti (Potong Gaji)</td>
                            <td>:</td>
                            <td class="font-weight-bold"><span id="res_total_cuti"></span> Hari</td>
                        </tr>
                        <tr>
                            <td>Gaji Pokok</td>
                            <td>:</td>
                            <td class="font-weight-bold">Rp <span id="res_gaji_pokok"></span></td>
                        </tr>
                        <tr>
                            <td>Total Potongan</td>
                            <td>:</td>
                            <td class="font-weight-bold text-danger">- Rp <span id="res_potongan"></span></td>
                        </tr>
                        <tr class="border-top">
                            <td class="font-weight-bold">Gaji Bersih</td>
                            <td class="font-weight-bold">:</td>
                            <td class="font-weight-bold text-success h5">Rp <span id="res_gaji_bersih"></span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#formHitungGaji').on('submit', function(e) {
    e.preventDefault();
    $('#btnHitung').html('<i class="fas fa-spinner fa-spin"></i> Menghitung...').prop('disabled', true);
    
    $.ajax({
        url: '<?= base_url('kaur/hitung_gaji_ajax') ?>',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(res) {
            if(res.status == 'success') {
                $('#res_total_cuti').text(res.total_cuti);
                $('#res_gaji_pokok').text(res.gaji_pokok);
                $('#res_potongan').text(res.potongan);
                $('#res_gaji_bersih').text(res.gaji_bersih);
                $('#hasilHitung').slideDown();
            } else {
                alert(res.message);
            }
            $('#btnHitung').html('Hitung').prop('disabled', false);
        },
        error: function() {
            alert('Terjadi kesalahan sistem.');
            $('#btnHitung').html('Hitung').prop('disabled', false);
        }
    });
});
</script>
EOD;
    file_put_contents($f, $c . $append);
}

// Apply to Kaur.php
$f = 'c:\\xampp\\htdocs\\AplikasiCuti\\application\\controllers\\Kaur.php';
$c = file_get_contents($f);

$append = <<<'EOD'

    public function cetak_rekap($jenis = 'bulanan')
    {
        $m = $this->input->get('m');
        $y = $this->input->get('y');

        if ($jenis == 'bulanan') {
            $this->db->where('is_approve', 0);
            if ($m) $this->db->where('MONTH(input)', $m);
            if ($y) $this->db->where('YEAR(input)', $y);
            $cuti = $this->db->get('form_cuti')->result_array();
            $tgl_field = 'input';
        } else {
            $this->db->where('is_approve', 0);
            if ($m) $this->db->where('MONTH(tgl_input)', $m);
            if ($y) $this->db->where('YEAR(tgl_input)', $y);
            $cuti = $this->db->get('formcuti_lain')->result_array();
            $tgl_field = 'tgl_input';
        }

        $this->load->library('Pdf');
        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->Image(FCPATH . 'assets/img/logo.png', 10, 10, 20);

        // ================= HEADER =================
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(277, 6, 'KLINIK PRATAMA RAWAT INAP', 0, 1, 'C');
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(277, 6, '"DARUSSYIFA"', 0, 1, 'C');

        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(277, 5, 'Jl. Joyoboyo Timur, Ds. Sumbercangkring Kec. Gurah Kab. Kediri', 0, 1, 'C');
        $pdf->Cell(277, 5, 'Telp. 082336799868  email : klinikdarusyifa@gontor.ac.id', 0, 1, 'C');

        $pdf->Ln(5);
        $pdf->Cell(277, 0, '', 1, 1);
        $pdf->Ln(5);

        // ================= JUDUL =================
        $pdf->SetFont('Times', 'B', 14);
        $nama_bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $periode = ($m && $y) ? $nama_bulan[(int)$m] . ' ' . $y : 'Semua Periode';
        $pdf->Cell(277, 7, 'REKAP CUTI PERIODE ' . strtoupper($periode), 0, 1, 'C');
        $pdf->Ln(8);

        // ================= TABEL =================
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(10, 7, 'No', 1, 0, 'C');
        $pdf->Cell(30, 7, 'NIK', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Nama', 1, 0, 'C');
        $pdf->Cell(35, 7, 'Bagian', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Tgl Input', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Tgl Cuti', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Sampai', 1, 0, 'C');
        $pdf->Cell(15, 7, 'Total', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Tgl Masuk', 1, 0, 'C');
        $pdf->Cell(37, 7, 'Keterangan', 1, 1, 'C');

        $pdf->SetFont('Times', '', 10);
        $no = 1;
        foreach ($cuti as $c) {
            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(30, 6, $c['nik'], 1, 0, 'C');
            $pdf->Cell(50, 6, substr($c['nama'], 0, 25), 1, 0, 'L');
            $pdf->Cell(35, 6, substr($c['bagian'], 0, 20), 1, 0, 'C');
            $pdf->Cell(25, 6, format_indo($c[$tgl_field] ?? date('Y-m-d')), 1, 0, 'C');
            $pdf->Cell(25, 6, format_indo($c['cuti']), 1, 0, 'C');
            $pdf->Cell(25, 6, format_indo($c['cuti2']), 1, 0, 'C');
            $pdf->Cell(15, 6, $c['jml_cuti'] . ' Hr', 1, 0, 'C');
            $pdf->Cell(25, 6, format_indo($c['masuk']), 1, 0, 'C');
            $pdf->Cell(37, 6, substr($c['keterangan'], 0, 20), 1, 1, 'L');
        }

        $pdf->Ln(15);

        // ================= TANDA TANGAN =================
        $pdf->Cell(277, 7, 'Kediri, ' . format_indo(date('Y-m-d')), 0, 1, 'R');
        $pdf->Ln(2);

        $pdf->Cell(138, 5, 'Mengetahui,', 0, 0, 'C');
        $pdf->Cell(138, 5, 'Mengetahui,', 0, 1, 'C');
        
        $pdf->Cell(138, 5, 'Bagian SDM', 0, 0, 'C');
        $pdf->Cell(138, 5, 'Penanggung Jawab Klinik', 0, 1, 'C');

        $pdf->Ln(20);

        $pdf->Cell(138, 5, 'Elliningtiyas,SE', 0, 0, 'C');
        $pdf->Cell(138, 5, 'dr. Agung Wibowo, SE', 0, 1, 'C');

        $pdf->Cell(138, 5, 'NIK : 2023.11.015', 0, 0, 'C');
        $pdf->Cell(138, 5, 'NIK : 2023.11.001', 0, 1, 'C');

        $pdf->Ln(15);

        // ================= FOOTER =================
        $pdf->SetY(-15);
        $pdf->SetFont('Times', 'I', 10);
        $pdf->Cell(277, 5, 'Tulus Mengabdi, Iklas Melayani', 0, 1, 'R');

        $pdf->Output('I', "Rekap_Cuti_{$m}_{$y}.pdf");
    }

    public function hitung_gaji_ajax()
    {
        $id_pegawai = $this->input->post('id_pegawai');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $gaji_pokok = $this->input->post('gaji_pokok');

        $pegawai = $this->db->get_where('mst_user', ['id' => $id_pegawai])->row_array();
        if (!$pegawai) {
            echo json_encode(['status' => 'error', 'message' => 'Pegawai tidak ditemukan']);
            return;
        }

        $total_hari = 0;
        
        $this->db->where('id_user', $id_pegawai);
        $this->db->where('is_approve', 0);
        $this->db->where('MONTH(cuti)', $bulan);
        $this->db->where('YEAR(cuti)', $tahun);
        $this->db->where_not_in('jenis_cuti', ['Melahirkan', 'Menikah', 'Sakit', 'Tahunan']);
        $cuti_reguler = $this->db->get('form_cuti')->result_array();
        foreach ($cuti_reguler as $cr) {
            $total_hari += $cr['jml_cuti'];
        }

        $this->db->where('id_user', $id_pegawai);
        $this->db->where('is_approve', 0);
        $this->db->where('MONTH(cuti)', $bulan);
        $this->db->where('YEAR(cuti)', $tahun);
        $this->db->where_not_in('jenis_cuti', ['Melahirkan', 'Menikah', 'Sakit', 'Tahunan']);
        $cuti_lain = $this->db->get('formcuti_lain')->result_array();
        foreach ($cuti_lain as $cl) {
            $total_hari += $cl['jml_cuti'];
        }

        $potongan = round(($gaji_pokok / 30) * $total_hari);
        $gaji_bersih = $gaji_pokok - $potongan;

        echo json_encode([
            'status' => 'success',
            'total_cuti' => $total_hari,
            'gaji_pokok' => number_format($gaji_pokok, 0, ',', '.'),
            'potongan' => number_format($potongan, 0, ',', '.'),
            'gaji_bersih' => number_format($gaji_bersih, 0, ',', '.')
        ]);
    }
EOD;

$c = preg_replace('/}\s*$/', $append . "\n}", $c);
file_put_contents($f, $c);

echo "Successfully reverted Sdm and applied to Kaur!";
?>
