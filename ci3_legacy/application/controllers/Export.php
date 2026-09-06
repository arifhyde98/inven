<?php
defined('BASEPATH') or exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('supadmin_model', 'sup_admin');
        $this->load->model('upload_model', 'uploadMod');
    }

    public function excel_data_pesanan()
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $penempatan = $data['user']['penempatan_cabang'];
        $role_id = $data['user']['role_id'];

        if ($role_id == 1) {
            $this->db->order_by('id', 'desc');
            $semua_pesanan = $this->db->get('pesanan_barang')->result_array();
            $header = header('Content-Disposition: attachment;filename="Data Pesanan - Semua Cabang.xlsx"');
        } else {
            $cabang_a = $this->db->get_where('data_cabang', ['id' => $penempatan])->row_array();
            $this->db->order_by('id', 'desc');
            $semua_pesanan = $this->db->get_where('pesanan_barang', ['tempat' => $data['user']['penempatan_cabang']])->result_array();
            $header = header('Content-Disposition: attachment;filename="Data Pesanan - ' . $cabang_a['nama_cabang'] . '.xlsx"');
        }

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Kode Pesanan')
            ->setCellValue('C1', 'Nama Pesanan')
            ->setCellValue('D1', 'Penempatan Cabang')
            ->setCellValue('E1', 'Suplier')
            ->setCellValue('F1', 'Jumlah Barang')
            ->setCellValue('G1', 'Jenis Pesanan')
            ->setCellValue('H1', 'Status Pesanan');

        $kolom = 2;
        $nomor = 1;
        foreach ($semua_pesanan as $pesanan) {
            $a = $this->db->get_where('suplier', ['id_suplier' => $pesanan['suplier']])->row_array();
            $cabang = $this->db->get_where('data_cabang', ['id' => $pesanan['tempat']])->row_array();
            $jumlah_pesan_stok = $this->db->get_where('isi_pesanan_barang', ['kode' => $pesanan['kode']])->num_rows();
            $jumlah_pesan_barang = $this->db->get_where('pesanan_manual', ['kode' => $pesanan['kode']])->num_rows();
            if ($pesanan['status'] == 0) {
                $s = "Dipesan";
            } else {
                $s = 'Diterima';
            }
            if ($pesanan['jenis_pesanan'] == 1) {
                $b = $jumlah_pesan_stok;
                $e = 'Stok';
            } else {
                $b = $jumlah_pesan_barang;
                $e = 'Barang';
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $pesanan['kode'])
                ->setCellValue('C' . $kolom, $pesanan['nama'])
                ->setCellValue('D' . $kolom, $cabang['nama_cabang'])
                ->setCellValue('E' . $kolom, $a['nama_suplier'])
                ->setCellValue('F' . $kolom, $b)
                ->setCellValue('G' . $kolom, $e)
                ->setCellValue('H' . $kolom, $s);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        echo $header;
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_data_pesanan_c($id)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $cabang_a = $this->db->get_where('data_cabang', ['id' => $id])->row_array();
        $this->db->order_by('id', 'desc');
        $semua_pesanan = $this->db->get_where('pesanan_barang', ['tempat' => $id])->result_array();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Kode Pesanan')
            ->setCellValue('C1', 'Nama Pesanan')
            ->setCellValue('D1', 'Penempatan Cabang')
            ->setCellValue('E1', 'Suplier')
            ->setCellValue('F1', 'Jumlah Barang')
            ->setCellValue('G1', 'Jenis Pesanan')
            ->setCellValue('H1', 'Status Pesanan');

        $kolom = 2;
        $nomor = 1;
        foreach ($semua_pesanan as $pesanan) {
            $a = $this->db->get_where('suplier', ['id_suplier' => $pesanan['suplier']])->row_array();
            $cabang = $this->db->get_where('data_cabang', ['id' => $pesanan['tempat']])->row_array();
            $jumlah_pesan_stok = $this->db->get_where('isi_pesanan_barang', ['kode' => $pesanan['kode']])->num_rows();
            $jumlah_pesan_barang = $this->db->get_where('pesanan_manual', ['kode' => $pesanan['kode']])->num_rows();
            if ($pesanan['status'] == 0) {
                $s = "Dipesan";
            } else {
                $s = 'Diterima';
            }
            if ($pesanan['jenis_pesanan'] == 1) {
                $b = $jumlah_pesan_stok;
                $e = 'Stok';
            } else {
                $b = $jumlah_pesan_barang;
                $e = 'Barang';
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $pesanan['kode'])
                ->setCellValue('C' . $kolom, $pesanan['nama'])
                ->setCellValue('D' . $kolom, $cabang['nama_cabang'])
                ->setCellValue('E' . $kolom, $a['nama_suplier'])
                ->setCellValue('F' . $kolom, $b)
                ->setCellValue('G' . $kolom, $e)
                ->setCellValue('H' . $kolom, $s);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data Pesanan - ' . $cabang_a['nama_cabang'] . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_data_pengeluaran()
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $penempatan = $data['user']['penempatan_cabang'];
        $role_id = $data['user']['role_id'];
        if ($role_id == 1) {
            $this->db->order_by('id', 'desc');
            $data_pengeluaran = $this->db->get_where('riwayat_pengeluaran', ['status_bukti !=' => 0])->result_array();
            $header =  header('Content-Disposition: attachment;filename="Data Pengeluaran - Semua Cabang.xlsx"');
        } else {
            $cabang_a = $this->db->get_where('data_cabang', ['id' => $penempatan])->row_array();
            $this->db->order_by('id', 'desc');
            $data_pengeluaran = $this->db->get_where('riwayat_pengeluaran', ['id_cabang' => $data['user']['penempatan_cabang'], 'status_bukti !=' => 0])->result_array();
            $header =  header('Content-Disposition: attachment;filename="Data Pengeluaran - ' . $cabang_a['nama_cabang'] . '.xlsx"');
        }

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Tanggal')
            ->setCellValue('C1', 'Kode Pesanan')
            ->setCellValue('D1', 'Penempatan Cabang')
            ->setCellValue('E1', 'Total Pengeluaran');

        $kolom = 2;
        $nomor = 1;
        foreach ($data_pengeluaran as $data) {
            $cabang = $this->db->get_where('data_cabang', ['id' => $data['id_cabang']])->row_array();
            if ($data['status_bukti'] == 0) {
                $s = "Dipesan";
            } else {
                $s = 'Diterima';
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data['tanggal_ind'])
                ->setCellValue('C' . $kolom, $data['kode_pesanan'])
                ->setCellValue('D' . $kolom, $cabang['nama_cabang'])
                ->setCellValue('E' . $kolom, $data['total_pengeluaran']);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        echo $header;
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function excel_data_pengeluaran_ex($dari, $ke, $id)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $penempatan = $data['user']['penempatan_cabang'];
        $role_id = $data['user']['role_id'];
        if ($role_id == 1) {
            if ($id == 0) {

                $this->db->order_by('id', 'desc');
                $query = "SELECT * FROM riwayat_pengeluaran WHERE status_bukti != '0' AND tanggal_ind BETWEEN '$dari' AND '$ke'";
                $data_pengeluaran = $this->db->query($query)->result_array();
                $header =  header('Content-Disposition: attachment;filename="Data Pengeluaran - Semua Cabang.xlsx"');
            } else {
                $cabang_a = $this->db->get_where('data_cabang', ['id' => $id])->row_array();
                $this->db->order_by('id', 'desc');
                $query = "SELECT * FROM riwayat_pengeluaran WHERE status_bukti != '0' AND id_cabang = '$id' AND tanggal_ind BETWEEN '$dari' AND '$ke'";
                $data_pengeluaran = $this->db->query($query)->result_array();
                $header =  header('Content-Disposition: attachment;filename="Data Pengeluaran - ' . $cabang_a['nama_cabang'] . '.xlsx"');
            }
        } else {
            $cabang_a = $this->db->get_where('data_cabang', ['id' => $penempatan])->row_array();
            $this->db->order_by('id', 'desc');
            $query = "SELECT * FROM riwayat_pengeluaran WHERE status_bukti != '0' AND id_cabang = '$penempatan' AND tanggal_ind BETWEEN '$dari' AND '$ke'";
            $data_pengeluaran = $this->db->query($query)->result_array();
            $header =  header('Content-Disposition: attachment;filename="Data Pengeluaran - ' . $cabang_a['nama_cabang'] . '.xlsx"');
        }

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Tanggal')
            ->setCellValue('C1', 'Kode Pesanan')
            ->setCellValue('D1', 'Penempatan Cabang')
            ->setCellValue('E1', 'Total Pengeluaran');

        $kolom = 2;
        $nomor = 1;
        foreach ($data_pengeluaran as $data) {
            $cabang = $this->db->get_where('data_cabang', ['id' => $data['id_cabang']])->row_array();
            if ($data['status_bukti'] == 0) {
                $s = "Dipesan";
            } else {
                $s = 'Diterima';
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data['tanggal_ind'])
                ->setCellValue('C' . $kolom, $data['kode_pesanan'])
                ->setCellValue('D' . $kolom, $cabang['nama_cabang'])
                ->setCellValue('E' . $kolom, $data['total_pengeluaran']);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        echo $header;
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_data_pengeluaran_c($id)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('id', 'desc');
        $data_pengeluaran = $this->db->get_where('riwayat_pengeluaran', ['status_bukti !=' => 0, 'id_cabang' => $id])->result_array();
        $cabang = $this->db->get_where('data_cabang', ['id' => $id])->row_array();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Tanggal')
            ->setCellValue('C1', 'Kode Pesanan')
            ->setCellValue('D1', 'Penempatan Cabang')
            ->setCellValue('E1', 'Total Pengeluaran');

        $kolom = 2;
        $nomor = 1;
        foreach ($data_pengeluaran as $data) {
            $cabang = $this->db->get_where('data_cabang', ['id' => $data['id_cabang']])->row_array();
            if ($data['status_bukti'] == 0) {
                $s = "Dipesan";
            } else {
                $s = 'Diterima';
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data['tanggal_ind'])
                ->setCellValue('C' . $kolom, $data['kode_pesanan'])
                ->setCellValue('D' . $kolom, $cabang['nama_cabang'])
                ->setCellValue('E' . $kolom, $data['total_pengeluaran']);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data Pengeluaran - ' . $cabang['nama_cabang'] . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_data_barang()
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $penempatan = $data['user']['penempatan_cabang'];
        $role_id = $data['user']['role_id'];

        if ($role_id == 1) {
            $this->db->order_by('id', 'desc');
            $data_barang = $this->db->get('barang')->result_array();
            $header =  header('Content-Disposition: attachment;filename="Data Barang - Semua Cabang.xlsx"');
        } else {
            $cabang_a = $this->db->get_where('data_cabang', ['id' => $penempatan])->row_array();
            $this->db->order_by('id', 'desc');
            $data_barang = $this->db->get_where('barang', ['id_cabang' => $data['user']['penempatan_cabang']])->result_array();
            $header = header('Content-Disposition: attachment;filename="Data Barang - ' . $cabang_a['nama_cabang'] . '.xlsx"');
        }



        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Kode')
            ->setCellValue('C1', 'Nama')
            ->setCellValue('D1', 'Kategori')
            ->setCellValue('E1', 'Harga Beli')
            ->setCellValue('F1', 'Harga Jual')
            ->setCellValue('G1', 'Profit')
            ->setCellValue('H1', 'Stok')
            ->setCellValue('I1', 'Satuan')
            ->setCellValue('J1', 'Suplier')
            ->setCellValue('K1', 'Penempatan');

        $kolom = 2;
        $nomor = 1;
        foreach ($data_barang as $data) {
            $penempatan = $this->db->get_where('data_cabang', ['id' => $data['id_cabang']])->row_array();
            $suplier = $this->db->get_where('suplier', ['id' => $data['id_suplier']])->row_array();
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, '"' . $data['barcode'] . '"')
                ->setCellValue('C' . $kolom, $data['nama_barang'])
                ->setCellValue('D' . $kolom, $data['kategori'])
                ->setCellValue('E' . $kolom, $data['harga_beli'])
                ->setCellValue('F' . $kolom, $data['harga_jual'])
                ->setCellValue('G' . $kolom, $data['profit'])
                ->setCellValue('H' . $kolom, $data['stok'])
                ->setCellValue('I' . $kolom, $data['satuan'])
                ->setCellValue('J' . $kolom, $suplier['nama_suplier'])
                ->setCellValue('K' . $kolom, $penempatan['nama_cabang']);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        echo $header;
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function excel_data_barang_c($id)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $cabang_a = $this->db->get_where('data_cabang', ['id' => $id])->row_array();
        $this->db->order_by('id', 'desc');
        $data_barang = $this->db->get_where('barang', ['id_cabang' => $id])->result_array();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Kode')
            ->setCellValue('C1', 'Nama')
            ->setCellValue('D1', 'Kategori')
            ->setCellValue('E1', 'Harga Beli')
            ->setCellValue('F1', 'Harga Jual')
            ->setCellValue('G1', 'Profit')
            ->setCellValue('H1', 'Stok')
            ->setCellValue('I1', 'Satuan')
            ->setCellValue('J1', 'Suplier')
            ->setCellValue('K1', 'Penempatan');

        $kolom = 2;
        $nomor = 1;
        foreach ($data_barang as $data) {
            $penempatan = $this->db->get_where('data_cabang', ['id' => $data['id_cabang']])->row_array();
            $suplier = $this->db->get_where('suplier', ['id' => $data['id_suplier']])->row_array();
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, '"' . $data['barcode'] . '"')
                ->setCellValue('C' . $kolom, $data['nama_barang'])
                ->setCellValue('D' . $kolom, $data['kategori'])
                ->setCellValue('E' . $kolom, $data['harga_beli'])
                ->setCellValue('F' . $kolom, $data['harga_jual'])
                ->setCellValue('G' . $kolom, $data['profit'])
                ->setCellValue('H' . $kolom, $data['stok'])
                ->setCellValue('I' . $kolom, $data['satuan'])
                ->setCellValue('J' . $kolom, $suplier['nama_suplier'])
                ->setCellValue('K' . $kolom, $penempatan['nama_cabang']);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data Barang - ' . $cabang_a['nama_cabang'] . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_data_opname()
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $penempatan = $data['user']['penempatan_cabang'];
        $role_id = $data['user']['role_id'];
        if ($role_id == 1) {
            $this->db->order_by('id', 'desc');
            $stok_opname = $this->db->get('stok_opname')->result_array();
            $header = header('Content-Disposition: attachment;filename="Data Stok Opname - Semua Cabang.xlsx"');
        } else {
            $cabang_a = $this->db->get_where('data_cabang', ['id' => $penempatan])->row_array();
            $this->db->order_by('id', 'desc');
            $stok_opname =  $this->db->get_where('stok_opname', ['tempat' => $data['user']['penempatan_cabang']])->result_array();
            $header = header('Content-Disposition: attachment;filename="Data Stok Opname - ' . $cabang_a['nama_cabang'] . '.xlsx"');
        }

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nama')
            ->setCellValue('C1', 'Tanggal')
            ->setCellValue('D1', 'Tempat')
            ->setCellValue('E1', 'Status')
            ->setCellValue('F1', 'Stok Di Aplikasi')
            ->setCellValue('G1', 'Stok Fisik');

        $kolom = 2;
        $nomor = 1;
        foreach ($stok_opname as $data) {
            $cabang = $this->db->get_where('data_cabang', ['id' => $data['tempat']])->row_array();
            $this->db->select_sum('stok_fisik');
            $jum = $this->db->get_where('isi_stok_opname', ['kode' => $data['kode']])->row_array();
            $this->db->select_sum('stok_aplikasi');
            $apps = $this->db->get_where('isi_stok_opname', ['kode' => $data['kode']])->row_array();
            if ($data['disabled'] == 0) {
                $stat = 'Belum Di Proses';
            } else {
                $stat = 'Sudah Di Proses';
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data['nama'])
                ->setCellValue('C' . $kolom, $data['tanggal'])
                ->setCellValue('D' . $kolom, $cabang['nama_cabang'])
                ->setCellValue('E' . $kolom, $stat)
                ->setCellValue('F' . $kolom, $apps['stok_aplikasi'])
                ->setCellValue('G' . $kolom, $jum['stok_fisik']);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        echo $header;
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_data_opname_c($id)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $cabang_a = $this->db->get_where('data_cabang', ['id' => $id])->row_array();
        $this->db->order_by('id', 'desc');
        $stok_opname = $this->db->get_where('stok_opname', ['tempat' => $id])->result_array();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nama')
            ->setCellValue('C1', 'Tanggal')
            ->setCellValue('D1', 'Tempat')
            ->setCellValue('E1', 'Status')
            ->setCellValue('F1', 'Stok Di Aplikasi')
            ->setCellValue('G1', 'Stok Fisik');

        $kolom = 2;
        $nomor = 1;
        foreach ($stok_opname as $data) {
            $cabang = $this->db->get_where('data_cabang', ['id' => $data['tempat']])->row_array();
            $this->db->select_sum('stok_fisik');
            $jum = $this->db->get_where('isi_stok_opname', ['kode' => $data['kode']])->row_array();
            $this->db->select_sum('stok_aplikasi');
            $apps = $this->db->get_where('isi_stok_opname', ['kode' => $data['kode']])->row_array();
            if ($data['disabled'] == 0) {
                $stat = 'Belum Di Proses';
            } else {
                $stat = 'Sudah Di Proses';
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data['nama'])
                ->setCellValue('C' . $kolom, $data['tanggal'])
                ->setCellValue('D' . $kolom, $cabang['nama_cabang'])
                ->setCellValue('E' . $kolom, $stat)
                ->setCellValue('F' . $kolom, $apps['stok_aplikasi'])
                ->setCellValue('G' . $kolom, $jum['stok_fisik']);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data Stok Opname - ' . $cabang_a['nama_cabang'] . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_data_cicilan()
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $penempatan = $data['user']['penempatan_cabang'];
        $role_id = $data['user']['role_id'];

        if ($role_id == 1) {
            $this->db->order_by('id', 'desc');
            $data_cicilan = $this->db->get_where('riwayat_penjualan', ['metode_bayar' => 'cicilan'])->result_array();
            $header = header('Content-Disposition: attachment;filename="Data Cicilan - Semua Cabang.xlsx"');
        } else {
            $cabang_a = $this->db->get_where('data_cabang', ['id' => $penempatan])->row_array();
            $this->db->order_by('id', 'desc');
            $data_cicilan = $this->db->get_where('riwayat_penjualan', ['metode_bayar' => 'cicilan', 'id_cabang' => $penempatan])->result_array();
            $header = header('Content-Disposition: attachment;filename="Data Cicilan - ' . $cabang_a['nama_cabang'] . '.xlsx"');
        }

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'ID Cicilan')
            ->setCellValue('C1', 'ID User')
            ->setCellValue('D1', 'Cabang')
            ->setCellValue('E1', 'Tanggal')
            ->setCellValue('F1', 'Total Bayar')
            ->setCellValue('G1', 'Sisa Cicilan')
            ->setCellValue('H1', 'Status');

        $kolom = 2;
        $nomor = 1;
        foreach ($data_cicilan as $data) {
            $d_cabang = $this->db->get_where('data_cabang', ['id' => $data['id_cabang']])->row_array();

            if ($data['status_utang'] == 1) {
                $stat = 'Belum Lunas';
            } else {
                $stat = 'Lunas';
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data['id_pembayaran_cicilan'])
                ->setCellValue('C' . $kolom, $data['id_user'])
                ->setCellValue('D' . $kolom, $d_cabang['nama_cabang'])
                ->setCellValue('E' . $kolom, $data['tanggal'])
                ->setCellValue('F' . $kolom, $data['total_pembayaran'])
                ->setCellValue('G' . $kolom, $data['kembalian'])
                ->setCellValue('H' . $kolom, $stat);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        echo $header;
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_data_cicilan_c($id)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $cabang_a = $this->db->get_where('data_cabang', ['id' => $id])->row_array();
        $this->db->order_by('id', 'desc');
        $data_cicilan = $this->db->get_where('riwayat_penjualan', ['metode_bayar' => 'cicilan', 'id_cabang' => $id])->result_array();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'ID Cicilan')
            ->setCellValue('C1', 'ID User')
            ->setCellValue('D1', 'Cabang')
            ->setCellValue('E1', 'Tanggal')
            ->setCellValue('F1', 'Total Bayar')
            ->setCellValue('G1', 'Sisa Cicilan')
            ->setCellValue('H1', 'Status');

        $kolom = 2;
        $nomor = 1;
        foreach ($data_cicilan as $data) {
            $d_cabang = $this->db->get_where('data_cabang', ['id' => $data['id_cabang']])->row_array();

            if ($data['status_utang'] == 1) {
                $stat = 'Belum Lunas';
            } else {
                $stat = 'Lunas';
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data['id_pembayaran_cicilan'])
                ->setCellValue('C' . $kolom, $data['id_user'])
                ->setCellValue('D' . $kolom, $d_cabang['nama_cabang'])
                ->setCellValue('E' . $kolom, $data['tanggal'])
                ->setCellValue('F' . $kolom, $data['total_pembayaran'])
                ->setCellValue('G' . $kolom, $data['kembalian'])
                ->setCellValue('H' . $kolom, $stat);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data Cicilan - ' . $cabang_a['nama_cabang'] . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_log_cicilan()
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $penempatan = $data['user']['penempatan_cabang'];
        $role_id = $data['user']['role_id'];
        if ($role_id == 1) {
            $this->db->order_by('id', 'desc');
            $log_cicilan = $this->db->get('pembayaran_cicilan')->result_array();
            $header = header('Content-Disposition: attachment;filename="Log Cicilan - Semua Cabang.xlsx"');
        } else {
            $cabang_a = $this->db->get_where('data_cabang', ['id' => $penempatan])->row_array();
            $this->db->order_by('id', 'desc');
            $log_cicilan = $this->db->get_where('pembayaran_cicilan', ['id_cabang' => $data['user']['penempatan_cabang']])->result_array();
            $header = header('Content-Disposition: attachment;filename="Log Cicilan - ' . $cabang_a['nama_cabang'] . '.xlsx"');
        }


        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Tanggal')
            ->setCellValue('C1', 'ID Cicilan')
            ->setCellValue('D1', 'ID User')
            ->setCellValue('E1', 'Cabang')
            ->setCellValue('F1', 'Status')
            ->setCellValue('G1', 'Total Bayar')
            ->setCellValue('H1', 'Sisa Cicilan');

        $kolom = 2;
        $nomor = 1;
        foreach ($log_cicilan as $data) {
            $d_cabang = $this->db->get_where('data_cabang', ['id' => $data['id_cabang']])->row_array();

            if ($data['sisa_cicilan_akhir'] == 0) {
                $stat = 'Melunasi Cicilan';
            } else {
                $stat = 'Membayar Cicilan';
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data['tanggal'])
                ->setCellValue('C' . $kolom, $data['id_cicilan'])
                ->setCellValue('D' . $kolom, $data['id_user'])
                ->setCellValue('E' . $kolom, $d_cabang['nama_cabang'])
                ->setCellValue('F' . $kolom, $stat)
                ->setCellValue('G' . $kolom, $data['uang'])
                ->setCellValue('H' . $kolom, $data['sisa_cicilan_akhir']);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        echo $header;
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_log_cicilan_c($id)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $cabang_a = $this->db->get_where('data_cabang', ['id' => $id])->row_array();
        $this->db->order_by('id', 'desc');
        $log_cicilan = $this->db->get_where('pembayaran_cicilan', ['id_cabang' => $id])->result_array();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Tanggal')
            ->setCellValue('C1', 'ID Cicilan')
            ->setCellValue('D1', 'ID User')
            ->setCellValue('E1', 'Cabang')
            ->setCellValue('F1', 'Status')
            ->setCellValue('G1', 'Total Bayar')
            ->setCellValue('H1', 'Sisa Cicilan');

        $kolom = 2;
        $nomor = 1;
        foreach ($log_cicilan as $data) {
            $d_cabang = $this->db->get_where('data_cabang', ['id' => $data['id_cabang']])->row_array();

            if ($data['sisa_cicilan_akhir'] == 0) {
                $stat = 'Melunasi Cicilan';
            } else {
                $stat = 'Membayar Cicilan';
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data['tanggal'])
                ->setCellValue('C' . $kolom, $data['id_cicilan'])
                ->setCellValue('D' . $kolom, $data['id_user'])
                ->setCellValue('E' . $kolom, $d_cabang['nama_cabang'])
                ->setCellValue('F' . $kolom, $stat)
                ->setCellValue('G' . $kolom, $data['uang'])
                ->setCellValue('H' . $kolom, $data['sisa_cicilan_akhir']);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Log Cicilan - ' . $cabang_a['nama_cabang'] . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_history_penjualan()
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $penempatan = $data['user']['penempatan_cabang'];
        $role_id = $data['user']['role_id'];
        if ($role_id == 1) {
            $this->db->order_by('id', 'desc');
            $history = $this->db->get('riwayat_penjualan')->result_array();
            $header = header('Content-Disposition: attachment;filename="History Penjualan - Semua Cabang.xlsx"');
        } else {
            $cabang_a = $this->db->get_where('data_cabang', ['id' => $penempatan])->row_array();
            $this->db->order_by('id', 'desc');
            $history = $this->db->get_where('riwayat_penjualan', ['id_cabang' => $data['user']['penempatan_cabang']])->result_array();
            $header = header('Content-Disposition: attachment;filename="History Penjualan - ' . $cabang_a['nama_cabang'] . '.xlsx"');
        }


        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'ID Penjualan')
            ->setCellValue('C1', 'Tanggal')
            ->setCellValue('D1', 'Cabang')
            ->setCellValue('E1', 'Total Barang')
            ->setCellValue('F1', 'Total Pembayaran')
            ->setCellValue('G1', 'Metode Bayar');

        $kolom = 2;
        $nomor = 1;
        foreach ($history as $data) {
            $a = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $data['id_keranjang']])->num_rows();
            $d_cabang = $this->db->get_where('data_cabang', ['id' => $data['id_cabang']])->row_array();

            if ($data['metode_bayar'] == 'tunai') {
                $status_cicilan = '';
            } else {
                if ($data['status_utang'] == 0) {

                    $status_cicilan = ' (Lunas)';
                } else {
                    $status_cicilan = ' (Belum Lunas)';
                }
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data['id_pembelian'])
                ->setCellValue('C' . $kolom, $data['tanggal'])
                ->setCellValue('D' . $kolom, $d_cabang['nama_cabang'])
                ->setCellValue('E' . $kolom, $a)
                ->setCellValue('F' . $kolom, $data['total_pembayaran'])
                ->setCellValue('G' . $kolom, $data['metode_bayar'] . $status_cicilan);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        echo $header;
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }


    public function excel_history_penjualan_c($id)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('id', 'desc');
        $history = $this->db->get_where('riwayat_penjualan', ['id_cabang' => $id])->result_array();
        $c = $this->db->get_where('data_cabang', ['id' => $id])->row_array();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'ID Penjualan')
            ->setCellValue('C1', 'Tanggal')
            ->setCellValue('D1', 'Cabang')
            ->setCellValue('E1', 'Total Barang')
            ->setCellValue('F1', 'Total Pembayaran')
            ->setCellValue('G1', 'Metode Bayar');

        $kolom = 2;
        $nomor = 1;
        foreach ($history as $data) {
            $a = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $data['id_keranjang']])->num_rows();
            $d_cabang = $this->db->get_where('data_cabang', ['id' => $data['id_cabang']])->row_array();

            if ($data['metode_bayar'] == 'tunai') {
                $status_cicilan = '';
            } else {
                if ($data['status_utang'] == 0) {

                    $status_cicilan = ' (Lunas)';
                } else {
                    $status_cicilan = ' (Belum Lunas)';
                }
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data['id_pembelian'])
                ->setCellValue('C' . $kolom, $data['tanggal'])
                ->setCellValue('D' . $kolom, $d_cabang['nama_cabang'])
                ->setCellValue('E' . $kolom, $a)
                ->setCellValue('F' . $kolom, $data['total_pembayaran'])
                ->setCellValue('G' . $kolom, $data['metode_bayar'] . $status_cicilan);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="History Penjualan - ' . $c['nama_cabang'] . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function excel_history_penjualan_ex($a, $b, $id)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('id', 'desc');
        if ($id == 0) {
            $historya = "SELECT * FROM riwayat_penjualan WHERE tanggal_ind BETWEEN '$a' AND '$b'";
            $history = $this->db->query($historya)->result_array();
            $c = "Semua Cabang";
        } else {

            $historya = "SELECT * FROM riwayat_penjualan WHERE tanggal_ind BETWEEN '$a' AND '$b' AND id_cabang='$id'";
            $history = $this->db->query($historya)->result_array();
            $c = $this->db->get_where('data_cabang', ['id' => $id])->row_array();
            $c = $c['nama_cabang'];
        }


        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'ID Penjualan')
            ->setCellValue('C1', 'Tanggal')
            ->setCellValue('D1', 'Cabang')
            ->setCellValue('E1', 'Total Barang')
            ->setCellValue('F1', 'Total Pembayaran')
            ->setCellValue('G1', 'Metode Bayar');

        $kolom = 2;
        $nomor = 1;
        foreach ($history as $data) {
            $a = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $data['id_keranjang']])->num_rows();
            $d_cabang = $this->db->get_where('data_cabang', ['id' => $data['id_cabang']])->row_array();

            if ($data['metode_bayar'] == 'tunai') {
                $status_cicilan = '';
            } else {
                if ($data['status_utang'] == 0) {

                    $status_cicilan = ' (Lunas)';
                } else {
                    $status_cicilan = ' (Belum Lunas)';
                }
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data['id_pembelian'])
                ->setCellValue('C' . $kolom, $data['tanggal'])
                ->setCellValue('D' . $kolom, $d_cabang['nama_cabang'])
                ->setCellValue('E' . $kolom, $a)
                ->setCellValue('F' . $kolom, $data['total_pembayaran'])
                ->setCellValue('G' . $kolom, $data['metode_bayar'] . $status_cicilan);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="History Penjualan - ' . $c . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_data_penjualan_hari($c)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $penempatan = $data['user']['penempatan_cabang'];

        $dats = "SELECT DISTINCT tanggal_ind FROM riwayat_penjualan WHERE id_cabang='$c'";
        $d_cabang = $this->db->get_where('data_cabang', ['id' => $c])->row_array();
        $header = header('Content-Disposition: attachment;filename="Laporan Penjualan Harian - ' . $d_cabang['nama_cabang'] . '.xlsx"');
        $anjay = $this->db->query($dats)->result_array();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Tanggal')
            ->setCellValue('C1', 'Total Penjualan')
            ->setCellValue('D1', 'Total Pendapatan');

        $kolom = 2;
        $nomor = 1;
        foreach ($anjay as $data) {
            $this->db->select_sum('total_pembayaran');
            $total_pembayaran = $this->db->get_where('riwayat_penjualan', ['tanggal_ind' => $data['tanggal_ind'], 'id_cabang' => $c])->row_array();
            $this->db->select_sum('pendapatan');
            $total_pendapatan = $this->db->get_where('riwayat_penjualan', ['tanggal_ind' => $data['tanggal_ind'], 'id_cabang' => $c])->row_array();

            $bersih = $total_pendapatan['pendapatan'];

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data['tanggal_ind'])
                ->setCellValue('C' . $kolom, $total_pembayaran['total_pembayaran'])
                ->setCellValue('D' . $kolom, $bersih);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        echo $header;
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function excel_data_penjualan_hari_ex($a, $b, $id)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $penempatan = $data['user']['penempatan_cabang'];

        $dats = "SELECT DISTINCT tanggal_ind FROM riwayat_penjualan WHERE tanggal_ind BETWEEN '$a' AND '$b' AND id_cabang='$id'";
        $d_cabang = $this->db->get_where('data_cabang', ['id' => $id])->row_array();
        $header = header('Content-Disposition: attachment;filename="Laporan Penjualan Harian - ' . $d_cabang['nama_cabang'] . '.xlsx"');
        $anjay = $this->db->query($dats)->result_array();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Tanggal')
            ->setCellValue('C1', 'Total Penjualan')
            ->setCellValue('D1', 'Total Pendapatan');

        $kolom = 2;
        $nomor = 1;
        foreach ($anjay as $data) {
            $this->db->select_sum('total_pembayaran');
            $total_pembayaran = $this->db->get_where('riwayat_penjualan', ['tanggal_ind' => $data['tanggal_ind'], 'id_cabang' => $id])->row_array();
            $this->db->select_sum('pendapatan');
            $total_pendapatan = $this->db->get_where('riwayat_penjualan', ['tanggal_ind' => $data['tanggal_ind'], 'id_cabang' => $id])->row_array();

            $bersih = $total_pendapatan['pendapatan'];

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data['tanggal_ind'])
                ->setCellValue('C' . $kolom, $total_pembayaran['total_pembayaran'])
                ->setCellValue('D' . $kolom, $bersih);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        echo $header;
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_data_penjualan_bulan($id)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $penempatan = $data['user']['penempatan_cabang'];
        $d_cabang = $this->db->get_where('data_cabang', ['id' => $id])->row_array();

        $this->db->order_by('single_tahun', 'desc');
        $dats = "SELECT DISTINCT bulan_ind FROM riwayat_penjualan WHERE id_cabang='$id'";

        $anjay = $this->db->query($dats)->result_array();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Tanggal')
            ->setCellValue('C1', 'Total Penjualan')
            ->setCellValue('D1', 'Total Pendapatan');

        $kolom = 2;
        $nomor = 1;
        foreach ($anjay as $data) {
            $this->db->select_sum('total_pembayaran');
            $total_pembayaran = $this->db->get_where('riwayat_penjualan', ['bulan_ind' => $data['bulan_ind'], 'id_cabang' => $id])->row_array();
            $this->db->select_sum('pendapatan');
            $total_pendapatan = $this->db->get_where('riwayat_penjualan', ['bulan_ind' => $data['bulan_ind'], 'id_cabang' => $id])->row_array();

            $split = $data['bulan_ind'];
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

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $nama_bulan)
                ->setCellValue('C' . $kolom, $total_pembayaran['total_pembayaran'])
                ->setCellValue('D' . $kolom, $bersih);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Penjualan Bulanan - ' . $d_cabang['nama_cabang'] . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_data_pengeluaran_hari($id)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $dats = "SELECT DISTINCT tanggal_ind FROM riwayat_pengeluaran WHERE id_cabang='$id' AND status_bukti != '0'";
        $d_cabang = $this->db->get_where('data_cabang', ['id' => $id])->row_array();

        $anjay = $this->db->query($dats)->result_array();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Tanggal')
            ->setCellValue('C1', 'Total Pengeluaran');

        $kolom = 2;
        $nomor = 1;
        foreach ($anjay as $data) {
            $this->db->select_sum('total_pengeluaran');
            $total_pengeluaran = $this->db->get_where('riwayat_pengeluaran', ['tanggal_ind' => $data['tanggal_ind'], 'id_cabang' => $id, 'status_bukti !=' => 0])->row_array();
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data['tanggal_ind'])
                ->setCellValue('C' . $kolom, $total_pengeluaran['total_pengeluaran']);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data Pengeluaran Harian - ' . $d_cabang['nama_cabang'] . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function excel_data_pengeluaran_hari_ex($dari, $ke, $id)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $dats = "SELECT DISTINCT tanggal_ind FROM riwayat_pengeluaran WHERE status_bukti != '0' AND tanggal_ind BETWEEN '$dari' AND '$ke' AND id_cabang = '$id'";
        $d_cabang = $this->db->get_where('data_cabang', ['id' => $id])->row_array();

        $anjay = $this->db->query($dats)->result_array();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Tanggal')
            ->setCellValue('C1', 'Total Pengeluaran');

        $kolom = 2;
        $nomor = 1;
        foreach ($anjay as $data) {
            $this->db->select_sum('total_pengeluaran');
            $total_pengeluaran = $this->db->get_where('riwayat_pengeluaran', ['tanggal_ind' => $data['tanggal_ind'], 'id_cabang' => $id, 'status_bukti !=' => 0])->row_array();
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data['tanggal_ind'])
                ->setCellValue('C' . $kolom, $total_pengeluaran['total_pengeluaran']);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data Pengeluaran Harian - ' . $d_cabang['nama_cabang'] . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_data_pengeluaran_bulan($id)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $d_cabang = $this->db->get_where('data_cabang', ['id' => $id])->row_array();
        $this->db->order_by('single_tahun', 'desc');
        $dats = "SELECT DISTINCT bulan_ind FROM riwayat_pengeluaran WHERE id_cabang='$id' AND status_bukti != '0'";

        $anjay = $this->db->query($dats)->result_array();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Bulan')
            ->setCellValue('C1', 'Total Pengeluaran');

        $kolom = 2;
        $nomor = 1;
        foreach ($anjay as $data) {

            $this->db->select_sum('total_pengeluaran');
            $total_pengeluaran = $this->db->get_where('riwayat_pengeluaran', ['bulan_ind' => $data['bulan_ind'], 'id_cabang' => $id, 'status_bukti !=' => 0])->row_array();

            $split = $data['bulan_ind'];
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

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $nama_bulan)
                ->setCellValue('C' . $kolom, $total_pengeluaran['total_pengeluaran']);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data Pengeluaran Bulanan - ' . $d_cabang['nama_cabang'] . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_laporan_stok()
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->db->order_by('id', 'desc');
        $stok = $this->db->get('barang')->result_array();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nama Barang')
            ->setCellValue('C1', 'Tanggal')
            ->setCellValue('D1', 'Expired')
            ->setCellValue('E1', 'Masuk')
            ->setCellValue('F1', 'Keluar')
            ->setCellValue('G1', 'Stok Akhir');

        $kolom = 2;
        $nomor = 1;
        foreach ($stok as $data) {
            $cabang = $this->db->get_where('data_cabang', ['id' => $data['id_cabang']])->row_array();
            $this->db->select_sum('jumlah');
            $pemasukan = $this->db->get_where('stok_barang', ['id_barang' => $data['id'], 'status' => 1])->row_array();
            $this->db->select_sum('jumlah');
            $keluar = $this->db->get_where('stok_barang', ['id_barang' => $data['id'], 'status' => 2])->row_array();
            if ($keluar['jumlah'] == 0) {
                $i = '0';
            } else {
                $i = $keluar['jumlah'] . ' ' . $data['satuan'];
            }
            if($data['exp_date'] == 0){
                $expired = "-";

            }else{
                $expired = $data['exp_date'];
            }
            $qTgl = $this->db->get_where('stok_barang', ['id_barang' => $data['id']])->row_array();
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data['nama_barang'])
                ->setCellValue('C' . $kolom, date('d F Y', $qTgl['tgl']))
                ->setCellValue('D' . $kolom, $expired)
                ->setCellValue('E' . $kolom, $pemasukan['jumlah'] . ' ' . $data['satuan'])
                ->setCellValue('F' . $kolom, $i)
                ->setCellValue('G' . $kolom, $data['stok'] . ' ' . $data['satuan']);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Stok - Semua Cabang.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_laporan_stok_c($id)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $d_cabang = $this->db->get_where('data_cabang', ['id' => $id])->row_array();
        $this->db->order_by('id', 'desc');
        $stok = $this->db->get_where('barang', ['id_cabang' => $id])->result_array();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nama Barang')
            ->setCellValue('C1', 'Tanggal')
            ->setCellValue('D1', 'Expired')
            ->setCellValue('E1', 'Masuk')
            ->setCellValue('F1', 'Keluar')
            ->setCellValue('G1', 'Stok Akhir');

        $kolom = 2;
        $nomor = 1;
        foreach ($stok as $data) {
            $this->db->select_sum('jumlah');
            $pemasukan = $this->db->get_where('stok_barang', ['id_barang' => $data['id'], 'status' => 1])->row_array();
            $this->db->select_sum('jumlah');
            $keluar = $this->db->get_where('stok_barang', ['id_barang' => $data['id'], 'status' => 2])->row_array();
            if ($keluar['jumlah'] == 0) {
                $i = '0';
            } else {
                $i = $keluar['jumlah'] . ' ' . $data['satuan'];
            }
            if($data['exp_date'] == 0){
                $expired = "-";

            }else{
                $expired = $data['exp_date'];
            }
            $qTgl = $this->db->get_where('stok_barang', ['id_barang' => $data['id']])->row_array();
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data['nama_barang'])
                ->setCellValue('C' . $kolom, date('d F Y', $qTgl['tgl']))
                ->setCellValue('D' . $kolom, $expired)
                ->setCellValue('E' . $kolom, $pemasukan['jumlah'] . ' ' . $data['satuan'])
                ->setCellValue('F' . $kolom, $i)
                ->setCellValue('G' . $kolom, $data['stok'] . ' ' . $data['satuan']);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Stok - ' . $d_cabang['nama_cabang'] . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_detail_stok($id)
    {
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $d_cabang = $this->db->get_where('data_cabang', ['id' => $id])->row_array();
        $this->db->order_by('id', 'desc');
        $data_barang = $this->db->get_where('barang', ['id' => $id])->row_array();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Tanggal')
            ->setCellValue('C1', 'Masuk')
            ->setCellValue('D1', 'Keluar')
            ->setCellValue('E1', 'Keterangan')
            ->setCellValue('F1', 'Jumlah');

        $kolom = 2;
        $nomor = 1;
        $mutasi = 0;
        $stok = $this->db->get_where('stok_barang', ['id_barang' => $data_barang['id']])->result_array();
        foreach ($stok as $data) {
            if ($data['status'] == 1) {
                $in = $data['jumlah'];
                $out = '';
                $ket = $data['keterangan'];
                $jml = $mutasi += $data['jumlah'];
            } elseif ($data['status'] == 2) {
                $in = '';
                $out =  $data['jumlah'];;
                $ket = $data['keterangan'];
                $jml = $mutasi -= $data['jumlah'];
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, date('d F Y - H:i', $data['tgl']))
                ->setCellValue('C' . $kolom, $in)
                ->setCellValue('D' . $kolom, $out)
                ->setCellValue('E' . $kolom, $ket)
                ->setCellValue('F' . $kolom, $jml);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Stok - ' . $data_barang['nama_barang'] . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
