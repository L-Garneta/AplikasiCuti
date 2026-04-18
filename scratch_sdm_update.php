<?php
$methods = "

\tpublic function cutilain_sdm()
\t{
\t\t\$data['title'] = 'Approval Cuti (Menikah, Melahirkan, dll)';
\t\t\$data['user'] = \$this->db->get_where('mst_user', ['username' => \$this->session->userdata('username')])->row_array();
\t\t
\t\t// PJK Tahap 2: Menunggu yang sudah diapprove KAUR (SDM Tahap1)
\t\t\$this->db->where('approved_kaur', 0); // Sudah di ACC SDM Tahap 1
\t\t\$this->db->where('approved_sdm', 1);  // Pending PJK
\t\t\$this->db->order_by('id', 'DESC');
\t\t\$data['cuti'] = \$this->db->get('formcuti_lain')->result_array();

\t\t\$this->load->view('templates/header', \$data);
\t\t\$this->load->view('templates/sidebar', \$data);
\t\t\$this->load->view('templates/topbar', \$data);
\t\t\$this->load->view('sdm/approval/cutilain_sdm', \$data);
\t\t\$this->load->view('templates/footer');
\t}

\tpublic function approve_cutilain_sdm()
\t{
\t\t\$nama_direktur = \$this->session->userdata('nama');
\t\t\$id = \$this->input->post('id');
\t\t\$alasan_ditolak = \$this->input->post('alasan_ditolak');
\t\t\$status = \$this->input->post('is_approve'); // 0=ACC, 2=TOLAK

\t\t\$this->db->set('nama_direktur', \$nama_direktur);
\t\tif (\$status == 2) {
\t\t\t\$this->db->set('alasan_ditolak', \$alasan_ditolak);
\t\t}
\t\t
\t\t\$this->db->set('approved_sdm', \$status);
\t\t\$this->db->set('is_approve', \$status);

\t\t\$this->db->where('id', \$id);
\t\t\$this->db->update('formcuti_lain');

\t\t\$this->session->set_flashdata('message', 'Approval Penanggung Jawab Klinik berhasil');
\t\tredirect('sdm/cutilain_sdm');
\t}
}
";

$file = 'application/controllers/Sdm.php';
$content = file_get_contents($file);
$content = preg_replace("/\s*}\s*$/", "", $content); // remove last brace
file_put_contents($file, $content . $methods);

// Create view for cutilain_sdm
$viewContent = file_get_contents('application/views/sdm/approval/cuti_sdm.php');
// Needs to remove the button "Approval Cuti Lain" from the Cuti Lain page itself (no looping)
$viewContent = preg_replace('/<a href="[^"]+" class="btn btn-primary btn-sm float-right">[^<]+<\/a>/', '', $viewContent);
// Form action
$viewContent = str_replace('sdm/approve_cuti_sdm', 'sdm/approve_cutilain_sdm', $viewContent);

// Cuti Lain has jenis_cuti, so let's try to add it. But for safety, using the exact same structure as cuti_sdm is usually fine, or we can see what formcuti_lain has. formcuti_lain has 'jenis_cuti'.
$viewContent = str_replace('<th>Cuti</th>', '<th>Jenis Cuti</th><th>Cuti</th>', $viewContent);
$viewContent = str_replace('<td><?= format_indo($c[\'cuti\']); ?></td>', '<td><?= $c[\'jenis_cuti\']; ?></td><td><?= format_indo($c[\'cuti\']); ?></td>', $viewContent);

file_put_contents('application/views/sdm/approval/cutilain_sdm.php', $viewContent);

// One more detail, the header title in Sdm::cuti_sdm needs to be exactly "Approval Cuti Bulanan (Jatah Sebulan Sekali)"
$fileSdm = 'application/controllers/Sdm.php';
$contentSdm = file_get_contents($fileSdm);
$contentSdm = str_replace("\$data['title'] = 'Approval Penanggung Jawab Klinik';", "\$data['title'] = 'Approval Cuti Bulanan (Jatah Sebulan Sekali)';", $contentSdm);
file_put_contents($fileSdm, $contentSdm);

echo "SDM Controller & Views updated.\n";
?>
