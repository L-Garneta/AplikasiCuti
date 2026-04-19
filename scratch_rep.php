<?php
$f = 'application/controllers/Kaur.php';
$c = file_get_contents($f);
$c = str_replace(
	"\$this->db->where('username', \$username);\r\n\t\t\$this->db->update('mst_user');", 
	"\$this->db->set('username', \$username);\n\t\t\$this->db->where('id', \$this->session->userdata('id'));\n\t\t\$this->db->update('mst_user');\n\t\t\$this->session->set_userdata('username', \$username);", 
	$c
);
file_put_contents($f, $c);
