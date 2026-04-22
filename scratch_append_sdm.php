<?php
$file = 'c:\\xampp\\htdocs\\AplikasiCuti\\application\\controllers\\Sdm.php';
$content = file_get_contents($file);

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

        // Cuti diluar tanggungan = total gaji / 30 * total hari (Atau cukup sebutkan potongan manual jika mau)
        // Kita hitung harian = gaji pokok / 30
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

$content = preg_replace('/}\s*$/', $append . "\n}", $content);
file_put_contents($file, $content);
echo "Appended Sdm.php";
?>
