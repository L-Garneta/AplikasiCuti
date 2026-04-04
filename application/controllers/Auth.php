<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'E-Cuti Login System';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/index');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->db->get_where('mst_user', ['username' => $username])->row_array();
        if ($user) {
            if ($user['is_active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'nama' => $user['nama'],
                        'username' => $user['username'],
                        'nik' => $user['nik'],
                        'id' => $user['id'],
                        'bagian' => $user['bagian'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } elseif ($user['role_id'] == 2) {
                        redirect('sdm');
                    } elseif ($user['role_id'] == 3) {
                        redirect('kaur');
                    } else {
                        redirect('staf');
                    }
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">Password salah</div>');
                    redirect('auth/index');
                }
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">User tidak aktif</div>');
                redirect('auth/index');
            }
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">Username dan Password tidak sesuai</div>');
            redirect('auth/index');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('bagian');
        $this->session->unset_userdata('nik');
        $this->session->set_flashdata('message', 'Logout');
        redirect('auth/index');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}
