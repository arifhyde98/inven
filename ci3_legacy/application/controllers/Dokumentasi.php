<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokumentasi extends CI_Controller
{

    public function index()
    {
        $data['title'] = "Dokumentasi";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $this->load->view('dokumentasi/header', $data);
        $this->load->view('dokumentasi/sidebar', $data);
        $this->load->view('dokumentasi/index', $data);
        $this->load->view('templates/supadmin/chart_footer', $data);
    }
    
    public function pemesanan()
    {
        $data['title'] = "Pemesanan";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $this->load->view('dokumentasi/header', $data);
        $this->load->view('dokumentasi/sidebar', $data);
        $this->load->view('dokumentasi/pemesanan', $data);
        $this->load->view('templates/supadmin/chart_footer', $data);
    }

    public function jual_barang()
    {
        $data['title'] = "Jual Barang";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $this->load->view('dokumentasi/header', $data);
        $this->load->view('dokumentasi/sidebar', $data);
        $this->load->view('dokumentasi/jual_barang', $data);
        $this->load->view('templates/supadmin/chart_footer', $data);
    }

    public function cetak_barcode()
    {
        $data['title'] = "Cetak Barcode";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $this->load->view('dokumentasi/header', $data);
        $this->load->view('dokumentasi/sidebar', $data);
        $this->load->view('dokumentasi/cetak_barcode', $data);
        $this->load->view('templates/supadmin/chart_footer', $data);
    }
    
    public function stok_opname()
    {
        $data['title'] = "Stok Opname";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $this->load->view('dokumentasi/header', $data);
        $this->load->view('dokumentasi/sidebar', $data);
        $this->load->view('dokumentasi/stok_opname', $data);
        $this->load->view('templates/supadmin/chart_footer', $data);
    }

    public function data_cicilan()
    {
        $data['title'] = "Data Cicilan";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $this->load->view('dokumentasi/header', $data);
        $this->load->view('dokumentasi/sidebar', $data);
        $this->load->view('dokumentasi/data_cicilan', $data);
        $this->load->view('templates/supadmin/chart_footer', $data);
    }

    public function penjelasan()
    {
        $data['title'] = "Penjelasan";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $this->load->view('dokumentasi/header', $data);
        $this->load->view('dokumentasi/sidebar', $data);
        $this->load->view('dokumentasi/penjelasan', $data);
        $this->load->view('templates/supadmin/chart_footer', $data);
    }

}
