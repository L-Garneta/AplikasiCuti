<?php
function appendMethod($file, $method) {
    if (!file_exists($file)) return;
    $content = file_get_contents($file);
    $content = preg_replace("/\s*}\s*$/", "", $content); // remove last brace
    file_put_contents($file, $content . "\n\n" . $method . "\n}");
}

// SDM Methods
$sdm_methods = "
    public function detail_cuti(\$id)
    {
        \$data['title'] = 'Detail Cuti Bulanan';
        \$data['user'] = \$this->db->get_where('mst_user', ['username' => \$this->session->userdata('username')])->row_array();
        \$data['cuti_pegawai'] = \$this->db->get_where('form_cuti', ['id' => \$id])->result_array();
        
        \$this->load->view('templates/header', \$data);
        \$this->load->view('templates/sidebar', \$data);
        \$this->load->view('templates/topbar', \$data);
        \$this->load->view('sdm/detail_cuti', \$data);
        \$this->load->view('templates/footer');
    }

    public function detail_cuti_diluartanggungan(\$id)
    {
        \$data['title'] = 'Detail Cuti Lain';
        \$data['user'] = \$this->db->get_where('mst_user', ['username' => \$this->session->userdata('username')])->row_array();
        \$data['cuti_pegawai'] = \$this->db->get_where('formcuti_lain', ['id' => \$id])->result_array();
        
        \$this->load->view('templates/header', \$data);
        \$this->load->view('templates/sidebar', \$data);
        \$this->load->view('templates/topbar', \$data);
        \$this->load->view('sdm/detail_cuti_diluartanggungan', \$data);
        \$this->load->view('templates/footer');
    }
";

// KAUR Methods
$kaur_methods = "
    public function detail_cuti(\$id)
    {
        \$data['title'] = 'Detail Cuti Bulanan';
        \$data['user'] = \$this->db->get_where('mst_user', ['username' => \$this->session->userdata('username')])->row_array();
        \$data['cuti_pegawai'] = \$this->db->get_where('form_cuti', ['id' => \$id])->result_array();
        
        \$this->load->view('templates/header', \$data);
        \$this->load->view('templates/sidebar', \$data);
        \$this->load->view('templates/topbar', \$data);
        \$this->load->view('kaur/detail_cuti', \$data);
        \$this->load->view('templates/footer');
    }

    public function detail_cuti_diluartanggungan(\$id)
    {
        \$data['title'] = 'Detail Cuti Lain';
        \$data['user'] = \$this->db->get_where('mst_user', ['username' => \$this->session->userdata('username')])->row_array();
        \$data['cuti_pegawai'] = \$this->db->get_where('formcuti_lain', ['id' => \$id])->result_array();
        
        \$this->load->view('templates/header', \$data);
        \$this->load->view('templates/sidebar', \$data);
        \$this->load->view('templates/topbar', \$data);
        \$this->load->view('kaur/detail_cuti_diluartanggungan', \$data);
        \$this->load->view('templates/footer');
    }
";

appendMethod('application/controllers/Sdm.php', $sdm_methods);
appendMethod('application/controllers/Kaur.php', $kaur_methods);

// One tiny UI fix for Sdm / Kaur detail UI badge labels. Let's make sure it doesn't say "Approval Kaur" literally if we want it to say "SDM"
// But it's okay if not perfectly replaced. We did not replace the detail_cuti texts yet.

echo "Methods injected.\n";
?>
