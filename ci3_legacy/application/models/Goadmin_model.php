<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Goadmin_model extends CI_Model
{
    public function g_login()
    {
        $email = $this->input->post('useremail', true);
        $password = $this->input->post('password', true);
        $this->db->where('username', $email);
        $this->db->or_where('email', $email);
        $user = $this->db->get('user')->row_array();
        if ($user) {
            if ($user['status'] == 1) {
                if (password_verify($password, $user['password'])) {
                    if ($user['role_id'] == 1) {
                        $data = [
                            'id' => $user['id'],
                            'nama' => $user['nama'],
                            'email' => $user['email'],
                            'role_id' => $user['role_id']
                        ];
                        $this->session->set_userdata($data);
                        redirect('superadmin');
                    } elseif ($user['role_id'] == 2) {
                        $data = [
                            'id' => $user['id'],
                            'nama' => $user['nama'],
                            'email' => $user['email'],
                            'role_id' => $user['role_id']
                        ];
                        $this->session->set_userdata($data);
                        redirect('admin');
                    } elseif ($user['role_id'] == 3) {
                        $data = [
                            'id' => $user['id'],
                            'nama' => $user['nama'],
                            'email' => $user['email'],
                            'role_id' => $user['role_id']
                        ];
                        $this->session->set_userdata($data);
                        redirect('siswa');
                    } else { }
                } else {
                    $this->session->set_flashdata(
                        'pesan',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
							Password Salah !!!
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>'
                    );
                    redirect('goadmin');
                }
            } else {
                $this->session->set_flashdata(
                    'pesan',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
						Akun Belum Aktif  !!!
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>'
                );
                redirect('goadmin');
            }
        } else {
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
					Email Atau Username Tidak Terdaftar !!!
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>'
            );
            redirect('goadmin');
        }
    }
}
