<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kaur_model extends CI_model
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
    function getKodeNik()
    {
        $this->db->select('RIGHT(nik,4) as kode', FALSE);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('mst_user');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = 1;
        }
        $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kodejadi = 'PEG-' . date('Y') . '-' . $kodemax;
        return $kodejadi;
    }


    public function getHistoryCuti($id_user)
    {
        $query = "SELECT * FROM form_cuti
                    WHERE id_user = $id_user 
                    ORDER BY id DESC";
        return $this->db->query($query)->result_array();
    }

    public function getHistoryCutiLain($id_user)
    {
        $query = "SELECT * FROM formcuti_lain
                    WHERE id_user = $id_user 
                    ORDER BY id DESC";
        return $this->db->query($query)->result_array();
    }

    public function getSisaCuti()
    {
        $id_user = $this->session->userdata('id');
        $query = "SELECT * FROM form_cuti WHERE id_user = $id_user 
                    ORDER BY id DESC LIMIT 1";
        return $this->db->query($query)->row_array();
    }

    public function getAllStaf()
    {
        $bagian = $this->session->userdata('bagian');
        $query = "SELECT * FROM mst_user  LEFT JOIN mst_pegawai
                  ON mst_user.nik = mst_pegawai.nik
                  WHERE mst_pegawai.bagian = '$bagian' AND mst_user.role_id = 4";
        return $this->db->query($query)->result_array();
    }

    public function getPegawaiLimit()
    {
        $bagian = $this->session->userdata('bagian');
        $query = "SELECT * FROM mst_user
                    WHERE bagian = '$bagian'
                    LIMIT 10";
        return $this->db->query($query)->result_array();
    }

    public function getCutiSayaLimit()
    {
        $id_user = $this->session->userdata('id');
        $query = "SELECT * FROM form_cuti
                    WHERE id_user = $id_user
                    ORDER BY id
                    LIMIT 5
                    ";
        return $this->db->query($query)->result_array();
    }

    public function getCutiLainSayaLimit()
    {
        $id_user = $this->session->userdata('id');
        $query = "SELECT * FROM formcuti_lain
                    WHERE id_user = $id_user
                    ORDER BY id
                    LIMIT 5
                    ";
        return $this->db->query($query)->result_array();
    }

    public function getListCutiStaf($bagian)
    {
        $query = "SELECT * 
                    FROM form_cuti
                    WHERE bagian = '$bagian' AND role_id = 4 
                    ORDER BY id DESC";
        return $this->db->query($query)->result_array();
    }

    public function getListCutiStafHabis($bagian)
    {
        $query = "SELECT * 
                    FROM form_cuti
                    WHERE bagian = '$bagian' AND role_id = 4 AND sisa_cuti = 0 
                    ORDER BY id DESC";
        return $this->db->query($query)->result_array();
    }

    public function getListCutiLainStaf($bagian)
    {
        $query = "SELECT *
                    FROM formcuti_lain
                    WHERE bagian = '$bagian' AND role_id = 4 ORDER BY id DESC ";
        return $this->db->query($query)->result_array();
    }

    public function getDataCuti($id)
    {
        $query = "SELECT * FROM form_cuti 
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

    public function stafCutiCount($bagian)
    {
        $query = $this->db->query("SELECT COUNT(is_approve) as pending
                                        FROM form_cuti 
                                        WHERE bagian = '$bagian' AND is_approve = 1 AND role_id = 4");
        return $query->row();
    }

    public function stafCutiLainCount($bagian)
    {
        $query = $this->db->query("SELECT COUNT(is_approve) as pending
                                        FROM formcuti_lain 
                                        WHERE bagian = '$bagian' AND is_approve = 1 AND role_id = 4");
        return $query->row();
    }

    public function sisaCutiCount($bagian)
    {
        $query = $this->db->query("SELECT COUNT(sisa_cuti) as pending
                                        FROM form_cuti 
                                        WHERE bagian = '$bagian' AND sisa_cuti = 0 AND role_id = 4");
        return $query->row();
    }


    public function getCutiTahunan($tahun, $id_user)
    {
        $query = $this->db->query(
            "SELECT * 
                FROM form_cuti
                WHERE year(input) = '$tahun' OR id_user = '$id_user'
                ORDER BY id DESC"
        );
        return $query->result_array();
    }

    public function getAllCuti($id_user)
    {
        $query = "SELECT * FROM form_cuti
                    WHERE id_user = $id_user 
                    ORDER BY id DESC";
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
