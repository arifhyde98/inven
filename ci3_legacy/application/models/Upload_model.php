<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Upload_model extends CI_Model
{
    public function image_upload_ins($up_path, $up_type, $up_maxsize, $up_name, $up_set, $up_err_redirect)
    {
        $config['upload_path'] = $up_path;
        $config['allowed_types'] = $up_type;
        $config['max_size'] = $up_maxsize;
        $config['encrypt_name'] = true;
        $this->upload->initialize($config);
        if ($this->upload->do_upload($up_name)) {
            $nama_baru = $this->upload->data('file_name');
            $this->db->set($up_set, $nama_baru);
        } else {

            $this->session->set_flashdata('pesan', 'Tipe file tidak mendukung atau ukuran file terlalu besar');
            $this->session->set_flashdata('tipe', 'error');
            $this->session->set_flashdata('status', 'Upload Gagal');
            redirect($up_err_redirect);
        }
    }

    public function image_upload_upl($up_path, $up_type, $up_maxsize, $up_name, $up_set, $up_err_redirect, $up_gambar_lama, $up_link)
    {
        $config['upload_path'] = $up_path;
        $config['allowed_types'] = $up_type;
        $config['max_size'] = $up_maxsize;
        $config['encrypt_name'] = true;
        $this->upload->initialize($config);
        if ($this->upload->do_upload($up_name)) {
            $nama_baru = $this->upload->data('file_name');
            if ($up_gambar_lama != "default.png") {
                unlink(FCPATH . $up_link . $up_gambar_lama);
            }
            $this->db->set($up_set, $nama_baru);
        } else {
            $this->session->set_flashdata('pesan', 'Tipe file tidak mendukung atau ukuran file terlalu besar');
            $this->session->set_flashdata('tipe', 'error');
            $this->session->set_flashdata('status', 'Upload Gagal');
            redirect($up_err_redirect);
        }
    }
}
