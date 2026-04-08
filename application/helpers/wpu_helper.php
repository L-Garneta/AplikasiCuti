<?php

function is_logged_in()
{
    $ci = get_instance();

    // cek login
    if (!$ci->session->userdata('username')) {
        redirect('auth');
    }

    $role_id = $ci->session->userdata('role_id');
    $menu = $ci->uri->segment(1);

    // ambil menu dari database
    $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();

    // ✅ CEK DULU ADA ATAU TIDAK
    if (!$queryMenu) {
        return; // biarkan lewat (jangan redirect)
    }

    $menu_id = $queryMenu['id'];

    $userAccess = $ci->db->get_where('user_access_menu', [
        'role_id' => $role_id,
        'menu_id' => $menu_id
    ]);

    if ($userAccess->num_rows() < 1) {
        redirect('auth/blocked');
    }
}


function check_access($role_id, $menu_id)
{
    $ci = get_instance();
    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}
