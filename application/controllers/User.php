<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_user();
        $this->load->model('User_model', 'user');
    }

    public function index()
    {
        $data['title'] = 'Beranda';
        $data['kategori_sidebar'] = $this->db->get_where('mst_kategori', ['status_kategori' => 1])->result_array();
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $data['list_dokumen'] = $this->user->getListDokumen($this->session->userdata('id_user'));

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_user', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit_profile()
    {
        $upload_image = $_FILES['image']['name'];
        if ($upload_image) {
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']     = '2048';
            $config['upload_path'] = './assets/dist/img/profile/';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('image')) {
                $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
                $old_image = $data['user']['image'];
                if ($old_image != 'default.png') {
                    unlink(FCPATH . 'assets/dist/img/profile/' . $old_image);
                }
                $new_image = $this->upload->data('file_name');
                $this->db->set('image', $new_image);
            } else {
                echo $this->upload->display_errors();
            }
        }
        $nama = $this->input->post('nama');
        $this->db->set('nama', $nama);
        $this->db->where('id_user', $this->session->userdata('id_user'));
        $this->db->update('mst_user');
        $this->session->set_flashdata('message', 'Simpan Perubahan');
        redirect('user/index');
    }

    public function ubah_password()
    {
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password1');
        if ($current_password == $new_password) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger font-weight-bolder text-center" role="alert">Ubah Password Gagal !! <br> Password baru tidak boleh sama dengan password lama</div>');
            redirect('user/index');
        } else {
            $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $this->db->set('password', $password_hash);
            $this->db->where('id_user', $this->session->userdata('id_user'));
            $this->db->update('mst_user');
            $this->session->set_flashdata('message', 'Ubah Password');
            redirect('user/index');
        }
    }

    public function input_data()
    {
        $this->form_validation->set_rules('nama_file', 'Nama Berkas', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Input Data';
            $data['kategori_sidebar'] = $this->db->get_where('mst_kategori', ['status_kategori' => 1])->result_array();
            $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('user/input_data', $data);
            $this->load->view('templates/footer');
        } else {
            $config['upload_path']   = './assets/files/';
            $config['allowed_types'] = 'xls|xlsx|doc|docx|ppt|pptx|pdf|zip|rar|txt';
            $config['max_size']      = 5120;
            $this->load->library('upload', $config);
            $this->upload->do_upload('file_arsip');
            $file = $this->upload->data('file_name');
            $data = [
                'kategori_id' => $this->input->post('kategori_id', true),
                'kode_arsip' => $this->input->post('kode_arsip', true),
                'tgl_upload' => $this->input->post('tgl_upload', true),
                'jam_upload' => $this->input->post('jam_upload', true),
                'nama_file' => $this->input->post('nama_file', true),
                'jenis_file' => $this->input->post('jenis_file', true),
                'petugas_arsip' => $this->session->userdata('id_user'),
                'keterangan' => $this->input->post('keterangan', true),
                'status_arsip' => 1,
                'file_arsip' => $file
            ];
            $this->db->insert('tb_arsip', $data);
            $this->session->set_flashdata('message', 'Tambah Data');
            redirect('user/input_data');
        }
    }

    public function list_dokumen($id_kategori)
    {
        $data['kategori_sidebar'] = $this->db->get_where('mst_kategori', ['status_kategori' => 1])->result_array();
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $data['nama_kategori'] = $this->db->get_where('mst_kategori', ['id_kategori' => $id_kategori])->row_array();
        $data['list_dokumen'] = $this->user->getArsip($id_kategori, $this->session->userdata('id_user'));
        $data['title'] = 'Arsip ' . $data['nama_kategori']['nama_kategori'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_user', $data);
        $this->load->view('user/list_dokumen', $data);
        $this->load->view('templates/footer');
    }

    public function detail($id_arsip)
    {
        $data['title'] = 'Detail Arsip';
        $data['kategori_sidebar'] = $this->db->get_where('mst_kategori', ['status_kategori' => 1])->result_array();
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $data['detail'] = $this->user->getDetail($id_arsip);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_user', $data);
        $this->load->view('user/detail', $data);
        $this->load->view('templates/footer');
    }

    public function unduh_arsip($id_arsip)
    {
        $data['arsip'] = $this->db->get_where('tb_arsip', ['id_arsip' => $id_arsip])->row_array();
        force_download('./assets/files/' . $data['arsip']['file_arsip'], NULL);
    }

    public function edit_data($id_arsip)
    {
        $this->form_validation->set_rules('nama_file', 'Nama Berkas', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Edit Data';
            $data['kategori_sidebar'] = $this->db->get_where('mst_kategori', ['status_kategori' => 1])->result_array();
            $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
            $data['arsip'] = $this->user->getEditArsip($id_arsip);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('user/edit_data', $data);
            $this->load->view('templates/footer');
        } else {
            $upload_image = $_FILES['file_arsip']['name'];
            if ($upload_image) {
                $config['allowed_types'] = 'xls|xlsx|doc|docx|ppt|pptx|pdf|zip|rar|txt';
                $config['max_size']     = '5120';
                $config['upload_path'] = './assets/files/';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    $data['arsip'] = $this->db->get_where('tb_arsip', ['id_arsip' => $this->input->post('id_arsip')])->row_array();
                    $old_image = $data['arsip']['file_arsip'];
                    if ($old_image != 'default.pdf') {
                        unlink(FCPATH . 'assets/files/' . $old_image);
                    }
                    $file_arsip = $this->upload->data('file_name');
                    $this->db->set('file_arsip', $file_arsip);
                } else {
                    echo $this->upload->display_errors();
                }
            }
            $id_arsip = $this->input->post('id_arsip');
            $kategori_id = $this->input->post('kategori_id', true);
            $kode_arsip = $this->input->post('kode_arsip', true);
            $tgl_upload = $this->input->post('tgl_upload', true);
            $jam_upload = $this->input->post('jam_upload', true);
            $nama_file = $this->input->post('nama_file', true);
            $jenis_file = $this->input->post('jenis_file', true);
            $keterangan = $this->input->post('keterangan', true);
            $status_arsip = $this->input->post('status_arsip', true);
            $this->db->set('kategori_id', $kategori_id);
            $this->db->set('kode_arsip', $kode_arsip);
            $this->db->set('tgl_upload', $tgl_upload);
            $this->db->set('jam_upload', $jam_upload);
            $this->db->set('nama_file', $nama_file);
            $this->db->set('jenis_file', $jenis_file);
            $this->db->set('keterangan', $keterangan);
            $this->db->set('status_arsip', $status_arsip);
            $this->db->where('id_arsip', $id_arsip);
            $this->db->update('tb_arsip');
            $this->session->set_flashdata('message', 'Ubah Data');
            redirect('user/detail/' . $id_arsip);
        }
    }

    public function publik_dokumen($id_kategori)
    {
        $data['kategori_sidebar'] = $this->db->get_where('mst_kategori', ['status_kategori' => 1])->result_array();
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $data['nama_kategori'] = $this->db->get_where('mst_kategori', ['id_kategori' => $id_kategori])->row_array();
        $data['list_dokumen'] = $this->user->getArsipPublik($id_kategori);
        $data['title'] = 'Arsip Publik ' . $data['nama_kategori']['nama_kategori'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_user', $data);
        $this->load->view('user/publik_dokumen', $data);
        $this->load->view('templates/footer');
    }

    public function publik_detail($id_arsip)
    {
        $data['title'] = 'Detail Arsip';
        $data['kategori_sidebar'] = $this->db->get_where('mst_kategori', ['status_kategori' => 1])->result_array();
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $data['detail'] = $this->user->getDetail($id_arsip);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_user', $data);
        $this->load->view('user/publik_detail', $data);
        $this->load->view('templates/footer');
    }

    public function hapus_data($id_arsip)
    {
        $_id = $this->db->get_where('tb_arsip', ['id_arsip' => $id_arsip])->row();
        $query = $this->db->delete('tb_arsip', ['id_arsip' => $id_arsip]);
        if ($query) {
            unlink("./assets/files/" . $_id->file_arsip);
        }
        $this->session->set_flashdata('message', 'Hapus Data');
        redirect($_SERVER['HTTP_REFERER']);
    }
}
