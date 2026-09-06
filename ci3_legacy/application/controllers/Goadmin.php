<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Goadmin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('goadmin_model');
        if ($this->session->userdata('role_id') == 1) {
            redirect('superadmin');
        } elseif ($this->session->userdata('role_id') == 2) {
            redirect('admin');
        }
    }

    public function index()
    {
        $this->form_validation->set_rules('useremail', 'Username / Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Login";
            $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
            $this->load->view('goadmin', $data);
        } else {
            $this->goadmin_model->g_login();
        }
    }
}
