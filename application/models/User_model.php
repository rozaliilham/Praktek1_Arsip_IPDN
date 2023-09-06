<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_model
{

    public function getListDokumen($id_user)
    {
        $query = "SELECT * 
                    FROM tb_arsip
                    JOIN mst_kategori 
                    ON tb_arsip.kategori_id = mst_kategori.id_kategori
                    JOIN mst_user
                    ON tb_arsip.petugas_arsip = mst_user.id_user
                    WHERE tb_arsip.petugas_arsip = '$id_user'";
        return $this->db->query($query)->result_array();
    }

    public function getArsip($id_kategori, $id_user)
    {
        $query = "SELECT * 
                    FROM tb_arsip
                    JOIN mst_user
                    ON tb_arsip.petugas_arsip = mst_user.id_user
                    WHERE tb_arsip.kategori_id = '$id_kategori' AND tb_arsip.petugas_arsip = '$id_user'";
        return $this->db->query($query)->result_array();
    }

    public function getDetail($id_arsip)
    {
        $query = "SELECT * 
                    FROM tb_arsip
                    JOIN mst_user
                    ON tb_arsip.petugas_arsip = mst_user.id_user
                    JOIN mst_kategori
                    ON mst_kategori.id_kategori = tb_arsip.kategori_id
                    WHERE tb_arsip.id_arsip = '$id_arsip'";
        return $this->db->query($query)->row_array();
    }

    public function getEditArsip($id_arsip)
    {
        $query = "SELECT * 
                    FROM tb_arsip
                    JOIN mst_kategori
                    ON tb_arsip.kategori_id = mst_kategori.id_kategori
                    WHERE tb_arsip.id_arsip = '$id_arsip'";
        return $this->db->query($query)->row_array();
    }

    public function getArsipPublik($id_kategori)
    {
        $query = "SELECT * 
                    FROM tb_arsip
                    JOIN mst_user
                    ON tb_arsip.petugas_arsip = mst_user.id_user
                    WHERE tb_arsip.kategori_id = '$id_kategori' AND status_arsip = 0";
        return $this->db->query($query)->result_array();
    }
}
