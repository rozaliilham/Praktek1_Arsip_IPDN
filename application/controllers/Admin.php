<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_admin();
        $this->load->model('Admin_model', 'admin');
    }

    public function index()
    {
        $data['title'] = 'Beranda';
        $data['kategori_sidebar'] = $this->db->get_where('mst_kategori', ['status_kategori' => 1])->result_array();
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $data['list_user'] = $this->db->get('mst_user')->result_array();

        $data['user_aktif'] = $this->admin->countUserAktif();
        $data['user_tak_aktif'] = $this->admin->countUserTidakAktif();
        $data['user_bulan'] = $this->admin->countUserBulan();
        $data['total_user'] = $this->admin->countAllUser();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/index', $data);
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
        redirect('admin/index');
    }

    public function ubah_password()
    {
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password1');
        if ($current_password == $new_password) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger font-weight-bolder text-center" role="alert">Ubah Password Gagal !! <br> Password baru tidak boleh sama dengan password lama</div>');
            redirect('admin/index');
        } else {
            $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $this->db->set('password', $password_hash);
            $this->db->where('id_user', $this->session->userdata('id_user'));
            $this->db->update('mst_user');
            $this->session->set_flashdata('message', 'Ubah Password');
            redirect('admin/index');
        }
    }

    public function man_user()
    {
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('email', 'Alamat Email', 'required|trim|is_unique[mst_user.email]', array(
            'is_unique' => 'Alamat Email sudah ada'
        ));
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', array(
            'matches' => 'Password tidak sama',
            'min_length' => 'password min 3 karakter'
        ));
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Management User';
            $data['kategori_sidebar'] = $this->db->get_where('mst_kategori', ['status_kategori' => 1])->result_array();
            $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
            $data['list_user'] = $this->db->get('mst_user')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/master/man_user', $data);
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'nama' => $this->input->post('nama', true),
                'email' => $this->input->post('email', true),
                'level' => $this->input->post('level', true),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'date_created' => date('Y/m/d'),
                'image' => 'default.jpg',
                'is_active' => 1
            );
            $this->db->insert('mst_user', $data);
            $this->session->set_flashdata('message', 'Tambah Data');
            redirect('admin/man_user');
        }
    }

    public function get_user()
    {
        $id_user = $this->input->post('id_user');
        echo json_encode($this->db->get_where('mst_user', ['id_user' => $id_user])->row_array());
    }

    public function edit_user()
    {
        $id_user = $this->input->post('id_user');
        $nama = $this->input->post('nama');
        $level = $this->input->post('level');
        $is_active = $this->input->post('is_active');

        $this->db->set('nama', $nama);
        $this->db->set('level', $level);
        $this->db->set('is_active', $is_active);
        $this->db->where('id_user', $id_user);
        $this->db->update('mst_user');
        $this->session->set_flashdata('message', 'Ubah Data');
        redirect('admin/man_user');
    }

    public function mst_kategori()
    {

        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required|trim|is_unique[mst_kategori.nama_kategori]', array(
            'is_unique' => 'Nama kategori sudah ada'
        ));

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Data Kategori';
            $data['kategori_sidebar'] = $this->db->get_where('mst_kategori', ['status_kategori' => 1])->result_array();
            $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
            $data['list_kategori'] = $this->db->get('mst_kategori')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/master/mst_kategori', $data);
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'nama_kategori' => $this->input->post('nama_kategori', true),
                'status_kategori' => 1
            );
            $this->db->insert('mst_kategori', $data);
            $this->session->set_flashdata('message', 'Tambah Data');
            redirect('admin/mst_kategori');
        }
    }

    public function get_kategori()
    {
        $id_kategori = $this->input->post('id_kategori');
        echo json_encode($this->db->get_where('mst_kategori', ['id_kategori' => $id_kategori])->row_array());
    }

    public function edit_kategori()
    {
        $id_kategori = $this->input->post('id_kategori');
        $nama_kategori = $this->input->post('nama_kategori');
        $status_kategori = $this->input->post('status_kategori');
        $this->db->set('nama_kategori', $nama_kategori);
        $this->db->set('status_kategori', $status_kategori);
        $this->db->where('id_kategori', $id_kategori);
        $this->db->update('mst_kategori');
        $this->session->set_flashdata('message', 'Ubah Data');
        redirect('admin/mst_kategori');
    }

    public function input_data()
    {
        $this->form_validation->set_rules('nama_file', 'Nama Berkas', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Input Data';
            $data['kategori_sidebar'] = $this->db->get_where('mst_kategori', ['status_kategori' => 1])->result_array();
            $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/input_data', $data);
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
            redirect('admin/input_data');
        }
    }


    public function list_dokumen($id_kategori)
    {
        $data['title'] = 'Input Data';
        $data['kategori_sidebar'] = $this->db->get_where('mst_kategori', ['status_kategori' => 1])->result_array();
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $data['nama_kategori'] = $this->db->get_where('mst_kategori', ['id_kategori' => $id_kategori])->row_array();
        $data['list_dokumen'] = $this->admin->getArsip($id_kategori);
        $data['title'] = 'Arsip ' . $data['nama_kategori']['nama_kategori'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/list_dokumen', $data);
        $this->load->view('templates/footer');
    }

    public function detail($id_arsip)
    {
        $data['title'] = 'Detail Arsip';
        $data['kategori_sidebar'] = $this->db->get_where('mst_kategori', ['status_kategori' => 1])->result_array();
        $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
        $data['detail'] = $this->admin->getDetail($id_arsip);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/detail', $data);
        $this->load->view('templates/footer');
    }

    public function edit_data($id_arsip)
    {
        $this->form_validation->set_rules('nama_file', 'Nama Berkas', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Edit Data';
            $data['kategori_sidebar'] = $this->db->get_where('mst_kategori', ['status_kategori' => 1])->result_array();
            $data['user'] = $this->db->get_where('mst_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
            $data['arsip'] = $this->admin->getEditArsip($id_arsip);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/edit_data', $data);
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
            redirect('admin/detail/' . $id_arsip);
        }
    }

    public function unduh_arsip($id_arsip)
    {
        $data['arsip'] = $this->db->get_where('tb_arsip', ['id_arsip' => $id_arsip])->row_array();
        force_download('./assets/files/' . $data['arsip']['file_arsip'], NULL);
    }

    public function hapus_data($id_arsip)
    {
        $_id = $this->db->get_where('tb_arsip', ['id_arsip' => $id_arsip])->row();
        $query = $this->db->delete('tb_arsip', ['id_arsip' => $id_arsip]);
        if ($query) {
            unlink("./assets/files/" . $_id->file_arsip);
        }
        $this->session->set_flashdata('message', 'Hapus data');
        redirect($_SERVER['HTTP_REFERER']);
    }
}
