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
		$data['title'] = 'Dashboard';
		$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['user_cuti'] = $this->db->get_where('form_cuti', ['id_user' => $this->session->userdata('id')])->row_array();
		$data['sisa_cuti'] = $this->user_cuti->getSisaCuti();
		$data['cuti_saya'] = $this->user_cuti->getCutiSayaLimit();
		$data['cuti_lain_saya'] = $this->user_cuti->getCutiLainSayaLimit();

		$id = $this->session->userdata('id');
		// hitung output Cuti count
		$query = $this->user_cuti->cuti_count($id);
		$data['count'] = $query->pending;
		$record = $this->db->get("form_cuti");
		$data['records'] = $record->result();

		// COunt History Cuti
		$query = $this->user_cuti->historyCutiCount($id);
		$data['history_count'] = $query->pending;
		$record = $this->db->get("form_cuti");
		$data['records'] = $record->result();

		// Count staf Cuti
		$bagian = $this->session->userdata('bagian');
		$query = $this->user_cuti->stafCutiCount($bagian);
		$data['stafcuti_count'] = $query->pending;
		$record = $this->db->get("form_cuti");
		$data['records'] = $record->result();

		// Count staf Cuti Lain
		$bagian = $this->session->userdata('bagian');
		$query = $this->user_cuti->stafCutiLainCount($bagian);
		$data['stafcutilain_count'] = $query->pending;
		$record = $this->db->get("formcuti_lain");
		$data['records'] = $record->result();
		// Count Sisa cuti=0
		$bagian = $this->session->userdata('bagian');
		$query = $this->user_cuti->sisaCutiCount($bagian);
		$data['sisacuti_count'] = $query->pending;
		$record = $this->db->get("form_cuti");
		$data['records'] = $record->result();


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
		$this->db->where('username', $username);
		$this->db->update('mst_user');

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
		$data['title'] = 'Cuti Tahunan Staf';
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
		$data['title'] = 'Cuti Lain Staf';
		$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['user_cuti'] = $this->db->get_where('form_cuti', ['id_user' => $this->session->userdata('id')])->result_array();

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
		$nama_kabid = $this->input->post('nama_kabid');
		$alasan_ditolak = $this->input->post('alasan_ditolak');
		$atasan = $nama_atasan;
		$is_approve = $this->input->post('is_approve');

		$this->db->set('nama_kabid', $nama_kabid);
		$this->db->set('atasan', $atasan);
		$this->db->set('alasan_ditolak', $alasan_ditolak);
		$this->db->set('is_approve', $is_approve);
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
		$atasan = $nama_atasan;
		$is_approve = $this->input->post('is_approve');
		$kabag = $this->input->post('kabag');
		$nama_kabag = $this->input->post('nama_kabag');
		$direktur = $this->input->post('direktur');
		$nama_direktur = $this->input->post('nama_direktur');
		$alasan_ditolak = $this->input->post('alasan_ditolak');

		$this->db->set('atasan', $atasan);
		$this->db->set('is_approve', $is_approve);
		$this->db->set('kabag', $kabag);
		$this->db->set('nama_kabag', $nama_kabag);
		$this->db->set('direktur', $direktur);
		$this->db->set('nama_direktur', $nama_direktur);
		$this->db->set('alasan_ditolak', $alasan_ditolak);

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
		$this->load->view('kaur/data/view_cutitahunan', $data);
		$this->load->view('templates/footer');
	}
}
