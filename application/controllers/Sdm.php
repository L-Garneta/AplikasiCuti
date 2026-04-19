<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sdm extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('Sdm_model', 'sdm');
        $this->load->helper('tglindo');
    }
public function index()
{
    $data['title'] = 'Beranda';
    $data['user'] = $this->db->get_where('mst_user', [
        'username' => $this->session->userdata('username')
    ])->row_array();

    // 🔥 TAMBAHAN (STATISTIK DASHBOARD)
    $data['count_cuti_tahunan'] = $this->db
        ->where('is_approve', 0)
        ->count_all_results('form_cuti');

    $data['count_cuti_luartanggungan'] = $this->db
        ->where('is_approve', 0)
        ->count_all_results('formcuti_lain');

    $data['count_cuti_ditolak'] = $this->db
        ->where('is_approve', 2)
        ->count_all_results('form_cuti');

    $data['count_user'] = $this->db
        ->count_all('mst_user');

    // data lain
    $data['pegawai'] = $this->db->get('mst_user')->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('sdm/index', $data);
    $this->load->view('templates/footer');
}
public function list_kary()
{
    $data['title'] = 'List Karyawan';
    $data['user'] = $this->db->get_where('mst_user', [
        'username' => $this->session->userdata('username')
    ])->row_array();

    // 🔥 AMBIL DATA PEGAWAI (BUKAN CUTI)
    $data['pegawai'] = $this->db->get('mst_user')->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('sdm/list_kary', $data);
    $this->load->view('templates/footer');
}
    // ==========================
    // INPUT CUTI (DEFAULT)
    // ==========================
    public function input_cuti()
    {
        $data = [
            'id_user' => $this->input->post('id_user'),
            'nik' => $this->input->post('nik'),
            'role_id' => $this->input->post('role_id'),
            'nama' => $this->input->post('nama'),
            'bagian' => $this->input->post('bagian'),
            'jabatan' => $this->input->post('jabatan'),
            'sisa_cuti' => $this->input->post('sisa_cuti'),
            'keterangan' => 'Pengajuan Cuti',
            'input' => date('Y-m-d'),
            'cuti' => $this->input->post('cuti'),
            'cuti2' => $this->input->post('cuti2'),
            'masuk' => $this->input->post('masuk'),

            // 🔥 STATUS AWAL (SEMUA PENDING)
            'approved_sdm' => 1,
            'approved_kaur' => 1,
            'is_approve' => 1
        ];

        $this->db->insert('form_cuti', $data);
        $this->session->set_flashdata('message', 'Pengajuan cuti berhasil');
        redirect('staf/cuti'); // arahkan ke halaman staf
    }

    // ==========================
    // LIST CUTI KAUR (TAHAP 1)
    // ==========================
    public function cuti_kaur()
    {
        $data['title'] = 'Approval KAUR';
        $data['user'] = $this->db->get_where('mst_user', [
            'username' => $this->session->userdata('username')
        ])->row_array();

        // 🔥 Tahap 1: hanya yang pending KAUR
        $this->db->where('approved_kaur', 1);
        $this->db->where('approved_sdm', 1); // masih tahap awal
        $data['cuti'] = $this->db->get('form_cuti')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sdm/approval/cuti_kaur', $data);
        $this->load->view('templates/footer');
    }

    // ==========================
    // APPROVAL KAUR (TAHAP 1)
    // ==========================
    public function approve_cuti_kaur()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('is_approve'); // 0=ACC, 2=TOLAK

        // update KAUR
        $this->db->set('approved_kaur', $status);

        if ($status == 0) {
            // ✅ KAUR ACC -> Lanjut ke SDM
            $this->db->set('approved_sdm', 1); // biarkan pending SDM
            $this->db->set('is_approve', 1);   // belum final
        } else {
            // ❌ KAUR TOLAK -> Langsung Final Tolak
            $this->db->set('approved_sdm', 2);
            $this->db->set('is_approve', 2);
        }

        $this->db->where('id', $id);
        $this->db->update('form_cuti');

        $this->session->set_flashdata('message', 'Approval KAUR berhasil');
        redirect('sdm/cuti_kaur');
    }

    // ==========================
    // LIST CUTI SDM (TAHAP 2)
    // ==========================
    public function cuti_sdm()
    {
        $data['title'] = 'Approval Cuti Bulanan (Jatah Sebulan Sekali)';
        $data['user'] = $this->db->get_where('mst_user', [
            'username' => $this->session->userdata('username')
        ])->row_array();

        // 🔥 Tahap 2: hanya muncul kalau KAUR sudah ACC (approved_kaur = 0) dan SDM masih pending (approved_sdm = 1)
        $this->db->where('approved_kaur', 0);
        $this->db->where('approved_sdm', 1);
        $data['cuti'] = $this->db->get('form_cuti')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sdm/approval/cuti_sdm', $data);
        $this->load->view('templates/footer');
    }

    // ==========================
    // APPROVAL SDM (FINAL)
    // ==========================
    public function approve_cuti_sdm()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('is_approve'); // 0=ACC, 2=TOLAK

        // update SDM
        $this->db->set('approved_sdm', $status);

        if ($status == 0) {
            // ✅ SDM ACC -> Final Diterima
            $this->db->set('is_approve', 0);
        } else {
            // ❌ SDM TOLAK -> Final Ditolak
            $this->db->set('is_approve', 2);
        }

        $this->db->where('id', $id);
        $this->db->update('form_cuti');

        $this->session->set_flashdata('message', 'Approval Penanggung Jawab Klinik berhasil');
        redirect('sdm/cuti_sdm');
    }

    public function list_cuti_kary()
    {
        $data['title'] = 'List Cuti Karyawan';
    $data['user'] = $this->db->get_where('mst_user', [
        'username' => $this->session->userdata('username')
    ])->row_array();

    $data['cuti_kary'] = $this->db->get('form_cuti')->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('sdm/list_cuti_kary', $data);
    $this->load->view('templates/footer');
}
public function list_tunggu_cuti_kary()
{
    $data['title'] = 'Cuti Pending';
    $data['user'] = $this->db->get_where('mst_user', [
        'username' => $this->session->userdata('username')
    ])->row_array();

    $this->db->where('is_approve', 1); // pending
    $data['cuti_kary'] = $this->db->get('form_cuti')->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('sdm/list_tunggu_cuti_kary', $data);
    $this->load->view('templates/footer');
}
public function list_cuti_ditolak()
{
    $data['title'] = 'Cuti Ditolak';
    $data['user'] = $this->db->get_where('mst_user', [
        'username' => $this->session->userdata('username')
    ])->row_array();

    $this->db->where('is_approve', 2);
    $data['cuti_kary'] = $this->db->get('form_cuti')->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('sdm/list_cuti_ditolak', $data);
    $this->load->view('templates/footer');
}
public function list_cuti_diluartanggungan_kary()
{
    $data['title'] = 'Cuti Diluar Tanggungan';
    $data['user'] = $this->db->get_where('mst_user', [
        'username' => $this->session->userdata('username')
    ])->row_array();

    $data['cuti_kary'] = $this->db->get('formcuti_lain')->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('sdm/list_cuti_diluartanggungan_kary', $data);
    $this->load->view('templates/footer');
    }

	public function cutilain_sdm()
	{
		$data['title'] = 'Approval Cuti (Menikah, Melahirkan, dll)';
		$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
		
		// PJK Tahap 2: Menunggu yang sudah diapprove KAUR (SDM Tahap1)
		$this->db->where('approved_kaur', 0); // Sudah di ACC SDM Tahap 1
		$this->db->where('approved_sdm', 1);  // Pending PJK
		$this->db->order_by('id', 'DESC');
		$data['cuti'] = $this->db->get('formcuti_lain')->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('sdm/approval/cutilain_sdm', $data);
		$this->load->view('templates/footer');
	}

	public function approve_cutilain_sdm()
	{
		$nama_direktur = $this->session->userdata('nama');
		$id = $this->input->post('id');
		$alasan_ditolak = $this->input->post('alasan_ditolak');
		$status = $this->input->post('is_approve'); // 0=ACC, 2=TOLAK

		$this->db->set('nama_direktur', $nama_direktur);
		if ($status == 2) {
			$this->db->set('alasan_ditolak', $alasan_ditolak);
		}
		
		$this->db->set('approved_sdm', $status);
		$this->db->set('is_approve', $status);

		$this->db->where('id', $id);
		$this->db->update('formcuti_lain');

		$this->session->set_flashdata('message', 'Approval Penanggung Jawab Klinik berhasil');
		redirect('sdm/cutilain_sdm');
	}


    public function detail_cuti($id)
    {
        $data['title'] = 'Detail Cuti Bulanan';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['cuti_pegawai'] = $this->db->get_where('form_cuti', ['id' => $id])->result_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sdm/detail_cuti', $data);
        $this->load->view('templates/footer');
    }

    public function detail_cuti_diluartanggungan($id)
    {
        $data['title'] = 'Detail Cuti Lain';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['cuti_pegawai'] = $this->db->get_where('formcuti_lain', ['id' => $id])->result_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sdm/detail_cuti_diluartanggungan', $data);
        $this->load->view('templates/footer');
    }



    public function edit_profile()
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
        redirect('sdm/index');
    }



    public function changepassword()
    {
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password1');

        if ($current_password == $new_password) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger font-weight-bolder text-center" role="alert">Password baru tidak boleh sama dengan password lama</div>');
            redirect('sdm/index');
        } else {
            $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $this->db->set('password', $password_hash);
            $this->db->where('username', $this->session->userdata('username'));
            $this->db->update('mst_user');
            $this->session->set_flashdata('message', 'Simpan Perubahan');
            redirect('sdm/index');
        }
    }

}