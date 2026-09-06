<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Not_found extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
    }

    public function index()
    {
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $this->load->view('not_found', $data);
    }
}
