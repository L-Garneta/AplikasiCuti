<?php
$file = 'application/controllers/Kaur.php';
$content = file_get_contents($file);

$start_pos = strpos($content, 'public function index()');
if ($start_pos !== false) {
    // Find the next public function to accurately determine the end of index()
    $next_func_pos = strpos($content, 'public function profile()', $start_pos);
    if ($next_func_pos !== false) {
        $before = substr($content, 0, $start_pos);
        $after = substr($content, $next_func_pos);
        
        $new_index = "public function index()\n\t{\n\t\t\$data['title'] = 'Beranda';\n\t\t\$data['user'] = \$this->db->get_where('mst_user', ['username' => \$this->session->userdata('username')])->row_array();\n\n\t\t\$data['count_cuti_tahunan'] = \$this->db->where('is_approve', 0)->count_all_results('form_cuti');\n\t\t\$data['count_cuti_luartanggungan'] = \$this->db->where('is_approve', 0)->count_all_results('formcuti_lain');\n\t\t\$data['count_cuti_ditolak'] = \$this->db->where('is_approve', 2)->count_all_results('form_cuti');\n\t\t\$data['count_user'] = \$this->db->count_all('mst_user');\n\t\t\$data['pegawai'] = \$this->db->get('mst_user')->result_array();\n\n\t\t\$this->load->view('templates/header', \$data);\n\t\t\$this->load->view('templates/sidebar', \$data);\n\t\t\$this->load->view('templates/topbar', \$data);\n\t\t\$this->load->view('kaur/index', \$data);\n\t\t\$this->load->view('templates/footer');\n\t}\n\n\t";
        
        file_put_contents($file, $before . $new_index . $after);
        echo "Successfully replaced index function.\n";
    } else {
        echo "Could not find profile function.\n";
    }
} else {
    echo "Could not find index function.\n";
}
?>
