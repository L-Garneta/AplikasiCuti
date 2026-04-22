<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kaur extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->library('form_validation');
		$this->load->helper('tglindo');
		$this->load->model('Kaur_model', 'user_cuti');
	}

	public function index()
	{
		$data['title'] = 'Beranda';
		$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();

		$data['count_cuti_tahunan'] = $this->db->where('approved_kaur', 1)->count_all_results('form_cuti');
		$data['count_cuti_luartanggungan'] = $this->db->where('approved_kaur', 1)->count_all_results('formcuti_lain');
		$data['count_cuti_ditolak'] = $this->db->where('is_approve', 2)->count_all_results('form_cuti');
		$data['count_user'] = $this->db->count_all('mst_user');
		$data['pegawai'] = $this->db->get('mst_user')->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kaur/index', $data);
		$this->load->view('templates/footer');
	}

	public function profile()
	{
		$data['title'] = 'My Profile';
		$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kaur/profile', $data);
		$this->load->view('templates/footer');
	}

	public function edit()
	{
		$upload_image = $_FILES['image']['name'];
		if ($upload_image) {
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']     = '2048';
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
		$nama =  $this->input->post('nama');
		$jabatan =  $this->input->post('jabatan');
		$bagian =  $this->input->post('bagian');
		$nik = $this->input->post('nik');
		$username = $this->input->post('username');

		$this->db->set('nama', $nama);
		$this->db->set('jabatan', $jabatan);
		$this->db->set('bagian', $bagian);
		$this->db->set('nik', $nik);
		$this->db->set('username', $username);
		$this->db->where('id', $this->session->userdata('id'));
		$this->db->update('mst_user');
		$this->session->set_userdata('username', $username);

		$this->session->set_flashdata('message', 'Simpan Perubahan');
		redirect('kaur/index');
	}

	public function changepassword()
	{
		$current_password = $this->input->post('current_password');
		$new_password = $this->input->post('new_password1');

		if ($current_password == $new_password) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger font-weight-bolder text-center" role="alert">Password baru tidak boleh sama dengan password lama</div>');
			redirect('kaur/index');
		} else {
			$password_hash = password_hash($new_password, PASSWORD_DEFAULT);
			$this->db->set('password', $password_hash);
			$this->db->where('username', $this->session->userdata('username'));
			$this->db->update('mst_user');
			$this->session->set_flashdata('message', 'Simpan Perubahan');
			redirect('kaur/index');
		}
	}

	public function add_cuti()
	{
		$this->form_validation->set_rules('input', 'Tanggal', 'required|trim');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'required|trim');
		$this->form_validation->set_rules('jml_cuti', 'Jumlah Cuti', 'required|trim|numeric|greater_than[0]');
		$this->form_validation->set_rules('sisa_cuti', 'Sisa Cuti', 'required|trim|numeric|greater_than[-1]');
		$this->form_validation->set_rules('cuti', 'Tanggal Cuti 1', 'required|trim');
		$this->form_validation->set_rules('cuti2', 'Tanggal Cuti 2', 'required|trim');
		$this->form_validation->set_rules('masuk', 'Tanggal Masuk', 'required|trim');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
		$this->form_validation->set_rules('telp', 'No Telp', 'required|trim');

		if ($this->form_validation->run() == false) {
			$data['title'] = 'Input Cuti';
			$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
			$data['user_cuti'] = $this->db->get_where('form_cuti', ['id_user' => $this->session->userdata('id')])->row_array();
			$data['sisa_cuti'] = $this->user_cuti->getSisaCuti();
			$data['kode_unik'] = $this->user_cuti->getKodeUnik();
			$data['kode_unik2'] = $this->user_cuti->getKodeUnik2();

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('kaur/add_cuti', $data);
			$this->load->view('templates/footer');
		} else {
			$data = [
				'id_user' => $this->input->post('id_user'),
				'input' => $this->input->post('input'),
				'kode_unik' => $this->input->post('kode_unik'),
				'nik' => $this->input->post('nik'),
				'role_id' => $this->input->post('role_id'),
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
			redirect('kaur/history');
		}
	}

	public function edit_cuti()
	{
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'required|trim');
		$this->form_validation->set_rules('jml_cuti', 'Jumlah Cuti', 'required|trim|numeric|greater_than[0]');
		$this->form_validation->set_rules('sisa_cuti', 'Sisa Cuti', 'required|trim|numeric|greater_than[-1]');
		$this->form_validation->set_rules('cuti', 'Tanggal Cuti 1', 'required|trim');
		$this->form_validation->set_rules('cuti2', 'Tanggal Cuti 2', 'required|trim');
		$this->form_validation->set_rules('masuk', 'Tanggal Masuk', 'required|trim');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
		$this->form_validation->set_rules('telp', 'No Telp', 'required|trim');

		$data['title'] = 'Edit Cuti Tahunan';
		$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['user_cuti'] = $this->db->get_where('form_cuti', ['id_user' => $this->session->userdata('id')])->row_array();

		$this->load->model('Staf_model', 'user_cuti');
		$data['sisa_cuti'] = $this->user_cuti->getSisaCuti();

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('kaur/edit_cuti', $data);
			$this->load->view('templates/footer');
		} else {
			$id = $this->input->post('id');
			$nama =  $this->input->post('nama');
			$jabatan =  $this->input->post('jabatan');
			$bagian =  $this->input->post('bagian');
			$nik = $this->input->post('nik');
			$keterangan =  $this->input->post('keterangan');
			$jml_cuti = $this->input->post('jml_cuti');
			$sisa_cuti = $this->input->post('sisa_cuti');
			$cuti = $this->input->post('cuti');
			$cuti2 = $this->input->post('cuti2');
			$masuk = $this->input->post('masuk');
			$alamat =  $this->input->post('alamat');
			$telp = $this->input->post('telp');

			$this->db->set('nama', $nama);
			$this->db->set('jabatan', $jabatan);
			$this->db->set('bagian', $bagian);
			$this->db->set('nik', $nik);
			$this->db->set('keterangan', $keterangan);
			$this->db->set('jml_cuti', $jml_cuti);
			$this->db->set('sisa_cuti', $sisa_cuti);
			$this->db->set('cuti', $cuti);
			$this->db->set('cuti2', $cuti2);
			$this->db->set('masuk', $masuk);
			$this->db->set('alamat', $alamat);
			$this->db->set('telp', $telp);
			$this->db->where('id', $id);
			$this->db->update('form_cuti');

			$this->session->set_flashdata('message', 'Update data');
			redirect('kaur/history');
		}
	}

	public function add_cuti_lain()
	{
		$this->form_validation->set_rules('nama', 'nama', 'required');
		$this->form_validation->set_rules('cuti', 'Tanggal Cuti 1', 'required');
		$this->form_validation->set_rules('cuti2', 'Tanggal Cuti 2', 'required');
		$this->form_validation->set_rules('masuk', 'Tanggal Masuk', 'required');

		if ($this->form_validation->run() == false) {
			$data['title'] = 'Input Cuti Tahunan';
			$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
			$data['user_cuti'] = $this->db->get_where('form_cuti', ['id_user' => $this->session->userdata('id')])->row_array();
			$data['sisa_cuti'] = $this->user_cuti->getSisaCuti();

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('kaur/add_cuti', $data);
			$this->load->view('templates/footer');
		} else {
			$data = [
				'id_user' => $this->input->post('id_user', true),
				'role_id' => $this->input->post('role_id', true),
				'tgl_input' => $this->input->post('tgl_input', true),
				'kode_unik2' => $this->input->post('kode_unik2'),
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
			$this->session->set_flashdata('message', 'Simpan cuti');
			redirect('kaur/history_cutilain');
		}
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
			$this->load->view('kaur/edit_cutilain', $data);
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
			redirect('kaur/history_cutilain');
		}
	}

	public function history()
	{
		$data['title'] = 'History Cuti';
		$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();

		$id_user = $this->session->userdata('id');
		$data['user_cuti'] = $this->user_cuti->getHistoryCuti($id_user);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kaur/history', $data);
		$this->load->view('templates/footer');
	}

	public function history_cutilain()
	{
		$data['title'] = 'History Cuti Lain';
		$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();

		$id_user = $this->session->userdata('id');
		$data['user_cuti'] = $this->user_cuti->getHistoryCutiLain($id_user);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kaur/history_cutilain', $data);
		$this->load->view('templates/footer');
	}

	public function cuti_staf()
    {
        $m = $this->input->get('m');
        $y = $this->input->get('y');
        $data['m'] = $m;
        $data['y'] = $y;

		$data['title'] = 'Approval Cuti Bulanan';
		$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['user_cuti'] = $this->db->get_where('form_cuti', ['id_user' => $this->session->userdata('id')])->result_array();

		$bagian = $this->session->userdata('bagian');
		$data['staf_cuti'] = $this->user_cuti->getListCutiStaf($bagian);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kaur/cuti_staf', $data);
		$this->load->view('templates/footer');
	}

	public function cutilain_staf()
    {
        $m = $this->input->get('m');
        $y = $this->input->get('y');
        $data['m'] = $m;
        $data['y'] = $y;

		$data['title'] = 'Approval Cuti (Menikah, Melahirkan, dll)';
		$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['user_cuti'] = $this->db->get_where('formcuti_lain', ['id_user' => $this->session->userdata('id')])->result_array();

		$bagian = $this->session->userdata('bagian');
		$data['staf_cutilain'] = $this->user_cuti->getListCutiLainStaf($bagian);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kaur/cutilain_staf', $data);
		$this->load->view('templates/footer');
	}

	public function get_cuti_staf()
	{
		$id = $this->input->post('id');
		echo json_encode($this->db->get_where('form_cuti', ['id' => $id])->row_array());
	}

	public function approve_cuti()
	{
		$nama_atasan = $this->session->userdata('nama');
		$id = $this->input->post('id');
		$alasan_ditolak = $this->input->post('alasan_ditolak');
		$status = $this->input->post('is_approve'); // 0=ACC, 2=TOLAK

		$this->db->set('atasan', $nama_atasan);
		$this->db->set('alasan_ditolak', $alasan_ditolak);

        // 🔥 Logika Alur Tahap 1 KAUR
        $this->db->set('approved_kaur', $status);
        if ($status == 0) {
            // ✅ KAUR ACC -> Lanjut ke SDM
            $this->db->set('approved_sdm', 1);
            $this->db->set('is_approve', 1);
        } else {
            // ❌ KAUR TOLAK -> Langsung Final Tolak
            $this->db->set('approved_sdm', 2);
            $this->db->set('is_approve', 2);
        }

		$this->db->where('id', $id);
		$this->db->update('form_cuti');

		$this->session->set_flashdata('message', 'Simpan Data');
		redirect('kaur/cuti_staf');
	}

	public function get_cutilain_staf()
	{
		$id = $this->input->post('id');
		echo json_encode($this->db->get_where('formcuti_lain', ['id' => $id])->row_array());
	}

	public function approvecuti_lain()
	{
		$nama_atasan = $this->session->userdata('nama');
		$id = $this->input->post('id');
		$alasan_ditolak = $this->input->post('alasan_ditolak');
		$status = $this->input->post('is_approve'); // 0=ACC, 2=TOLAK

		$this->db->set('atasan', $nama_atasan);
		$this->db->set('alasan_ditolak', $alasan_ditolak);
		$this->db->set('approved_kaur', $status);
		if ($status == 0) {
			$this->db->set('approved_sdm', 1);
			$this->db->set('is_approve', 1);
		} else {
			$this->db->set('approved_sdm', 2);
			$this->db->set('is_approve', 2);
		}

		$this->db->where('id', $id);
		$this->db->update('formcuti_lain');
		$this->session->set_flashdata('message', 'Simpan Data');
		redirect('kaur/cutilain_staf');
	}

	public function add_staf()
	{
		$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
		$this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');
		$this->form_validation->set_rules('bagian', 'Bagian', 'required|trim');
		$this->form_validation->set_rules('nik', 'No NIK', 'required|trim|is_unique[mst_user.nik]', array(
			'is_unique' => 'No NIK sudah ada'
		));
		$this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[mst_user.username]', array(
			'is_unique' => 'Username sudah ada'
		));
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', array(
			'matches' => 'Password tidak sama',
			'min_length' => 'password min 3 karakter'
		));
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

		if ($this->form_validation->run() == false) {
			$data['title'] = 'Tambah User Baru';
			$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
			$data['user_list'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->result_array();
			$data['pegawai'] = $this->db->get_where('mst_user', ['bagian' => $this->session->userdata('bagian')])->result_array();
			$data['kode_nik'] = $this->user_cuti->getKodeNik();

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('kaur/add_staf', $data);
			$this->load->view('templates/footer');
		} else {
			$data = array(
				'nama' =>  $this->input->post('nama', true),
				'jabatan' =>  $this->input->post('jabatan', true),
				'bagian' =>  $this->input->post('bagian', true),
				'nik' => $this->input->post('nik', true),
				'image' => 'default.jpg',
				'role_id' => $this->input->post('role_id', true),
				'date_created' => $this->input->post('date_created', true),
				'username' => $this->input->post('username', true),
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'is_active' => 1
			);

			$this->db->insert('mst_user', $data);
			$this->session->set_flashdata('message', 'Simpan data');
			redirect('kaur/list_staf');
		}
	}

	public function list_staf()
	{
		$data['title'] = 'List Staf';
		$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['user_cuti'] = $this->db->get_where('form_cuti', ['id_user' => $this->session->userdata('id')])->row_array();
		$data['pegawai'] = $this->db->get_where('mst_user', ['bagian' => $this->session->userdata('bagian')])->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kaur/list_staf', $data);
		$this->load->view('templates/footer');
	}


	public function cetak_data($id)
	{
		$this->load->library('Pdf');
		$pdf = new FPDF('p', 'mm', 'A4');
		$pdf->AddPage();
		$pdf->Cell(50, 25, '', 0, 1, 'C');
		$pdf->SetFont('Times', '', 11);
		$pdf->Ln(3);
		$pdf->SetFont('Times', 'B', 11);
		$pdf->Cell(190, 5, 'PERMOHONAN CUTI / IJIN', 0, 1, 'C');
		$pdf->Ln(10);
		$pdf->SetFont('Times', '', 11);
		$pdf->Cell(10, 5, 'Kepada Yth :', 0, 1);
		$pdf->Cell(10, 5, 'Kabag SDM', 0, 1);
		$pdf->Cell(10, 5, 'Di tempat.', 0, 1);
		$pdf->Ln(6);

		$sisa_cuti = $this->db->get_where('form_cuti', ['id' => $id])->result_array();
		foreach ($sisa_cuti as $row) {
			$pdf->Cell(10, 5, 'Yang bertanda tangan di bawah ini, Saya :', 0, 1);
			$pdf->Cell(26, 5, 'Nama', 0, 0);
			$pdf->Cell(2, 5, ':', 0, 0);
			$pdf->Cell(10, 5, ucwords($row['nama']), 0, 1);
			$pdf->Cell(26, 5, 'NIK', 0, 0);
			$pdf->Cell(2, 5, ':', 0, 0);
			$pdf->Cell(10, 5, $row['nik'], 0, 1);
			$pdf->Cell(26, 5, 'Bagian', 0, 0);
			$pdf->Cell(2, 5, ':', 0, 0);
			$pdf->Cell(20, 5, $row['bagian'], 0, 1);
			$pdf->Ln(3);
			$pdf->Cell(60, 5, 'Dengan ini mengajukan permohonan : ' . $row['jenis_cuti'] . ', Selama ' . $row['jml_cuti'] . ' hari', 0, 1);
			$pdf->Cell(100, 5, 'mulai tanggal '  . format_indo($row['cuti']) . ' sampai tanggal ' . format_indo($row['cuti2']) . ', dan bekerja kembali pada tanggal ' . format_indo($row['masuk']) . '.', 0, 1);
			$pdf->Cell(58, 5, 'Selama cuti/ijin Saya dapat dihubungi ke :', 0, 1);
			$pdf->Ln(3);
			$pdf->Cell(26, 5, 'Alamat', 0, 0);
			$pdf->Cell(2, 5, ':', 0, 0);
			$pdf->Cell(10, 5, ucwords($row['alamat']), 0, 1);
			$pdf->Cell(26, 5, 'No. Telp/HP', 0, 0);
			$pdf->Cell(2, 5, ':', 0, 0);
			$pdf->Cell(10, 5, $row['telp'], 0, 1);
			$pdf->Ln(8);
			$pdf->Cell(95, 5, '', 0, 0, 'C');
			$pdf->Cell(95, 5, 'Kudus, ' . format_indo($row['input']), 0, 1, 'C');
			$pdf->Cell(45, 5, 'Menyetujui', 0, 0, 'C');
			$pdf->Cell(75, 5, '', 0, 0, 'C');
			$pdf->Cell(45, 5, 'Hormat saya,', 0, 1, 'C');
			$pdf->Cell(45, 5, 'Atasan Langsung', 0, 0, 'C');
			$pdf->Ln(30);
			$pdf->Cell(45, 5, ucwords($row['atasan']), 0, 0, 'C');
			$pdf->Cell(75, 5, '', 0, 0, 'C');
			$pdf->Cell(45, 5, ucwords($row['nama']), 0, 1, 'C');
			$pdf->Ln(10);
			$pdf->Cell(190, 5, 'Mengetahui,', 0, 1, 'C');
			$pdf->Cell(190, 5, 'Kepala Bidang / Bagian / Instalasi Terkait,', 0, 1, 'C');
			$pdf->Ln(20);
			$pdf->Cell(190, 5, ucwords($row['nama_kabid']), 0, 1, 'C');
			$pdf->Ln(20);
			$pdf->Cell(10, 7, 'No', 1, 0, 'C');
			$pdf->Cell(33, 7, 'Jenis Cuti/Ijin', 1, 0, 'C');
			$pdf->Cell(20, 7, 'Total Cuti', 1, 0, 'C');
			$pdf->Cell(20, 7, 'Masih Ada', 1, 0, 'C');
			$pdf->Cell(20, 7, 'Diambil', 1, 0, 'C');
			$pdf->Cell(20, 7, 'Sisa Cuti', 1, 0, 'C');
			$pdf->Cell(65, 7, 'Keterangan', 1, 1, 'C');
			$pdf->Cell(10, 7, '1', 1, 0, 'C');
			$pdf->Cell(33, 7, ucwords($row['jenis_cuti']), 1, 0, 'C');
			$pdf->Cell(20, 7, '12', 1, 0, 'C');
			$pdf->Cell(20, 7, $row['sisa_cuti'] + $row['jml_cuti'], 1, 0, 'C');
			$pdf->Cell(20, 7, $row['jml_cuti'], 1, 0, 'C');
			$pdf->Cell(20, 7, $row['sisa_cuti'], 1, 0, 'C');
			$pdf->Cell(65, 7, $row['keterangan'], 1, 1, 'C');
			$pdf->Ln(8);
		}
		$pdf->Output();
	}

	public function cetak_cutilain($id)
	{
		$this->load->library('Pdf');
		$pdf = new FPDF('p', 'mm', 'A4');
		$sisa_cuti = $this->db->get_where('formcuti_lain', ['id' => $id])->result_array();
		foreach ($sisa_cuti as $row) {
			$pdf->AddPage();
			$pdf->Cell(50, 25, '', 0, 1, 'C');
			$pdf->SetFont('Times', '', 11);
			$pdf->Ln(3);
			$pdf->SetFont('Times', 'B', 11);
			$pdf->Cell(190, 5, 'PERMOHONAN CUTI DILUAR TANGGUNGAN ', 0, 1, 'C');
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
			$pdf->Cell(186, 5, 'Adonia Vincent, S.Kom', 0, 1, 'C');
			$pdf->Ln(27);
		}
		$pdf->Output();
	}

	public function cuti_staf_habis()
	{
		$data['title'] = 'Reset Cuti';
		$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['user_cuti'] = $this->db->get_where('form_cuti', ['id_user' => $this->session->userdata('id')])->row_array();
		$bagian = $this->session->userdata('bagian');
		$data['staf_cuti'] = $this->user_cuti->getListCutiStafHabis($bagian);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kaur/cuti_staf_habis', $data);
		$this->load->view('templates/footer');
	}

	public function reset_cuti($id_user)
	{
		$query = $this->db->get_where('form_cuti', ['id_user' => $id_user]);
		foreach ($query->result() as $row) {
			$this->db->insert('history_cuti', $row);
			$this->db->where('id_user', $id_user);
			$this->db->delete('form_cuti');
		}
		$this->session->set_flashdata('message', 'Reset Cuti');
		redirect('kaur/cuti_staf_habis');
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
		$this->load->view('kaur/history_cutitahunan', $data);
		$this->load->view('templates/footer');
	}

	public function view_cutitahunan()
	{
		$data['title'] = 'History Cuti Tahun Lalu';
		$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
		$id_user = $this->session->userdata('id');
		$data['cuti_saya'] = $this->db->get_where('history_cuti', ['id_user' => $id_user])->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kaur/view_cutitahunan', $data);
		$this->load->view('templates/footer');
	}

	public function view_cutitahunan1()
	{
		$data['title'] = 'History Cuti Tahun Lalu';
		$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
		$id_user = $this->session->userdata('id');
		$tahun = $this->input->post('tahun');
		$data['pertahun'] = $this->user_cuti->getHistoryCutiTahunan($tahun, $id_user);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kaur/view_cutitahunan', $data);
		$this->load->view('templates/footer');
	}

    public function list_kary()
    {
        $id = $this->input->post('pegawai_id');
        if ($id) {
            $data_update = [
                'nama' => $this->input->post('nama'),
                'nik' => $this->input->post('nik'),
                'jabatan' => $this->input->post('jabatan'),
                'alamat' => $this->input->post('alamat'),
                'telp' => $this->input->post('telp'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'agama' => $this->input->post('agama'),
                'kota_lahir' => $this->input->post('kota_lahir'),
                'tgl_lahir' => $this->input->post('tgl_lahir')
            ];
            $this->db->where('id', $id);
            $this->db->update('mst_user', $data_update);
            $this->session->set_flashdata('message', 'Data Karyawan Berhasil Diupdate');
            redirect('kaur/list_kary');
        }

        $data['title'] = 'List Karyawan';
        $data['user'] = $this->db->get_where('mst_user', [
            'username' => $this->session->userdata('username')
        ])->row_array();

        $this->db->select('mst_user.*, data_pegawai.pegawai_id');
        $this->db->from('mst_user');
        $this->db->join('data_pegawai', 'data_pegawai.pegawai_id = mst_user.id', 'left');
        $data['pegawai'] = $this->db->get()->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kaur/list_kary', $data);
        $this->load->view('templates/footer');
    }

    public function view_kary($id)
    {
        $data['title'] = 'Detail Karyawan';
        $data['user'] = $this->db->get_where('mst_user', [
            'username' => $this->session->userdata('username')
        ])->row_array();

        $this->db->where('mst_user.id', $id);
        $this->db->select('*');
        $this->db->from('mst_user');
        $this->db->join('data_pegawai', 'data_pegawai.pegawai_id = mst_user.id', 'left');
        $data['pegawai'] = $this->db->get()->row_array();

        $data['keluarga'] = $this->db->get_where('keluarga_pegawai', ['pegawai_id' => $id])->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kaur/view_kary', $data);
        $this->load->view('templates/footer');
    }

    public function get_user()
    {
        $id = $this->input->post('id');
        echo json_encode($this->db->get_where('mst_user', ['id' => $id])->row_array());
    }

    public function add_keluarga()
    {
        $data = [
            'pegawai_id' => $this->input->post('pegawai_id'),
            'nama_keluarga' => $this->input->post('nama_keluarga'),
            'posisi_keluarga' => $this->input->post('posisi_keluarga'),
            'tempat_lahir' => $this->input->post('tempat_lahir_keluarga'),
            'tgl_lahir' => $this->input->post('tgl_lahir_keluarga'),
            'alamat' => $this->input->post('alamat_keluarga'),
            'telp' => $this->input->post('telp_keluarga')
        ];
        $this->db->insert('keluarga_pegawai', $data);
        $this->session->set_flashdata('message', 'Data keluarga berhasil ditambah');
        redirect('kaur/list_kary');
    }

    public function list_cuti_kary()
    {
        $m = $this->input->get('m');
        $y = $this->input->get('y');
        $data['m'] = $m;
        $data['y'] = $y;

        $data['title'] = 'List Cuti Bulanan';
        $data['user'] = $this->db->get_where('mst_user', [
            'username' => $this->session->userdata('username')
        ])->row_array();

        $this->db->order_by('id', 'DESC');
        $data['cuti_kary'] = $this->db->get('form_cuti')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kaur/list_cuti_kary', $data);
        $this->load->view('templates/footer');
    }

    public function list_cuti_diluartanggungan_kary()
    {
        $data['title'] = 'Cuti Lain';
        $data['user'] = $this->db->get_where('mst_user', [
            'username' => $this->session->userdata('username')
        ])->row_array();

        $this->db->order_by('id', 'DESC');
        $data['cuti_kary'] = $this->db->get('formcuti_lain')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kaur/list_cuti_diluartanggungan_kary', $data);
        $this->load->view('templates/footer');
    }


    public function detail_cuti($id)
    {
        $data['title'] = 'Detail Cuti Bulanan';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['cuti_pegawai'] = $this->db->get_where('form_cuti', ['id' => $id])->result_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kaur/detail_cuti', $data);
        $this->load->view('templates/footer');
    }

    public function detail_cuti_diluartanggungan($id)
    {
        $data['title'] = 'Detail Cuti Lain';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['cuti_pegawai'] = $this->db->get_where('formcuti_lain', ['id' => $id])->result_array();
        
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kaur/detail_cuti_diluartanggungan', $data);
		$this->load->view('templates/footer');
	}

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
        $pdf->Cell(25, 7, 'NIK', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Nama', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Bagian', 1, 0, 'C');
        $pdf->Cell(22, 7, 'Tgl Input', 1, 0, 'C');
        $pdf->Cell(22, 7, 'Tgl Cuti', 1, 0, 'C');
        $pdf->Cell(22, 7, 'Sampai', 1, 0, 'C');
        $pdf->Cell(12, 7, 'Total', 1, 0, 'C');
        $pdf->Cell(22, 7, 'Tgl Masuk', 1, 0, 'C');
        $pdf->Cell(67, 7, 'Keterangan', 1, 1, 'C');

        $pdf->SetFont('Times', '', 10);
        $no = 1;
        foreach ($cuti as $c) {
            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(25, 6, $c['nik'], 1, 0, 'C');
            $pdf->Cell(45, 6, substr($c['nama'], 0, 25), 1, 0, 'L');
            $pdf->Cell(30, 6, substr($c['bagian'], 0, 20), 1, 0, 'C');
            $pdf->Cell(22, 6, format_indo($c[$tgl_field] ?? date('Y-m-d')), 1, 0, 'C');
            $pdf->Cell(22, 6, format_indo($c['cuti']), 1, 0, 'C');
            $pdf->Cell(22, 6, format_indo($c['cuti2']), 1, 0, 'C');
            $pdf->Cell(12, 6, $c['jml_cuti'] . ' Hr', 1, 0, 'C');
            $pdf->Cell(22, 6, format_indo($c['masuk']), 1, 0, 'C');
            $pdf->Cell(67, 6, $c['keterangan'], 1, 1, 'L');
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
        $pdf->Cell(138, 5, 'dr. Agung Wibowo', 0, 1, 'C');

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
        // Manual hari_bolos removed as per user request to rely on DB sync

        $pegawai = $this->db->get_where('mst_user', ['id' => $id_pegawai])->row_array();
        if (!$pegawai) {
            echo json_encode(['status' => 'error', 'message' => 'Pegawai tidak ditemukan']);
            return;
        }

        $total_hari = 0;
        $total_cuti_bulanan = 0;
        
        // Cuti Bulanan (form_cuti)
        $this->db->where('id_user', $id_pegawai);
        $this->db->where('is_approve', 0);
        $this->db->where('MONTH(cuti)', $bulan);
        $this->db->where('YEAR(cuti)', $tahun);
        $this->db->where_not_in('jenis_cuti', ['Melahirkan', 'Menikah', 'Sakit']);
        $cuti_reguler = $this->db->get('form_cuti')->result_array();
        foreach ($cuti_reguler as $cr) {
            $total_cuti_bulanan += $cr['jml_cuti'];
        }

        // Potong gaji untuk cuti bulanan hanya jika melebihi jatah 1 hari
        if ($total_cuti_bulanan > 1) {
            $total_hari += ($total_cuti_bulanan - 1);
        }

        // Cuti Lainnya (formcuti_lain) di luar tanggungan
        $this->db->where('id_user', $id_pegawai);
        $this->db->where('is_approve', 0);
        $this->db->where('MONTH(cuti)', $bulan);
        $this->db->where('YEAR(cuti)', $tahun);
        $this->db->where_not_in('jenis_cuti', ['Melahirkan', 'Menikah', 'Sakit']);
        $cuti_lain = $this->db->get('formcuti_lain')->result_array();
        foreach ($cuti_lain as $cl) {
            $total_hari += $cl['jml_cuti'];
        }

        $total_hari += 0; // Manual hari_bolos removed
        $pot_absensi = round(($gaji_pokok / 30) * $total_hari);
        
        // Sum all Pendapatan
        $gaji_lembur = (int) $this->input->post('gaji_lembur');
        $tunj_kinerja = (int) $this->input->post('tunj_kinerja');
        $tunj_jabatan = (int) $this->input->post('tunj_jabatan');
        $tunj_makan = (int) $this->input->post('tunj_makan');
        $tunj_beras = (int) $this->input->post('tunj_beras');
        $jasa_pelayanan = (int) $this->input->post('jasa_pelayanan');
        
        $total_thp = $gaji_pokok + $gaji_lembur + $tunj_kinerja + $tunj_jabatan + $tunj_makan + $tunj_beras + $jasa_pelayanan;

        // Sum all Potongan
        $pot_bpjs = (int) $this->input->post('pot_bpjs');
        $pot_kesehatan = (int) $this->input->post('pot_kesehatan');
        $pot_telat = (int) $this->input->post('pot_telat');
        $pot_pajak = (int) $this->input->post('pot_pajak');
        // Manual override pot_absensi if provided (though we usually fill it via ajax first)
        $pot_absensi_input = $this->input->post('pot_absensi');
        if($pot_absensi_input !== null && $pot_absensi_input !== '') {
            $pot_absensi = (int) $pot_absensi_input;
        }

        $total_potongan = $pot_absensi + $pot_bpjs + $pot_kesehatan + $pot_telat + $pot_pajak;
        $gaji_bersih = $total_thp - $total_potongan;

        echo json_encode([
            'status' => 'success',
            'total_cuti' => $total_hari,
            'potongan_raw' => $pot_absensi,
            'total_thp' => number_format($total_thp, 0, ',', '.'),
            'total_potongan' => number_format($total_potongan, 0, ',', '.'),
            'gaji_bersih' => number_format($gaji_bersih, 0, ',', '.')
        ]);
    }

    public function cetak_slip_gaji()
    {
        $id_pegawai = $this->input->post('id_pegawai');
        $m = $this->input->post('bulan');
        $y = $this->input->post('tahun');
        
        $pegawai = $this->db->get_where('mst_user', ['id' => $id_pegawai])->row_array();
        if (!$pegawai) return;

        $nama_bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $periode = $nama_bulan[(int)$m] . ' ' . $y;

        $this->load->library('Pdf');
        // Ukuran Slip Gaji 10cm x 14cm Portrait
        $pdf = new FPDF('P', 'mm', array(100, 140));
        $pdf->AddPage();
        
        // ================= KOP =================
        $pdf->Image(FCPATH . 'assets/img/logo.png', 5, 5, 12);
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(90, 4, 'KLINIK PRATAMA RAWAT INAP', 0, 1, 'C');
        $pdf->Cell(90, 4, '"DARUSSYIFA"', 0, 1, 'C');
        $pdf->SetFont('Times', '', 6);
        $pdf->Cell(90, 3, 'Jl. Joyoboyo Timur, Ds. Sumbercangkring Kediri', 0, 1, 'C');
        $pdf->Ln(1);
        $pdf->Cell(90, 0, '', 1, 1);
        $pdf->Ln(1);

        // ================= JUDUL =================
        $pdf->SetFont('Times', 'BU', 9);
        $pdf->Cell(90, 4, 'SLIP IHSAN KARYAWAN', 0, 1, 'C');
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(90, 4, 'Bulan : ' . $periode, 0, 1, 'C');
        $pdf->Ln(2);

        // ================= INFO KARYAWAN =================
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(15, 4, 'Nama', 0, 0); $pdf->Cell(3, 4, ':', 0, 0); $pdf->Cell(32, 4, substr($pegawai['nama'],0,20), 0, 0);
        $pdf->Cell(12, 4, 'Bagian', 0, 0); $pdf->Cell(3, 4, ':', 0, 0); $pdf->Cell(25, 4, $pegawai['bagian'], 0, 1);
        
        $pdf->Cell(15, 4, 'NIK', 0, 0); $pdf->Cell(3, 4, ':', 0, 0); $pdf->Cell(32, 4, $pegawai['nik'], 0, 0);
        $pdf->Cell(12, 4, 'Jabatan', 0, 0); $pdf->Cell(3, 4, ':', 0, 0); $pdf->Cell(25, 4, substr($pegawai['jabatan'],0,15), 0, 1);
        $pdf->Ln(2);

        // ================= RINCIAN =================
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(45, 5, 'Penerimaan', 1, 0, 'C');
        $pdf->Cell(45, 5, 'Potongan', 1, 1, 'C');
        
        $pdf->SetFont('Times', '', 7);
        
        // Data Pendapatan
        $gp = (int)$this->input->post('gaji_pokok');
        $gl = (int)$this->input->post('gaji_lembur');
        $tk = (int)$this->input->post('tunj_kinerja');
        $tj = (int)$this->input->post('tunj_jabatan');
        $tm = (int)$this->input->post('tunj_makan');
        $tb = (int)$this->input->post('tunj_beras');
        $jp = (int)$this->input->post('jasa_pelayanan');
        $total_thp = $gp + $gl + $tk + $tj + $tm + $tb + $jp;

        // Data Potongan
        $pa = (int)$this->input->post('pot_absensi');
        $pb = (int)$this->input->post('pot_bpjs');
        $pk = (int)$this->input->post('pot_kesehatan');
        $pt = (int)$this->input->post('pot_telat');
        $pp = (int)$this->input->post('pot_pajak');
        $total_pot = $pa + $pb + $pk + $pt + $pp;

        $rows = [
            ['Gaji Pokok', $gp, 'Pot. Absensi', $pa],
            ['Gaji Lembur', $gl, 'BPJS', $pb],
            ['Tunj. Kinerja', $tk, 'Kesejahteraan', $pk],
            ['Tunj. Jabatan', $tj, 'Pot. Telat', $pt],
            ['Tunj. Makan', $tm, 'Pot. Pajak', $pp],
            ['Tunj. Beras', $tb, '', ''],
            ['Jasa Pelayanan', $jp, '', '']
        ];

        foreach($rows as $row) {
            $pdf->Cell(28, 4, $row[0], 'LR', 0, 'L');
            $pdf->Cell(17, 4, $row[1] > 0 ? number_format($row[1],0,',','.') : '', 'R', 0, 'R');
            $pdf->Cell(28, 4, $row[2], 'R', 0, 'L');
            $pdf->Cell(17, 4, $row[3] > 0 ? number_format($row[3],0,',','.') : '', 'R', 1, 'R');
        }

        $pdf->SetFont('Times', 'B', 7);
        $pdf->Cell(28, 5, 'Total THP', 1, 0, 'L');
        $pdf->Cell(17, 5, number_format($total_thp,0,',','.'), 1, 0, 'R');
        $pdf->Cell(28, 5, 'Total Pot.', 1, 0, 'L');
        $pdf->Cell(17, 5, number_format($total_pot,0,',','.'), 1, 1, 'R');
        
        $pdf->Ln(1);
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(65, 5, 'GAJI DIBAYARKAN', 1, 0, 'R');
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(25, 5, 'Rp '.number_format($total_thp - $total_pot,0,',','.'), 1, 1, 'R', true);
        $pdf->Ln(2);

        // ================= TANDA TANGAN =================
        $pdf->SetFont('Times', '', 7);
        $pdf->Cell(45, 4, 'Yang menerima,', 0, 0, 'C');
        $pdf->Cell(45, 4, 'Bagian SDM,', 0, 1, 'C');
        
        $pdf->Ln(6);
        
        $pdf->SetFont('Times', 'BU', 7);
        $pdf->Cell(45, 4, substr($pegawai['nama'],0,20), 0, 0, 'C');
        $pdf->Cell(45, 4, 'Elliningtiyas, S.E', 0, 1, 'C');
        
        $pdf->SetFont('Times', '', 6);
        $pdf->Cell(45, 3, 'NIK : ' . $pegawai['nik'], 0, 0, 'C');
        $pdf->Cell(45, 3, 'NIK : 2023.11.015', 0, 1, 'C');

        $pdf->Output('I', "Slip_Gaji_{$pegawai['nama']}_{$periode}.pdf");
    }
}
