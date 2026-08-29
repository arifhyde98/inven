<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Superadmin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('supadmin_model', 'sup_admin');
        $this->load->model('upload_model', 'uploadMod');
    }

    public function index()
    {
        $data['title'] = "Dashboard";
        $cabang = $this->db->get('data_cabang')->result_array();
        foreach ($cabang as $row) {
            $jum_barang = $this->db->get_where('barang', ['id_cabang' => $row['id']])->num_rows();
            $this->db->set('jumlah_barang', $jum_barang);
            $this->db->where('id', $row['id']);
            $this->db->update('data_cabang');
        }

        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $data['cabang'] = $this->db->get('data_cabang')->result_array();
        $this->load->view('templates/supadmin/header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/index', $data);
        $this->load->view('templates/supadmin/chart_footer', $data);
    }

    public function statistik_penjualan($id)
    {
        $data['title'] = "Dashboard";
        $data['cabang'] = $this->db->get_where('data_cabang', ['id' => $id])->row_array();
        $data['semua_cabang'] = $this->db->get('data_cabang')->result_array();
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->load->view('templates/supadmin/header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/statistik_penjualan', $data);
        $this->load->view('templates/supadmin/statistik_footer', $data);
    }

    public function getStatBarang()
    {
        header('Content-Type: application/json');

        $sqlQuery = "SELECT * FROM data_cabang";

        $result = $this->db->query($sqlQuery)->result();

        $data = array();
        foreach ($result as $row) {
            $data[] = $row;
        }

        echo json_encode($data);
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
        $wdate_to = strtotime("+6 days", strtotime($wdate_to));
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

    public function admin()
    {

        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('penempatan', 'Penempatan', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[3]|matches[conf_password]');
        $this->form_validation->set_rules('conf_password', 'Konfirmasi Password', 'required|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Data Admin";
            $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
            $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
            $this->db->order_by('id', 'desc');
            $data['data_admin'] = $this->db->get_where('user', ['role_id' => 2])->result_array();
            $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
            $this->load->view('templates/supadmin/table_header', $data);
            $this->load->view('templates/supadmin/sidebar', $data);
            $this->load->view('supadmin/admin', $data);
            $this->load->view('templates/supadmin/table_footer', $data);
        } else {
            $this->sup_admin->sam_tambah_admin();
        }
    }

    public function ubah_admin()
    {
        $this->sup_admin->sam_ubah_admin();
    }

    public function blokir_admin($id)
    {
        $this->sup_admin->sam_blokir_admin($id);
    }

    public function aktifkan_admin($id)
    {
        $this->sup_admin->sam_aktifkan_admin($id);
    }

    public function hapus_admin($id)
    {
        $this->sup_admin->sam_hapus_admin($id);
    }

    public function barang()
    {
        $data['title'] = "Data Barang";
        $data['main_title'] = "Barang";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('id', 'desc');
        $data['data_barang'] = $this->db->get('barang')->result_array();
        $this->db->order_by('nama_kategori', 'asc');
        $data['kategori_barang'] = $this->db->get('kategori_barang')->result_array();
        $this->db->order_by('id', 'desc');
        $data['satuan_barang'] = $this->db->get('satuan_barang')->result_array();
        $this->db->order_by('nama_asli', 'asc');
        $data['satuan_barang_inp'] = $this->db->get('satuan_barang')->result_array();
        $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
        $this->load->view('templates/supadmin/form_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/barang', $data);
        $this->load->view('templates/supadmin/form_footer', $data);
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
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/detail_barang', $data);
        $this->load->view('templates/supadmin/form_footer', $data);
    }

    public function tes()
    {
        $t = $this->db->get_where('barang', ['id' => 109])->row_array();
        $tt = $t['exp_date'];
        $tgl = substr($tt,0,2);
        $bln = substr($tt,3,2);
        $thn = substr($tt,6,12);
        $tgl_lengkap = $thn."-".$bln."-".$tgl;
        echo $tgl_lengkap;




        $a = "SELECT DATE_ADD('$tgl_lengkap', INTERVAL -60 DAY) AS tomorow";
        $a = $this->db->query($a)->row_array();
        $rr =  $a['tomorow'];
        echo "<br>".$rr;
        $thn_baru = substr($rr,0,4);
        $bln_baru = substr($rr,4,3);
        $tgl_baru = substr($rr,8,9);
        $tgl_lengkap_baru = $tgl_baru."".$bln_baru."-".$thn_baru;

        $baru = "SELECT * FROM barang WHERE exp_date BETWEEN '$tgl_lengkap_baru' AND '$tgl_lengkap' AND id = '109'";
        $baru = $this->db->query($baru)->row_array();
        echo "<br>";
        echo $baru['nama_barang'];
    }
    public function save_keranjang_barcode()
    {
        $this->sup_admin->sam_save_keranjang_barcode();
    }

    public function cetak_barcode()
    {
        $data['title'] = "Cetak Barcode";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $data['barang'] = $this->db->get('barang')->result_array();
        $data['code_barcodenya'] = $this->input->post('code');

        $this->load->view('templates/supadmin/form_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/cetak_barcode', $data);
        $this->load->view('templates/supadmin/form_footer_bc', $data);
    }

    public function ambil_barcode()
    {
        $code = $this->input->post('code');
        echo $code;
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
            $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
            $this->load->view('templates/supadmin/form_header', $data);
            $this->load->view('templates/supadmin/sidebar', $data);
            $this->load->view('supadmin/tambah_barang', $data);
            $this->load->view('templates/supadmin/form_footer', $data);
        } else {
            $this->sup_admin->sam_tambah_barang();
        }
    }

    public function ubah_barang($id)
    {
        $this->form_validation->set_rules('nama', 'Nama Barang', 'required');
        $this->form_validation->set_rules(
            'barcode',
            'Barcode',
            'required|min_length[12]|max_length[12]',
            [
                'min_length' => 'Barcode minimal 12 digit',
                'max_length' => 'Barcode maksimal 12 digit'
            ]
        );
        $this->form_validation->set_rules('kategori', 'Kategori Barang', 'required');
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
            $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
            $this->load->view('templates/supadmin/form_header', $data);
            $this->load->view('templates/supadmin/sidebar', $data);
            $this->load->view('supadmin/ubah_barang', $data);
            $this->load->view('templates/supadmin/form_footer', $data);
        } else {
            $this->sup_admin->sam_ubah_barang($id);
        }
    }

    public function hapus_barang($id)
    {
        $this->sup_admin->sam_hapus_barang($id);
    }

    public function tambah_kategori_barang()
    {
        $this->sup_admin->sam_tambah_kategori_barang();
    }

    public function ubah_kategori_barang()
    {
        $this->sup_admin->sam_ubah_kaategori_barang();
    }

    public function hapus_kategori_barang($id)
    {
        $this->sup_admin->sam_hapus_kategori_barang($id);
    }

    public function tambah_satuan_barang()
    {
        $this->sup_admin->sam_tambah_satuan_barang();
    }

    public function ubah_satuan_barang()
    {
        $this->sup_admin->sam_ubah_satuan_barang();
    }

    public function hapus_satuan_barang($id)
    {
        $this->sup_admin->sam_hapus_satuan_barang($id);
    }


    public function stok_barang()
    {

        $data['title'] = "Stok Barang";
        $data['main_title'] = "Barang";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('id', 'desc');
        $data['data_barang'] = $this->db->get('barang')->result_array();
        $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
        $this->load->view('templates/supadmin/table_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/stok_barang', $data);
        $this->load->view('templates/supadmin/table_footer', $data);
    }
    public function log_in_out()
    {

        $data['title'] = "Log In Out";
        $data['main_title'] = "Barang";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('id', 'desc');
        $data['data_barang'] = $this->db->get('barang')->result_array();
        $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
        $this->db->order_by('id', 'desc');
        $data['in_out'] = $this->db->get_where('stok_barang', ['in_out' => 1])->result_array();
        $this->load->view('templates/supadmin/table_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/log_in_out', $data);
        $this->load->view('templates/supadmin/table_footer', $data);
    }

    public function hapus_in_out($id)
    {
        $this->sup_admin->sam_hapus_in_out($id);
    }

    public function tambah_stok_barang()
    {
        $this->sup_admin->sam_tambah_stok_barang();
    }

    public function jual_barang()
    {
        $data['title'] = "Jual Barang";
        $data['sidebar_mini'] = true;
        $data['main_title'] = "Penjualan";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('nama_barang', 'asc');
        $data['data_barang'] = $this->db->get_where('barang', ['id_cabang' => 1])->result_array();
        $data['keranjang'] = $this->db->get('keranjang')->result_array();
        $data['jum_keranjang'] = $this->db->get('keranjang')->num_rows();
        $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
        $this->load->view('templates/supadmin/table_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/jual_barang', $data);
        $this->load->view('templates/supadmin/jual_footer', $data);
    }

    // JUAL BARANG ----------------------------------------------------------------------------------------------------------------------

    function list_barang()
    {
        echo $this->tampil_keranjang();
    }


    function savedata_keranjang()
    {
        $this->sup_admin->sam_savedata_keranjang();
        echo $this->tampil_keranjang();
    }

    function skurd()
    {
        $id_barang = $this->input->post('id_barang', true);
        $id_cabang = $this->input->post('id_cabang', true);
        $jml = $this->input->post('jml', true);
        $satuan = $this->input->post('satuan', true);
        $data = [
            'id_barang' => $id_barang,
            'id_cabang' => $id_cabang,
            'jumlah' => $jml,
            'satuan' => $satuan,
            'harga' => 123,
            'profit' => 1234,
            'harga_total' => 12345,
            'id_pembelian' => 1,
            'id_user' =>  $this->session->userdata('id')
        ];

        $this->db->insert('keranjang', $data);
        echo $this->tampil_keranjang();
    }

    public function tampil_checkout()
    {
        echo $this->isi_tampil_checkout();
    }

    public function tambah_beli()
    {
        $this->sup_admin->sam_tambah_beli();
    }

    public function hapus_data_keranjang()
    {
        $id = $this->input->post('id');
        $this->sup_admin->sam_hapus_data_keranjang($id);
        echo $this->tampil_keranjang();
    }

    public function checkout()
    {
        $this->sup_admin->sam_checkout();
        echo $this->tampil_keranjang();
    }

    public function struk_penjualan_c($id_pembelian)
    {
        $this->sup_admin->sam_struk_penjualan_c($id_pembelian);
    }
    public function struk_penjualan_h($id_pembelian)
    {
        $this->sup_admin->sam_struk_penjualan_h($id_pembelian);
    }

    // JUAL BARANG ----------------------------------------------------------------------------------------------------------------------

    public function isi_tampil_checkout()
    {
        return $this->sup_admin->sam_isi_tampil_checkout();
    }

    function tampil_keranjang()
    {
        return $this->sup_admin->sam_tampil_keranjang();
    }

    //History Penjualan
    function wegot_history()
    {
        return $this->sup_admin->sam_wegot_history();
    }

    //History penjualan percabang
    function wegot_history_percabang($id)
    {
        return $this->sup_admin->sam_wegot_history_percabang($id);
    }

    //Cari data history penjualan pertanggal
    function search_history()
    {
        $this->sup_admin->sam_search_history();
    }

    //Cari data history penjualan pertanggal percabang
    function search_history_percabang($id)
    {
        $this->sup_admin->sam_search_history_percabang($id);
    }

    //Data penjualan perhari
    function data_jual_hari()
    {
        return $this->sup_admin->sam_data_jual_hari();
    }

    //Data penjualan perhari percabang
    function data_jual_hari_cabang($id)
    {
        return $this->sup_admin->sam_data_jual_hari_cabang($id);
    }

    //Cari data penjualan perhari
    function search_data_jual_hari()
    {
        $this->sup_admin->sam_search_data_jual_hari();
    }

    //Cari data penjualan perhari percabang
    function search_data_jual_hari_cabang($id)
    {
        $this->sup_admin->sam_search_data_jual_hari_cabang($id);
    }

    //Data penjualan perbulan
    function data_jual_bulan()
    {
        return $this->sup_admin->sam_data_jual_bulan();
    }

    //Data penjualan perbulan percabang
    function data_jual_bulan_cabang($id)
    {
        return $this->sup_admin->sam_data_jual_bulan_cabang($id);
    }

    //Cari data penjualan perbulan
    function search_data_jual_bulan()
    {
        $this->sup_admin->sam_search_data_jual_bulan();
    }

    //Cari data penjualan perbulan percabang 
    function search_data_jual_bulan_cabang($id)
    {
        $this->sup_admin->sam_search_data_jual_bulan_cabang($id);
    }

    //Ambil  data barang
    public function wegot_data_barang()
    {
        return $this->sup_admin->sam_wegot_data_barang();
    }

    //Ambil data barang percabang
    public function wegot_data_barang_cabang($id)
    {
        return $this->sup_admin->sam_wegot_data_barang_cabang($id);
    }


    public function show_history_penjualan()
    {
        echo $this->wegot_history();
    }


    public function show_data_barang()
    {
        echo $this->wegot_data_barang();
    }

    // public function show_data_barang_cabang($id)
    // {
    //     echo $this->wegot_data_barang_cabang($id);
    // }

    public function show_penjualan_hari()
    {
        echo $this->data_jual_hari();
    }

    public function show_penjualan_bulan()
    {
        echo $this->data_jual_bulan();
    }

    public function show_penjualan_bulan_cabang($id)
    {
        echo $this->data_jual_bulan_cabang($id);
    }

    public function show_penjualan_hari_cabang($id)
    {
        echo $this->data_jual_hari_cabang($id);
    }

    public function show_history_penjualan_percabang($id)
    {
        echo $this->wegot_history_percabang($id);
    }

    public function ubah_d_keranjang()
    {
        $this->sup_admin->sam_ubah_d_keranjang();
    }


    public function laporan_penjualan()
    {
        $data['title'] = "Laporan Penjualan";
        $data['main_title'] = "Laporan";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('id', 'desc');
        $data['data_penjualan'] = $this->db->get('riwayat_penjualan')->result_array();
        $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
        $this->load->view('templates/supadmin/form_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/data_penjualan', $data);
    }

    public function laporan_penjualan_bulan()
    {
        $data['title'] = "Laporan Penjualan Bulan";
        $data['main_title'] = "Laporan";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('id', 'desc');
        $data['data_penjualan'] = $this->db->get('riwayat_penjualan')->result_array();
        $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
        $this->load->view('templates/supadmin/form_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/data_penjualan_bulan', $data);
    }

    public function history_penjualan()
    {
        $data['title'] = "History Penjualan";
        $data['main_title'] = "Laporan";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('id', 'desc');
        $data['data_penjualan'] = $this->db->get('riwayat_penjualan')->result_array();
        $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
        $this->load->view('templates/supadmin/form_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/history_penjualan', $data);
    }

    public function laporan_penjualan_hari()
    {
        $data['title'] = "Laporan Penjualan Filter Hari";
        $data['main_title'] = "Laporan";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('id', 'desc');
        $data['data_penjualan'] = $this->db->get('riwayat_penjualan')->result_array();
        $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
        $this->load->view('templates/supadmin/form_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/laporan_penjualan_hari', $data);
        $this->load->view('templates/supadmin/form_footer', $data);
    }

    public function laporan_pemasukan()
    {
        $data['title'] = "Masukan";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('id', 'desc');
        $data['data_penjualan'] = $this->db->get('riwayat_penjualan')->result_array();
        $this->load->view('templates/supadmin/form_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
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
        $data['data_barang'] = $this->db->get('barang')->result_array();
        $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
        $this->load->view('templates/supadmin/table_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/laporan_stok', $data);
        $this->load->view('templates/supadmin/table_footer', $data);
    }

    public function suplier()
    {
        $this->form_validation->set_rules('nama', 'Nama Suplier', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat Suplier', 'required');
        $this->form_validation->set_rules('telp', 'Nomor Telepon', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Suplier";
            $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
            $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
            $this->db->order_by('id', 'desc');
            $data['data_suplier'] = $this->db->get('suplier')->result_array();
            $this->load->view('templates/supadmin/form_header', $data);
            $this->load->view('templates/supadmin/sidebar', $data);
            $this->load->view('supadmin/suplier', $data);
            $this->load->view('templates/supadmin/form_footer', $data);
        } else {
            $this->sup_admin->sam_tambah_suplier();
        }
    }

    public function ubah_suplier()
    {
        $this->sup_admin->sam_ubah_suplier();
    }

    public function hapus_suplier($id)
    {
        $this->sup_admin->sam_hapus_suplier($id);
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
            $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
            $this->db->order_by('id', 'desc');
            $data['barang'] = $this->db->get_where('barang', ['id_cabang' => 1])->result_array();
            $this->load->view('templates/supadmin/form_header', $data);
            $this->load->view('templates/supadmin/sidebar', $data);
            $this->load->view('supadmin/pesan_stok_barang', $data);
            $this->load->view('templates/supadmin/form_footer', $data);
        } else {
            $this->sup_admin->sam_pesan_stok_barang();
        }
    }

    public function data_pesanan()
    {
        $data['title'] = "Data Pesanan";
        $data['main_title'] = "Pemesanan";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('id', 'desc');
        $this->db->order_by('nama_kategori', 'asc');
        $data['kategori_barang'] = $this->db->get('kategori_barang')->result_array();
        $this->db->order_by('id', 'desc');
        $data['data_pesanan'] = $this->db->get('pesanan_barang')->result_array();
        $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
        $this->load->view('templates/supadmin/form_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
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
        $data['riwayat'] = $this->db->get_where('riwayat_pengeluaran', ['status_bukti !=' => 0])->result_array();
        $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
        $this->load->view('templates/supadmin/form_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/data_pengeluaran', $data);
        $this->load->view('templates/supadmin/form_footer', $data);
    }

    public function tolak_bukti_pengeluaran($kode)
    {
        $this->sup_admin->sam_tolak_bukti_pengeluaran($kode);
    }

    public function upload_bukti_pengeluaran($kode)
    {
        $this->sup_admin->sam_upload_bukti_pengeluaran($kode);
    }

    public function stok_opname()
    {
        $data['title'] = "Stok Opname";
        $data['main_title'] = "Barang";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('id', 'desc');
        $data['stop_opname'] = $this->db->get('stok_opname')->result_array();
        $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
        $this->load->view('templates/supadmin/form_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
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
            $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
            $this->db->order_by('id', 'desc');
            $data['barang'] = $this->db->get_where('barang', ['id_cabang' => 1])->result_array();
            $this->load->view('templates/supadmin/form_header', $data);
            $this->load->view('templates/supadmin/sidebar', $data);
            $this->load->view('supadmin/tambah_stok_opname', $data);
            $this->load->view('templates/supadmin/form_footer', $data);
        } else {
            $this->sup_admin->sam_tambah_stok_opname();
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
            $this->load->view('templates/supadmin/sidebar', $data);
            $this->load->view('supadmin/proses_stok_opname', $data);
            $this->load->view('templates/supadmin/form_footer', $data);
        } else {
            $this->sup_admin->sam_proses_stok_opname($kode);
        }
    }

    public function hapus_data_pesanan_stok($kode)
    {
        $this->sup_admin->sam_hapus_data_pesanan_stok($kode);
    }

    public function hapus_data_pesanan($kode)
    {
        $this->sup_admin->sam_hapus_data_pesanan($kode);
    }
    public function hapus_stok_opname($kode)
    {
        $this->sup_admin->sam_hapus_stok_opname($kode);
    }

    public function terima_pesanan($kode)
    {
        $this->sup_admin->sam_terima_pesanan($kode);
    }

    public function simpan_barang_kegudang()
    {
        $this->sup_admin->sam_simpan_barang_kegudang();
    }

    public function laporan_pembelian()
    {
        $data['title'] = "Laporan Pembelian";
        $data['main_title'] = "Laporan";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('id', 'desc');
        $this->db->order_by('nama_kategori', 'asc');
        $data['kategori_barang'] = $this->db->get('kategori_barang')->result_array();
        $data['data_cabang'] = $this->db->get('data_cabang')->result_array();
        $this->load->view('templates/supadmin/form_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/laporan_pembelian', $data);
        $this->load->view('templates/supadmin/form_footer', $data);
    }

    public function data_cabang()
    {
        $this->form_validation->set_rules('nama', 'Nama Cabang', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat Cabang', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Data Cabang";
            $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
            $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
            $this->db->order_by('id', 'desc');
            $data['data_cabang'] = $this->db->get_where('data_cabang', ['id !=' => 1])->result_array();
            $data['cabang_utama'] = $this->db->get_where('data_cabang', ['id' => 1])->row_array();
            $this->load->view('templates/supadmin/form_header', $data);
            $this->load->view('templates/supadmin/sidebar', $data);
            $this->load->view('supadmin/data_cabang', $data);
            $this->load->view('templates/supadmin/form_footer', $data);
        } else {
            $this->sup_admin->sam_tambah_cabang();
        }
    }

    public function ubah_dataCabang()
    {
        $this->sup_admin->sam_ubah_dataCabang();
    }

    public function hapus_dataCabang($id)
    {
        $this->sup_admin->sam_hapus_dataCabang($id);
    }

    public function kategori_barang()
    {
        $data['title'] = "Kategori Barang";
        $data['main_title'] = "Barang";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('id', 'desc');
        $data['kategori_barang'] = $this->db->get('kategori_barang')->result_array();
        $this->load->view('templates/supadmin/table_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/kategori_barang', $data);
        $this->load->view('templates/supadmin/table_footer', $data);
    }

    public function satuan_barang()
    {
        $data['title'] = "Satuan Barang";
        $data['main_title'] = "Barang";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('id', 'desc');
        $data['satuan_barang'] = $this->db->get('satuan_barang')->result_array();
        $this->load->view('templates/supadmin/table_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/satuan_barang', $data);
        $this->load->view('templates/supadmin/table_footer', $data);
    }

    //Batas

    public function pengaturan_umum()
    {

        $this->form_validation->set_rules('nama', 'Nama Perusahaan', 'required');
        $this->form_validation->set_rules('pemilik', 'Pemilik Perusahaan', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat Perusahaan', 'required');
        $this->form_validation->set_rules('footer', 'Footer', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Pengaturan";
            $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
            $data['umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
            $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
            $this->load->view('templates/supadmin/header', $data);
            $this->load->view('templates/supadmin/sidebar', $data);
            $this->load->view('supadmin/pengaturan/umum', $data);
            $this->load->view('templates/supadmin/footer', $data);
        } else {
            $this->sup_admin->sam_pengaturan_umum();
        }
    }

    public function profile()
    {
        $data['title'] = "Profile";
        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->load->view('templates/supadmin/header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('lainnya/profile', $data);
        $this->load->view('templates/supadmin/footer', $data);
    }

    public function ubah_password()
    {
        if ($this->session->userdata('role_id') == 3) {
            redirect('superadmin/profile');
        }
        $this->form_validation->set_rules('pl', 'Password lama', 'required');
        $this->form_validation->set_rules('pb', 'Password baru', 'required|min_length[3]|matches[up]');
        $this->form_validation->set_rules('up', 'Verifikasi password', 'required|min_length[3]|matches[pb]');
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Ubah Password";
            $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
            $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
            $this->load->view('templates/supadmin/header', $data);
            $this->load->view('templates/supadmin/sidebar', $data);
            $this->load->view('lainnya/ubah_password', $data);
            $this->load->view('templates/supadmin/footer', $data);
        } else {
            $this->sup_admin->sam_ubah_password();
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
            $this->load->view('templates/supadmin/sidebar', $data);
            $this->load->view('lainnya/ubah_profile', $data);
            $this->load->view('templates/supadmin/footer', $data);
        } else {
            $this->sup_admin->sam_ubah_profile();
        }
    }

    function get_autocomplete()
    {
        if (isset($_GET['term'])) {
            $result = $this->sup_admin->search_bar($_GET['term']);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = $row->barcode;
                echo json_encode($arr_result);
            }
        }
    }

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
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/history_pengeluaran', $data);
    }

    function get_history_pengeluaran()
    {
        return $this->sup_admin->sam_history_pengeluaran();
    }

    public function show_history_pengeluaran()
    {
        echo $this->get_history_pengeluaran();
    }

    function search_h_pengeluaran()
    {
        $this->sup_admin->sam_search_history_pengeluaran();
    }

    function get_history_pengeluaran_c($id)
    {
        return $this->sup_admin->sam_history_pengeluaran_c($id);
    }

    public function show_history_pengeluaran_c($id)
    {
        echo $this->get_history_pengeluaran_c($id);
    }

    function search_h_pengeluaran_c($id)
    {
        $this->sup_admin->sam_search_history_pengeluaran_c($id);
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
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/data_pengeluaran_hari', $data);
    }

    function get_pengeluaran_hari()
    {
        return $this->sup_admin->sam_data_pengeluaran_hari();
    }

    public function sh_pl_hari()
    {
        echo $this->get_pengeluaran_hari();
    }

    function search_pengeluaran_h()
    {
        $this->sup_admin->sam_search_data_pengeluaran_hari();
    }

    function get_pengeluaran_hari_cabang($id)
    {
        return $this->sup_admin->sam_data_pengeluaran_hari_cabang($id);
    }

    public function sh_pl_hari_cabang($id)
    {
        echo $this->get_pengeluaran_hari_cabang($id);
    }

    function search_pengeluaran_h_cabang($id)
    {
        $this->sup_admin->sam_search_data_pengeluaran_hari_c($id);
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
        $this->load->view('templates/supadmin/sidebar', $data);
        $this->load->view('supadmin/data_pengeluaran_bulan', $data);
    }

    function get_pengeluaran_bulan()
    {
        return $this->sup_admin->sam_data_pengeluaran_bulan();
    }

    public function show_pengeluaran_bulan()
    {
        echo $this->get_pengeluaran_bulan();
    }

    function get_data_pengeluaran_bulan_cabang($id)
    {
        return $this->sup_admin->sam_data_pengeluaran_bulan_cabang($id);
    }
    public function show_pengeluaran_bulan_cabang($id)
    {
        echo $this->get_data_pengeluaran_bulan_cabang($id);
    }

    function search_data_pengeluaran_bulan()
    {
        $this->sup_admin->sam_search_data_pengeluaran_bulan();
    }

    function search_data_pengeluaran_bulan_cabang($id)
    {
        $this->sup_admin->sam_search_data_pengeluaran_bulan_cabang($id);
    }

    public function addUser()
    {
        $this->sup_admin->sam_addUser();
    }

    public function dinamis_user()
    {
        $this->sup_admin->sam_dinamis_user();
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
            $data['data_user'] = $this->db->get('user_langganan')->result_array();
            $this->load->view('templates/supadmin/table_header', $data);
            $this->load->view('templates/supadmin/sidebar', $data);
            $this->load->view('supadmin/data_user', $data);
        } else {
            $this->sup_admin->sam_tambah_user();
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
            $data['data_user'] = $this->db->get_where('user_langganan', ['id_user' => $id])->row_array();
            $this->load->view('templates/supadmin/table_header', $data);
            $this->load->view('templates/supadmin/sidebar', $data);
            $this->load->view('supadmin/ubah_user', $data);
        } else {
            $this->sup_admin->sam_ubah_user($id);
        }
    }

    public function hapus_user($id)
    {
        $this->sup_admin->sam_hapus_user($id);
    }

    public function data_cicilan()
    {
        $data['title'] = "Data Cicilan";
        $data['main_title'] = "Cicilan";
        $data['data_cabang'] = $this->db->get('data_cabang')->result_array();

        $data['p_umum'] = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('id', 'desc');
        $data['hutang'] = $this->db->get_where('riwayat_penjualan', ['metode_bayar' => 'cicilan'])->result_array();
        $this->load->view('templates/supadmin/form_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
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
            $this->load->view('templates/supadmin/sidebar', $data);
            $this->load->view('supadmin/bayar_cicilan', $data);
        } else {
            $this->sup_admin->sam_bayar_cicilan($id);
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
        $data['pembayaran'] = $this->db->get('pembayaran_cicilan')->result_array();
        $this->load->view('templates/supadmin/form_header', $data);
        $this->load->view('templates/supadmin/sidebar', $data);
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
            $this->load->view('templates/supadmin/sidebar', $data);
            $this->load->view('supadmin/pesan_barang', $data);
        } else {
            $this->sup_admin->sam_pesan_barang();
        }
    }

    public function simpan_barang_sementara()
    {
        $this->sup_admin->sam_simpan_barang_sementara();
    }

    public function hapus_isi_pesanan_manual()
    {
        $this->sup_admin->sam_hapus_isi_pesanan_manual();
    }

    public function ubah_p_keranjang()
    {
        $this->sup_admin->sam_ubah_p_keranjang();
    }

    function list_pesanan_barang()
    {
        echo $this->sup_admin->sam_pesanan_manual();
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
            $this->load->view('templates/supadmin/sidebar', $data);
            $this->load->view('supadmin/terima_pesanan_barang', $data);
            $this->load->view('templates/supadmin/table_footer', $data);
        } else {
            $this->sup_admin->sam_pesan_barang();
        }
    }

    public function simpan_jual_barang()
    {
        $this->sup_admin->sam_simpan_jual_barang();
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
