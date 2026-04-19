<?php
$f = 'application/controllers/Sdm.php';
$c = file_get_contents($f);
$m = "
    public function edit_profile()
    {
        \$upload_image = \$_FILES['image']['name'];
        if (\$upload_image) {
            \$config['allowed_types'] = 'gif|jpg|png|jpeg';
            \$config['max_size']     = '2048';
            \$config['upload_path'] = './assets/img/profile';
            \$this->load->library('upload', \$config);
            if (\$this->upload->do_upload('image')) {
                \$data['user'] = \$this->db->get_where('mst_user', ['username' => \$this->session->userdata('username')])->row_array();
                \$old_image = \$data['user']['image'];
                if (\$old_image != 'default.jpg') {
                    unlink(FCPATH . 'assets/img/profile/' . \$old_image);
                }

                \$new_image = \$this->upload->data('file_name');
                \$this->db->set('image', \$new_image);
            } else {
                echo \$this->upload->display_errors();
            }
        }
        \$nama =  \$this->input->post('nama');
        \$jabatan =  \$this->input->post('jabatan');
        \$bagian =  \$this->input->post('bagian');
        \$nik = \$this->input->post('nik');
        \$username = \$this->input->post('username');

        \$this->db->set('nama', \$nama);
        \$this->db->set('jabatan', \$jabatan);
        \$this->db->set('bagian', \$bagian);
        \$this->db->set('nik', \$nik);
        \$this->db->set('username', \$username);
        \$this->db->where('id', \$this->session->userdata('id'));
        \$this->db->update('mst_user');
        
        \$this->session->set_userdata('username', \$username);

        \$this->session->set_flashdata('message', 'Simpan Perubahan');
        redirect('sdm/index');
    }
";
$c = preg_replace('/}([\s]*)$/', "\n" . $m . "\n}", $c);
file_put_contents($f, $c);
