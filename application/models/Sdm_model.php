<?php
class Sdm_model extends CI_Model
{
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

    public function getUser()
    {
        $query = "SELECT *
                  FROM mst_user
                  WHERE role_id = 2 OR role_id = 3 OR role_id = 4
                  ORDER BY bagian ASC";
        return $this->db->query($query)->result_array();
    }

    public function getBagian()
    {
        $query = "SELECT bagian
                  FROM mst_user
                  GROUP BY bagian 
                  ORDER BY bagian ASC";
        return $this->db->query($query)->result_array();
    }

    public function getKaryawanPage($limit, $start)
    {
        $query = $this->db->get('mst_pegawai', $limit, $start)->result_array();
        return $query;
    }

    public function getKaryawan()
    {
        $this->db->select('*');
        $this->db->from('mst_user');
        $this->db->join('data_pegawai', 'data_pegawai.pegawai_id = mst_user.id', 'left');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get()->result_array();
        return $query;
    }


    public function getNilai($nik)
    {
        $query = "SELECT *
                  FROM   mst_pegawai JOIN nilai_pegawai
                  ON mst_pegawai.nik = nilai_pegawai.nik
                  WHERE nilai_pegawai.nik = $nik ";
        return $this->db->query($query)->result_array();
    }

    public function getListCuti()
    {
        $query = $this->db->get('form_cuti')->result_array();
        return $query;
    }

    public function countUser()
    {
        $query = $this->db->query(
            "SELECT COUNT(id) as count_user
                             FROM mst_user"
        );
        if ($query->num_rows() > 0) {
            return $query->row()->count_user;
        } else {
            return 0;
        }
    }


    public function countCutiTahunan()
    {
        $query = $this->db->query(
            "SELECT COUNT(is_approve) as tahunan
                             FROM form_cuti
                             WHERE is_approve = 1"
        );
        if ($query->num_rows() > 0) {
            return $query->row()->tahunan;
        } else {
            return 0;
        }
    }

    public function countCutiLuarTanggungan()
    {
        $query = $this->db->query(
            "SELECT COUNT(is_approve) as tanggungan
                               FROM formcuti_lain
                               WHERE is_approve = 1"
        );
        if ($query->num_rows() > 0) {
            return $query->row()->tanggungan;
        } else {
            return 0;
        }
    }

    public function countCutiDitolak()
    {
        $query = $this->db->query(
            "SELECT COUNT(is_approve) as ditolak
                               FROM form_cuti
                               WHERE is_approve = 2"
        );
        if ($query->num_rows() > 0) {
            return $query->row()->ditolak;
        } else {
            return 0;
        }
    }

    public function getListCutiPending()
    {
        $this->db->select('*');
        $this->db->from('form_cuti');
        $this->db->where('is_approve', 1);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getListCutiPendingLuarTanggungan()
    {
        $this->db->select('*');
        $this->db->from('formcuti_lain');
        $this->db->where('is_approve', 1);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getListCutiLuarTanggungan()
    {
        $this->db->select('*');
        $this->db->from('formcuti_lain');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getListCutiDitolak()
    {
        $this->db->select('*');
        $this->db->from('form_cuti');
        $this->db->where('is_approve', 2);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getListUser($limit, $start)
    {
        $this->db->select('*');
        $this->db->from('mst_user');
        $this->db->where('role_id', 2, 3, 4);
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getDetailPegawai($id)
    {
        $query = "  SELECT * 
                    FROM mst_user 
                    LEFT JOIN data_pegawai
                    ON mst_user.id = data_pegawai.pegawai_id
                    WHERE mst_user.id = '$id'";
        return $this->db->query($query)->row_array();
    }

    public function getListCutiStaf()
    {
        $query = "SELECT * 
                    FROM form_cuti
                    WHERE role_id = 3 
                    ORDER BY id DESC";
        return $this->db->query($query)->result_array();
    }

    public function getListCutiLainStaf()
    {
        $query = "SELECT * 
                    FROM formcuti_lain
                    WHERE role_id = 3 
                    ORDER BY id DESC";
        return $this->db->query($query)->result_array();
    }
}
