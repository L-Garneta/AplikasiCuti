<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Staf_model extends CI_model
{

    function getKodeUnik()
    {
        $this->db->select('RIGHT(kode_unik,4) as kode', FALSE);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('form_cuti');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = 1;
        }
        $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kodejadi = date('YmdHis') . 'CT' . $kodemax;
        return $kodejadi;
    }

    function getKodeUnik2()
    {
        $this->db->select('RIGHT(kode_unik2,4) as kode', FALSE);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('formcuti_lain');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = 1;
        }
        $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kodejadi = date('YmdHis') . 'CTL' . $kodemax;
        return $kodejadi;
    }

    public function getCutiUser($id_user)
    {
        $query = "SELECT * FROM form_cuti
                    WHERE id_user = $id_user 
                    ORDER BY id DESC";
        return $this->db->query($query)->result_array();
    }

    public function getCutiLainUser($id_user)
    {
        $query = "SELECT * FROM formcuti_lain
                    WHERE id_user = $id_user 
                    ORDER BY id DESC";
        return $this->db->query($query)->result_array();
    }

    public function getSisaCuti()
    {
        $id_user = $this->session->userdata('id');
        $query = "SELECT * FROM form_cuti 
                        WHERE id_user = $id_user 
                        ORDER BY id DESC LIMIT 1";
        return $this->db->query($query)->row_array();
    }

    public function getAllCuti($id_user)
    {
        $query = "SELECT * FROM form_cuti
                    WHERE id_user = $id_user 
                    ORDER BY id DESC";
        return $this->db->query($query)->result_array();
    }

    public function getAllCutiLain($id_user)
    {
        $query = "SELECT * 
                    FROM formcuti_lain
                    WHERE id_user = $id_user 
                    ORDER BY id DESC";
        return $this->db->query($query)->result_array();
    }

    public function getNullCuti($id)
    {
        $query = "SELECT sisa_cuti 
                    FROM form_cuti
                    WHERE id_user = $id ";
        return $this->db->query($query)->row_array();
    }

    public function getCetakCuti($id)
    {
        $query = "SELECT * 
                    FROM form_cuti
                    WHERE id = $id";
        return $this->db->query($query)->row_array();
    }

    public function cuti_count($id)
    {
        $query = $this->db->query("SELECT COUNT(is_approve) as pending
                               FROM form_cuti
                               WHERE id_user = '$id' AND is_approve = 1");
        return $query->row();
    }

    public function historyCutiCount($id)
    {
        $query = $this->db->query("SELECT COUNT(is_approve) as pending
                               FROM form_cuti
                               WHERE id_user = '$id'");
        return $query->row();
    }

    public function historyCutiLainCount($id)
    {
        $query = $this->db->query("SELECT COUNT(is_approve) as pending
                               FROM formcuti_lain
                               WHERE id_user = '$id'");
        return $query->row();
    }

    public function getDetailStaf($nik)
    {
        $query = "SELECT * 
                    FROM mst_user 
                    JOIN mst_pegawai ON mst_user.nik = mst_pegawai.nik 
                    LEFT JOIN nilai_pegawai ON mst_pegawai.nik = nilai_pegawai.nik
                    WHERE mst_user.nik = $nik ORDER BY mst_user.id DESC LIMIT 1               
                    ";
        return $this->db->query($query)->result_array();
    }

    public function getHistoryCutiTahunan($tahun, $id_user)
    {
        $query = $this->db->query(
            "SELECT * 
                FROM history_cuti
                WHERE YEAR(input) = '$tahun' AND id_user = '$id_user'"
        );
        return $query->result_array();
    }
}
