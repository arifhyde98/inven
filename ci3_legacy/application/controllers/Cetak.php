<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cetak extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('supadmin_model', 'sup_admin');
        $this->load->model('upload_model', 'uploadMod');
    }
    public function bukti_pesanan($kode)
    {
        $data['title'] = "Cetak Bukti Pembelian";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['pesanan'] = $this->db->get_where('pesanan_barang', ['kode' => $kode])->row_array();
        $data['isi_pesanan'] = $this->db->get_where('isi_pesanan_barang', ['kode' => $data['pesanan']['kode']])->result_array();
        $data['sp'] = $this->db->get_where('suplier', ['id_suplier' => $data['pesanan']['suplier']])->row_array();
        $data['cb'] = $this->db->get_where('data_cabang', ['id' => $data['pesanan']['tempat']])->row_array();
        $this->load->view('templates/supadmin/cetak_header', $data);
        $this->load->view('supadmin/cetak/c_data_pesanan', $data);
        $this->load->view('templates/supadmin/cetak_footer', $data);
    }

    public function history_penjualan()
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $data['title'] = "Cetak History Penjualan";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $this->db->order_by('id', 'desc');
        $data['history'] =  $this->db->get('riwayat_penjualan')->result_array();
        $this->load->view('templates/supadmin/cetak_header', $data);
        $this->load->view('supadmin/cetak/c_history_penjualan', $data);
        $this->load->view('templates/supadmin/cetak_footer', $data);
    }

    public function history_penjualan_c($id)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $data['title'] = "Cetak History Penjualan";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $this->db->order_by('id', 'desc');
        $data['history'] =  $this->db->get_where('riwayat_penjualan', ['id_cabang' => $id])->result_array();
        $data['cabang'] = $this->db->get_where('data_cabang', ['id' =>  $id])->row_array();
        $this->load->view('templates/supadmin/cetak_header', $data);
        $this->load->view('supadmin/cetak/c_history_penjualan_c', $data);
        $this->load->view('templates/supadmin/cetak_footer', $data);
    }

    public function data_penjualan($kode)
    {
        $data['title'] = "Cetak Data Penjualan";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['penjualan'] = $this->db->get_where('riwayat_penjualan', ['id_pembelian' => $kode])->row_array();
        $data['cb'] = $this->db->get_where('data_cabang', ['id' => $data['penjualan']['id_cabang']])->row_array();
        $this->load->view('templates/supadmin/cetak_header', $data);
        $this->load->view('supadmin/cetak/c_data_penjualan', $data);
        $this->load->view('templates/supadmin/cetak_footer', $data);
    }


    public function struk_penjualan($id_pembelian)
    {
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['title'] = "Struk Penjualan Barang";
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $data['data_barang'] = $this->db->get_where('riwayat_penjualan', ['id_pembelian' => $id_pembelian])->row_array();
        $data['cabang'] = $this->db->get_where('data_cabang', ['id' => $data['data_barang']['id_cabang']])->row_array();
        $this->load->view('templates/supadmin/cetak_header', $data);
        $this->load->view('supadmin/struk_penjualan', $data);
        $this->load->view('templates/supadmin/cetak_footer', $data);
    }

    public function laporan_penjualan_hari()
    {

        $data['title'] = "Cetak Laporan Penjualan Perhari";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $this->db->order_by('id', 'desc');
        $data['data_barang'] = $this->db->get('barang')->result_array();
        $this->load->view('templates/supadmin/cetak_header', $data);
        $this->load->view('supadmin/cetak/c_laporan_penjualan', $data);
        $this->load->view('templates/supadmin/cetak_footer', $data);
    }


    public function laporan_penjualan_bulan()
    {
        $data['title'] = "Cetak Laporan Penjualan Perbulan";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['data_barang'] = $this->db->get('barang')->result_array();
        $this->load->view('templates/supadmin/cetak_header', $data);
        $this->load->view('supadmin/cetak/c_laporan_penjualan_b', $data);
        $this->load->view('templates/supadmin/cetak_footer', $data);
    }

    public function laporan_pengeluaran()
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $data['title'] = "Cetak Laporan Penjualan";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $this->db->order_by('id', 'desc');
        $data['pengeluaran'] = $this->db->get_where('riwayat_pengeluaran', ['status_bukti !=' => 0])->result_array();
        $this->load->view('templates/supadmin/cetak_header', $data);
        $this->load->view('supadmin/cetak/c_laporan_pengeluaran', $data);
        $this->load->view('templates/supadmin/cetak_footer', $data);
    }

    public function laporan_pengeluaran_c($id)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $data['title'] = "Cetak Laporan Pengeluaran";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $this->db->order_by('id', 'desc');
        $data['pengeluaran'] = $this->db->get_where('riwayat_pengeluaran', ['status_bukti !=' => 0, 'id_cabang' => $id])->result_array();

        $this->load->view('templates/supadmin/cetak_header', $data);
        $this->load->view('supadmin/cetak/c_laporan_pengeluaran_c', $data);
        $this->load->view('templates/supadmin/cetak_footer', $data);
    }

    public function laporan_pengeluaran_hari()
    {

        $data['title'] = "Cetak Laporan pengeluaran Hari";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->load->view('templates/supadmin/cetak_header', $data);
        $this->load->view('supadmin/cetak/c_laporan_pengeluaran_h', $data);
        $this->load->view('templates/supadmin/cetak_footer', $data);
    }

    public function laporan_pengeluaran_bulan()
    {
        $data['title'] = "Cetak Laporan Pengeluaran Perbulan";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['data_barang'] = $this->db->get('barang')->result_array();
        $this->load->view('templates/supadmin/cetak_header', $data);
        $this->load->view('supadmin/cetak/c_laporan_pengeluaran_b', $data);
        $this->load->view('templates/supadmin/cetak_footer', $data);
    }

    public function laporan_stok()
    {
        $data['title'] = "Cetak Laporan Stok";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $this->db->order_by('id', 'desc');
        $data['data_barang'] = $this->db->get('barang')->result_array();
        $this->load->view('templates/supadmin/cetak_header', $data);
        $this->load->view('supadmin/cetak/c_laporan_stok', $data);
        $this->load->view('templates/supadmin/cetak_footer', $data);
    }

    public function laporan_stok_c()
    {
        $data['title'] = "Cetak Laporan Stok";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $this->db->order_by('id', 'desc');
        $this->load->view('templates/supadmin/cetak_header', $data);
        $this->load->view('supadmin/cetak/c_laporan_stok_cab', $data);
        $this->load->view('templates/supadmin/cetak_footer', $data);
    }

    public function detail_stok($id)
    {
        $data['title'] = "Cetak Detail Laporan Stok";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['data_barang'] = $this->db->get_where('barang', ['id' => $id])->row_array();
        $this->load->view('templates/supadmin/cetak_header', $data);
        $this->load->view('supadmin/cetak/c_detail_stok', $data);
        $this->load->view('templates/supadmin/cetak_footer', $data);
    }

    public function barcode_semua()
    {
        $data['title'] = "Cetak Barcode Semua Barang";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        if ($data['user']['role_id'] == 1) {
            $data['barang'] = $this->db->get('barang')->result_array();
        } else {
            $data['barang'] = $this->db->get_where('barang', ['id_cabang' => $data['user']['penempatan_cabang']])->result_array();
        }
        $data['code_barcodenya'] = $this->input->post('code');
        $this->load->view('templates/supadmin/cetak_header', $data);
        $this->load->view('supadmin/cetak/c_barcode_semuaBarang', $data);
        $this->load->view('templates/supadmin/cetak_footer', $data);
    }


    public function stok_opname($kode)
    {
        $data['title'] = "Cetak Stok Opname";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['stok_opname'] = $this->db->get_where('stok_opname', ['kode' => $kode])->row_array();
        $this->db->order_by('id', 'desc');
        $data['isi_stok'] = $this->db->get_where('isi_stok_opname', ['kode' => $data['stok_opname']['kode']])->result_array();
        $data['cb'] = $this->db->get_where('data_cabang', ['id' => $data['stok_opname']['tempat']])->row_array();
        $this->load->view('templates/supadmin/cetak_header', $data);
        $this->load->view('supadmin/cetak/c_stok_opname', $data);
        $this->load->view('templates/supadmin/cetak_footer', $data);
    }


    public function struk_pembayaran_cicilan($id_cicilan)
    {
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['title'] = "Struk Pembayaran Cicilan";
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $data['data_barang'] = $this->db->get_where('riwayat_penjualan', ['id_pembayaran_cicilan' => $id_cicilan])->row_array();
        $data['cicilan'] = $this->db->get_where('pembayaran_cicilan', ['id_cicilan' => $data['data_barang']['id_pembayaran_cicilan']])->result_array();
        $data['cabang'] = $this->db->get_where('data_cabang', ['id' => $data['data_barang']['id_cabang']])->row_array();
        $this->load->view('templates/supadmin/cetak_header', $data);
        $this->load->view('supadmin/struk_pembayaran_cicilan', $data);
        $this->load->view('templates/supadmin/cetak_footer', $data);
    }

    public function data_cicilan($kode)
    {
        $data['title'] = "Cetak Data Cicilan";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['penjualan'] = $this->db->get_where('riwayat_penjualan', ['id_pembayaran_cicilan' => $kode])->row_array();
        $data['cb'] = $this->db->get_where('data_cabang', ['id' => $data['penjualan']['id_cabang']])->row_array();
        $data['cicilan'] = $this->db->get_where('pembayaran_cicilan', ['id_cicilan' => $data['penjualan']['id_pembayaran_cicilan']])->result_array();
        $this->load->view('templates/supadmin/cetak_header', $data);
        $this->load->view('supadmin/cetak/c_data_cicilan', $data);
        $this->load->view('templates/supadmin/cetak_footer', $data);
    }
}
