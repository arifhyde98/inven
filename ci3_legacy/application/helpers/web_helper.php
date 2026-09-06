<?php

function is_logged_in()
{
    $ci = get_instance();

    if (!$ci->session->userdata('id')) {
        redirect('goadmin');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        $userAkses = $ci->db->get_where('akses_menu', ['role_id' => $role_id, 'menu_id' => $menu_id]);

        if ($userAkses->num_rows() < 1) {
            redirect('blocked');
        }
    }
}


function check_access($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('akses_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function bad_word_filter()
{
    $words = [
        'anjing',
        'kontol',
        'memek',
        'memec',
        'jembud',
        'tolol',
        'babi',
        'goblog',
        'nigga',
        'nigger',
        'nibbas',
        'hideng',
        'hideung',
        'hiddeng',
        'isis',
        'babi'
    ];
    return $words;
}

function rupiah($angka)
{
    $hasil_rupiah = number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

function rupiah2($angka)
{
    $hasil_rupiah = number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}
