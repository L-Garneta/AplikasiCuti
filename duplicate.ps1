$methods = @"

    // ======================================
    // DUPLIKAT DARI SDM 
    // ======================================

    public function list_kary()
    {
        `$data['title'] = 'List Karyawan';
        `$data['user'] = `$this->db->get_where('mst_user', [
            'username' => `$this->session->userdata('username')
        ])->row_array();

        `$data['pegawai'] = `$this->db->get('mst_user')->result_array();

        `$this->load->view('templates/header', `$data);
        `$this->load->view('templates/sidebar', `$data);
        `$this->load->view('templates/topbar', `$data);
        `$this->load->view('kaur/list_kary', `$data);
        `$this->load->view('templates/footer');
    }

    public function view_kary(`$id)
    {
        `$data['title'] = 'Detail Karyawan';
        `$data['user'] = `$this->db->get_where('mst_user', [
            'username' => `$this->session->userdata('username')
        ])->row_array();

        `$this->db->where('mst_user.id', `$id);
        `$this->db->select('*');
        `$this->db->from('mst_user');
        `$this->db->join('data_pegawai', 'data_pegawai.pegawai_id = mst_user.id', 'left');
        `$data['pegawai'] = `$this->db->get()->row_array();

        `$data['keluarga'] = `$this->db->get_where('keluarga_pegawai', ['pegawai_id' => `$id])->result_array();

        `$this->load->view('templates/header', `$data);
        `$this->load->view('templates/sidebar', `$data);
        `$this->load->view('templates/topbar', `$data);
        `$this->load->view('kaur/view_kary', `$data);
        `$this->load->view('templates/footer');
    }

    public function get_user()
    {
        `$id = `$this->input->post('id');
        echo json_encode(`$this->db->get_where('mst_user', ['id' => `$id])->row_array());
    }

    public function add_keluarga()
    {
        `$data = [
            'pegawai_id' => `$this->input->post('pegawai_id'),
            'nama_keluarga' => `$this->input->post('nama_keluarga'),
            'posisi_keluarga' => `$this->input->post('posisi_keluarga'),
            'tempat_lahir' => `$this->input->post('tempat_lahir_keluarga'),
            'tgl_lahir' => `$this->input->post('tgl_lahir_keluarga'),
            'alamat' => `$this->input->post('alamat_keluarga'),
            'telp' => `$this->input->post('telp_keluarga')
        ];
        `$this->db->insert('keluarga_pegawai', `$data);
        `$this->session->set_flashdata('message', 'Data keluarga berhasil ditambah');
        redirect('kaur/list_kary');
    }

    public function list_cuti_kary()
    {
        `$data['title'] = 'List Cuti Karyawan';
        `$data['user'] = `$this->db->get_where('mst_user', [
            'username' => `$this->session->userdata('username')
        ])->row_array();

        `$data['cuti_kary'] = `$this->db->get('form_cuti')->result_array();

        `$this->load->view('templates/header', `$data);
        `$this->load->view('templates/sidebar', `$data);
        `$this->load->view('templates/topbar', `$data);
        `$this->load->view('kaur/list_cuti_kary', `$data);
        `$this->load->view('templates/footer');
    }

    public function list_cuti_diluartanggungan_kary()
    {
        `$data['title'] = 'Cuti Diluar Tanggungan';
        `$data['user'] = `$this->db->get_where('mst_user', [
            'username' => `$this->session->userdata('username')
        ])->row_array();

        `$data['cuti_kary'] = `$this->db->get('formcuti_lain')->result_array();

        `$this->load->view('templates/header', `$data);
        `$this->load->view('templates/sidebar', `$data);
        `$this->load->view('templates/topbar', `$data);
        `$this->load->view('kaur/list_cuti_diluartanggungan_kary', `$data);
        `$this->load->view('templates/footer');
    }

}
"@

$content = Get-Content "application\controllers\Kaur.php" -Raw
$content = $content -replace "\s*}\s*`$", ""
$content = $content + $methods
Set-Content "application\controllers\Kaur.php" $content

# Copy views
Copy-Item "application\views\sdm\list_kary.php" -Destination "application\views\kaur\list_kary.php" -ErrorAction SilentlyContinue
Copy-Item "application\views\sdm\view_kary.php" -Destination "application\views\kaur\view_kary.php" -ErrorAction SilentlyContinue
Copy-Item "application\views\sdm\list_cuti_kary.php" -Destination "application\views\kaur\list_cuti_kary.php" -ErrorAction SilentlyContinue
Copy-Item "application\views\sdm\list_cuti_diluartanggungan_kary.php" -Destination "application\views\kaur\list_cuti_diluartanggungan_kary.php" -ErrorAction SilentlyContinue

(Get-Content "application\views\kaur\list_kary.php") -replace 'sdm/', 'kaur/' | Set-Content "application\views\kaur\list_kary.php"
(Get-Content "application\views\kaur\view_kary.php") -replace 'sdm/', 'kaur/' | Set-Content "application\views\kaur\view_kary.php"
(Get-Content "application\views\kaur\list_cuti_kary.php") -replace 'sdm/', 'kaur/' | Set-Content "application\views\kaur\list_cuti_kary.php"
(Get-Content "application\views\kaur\list_cuti_diluartanggungan_kary.php") -replace 'sdm/', 'kaur/' | Set-Content "application\views\kaur\list_cuti_diluartanggungan_kary.php"
