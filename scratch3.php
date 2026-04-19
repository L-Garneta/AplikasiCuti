<?php
$file = 'application/controllers/Kaur.php';
$content = file_get_contents($file);

$start = strpos($content, 'public function approvecuti_lain()');
$endFunc = strpos($content, 'public function hapuscuti_lain', $start); 

// Rewrite approvecuti_lain completely
$newFunc = "public function approvecuti_lain()\n\t{\n\t\t\$nama_atasan = \$this->session->userdata('nama');\n\t\t\$id = \$this->input->post('id');\n\t\t\$alasan_ditolak = \$this->input->post('alasan_ditolak');\n\t\t\$status = \$this->input->post('is_approve'); // 0=ACC, 2=TOLAK\n\n\t\t\$this->db->set('atasan', \$nama_atasan);\n\t\t\$this->db->set('alasan_ditolak', \$alasan_ditolak);\n\t\t\$this->db->set('approved_kaur', \$status);\n\t\tif (\$status == 0) {\n\t\t\t\$this->db->set('approved_sdm', 1);\n\t\t\t\$this->db->set('is_approve', 1);\n\t\t} else {\n\t\t\t\$this->db->set('approved_sdm', 2);\n\t\t\t\$this->db->set('is_approve', 2);\n\t\t}\n\n\t\t\$this->db->where('id', \$id);\n\t\t\$this->db->update('formcuti_lain');\n\t\t\$this->session->set_flashdata('message', 'Simpan Data');\n\t\tredirect('kaur/cutilain_staf');\n\t}\n\n\t";

$res = substr($content, 0, $start) . $newFunc . substr($content, $endFunc);
file_put_contents($file, $res);
echo "Done replacing approvecuti_lain in Kaur.php\n";
?>
