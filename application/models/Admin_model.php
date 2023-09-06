<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_model
{

    public function countUserAktif()
    {

        $query = $this->db->query(
            "SELECT COUNT(id_user) as jml_user
                               FROM mst_user
                               WHERE is_active = 1"
        );
        if ($query->num_rows() > 0) {
            return $query->row()->jml_user;
        } else {
            return 0;
        }
    }

    public function countUserTidakAktif()
    {

        $query = $this->db->query(
            "SELECT COUNT(id_user) as jml_user
                               FROM mst_user
                               WHERE is_active = 0"
        );
        if ($query->num_rows() > 0) {
            return $query->row()->jml_user;
        } else {
            return 0;
        }
    }

    public function countUserBulan()
    {

        $query = $this->db->query(
            "SELECT CONCAT(YEAR(date_created),'/',MONTH(date_created)) AS tahun_bulan, COUNT(*) AS count_bulan
                FROM mst_user
                WHERE CONCAT(YEAR(date_created),'/',MONTH(date_created))=CONCAT(YEAR(NOW()),'/',MONTH(NOW()))
                GROUP BY YEAR(date_created),MONTH(date_created);"
        );
        if ($query->num_rows() > 0) {
            return $query->row()->count_bulan;
        } else {
            return 0;
        }
    }

    public function countAllUser()
    {
        $query = $this->db->query(
            "SELECT COUNT(id_user) as count_all
                               FROM mst_user"
        );
        if ($query->num_rows() > 0) {
            return $query->row()->count_all;
        } else {
            return 0;
        }
    }

    public function getArsip($id_kategori)
    {
        $query = "SELECT * 
                    FROM tb_arsip
                    JOIN mst_user
                    ON tb_arsip.petugas_arsip = mst_user.id_user
                    WHERE tb_arsip.kategori_id = '$id_kategori'";
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
}
