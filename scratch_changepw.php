<?php
$f = 'application/controllers/Sdm.php';
$c = file_get_contents($f);
$m = "
    public function changepassword()
    {
        \$current_password = \$this->input->post('current_password');
        \$new_password = \$this->input->post('new_password1');

        if (\$current_password == \$new_password) {
            \$this->session->set_flashdata('msg', '<div class=\"alert alert-danger font-weight-bolder text-center\" role=\"alert\">Password baru tidak boleh sama dengan password lama</div>');
            redirect('sdm/index');
        } else {
            \$password_hash = password_hash(\$new_password, PASSWORD_DEFAULT);
            \$this->db->set('password', \$password_hash);
            \$this->db->where('username', \$this->session->userdata('username'));
            \$this->db->update('mst_user');
            \$this->session->set_flashdata('message', 'Simpan Perubahan');
            redirect('sdm/index');
        }
    }
";
$c = preg_replace('/}([\s]*)$/', "\n" . $m . "\n}", $c);
file_put_contents($f, $c);
