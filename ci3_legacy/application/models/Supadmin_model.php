<?php defined('BASEPATH') or exit('No direct script access allowed');

class Supadmin_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('upload_model', 'uploadMod');
  }

  public function sam_tambah_admin()
  {
    $nama = $this->input->post('nama', true);
    $jk = $this->input->post('jk', true);
    $email = $this->input->post('email', true);
    $username = $this->input->post('username', true);
    $password = $this->input->post('password', true);
    $penempatan = $this->input->post('penempatan', true);

    $foto = $_FILES['foto']['name'];
    $up_path = './assets/images/profiles/';
    $up_type = 'jpg|jpeg|png|gif';
    $up_maxsize = 9000;
    $up_name = 'foto';
    $up_set = 'foto_profile';
    $up_err_redirect = 'superadmin/admin';

    if ($foto) {
      $this->uploadMod->image_upload_ins($up_path, $up_type, $up_maxsize, $up_name, $up_set, $up_err_redirect);
    } else {
      $this->db->set('foto_profile', "default.png");
    }

    $data = [
      'nama' =>  $nama,
      'username' =>  $username,
      'email' =>  $email,
      'jenis_kelamin' =>  $jk,
      'password' =>  password_hash($password, PASSWORD_DEFAULT),
      'penempatan_cabang' =>  $penempatan,
      'role_id' =>  2,
      'status' =>  1
    ];

    $this->db->insert('user', $data);
    $this->session->set_flashdata('pesan', 'Admin berhasil ditambahkan');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/admin');
  }

  public function sam_ubah_admin()
  {
    $nama = $this->input->post('nama', true);
    $jk = $this->input->post('jk', true);
    $email = $this->input->post('email', true);
    $username = $this->input->post('username', true);
    $penempatan = $this->input->post('penempatan', true);
    $id = $this->input->post('id', true);

    $foto = $_FILES['foto']['name'];
    $up_path = './assets/images/profiles/';
    $up_type = 'jpg|jpeg|png|gif';
    $up_maxsize = 9000;
    $up_name = 'foto';
    $up_set = 'foto_profile';
    $up_err_redirect = 'superadmin/admin';
    $up_gambar_lama = $this->input->post('gambar_lama');
    $up_unlink = 'assets/images/profiles/';

    if ($foto) {
      $this->uploadMod->image_upload_upl($up_path, $up_type, $up_maxsize, $up_name, $up_set, $up_err_redirect, $up_gambar_lama, $up_unlink);
    }

    $data = [
      'nama' =>  $nama,
      'username' =>  $username,
      'email' =>  $email,
      'jenis_kelamin' =>  $jk,
      'penempatan_cabang' =>  $penempatan
    ];
    $this->db->set($data);
    $this->db->where('id', $id);
    $this->db->update('user');
    $this->session->set_flashdata('pesan', 'Admin berhasil diubah');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/admin');
  }

  public function sam_blokir_admin($id)
  {
    $this->db->set('status',  0);
    $this->db->where('id', $id);
    $this->db->update('user');
    $this->session->set_flashdata('pesan', 'Admin berhasil diblokir');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/admin');
  }

  public function sam_aktifkan_admin($id)
  {
    $this->db->set('status',  1);
    $this->db->where('id', $id);
    $this->db->update('user');
    $this->session->set_flashdata('pesan', 'Admin berhasil diaktifkan');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/admin');
  }

  public function sam_hapus_admin($id)
  {
    $q = $this->db->get_where('user', ['id' => $id])->row_array();
    if ($q['foto_profile'] != 'default.png') {
      unlink(FCPATH . 'assets/images/profiles/' . $q['foto_profile']);
    }
    $this->db->where('id', $id);
    $this->db->delete('user');
    $this->session->set_flashdata('pesan', 'Admin berhasil dihapus');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/admin');
  }

  public function sam_tambah_barang()
  {
    $barcode = $this->input->post('barcode', true);
    $nama = $this->input->post('nama', true);
    $kategori = $this->input->post('kategori', true);
    $harga_beli = $this->input->post('harga_beli', true);
    $harga_jual = $this->input->post('harga_jual', true);
    $profit = $this->input->post('profit', true);
    $hargabeli_filter = str_replace(",", "", $harga_beli);
    $hargajual_filter = str_replace(",", "", $harga_jual);
    $hargaprofit_filter = str_replace(",", "", $profit);
    $satuan = $this->input->post('satuan', true);
    $penempatan = $this->input->post('penempatan', true);
    $keterangan = $this->input->post('keterangan', true);
    $suplier = $this->input->post('suplier', true);
    $daril_pajak = $this->input->post('daril_pajak', true);
    $kd_penjualan = $this->input->post('kd_penjualan', true);
    $kd_pembelian = $this->input->post('kd_pembelian', true);
    $kadaluarsa = $this->input->post('kadaluarsa', true);

    $qBarang = $this->db->get_where('barang', ['barcode' => $barcode, 'id_cabang' => $penempatan])->row_array();
    $cabeng = $this->db->get_where('data_cabang', ['id' => $penempatan])->row_array();
    if ($qBarang) {
      $this->session->set_flashdata('pesan', 'Barcode sudah digunakan di ' . $cabeng['nama_cabang']);
      $this->session->set_flashdata('tipe', 'error');
      $this->session->set_flashdata('status', 'Gagal Diubah');
      redirect('superadmin/tambah_barang');
    }

    $foto = $_FILES['foto']['name'];
    $up_path = './assets/images/barang/';
    $up_type = 'jpg|jpeg|png|gif';
    $up_maxsize = 9000;
    $up_name = 'foto';
    $up_set = 'gambar';
    $up_err_redirect = 'superadmin/tambah_barang';

    if ($foto) {
      $this->uploadMod->image_upload_ins($up_path, $up_type, $up_maxsize, $up_name, $up_set, $up_err_redirect);
    } else {
      $this->db->set('gambar', "default.png");
    }

    $data = [
      'barcode' =>  $barcode,
      'nama_barang' =>  $nama,
      'kategori' =>  $kategori,
      'harga_beli' =>  $hargabeli_filter,
      'harga_jual' =>  $hargajual_filter,
      'profit' =>  $hargaprofit_filter,
      'stok' =>  0,
      'satuan' =>  $satuan,
      'id_cabang' =>  $penempatan,
      'keterangan' => $keterangan,
      'id_suplier' => $suplier,
      'kode_penjualan' => $kd_penjualan,
      'kode_pembelian' => $kd_pembelian,
      'exp_date' => $kadaluarsa,
    ];

    $this->db->insert('barang', $data);
    $q = "SELECT * FROM barang ORDER BY id DESC LIMIT 1";
    $last_id = $this->db->query($q)->row_array();
    $data2 = [
      'id_barang' => $last_id['id'],
      'tgl' => time(),
      'tanggal' => '',
      'jumlah' => 0,
      'keterangan' => 'Data awal',
      'status' => 1,
      'in_out' => 0
    ];
    $this->db->insert('stok_barang', $data2);

    $this->session->set_flashdata('pesan', 'Barang berhasil ditambahkan');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/barang');
  }

  public function sam_hapus_barang($id)
  {
    //filter
    $i = $this->db->get_where('isi_pesanan_barang', ['id_barang' => $id, 'status' => 0])->row_array();
    $j = $this->db->get_where('isi_stok_opname', ['id_barang' => $id, 'status' => 0])->row_array();
    $k = $this->db->get_where('keranjang', ['id_barang' => $id])->row_array();
    if ($k) {
      $this->session->set_flashdata('pesan', 'Barang yang dipilih sedang dalam proses transaksi penjualan');
      $this->session->set_flashdata('tipe', 'error');
      $this->session->set_flashdata('status', 'Data Gagal Dihapus');
      redirect('superadmin/barang');
    } elseif ($i) {
      $this->session->set_flashdata('pesan', 'Barang yang dipilih sedang dalam proses transaksi pemesanan barang');
      $this->session->set_flashdata('tipe', 'error');
      $this->session->set_flashdata('status', 'Data Gagal Dihapus');
      redirect('superadmin/barang');
    } elseif ($j) {
      $this->session->set_flashdata('pesan', 'Barang yang dipilih sedang dalam proses pembuatan stok opname');
      $this->session->set_flashdata('tipe', 'error');
      $this->session->set_flashdata('status', 'Data Gagal Dihapus');
      redirect('superadmin/barang');
    }
    $q = $this->db->get_where('barang', ['id' => $id])->row_array();
    if ($q['gambar'] != 'default.png') {
      unlink(FCPATH . 'assets/images/barang/' . $q['gambar']);
    }
    $this->db->where('id', $id);
    $this->db->delete('barang');
    $this->db->where('id_barang', $id);
    $this->db->delete('stok_barang');
    $this->db->where('id_barang',$id);
    $this->db->delete('semua_data_keranjang');
    $this->session->set_flashdata('pesan', 'Barang berhasil dihapus');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/barang');
  }

  public function sam_ubah_barang($id)
  {
    $nama = $this->input->post('nama', true);
    $barcode = $this->input->post('barcode', true);
    $kategori = $this->input->post('kategori', true);
    $harga_jual = $this->input->post('harga_jual', true);
    $harga_beli = $this->input->post('harga_beli', true);
    $profit = $this->input->post('profit', true);
    $hargabeli_filter = str_replace(",", "", $harga_beli);
    $hargajual_filter = str_replace(",", "", $harga_jual);
    $hargaprofit_filter = str_replace(",", "", $profit);
    $satuan = $this->input->post('satuan', true);
    $penempatan = $this->input->post('penempatan', true);
    $keterangan = $this->input->post('keterangan', true);
    $suplier = $this->input->post('suplier', true);
    $daril_pajak = $this->input->post('daril_pajak', true);
    $kd_penjualan = $this->input->post('kd_penjualan', true);
    $kd_pembelian = $this->input->post('kd_pembelian', true);
    $kadaluarsa = $this->input->post('kadaluarsa', true);

    $qBarang = $this->db->get_where('barang', ['barcode' => $barcode, 'id_cabang' => $penempatan, 'id !=' => $id])->row_array();
    $cabeng = $this->db->get_where('data_cabang', ['id' => $penempatan])->row_array();
    if ($qBarang) {
      $this->session->set_flashdata('pesan', 'Barcode sudah digunakan di ' . $cabeng['nama_cabang']);
      $this->session->set_flashdata('tipe', 'error');
      $this->session->set_flashdata('status', 'Gagal Diubah');
      redirect('superadmin/ubah_barang/' . $id);
    }

    $foto = $_FILES['foto']['name'];
    $up_path = './assets/images/barang/';
    $up_type = 'jpg|jpeg|png|gif';
    $up_maxsize = 9000;
    $up_name = 'foto';
    $up_set = 'gambar';
    $up_err_redirect = 'superadmin/ubah_barang/' . $id;
    $up_gambar_lama = $this->input->post('gambar_lama');
    $up_unlink = 'assets/images/barang/';

    if ($foto) {
      $this->uploadMod->image_upload_upl($up_path, $up_type, $up_maxsize, $up_name, $up_set, $up_err_redirect, $up_gambar_lama, $up_unlink);
    }

    $data = [
      'barcode' =>  $barcode,
      'nama_barang' =>  $nama,
      'kategori' =>  $kategori,
      'harga_beli' =>  $hargabeli_filter,
      'harga_jual' =>  $hargajual_filter,
      'profit' =>  $hargaprofit_filter,
      'satuan' =>  $satuan,
      'id_cabang' =>  $penempatan,
      'keterangan' => $keterangan,
      'id_suplier' => $suplier,
      'kode_penjualan' => $kd_penjualan,
      'kode_pembelian' => $kd_pembelian,
      'exp_date' => $kadaluarsa
    ];

    $this->db->set($data);
    $this->db->where('id', $id);
    $this->db->update('barang');
    $this->session->set_flashdata('pesan', 'Barang berhasil diubah');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/barang');
  }

  public function sam_tambah_kategori_barang()
  {
    $nama_kategori = $this->input->post('nama_kategori', true);
    $cus_halaman = $this->input->post('cus_halaman', true);
    $data = [
      'nama_kategori' => $nama_kategori
    ];
    $this->db->insert('kategori_barang', $data);
    $this->session->set_flashdata('pesan', 'Kategori berhasil ditambahkan');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    if (isset($_POST['cus_halaman'])) {
      redirect('superadmin/' . $cus_halaman);
    } else {
      redirect('superadmin/kategori_barang');
    }
  }

  public function sam_ubah_kaategori_barang()
  {
    $nama_kategori = $this->input->post('nama_kategori', true);
    $id = $this->input->post('id', true);
    $data = [
      'nama_kategori' => $nama_kategori
    ];
    $this->db->set($data);
    $this->db->where('id', $id);
    $this->db->update('kategori_barang');
    $this->session->set_flashdata('pesan', 'Kategori berhasil diubah');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/kategori_barang');
  }

  public function sam_hapus_kategori_barang($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('kategori_barang');
    $this->session->set_flashdata('pesan', 'Kategori berhasil dihapus');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/kategori_barang');
  }

  public function sam_tambah_satuan_barang()
  {
    $nama_satuan = $this->input->post('nama_satuan', true);
    $nama_asli = $this->input->post('nama_asli', true);
    $data = [
      'nama_satuan' => $nama_satuan,
      'nama_asli' => $nama_asli
    ];
    $this->db->insert('satuan_barang', $data);
    $this->session->set_flashdata('pesan', 'Satuan barang berhasil ditambahkan');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/satuan_barang');
  }

  public function sam_ubah_satuan_barang()
  {
    $nama_satuan = $this->input->post('nama_satuan', true);
    $nama_asli = $this->input->post('nama_asli', true);
    $id = $this->input->post('id', true);
    $data = [
      'nama_satuan' => $nama_satuan,
      'nama_asli' => $nama_asli
    ];
    $this->db->set($data);
    $this->db->where('id', $id);
    $this->db->update('satuan_barang');
    $this->session->set_flashdata('pesan', 'Satuan barang berhasil diubah');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/satuan_barang');
  }

  public function sam_hapus_satuan_barang($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('satuan_barang');
    $this->session->set_flashdata('pesan', 'Satuan barang berhasil dihapus');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/satuan_barang');
  }

  public function sam_hapus_in_out($id)
  {
    $in_out = $this->db->get_where('stok_barang', ['id' => $id])->row_array();
    $barang = $this->db->get_where('barang', ['id' => $in_out['id_barang']])->row_array();

    if ($in_out['status'] == 1) {
      $inout = 'Stok in berhasil dihapus';
      $if1 = $barang['stok'] - $in_out['jumlah'];
    } elseif ($in_out['status'] == 2) {
      $inout = 'Stok out berhasil dihapus';
      $if1 = $barang['stok'] + $in_out['jumlah'];
    }
    $this->db->set('stok', $if1);
    $this->db->where('id', $in_out['id_barang']);
    $this->db->update('barang');
    $this->db->where('id', $id);
    $this->db->delete('stok_barang');
    $this->session->set_flashdata('pesan', $inout);
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/log_in_out');
  }

  public function sam_tambah_stok_barang()
  {
    $stok = $this->input->post('stok', true);
    $stok_in = $this->input->post('stok_in', true);
    $stok_out = $this->input->post('stok_out', true);
    $keterangan = $this->input->post('keterangan', true);
    $id = $this->input->post('id', true);
    if ($stok_in == 1) {
      $q = $this->db->get_where('barang', ['id' => $id])->row_array();
      $stok_dulu = $q['stok'] + $stok;
      $this->db->set('stok', $stok_dulu);
      $this->db->where('id', $id);
      $this->db->update('barang');

      $data = [
        'id_barang' => $id,
        'tgl' => time(),
        'tanggal' => '',

        'jumlah' => $stok,
        'keterangan' => 'Stok In : ' . $keterangan,
        'status' => 1,
        'in_out' => 1
      ];
      $this->db->insert('stok_barang', $data);
      $this->session->set_flashdata('pesan', 'Stok berhasil ditambahkan');
      $this->session->set_flashdata('tipe', 'success');
      $this->session->set_flashdata('status', 'Berhasil');
      redirect('superadmin/stok_barang');
    } else if ($stok_out == 1) {
      $q = $this->db->get_where('barang', ['id' => $id])->row_array();
      if ($stok > $q['stok']) {
        $this->session->set_flashdata('pesan', 'Stok out lebih besar dari stok yang ada');
        $this->session->set_flashdata('tipe', 'error');
        $this->session->set_flashdata('status', 'Gagal');
        redirect('superadmin/stok_barang');
      }else{
        $stok_dulu = $q['stok'] - $stok;
        $this->db->set('stok', $stok_dulu);
        $this->db->where('id', $id);
        $this->db->update('barang');
  
        $data = [
          'id_barang' => $id,
          'tgl' => time(),
          'tanggal' => '',

          'jumlah' => $stok,
          'keterangan' => 'Stok Out : ' . $keterangan,
          'status' => 2,
          'in_out' => 1
        ];
        $this->db->insert('stok_barang', $data);
        $this->session->set_flashdata('pesan', 'Stok berhasil dikeluarkan');
        $this->session->set_flashdata('tipe', 'success');
        $this->session->set_flashdata('status', 'Berhasil');
        redirect('superadmin/stok_barang');
      }
    }
  }

  public function sam_hapus_data_keranjang($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('keranjang');
    $this->db->where('id_del', $id);
    $this->db->delete('semua_data_keranjang');
  }

  public function sam_savedata_keranjang()
  {
    $id_barang = $this->input->post('id_barang', true);
    $id_cabang = $this->input->post('id_cabang', true);
    $harga_barang = $this->input->post('harga_barang', true);
    $satuan = $this->input->post('satuan', true);
    $jml = $this->input->post('jml', true);
    $q = $this->db->get_where('barang', ['id' => $id_barang])->row_array();
    $harga_total = $jml * $harga_barang;
    $data = [
      'barcode' => $q['barcode'],
      'id_barang' => $id_barang,
      'id_cabang' => $id_cabang,
      'jumlah' => $jml,
      'satuan' => $satuan,
      'harga' => $harga_barang,
      'profit' => $q['profit'] * $jml,
      'harga_total' => $harga_total,
      'id_pembelian' => 1,
      'id_user' =>  $this->session->userdata('id')
    ];

    $this->db->insert('keranjang', $data);
    $qwe = "SELECT * FROM keranjang ORDER BY id DESC LIMIT 1";
    $last_idqwe = $this->db->query($qwe)->row_array();
    $idKeranjang = $last_idqwe['id'];
    $data2 = [
      'barcode' => $q['barcode'],
      'id_keranjang' => 1,
      'nama' => $q['nama_barang'],
      'jumlah' => $jml,
      'satuan' => $satuan,
      'harga' => $harga_barang,
      'harga_total' => $harga_total,
      'id_del' => $idKeranjang,
      'harga_beli' => $q['harga_beli'],
      'harga_jual' => $q['harga_jual'],
      'profit' => $q['profit'] * $jml,
      'id_user' =>  $this->session->userdata('id'),
      'id_cabang' => $id_cabang,
      'id_barang' => $id_barang

    ];
    $this->db->insert('semua_data_keranjang', $data2);
  }

  public function sam_checkout()
  {
    $id_pembelian = $this->input->post('id_pembelian', true);
    $metode = $this->input->post('metode', true);
    $id_cicilan = $this->input->post('id_cicilan', true);
    if ($metode == 'cicilan') {
      $id_user = $this->input->post('id_user', true);
    }
    $uang_saya = $this->input->post('uang_saya', true);
    $kembalian_saya = $this->input->post('kembalian_saya', true);
    $harga_total = $this->input->post('harga_total', true);
    $total_keuntungan = $this->input->post('total_keuntungan', true);
    $id_keranjang = rand(0, 10000);

    $q_qu = $this->db->get_where('keranjang', ['id_pembelian' => 1, 'id_user' => $this->session->userdata('id')])->result_array();
    foreach ($q_qu as $q_q) {
      $jmlh = $q_q['jumlah'];
      $asd = $this->db->get_where('barang', ['id' => $q_q['id_barang']])->row_array();
      $jum_asd = $asd['stok'] - $jmlh;
      $this->db->set('stok', $jum_asd);
      $this->db->where('id', $q_q['id_barang']);
      $this->db->update('barang');
      $data_stok = [
        'id_barang' => $q_q['id_barang'],
        'tgl' => time(),
        'tanggal' => '',

        'jumlah' => $q_q['jumlah'],
        'keterangan' => "Barang terjual - ID : " . $id_pembelian,
        'status' => 2,
        'in_out' => 0
      ];
      $this->db->insert('stok_barang', $data_stok);
    }
    $this->db->limit(1);
    $this->db->order_by('id', 'desc');
    $idcabang = $this->db->get('keranjang')->row_array();
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_ind = date('d-m-Y');
    $hari_indo = date('d-m-Y H:i:s');
    $bulan_indo = date('m-Y');
    $single_bulan = date('m');
    $single_tahun = date('Y');
    $a =  date('Y-m-d');
    $p = "SELECT DAYOFWEEK('$a') as re";
    $qHari = $this->db->query($p)->row_array();
    if ($qHari['re'] == 2) {
      $hariku = 1;
    } else if ($qHari['re'] > 2) {
      $hariku  = $qHari['re'] - 1;
    } else if ($qHari['re'] == 1) {
      $hariku = 7;
    }

    if ($metode == 'tunai') {
      $data = [
        'id_pembelian' => $id_pembelian,
        'id_pembayaran_cicilan' => '',
        'id_user' => '',
        'id_keranjang' => $id_keranjang,
        'id_cabang' => $idcabang['id_cabang'],
        'total_pembayaran' => $harga_total,
        'tanggal' => $hari_indo,
        'tanggal_ind' => $tanggal_ind,
        'bulan_ind' => $bulan_indo,
        'single_bulan' => $single_bulan,
        'single_tahun' => $single_tahun,
        'uang' => $uang_saya,
        'kembalian' => $kembalian_saya,
        'pendapatan' => $total_keuntungan,
        'hari' => $hariku,
        'metode_bayar' => $metode,
        'status_utang' => 0
      ];
    } elseif ($metode == 'cicilan') {
      $data = [
        'id_pembelian' => $id_pembelian,
        'id_pembayaran_cicilan' => $id_cicilan,
        'id_user' => $id_user,
        'id_keranjang' => $id_keranjang,
        'id_cabang' => $idcabang['id_cabang'],
        'total_pembayaran' => $harga_total,
        'tanggal' => $hari_indo,
        'tanggal_ind' => $tanggal_ind,
        'bulan_ind' => $bulan_indo,
        'single_bulan' => $single_bulan,
        'single_tahun' => $single_tahun,
        'uang' => $uang_saya,
        'kembalian' => $kembalian_saya,
        'pendapatan' => $total_keuntungan,
        'hari' => $hariku,
        'metode_bayar' => $metode,
        'status_utang' => 1
      ];

      $dataTwo = [
        'id_cicilan' => $id_cicilan,
        'id_pembelian' => $id_pembelian,
        'id_user' => $id_user,
        'id_cabang' => $idcabang['id_cabang'],
        'tanggal' => $hari_indo,
        'sisa_cicilan' => $harga_total,
        'uang' => $uang_saya,
        'sisa_cicilan_akhir' => $kembalian_saya,
        'kembalian' => 0
      ];
      $this->db->insert('pembayaran_cicilan', $dataTwo);
    }


    $this->db->insert('riwayat_penjualan', $data);
    $this->db->set('id_keranjang', $id_keranjang);
    $data_we = [
      'id_keranjang' => 1,
      'id_user' => $this->session->userdata('id')
    ];
    $this->db->where($data_we);
    $this->db->update('semua_data_keranjang');
    $data_delete = [
      'id_pembelian' => 1,
      'id_user' => $this->session->userdata('id')
    ];
    $this->db->where($data_delete);
    $this->db->delete('keranjang');

    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Terimakasih sudah berbelanja <a href="' . base_url('cetak/struk_penjualan/') . $id_pembelian . '" class="btn btn-primary" target="_blank"><i class="fas fa-print"></i> Print Stuk Belanja</a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>');
  }

  public function sam_tambah_suplier()
  {
    $kode = $this->input->post('kode', true);
    $nama = $this->input->post('nama', true);
    $alamat = $this->input->post('alamat', true);
    $telp = $this->input->post('telp', true);

    $data = [
      'id_suplier' =>  $kode,
      'nama_suplier' =>  $nama,
      'alamat_suplier' =>  $alamat,
      'telp' =>  $telp
    ];

    $this->db->insert('suplier', $data);
    $this->session->set_flashdata('pesan', 'Suplier berhasil ditambahkan');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/suplier');
  }

  public function sam_ubah_suplier()
  {
    $kode = $this->input->post('kode', true);
    $nama = $this->input->post('nama', true);
    $alamat = $this->input->post('alamat', true);
    $telp = $this->input->post('telp', true);
    $id = $this->input->post('id', true);

    $data = [
      'id_suplier' =>  $kode,
      'nama_suplier' =>  $nama,
      'alamat_suplier' =>  $alamat,
      'telp' =>  $telp
    ];

    $this->db->set($data);
    $this->db->where('id', $id);
    $this->db->update('suplier');
    $this->session->set_flashdata('pesan', 'Suplier berhasil diubah');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/suplier');
  }

  public function sam_hapus_suplier($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('suplier');
    $this->session->set_flashdata('pesan', 'Suplier berhasil dihapus');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/suplier');
  }

  public function sam_pesan_stok_barang()
  {
    $kode = $this->input->post('kode', true);
    $nama = $this->input->post('nama', true);
    $suplier = $this->input->post('suplier', true);
    $cabang = $this->input->post('cabang', true);
    $tgl_pesan = $this->input->post('tgl_pesan', true);

    $id_admin = $this->session->userdata('id');

    $checkbox = $this->input->post('is_check');
    $jumlah = $this->input->post('jumlah', true);

    foreach ($checkbox as $cb => $value) {
      $namer = $this->db->get_where('barang', ['id' => $value])->row_array();
      $stok_pesan = $jumlah[$cb];
      $harganya = $namer['harga_beli'];
      $totalnya = $stok_pesan * $harganya;
      $data = [
        'kode' => $kode,
        'nama' => $namer['nama_barang'],
        'id_barang' => $value,
        'stok_sekarang' => $namer['stok'],
        'stok_pesan' => $stok_pesan,
        'stok_terima' => 0,
        'harga_beli' => $harganya,
        'total_beli' => $totalnya,
        'status' => 0,
        'id_cabang' => $cabang
      ];
      $this->db->insert('isi_pesanan_barang', $data);
    }

    $data = [
      'kode' =>  $kode,
      'nama' =>  $nama,
      'suplier' =>  $suplier,
      'tempat' =>  $cabang,
      'tanggal_pesan' =>  $tgl_pesan,
      'tanggal_terima' => '',
      'status' => 0,
      'jenis_pesanan' => 1
    ];

    $this->db->insert('pesanan_barang', $data);

    $this->db->select_sum('total_beli');
    $xz = $this->db->get_where('isi_pesanan_barang',  ['kode' => $kode])->row_array();
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_ind = date('d-m-Y');
    $bulan_indo = date('m-Y');
    $single_bulan = date('m');
    $single_tahun = date('Y');
    $a =  date('Y-m-d');
    $p = "SELECT DAYOFWEEK('$a') as re";
    $qHari = $this->db->query($p)->row_array();
    if ($qHari['re'] == 2) {
      $hariku = 1;
    } else if ($qHari['re'] > 2) {
      $hariku  = $qHari['re'] - 1;
    } else if ($qHari['re'] == 1) {
      $hariku = 7;
    }
    $data_pengeluaran = [
      'kode_pesanan' => $kode,
      'id_cabang' => $cabang,
      'total_pengeluaran' => $xz['total_beli'],
      'tanggal_ind' => $tanggal_ind,
      'bulan_ind' => $bulan_indo,
      'single_bulan'  => $single_bulan,
      'single_tahun' => $single_tahun,
      'bukti_pengeluaran' =>  '',
      'status_bukti' => 0,
      'hari' => $hariku
    ];
    $this->db->insert('riwayat_pengeluaran', $data_pengeluaran);

    $this->session->set_flashdata('pesan', 'Pemesanan Stok barang berhasil');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/data_pesanan');
  }

  public function sam_pesan_barang()
  {
    $kode = $this->input->post('kode', true);
    $nama = $this->input->post('nama', true);
    $suplier = $this->input->post('suplier', true);
    $cabang = $this->input->post('cabang', true);
    $tgl_pesan = $this->input->post('tgl_pesan', true);
    $iduser = $this->input->post('iduser', true);

    $cek = $this->db->get_where('pesanan_manual', ['kode' => 1, 'id_user' => $iduser])->row_array();
    if ($cek == 0) {
      $this->session->set_flashdata('pesan', 'Belum ada data barang');
      $this->session->set_flashdata('tipe', 'error');
      $this->session->set_flashdata('status', 'Pemesanan Gagal');
      redirect('superadmin/pesan_barang');
    }

    $this->db->set('kode', $kode);
    $this->db->where(['kode' => 1, 'id_user' => $iduser]);
    $this->db->update('pesanan_manual');

    $data = [
      'kode' =>  $kode,
      'nama' =>  $nama,
      'suplier' =>  $suplier,
      'tempat' =>  $cabang,
      'tanggal_pesan' =>  $tgl_pesan,
      'tanggal_terima' => '',
      'status' => 0,
      'jenis_pesanan' => 2
    ];

    $this->db->insert('pesanan_barang', $data);

    $this->db->select_sum('harga_total');
    $xz = $this->db->get_where('pesanan_manual',  ['kode' => $kode])->row_array();
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_ind = date('d-m-Y');
    $bulan_indo = date('m-Y');
    $single_bulan = date('m');
    $single_tahun = date('Y');
    $a =  date('Y-m-d');
    $p = "SELECT DAYOFWEEK('$a') as re";
    $qHari = $this->db->query($p)->row_array();
    if ($qHari['re'] == 2) {
      $hariku = 1;
    } else if ($qHari['re'] > 2) {
      $hariku  = $qHari['re'] - 1;
    } else if ($qHari['re'] == 1) {
      $hariku = 7;
    }
    $data_pengeluaran = [
      'kode_pesanan' => $kode,
      'id_cabang' => $cabang,
      'total_pengeluaran' => $xz['harga_total'],
      'tanggal_ind' => $tanggal_ind,
      'bulan_ind' => $bulan_indo,
      'single_bulan'  => $single_bulan,
      'single_tahun' => $single_tahun,
      'bukti_pengeluaran' =>  '',
      'status_bukti' => 0,
      'hari' => $hariku

    ];
    $this->db->insert('riwayat_pengeluaran', $data_pengeluaran);

    $this->session->set_flashdata('pesan', 'Pemesanan barang berhasil');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/data_pesanan');
  }

  public function sam_hapus_data_pesanan_stok($kode)
  {
    $this->db->where('kode', $kode);
    $this->db->delete('pesanan_barang');
    $this->db->where('kode', $kode);
    $this->db->delete('isi_pesanan_barang');
    $this->db->where('kode_pesanan', $kode);
    $this->db->delete('riwayat_pengeluaran');
    $this->session->set_flashdata('pesan', 'Pesanan stok barang berhasil dihapus');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/data_pesanan');
  }

  public function sam_hapus_data_pesanan($kode)
  {
    $this->db->where('kode', $kode);
    $this->db->delete('pesanan_barang');
    $this->db->where('kode', $kode);
    $this->db->delete('pesanan_manual');
    $this->db->where('kode_pesanan', $kode);
    $this->db->delete('riwayat_pengeluaran');
    $this->session->set_flashdata('pesan', 'Pesanan barang berhasil dihapus');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/data_pesanan');
  }

  public function sam_hapus_stok_opname($kode)
  {
    $this->db->where('kode', $kode);
    $this->db->delete('stok_opname');
    $this->db->where('kode', $kode);
    $this->db->delete('isi_stok_opname');
    $this->session->set_flashdata('pesan', 'Data berhasil dihapus');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/stok_opname');
  }

  public function sam_terima_pesanan($kode)
  {
    $q_qu = $this->db->get_where('isi_pesanan_barang', ['kode' => $kode])->result_array();
    foreach ($q_qu as $q_q) {
      $jmlh = $q_q['stok_pesan'];
      $data = [
        'stok_terima' => $jmlh,
        'status' => 1
      ];
      $this->db->set($data);
      $this->db->where('id_barang', $q_q['id_barang']);
      $this->db->update('isi_pesanan_barang');
      date_default_timezone_set('Asia/Jakarta');
      $tgl_terima = date('d-m-Y');
      $time_ind = time();
      $data2 = [
        'id_barang' => $q_q['id_barang'],
        'tgl' => $time_ind,
        'tanggal' => $tgl_terima,
        'jumlah' => $jmlh,
        'keterangan' => 'Pembelian Stok Barang - Kode : ' . $kode,
        'status' => 1,
        'in_out' => 0
      ];
      $this->db->insert('stok_barang', $data2);
      $bar = $this->db->get_where('barang', ['id' => $q_q['id_barang']])->row_array();
      $stokbar = $bar['stok'] + $jmlh;
      $this->db->set('stok', $stokbar);
      $this->db->where('id', $q_q['id_barang']);
      $this->db->update('barang');
    }

    $data = [
      'tanggal_terima' => $tgl_terima,
      'status' => 1
    ];
    $this->db->set($data);
    $this->db->where('kode', $kode);
    $this->db->update('pesanan_barang');

    $this->db->set('status_bukti', 1);
    $this->db->where('kode_pesanan', $kode);
    $this->db->update('riwayat_pengeluaran');

    $this->session->set_flashdata('pesan', 'Barang berhasil diterima');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/data_pesanan');
  }

  public function sam_tolak_bukti_pengeluaran($kode)
  {
    $this->db->set('status_bukti', 3);
    $this->db->where('kode_pesanan', $kode);
    $this->db->update('riwayat_pengeluaran');
    $this->session->set_flashdata('pesan', 'Bukti tidak diupload');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/data_pengeluaran');
  }

  public function sam_upload_bukti_pengeluaran($kode)
  {
    $foto = $_FILES['foto']['name'];
    $up_path = './assets/images/bukti_pengeluaran/';
    $up_type = 'jpg|jpeg|png';
    $up_maxsize = 2000;
    $up_name = 'foto';
    $up_set = 'bukti_pengeluaran';
    $up_err_redirect = 'superadmin/data_pengeluaran';
    $up_gambar_lama = $this->input->post('gambar_lama');
    $up_unlink = 'assets/images/bukti_pengeluaran/';

    if ($foto) {
      $this->uploadMod->image_upload_upl($up_path, $up_type, $up_maxsize, $up_name, $up_set, $up_err_redirect, $up_gambar_lama, $up_unlink);
    }

    $this->db->set('status_bukti', 2);
    $this->db->where('kode_pesanan', $kode);
    $this->db->update('riwayat_pengeluaran');
    $this->session->set_flashdata('pesan', 'Bukti berhasil diupload');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/data_pengeluaran');
  }

  public function sam_tambah_stok_opname()
  {
    $namaOpname =  $this->input->post('nama', true);
    $tempat =  $this->input->post('tempat', true);
    $kode =  $this->input->post('kode', true);
    $tgl =  $this->input->post('tgl', true);
    $catatan =  $this->input->post('catatan', true);


    $qry = $this->db->get_where('barang', ['id_cabang' => $tempat])->result_array();
    foreach ($qry as $key) {
      $data2 = [
        'kode' => $kode,
        'id_barang' => $key['id'],
        'nama' => $key['nama_barang'],
        'stok_aplikasi' => $key['stok'],
        'stok_fisik' => 0,
        'selisih_total' => 0,
        'selisih_harga' => 0,
        'id_cabang' => $tempat,
        'status' => 0
      ];
      $this->db->insert('isi_stok_opname', $data2);
    }

    $data1 = [
      'kode' => $kode,
      'nama' => $namaOpname,
      'tanggal' => $tgl,
      'tempat' => $tempat,
      'status' => "Stok Opname",
      'catatan' => $catatan,
      'disabled' => 0
    ];

    $this->db->insert('stok_opname', $data1);


    $this->session->set_flashdata('pesan', 'Silahkan lanjutkan proses selanjutnya');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Data Berhasil Disimpan');
    redirect('superadmin/proses_stok_opname/' . $kode);
  }

  public function sam_proses_stok_opname($kode)
  {
    $checkbox = $this->input->post('is_check');
    $stok_fisik = $this->input->post('stok_fisik', true);
    $stok_aplikasi = $this->input->post('stok_aplikasi', true);

    foreach ($checkbox as $cb => $value) {
      $namer = $this->db->get_where('barang', ['id' => $value])->row_array();
      $stok_pesan = $stok_fisik[$cb];
      $selisih_total  = $stok_pesan - $stok_aplikasi[$cb];
      $harga_total = $namer['harga_jual'] * $selisih_total;
      $data = [
        'stok_fisik' => $stok_pesan,
        'selisih_total' => $selisih_total,
        'selisih_harga' => $harga_total,
        'status' => 1
      ];
      $this->db->set($data);
      $wer = [
        'kode' => $kode,
        'id_barang' => $namer['id']
      ];
      $this->db->where($wer);
      $this->db->update('isi_stok_opname');
    }
    $this->db->set('disabled', 1);
    $this->db->where('kode', $kode);
    $this->db->update('stok_opname');

    $this->session->set_flashdata('pesan', 'Pembuatan stok opname berhasil');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/stok_opname');
  }

  public function sam_simpan_barang_kegudang()
  {
    $kode = $this->input->post('kode', true);
    $nama = $this->input->post('nama', true);
    $kategori = $this->input->post('kategori', true);
    $harga = $this->input->post('harga', true);
    $satuan_stok = $this->input->post('satuan_stok', true);
    $stok = $this->input->post('stok', true);
    $nama_suplier = $this->input->post('nama_suplier', true);
    $id_pembelian = $this->input->post('id_pembelian', true);
    $id_cabang = $this->input->post('id_cabang', true);

    $this->db->set('status', 1);
    $this->db->where('id', $id_pembelian);
    $this->db->update('riwayat_pembelian');

    $data = [
      'kode_barang' =>  $kode,
      'nama_barang' =>  $nama,
      'kategori' =>  $kategori,
      'harga' =>  $harga,
      'stok' =>  $stok,
      'satuan' =>  $satuan_stok,
      'id_cabang' => $id_cabang
    ];

    $this->db->insert('barang', $data);
    $q = "SELECT * FROM barang ORDER BY id DESC LIMIT 1";
    $last_id = $this->db->query($q)->row_array();
    $data2 = [
      'id_barang' => $last_id['id'],
      'tgl' => time(),
      'tanggal' => '',
      'jumlah' => $stok,
      'keterangan' => 'Data pembelian barang di suplier : ' . $nama_suplier,
      'status' => 1,
      'in_out' => 0
    ];
    $this->db->insert('stok_barang', $data2);

    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Data berhasil disimpan kegudang, <a href="' . base_url('superadmin/barang') . '" class="btn btn-sm btn-dark">Lihat gudang</a>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>');
    redirect('superadmin/data_pesanan');
  }

  public function sam_tambah_cabang()
  {
    $nama = $this->input->post('nama', true);
    $alamat = $this->input->post('alamat', true);

    $data = [
      'nama_cabang' =>  $nama,
      'alamat' =>  $alamat
    ];

    $this->db->insert('data_cabang', $data);
    $this->session->set_flashdata('pesan', 'Data cabang berhasil ditambahkan');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/data_cabang');
  }

  public function sam_ubah_dataCabang()
  {
    $nama = $this->input->post('nama', true);
    $alamat = $this->input->post('alamat', true);
    $id = $this->input->post('id', true);

    $data = [
      'nama_cabang' =>  $nama,
      'alamat' =>  $alamat
    ];
    $this->db->set($data);
    $this->db->where('id', $id);
    $this->db->update('data_cabang');
    $this->session->set_flashdata('pesan', 'Data cabang berhasil diubah');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/data_cabang');
  }

  public function sam_hapus_dataCabang($id)
  {
    $pesanan_barang = $this->db->get_where('pesanan_barang', ['tempat' => $id, 'status' => 0])->row_array();
    $stok_opname = $this->db->get_where('stok_opname', ['tempat' => $id, 'disabled' => 0])->row_array();
    $keranjang = $this->db->get_where('keranjang', ['id_cabang' => $id])->row_array();
    if ($pesanan_barang) {
      $this->session->set_flashdata('pesan', 'Cabang yang dipilih sedang dalam proses transaksi pemesanan barang');
      $this->session->set_flashdata('tipe', 'error');
      $this->session->set_flashdata('status', 'Data Gagal Dihapus');
      redirect('superadmin/data_cabang');
    } elseif ($stok_opname) {
      $this->session->set_flashdata('pesan', 'Cabang yang dipilih sedang dalam proses pembuatan stok opname');
      $this->session->set_flashdata('tipe', 'error');
      $this->session->set_flashdata('status', 'Data Gagal Dihapus');
      redirect('superadmin/data_cabang');
    } elseif ($keranjang) {
      $this->session->set_flashdata('pesan', 'Cabang yang dipilih sedang dalam proses transaksi penjualan');
      $this->session->set_flashdata('tipe', 'error');
      $this->session->set_flashdata('status', 'Data Gagal Dihapus');
      redirect('superadmin/data_cabang');
    }

    $this->db->where('id_cabang', $id);
    $this->db->delete('barang');
    $this->db->where('id_cabang', $id);
    $this->db->delete('isi_pesanan_barang');
    $this->db->where('id_cabang', $id);
    $this->db->delete('isi_stok_opname');
    $this->db->where('tempat', $id);
    $this->db->delete('pesanan_barang');
    $this->db->where('id_cabang', $id);
    $this->db->delete('riwayat_penjualan');
    $this->db->where('id_cabang', $id);
    $this->db->delete('semua_data_keranjang');
    $this->db->where('tempat', $id);
    $this->db->delete('stok_opname');
    $this->db->where('penempatan_cabang', $id);
    $this->db->delete('user');

    $this->db->where('id', $id);
    $this->db->delete('data_cabang');


    $this->session->set_flashdata('pesan', 'Data cabang berhasil dihapus');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/data_cabang');
  }

  public function sam_pengaturan_umum()
  {
    $nama = $this->input->post('nama', true);
    $pemilik = $this->input->post('pemilik', true);
    $alamat = $this->input->post('alamat', true);
    $footer = $this->input->post('footer', true);
    $title = $this->input->post('title', true);

    $foto = $_FILES['favicon']['name'];
    $up_path = './assets/images/';
    $up_type = 'jpg|jpeg|png|gif|ico';
    $up_maxsize = 2000;
    $up_name = 'favicon';
    $up_set = 'favicon';
    $up_err_redirect = 'superadmin/pengaturan_umum';
    $up_gambar_lama = $this->input->post('favicon_lama');
    $up_unlink = 'assets/images/';

    if ($foto) {
      $this->uploadMod->image_upload_upl($up_path, $up_type, $up_maxsize, $up_name, $up_set, $up_err_redirect, $up_gambar_lama, $up_unlink);
    }

    $data = [
      'nama_perusahaan' => $nama,
      'pemilik' => $pemilik,
      'alamat_perusahaan' => $alamat,
      'title' => $title,
      'footer' => $footer
    ];
    $this->db->set($data);
    $this->db->where('id', 1);
    $this->db->update('pengaturan_umum');
    $this->session->set_flashdata('pesan', 'Pengaturan berhasil diubah');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/pengaturan_umum');
  }

  public function sam_ubah_password()
  {
    $password_lama = $this->input->post('pl', true);
    $password_baru = $this->input->post('pb', true);
    $ulangi_password = $this->input->post('up', true);
    $usr = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();

    if (password_verify($password_lama, $usr['password'])) {
      if ($password_lama != $password_baru) {
        $this->db->set('password', password_hash($password_baru, PASSWORD_DEFAULT));
        $this->db->where('id', $usr['id']);
        $this->db->update('user');
        $this->session->set_flashdata('pesan', 'Password berhasil diubah');
        $this->session->set_flashdata('tipe', 'success');
        $this->session->set_flashdata('status', 'Berhasil');
        redirect('superadmin/profile');
      } else {

        $this->session->set_flashdata('pesan', 'Password baru harus berbeda dengan password lama');
        $this->session->set_flashdata('tipe', 'error');
        $this->session->set_flashdata('status', 'Gagal');
        redirect('superadmin/ubah_password');
      }
    } else {

      $this->session->set_flashdata('pesan', 'Password lama salah');
      $this->session->set_flashdata('tipe', 'error');
      $this->session->set_flashdata('status', 'Gagal');
      redirect('superadmin/ubah_password');
    }
  }

  public function sam_ubah_profile()
  {
    $nama = $this->input->post('nama', true);
    $username = $this->input->post('username', true);
    $id = $this->input->post('id', true);

    $foto = $_FILES['foto']['name'];
    $up_path = './assets/images/profiles/';
    $up_type = 'jpg|jpeg|png|gif';
    $up_maxsize = 9000;
    $up_name = 'foto';
    $up_set = 'foto_profile';
    $up_err_redirect = 'superadmin/ubah_profile';
    $up_gambar_lama = $this->input->post('gambar_lama');
    $up_unlink = 'assets/images/profiles/';

    if ($foto) {
      $this->uploadMod->image_upload_upl($up_path, $up_type, $up_maxsize, $up_name, $up_set, $up_err_redirect, $up_gambar_lama, $up_unlink);
    }

    $data = [
      'nama' => $nama,
      'username' => $username
    ];
    $this->db->set($data);
    $this->db->where('id', $id);
    $this->db->update('user');
    $this->session->set_flashdata('pesan', 'Profile berhasil diubah');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/profile');
  }


  public function sam_isi_tampil_checkout()
  {
    $this->db->select_sum('harga_total');
    $q = $this->db->get_where('keranjang', ['id_user' => $this->session->userdata('id')])->row_array();
    $this->db->select_sum('profit');
    $x = $this->db->get_where('keranjang', ['id_user' => $this->session->userdata('id')])->row_array();
    $a = $this->db->get('riwayat_penjualan')->num_rows();
    $kl = $a += 1;
    $rand = rand($kl, 99999);
    $ut = rand(0, 99999);
    date_default_timezone_set('Asia/Jakarta');

    $tang = date('d');
    $bul = date('m');
    $hun = date('y');
    if ($q['harga_total'] == 0) {
      $filterDisabled = 'disabled';
    } else {
      $filterDisabled = '';
    }

    $output = '
    <div class="form-group">
      <label class="form-label">Metode Pembayaran</label>
      <div class="selectgroup w-100">
        <label class="selectgroup-item">
            <input type="radio" name="metode" value="tunai" data-mB="tunai" class="selectgroup-input metodeBayar" checked="" id="tunai">
            <span class="selectgroup-button">Tunai</span>
        </label>
        <label class="selectgroup-item">
            <input type="radio" name="metode" value="cicilan" data-mB="hutang" class="selectgroup-input metodeBayar" id="hutang">
            <span class="selectgroup-button">Cicilan</span>
        </label>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12" id="pIp">
          <div class="form-group">
              <label for="">ID Pembelian</label>
              <input type="text" name="id_pembelian" readonly class="form-control idPembelian" value="JBR' . $tang . $bul . $hun . $rand . '">
          </div>
      </div>
      <div class="col-lg-6">
          <div class="form-group hiddenHutang" style="display:none;">
              <label for="">ID Pembayaran Cicilan</label>
              <input type="text" name="id_cicilan" readonly class="form-control idHutang" value="IPC' . $tang . $bul . $hun . $ut . '">
          </div>
      </div>
    </div>
    <div id="didie"></div>
    
    
      <div class="form-group">
          <label for="">Total Pembayaran</label>
          <input type="text" name="total_bayar" readonly class="form-control tot-bar" value="' . rupiah($q['harga_total']) . '">
          <input type="hidden" readonly class="form-control tot-ber" value="' . $q['harga_total'] . '">
      </div>
     
      <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <label for="">Uang</label>
                  <input type="text" min="1" name="uang_saya" min="' . $q['harga_total'] . '" class="form-control uang-saya">
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <label for="" class="kSisa">Kembalian</label>
                  <input type="hidden" name="harga_total" value="' . $q['harga_total'] . '" class="harga-total-saya">
                  <input type="hidden" name="total_keuntungan" value="' . $x['profit'] . '" class="">
                  <input type="text" readonly class="form-control kembalian-saya-bg">
                  <input type="number" style="display:none;" name="kembalian_saya" readonly class="form-control kembalian-saya">
              </div>
          </div>
      </div>
      <button type="button" ' . $filterDisabled . ' id="btn-checkout" class="btn btnCheckout btn-primary float-right"><i class="fas fa-check"></i> Bayar</button>
      <div class="clearfix"></div>
      <p>Keyboard Shortcut</p>
      <p class="text-danger mb-0">**Tekan (F9) untuk memasukan uang </p>
      <p class="text-danger mb-0">**Tekan (F8) untuk menampilkan barang </p>
      <p class="text-danger mb-0">**Tekan (F7) untuk memasukan barcode </p>
      <p class="text-danger mb-0">**Tekan (F4) untuk melakukan pembayaran </p>
      <p class="text-danger mb-0">**Tekan (ENTER) untuk mengprint jika struk sudah tampil </p>

  ';
    return $output;
  }

  public function sam_tampil_keranjang()
  {
    $user = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    if ($user['role_id'] == 1) {
      $link = 'superadmin';
    } else {
      $link = 'admin';
    }
    $jum_ker = $this->db->get_where('keranjang', ['id_user' => $user['id']])->num_rows();
    $output = '';
    $no = 0;
    $keranjang = $this->db->get_where('keranjang', ['id_user' => $this->session->userdata('id')])->result_array();
    foreach ($keranjang as $ker) {
      $q = $this->db->get_where('barang', ['id' => $ker['id_barang']])->row_array();
      $no++;
      $output .= '
            <tr>
                <td> 
                <button type="button" data-id="' . $ker['id'] . '" title="Hapus" class="btn btn-danger btn-sm mb-1 btn-del"><i class="fas fa-trash"></i></button>
                </td>   
                <input type="hidden" class="kib-' . $ker['id_barang'] . '" value="' . $ker['id_barang'] . '">
                <input type="hidden" class="hbk-' . $ker['id_barang'] . '" value="' . $ker['harga'] . '">
                <input type="hidden" class="cbg-' . $ker['id_barang'] . '" value="' . $ker['id_cabang'] . '">
                <input type="hidden" class="pft-' . $ker['id_barang'] . '" value="' . $ker['profit'] . '">
                <input type="hidden" class="itusr" value="' . $user['id'] . '">
                <td>' . $q['nama_barang'] . '</td>
                <td>
                <div class="input-group">
                    <input type="number" name="jml" min="1" max="' . $q['stok'] . '" data-stok="' . $q['stok'] . '"  value="' . $ker['jumlah'] . '" required class="form-control inputJumlah-' . $ker['id_barang'] . '">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            ' . $q['satuan'] . '
                        </div>
                    </div>
                </div>
                </td>
                <td>' . rupiah($ker['harga']) . '</td>
                <td>' . rupiah($ker['harga_total']) . '</td>
                <td>
                <button type="button" data-idk="' . $ker['id_barang'] . '" title="Ubah Jumlah" class="btn btn-primary btn-sm mb-1 btn-ubk"><i class="fas fa-check"></i></button>
                </td>   
            </tr>
        ';
    }
    if ($jum_ker == 0) {
      $output .= '
            <tr>
                <td colspan="6" align="center">Belum ada data barang</td>
            </tr>
        ';
    } else {
      $this->db->select_sum('harga_total');
      $q = $this->db->get_where('keranjang', ['id_user' => $user['id']])->row_array();
      $output .= '
                <tr>
                <td colspan="4">Total Pembelian</td>
                <td colspan="2">' . rupiah($q['harga_total']) . '</td>
                </tr>
            ';
    }

    return $output;
  }

  public function sam_pesanan_manual()
  {
    $user = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $penempatan = $user['penempatan_cabang'];
    if ($user['role_id'] == 1) {
      $link = 'superadmin';
    } else {
      $link = 'admin';
    }
    $output = '';
    $no = 0;
    $jum_ker = $this->db->get_where('pesanan_manual', ['id_user' => $user['id']])->num_rows();
    $pesanan = $this->db->get_where('pesanan_manual', ['kode' => 1, 'id_user' => $this->session->userdata('id')])->result_array();
    foreach ($pesanan as $pes) {
      $no++;
      $output .= '
      <li class="list-group-item">
      <div class="float-left">
      <button type="button" data-id="' . $pes['id'] . '" title="Hapus" class="btn btn-danger btn-sm mr-3 btn-del"><i class="fas fa-trash"></i></button>

          <span>
              ' . $pes['nama_barang'] . '
          </span>
          <span class="mx-2">|</span>
          <span>
          ' . $pes['kategori'] . '
          </span>
          <p class="ml-5 mb-0">
              Rp. ' . rupiah($pes['harga_beli']) . '
              -> Rp. ' . rupiah($pes['harga_total']) . '
          </p>
      </div>
      <input type="hidden" class="h-beli-' . $pes['id'] . '" value="' . $pes['harga_beli'] . '">
                <input type="hidden" class="cbg-' . $pes['id'] . '" value="' . $pes['id_cabang'] . '">
      <div class="float-right">
          <div class="input-group">
              <input type="number" min="1" value="' . $pes['jumlah'] . '" class="form-control inputJumlah-' . $pes['id'] . '">
              <div class="input-group-append">
                  <button class="btn btn-outline-secondary">' . $pes['satuan'] . '</button>
                  <button type="button" data-idk="' . $pes['id'] . '" title="Ubah Jumlah" class="btn btn-outline-primary btn-sm btn-ubk"><i class="fas fa-check"></i></button>
              </div>
          </div>

      </div>
  </li>
        ';
    }
    if ($jum_ker == 0) {
      $output .= '
      <ul class="list-group">
      <li class="list-group-item">Belum ada data barang</li>
      
    </ul>
        ';
    }

    echo $output;
  }

  public function sam_wegot_history()
  {
    $output = '';
    $no = 1;
    $output .= '
    
        <table class="table table-striped" id="table-89">
            <thead>
                <tr>
                    <th width="30" class="text-center">
                        No
                    </th>
                    <th>ID Penjualan</th>
                    <th>Tanggal</th>
                    <th>Cabang</th>
                    <th>Total Barang</th>
                    <th>Total Pembayaran</th>
                    <th>Metode Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                
            
        ';
    $this->db->order_by('id', 'desc');
    $data_penjualan = $this->db->get('riwayat_penjualan')->result_array();
    foreach ($data_penjualan as $dp) {
      $d_cabang = $this->db->get_where('data_cabang', ['id' => $dp['id_cabang']])->row_array();
      if ($dp['metode_bayar'] == 'tunai') {
        $span_class = 'badge-info';
        $status_cicilan = '';
      } else {
        $span_class = 'badge-secondary';
        if ($dp['status_utang'] == 0) {

          $status_cicilan = '<span class="badge badge-success mt-1">Lunas</span>';
        } else {
          $status_cicilan = '<span class="badge badge-danger mt-1">Belum Lunas</span>';
        }
      }

      if ($dp['status_utang'] == 0 && $dp['metode_bayar'] == 'tunai') {
        $tombol = '
        <a href="' . base_url('cetak/data_penjualan/' . $dp['id_pembelian']) . '" target="_blank" title="Print Nota" class="btn btn-sm btn-primary mb-1"><i class="fas fa-print"></i></a>
        <a href="' . base_url('cetak/struk_penjualan/' . $dp['id_pembelian']) . '" title="Print Struk" target="_blank" class="btn btn-sm btn-outline-danger mb-1"><i class="fas fa-print"></i> Struk</a>
        ';
      } elseif ($dp['status_utang'] == 0 && $dp['metode_bayar'] == 'cicilan') {
        $tombol = '
        <a href="' . base_url('cetak/data_cicilan/' . $dp['id_pembayaran_cicilan']) . '" target="_blank" title="Print Nota" class="btn btn-sm btn-primary mb-1"><i class="fas fa-print"></i></a>
        <a href="' . base_url('cetak/struk_pembayaran_cicilan/' . $dp['id_pembayaran_cicilan']) . '" title="Print Struk" target="_blank" class="btn btn-sm btn-outline-danger mb-1"><i class="fas fa-print"></i> Struk</a>
        ';
      } else {

        $tombol = '';
      }


      $a = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $dp['id_keranjang']])->num_rows();
      $output .= '
                    <tr>
                        <td class="text-center">' . $no . '</td>
                        <td>' . $dp['id_pembelian'] . '</td>
                        <td>' . $dp['tanggal'] . '</td>
                        <td>' . $d_cabang['nama_cabang'] . '</td>
                        <td>' . $a . '</td>
                        <td>Rp ' . rupiah($dp['total_pembayaran']) . '</td>
                        <td><span class="badge ' . $span_class . '">' . $dp['metode_bayar'] . '</span> <br>' . $status_cicilan . '</td>
                        <td>
                            <div class="btn-group-horizontal text-center">
                                <button class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#modalUbahSiswa_' . $dp['id'] . '"><i class="fas fa-eye"></i> Detail</button>

                                ' . $tombol . '
                            </div>
                        </td>
                    </tr>
                ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    return $output;
  }

  public function sam_history_pengeluaran()
  {
    $output = '';
    $no = 1;
    $output .= '
        <table class="table table-striped" id="table-89">
            <thead>
                <tr>
                    <th width="30" class="text-center">
                        No
                    </th>
                    <th>Kode Pesanan</th>
                    <th>Tanggal</th>
                    <th>Cabang</th>
                    <th>Total Pengeluaran</th>
                </tr>
            </thead>
            <tbody>
                
            
        ';
    $this->db->order_by('id', 'desc');
    $data_pengeluaran = $this->db->get_where('riwayat_pengeluaran', ['status_bukti !=' => 0])->result_array();
    foreach ($data_pengeluaran as $dp) {
      $cabang = $this->db->get_where('data_cabang', ['id' => $dp['id_cabang']])->row_array();
      $output .= '
                    <tr>
                        <td class="text-center">' . $no . '</td>
                        <td>' . $dp['kode_pesanan'] . '</td>
                        <td>' . $dp['tanggal_ind'] . '</td>
                        <td>' . $cabang['nama_cabang'] . '</td>
                        <td>Rp ' . rupiah($dp['total_pengeluaran']) . '</td>                        
                    </tr>
                ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    return $output;
  }

  public function sam_search_history_pengeluaran()
  {
    $dari = $this->input->post('dari');
    $ke = $this->input->post('ke');
    $output = '';
    $no = 1;
    $output .= '
    <a href="'.base_url('export/excel_data_pengeluaran_ex/'.$dari.'/'.$ke.'/0').'" target="_blank" class="btn btn-outline-warning btn-sm mb-4" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>

    <table class="table table-striped" id="table-89">
    <thead>
        <tr>
            <th width="30" class="text-center">
                No
            </th>
            <th>Kode Pesanan</th>
            <th>Tanggal</th>
            <th>Cabang</th>
            <th>Total Pengeluaran</th>
        </tr>
    </thead>
    <tbody>
            
        ';
    $query = "SELECT * FROM riwayat_pengeluaran WHERE status_bukti != '0' AND tanggal_ind BETWEEN '$dari' AND '$ke'";
    $data_pengeluaran = $this->db->query($query)->result_array();
    foreach ($data_pengeluaran as $dp) {
      $cabang = $this->db->get_where('data_cabang', ['id' => $dp['id_cabang']])->row_array();
      $output .= '
      <tr>
      <td class="text-center">' . $no . '</td>
      <td>' . $dp['kode_pesanan'] . '</td>
      <td>' . $dp['tanggal_ind'] . '</td>
      <td>' . $cabang['nama_cabang'] . '</td>
      <td>Rp ' . rupiah($dp['total_pengeluaran']) . '</td>                        
      </tr>
                ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    echo $output;
  }

  public function sam_history_pengeluaran_c($id)
  {
    $output = '';
    $no = 1;
    $output .= '
        <table class="table table-striped" id="table-89">
            <thead>
                <tr>
                    <th width="30" class="text-center">
                        No
                    </th>
                    <th>Kode Pesanan</th>
                    <th>Tanggal</th>
                    <th>Cabang</th>
                    <th>Total Pengeluaran</th>
                </tr>
            </thead>
            <tbody>
                
            
        ';
    $this->db->order_by('id', 'desc');
    $data_pengeluaran = $this->db->get_where('riwayat_pengeluaran', ['status_bukti !=' => 0, 'id_cabang' => $id])->result_array();
    foreach ($data_pengeluaran as $dp) {
      $cabang = $this->db->get_where('data_cabang', ['id' => $id])->row_array();
      $output .= '
                    <tr>
                        <td class="text-center">' . $no . '</td>
                        <td>' . $dp['kode_pesanan'] . '</td>
                        <td>' . $dp['tanggal_ind'] . '</td>
                        <td>' . $cabang['nama_cabang'] . '</td>
                        <td>Rp ' . rupiah($dp['total_pengeluaran']) . '</td>                        
                    </tr>
                ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    return $output;
  }

  public function sam_search_history_pengeluaran_c($id)
  {
    $dari = $this->input->post('dari');
    $ke = $this->input->post('ke');
    $output = '';
    $no = 1;
    $output .= '
    <a href="'.base_url('export/excel_data_pengeluaran_ex/'.$dari.'/'.$ke.'/'.$id).'" target="_blank" class="btn btn-outline-warning btn-sm mb-4" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>

    <table class="table table-striped" id="table-89">
    <thead>
        <tr>
            <th width="30" class="text-center">
                No
            </th>
            <th>Kode Pesanan</th>
            <th>Tanggal</th>
            <th>Cabang</th>
            <th>Total Pengeluaran</th>
        </tr>
    </thead>
    <tbody>
            
        ';
    $query = "SELECT * FROM riwayat_pengeluaran WHERE id_cabang = '$id' AND status_bukti != '0' AND tanggal_ind BETWEEN '$dari' AND '$ke'";
    $data_pengeluaran = $this->db->query($query)->result_array();
    foreach ($data_pengeluaran as $dp) {
      $cabang = $this->db->get_where('data_cabang', ['id' => $id])->row_array();
      $output .= '
      <tr>
      <td class="text-center">' . $no . '</td>
      <td>' . $dp['kode_pesanan'] . '</td>
      <td>' . $dp['tanggal_ind'] . '</td>
      <td>' . $cabang['nama_cabang'] . '</td>
      <td>Rp ' . rupiah($dp['total_pengeluaran']) . '</td>                        
      </tr>
                ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    echo $output;
  }


  public function sam_wegot_history_percabang($id)
  {
    $output = '';
    $no = 1;
    $output .= '
    <table class="table table-striped" id="table-89">
        <thead>
          <tr>
              <th width="30" class="text-center">
                No
              </th>
              <th>ID Penjualan</th>
              <th>Tanggal</th>
              <th>Cabang</th>
              <th>Total Barang</th>
              <th>Total Pembayaran</th>
              <th>Metode Bayar</th>
              <th>Aksi</th>
          </>
        </thead>
        <tbody>
            
        
    ';
    $this->db->order_by('id', 'desc');
    $data_penjualan = $this->db->get_where('riwayat_penjualan', ['id_cabang' => $id])->result_array();
    foreach ($data_penjualan as $dp) {
      $d_cabang = $this->db->get_where('data_cabang', ['id' => $dp['id_cabang']])->row_array();
      if ($dp['metode_bayar'] == 'tunai') {
        $span_class = 'badge-info';
        $status_cicilan = '';
      } else {
        $span_class = 'badge-secondary';
        if ($dp['status_utang'] == 0) {

          $status_cicilan = '<span class="badge badge-success mt-1">Lunas</span>';
        } else {
          $status_cicilan = '<span class="badge badge-danger mt-1">Belum Lunas</span>';
        }
      }

      if ($dp['status_utang'] == 0 && $dp['metode_bayar'] == 'tunai') {
        $tombol = '
        <a href="' . base_url('cetak/data_penjualan/' . $dp['id_pembelian']) . '" target="_blank" title="Print Nota" class="btn btn-sm btn-primary mb-1"><i class="fas fa-print"></i></a>
        <a href="' . base_url('cetak/struk_penjualan/' . $dp['id_pembelian']) . '" title="Print Struk" target="_blank" class="btn btn-sm btn-outline-danger mb-1"><i class="fas fa-print"></i> Struk</a>
        ';
      } elseif ($dp['status_utang'] == 0 && $dp['metode_bayar'] == 'cicilan') {
        $tombol = '
        <a href="' . base_url('cetak/data_cicilan/' . $dp['id_pembayaran_cicilan']) . '" target="_blank" title="Print Nota" class="btn btn-sm btn-primary mb-1"><i class="fas fa-print"></i></a>
        <a href="' . base_url('cetak/struk_pembayaran_cicilan/' . $dp['id_pembayaran_cicilan']) . '" title="Print Struk" target="_blank" class="btn btn-sm btn-outline-danger mb-1"><i class="fas fa-print"></i> Struk</a>
        ';
      } else {

        $tombol = '';
      }
      $a = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $dp['id_keranjang']])->num_rows();
      $output .= '
      <tr>
      <td class="text-center">' . $no . '</td>
      <td>' . $dp['id_pembelian'] . '</td>
      <td>' . $dp['tanggal'] . '</td>
      <td>' . $d_cabang['nama_cabang'] . '</td>
      <td>' . $a . '</td>
      <td>Rp ' . rupiah($dp['total_pembayaran']) . '</td>
      <td><span class="badge ' . $span_class . '">' . $dp['metode_bayar'] . '</span> <br>' . $status_cicilan . '</td>
      <td>
          <div class="btn-group-horizontal text-center">
              <button class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#modalUbahSiswa_' . $dp['id'] . '"><i class="fas fa-eye"></i> Detail</button>

              ' . $tombol . '
          </div>
      </td>
  </tr>
            ';
      $no++;
    }
    $output .= '
    </tbody>
    </table>
    <script>
    $("#table-89").dataTable({

    });
    </script>
    ';
    return $output;
  }

  public function sam_search_history()
  {
    $dari = $this->input->post('dari');
    $ke = $this->input->post('ke');
    $output = '';
    $no = 1;
    $output .= '
    <a href="'.base_url('export/excel_history_penjualan_ex/'.$dari.'/'.$ke.'/0').'" target="_blank" class="btn btn-outline-warning btn-sm mb-4" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
        <table class="table table-striped" id="table-89">
            <thead>
                <tr>
                  <th width="30" class="text-center">
                    No
                  </th>
                  <th>ID Penjualan</th>
                  <th>Tanggal</th>
                  <th>Cabang</th>
                  <th>Total Barang</th>
                  <th>Total Pembayaran</th>
                  <th>Metode Bayar</th>
                  <th>Aksi</th>
              </tr>
                </tr>
            </thead>
            <tbody>
                
            
        ';
    $query = "SELECT * FROM riwayat_penjualan WHERE tanggal_ind BETWEEN '$dari' AND '$ke'";
    $data_penjualan = $this->db->query($query)->result_array();
    foreach ($data_penjualan as $dp) {
      $d_cabang = $this->db->get_where('data_cabang', ['id' => $dp['id_cabang']])->row_array();
      if ($dp['metode_bayar'] == 'tunai') {
        $span_class = 'badge-info';
        $status_cicilan = '';
      } else {
        $span_class = 'badge-secondary';
        if ($dp['status_utang'] == 0) {

          $status_cicilan = '<span class="badge badge-success mt-1">Lunas</span>';
        } else {
          $status_cicilan = '<span class="badge badge-danger mt-1">Belum Lunas</span>';
        }
      }

      if ($dp['status_utang'] == 0 && $dp['metode_bayar'] == 'tunai') {
        $tombol = '
        <a href="' . base_url('cetak/data_penjualan/' . $dp['id_pembelian']) . '" target="_blank" title="Print Nota" class="btn btn-sm btn-primary mb-1"><i class="fas fa-print"></i></a>
        <a href="' . base_url('cetak/struk_penjualan/' . $dp['id_pembelian']) . '" title="Print Struk" target="_blank" class="btn btn-sm btn-outline-danger mb-1"><i class="fas fa-print"></i> Struk</a>
        ';
      } elseif ($dp['status_utang'] == 0 && $dp['metode_bayar'] == 'cicilan') {
        $tombol = '
        <a href="' . base_url('cetak/data_cicilan/' . $dp['id_pembayaran_cicilan']) . '" target="_blank" title="Print Nota" class="btn btn-sm btn-primary mb-1"><i class="fas fa-print"></i></a>
        <a href="' . base_url('cetak/struk_pembayaran_cicilan/' . $dp['id_pembayaran_cicilan']) . '" title="Print Struk" target="_blank" class="btn btn-sm btn-outline-danger mb-1"><i class="fas fa-print"></i> Struk</a>
        ';
      } else {

        $tombol = '';
      }
      $a = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $dp['id_keranjang']])->num_rows();
      $output .= '
                  <tr>
                  <td class="text-center">' . $no . '</td>
                  <td>' . $dp['id_pembelian'] . '</td>
                  <td>' . $dp['tanggal'] . '</td>
                  <td>' . $d_cabang['nama_cabang'] . '</td>
                  <td>' . $a . '</td>
                  <td>Rp ' . rupiah($dp['total_pembayaran']) . '</td>
                  <td><span class="badge ' . $span_class . '">' . $dp['metode_bayar'] . '</span> <br>' . $status_cicilan . '</td>
                  <td>
                      <div class="btn-group-horizontal text-center">
                          <button class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#modalUbahSiswa_' . $dp['id'] . '"><i class="fas fa-eye"></i> Detail</button>

                          ' . $tombol . '
                      </div>
                  </td>
              </tr>
                ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    echo $output;
  }

  public function sam_search_history_percabang($id)
  {
    $dari = $this->input->post('dari');
    $ke = $this->input->post('ke');
    $output = '';
    $no = 1;
    $output .= '
    <a href="'.base_url('export/excel_history_penjualan_ex/'.$dari.'/'.$ke.'/'.$id).'" target="_blank" class="btn btn-outline-warning btn-sm mb-4" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
        <table class="table table-striped" id="table-89">
            <thead>
                <tr>
                    <th width="30" class="text-center">
                        No
                    </th>
                    <th>ID Penjualan</th>
                    <th>Tanggal</th>
                    <th>Cabang</th>
                  <th>Total Barang</th>
                  <th>Total Pembayaran</th>
                  <th>Metode Bayar</th>
                  <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                
            
        ';
    $query = "SELECT * FROM riwayat_penjualan WHERE tanggal_ind BETWEEN '$dari' AND '$ke' AND id_cabang ='$id'";
    $data_penjualan = $this->db->query($query)->result_array();
    foreach ($data_penjualan as $dp) {
      $d_cabang = $this->db->get_where('data_cabang', ['id' => $dp['id_cabang']])->row_array();
      if ($dp['metode_bayar'] == 'tunai') {
        $span_class = 'badge-info';
        $status_cicilan = '';
      } else {
        $span_class = 'badge-secondary';
        if ($dp['status_utang'] == 0) {

          $status_cicilan = '<span class="badge badge-success mt-1">Lunas</span>';
        } else {
          $status_cicilan = '<span class="badge badge-danger mt-1">Belum Lunas</span>';
        }
      }

      if ($dp['status_utang'] == 0 && $dp['metode_bayar'] == 'tunai') {
        $tombol = '
        <a href="' . base_url('cetak/data_penjualan/' . $dp['id_pembelian']) . '" target="_blank" title="Print Nota" class="btn btn-sm btn-primary mb-1"><i class="fas fa-print"></i></a>
        <a href="' . base_url('cetak/struk_penjualan/' . $dp['id_pembelian']) . '" title="Print Struk" target="_blank" class="btn btn-sm btn-outline-danger mb-1"><i class="fas fa-print"></i> Struk</a>
        ';
      } elseif ($dp['status_utang'] == 0 && $dp['metode_bayar'] == 'cicilan') {
        $tombol = '
        <a href="' . base_url('cetak/data_cicilan/' . $dp['id_pembayaran_cicilan']) . '" target="_blank" title="Print Nota" class="btn btn-sm btn-primary mb-1"><i class="fas fa-print"></i></a>
        <a href="' . base_url('cetak/struk_pembayaran_cicilan/' . $dp['id_pembayaran_cicilan']) . '" title="Print Struk" target="_blank" class="btn btn-sm btn-outline-danger mb-1"><i class="fas fa-print"></i> Struk</a>
        ';
      } else {

        $tombol = '';
      }
      $a = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $dp['id_keranjang']])->num_rows();
      $output .= '
      <tr>
      <td class="text-center">' . $no . '</td>
      <td>' . $dp['id_pembelian'] . '</td>
      <td>' . $dp['tanggal'] . '</td>
      <td>' . $d_cabang['nama_cabang'] . '</td>
      <td>' . $a . '</td>
      <td>Rp ' . rupiah($dp['total_pembayaran']) . '</td>
      <td><span class="badge ' . $span_class . '">' . $dp['metode_bayar'] . '</span> <br>' . $status_cicilan . '</td>
      <td>
          <div class="btn-group-horizontal text-center">
              <button class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#modalUbahSiswa_' . $dp['id'] . '"><i class="fas fa-eye"></i> Detail</button>

              ' . $tombol . '
          </div>
      </td>
  </tr>
                ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    echo $output;
  }

  public function sam_data_jual_hari()
  {
    $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $penempatan = $data['user']['penempatan_cabang'];
    $output = '';
    $no = 1;
    $output .= '

    <table class="table table-striped" id="table-89">
        <thead>
            <tr>
                <th width="30" class="text-center">
                    No
                </th>
                <th>Tanggal</th>
                <th>Total Penjualan</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            
        
    ';

    $dats = "SELECT DISTINCT tanggal_ind FROM riwayat_penjualan WHERE id_cabang='1'";

    $anjay = $this->db->query($dats)->result_array();



    foreach ($anjay as $dp) {
      $this->db->select_sum('total_pembayaran');
      $total_pembayaran = $this->db->get_where('riwayat_penjualan', ['tanggal_ind' => $dp['tanggal_ind'], 'id_cabang' => 1])->row_array();
      $this->db->select_sum('pendapatan');
      $total_pendapatan = $this->db->get_where('riwayat_penjualan', ['tanggal_ind' => $dp['tanggal_ind'], 'id_cabang' => 1])->row_array();

      $bersih = $total_pendapatan['pendapatan'];
      $output .= '
                <tr>
                    <td class="text-center">' . $no . '</td>
                    <td>' . $dp['tanggal_ind'] . '</td>
                    <td>Rp ' . rupiah($total_pembayaran['total_pembayaran']) . '</td>
                    <td>Rp ' . rupiah($bersih) . '</td>
                    
                </tr>
            ';
      $no++;
    }
    $output .= '
    </tbody>
    </table>
    <script>
    $("#table-89").dataTable({

    });
    </script>
    ';
    return $output;
  }


  public function sam_data_jual_hari_cabang($id)
  {
    $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $penempatan = $data['user']['penempatan_cabang'];
    $output = '';
    $no = 1;
    $output .= '
        <table class="table table-striped" id="table-89">
            <thead>
                <tr>
                    <th width="30" class="text-center">
                        No
                    </th>
                    <th>Tanggal</th>
                    <th>Total Penjualan</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                
            
        ';

    $dats = "SELECT DISTINCT tanggal_ind FROM riwayat_penjualan WHERE id_cabang = '$id'";

    $anjay = $this->db->query($dats)->result_array();

    foreach ($anjay as $dp) {
      $this->db->select_sum('total_pembayaran');
      $total_pembayaran = $this->db->get_where('riwayat_penjualan', ['tanggal_ind' => $dp['tanggal_ind'], 'id_cabang' => $id])->row_array();
      $this->db->select_sum('pendapatan');
      $total_pendapatan = $this->db->get_where('riwayat_penjualan', ['tanggal_ind' => $dp['tanggal_ind'], 'id_cabang' => $id])->row_array();

      $bersih = $total_pendapatan['pendapatan'];
      $output .= '
                    <tr>
                        <td class="text-center">' . $no . '</td>
                        <td>' . $dp['tanggal_ind'] . '</td>
                        <td>Rp ' . rupiah($total_pembayaran['total_pembayaran']) . '</td>
                        <td>Rp ' . rupiah($bersih) . '</td>
                        
                    </tr>
                ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    return $output;
  }

  public function sam_search_data_jual_hari()
  {
    $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $penempatan = $data['user']['penempatan_cabang'];
    $dari = $this->input->post('dari');
    $ke = $this->input->post('ke');
    $output = '';
    $no = 1;
    $output .= '
    <a href="'.base_url('export/excel_data_penjualan_hari_ex/'.$dari.'/'.$ke.'/1').'" target="_blank" class="btn btn-outline-warning btn-sm mb-4" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
        <table class="table table-striped" id="table-89">
            <thead>
                <tr>
                    <th width="30" class="text-center">
                        No
                    </th>
                    <th>Tanggal</th>
                    <th>Total Penjualan</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                
            
        ';

    $dats = "SELECT DISTINCT tanggal_ind FROM riwayat_penjualan WHERE tanggal_ind BETWEEN '$dari' AND '$ke' AND id_cabang = '1'";

    $anjay = $this->db->query($dats)->result_array();

    foreach ($anjay as $dp) {
      $this->db->select_sum('total_pembayaran');
      $total_pembayaran = $this->db->get_where('riwayat_penjualan', ['tanggal_ind' => $dp['tanggal_ind'], 'id_cabang' => 1])->row_array();
      $this->db->select_sum('pendapatan');
      $total_pendapatan = $this->db->get_where('riwayat_penjualan', ['tanggal_ind' => $dp['tanggal_ind'], 'id_cabang' => 1])->row_array();

      $bersih = $total_pendapatan['pendapatan'];
      $output .= '
                    <tr>
                        <td class="text-center">' . $no . '</td>
                        <td>' . $dp['tanggal_ind'] . '</td>
                        <td>Rp ' . rupiah($total_pembayaran['total_pembayaran']) . '</td>
                        <td>Rp ' . rupiah($bersih) . '</td>
                        
                    </tr>
                ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    echo $output;
  }

  public function sam_search_data_jual_hari_cabang($id)
  {
    $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $penempatan = $data['user']['penempatan_cabang'];
    $dari = $this->input->post('dari');
    $ke = $this->input->post('ke');
    $output = '';
    $no = 1;
    $output .= '
        <a href="'.base_url('export/excel_data_penjualan_hari_ex/'.$dari.'/'.$ke.'/'.$id).'" target="_blank" class="btn btn-outline-warning btn-sm mb-4" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>

        <table class="table table-striped" id="table-89">
            <thead>
                <tr>
                    <th width="30" class="text-center">
                        No
                    </th>
                    <th>Tanggal</th>
                    <th>Total Penjualan</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                
            
        ';

    $dats = "SELECT DISTINCT tanggal_ind FROM riwayat_penjualan WHERE tanggal_ind BETWEEN '$dari' AND '$ke' AND id_cabang = '$id'";

    $anjay = $this->db->query($dats)->result_array();

    foreach ($anjay as $dp) {
      $this->db->select_sum('total_pembayaran');
      $total_pembayaran = $this->db->get_where('riwayat_penjualan', ['tanggal_ind' => $dp['tanggal_ind'], 'id_cabang' => $id])->row_array();
      $this->db->select_sum('pendapatan');
      $total_pendapatan = $this->db->get_where('riwayat_penjualan', ['tanggal_ind' => $dp['tanggal_ind'], 'id_cabang' => $id])->row_array();

      $bersih = $total_pendapatan['pendapatan'];
      $output .= '
                    <tr>
                        <td class="text-center">' . $no . '</td>
                        <td>' . $dp['tanggal_ind'] . '</td>
                        <td>Rp ' . rupiah($total_pembayaran['total_pembayaran']) . '</td>
                        <td>Rp ' . rupiah($bersih) . '</td>
                        
                    </tr>
                ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    echo $output;
  }

  public function sam_data_jual_bulan()
  {
    $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $penempatan = $data['user']['penempatan_cabang'];
    $output = '';
    $no = 1;
    $output .= '
        <table class="table table-striped" id="table-89">
            <thead>
                <tr>
                    <th width="30" class="text-center">
                        No
                    </th>
                    <th>Tanggal</th>
                    <th>Total Penjualan</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                
            
        ';

    $this->db->order_by('single_tahun', 'desc');
    $dats = "SELECT DISTINCT bulan_ind FROM riwayat_penjualan WHERE id_cabang='1'";

    $anjay = $this->db->query($dats)->result_array();

    foreach ($anjay as $dp) {
      $this->db->select_sum('total_pembayaran');
      $total_pembayaran = $this->db->get_where('riwayat_penjualan', ['bulan_ind' => $dp['bulan_ind'], 'id_cabang' => 1])->row_array();
      $this->db->select_sum('pendapatan');
      $total_pendapatan = $this->db->get_where('riwayat_penjualan', ['bulan_ind' => $dp['bulan_ind'], 'id_cabang' => 1])->row_array();

      $split = $dp['bulan_ind'];
      $split = explode('-', $split);
      $nama_bulan = '';
      if ($split[0] == '01') {
        $nama_bulan = 'Januari ' . $split[1];
      } elseif ($split[0] == '02') {
        $nama_bulan = 'Februari ' . $split[1];
      } elseif ($split[0] == '03') {
        $nama_bulan = 'Maret ' . $split[1];
      } elseif ($split[0] == '04') {
        $nama_bulan = 'April ' . $split[1];
      } elseif ($split[0] == '05') {
        $nama_bulan = 'Mei ' . $split[1];
      } elseif ($split[0] == '06') {
        $nama_bulan = 'Juni ' . $split[1];
      } elseif ($split[0] == '07') {
        $nama_bulan = 'Juli ' . $split[1];
      } elseif ($split[0] == '08') {
        $nama_bulan = 'Agustus ' . $split[1];
      } elseif ($split[0] == '09') {
        $nama_bulan = 'September ' . $split[1];
      } elseif ($split[0] == '10') {
        $nama_bulan = 'Oktober ' . $split[1];
      } elseif ($split[0] == '11') {
        $nama_bulan = 'November ' . $split[1];
      } elseif ($split[0] == '12') {
        $nama_bulan = 'Desember ' . $split[1];
      }
      $bersih = $total_pendapatan['pendapatan'];
      $output .= '
                    <tr>
                        <td class="text-center">' . $no . '</td>
                        <td>' . $nama_bulan . '</td>
                        <td>Rp ' . rupiah($total_pembayaran['total_pembayaran']) . '</td>
                        <td>Rp ' . rupiah($bersih) . '</td>
                        
                    </tr>
                ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    return $output;
  }

  public function sam_data_jual_bulan_cabang($id)
  {
    $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $penempatan = $data['user']['penempatan_cabang'];
    $output = '';
    $no = 1;
    $output .= '
        <table class="table table-striped" id="table-89">
            <thead>
                <tr>
                    <th width="30" class="text-center">
                        No
                    </th>
                    <th>Tanggal</th>
                    <th>Total Penjualan</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                
            
        ';

    $this->db->order_by('single_tahun', 'desc');
    $dats = "SELECT DISTINCT bulan_ind FROM riwayat_penjualan WHERE id_cabang='$id'";

    $anjay = $this->db->query($dats)->result_array();

    foreach ($anjay as $dp) {
      $this->db->select_sum('total_pembayaran');
      $total_pembayaran = $this->db->get_where('riwayat_penjualan', ['bulan_ind' => $dp['bulan_ind'], 'id_cabang' => $id])->row_array();
      $this->db->select_sum('pendapatan');
      $total_pendapatan = $this->db->get_where('riwayat_penjualan', ['bulan_ind' => $dp['bulan_ind'], 'id_cabang' => $id])->row_array();

      $split = $dp['bulan_ind'];
      $split = explode('-', $split);
      $nama_bulan = '';
      if ($split[0] == '01') {
        $nama_bulan = 'Januari ' . $split[1];
      } elseif ($split[0] == '02') {
        $nama_bulan = 'Februari ' . $split[1];
      } elseif ($split[0] == '03') {
        $nama_bulan = 'Maret ' . $split[1];
      } elseif ($split[0] == '04') {
        $nama_bulan = 'April ' . $split[1];
      } elseif ($split[0] == '05') {
        $nama_bulan = 'Mei ' . $split[1];
      } elseif ($split[0] == '06') {
        $nama_bulan = 'Juni ' . $split[1];
      } elseif ($split[0] == '07') {
        $nama_bulan = 'Juli ' . $split[1];
      } elseif ($split[0] == '08') {
        $nama_bulan = 'Agustus ' . $split[1];
      } elseif ($split[0] == '09') {
        $nama_bulan = 'September ' . $split[1];
      } elseif ($split[0] == '10') {
        $nama_bulan = 'Oktober ' . $split[1];
      } elseif ($split[0] == '11') {
        $nama_bulan = 'November ' . $split[1];
      } elseif ($split[0] == '12') {
        $nama_bulan = 'Desember ' . $split[1];
      }
      $bersih = $total_pendapatan['pendapatan'];
      $output .= '
                    <tr>
                        <td class="text-center">' . $no . '</td>
                        <td>' . $nama_bulan . '</td>
                        <td>Rp ' . rupiah($total_pembayaran['total_pembayaran']) . '</td>
                        <td>Rp ' . rupiah($bersih) . '</td>
                        
                    </tr>
                ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    return $output;
  }

  public function sam_search_data_jual_bulan()
  {
    $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $penempatan = $data['user']['penempatan_cabang'];
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    $output = '';
    $no = 1;
    $output .= '
    
        <table class="table table-striped" id="table-89">
            <thead>
                <tr>
                    <th width="30" class="text-center">
                        No
                    </th>
                    <th>Tanggal</th>
                    <th>Total Penjualan</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                
            
        ';

    $dats = "SELECT DISTINCT bulan_ind FROM riwayat_penjualan WHERE single_bulan='$bulan' AND single_tahun='$tahun' AND id_cabang = '1'";

    $anjay = $this->db->query($dats)->result_array();

    foreach ($anjay as $dp) {
      $this->db->select_sum('total_pembayaran');
      $total_pembayaran = $this->db->get_where('riwayat_penjualan', ['bulan_ind' => $dp['bulan_ind'], 'id_cabang' => 1])->row_array();
      $this->db->select_sum('pendapatan');
      $total_pendapatan = $this->db->get_where('riwayat_penjualan', ['bulan_ind' => $dp['bulan_ind'], 'id_cabang' => 1])->row_array();

      $split = $dp['bulan_ind'];
      $split = explode('-', $split);
      $nama_bulan = '';
      if ($split[0] == '01') {
        $nama_bulan = 'Januari ' . $split[1];
      } elseif ($split[0] == '02') {
        $nama_bulan = 'Februari ' . $split[1];
      } elseif ($split[0] == '03') {
        $nama_bulan = 'Maret ' . $split[1];
      } elseif ($split[0] == '04') {
        $nama_bulan = 'April ' . $split[1];
      } elseif ($split[0] == '05') {
        $nama_bulan = 'Mei ' . $split[1];
      } elseif ($split[0] == '06') {
        $nama_bulan = 'Juni ' . $split[1];
      } elseif ($split[0] == '07') {
        $nama_bulan = 'Juli ' . $split[1];
      } elseif ($split[0] == '08') {
        $nama_bulan = 'Agustus ' . $split[1];
      } elseif ($split[0] == '09') {
        $nama_bulan = 'September ' . $split[1];
      } elseif ($split[0] == '10') {
        $nama_bulan = 'Oktober ' . $split[1];
      } elseif ($split[0] == '11') {
        $nama_bulan = 'November ' . $split[1];
      } elseif ($split[0] == '12') {
        $nama_bulan = 'Desember ' . $split[1];
      }
      $bersih = $total_pendapatan['pendapatan'];
      $output .= '
                    <tr>
                        <td class="text-center">' . $no . '</td>
                        <td>' . $nama_bulan . '</td>
                        <td>Rp ' . rupiah($total_pembayaran['total_pembayaran']) . '</td>
                        <td>Rp ' . rupiah($bersih) . '</td>
                        
                    </tr>
                ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    echo $output;
  }

  public function sam_search_data_jual_bulan_cabang($id)
  {
    $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $penempatan = $data['user']['penempatan_cabang'];
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    $output = '';
    $no = 1;
    $output .= '
        <table class="table table-striped" id="table-89">
            <thead>
                <tr>
                    <th width="30" class="text-center">
                        No
                    </th>
                    <th>Tanggal</th>
                    <th>Total Penjualan</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                
            
        ';

    $dats = "SELECT DISTINCT bulan_ind FROM riwayat_penjualan WHERE id_cabang = '$id' AND single_bulan='$bulan' AND single_tahun='$tahun'";

    $anjay = $this->db->query($dats)->result_array();

    foreach ($anjay as $dp) {
      $this->db->select_sum('total_pembayaran');
      $total_pembayaran = $this->db->get_where('riwayat_penjualan', ['bulan_ind' => $dp['bulan_ind'], 'id_cabang' => $id])->row_array();
      $this->db->select_sum('pendapatan');
      $total_pendapatan = $this->db->get_where('riwayat_penjualan', ['bulan_ind' => $dp['bulan_ind'], 'id_cabang' => $id])->row_array();

      $split = $dp['bulan_ind'];
      $split = explode('-', $split);
      $nama_bulan = '';
      if ($split[0] == '01') {
        $nama_bulan = 'Januari ' . $split[1];
      } elseif ($split[0] == '02') {
        $nama_bulan = 'Februari ' . $split[1];
      } elseif ($split[0] == '03') {
        $nama_bulan = 'Maret ' . $split[1];
      } elseif ($split[0] == '04') {
        $nama_bulan = 'April ' . $split[1];
      } elseif ($split[0] == '05') {
        $nama_bulan = 'Mei ' . $split[1];
      } elseif ($split[0] == '06') {
        $nama_bulan = 'Juni ' . $split[1];
      } elseif ($split[0] == '07') {
        $nama_bulan = 'Juli ' . $split[1];
      } elseif ($split[0] == '08') {
        $nama_bulan = 'Agustus ' . $split[1];
      } elseif ($split[0] == '09') {
        $nama_bulan = 'September ' . $split[1];
      } elseif ($split[0] == '10') {
        $nama_bulan = 'Oktober ' . $split[1];
      } elseif ($split[0] == '11') {
        $nama_bulan = 'November ' . $split[1];
      } elseif ($split[0] == '12') {
        $nama_bulan = 'Desember ' . $split[1];
      }
      $bersih = $total_pendapatan['pendapatan'];
      $output .= '
                    <tr>
                        <td class="text-center">' . $no . '</td>
                        <td>' . $nama_bulan . '</td>
                        <td>Rp ' . rupiah($total_pembayaran['total_pembayaran']) . '</td>
                        <td>Rp ' . rupiah($bersih) . '</td>
                        
                    </tr>
                ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    echo $output;
  }

  public function sam_wegot_data_barang()
  {
    $output = '';
    $no = 1;
    $output .= '
        <table class="table table-striped" id="table-89">
            <thead>
                <tr>
                    <th width="30" class="text-center">
                        No
                    </th>
                    <th width="80">Kode</th>
                    <th width="60">Kategori</th>
                    <th width="120">Nama Barang</th>
                    <th width="50">Stok</th>
                    <th width="80">Harga</th>
                    <th width="120"></th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
        ';
    $this->db->order_by('nama_barang', 'asc');
    $data_barang = $this->db->get_where('barang', ['id_cabang' => 1])->result_array();

    foreach ($data_barang as $db) {
      if ($db['stok'] < 1) {
        $btnBuy = '<button class="btn btn-primary btn-sm mb-1" disabled><i class="fas fa-check"></i> Beli</button>';
      } else {
        $btnBuy = ' <button type="submit" data-id="' . $db['id'] . '" class="btn btn-primary btn-sm mb-1 btn-save"><i class="fas fa-check"></i> Beli</button>';
      }
      $output .= '
            <tr>
                <input type="hidden" class="idCabang-' . $db['id'] . '" name="id_cabang" value="' . $db['id_cabang'] . '">
                <input type="hidden" class="idBarang-' . $db['id'] . '" name="id_barang" value="' . $db['id'] . '">
                <input type="hidden" class="hargaBarang-' . $db['id'] . '" name="harga_barang" value="' . $db['harga_jual'] . '">
                <input type="hidden" class="profit-' . $db['id'] . '" name="profit" value="' . $db['profit'] . '">
                <input type="hidden" class="satuan-' . $db['id'] . '" name="satuan" value="' . $db['satuan'] . '" id="">

                <td class="text-center">
                    ' . $no . '
                </td>
                <td>
                    ' . $db['barcode'] . '
                </td>
                <td>
                    ' . $db['kategori'] . '
                </td>
                <td>
                    ' . $db['nama_barang'] . '
                </td>
                <td>
                    ' . $db['stok'] . ' ' . $db['satuan'] . '
                </td>

                <td>
                    Rp. ' . rupiah($db['harga_jual']) . '
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" name="jml" min="1" value="1" max="' . $db['stok'] . '" data-stok="' . $db['stok'] . '" required class="form-control inp-jum inputId-' . $db['id'] . '">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                ' . $db['satuan'] . '
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="btn-group-horizontal text-center">
                        ' . $btnBuy . '
                    </div>
                </td>

        </tr>
            ';
      $no++;
    }

    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    return $output;
  }

  function tampil_keranjang()
  {
    return $this->sup_admin->sam_tampil_keranjang();
  }

  public function sam_ubah_d_keranjang()
  {
    $jumlah = $this->input->post('jumlah', true);
    $harga = $this->input->post('harga', true);
    $idCabang = $this->input->post('idCabang', true);
    $idUsr = $this->input->post('idUsr', true);
    $profit = $this->input->post('profit', true);
    $idBarang = $this->input->post('idBarang', true);
    $q = $this->db->get_where('barang', ['id' => $idBarang])->row_array();

    $hargaTotal = $harga * $jumlah;
    $data = [
      'jumlah' => $jumlah,
      'profit' => $q['profit'] * $jumlah,
      'harga_total' => $hargaTotal
    ];
    $this->db->set($data);
    $where = [
      'id_barang' => $idBarang,
      'id_cabang' => $idCabang,
      'id_pembelian' => 1,
      'id_user' => $idUsr
    ];
    $this->db->where($where);
    $this->db->update('keranjang');

    $data1 = [
      'jumlah' => $jumlah,
      'harga_total' => $hargaTotal,
      'profit' => $q['profit'] * $jumlah
    ];
    $this->db->set($data1);
    $where1 = [
      'id_cabang' => $idCabang,
      'id_keranjang' => 1,
      'id_user' => $idUsr,
      'id_barang' => $idBarang
    ];
    $this->db->where($where1);
    $this->db->update('semua_data_keranjang');
    echo $this->tampil_keranjang();
  }

  function search_bar($title)
  {
    $user = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $this->db->like('barcode', $title, 'both');
    $this->db->order_by('barcode', 'ASC');
    $this->db->limit(10);
    return $this->db->get_where('barang', ['id_cabang' => $user['penempatan_cabang']])->result();
  }

  public function sam_data_pengeluaran_hari()
  {
    $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $penempatan = $data['user']['penempatan_cabang'];
    $output = '';
    $no = 1;
    $output .= '
    <table class="table table-striped" id="table-89">
        <thead>
            <tr>
                <th width="30" class="text-center">
                    No
                </th>
                <th>Tanggal</th>
                <th>Total Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            
        
    ';

    $dats = "SELECT DISTINCT tanggal_ind FROM riwayat_pengeluaran WHERE id_cabang='1' AND status_bukti != '0'";

    $anjay = $this->db->query($dats)->result_array();

    foreach ($anjay as $dp) {
      $this->db->select_sum('total_pengeluaran');
      $total_pengeluaran = $this->db->get_where('riwayat_pengeluaran', ['tanggal_ind' => $dp['tanggal_ind'], 'id_cabang' => 1, 'status_bukti !=' => 0])->row_array();

      $output .= '
                <tr>
                    <td class="text-center">' . $no . '</td>
                    <td>' . $dp['tanggal_ind'] . '</td>
                    <td>Rp ' . rupiah($total_pengeluaran['total_pengeluaran']) . '</td>
                    
                </tr>
            ';
      $no++;
    }
    $output .= '
    </tbody>
    </table>
    <script>
    $("#table-89").dataTable({

    });
    </script>
    ';
    return $output;
  }

  public function sam_search_data_pengeluaran_hari()
  {
    $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $penempatan = $data['user']['penempatan_cabang'];
    $dari = $this->input->post('dari');
    $ke = $this->input->post('ke');
    $output = '';
    $no = 1;
    $output .= '
    <a href="'.base_url('export/excel_data_pengeluaran_hari_ex/'.$dari.'/'.$ke.'/1').'" target="_blank" class="btn btn-outline-warning btn-sm mb-4" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>

        <table class="table table-striped" id="table-89">
        <thead>
        <tr>
            <th width="30" class="text-center">
                No
            </th>
            <th>Tanggal</th>
            <th>Total Pengeluaran</th>
        </tr>
    </thead>
            <tbody>
                
            
        ';

    $dats = "SELECT DISTINCT tanggal_ind FROM riwayat_pengeluaran WHERE status_bukti != '0' AND tanggal_ind BETWEEN '$dari' AND '$ke' AND id_cabang = '1'";

    $anjay = $this->db->query($dats)->result_array();

    foreach ($anjay as $dp) {
      $this->db->select_sum('total_pengeluaran');
      $total_pengeluaran = $this->db->get_where('riwayat_pengeluaran', ['tanggal_ind' => $dp['tanggal_ind'], 'id_cabang' => 1, 'status_bukti !=' => 0])->row_array();

      $output .= '
                <tr>
                    <td class="text-center">' . $no . '</td>
                    <td>' . $dp['tanggal_ind'] . '</td>
                    <td>Rp ' . rupiah($total_pengeluaran['total_pengeluaran']) . '</td>
                    
                </tr>
            ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    echo $output;
  }

  public function sam_data_pengeluaran_hari_cabang($id)
  {
    $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $penempatan = $data['user']['penempatan_cabang'];
    $output = '';
    $no = 1;
    $output .= '
    <table class="table table-striped" id="table-89">
        <thead>
            <tr>
                <th width="30" class="text-center">
                    No
                </th>
                <th>Tanggal</th>
                <th>Total Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            
        
    ';

    $dats = "SELECT DISTINCT tanggal_ind FROM riwayat_pengeluaran WHERE id_cabang='$id' AND status_bukti != '0'";

    $anjay = $this->db->query($dats)->result_array();

    foreach ($anjay as $dp) {
      $this->db->select_sum('total_pengeluaran');
      $total_pengeluaran = $this->db->get_where('riwayat_pengeluaran', ['tanggal_ind' => $dp['tanggal_ind'], 'id_cabang' => $id, 'status_bukti !=' => 0])->row_array();

      $output .= '
                <tr>
                    <td class="text-center">' . $no . '</td>
                    <td>' . $dp['tanggal_ind'] . '</td>
                    <td>Rp ' . rupiah($total_pengeluaran['total_pengeluaran']) . '</td>
                    
                </tr>
            ';
      $no++;
    }
    $output .= '
    </tbody>
    </table>
    <script>
    $("#table-89").dataTable({

    });
    </script>
    ';
    return $output;
  }

  public function sam_search_data_pengeluaran_hari_c($id)
  {
    $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $penempatan = $data['user']['penempatan_cabang'];
    $dari = $this->input->post('dari');
    $ke = $this->input->post('ke');
    $output = '';
    $no = 1;
    $output .= '
    <a href="'.base_url('export/excel_data_pengeluaran_hari_ex/'.$dari.'/'.$ke.'/'.$id).'" target="_blank" class="btn btn-outline-warning btn-sm mb-4" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
        <table class="table table-striped" id="table-89">
        <thead>
        <tr>
            <th width="30" class="text-center">
                No
            </th>
            <th>Tanggal</th>
            <th>Total Pengeluaran</th>
        </tr>
    </thead>
            <tbody>
                
            
        ';

    $dats = "SELECT DISTINCT tanggal_ind FROM riwayat_pengeluaran WHERE status_bukti != '0' AND tanggal_ind BETWEEN '$dari' AND '$ke' AND id_cabang = '$id'";

    $anjay = $this->db->query($dats)->result_array();

    foreach ($anjay as $dp) {
      $this->db->select_sum('total_pengeluaran');
      $total_pengeluaran = $this->db->get_where('riwayat_pengeluaran', ['tanggal_ind' => $dp['tanggal_ind'], 'id_cabang' => $id, 'status_bukti !=' => 0])->row_array();

      $output .= '
                <tr>
                    <td class="text-center">' . $no . '</td>
                    <td>' . $dp['tanggal_ind'] . '</td>
                    <td>Rp ' . rupiah($total_pengeluaran['total_pengeluaran']) . '</td>
                    
                </tr>
            ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    echo $output;
  }

  public function sam_data_pengeluaran_bulan()
  {
    $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $penempatan = $data['user']['penempatan_cabang'];
    $output = '';
    $no = 1;
    $output .= '
        <table class="table table-striped" id="table-89">
            <thead>
                <tr>
                    <th width="30" class="text-center">
                        No
                    </th>
                    <th>Bulan</th>
                    <th>Total Pengeluaran</th>
                </tr>
            </thead>
            <tbody>
                
            
        ';

    $this->db->order_by('single_tahun', 'desc');
    $dats = "SELECT DISTINCT bulan_ind FROM riwayat_pengeluaran WHERE id_cabang='1' AND status_bukti != '0'";

    $anjay = $this->db->query($dats)->result_array();

    foreach ($anjay as $dp) {
      $this->db->select_sum('total_pengeluaran');
      $total_pengeluaran = $this->db->get_where('riwayat_pengeluaran', ['bulan_ind' => $dp['bulan_ind'], 'id_cabang' => 1, 'status_bukti !=' => 0])->row_array();

      $split = $dp['bulan_ind'];
      $split = explode('-', $split);
      $nama_bulan = '';
      if ($split[0] == '01') {
        $nama_bulan = 'Januari ' . $split[1];
      } elseif ($split[0] == '02') {
        $nama_bulan = 'Februari ' . $split[1];
      } elseif ($split[0] == '03') {
        $nama_bulan = 'Maret ' . $split[1];
      } elseif ($split[0] == '04') {
        $nama_bulan = 'April ' . $split[1];
      } elseif ($split[0] == '05') {
        $nama_bulan = 'Mei ' . $split[1];
      } elseif ($split[0] == '06') {
        $nama_bulan = 'Juni ' . $split[1];
      } elseif ($split[0] == '07') {
        $nama_bulan = 'Juli ' . $split[1];
      } elseif ($split[0] == '08') {
        $nama_bulan = 'Agustus ' . $split[1];
      } elseif ($split[0] == '09') {
        $nama_bulan = 'September ' . $split[1];
      } elseif ($split[0] == '10') {
        $nama_bulan = 'Oktober ' . $split[1];
      } elseif ($split[0] == '11') {
        $nama_bulan = 'November ' . $split[1];
      } elseif ($split[0] == '12') {
        $nama_bulan = 'Desember ' . $split[1];
      }
      $output .= '
                    <tr>
                        <td class="text-center">' . $no . '</td>
                        <td>' . $nama_bulan . '</td>
                        <td>Rp ' . rupiah($total_pengeluaran['total_pengeluaran']) . '</td>
                        
                    </tr>
                ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    return $output;
  }

  public function sam_search_data_pengeluaran_bulan()
  {
    $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $penempatan = $data['user']['penempatan_cabang'];
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    $output = '';
    $no = 1;
    $output .= '
        <table class="table table-striped" id="table-89">
            <thead>
            <tr>
            <th width="30" class="text-center">
                No
            </th>
            <th>Bulan</th>
            <th>Total Pengeluaran</th>
        </tr>
            </thead>
            <tbody>
                
            
        ';

    $dats = "SELECT DISTINCT bulan_ind FROM riwayat_pengeluaran WHERE single_bulan='$bulan' AND single_tahun='$tahun' AND id_cabang = '1' AND status_bukti != '0'";

    $anjay = $this->db->query($dats)->result_array();

    foreach ($anjay as $dp) {
      $this->db->select_sum('total_pengeluaran');
      $total_pengeluaran = $this->db->get_where('riwayat_pengeluaran', ['bulan_ind' => $dp['bulan_ind'], 'id_cabang' => 1, 'status_bukti !=' => 0])->row_array();

      $split = $dp['bulan_ind'];
      $split = explode('-', $split);
      $nama_bulan = '';
      if ($split[0] == '01') {
        $nama_bulan = 'Januari ' . $split[1];
      } elseif ($split[0] == '02') {
        $nama_bulan = 'Februari ' . $split[1];
      } elseif ($split[0] == '03') {
        $nama_bulan = 'Maret ' . $split[1];
      } elseif ($split[0] == '04') {
        $nama_bulan = 'April ' . $split[1];
      } elseif ($split[0] == '05') {
        $nama_bulan = 'Mei ' . $split[1];
      } elseif ($split[0] == '06') {
        $nama_bulan = 'Juni ' . $split[1];
      } elseif ($split[0] == '07') {
        $nama_bulan = 'Juli ' . $split[1];
      } elseif ($split[0] == '08') {
        $nama_bulan = 'Agustus ' . $split[1];
      } elseif ($split[0] == '09') {
        $nama_bulan = 'September ' . $split[1];
      } elseif ($split[0] == '10') {
        $nama_bulan = 'Oktober ' . $split[1];
      } elseif ($split[0] == '11') {
        $nama_bulan = 'November ' . $split[1];
      } elseif ($split[0] == '12') {
        $nama_bulan = 'Desember ' . $split[1];
      }
      $output .= '
      <tr>
      <td class="text-center">' . $no . '</td>
      <td>' . $nama_bulan . '</td>
      <td>Rp ' . rupiah($total_pengeluaran['total_pengeluaran']) . '</td>
      
  </tr>
                ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    echo $output;
  }

  public function sam_data_pengeluaran_bulan_cabang($id)
  {
    $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $penempatan = $data['user']['penempatan_cabang'];
    $output = '';
    $no = 1;
    $output .= '
        <table class="table table-striped" id="table-89">
            <thead>
                <tr>
                    <th width="30" class="text-center">
                        No
                    </th>
                    <th>Bulan</th>
                    <th>Total Pengeluaran</th>
                </tr>
            </thead>
            <tbody>
                
            
        ';

    $this->db->order_by('single_tahun', 'desc');
    $dats = "SELECT DISTINCT bulan_ind FROM riwayat_pengeluaran WHERE id_cabang='$id' AND status_bukti != '0'";

    $anjay = $this->db->query($dats)->result_array();

    foreach ($anjay as $dp) {
      $this->db->select_sum('total_pengeluaran');
      $total_pengeluaran = $this->db->get_where('riwayat_pengeluaran', ['bulan_ind' => $dp['bulan_ind'], 'id_cabang' => $id, 'status_bukti !=' => 0])->row_array();

      $split = $dp['bulan_ind'];
      $split = explode('-', $split);
      $nama_bulan = '';
      if ($split[0] == '01') {
        $nama_bulan = 'Januari ' . $split[1];
      } elseif ($split[0] == '02') {
        $nama_bulan = 'Februari ' . $split[1];
      } elseif ($split[0] == '03') {
        $nama_bulan = 'Maret ' . $split[1];
      } elseif ($split[0] == '04') {
        $nama_bulan = 'April ' . $split[1];
      } elseif ($split[0] == '05') {
        $nama_bulan = 'Mei ' . $split[1];
      } elseif ($split[0] == '06') {
        $nama_bulan = 'Juni ' . $split[1];
      } elseif ($split[0] == '07') {
        $nama_bulan = 'Juli ' . $split[1];
      } elseif ($split[0] == '08') {
        $nama_bulan = 'Agustus ' . $split[1];
      } elseif ($split[0] == '09') {
        $nama_bulan = 'September ' . $split[1];
      } elseif ($split[0] == '10') {
        $nama_bulan = 'Oktober ' . $split[1];
      } elseif ($split[0] == '11') {
        $nama_bulan = 'November ' . $split[1];
      } elseif ($split[0] == '12') {
        $nama_bulan = 'Desember ' . $split[1];
      }
      $output .= '
                    <tr>
                        <td class="text-center">' . $no . '</td>
                        <td>' . $nama_bulan . '</td>
                        <td>Rp ' . rupiah($total_pengeluaran['total_pengeluaran']) . '</td>
                        
                    </tr>
                ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    return $output;
  }

  public function sam_search_data_pengeluaran_bulan_cabang($id)
  {
    $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $penempatan = $data['user']['penempatan_cabang'];
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    $output = '';
    $no = 1;
    $output .= '
        <table class="table table-striped" id="table-89">
            <thead>
            <tr>
            <th width="30" class="text-center">
                No
            </th>
            <th>Bulan</th>
            <th>Total Pengeluaran</th>
        </tr>
            </thead>
            <tbody>
                
            
        ';

    $dats = "SELECT DISTINCT bulan_ind FROM riwayat_pengeluaran WHERE single_bulan='$bulan' AND single_tahun='$tahun' AND id_cabang = '$id' AND status_bukti != '0'";

    $anjay = $this->db->query($dats)->result_array();

    foreach ($anjay as $dp) {
      $this->db->select_sum('total_pengeluaran');
      $total_pengeluaran = $this->db->get_where('riwayat_pengeluaran', ['bulan_ind' => $dp['bulan_ind'], 'id_cabang' => $id, 'status_bukti !=' => 0])->row_array();

      $split = $dp['bulan_ind'];
      $split = explode('-', $split);
      $nama_bulan = '';
      if ($split[0] == '01') {
        $nama_bulan = 'Januari ' . $split[1];
      } elseif ($split[0] == '02') {
        $nama_bulan = 'Februari ' . $split[1];
      } elseif ($split[0] == '03') {
        $nama_bulan = 'Maret ' . $split[1];
      } elseif ($split[0] == '04') {
        $nama_bulan = 'April ' . $split[1];
      } elseif ($split[0] == '05') {
        $nama_bulan = 'Mei ' . $split[1];
      } elseif ($split[0] == '06') {
        $nama_bulan = 'Juni ' . $split[1];
      } elseif ($split[0] == '07') {
        $nama_bulan = 'Juli ' . $split[1];
      } elseif ($split[0] == '08') {
        $nama_bulan = 'Agustus ' . $split[1];
      } elseif ($split[0] == '09') {
        $nama_bulan = 'September ' . $split[1];
      } elseif ($split[0] == '10') {
        $nama_bulan = 'Oktober ' . $split[1];
      } elseif ($split[0] == '11') {
        $nama_bulan = 'November ' . $split[1];
      } elseif ($split[0] == '12') {
        $nama_bulan = 'Desember ' . $split[1];
      }
      $output .= '
      <tr>
      <td class="text-center">' . $no . '</td>
      <td>' . $nama_bulan . '</td>
      <td>Rp ' . rupiah($total_pengeluaran['total_pengeluaran']) . '</td>
      
  </tr>
                ';
      $no++;
    }
    $output .= '
        </tbody>
        </table>
        <script>
        $("#table-89").dataTable({

        });
        </script>
        ';
    echo $output;
  }

  public function sam_save_keranjang_barcode()
  {
    $user = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $barcode = $this->input->post('barcode');
    $cabang = $this->input->post('cabang');
    $barcode = str_replace('-', '', $barcode);
    $barcode = preg_replace('/[^0-9\-]/', '', $barcode);
    $barcode = substr($barcode, 0, 12);
    $row = $this->db->get_where('barang', ['barcode' => $barcode, 'id_cabang' => $cabang])->row_array();
    $id_barang = $row['id'];
    $id_cabang = $row['id_cabang'];
    $harga_barang = $row['harga_jual'];
    $satuan = $row['satuan'];
    $jml = 1;
    $harga_total = $jml * $harga_barang;
    $qker = $this->db->get_where('keranjang', ['barcode' => $barcode, 'id_cabang' => $user['penempatan_cabang'], 'id_user' => $user['id']])->row_array();

    if (!$row) {
      echo $this->tampil_keranjang();

      echo "<script>
            iziToast.error({
                message: 'Barang tidak ditemukan',
                position: 'topCenter'
            });
            </script>";
    } elseif ($row['stok'] < 1) {
      echo $this->tampil_keranjang();
      echo "<script>
            iziToast.warning({
                message: 'Stok barang habis',
                position: 'topCenter'
            });
            </script>";
    } elseif ($qker['barcode'] == $barcode) {
      echo $this->tampil_keranjang();

      echo "<script>
            iziToast.warning({
                message: 'Barang sudah ada dikeranjang',
                position: 'topCenter'
            });
            </script>";
    } elseif ($row) {
      $data = [
        'barcode' => $barcode,
        'id_barang' => $id_barang,
        'id_cabang' => $id_cabang,
        'jumlah' => $jml,
        'satuan' => $satuan,
        'harga' => $harga_barang,
        'profit' => $row['profit'] * $jml,
        'harga_total' => $harga_total,
        'id_pembelian' => 1,
        'id_user' =>  $this->session->userdata('id')
      ];

      $this->db->insert('keranjang', $data);
      $qwe = "SELECT * FROM keranjang ORDER BY id DESC LIMIT 1";
      $last_idqwe = $this->db->query($qwe)->row_array();
      $idKeranjang = $last_idqwe['id'];
      $data2 = [
        'barcode' => $barcode,
        'id_keranjang' => 1,
        'nama' => $row['nama_barang'],
        'jumlah' => $jml,
        'satuan' => $satuan,
        'harga' => $harga_barang,
        'harga_total' => $harga_total,
        'id_del' => $idKeranjang,
        'harga_beli' => $row['harga_beli'],
        'harga_jual' => $row['harga_jual'],
        'profit' => $row['profit'] * $jml,
        'id_user' =>  $this->session->userdata('id'),
        'id_cabang' => $id_cabang,
        'id_barang' => $id_barang

      ];

      $this->db->insert('semua_data_keranjang', $data2);

      echo $this->tampil_keranjang();
      echo "<script>
            iziToast.success({
                message: 'Barang disimpan dikeranjang',
                position: 'topCenter'
            });
            </script>";
    }
  }

  public function sam_struk_penjualan_c($id_pembelian)
  {
    $p_umum = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
    $title = "Struk Penjualan Barang";
    $user = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $data_barang = $this->db->get_where('riwayat_penjualan', ['id_pembelian' => $id_pembelian])->row_array();
    $cabang = $this->db->get_where('data_cabang', ['id' => $data_barang['id_cabang']])->row_array();
    $output = '';
    $output .= '
        <div class="container-fluid text-pure-dark">


        <div class="row">
            <div class="col-md-12 sizenya-paper" style="border: 1px solid #000;">
                <div class="row">
    
    
                    <div class="col-md-12 mt-4 mb-1">
                        <div class="text-center">
                            <h5>' . $p_umum['nama_perusahaan'] . '</h5>
                            ' . $cabang['nama_cabang'] . '<br>
                            ' . $cabang['alamat'] . '
                        </div>
                    </div>
                    <div class="col-md-12 py-2" style="border-top:solid 1px #000;border-bottom:solid 1px #000">
                        <span>' . $data_barang['id_pembelian'] . '</span>
                        <span class="float-right">
                        <span>' . $data_barang['tanggal'] . '</span>
                        </span>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-sm table-borderless">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th width="70"></th>
                                    <th width="70"></th>
                                </tr>
                            </thead>
                            <tbody>
                            ';

    $q = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $data_barang['id_keranjang']])->result_array();
    foreach ($q as $barang) {

      $output .= '<tr>
                                        <td>' . $barang['nama'] . '</td>
                                        <td>' . $barang['jumlah'] . ' ' . $barang['satuan'] . '</td>
                                        <td>' . rupiah2($barang['harga']) . '</td>
                                        <td>' . rupiah2($barang['harga_total']) . '</td>
                                    </tr>';
    }

    $output .= '<tr style="border-top:solid 1px #000;border-bottom:solid 1px #000">
                                    <td colspan="3" align="right">Harga Jual :</td>
                                    <td>' . rupiah2($data_barang['total_pembayaran']) . '</td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">Total :</td>
                                    <td>' . rupiah2($data_barang['total_pembayaran'])  . '</td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">Tunai :</td>
                                    <td>' . rupiah2($data_barang['uang']) . '</td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">Kembalian :</td>
                                    <td>' . rupiah2($data_barang['kembalian']) . '</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 text-center mb-3">
                        <span class="text-uppercase">Terimakasih Selamat Belanja Kembali</span><br>
                        <span class="text-uppercase">Layanan Konsumen</span><br>
                        <span class="text-uppercase">=== Bakrie POS ===</span><br>
                        <span class="text-uppercase">WA 0813 1685 6161</span><br>
                        <span class="text-uppercase">Sedia Jual Pulsa</span><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
        ';
    echo $output;
  }

  public function sam_struk_penjualan_h($id_pembelian)
  {
    $p_umum = $this->db->get_where('pengaturan_umum', ['id' => 1])->row_array();
    $title = "Struk Penjualan Barang";
    $user = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $data_barang = $this->db->get_where('riwayat_penjualan', ['id_pembelian' => $id_pembelian])->row_array();
    $cabang = $this->db->get_where('data_cabang', ['id' => $data_barang['id_cabang']])->row_array();
    $output = '';
    $output .= '
        <div class="container-fluid text-pure-dark">


        <div class="row">
            <div class="col-md-12 sizenya-paper" style="border: 1px solid #000;">
                <div class="row">
    
    
                    <div class="col-md-12 mt-4 mb-1">
                        <div class="text-center">
                            <h5>' . $p_umum['nama_perusahaan'] . '</h5>
                            ' . $cabang['nama_cabang'] . '<br>
                            ' . $cabang['alamat'] . '
                        </div>
                    </div>
                    <div class="col-md-12 py-2" style="border-top:solid 1px #000;border-bottom:solid 1px #000">
                        <p class="mb-0">
                        <span>' . $data_barang['id_pembelian'] . '</span>
                        <span class="float-right">
                            <span>' . $data_barang['tanggal'] . '</span>
                        </span>
                        </p>
                        <p class="mb-0" style="border-top:1px solid #000;">
                        <span>' . $data_barang['id_pembayaran_cicilan'] . '</span>
                        <span class="float-right">User : ' . $data_barang['id_user'] . '</span>
                        
                        </p>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-sm table-borderless">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th width="70"></th>
                                    <th width="70"></th>
                                </tr>
                            </thead>
                            <tbody>
                            ';

    $q = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $data_barang['id_keranjang']])->result_array();
    foreach ($q as $barang) {

      $output .= '<tr>
                                        <td>' . $barang['nama'] . '</td>
                                        <td>' . $barang['jumlah'] . ' ' . $barang['satuan'] . '</td>
                                        <td>' . rupiah2($barang['harga']) . '</td>
                                        <td>' . rupiah2($barang['harga_total']) . '</td>
                                    </tr>';
    }

    $output .= '<tr style="border-top:solid 1px #000;border-bottom:solid 1px #000">
                                    <td colspan="3" align="right">Harga Jual :</td>
                                    <td>' . rupiah2($data_barang['total_pembayaran']) . '</td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">Total :</td>
                                    <td>' . rupiah2($data_barang['total_pembayaran'])  . '</td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">Tunai :</td>
                                    <td>' . rupiah2($data_barang['uang']) . '</td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">Sisa Cicilan :</td>
                                    <td>' . rupiah2($data_barang['kembalian']) . '</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 text-center mb-3">
                    <span class="text-uppercase">STRUK TIDAK BOLEH HILANG</span><br>
                    <span class="text-uppercase">BERIKAN STRUK JIKA HENDAK</span><br>
                    <span class="text-uppercase">=== MEMBAYAR CICILAN ===</span><br>
                    <span class="text-uppercase">WA 0821 2160 9346 Call 0811</span><br>
                    <span class="text-uppercase">Email : inventory@gmail.com</span><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
        ';
    echo $output;
  }

  public function sam_addUser()
  {
    $data = [
      'id_user' => $this->input->post('id_user', true),
      'nama_user' => $this->input->post('nama_user', true),
      'tlp_user' => $this->input->post('no_telp', true),
      'alamat' => $this->input->post('alamat_user', true),
      'penempatan' => $this->input->post('penempatan', true),
    ];
    $this->db->insert('user_langganan', $data);
  }

  public function sam_tambah_user()
  {
    $data = [
      'id_user' => $this->input->post('id_user', true),
      'nama_user' => $this->input->post('nama_user', true),
      'tlp_user' => $this->input->post('no_telp', true),
      'alamat' => $this->input->post('alamat_user', true),
      'penempatan' => $this->input->post('penempatan', true),
    ];
    $this->db->insert('user_langganan', $data);
    $this->session->set_flashdata('pesan', 'User berhasil ditambahkan');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/data_user');
  }

  public function sam_ubah_user($id)
  {
    $data = [
      'id_user' => $this->input->post('id_user', true),
      'nama_user' => $this->input->post('nama_user', true),
      'tlp_user' => $this->input->post('no_telp', true),
      'alamat' => $this->input->post('alamat_user', true),
      'penempatan' => $this->input->post('penempatan', true)
    ];
    $this->db->set($data);
    $this->db->where('id_user', $id);
    $this->db->update('user_langganan');
    $data_s = [
      'id_user' => $this->input->post('id_user', true)
    ];
    $this->db->set($data_s);
    $this->db->where('id_user', $id);
    $this->db->update('riwayat_penjualan');
    $this->db->set($data_s);
    $this->db->where('id_user', $id);
    $this->db->update('pembayaran_cicilan');
    $this->session->set_flashdata('pesan', 'User berhasil diubah');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/data_user');
  }

  public function sam_hapus_user($id)
  {
    $riwayat_jual = $this->db->get_where('riwayat_penjualan', ['id_user' => $id])->row_array();
    if ($riwayat_jual['status_utang'] == 1) {
      $this->session->set_flashdata('pesan', 'User sedang melakukan cicilan barang');
      $this->session->set_flashdata('tipe', 'error');
      $this->session->set_flashdata('status', 'Gagal Dihapus');
      redirect('superadmin/data_user');
    }

    $this->db->where('id_user', $id);
    $this->db->delete('pembayaran_cicilan');
    $this->db->where('id_user', $id);
    $this->db->delete('riwayat_penjualan');
    $this->db->where('id_user', $id);
    $this->db->delete('user_langganan');
    $this->session->set_flashdata('pesan', 'User berhasil dihapus');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/data_user');
  }

  public function sam_dinamis_user()
  {
    $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
    $penempatan = $data['user']['penempatan_cabang'];
    $output = '';
    $output .= '
        <div class="form-group">
            <label for="">
              ID User <button type="button" title="Tambah User" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#modalUsr">
              <i class="fas fa-plus"></i> Tambah User
            </button>
            </label>
            <select class="form-control idUs" name="id_user">
              <option value=""></option>';
    $this->db->order_by('nama_user', 'asc');
    $user_langganan = $this->db->get_where('user_langganan', ['penempatan' => $penempatan])->result_array();
    foreach ($user_langganan as $row_ul) {
      $output .= '
            <option value="' . $row_ul['id_user'] . '">' . $row_ul['id_user'] . '</option>
            ';
    }
    $output .= ' </select>
        </div>';
    echo $output;
  }

  public function sam_bayar_cicilan($id)
  {
    date_default_timezone_set('Asia/Jakarta');
    $hari_indo = date('d-m-Y H:i:s');
    $dataTwo = [
      'id_cicilan' => $this->input->post('id_pembayaran'),
      'id_pembelian' => $this->input->post('id_pembelian'),
      'id_user' => $this->input->post('id_user'),
      'id_cabang' => $this->input->post('id_cabang'),
      'tanggal' => $hari_indo,
      'sisa_cicilan' => $this->input->post('sisa_cicilan'),
      'uang' => $this->input->post('uang'),
      'sisa_cicilan_akhir' => $this->input->post('sisa_cicilan_akhir'),
      'kembalian' => $this->input->post('kembalian_saya')
    ];
    $this->db->insert('pembayaran_cicilan', $dataTwo);
    $r = [
      'uang' => $this->input->post('uang'),
      'kembalian' => $this->input->post('sisa_cicilan_akhir')
    ];
    $this->db->set($r);
    $this->db->where('id_pembelian', $this->input->post('id_pembelian'));
    $this->db->update('riwayat_penjualan');
    if ($this->input->post('sisa_cicilan_akhir') == 0) {
      $this->db->set('status_utang', 0);
      $this->db->where('id_pembelian', $this->input->post('id_pembelian'));
      $this->db->update('riwayat_penjualan');
    }

    if ($this->input->post('sisa_cicilan_akhir') == 0) {
      $this->session->set_flashdata('pesan', 'Cicilan Lunas');
      $this->session->set_flashdata('tipe', 'success');
      $this->session->set_flashdata('status', 'Selamat');
      redirect('superadmin/data_cicilan');
    } else {
      $this->session->set_flashdata(
        'pesan',
        '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Pembayaran berhasil.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>'
      );
      redirect('superadmin/bayar_cicilan/' . $id);
    }
  }

  public function sam_simpan_barang_sementara()
  {

    $data = [
      'kode' => 1,
      'nama_barang' => $this->input->post('nama_barang'),
      'kategori' => $this->input->post('kategori'),
      'satuan' => $this->input->post('satuan'),
      'harga_beli' => $this->input->post('harga_beli'),
      'jumlah' => $this->input->post('jumlah_beli'),
      'harga_total' => $this->input->post('total_harga'),
      'id_user' => $this->input->post('id_user'),
      'id_cabang' => $this->input->post('id_cabang')
    ];
    $this->db->insert('pesanan_manual', $data);
  }

  public function sam_hapus_isi_pesanan_manual()
  {
    $id = $this->input->post('id');
    $this->db->where('id', $id);
    $this->db->delete('pesanan_manual');
  }

  public function sam_ubah_p_keranjang()
  {
    $id = $this->input->post('id_barang');
    $data = [
      'jumlah' => $this->input->post('jumlah'),
      'harga_total' => $this->input->post('harga_total')
    ];
    $this->db->set($data);
    $this->db->where('id', $id);
    $this->db->update('pesanan_manual');
  }

  public function sam_simpan_jual_barang()
  {
    $nama = $this->input->post('nama', true);
    $kode = $this->input->post('kode', true);
    $kategori = $this->input->post('kategori', true);
    $harga_beli = $this->input->post('harga_beli', true);
    $id_cabang = $this->input->post('id_cabang', true);
    $total_harga_sekarang = $this->input->post('total_harga_sekarang', true);
    $harga_jual = $this->input->post('harga_jual', true);
    $satuan_jual = $this->input->post('satuan_jual', true);
    $stok_jual = $this->input->post('stok_jual', true);
    $id_suplier = $this->input->post('id_suplier', true);
    $cabang_asli = $this->db->get_where('pesanan_barang', ['kode' => $kode])->row_array();
    $id = $this->input->post('id', true);
    $jumlah_barang = count($id);
    for ($i = 0; $i < $jumlah_barang; $i++) {
      if ($satuan_jual[$i] == 'pcs') {
        $total = $stok_jual[$i] * $harga_jual[$i];
        $profit1 = $total - $total_harga_sekarang[$i];
        $profit = $profit1 / $stok_jual[$i];
        $harga_belip = $harga_jual[$i] - $profit;
      } else {
        $profit = $harga_jual[$i] - $harga_beli[$i];
        $harga_belip = $harga_beli[$i];
      }

      $data = [
        'barcode' =>  '',
        'nama_barang' =>  $nama[$i],
        'gambar' =>  'default.png',
        'kategori' =>  $kategori[$i],
        'harga_beli' =>  $harga_belip,
        'harga_jual' =>  $harga_jual[$i],
        'profit' =>  $profit,
        'stok' =>  $stok_jual[$i],
        'satuan' =>  $satuan_jual[$i],
        'id_cabang' =>  $cabang_asli['tempat'],
        'keterangan' => '',
        'id_suplier' => $id_suplier[$i],
        'kode_penjualan' => '',
        'kode_pembelian' => $kode,
      ];
      $this->db->insert('barang', $data);
    }
    $q_q = $this->db->get_where('barang', ['kode_pembelian' => $kode])->result_array();
    date_default_timezone_set('Asia/Jakarta');
    $tgl_terima = date('d-m-Y');
    $time_ind = time();
    foreach ($q_q as $barang) {
      $data2 = [
        'id_barang' => $barang['id'],
        'tgl' => $time_ind,
        'tanggal' => $tgl_terima,
        'jumlah' => $barang['stok'],
        'keterangan' => 'Pembelian Barang - Kode : ' . $kode,
        'status' => 1,
        'in_out' => 0
      ];
      $this->db->insert('stok_barang', $data2);
    }

    $data = [
      'tanggal_terima' => $tgl_terima,
      'status' => 1
    ];
    $this->db->set($data);
    $this->db->where('kode', $kode);
    $this->db->update('pesanan_barang');

    $this->db->set('status_bukti', 1);
    $this->db->where('kode_pesanan', $kode);
    $this->db->update('riwayat_pengeluaran');

    $this->session->set_flashdata('pesan', 'Pesanan Berhasil di Terima dan Barang ditambahkan');
    $this->session->set_flashdata('tipe', 'success');
    $this->session->set_flashdata('status', 'Berhasil');
    redirect('superadmin/data_pesanan');
  }
}
