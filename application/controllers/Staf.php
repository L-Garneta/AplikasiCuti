<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Staf extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->model('Staf_model', 'user_cuti');
    }
    public function index()
{
    $data['title'] = 'Dashboard';

    // Ambil user login
    $data['user'] = $this->db->get_where('mst_user', [
        'username' => $this->session->userdata('username')
    ])->row_array();

    $id_user = $this->session->userdata('id');

    // ================== USER CUTI ==================
    $user_cuti = $this->db->get_where('form_cuti', [
        'id_user' => $id_user
    ])->row_array();

    // Jika belum ada data cuti → kasih default
    if (!$user_cuti) {
        $user_cuti = [
            'sisa_cuti' => 0,
            'jml_cuti' => 0,
            'keterangan' => '-',
            'cuti' => null,
            'cuti2' => null,
            'masuk' => null
        ];
    }

    $data['user_cuti'] = $user_cuti;

    // ================== SISA CUTI ==================
    $data['sisa_cuti'] = $this->user_cuti->getSisaCuti() ?? 0;

    // ================== LIST CUTI ==================
    $data['cuti_user'] = $this->user_cuti->getCutiUser($id_user) ?? [];
    $data['cuti_lain_user'] = $this->user_cuti->getCutiLainUser($id_user) ?? [];

    // ================== COUNT CUTI ==================
    $query = $this->user_cuti->cuti_count($id_user);
    $data['count'] = ($query && isset($query->pending)) ? $query->pending : 0;

    // ================== HISTORY CUTI ==================
    $query = $this->user_cuti->historyCutiCount($id_user);
    $data['history_count'] = ($query && isset($query->pending)) ? $query->pending : 0;

    // ================== HISTORY CUTI LAIN ==================
    $query = $this->user_cuti->historyCutiLainCount($id_user);
    $data['history_countcutilain'] = ($query && isset($query->pending)) ? $query->pending : 0;

    // ================== RECORDS ==================
    $data['records'] = $this->db->get("form_cuti")->result() ?? [];

    // ================== LOAD VIEW ==================
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('staf/index', $data);
    $this->load->view('templates/footer');
}

    public function edit()
    {
        $upload_image = $_FILES['image']['name'];
        if ($upload_image) {
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/img/profile';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('image')) {
                $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
                $old_image = $data['user']['image'];
                if ($old_image != 'default.jpg') {
                    unlink(FCPATH . 'assets/img/profile/' . $old_image);
                }
                $new_image = $this->upload->data('file_name');
                $this->db->set('image', $new_image);
            } else {
                echo $this->upload->display_errors();
            }
        }

        $nama = $this->input->post('nama');
        $jabatan = $this->input->post('jabatan');
        $bagian = $this->input->post('bagian');
        $nik = $this->input->post('nik');
        $username = $this->input->post('username');

        $this->db->set('nama', $nama);
        $this->db->set('jabatan', $jabatan);
        $this->db->set('bagian', $bagian);
        $this->db->set('nik', $nik);
        $this->db->where('username', $username);
        $this->db->update('mst_user');

        $this->session->set_flashdata('message', 'Simpan Perubahan');
        redirect('staf/index');
    }

    public function changepassword()
    {
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password1');

        if ($current_password == $new_password) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger font-weight-bolder text-center" role="alert">Password baru tidak boleh sama dengan password lama</div>');
            redirect('staf/index');
        } else {
            $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $this->db->set('password', $password_hash);
            $this->db->where('username', $this->session->userdata('username'));
            $this->db->update('mst_user');
            $this->session->set_flashdata('message', 'Simpan Perubahan');
            redirect('staf/index');
        }
    }

    public function profile()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('staf/profile', $data);
        $this->load->view('templates/footer');
    }

public function add_cuti()
{
    $this->form_validation->set_rules('input', 'Tanggal', 'required|trim');
    $this->form_validation->set_rules('keterangan', 'Keterangan', 'required|trim');
    $this->form_validation->set_rules('jml_cuti', 'Ambil cuti', 'required|trim|numeric|greater_than[0]');
    $this->form_validation->set_rules('sisa_cuti', 'Sisa Cuti', 'required|trim|greater_than[-1]');
    $this->form_validation->set_rules('cuti', 'Tanggal Cuti 1', 'required|trim');
    $this->form_validation->set_rules('cuti2', 'Tanggal Cuti 2', 'required|trim');
    $this->form_validation->set_rules('masuk', 'Tanggal Masuk', 'required|trim');
    $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
    $this->form_validation->set_rules('telp', 'No Telp', 'required|trim');

    if ($this->form_validation->run() == false) {

        $data['title'] = 'Input Cuti';

        $data['user'] = $this->db->get_where('mst_user', [
            'username' => $this->session->userdata('username')
        ])->row_array();

        // =========================
        // 🔥 FIX 1: user_cuti NULL
        // =========================
        $data['user_cuti'] = $this->db->get_where('form_cuti', [
            'id_user' => $this->session->userdata('id')
        ])->row_array();

        if (!$data['user_cuti']) {
            $data['user_cuti'] = [
                'alamat' => '',
                'telp' => '',
                'keterangan' => '',
                'sisa_cuti' => 12,
                'jml_cuti' => 0,
                'is_approve' => 0
            ];
        }

        // =========================
        // 🔥 FIX 2: sisa_cuti NULL
        // =========================
        $data['sisa_cuti'] = $this->user_cuti->getSisaCuti();

        if (!$data['sisa_cuti']) {
            $data['sisa_cuti'] = [
                'is_approve' => 0,
                'sisa_cuti' => 12,
                'jml_cuti' => 0,
                'keterangan' => ''
            ];
        }

        $data['kode_unik'] = $this->user_cuti->getKodeUnik();
        $data['kode_unik2'] = $this->user_cuti->getKodeUnik2();

        $id = $this->session->userdata('id');
        $data['null_cuti'] = $this->user_cuti->getNullCuti($id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('staf/add_cuti', $data);
        $this->load->view('templates/footer');

    } else {

        $data = [
            'id_user' => $this->input->post('id_user'),
            'kode_unik' => $this->input->post('kode_unik'),
            'role_id' => $this->input->post('role_id'),
            'input' => $this->input->post('input'),
            'nik' => $this->input->post('nik'),
            'nama' => $this->input->post('nama'),
            'bagian' => $this->input->post('bagian'),
            'jabatan' => $this->input->post('jabatan'),
            'jenis_cuti' => $this->input->post('jenis_cuti'),
            'keterangan' => $this->input->post('keterangan'),
            'jml_cuti' => $this->input->post('jml_cuti'),
            'sisa_cuti' => $this->input->post('sisa_cuti'),
            'cuti' => $this->input->post('cuti'),
            'cuti2' => $this->input->post('cuti2'),
            'masuk' => $this->input->post('masuk'),
            'alamat' => $this->input->post('alamat'),
            'telp' => $this->input->post('telp'),
            'is_approve' => 1
        ];

        $this->db->insert('form_cuti', $data);
        $this->session->set_flashdata('message', 'Simpan data');
        redirect('staf');
    }
}

    public function history()
    {
        $data['title'] = 'History Cuti';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();

        $id_user = $this->session->userdata('id');
        $data['user_cuti'] = $this->user_cuti->getAllCuti($id_user);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('staf/history', $data);
        $this->load->view('templates/footer');
    }

    public function detail_staf()
    {
        $data['title'] = 'Detail';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['user_cuti'] = $this->db->get_where('form_cuti', ['id_user' => $this->session->userdata('id')])->result_array();

        $nik = $this->session->userdata('nik');
        $data['detail_staf'] = $this->user_cuti->getDetailStaf($nik);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('staf/detail_staf', $data);
        $this->load->view('templates/footer');
    }

    public function cetak_data($id)
    {
        $this->load->library('Pdf');
        $pdf = new FPDF('p', 'mm', 'A4');

        // ambil 1 data saja
        $row = $this->db->get_where('form_cuti', ['id' => $id])->row_array();

        if (!$row) {
            echo "Data tidak ditemukan";
            die;
        }

        $this->load->library('Pdf');
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->Image(FCPATH . 'assets/img/logo.png', 10, 10, 20);

        // ================= HEADER =================
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(190, 6, 'KLINIK PRATAMA RAWAT INAP', 0, 1, 'C');
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(190, 6, '"DARUSSYIFA"', 0, 1, 'C');

        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(190, 5, 'Jl. Joyoboyo Timur, Ds. Sumbercangkring Kec. Gurah Kab. Kediri', 0, 1, 'C');
        $pdf->Cell(190, 5, 'Telp. 082336799868  email : klinikdarusyifa@gontor.ac.id', 0, 1, 'C');

        $pdf->Ln(5);
        $pdf->Cell(190, 0, '', 1, 1); // garis
        $pdf->Ln(5);

        // ================= JUDUL =================
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(190, 7, 'FORMULIR PENGAJUAN CUTI', 0, 1, 'C');
        $pdf->Ln(8);

        // ================= DATA PEMOHON =================
        $pdf->SetFont('Times', '', 11);

        function field($pdf, $label, $value)
        {
            $pdf->Cell(60, 7, $label, 0, 0);
            $pdf->Cell(5, 7, ':', 0, 0);
            $pdf->Cell(125, 7, $value, 0, 1);
        }

        field($pdf, 'Nama', $row['nama']);
        field($pdf, 'NIK', $row['nik']);
        field($pdf, 'Jabatan', $row['jabatan']);
        field($pdf, 'Tanggal Diajukan', format_indo($row['input']));

        // tanggal cuti
        $pdf->Cell(60, 7, 'Cuti Mulai Tanggal', 0, 0);
        $pdf->Cell(5, 7, ':', 0, 0);
        $pdf->Cell(50, 7, format_indo($row['cuti']), 0, 0);

        $pdf->Cell(20, 7, 'Sampai', 0, 0);
        $pdf->Cell(5, 7, ':', 0, 0);
        $pdf->Cell(50, 7, format_indo($row['cuti2']), 0, 1);

        $pdf->Ln(5);

        // ================= JENIS CUTI =================
        $pdf->Cell(190, 7, 'Jenis Cuti:', 0, 1);

        function cek($jenis, $value)
        {
            return ($jenis == $value) ? '[v]' : '[ ]';
        }

        $pdf->Cell(60, 7, cek($row['jenis_cuti'], 'Sakit') . ' Cuti Sakit', 0, 0);
        $pdf->Cell(60, 7, cek($row['jenis_cuti'], 'Khusus') . ' Cuti Khusus', 0, 0);
        $pdf->Cell(60, 7, cek($row['jenis_cuti'], 'Melahirkan') . ' Cuti Melahirkan', 0, 1);

        $pdf->Cell(60, 7, cek($row['jenis_cuti'], 'Tahunan') . ' Cuti Tahunan', 0, 1);

        $pdf->Ln(5);

        // ================= KETERANGAN =================
        $pdf->Cell(60, 7, 'Keterangan Cuti', 0, 0);
        $pdf->Cell(5, 7, ':', 0, 0);
        $pdf->MultiCell(125, 7, $row['keterangan']);

        $pdf->Ln(3);

        // ================= KONTAK =================
        $pdf->Cell(60, 7, 'No HP yang dapat dihubungi', 0, 0);
        $pdf->Cell(5, 7, ':', 0, 0);
        $pdf->Cell(125, 7, $row['telp'], 0, 1);

        $pdf->Cell(60, 7, 'Alamat yang dapat dihubungi', 0, 0);
        $pdf->Cell(5, 7, ':', 0, 0);
        $pdf->MultiCell(125, 7, $row['alamat']);

        $pdf->Ln(10);

        // ================= TANDA TANGAN =================
        $pdf->Cell(95, 7, 'Kediri, ' . format_indo($row['input']), 0, 1, 'R');

        $pdf->Cell(63, 7, 'Pemohon,', 0, 0, 'C');
        $pdf->Cell(63, 7, 'Mengetahui,', 0, 0, 'C');
        $pdf->Cell(63, 7, 'Menyetujui,', 0, 1, 'C');

        $pdf->Cell(63, 7, '', 0, 0);
        $pdf->Cell(63, 7, 'Bagian SDM', 0, 0, 'C');
        $pdf->Cell(63, 7, 'Penanggung Jawab Klinik', 0, 1, 'C');

        $pdf->Ln(20);

        $pdf->Cell(63, 7, $row['nama'], 0, 0, 'C');
        $pdf->Cell(63, 7, 'Elliningtiyas, S.E', 0, 0, 'C');
        $pdf->Cell(63, 7, 'dr Agung Wibowo', 0, 1, 'C');

        $pdf->Cell(63, 5, '', 0, 0, 'C');
        $pdf->Cell(63, 5, 'NIK : 2023.11.015', 0, 0, 'C');
        $pdf->Cell(63, 5, 'NIK : 2023.11.001', 0, 1, 'C');

        $pdf->Ln(10);

        // ================= FOOTER =================
        $pdf->SetFont('Times', 'I', 10);
        $pdf->Cell(190, 5, 'Tulus Mengabdi, Ikhlas Melayani', 0, 1, 'C');

        // OUTPUT
        $pdf->Output()

        ;
    }

    public function add_cuti_lain()
    {
        $data = [
            'id_user' => $this->input->post('id_user', true),
            'kode_unik2' => $this->input->post('kode_unik2'),
            'role_id' => $this->input->post('role_id', true),
            'tgl_input' => $this->input->post('tgl_input', true),
            'nik' => $this->input->post('nik', true),
            'nama' => $this->input->post('nama', true),
            'jabatan' => $this->input->post('jabatan', true),
            'bagian' => $this->input->post('bagian', true),
            'keterangan' => $this->input->post('keterangan', true),
            'alamat' => $this->input->post('alamat', true),
            'jenis_cuti' => $this->input->post('jenis_cuti', true),
            'telp' => $this->input->post('telp', true),
            'cuti' => $this->input->post('cuti', true),
            'cuti2' => $this->input->post('cuti2', true),
            'masuk' => $this->input->post('masuk', true),
            'is_approve' => 1
        ];
        $this->db->insert('formcuti_lain', $data);
        $this->session->set_flashdata('message', 'Simpan data');
        redirect('staf/history_cutilain');
    }

    public function history_cutilain()
    {
        $data['title'] = 'History Cuti Lain';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();

        $id_user = $this->session->userdata('id');
        $data['user_cuti'] = $this->user_cuti->getAllCutiLain($id_user);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('staf/history_cutilain', $data);
        $this->load->view('templates/footer');
    }

    public function edit_cutilain($id)
    {

        $this->form_validation->set_rules('nama', 'nama', 'required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Edit Cuti Lain';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['user_cuti'] = $this->db->get_where('formcuti_lain', ['id' => $id])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('staf/edit_cutilain', $data);
            $this->load->view('templates/footer');
        } else {

            $id = $this->input->post('id');
            $id_user = $this->input->post('id_user');
            $tgl_input = $this->input->post('tgl_input');
            $nik = $this->input->post('nik');
            $nama = $this->input->post('nama');
            $jabatan = $this->input->post('jabatan');
            $bagian = $this->input->post('bagian');
            $keterangan = $this->input->post('keterangan');
            $alamat = $this->input->post('alamat');
            $jenis_cuti = $this->input->post('jenis_cuti');
            $telp = $this->input->post('telp');
            $cuti = $this->input->post('cuti');
            $cuti2 = $this->input->post('cuti2');
            $masuk = $this->input->post('masuk');

            $this->db->set('id_user', $id_user);
            $this->db->set('tgl_input', $tgl_input);
            $this->db->set('nik', $nik);
            $this->db->set('nama', $nama);
            $this->db->set('jabatan', $jabatan);
            $this->db->set('bagian', $bagian);
            $this->db->set('keterangan', $keterangan);
            $this->db->set('alamat', $alamat);
            $this->db->set('jenis_cuti', $jenis_cuti);
            $this->db->set('telp', $telp);
            $this->db->set('cuti', $cuti);
            $this->db->set('cuti2', $cuti2);
            $this->db->set('masuk', $masuk);

            $this->db->where('id', $id);
            $this->db->update('formcuti_lain');

            $this->session->set_flashdata('message', 'Update data');
            redirect('staf/history_cutilain');
        }
    }

    public function cetak_cutilain($id)
    {
        $this->load->library('Pdf');
        $pdf = new FPDF('p', 'mm', 'A4');
        $sisa_cuti = $this->db->get_where('formcuti_lain', ['id' => $id])->result_array();
        foreach ($sisa_cuti as $row) {
            $pdf->AddPage();
            $pdf->Ln(10);
            $pdf->SetFont('Times', 'B', 11);
            $pdf->Cell(190, 5, 'PERMOHONAN ' . strtoupper($row['jenis_cuti']), 0, 1, 'C');
            $pdf->Ln(3);
            $pdf->SetFont('Times', '', 11);
            $pdf->Cell(10, 5, 'Kepada Yth :', 0, 1);
            $pdf->Cell(10, 5, 'Kabag SDM', 0, 1);
            $pdf->Cell(10, 5, 'Di tempat.', 0, 1);
            $pdf->Ln(6);
            $pdf->Cell(10, 5, 'Dengan hormat,', 0, 1);
            $pdf->Ln(6);
            $pdf->Cell(10, 5, 'Yang bertanda tangan di bawah ini, Saya :', 0, 1);
            $pdf->Ln(2);
            $pdf->Cell(55, 5, 'Nama', 0, 0);
            $pdf->Cell(2, 5, ':', 0, 0);
            $pdf->Cell(10, 5, ucwords($row['nama']), 0, 1);
            $pdf->Cell(55, 5, 'NIK', 0, 0);
            $pdf->Cell(2, 5, ':', 0, 0);
            $pdf->Cell(10, 5, $row['nik'], 0, 1);
            $pdf->Cell(55, 5, 'Jabatan', 0, 0);
            $pdf->Cell(2, 5, ':', 0, 0);
            $pdf->Cell(20, 5, ucwords($row['jabatan']), 0, 1);
            $pdf->Cell(55, 5, 'Bagian', 0, 0);
            $pdf->Cell(2, 5, ':', 0, 0);
            $pdf->Cell(20, 5, $row['bagian'], 0, 1);
            $pdf->Cell(55, 5, 'Tanggal Mulai Bekerja', 0, 0);
            $pdf->Cell(2, 5, ':', 0, 0);
            $pdf->Cell(20, 5, format_indo($row['masuk']), 0, 1);
            $pdf->Ln(3);
            $pdf->Cell(0, 5, 'Dengan ini Saya mengajukan ' . $row['jenis_cuti'] . ' terhitung mulai tanggal ' . format_indo($row['cuti']) . ' sampai tanggal ' . format_indo($row['cuti2']), 0, 1);
            $pdf->Cell(0, 5, 'dan bekerja kembali pada tanggal ' . format_indo($row['masuk']) . '.', 0, 1);
            $pdf->Ln(3);
            $pdf->Cell(10, 5, 'Adapun yang mendasari permohonan Saya adalah ' . $row['keterangan'] . '.', 0, 1);
            $pdf->Ln(3);
            $pdf->Cell(10, 5, 'Selama ' . ucwords($row['jenis_cuti']) . ', Saya dapat dihubungi ke :', 0, 1);
            $pdf->Cell(30, 5, 'Alamat', 0, 0);
            $pdf->Cell(2, 5, ':', 0, 0);
            $pdf->Cell(10, 5, ucwords($row['alamat']), 0, 1);
            $pdf->Cell(30, 5, 'Telepon', 0, 0);
            $pdf->Cell(2, 5, ':', 0, 0);
            $pdf->Cell(10, 5, $row['telp'], 0, 1);
            $pdf->Ln(5);
            $pdf->Cell(62, 5, 'Menyetujui', 0, 0, 'C');
            $pdf->Cell(62, 5, '', 0, 0, 'C');
            $pdf->Cell(62, 5, 'Kudus, ' . format_indo($row['tgl_input']), 0, 1, 'C');
            $pdf->Cell(62, 5, 'Atasan Langsung,', 0, 0, 'C');
            $pdf->Cell(62, 5, '', 0, 0, 'C');
            $pdf->Cell(62, 5, 'Pemohon', 0, 1, 'C');
            $pdf->Ln(15);
            $pdf->Cell(62, 5, ucwords($row['atasan']), 0, 0, 'C');
            $pdf->Cell(62, 5, '', 0, 0, 'C');
            $pdf->Cell(62, 5, ucwords($row['nama']), 0, 1, 'C');
            $pdf->Cell(186, 5, 'Mengetahui, ', 0, 1, 'C');
            $pdf->Cell(62, 5, 'Kepala Bidang / Bagian ' . ucwords($row['kabag']), 0, 0, 'C');
            $pdf->Cell(62, 5, '', 0, 0, 'C');
            $pdf->Cell(62, 5, 'Direktur ' . ucwords($row['direktur']), 0, 1, 'C');
            $pdf->Ln(15);
            $pdf->Cell(62, 5, ucwords($row['nama_kabag']), 0, 0, 'C');
            $pdf->Cell(62, 5, '', 0, 0, 'C');
            $pdf->Cell(62, 5, ucwords($row['nama_direktur']), 0, 1, 'C');
            $pdf->Cell(186, 5, 'Kepala Bagian SDM', 0, 1, 'C');
            $pdf->Ln(15);
            $pdf->Cell(186, 5, 'Adonia Vincent N', 0, 1, 'C');
            $pdf->Ln(27);
        }

        $pdf->Output();
    }

    public function history_cutitahunan()
    {
        $data['title'] = 'View Cuti Pertahun';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $id_user = $this->session->userdata('id');
        $data['user_cuti'] = $this->user_cuti->getAllCuti($id_user);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('staf/history_cutitahunan', $data);
        $this->load->view('templates/footer');
    }

    public function view_cutitahunan()
    {
        $data['title'] = 'History Cuti';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $id_user = $this->session->userdata('id');

        $data['cuti_saya'] = $this->db->get_where('form_cuti', ['id_user' => $id_user])->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('staf/view_cutitahunan', $data);
        $this->load->view('templates/footer');
    }

    public function view_cutitahunan1()
    {
        $data['title'] = 'History Cuti Tahun Lalu';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $id_user = $this->session->userdata('id');
        $tahun = $this->input->post('tahun');
        $data['cuti_saya'] = $this->db->get_where('form_cuti', ['id_user' => $id_user])->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('staf/data/view_cutitahunan', $data);
        $this->load->view('templates/footer');
    }
}
