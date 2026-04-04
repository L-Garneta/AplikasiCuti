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

            $data['title'] = 'Beranda';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['bagian'] = $this->sdm->getBagian();
            $data['count_cuti_tahunan'] = $this->sdm->countCutiTahunan();
            $data['count_cuti_luartanggungan'] = $this->sdm->countCutiLuarTanggungan();
            $data['count_cuti_ditolak'] = $this->sdm->countCutiDitolak();
            $data['count_user'] = $this->sdm->countUser();
            $data['pegawai'] = $this->sdm->getUser();
            $data['kode_nik'] = $this->sdm->getKodeNik();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('sdm/index', $data);
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'nama' => $this->input->post('nama', true),
                'jabatan' => $this->input->post('jabatan', true),
                'bagian' => $this->input->post('bagian', true),
                'nik' => $this->input->post('nik', true),
                'image' => 'default.jpg',
                'role_id' => $this->input->post('role_id', true),
                'date_created' => date('Y-m-d'),
                'username' => $this->input->post('username', true),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'is_active' => 1
            );
            $this->db->insert('mst_user', $data);
            $this->session->set_flashdata('message', 'Tambah data');
            redirect('sdm/index');
        }
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
        $nama = $this->input->post('nama');
        $jabatan = $this->input->post('jabatan');
        $bagian = $this->input->post('bagian');
        $username = $this->input->post('username');

        $this->db->set('nama', $nama);
        $this->db->set('jabatan', $jabatan);
        $this->db->set('bagian', $bagian);
        $this->db->where('username', $username);
        $this->db->update('mst_user');

        $this->session->set_flashdata('message', 'Update data');
        redirect('sdm/index');
    }

    public function changePassword()
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

    public function get_user()
    {
        $id = $this->input->post('id');
        echo json_encode($this->db->get_where('mst_user', ['id' => $id])->row_array());
    }

    public function edit_user()
    {
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $jabatan = $this->input->post('jabatan');
        $nik = $this->input->post('nik');
        $bagian = $this->input->post('bagian');
        $is_active = $this->input->post('is_active');
        $role_id = $this->input->post('role_id');

        $this->db->set('nama', $nama);
        $this->db->set('jabatan', $jabatan);
        $this->db->set('nik', $nik);
        $this->db->set('bagian', $bagian);
        $this->db->set('is_active', $is_active);
        $this->db->set('role_id', $role_id);

        $this->db->where('id', $id);
        $this->db->update('mst_user');
        $this->session->set_flashdata('message', 'Simpan Perubahan');
        redirect('sdm/index');
    }

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
            'keterangan' => 'Karyawan Baru',
            'input' => date('Y-m-d'),
            'cuti' => date('Y-m-d'),
            'cuti2' => date('Y-m-d'),
            'masuk' => date('Y-m-d')
        ];
        $this->db->insert('form_cuti', $data);
        $this->session->set_flashdata('message', 'Simpan data');
        redirect('sdm/index');
    }

    public function list_kary()
    {
        $this->form_validation->set_rules('pegawai_id', 'Nama Pegawai', 'required|trim|is_unique[data_pegawai.pegawai_id]', array(
            'is_unique' => 'Sudah ada data Pegawai'
        ));
        if ($this->form_validation->run() == false) {

            $data['title'] = 'List Karyawan';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['pegawai'] = $this->sdm->getKaryawan();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('sdm/list_kary', $data);
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'pegawai_id' => $this->input->post('pegawai_id', true),
                'nama_sekolah' => $this->input->post('nama_sekolah', true),
                'telp' => $this->input->post('telp', true),
                'jurusan' => $this->input->post('jurusan', true),
                'tahun_lulus' => $this->input->post('tahun_lulus', true),
                'nama_jenjang' => $this->input->post('nama_jenjang', true),
                'kota_lahir' => $this->input->post('kota_lahir', true),
                'tgl_lahir' => $this->input->post('tgl_lahir', true),
                'agama' => $this->input->post('agama', true),
                'status_nikah' => $this->input->post('status_nikah', true),
                'jenis_kelamin' => $this->input->post('jenis_kelamin', true),
                'gol_darah' => $this->input->post('gol_darah', true),
                'alamat' => $this->input->post('alamat', true)
            );
            $this->db->insert('data_pegawai', $data);
            $this->session->set_flashdata('message', 'Simpan Data');
            redirect('sdm/list_kary');
        }
    }

    public function view_kary($id)
    {
        $this->form_validation->set_rules('pegawai_id', 'Nama Pegawai', 'required|trim|is_unique[data_pegawai.pegawai_id]', array(
            'is_unique' => 'Sudah ada data Pegawai'
        ));
        if ($this->form_validation->run() == false) {

            $data['title'] = 'Detail Karyawan';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['pegawai'] = $this->sdm->getDetailPegawai($id);
            $data['keluarga'] = $this->db->get_where('data_keluarga', ['karyawan_id' => $id])->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('sdm/view_kary', $data);
            $this->load->view('templates/footer');
        } else {
            $pegawai_id = $this->input->post('pegawai_id');
            $id_karyawan = $this->input->post('id_karyawan');
            $nama_sekolah = $this->input->post('nama_sekolah');
            $telp = $this->input->post('telp');
            $jurusan = $this->input->post('jurusan');
            $tahun_lulus = $this->input->post('tahun_lulus');
            $nama_jenjang = $this->input->post('nama_jenjang');
            $kota_lahir = $this->input->post('kota_lahir');
            $tgl_lahir = $this->input->post('tgl_lahir');
            $agama = $this->input->post('agama');
            $status_nikah = $this->input->post('status_nikah');
            $jenis_kelamin = $this->input->post('jenis_kelamin');
            $gol_darah = $this->input->post('gol_darah');
            $alamat = $this->input->post('alamat');

            $this->db->set('nama_sekolah', $nama_sekolah);
            $this->db->set('telp', $telp);
            $this->db->set('jurusan', $jurusan);
            $this->db->set('tahun_lulus', $tahun_lulus);
            $this->db->set('nama_jenjang', $nama_jenjang);
            $this->db->set('kota_lahir', $kota_lahir);
            $this->db->set('tgl_lahir', $tgl_lahir);
            $this->db->set('agama', $agama);
            $this->db->set('status_nikah', $status_nikah);
            $this->db->set('jenis_kelamin', $jenis_kelamin);
            $this->db->set('gol_darah', $gol_darah);
            $this->db->set('alamat', $alamat);

            $this->db->where('id_karyawan', $id_karyawan);
            $this->db->update('data_pegawai');
            $this->session->set_flashdata('message', 'Simpan Perubahan');
            redirect('sdm/view_kary/' . $pegawai_id);
        }
    }

    public function add_keluarga()
    {
        $data = array(
            'karyawan_id' => $this->input->post('pegawai_id', true),
            'nama_keluarga' => $this->input->post('nama_keluarga', true),
            'posisi_keluarga' => $this->input->post('posisi_keluarga', true),
            'tempat_lahir_keluarga' => $this->input->post('tempat_lahir_keluarga', true),
            'tgl_lahir_keluarga' => $this->input->post('tgl_lahir_keluarga', true),
            'alamat_keluarga' => $this->input->post('alamat_keluarga', true),
            'telp_keluarga' => $this->input->post('telp_keluarga', true)
        );
        $this->db->insert('data_keluarga', $data);
        $this->session->set_flashdata('message', 'Simpan Data');
        redirect('sdm/list_kary');
    }

    public function edit_kary($nik)
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('bagian', 'Bagian', 'required|trim');
        $this->form_validation->set_rules('kota_lahir', 'Kota', 'required|trim');
        $this->form_validation->set_rules('tgl_lahir', 'Tgl Lahir', 'required|trim');
        $this->form_validation->set_rules('agama', 'Agama', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Edit Karyawan';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['pegawai'] = $this->db->get_where('sdm', ['nik' => $nik])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('sdm/edit_kary', $data);
            $this->load->view('templates/footer');
        } else {
            $id_pegawai = $this->input->post('id_pegawai');
            $nik = $this->input->post('nik');
            $nama = $this->input->post('nama');
            $bagian = $this->input->post('bagian');
            $jabatan = $this->input->post('jabatan');
            $nama_sekolah = $this->input->post('nama_sekolah');
            $jurusan = $this->input->post('jurusan');
            $tahun_lulus = $this->input->post('tahun_lulus');
            $nama_jenjang = $this->input->post('nama_jenjang');
            $kota_lahir = $this->input->post('kota_lahir');
            $tgl_lahir = $this->input->post('tgl_lahir');
            $agama = $this->input->post('agama');
            $status_nikah = $this->input->post('status_nikah');
            $jenis_kelamin = $this->input->post('jenis_kelamin');
            $gol_darah = $this->input->post('gol_darah');
            $alamat = $this->input->post('alamat');

            $this->db->set('id_pegawai', $id_pegawai);
            $this->db->set('nama', $nama);
            $this->db->set('bagian', $bagian);
            $this->db->set('jabatan', $jabatan);
            $this->db->set('nama_sekolah', $nama_sekolah);
            $this->db->set('jurusan', $jurusan);
            $this->db->set('tahun_lulus', $tahun_lulus);
            $this->db->set('nama_jenjang', $nama_jenjang);
            $this->db->set('kota_lahir', $kota_lahir);
            $this->db->set('tgl_lahir', $tgl_lahir);
            $this->db->set('agama', $agama);
            $this->db->set('status_nikah', $status_nikah);
            $this->db->set('jenis_kelamin', $jenis_kelamin);
            $this->db->set('gol_darah', $gol_darah);
            $this->db->set('alamat', $alamat);
            $this->db->where('nik', $nik);
            $this->db->update('sdm');

            $this->session->set_flashdata('message', 'Update data');
            redirect('sdm/detail_kary/' . $nik);
        }
    }


    public function list_cuti_kary()
    {
        $data['title'] = 'List Cuti Karyawan';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['cuti_kary'] = $this->sdm->getListCuti();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sdm/list_cuti_kary', $data);
        $this->load->view('templates/footer');
    }

    public function detail_cuti($id)
    {
        $data['title'] = 'Detail Cuti';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['cuti_pegawai'] = $this->db->get_where('form_cuti', ['id' => $id])->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sdm/detail_cuti', $data);
        $this->load->view('templates/footer');
    }

    public function list_tunggu_cuti_kary()
    {
        $data['title'] = 'List Pending Cuti Karyawan';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['cuti_kary'] = $this->sdm->getListCutiPending();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sdm/list_tunggu_cuti_kary', $data);
        $this->load->view('templates/footer');
    }

    public function list_tunggu_cuti_diluartanggungan_kary()
    {
        $data['title'] = 'List Pending Cuti Lain Karyawan';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['cuti_kary'] = $this->sdm->getListCutiPendingLuarTanggungan();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sdm/list_tunggu_cuti_diluartanggungan_kary', $data);
        $this->load->view('templates/footer');
    }

    public function list_cuti_diluartanggungan_kary()
    {
        $data['title'] = 'List Cuti Lain Karyawan';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['cuti_kary'] = $this->sdm->getListCutiLuarTanggungan();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sdm/list_cuti_diluartanggungan_kary', $data);
        $this->load->view('templates/footer');
    }

    public function detail_cuti_diluartanggungan($id)
    {
        $data['title'] = 'Detail Cuti Diluar Tanggungan';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['cuti_pegawai'] = $this->db->get_where('formcuti_lain', ['id' => $id])->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sdm/detail_cuti_diluartanggungan', $data);
        $this->load->view('templates/footer');
    }

    public function list_cuti_ditolak()
    {
        $data['title'] = 'List Cuti Ditolak Karyawan';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['cuti_kary'] = $this->sdm->getListCutiDitolak();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sdm/list_cuti_ditolak', $data);
        $this->load->view('templates/footer');
    }

    public function cuti_kaur()
    {
        $data['title'] = 'Cuti Tahunan Staf';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['staf_cuti'] = $this->sdm->getListCutiStaf();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sdm/approval/cuti_kaur', $data);
        $this->load->view('templates/footer');
    }

    public function get_cuti_kaur()
    {
        $id = $this->input->post('id');
        echo json_encode($this->db->get_where('form_cuti', ['id' => $id])->row_array());
    }

    public function approve_cuti_kaur()
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
        redirect('sdm/cuti_kaur');
    }


    public function cuti_lain_kaur()
    {
        $data['title'] = 'Cuti Lain Staf';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['staf_cuti_lain'] = $this->sdm->getListCutiLainStaf();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sdm/approval/cutilain_kaur', $data);
        $this->load->view('templates/footer');
    }

    public function get_cutilain_staf()
    {
        $id = $this->input->post('id');
        echo json_encode($this->db->get_where('formcuti_lain', ['id' => $id])->row_array());
    }

    public function approvecuti_lain_kaur()
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
        redirect('sdm/cuti_lain_kaur');
    }
}
