<?php
defined('BASEPATH') or exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('admin_model', 'adminMod');
		$this->load->model('upload_model', 'uploadMod');
	}

	public function index()
	{
		$data['title'] = "Dashboard";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$data['cb'] = $this->db->get_where('data_cabang', ['id' => $data['user']['penempatan_cabang']])->row_array();
		$data['cabang'] = $this->db->get_where('data_cabang', ['id' => $data['user']['penempatan_cabang']])->row_array();

		$this->load->view('templates/supadmin/header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('admin/index', $data);
		$this->load->view('templates/supadmin/statistik_footer', $data);
	}

	public function statistik_penjualan($id)
    {
        $data['title'] = "Dashboard";
        $data['cabang'] = $this->db->get_where('data_cabang', ['id' => $id])->row_array();
        $data['semua_cabang'] = $this->db->get('data_cabang')->result_array();
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->load->view('templates/supadmin/header', $data);
        $this->load->view('templates/admin/sidebar', $data);
        $this->load->view('supadmin/statistik_penjualan', $data);
        $this->load->view('templates/supadmin/statistik_footer', $data);
	}
	
	public function getStatPendapatan($id)
    {

        header('Content-Type: application/json');
        $data = [];
        date_default_timezone_set('Asia/Jakarta');
        $wdate = date('d-m-Y', strtotime('monday this week'));
        $wdate_to = $wdate;
        $wdate_to = strtotime("+6 days", strtotime($wdate_to));
        $wdate_to = date("d-m-Y", $wdate_to);
        for ($a = 1; $a <= 7; $a++) {
            $query = "SELECT SUM(total_pengeluaran) as total_pengeluaran FROM riwayat_pengeluaran WHERE tanggal_ind BETWEEN '$wdate' AND '$wdate_to' AND hari = '$a' AND id_cabang='$id'";
            $q = $this->db->query($query)->row_array();
            $data[] = $q;
        }
        echo json_encode($data);
    }

    public function getStatPendapatanMonth($id)
    {

        header('Content-Type: application/json');
        $data = [];
        date_default_timezone_set('Asia/Jakarta');
        $wdate = date('d-m-Y', strtotime('monday this week'));
        $wdate_to = $wdate;
        $wdate_to = strtotime("+6 days", strtotime($wdate_to));
        $wdate_to = date("d-m-Y", $wdate_to);
        $Year = date("Y");
        for ($a = 1; $a <= 12; $a++) {
            if($a >= 10){
                $ty = $a;
            }else{
                $ty = '0'.$a;
            }
            $query = "SELECT SUM(total_pengeluaran) as total_pengeluaran FROM riwayat_pengeluaran WHERE single_bulan = '$ty' AND single_tahun = '$Year' AND id_cabang='$id'";
            $q = $this->db->query($query)->row_array();
            $data[] = $q;
        }
        echo json_encode($data);
    }

    public function getStatPendapatanYear($id)
    {

        header('Content-Type: application/json');
        $data = [];
        date_default_timezone_set('Asia/Jakarta');
        $wdate = date('d-m-Y', strtotime('monday this week'));
        $wdate_to = $wdate;
        $wdate_to = strtotime("+6 days", strtotime($wdate_to));
        $wdate_to = date("d-m-Y", $wdate_to);
        for ($a = 0; $a <= 10; $a++) {
            $query = "SELECT SUM(total_pengeluaran) as total_pengeluaran FROM riwayat_pengeluaran WHERE single_tahun = '202$a' AND id_cabang='$id'";
            $q = $this->db->query($query)->row_array();
            $data[] = $q;
        }
        echo json_encode($data);
    }

	public function getStatSell($id)
	{

		header('Content-Type: application/json');
		$data = [];
		date_default_timezone_set('Asia/Jakarta');
		$wdate = date('d-m-Y', strtotime('monday this week'));
		$wdate_to = $wdate;
		$wdate_to = strtotime("+6 days", strtotime($wdate_to)); //-7 days for last week. -30 for last week
		$wdate_to = date("d-m-Y", $wdate_to);
		for ($a = 1; $a <= 7; $a++) {
			$query = "SELECT SUM(total_pembayaran) as total_pembayaran, SUM(pendapatan) as pendapatan FROM riwayat_penjualan WHERE tanggal_ind BETWEEN '$wdate' AND '$wdate_to' AND hari = '$a' AND id_cabang='$id'";
			$q = $this->db->query($query)->row_array();
			$data[] = $q;
			
		}
		echo json_encode($data);
	}

	public function getStatSellMonth($id)
    {

        header('Content-Type: application/json');
        $data = [];
        date_default_timezone_set('Asia/Jakarta');
        $wdate = date('d-m-Y', strtotime('monday this week'));
        $wdate_to = $wdate;
        $wdate_to = strtotime("+6 days", strtotime($wdate_to));
        $wdate_to = date("d-m-Y", $wdate_to);
        $Year = date("Y");
        for ($a = 1; $a <= 12; $a++) {
            if($a >= 10){
                $ty = $a;
            }else{
                $ty = '0'.$a;
            }
            $query = "SELECT SUM(total_pembayaran) as total_pembayaran, SUM(pendapatan) as pendapatan FROM riwayat_penjualan WHERE single_bulan = '$ty' AND single_tahun = '$Year' AND id_cabang='$id'";
            $q = $this->db->query($query)->row_array();
            $data[] = $q;
        }
        echo json_encode($data);
    }
    public function getStatSellYear($id)
    {

        header('Content-Type: application/json');
        $data = [];
        date_default_timezone_set('Asia/Jakarta');
        $wdate = date('d-m-Y', strtotime('monday this week'));
        $wdate_to = $wdate;
        $wdate_to = strtotime("+6 days", strtotime($wdate_to));
        $wdate_to = date("d-m-Y", $wdate_to);
        for ($a = 0; $a <= 10; $a++) {
            $query = "SELECT SUM(total_pembayaran) as total_pembayaran, SUM(pendapatan) as pendapatan FROM riwayat_penjualan WHERE single_tahun = '202$a' AND id_cabang='$id'";
            $q = $this->db->query($query)->row_array();
            $data[] = $q;
        }
        echo json_encode($data);
    }

	public function history_penjualan()
	{
		$data['title'] = "History Penjualan";
		$data['main_title'] = "Laporan";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->db->order_by('id', 'desc');
		$data['data_penjualan'] = $this->db->get_where('riwayat_penjualan', ['id_cabang' => $data['user']['penempatan_cabang']])->result_array();
		$data['data_cabang'] = $this->db->get('data_cabang')->result_array();
		$this->load->view('templates/supadmin/form_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/history_penjualan', $data);
	}

	public function barang()
	{

		$data['title'] = "Data Barang";
		$data['main_title'] = "Barang";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->db->order_by('id', 'desc');
		$data['data_barang'] = $this->db->get_where('barang', ['id_cabang' => $data['user']['penempatan_cabang']])->result_array();
		$this->db->order_by('nama_kategori', 'asc');
		$data['kategori_barang'] = $this->db->get('kategori_barang')->result_array();
		$this->db->order_by('id', 'desc');
		$data['satuan_barang'] = $this->db->get('satuan_barang')->result_array();
		$this->db->order_by('nama_asli', 'asc');
		$data['satuan_barang_inp'] = $this->db->get('satuan_barang')->result_array();
		$data['data_cabang'] = $this->db->get('data_cabang')->result_array();
		$this->load->view('templates/supadmin/form_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/barang', $data);
		$this->load->view('templates/supadmin/form_footer', $data);
	}


	public function stok_barang()
	{
		$data['title'] = "Stok Barang";
		$data['main_title'] = "Barang";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->db->order_by('id', 'desc');
		$data['data_barang'] = $this->db->get_where('barang', ['id_cabang' => $data['user']['penempatan_cabang']])->result_array();
		$data['data_cabang'] = $this->db->get('data_cabang')->result_array();
		$this->load->view('templates/supadmin/table_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/stok_barang', $data);
		$this->load->view('templates/supadmin/table_footer', $data);
	}

	public function tambah_stok_barang()
	{
		$this->adminMod->am_tambah_stok_barang();
	}

	public function jual_barang()
	{
		$data['title'] = "Jual Barang";
		$data['sidebar_mini'] = true;
		$data['main_title'] = "Penjualan";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->db->order_by('nama_barang', 'asc');
		$data['data_barang'] = $this->db->get_where('barang', ['id_cabang' => $data['user']['penempatan_cabang']])->result_array();
		$data['keranjang'] = $this->db->get('keranjang')->result_array();
		$data['jum_keranjang'] = $this->db->get('keranjang')->num_rows();
		$data['data_cabang'] = $this->db->get('data_cabang')->result_array();
		$this->load->view('templates/supadmin/table_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/jual_barang', $data);
		$this->load->view('templates/supadmin/jual_footer', $data);
	}

	public function tambah_beli()
	{
		$this->adminMod->am_tambah_beli();
	}

	public function hapus_data_keranjang()
	{
		$id = $this->input->post('id');
		$this->adminMod->am_hapus_data_keranjang($id);
		echo $this->tampil_keranjang();
	}


	public function checkout()
	{
		$this->adminMod->am_checkout();
		echo $this->tampil_keranjang();
	}

	public function struk_penjualan($id_pembelian)
	{
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['title'] = "Struk Penjualan Barang";
		$data['data_barang'] = $this->db->get_where('riwayat_penjualan', ['id_pembelian' => $id_pembelian])->row_array();
		$data['cabang'] = $this->db->get_where('data_cabang', ['id' => $data['data_barang']['id_cabang']])->row_array();
		$this->load->view('templates/supadmin/cetak_header', $data);
		$this->load->view('supadmin/struk_penjualan', $data);
		// $this->load->view('templates/supadmin/cetak_footer', $data);
	}

	public function struk_penjualan_c($id_pembelian)
	{
		$this->adminMod->am_struk_penjualan_c($id_pembelian);
	}
	public function struk_penjualan_h($id_pembelian)
	{
		$this->adminMod->am_struk_penjualan_h($id_pembelian);
	}

	public function laporan_penjualan()
	{
		$data['title'] = "Laporan Penjualan";
		$data['main_title'] = "Laporan";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->db->order_by('id', 'desc');
		$data['data_penjualan'] = $this->db->get_where('riwayat_penjualan', ['id_cabang' => $data['user']['penempatan_cabang']])->result_array();
		$data['data_cabang'] = $this->db->get('data_cabang')->result_array();
		$this->load->view('templates/supadmin/form_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/data_penjualan', $data);
	}

	public function laporan_penjualan_bulan()
	{
		$data['title'] = "Laporan Penjualan Bulan";
		$data['main_title'] = "Laporan";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->db->order_by('id', 'desc');
		$data['data_penjualan'] = $this->db->get_where('riwayat_penjualan', ['id_cabang' => $data['user']['penempatan_cabang']])->result_array();
		$data['data_cabang'] = $this->db->get('data_cabang')->result_array();
		$this->load->view('templates/supadmin/form_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/data_penjualan_bulan', $data);
	}

	public function laporan_pemasukan()
	{
		$data['title'] = "Masukan";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->db->order_by('id', 'desc');
		$data['data_penjualan'] = $this->db->get('riwayat_penjualan')->result_array();
		$this->load->view('templates/supadmin/form_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/data_penjualan', $data);
		$this->load->view('templates/supadmin/form_footer', $data);
	}

	public function laporan_stok()
	{

		$data['title'] = "Laporan Stok";
		$data['main_title'] = "Laporan";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->db->order_by('id', 'desc');
		$data['data_barang'] = $this->db->get_where('barang', ['id_cabang' => $data['user']['penempatan_cabang']])->result_array();
		$data['data_cabang'] = $this->db->get('data_cabang')->result_array();
		$this->load->view('templates/supadmin/table_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/laporan_stok', $data);
		$this->load->view('templates/supadmin/table_footer', $data);
	}

	public function beli_barang()
	{
		$this->form_validation->set_rules('kode', 'Nama Barang', 'required');
		$this->form_validation->set_rules('nama', 'Nama Barang', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah Barang', 'required');
		$this->form_validation->set_rules('satuan', 'Satuan Barang', 'required');
		$this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required');
		$this->form_validation->set_rules('suplier', 'Suplier', 'required');
		$this->form_validation->set_rules('penempatan', 'Penempatan', 'required');
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "Beli Barang";
			$data['main_title'] = "Pembelian";
			$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
			$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
			$this->db->order_by('nama_suplier', 'asc');
			$data['data_suplier'] = $this->db->get('suplier')->result_array();
			$this->db->order_by('nama_satuan', 'asc');
			$data['satuan_barang_inp'] = $this->db->get('satuan_barang')->result_array();
			$data['jum'] = $this->db->get('riwayat_pembelian')->num_rows();
			$this->load->view('templates/supadmin/form_header', $data);
			$this->load->view('templates/admin/sidebar', $data);
			$this->load->view('supadmin/beli_barang', $data);
			$this->load->view('templates/supadmin/form_footer', $data);
		} else {
			$this->adminMod->am_beli_barang();
		}
	}

	public function data_pembelian()
	{
		$data['title'] = "Data Pembelian";
		$data['main_title'] = "Pembelian";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->db->order_by('id', 'desc');
		$data['data_pembelian'] = $this->db->get_where('riwayat_pembelian', ['id_admin' => $this->session->userdata('id')])->result_array();
		$this->db->order_by('nama_kategori', 'asc');
		$data['kategori_barang'] = $this->db->get('kategori_barang')->result_array();
		$data['data_cabang'] = $this->db->get('data_cabang')->result_array();
		$this->load->view('templates/supadmin/form_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/data_pembelian', $data);
		$this->load->view('templates/supadmin/form_footer', $data);
	}

	public function simpan_barang_kegudang()
	{
		$this->adminMod->am_simpan_barang_kegudang();
	}

	public function laporan_pembelian()
	{
		$data['title'] = "Laporan Pembelian";
		$data['main_title'] = "Laporan";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->db->order_by('id', 'desc');
		$data['data_pembelian'] = $this->db->get_where('riwayat_pembelian', ['id_cabang' => $data['user']['penempatan_cabang']])->result_array();
		$this->db->order_by('nama_kategori', 'asc');
		$data['kategori_barang'] = $this->db->get('kategori_barang')->result_array();
		$data['data_cabang'] = $this->db->get('data_cabang')->result_array();
		$this->load->view('templates/supadmin/form_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/laporan_pembelian', $data);
		$this->load->view('templates/supadmin/form_footer', $data);
	}

	public function tambah_barang()
	{
		$this->form_validation->set_rules('nama', 'Nama Barang', 'required');
		//$this->form_validation->set_rules('kategori', 'Kategori Barang', 'required');
		$this->form_validation->set_rules(
			'barcode',
			'Barcode',
			'required|min_length[12]|max_length[12]',
			[
				'min_length' => 'Barcode minimal 12 digit',
				'max_length' => 'Barcode maksimal 12 digit'
			]
		);
		$this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required');
		$this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required');
		$this->form_validation->set_rules('satuan', 'Satuan Stok', 'required');
		$this->form_validation->set_rules('penempatan', 'Penempatan', 'required');
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "Tambah Barang";
			$data['main_title'] = "Barang";
			$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
			$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
			$this->db->order_by('id', 'desc');
			$data['data_barang'] = $this->db->get('barang')->result_array();
			$this->db->order_by('nama_kategori', 'asc');
			$data['kategori_barang'] = $this->db->get('kategori_barang')->result_array();
			$this->db->order_by('id', 'desc');
			$data['satuan_barang'] = $this->db->get('satuan_barang')->result_array();
			$this->db->order_by('id', 'desc');
			$data['suplier'] = $this->db->get('suplier')->result_array();
			$this->db->order_by('nama_asli', 'asc');
			$data['satuan_barang_inp'] = $this->db->get('satuan_barang')->result_array();
			$data['data_cabang'] = $this->db->get_where('data_cabang', ['id' => $data['user']['penempatan_cabang']])->row_array();
			$this->load->view('templates/supadmin/form_header', $data);
			$this->load->view('templates/admin/sidebar', $data);
			$this->load->view('supadmin/tambah_barang', $data);
			$this->load->view('templates/supadmin/form_footer', $data);
		} else {
			$this->adminMod->am_tambah_barang();
		}
	}

	public function hapus_barang($id)
	{
		$this->adminMod->am_hapus_barang($id);
	}


	public function detail_barang($id)
	{
		$data['title'] = "Detail Barang";
		$data['main_title'] = "Barang";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$data['data_barang'] = $this->db->get_where('barang', ['id' => $id])->row_array();
		$data['suplier'] = $this->db->get_where('suplier', ['id' => $data['data_barang']['id_suplier']])->row_array();
		$data['data_cabang'] = $this->db->get_where('data_cabang', ['id' => $data['data_barang']['id_cabang']])->row_array();
		$this->load->view('templates/supadmin/form_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/detail_barang', $data);
		$this->load->view('templates/supadmin/form_footer', $data);
	}

	public function ubah_barang($id)
	{
		$this->form_validation->set_rules('nama', 'Nama Barang', 'required');
		$this->form_validation->set_rules('kategori', 'Kategori Barang', 'required');
		$this->form_validation->set_rules(
			'barcode',
			'Barcode',
			'required|min_length[12]|max_length[12]',
			[
				'min_length' => 'Barcode minimal 12 digit',
				'max_length' => 'Barcode maksimal 12 digit'
			]
		);
		$this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required');
		$this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required');
		$this->form_validation->set_rules('satuan', 'Satuan Stok', 'required');
		$this->form_validation->set_rules('penempatan', 'Penempatan', 'required');
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "Ubah Barang";
			$data['main_title'] = "Barang";
			$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
			$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
			$this->db->order_by('id', 'desc');
			$data['data_barang'] = $this->db->get_where('barang', ['id' => $id])->row_array();
			$this->db->order_by('nama_kategori', 'asc');
			$data['kategori_barang'] = $this->db->get('kategori_barang')->result_array();
			$this->db->order_by('id', 'desc');
			$data['satuan_barang'] = $this->db->get('satuan_barang')->result_array();
			$this->db->order_by('id', 'desc');
			$data['suplier'] = $this->db->get('suplier')->result_array();
			$this->db->order_by('nama_asli', 'asc');
			$data['satuan_barang_inp'] = $this->db->get('satuan_barang')->result_array();
			$data['data_cabang'] = $this->db->get_where('data_cabang', ['id' => $data['user']['penempatan_cabang']])->row_array();
			$this->load->view('templates/supadmin/form_header', $data);
			$this->load->view('templates/admin/sidebar', $data);
			$this->load->view('supadmin/ubah_barang', $data);
			$this->load->view('templates/supadmin/form_footer', $data);
		} else {
			$this->adminMod->am_ubah_barang($id);
		}
	}

	public function save_keranjang_barcode()
	{
		$this->adminMod->am_save_keranjang_barcode();
	}

	public function cetak_barcode()
	{
		$data['title'] = "Cetak Barcode";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$data['barang'] = $this->db->get_where('barang', ['id_cabang' => $data['user']['penempatan_cabang']])->result_array();
		$data['code_barcodenya'] = $this->input->post('code');
		$this->load->view('templates/supadmin/form_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/cetak_barcode', $data);
		$this->load->view('templates/supadmin/form_footer_bc', $data);
	}

	public function stok_opname()
	{
		$data['title'] = "Stok Opname";
		$data['main_title'] = "Barang";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->db->order_by('id', 'desc');
		$data['stop_opname'] = $this->db->get_where('stok_opname', ['tempat' => $data['user']['penempatan_cabang']])->result_array();
		$data['data_cabang'] = $this->db->get('data_cabang')->result_array();

		$this->load->view('templates/supadmin/form_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/stok_opname', $data);
		$this->load->view('templates/supadmin/form_footer', $data);
	}

	public function tambah_stok_opname()
	{
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('tgl', 'Tanggal', 'required');
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "Tambah Stok Opname";
			$data['main_title'] = "Barang";
			$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
			$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
			$this->db->order_by('nama_suplier', 'asc');
			$data['data_suplier'] = $this->db->get('suplier')->result_array();
			$this->db->order_by('nama_satuan', 'asc');
			$data['satuan_barang_inp'] = $this->db->get('satuan_barang')->result_array();
			$data['jum'] = $this->db->get('stok_opname')->num_rows();
			$data['data_cabang'] = $this->db->get_where('data_cabang', ['id' => $data['user']['penempatan_cabang']])->row_array();
			$this->db->order_by('id', 'desc');
			$data['barang'] = $this->db->get_where('barang', ['id_cabang' => $data['user']['penempatan_cabang']])->result_array();
			$this->load->view('templates/supadmin/form_header', $data);
			$this->load->view('templates/admin/sidebar', $data);
			$this->load->view('supadmin/tambah_stok_opname', $data);
			$this->load->view('templates/supadmin/form_footer', $data);
		} else {
			$this->adminMod->am_tambah_stok_opname();
		}
	}

	public function proses_stok_opname($kode)
	{
		$this->form_validation->set_rules('stok_fisik[]', 'Stok Fisik', 'required');
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "Proses Stok Opname";
			$data['main_title'] = "Barang";
			$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
			$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
			$data['stok_opname'] = $this->db->get_where('stok_opname', ['kode' => $kode])->row_array();
			$data['data_cabang'] = $this->db->get_where('data_cabang', ['id' => $data['stok_opname']['tempat']])->row_array();
			$this->db->order_by('id', 'desc');
			$data['isi_barang'] = $this->db->get_where('isi_stok_opname', ['kode' => $kode])->result_array();
			$this->load->view('templates/supadmin/form_header', $data);
			$this->load->view('templates/admin/sidebar', $data);
			$this->load->view('supadmin/proses_stok_opname', $data);
			$this->load->view('templates/supadmin/form_footer', $data);
		} else {
			$this->adminMod->am_proses_stok_opname($kode);
		}
	}

	public function pesan_stok_barang()
	{
		$this->form_validation->set_rules('kode', 'Kode Barang', 'required');
		$this->form_validation->set_rules('nama', 'Nama Pesanan', 'required');
		$this->form_validation->set_rules('suplier', 'Suplier', 'required');
		$this->form_validation->set_rules('cabang', 'Cabang', 'required');
		$this->form_validation->set_rules('tgl_pesan', 'Tanggal Pesan', 'required');
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "Pesan Stok Barang";
			$data['main_title'] = "Pemesanan";
			$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
			$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
			$this->db->order_by('nama_suplier', 'asc');
			$data['data_suplier'] = $this->db->get('suplier')->result_array();
			$this->db->order_by('nama_satuan', 'asc');
			$data['satuan_barang_inp'] = $this->db->get('satuan_barang')->result_array();
			$data['jum'] = $this->db->get('pesanan_barang')->num_rows();
			$data['data_cabang'] = $this->db->get_where('data_cabang', ['id' => $data['user']['penempatan_cabang']])->row_array();
			$this->db->order_by('id', 'asc');
			$data['barang'] = $this->db->get_where('barang', ['id_cabang' => $data['user']['penempatan_cabang']])->result_array();
			$this->load->view('templates/supadmin/form_header', $data);
			$this->load->view('templates/admin/sidebar', $data);
			$this->load->view('supadmin/pesan_stok_barang', $data);
			$this->load->view('templates/supadmin/form_footer', $data);
		} else {
			$this->adminMod->am_pesan_stok_barang();
		}
	}

	public function data_pesanan()
	{
		$data['title'] = "Data Pesanan";
		$data['main_title'] = "Pemesanan";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->db->order_by('nama_kategori', 'asc');
		$data['kategori_barang'] = $this->db->get('kategori_barang')->result_array();
		$this->db->order_by('id', 'desc');
		$data['data_pesanan'] = $this->db->get_where('pesanan_barang', ['tempat' => $data['user']['penempatan_cabang']])->result_array();
		$data['data_cabang'] = $this->db->get('data_cabang')->result_array();
		$this->load->view('templates/supadmin/form_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/data_pesanan', $data);
		$this->load->view('templates/supadmin/form_footer', $data);
	}

	public function data_pengeluaran()
	{
		$data['title'] = "Data Pengeluaran";
		$data['main_title'] = "Pemesanan";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->db->order_by('id', 'desc');
		$data['riwayat'] = $this->db->get_where('riwayat_pengeluaran', ['id_cabang' => $data['user']['penempatan_cabang'], 'status_bukti !=' => 0])->result_array();
		$data['data_cabang'] = $this->db->get('data_cabang')->result_array();
		$this->load->view('templates/supadmin/form_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/data_pengeluaran', $data);
		$this->load->view('templates/supadmin/form_footer', $data);
	}

	public function tolak_bukti_pengeluaran($kode)
	{
		$this->adminMod->am_tolak_bukti_pengeluaran($kode);
	}

	public function upload_bukti_pengeluaran($kode)
	{
		$this->adminMod->am_upload_bukti_pengeluaran($kode);
	}

	// JUAL BARANG ----------------------------------------------------------------------------------------------------------------------

	function list_barang()
	{
		echo $this->tampil_keranjang();
	}

	function savedata_keranjang()
	{
		$this->adminMod->am_savedata_keranjang();
		echo $this->tampil_keranjang();
	}

	public function tampil_checkout()
	{
		echo $this->isi_tampil_checkout();
	}

	public function hapus_data_pesanan($kode)
	{
		$this->adminMod->am_hapus_data_pesanan($kode);
	}

	    public function hapus_data_pesanan_stok($kode)
    {
        $this->adminMod->am_hapus_data_pesanan_stok($kode);
    }

	public function terima_pesanan($kode)
	{
		$this->adminMod->am_terima_pesanan($kode);
	}

	// JUAL BARANG ----------------------------------------------------------------------------------------------------------------------


	//Tampilan bagian pembayaran di halamann jual barang
	public function isi_tampil_checkout()
	{
		return $this->adminMod->am_isi_tampil_checkout();
	}

	//Tampilan bagian keranjang di halaman jual barang
	function tampil_keranjang()
	{
		return $this->adminMod->am_tampil_keranjang();
	}

	//Ambil data histori penjualan
	function wegot_history()
	{
		return $this->adminMod->am_wegot_history();
	}

	//Cari data histori penjualan
	function search_history()
	{
		$this->adminMod->am_search_history();
	}

	//Data penjualan perhari
	function data_jual_hari()
	{
		return $this->adminMod->am_data_jual_hari();
	}

	//Cari data penjualan perhari
	function search_data_jual_hari()
	{
		$this->adminMod->am_search_data_jual_hari();
	}

	//Data penjualan perbulan
	function data_jual_bulan()
	{
		return $this->adminMod->am_data_jual_bulan();
	}

	//Cari data penjualan perbulan
	function search_data_jual_bulan()
	{
		$this->adminMod->am_search_data_jual_bulan();
	}

	//Ambil data barang untuk halaman jual barang
	public function wegot_data_barang()
	{
		return $this->adminMod->am_wegot_data_barang();
	}

	public function show_penjualan_bulan()
	{
		echo $this->data_jual_bulan();
	}

	public function show_penjualan_hari()
	{
		echo $this->data_jual_hari();
	}

	public function show_history_penjualan()
	{
		echo $this->wegot_history();
	}

	public function show_data_barang()
	{
		echo $this->wegot_data_barang();
	}

	public function ubah_d_keranjang()
	{
		$this->adminMod->am_ubah_d_keranjang();
	}

	public function hapus_stok_opname($kode)
	{
		$this->adminMod->am_hapus_stok_opname($kode);
	}

	public function profile()
	{
		$data['title'] = "Profile";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->load->view('templates/supadmin/header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('lainnya/profile', $data);
		$this->load->view('templates/supadmin/footer', $data);
	}

	public function ubah_password()
	{
		if ($this->session->userdata('role_id') == 3) {
			redirect('admin/profile');
		}
		$this->form_validation->set_rules('pl', 'Password lama', 'required');
		$this->form_validation->set_rules('pb', 'Password baru', 'required|min_length[3]|matches[up]');
		$this->form_validation->set_rules('up', 'Verifikasi password', 'required|min_length[3]|matches[pb]');
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "Ubah Password";
			$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
			$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
			$this->load->view('templates/supadmin/header', $data);
			$this->load->view('templates/admin/sidebar', $data);
			$this->load->view('lainnya/ubah_password', $data);
			$this->load->view('templates/supadmin/footer', $data);
		} else {
			$this->adminMod->am_ubah_password();
		}
	}

	public function ubah_profile()
	{
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "Ubah Profile";
			$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
			$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
			$this->load->view('templates/supadmin/header', $data);
			$this->load->view('templates/admin/sidebar', $data);
			$this->load->view('lainnya/ubah_profile', $data);
			$this->load->view('templates/supadmin/footer', $data);
		} else {
			$this->adminMod->am_ubah_profile();
		}
	}

	function get_autocomplete()
	{
		if (isset($_GET['term'])) {
			$result = $this->adminMod->search_bar($_GET['term']);
			if (count($result) > 0) {
				foreach ($result as $row)
					$arr_result[] = $row->barcode;
				echo json_encode($arr_result);
			}
		}
	}

	//Batas

	public function history_pengeluaran()
	{
		$data['title'] = "History Pengeluaran";
		$data['main_title'] = "Laporan";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->db->order_by('id', 'desc');
		$data['data_penjualan'] = $this->db->get('riwayat_penjualan')->result_array();
		$data['data_cabang'] = $this->db->get('data_cabang')->result_array();
		$this->load->view('templates/supadmin/form_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/history_pengeluaran', $data);
	}

	function get_history_pengeluaran()
	{
		return $this->adminMod->am_history_pengeluaran();
	}

	public function show_history_pengeluaran()
	{
		echo $this->get_history_pengeluaran();
	}

	function search_h_pengeluaran()
	{
		$this->adminMod->am_search_history_pengeluaran();
	}

	public function laporan_pengeluaran()
	{
		$data['title'] = "Laporan Pengeluaran";
		$data['main_title'] = "Laporan";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->db->order_by('id', 'desc');
		$data['data_penjualan'] = $this->db->get('riwayat_penjualan')->result_array();
		$data['data_cabang'] = $this->db->get('data_cabang')->result_array();
		$this->load->view('templates/supadmin/form_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/data_pengeluaran_hari', $data);
	}

	function get_pengeluaran_hari()
	{
		return $this->adminMod->am_data_pengeluaran_hari();
	}

	public function sh_pl_hari()
	{
		echo $this->get_pengeluaran_hari();
	}

	function search_pengeluaran_h()
	{
		$this->adminMod->am_search_data_pengeluaran_hari();
	}

	public function laporan_pengeluaran_bulan()
	{
		$data['title'] = "Laporan Pengeluaran Bulan";
		$data['main_title'] = "Laporan";
		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->db->order_by('id', 'desc');
		$data['data_penjualan'] = $this->db->get('riwayat_penjualan')->result_array();
		$data['data_cabang'] = $this->db->get('data_cabang')->result_array();
		$this->load->view('templates/supadmin/form_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/data_pengeluaran_bulan', $data);
	}

	function get_pengeluaran_bulan()
	{
		return $this->adminMod->am_data_pengeluaran_bulan();
	}

	public function show_pengeluaran_bulan()
	{
		echo $this->get_pengeluaran_bulan();
	}

	function search_data_pengeluaran_bulan()
	{
		$this->adminMod->am_search_data_pengeluaran_bulan();
	}

	public function addUser()
	{
		$this->adminMod->am_addUser();
	}

	public function dinamis_user()
	{
		$this->adminMod->am_dinamis_user();
	}

	public function data_user()
	{

		$this->form_validation->set_rules('nama_user', 'Nama', 'required');
		$this->form_validation->set_rules('id_user', 'Id User', 'required');
		$this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required');
		$this->form_validation->set_rules('alamat_user', 'Alamat', 'required');
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "Data User";
			$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
			$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
			$this->db->order_by('id', 'desc');
			$data['data_user'] = $this->db->get_where('user_langganan', ['penempatan' => $data['user']['penempatan_cabang']])->result_array();
			$this->load->view('templates/supadmin/table_header', $data);
			$this->load->view('templates/admin/sidebar', $data);
			$this->load->view('supadmin/data_user', $data);
		} else {
			$this->adminMod->am_tambah_user();
		}
	}

	public function ubah_user($id)
	{

		$this->form_validation->set_rules('nama_user', 'Nama', 'required');
		$this->form_validation->set_rules('id_user', 'Id User', 'required');
		$this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required');
		$this->form_validation->set_rules('alamat_user', 'Alamat', 'required');
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "Data User";
			$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
			$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
			$this->db->order_by('id', 'desc');
			$data['data_user'] = $this->db->get_where('user_langganan', ['id' => $id])->row_array();
			$this->load->view('templates/supadmin/table_header', $data);
			$this->load->view('templates/admin/sidebar', $data);
			$this->load->view('supadmin/ubah_user', $data);
		} else {
			$this->adminMod->am_ubah_user($id);
		}
	}

	public function hapus_user($id)
	{
		$this->adminMod->am_hapus_user($id);
	}

	public function data_cicilan()
	{
		$data['title'] = "Data Cicilan";
		$data['main_title'] = "Cicilan";
		$data['data_cabang'] = $this->db->get('data_cabang')->result_array();

		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->db->order_by('id', 'desc');
		$data['hutang'] = $this->db->get_where('riwayat_penjualan', ['metode_bayar' => 'cicilan', 'id_cabang' => $data['user']['penempatan_cabang']])->result_array();
		$this->load->view('templates/supadmin/form_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/data_cicilan', $data);
		$this->load->view('templates/supadmin/form_footer', $data);
	}

	public function bayar_cicilan($id)
	{

		$this->form_validation->set_rules('uang', 'Uang', 'required');
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "Bayar Cicilan";
			$data['main_title'] = "Cicilan";
			$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
			$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
			$data['cicilan'] = $this->db->get_where('riwayat_penjualan', ['status_utang' => 1, 'id_pembayaran_cicilan' => $id])->row_array();
			$this->load->view('templates/supadmin/table_header', $data);
			$this->load->view('templates/admin/sidebar', $data);
			$this->load->view('supadmin/bayar_cicilan', $data);
		} else {
			$this->adminMod->sam_bayar_cicilan($id);
		}
	}

	public function log_cicilan()
	{
		$data['title'] = "Log Cicilan";
		$data['main_title'] = "Cicilan";
		$data['data_cabang'] = $this->db->get('data_cabang')->result_array();

		$data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$this->db->order_by('id', 'desc');
		$data['pembayaran'] = $this->db->get_where('pembayaran_cicilan', ['id_cabang' => $data['user']['penempatan_cabang']])->result_array();
		$this->load->view('templates/supadmin/form_header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('supadmin/log_cicilan', $data);
		$this->load->view('templates/supadmin/form_footer', $data);
	}

	public function pesan_barang()
    {
        $this->form_validation->set_rules('kode', 'Kode Barang', 'required');
        $this->form_validation->set_rules('nama', 'Nama Pesanan', 'required');
        $this->form_validation->set_rules('suplier', 'Suplier', 'required');
        $this->form_validation->set_rules('cabang', 'Cabang', 'required');
        $this->form_validation->set_rules('tgl_pesan', 'Tanggal Pesan', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Pesan Barang";
            $data['main_title'] = "Pemesanan";
            $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
            $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
            $this->db->order_by('nama_suplier', 'asc');
            $data['data_suplier'] = $this->db->get('suplier')->result_array();
            $this->db->order_by('nama_satuan', 'asc');
            $data['satuan_barang_inp'] = $this->db->get('satuan_barang')->result_array();
            $this->db->order_by('nama_kategori', 'asc');
            $data['kategori_barang'] = $this->db->get('kategori_barang')->result_array();
            $data['jum'] = $this->db->get('pesanan_barang')->num_rows();
            $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
            $this->db->order_by('id', 'desc');
            $data['barang'] = $this->db->get_where('barang', ['id_cabang' => 1])->result_array();
            $this->load->view('templates/supadmin/form_header', $data);
			$this->load->view('templates/admin/sidebar', $data);
            $this->load->view('supadmin/pesan_barang', $data);
        } else {
            $this->adminMod->sam_pesan_barang();
        }
    }

    public function simpan_barang_sementara()
    {
        $this->adminMod->am_simpan_barang_sementara();
    }

    public function hapus_isi_pesanan_manual()
    {
        $this->adminMod->am_hapus_isi_pesanan_manual();
    }

    public function ubah_p_keranjang()
    {
        $this->adminMod->am_ubah_p_keranjang();
    }

    function list_pesanan_barang()
    {
        echo $this->adminMod->sam_pesanan_manual();
    }

	public function terima_pesanan_barang($id)
    {
        $this->form_validation->set_rules('kode', 'Kode Barang', 'required');
        $this->form_validation->set_rules('nama', 'Nama Pesanan', 'required');
        $this->form_validation->set_rules('suplier', 'Suplier', 'required');
        $this->form_validation->set_rules('cabang', 'Cabang', 'required');
        $this->form_validation->set_rules('tgl_pesan', 'Tanggal Pesan', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Terima Pesan Barang";
            $data['main_title'] = "Pemesanan";
            $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
            $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
            $this->db->order_by('id', 'decs');
            $data['barang'] = $this->db->get_where('pesanan_manual', ['kode' => $id])->result_array();
            $data['pesan'] = $this->db->get_where('pesanan_barang', ['kode' => $id])->row_array();
            $this->load->view('templates/supadmin/table_header', $data);
			$this->load->view('templates/admin/sidebar', $data);
            $this->load->view('supadmin/terima_pesanan_barang', $data);
            $this->load->view('templates/supadmin/table_footer', $data);
        } else {
            $this->adminMod->am_pesan_barang();
        }
    }

    public function simpan_jual_barang()
    {
		$this->adminMod->am_simpan_jual_barang();
    }
	public function logout()
	{
		$data = [
			'id',
			'nama',
			'email',
			'role_id'
		];
		$this->session->unset_userdata($data);
		redirect('goadmin');
	}
}
