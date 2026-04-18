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
        return 'PEG-' . date('Y') . '-' . $kodemax;
    }

    public function getUser()
    {
        return $this->db
            ->where_in('role_id', [2,3,4])
            ->order_by('bagian', 'ASC')
            ->get('mst_user')
            ->result_array();
    }

    public function getBagian()
    {
        return $this->db
            ->select('bagian')
            ->group_by('bagian')
            ->order_by('bagian', 'ASC')
            ->get('mst_user')
            ->result_array();
    }

    public function getKaryawan()
    {
        return $this->db
            ->select('*')
            ->from('mst_user')
            ->join('data_pegawai', 'data_pegawai.pegawai_id = mst_user.id', 'left')
            ->order_by('id', 'DESC')
            ->get()
            ->result_array();
    }

    // =======================
    // 🔥 CUTI (REFACTORED)
    // =======================

    // ✅ Semua cuti
    public function getListCuti()
    {
        return $this->db
            ->order_by('id', 'DESC')
            ->get('form_cuti')
            ->result_array();
    }

    // ✅ Untuk KAUR (tahap 1)
    public function getCutiKaur()
    {
        return $this->db
            ->where('approved_kaur', 1)
            ->order_by('id', 'DESC')
            ->get('form_cuti')
            ->result_array();
    }

    // ✅ Untuk SDM (tahap 2)
    public function getCutiSdm()
    {
        return $this->db
            ->where('approved_kaur', 0)
            ->where('approved_sdm', 1)
            ->order_by('id', 'DESC')
            ->get('form_cuti')
            ->result_array();
    }

    // ✅ Pending (belum final)
    public function getCutiPending()
    {
        return $this->db
            ->where('is_approve', 1)
            ->order_by('id', 'DESC')
            ->get('form_cuti')
            ->result_array();
    }

    // ✅ Disetujui
    public function getCutiApproved()
    {
        return $this->db
            ->where('is_approve', 0)
            ->order_by('id', 'DESC')
            ->get('form_cuti')
            ->result_array();
    }

    // ✅ Ditolak
    public function getCutiDitolak()
    {
        return $this->db
            ->where('is_approve', 2)
            ->order_by('id', 'DESC')
            ->get('form_cuti')
            ->result_array();
    }

    // =======================
    // 🔥 CUTI LAIN
    // =======================

    public function getListCutiLuarTanggungan()
    {
        return $this->db
            ->order_by('id', 'DESC')
            ->get('formcuti_lain')
            ->result_array();
    }

    public function getCutiLainPending()
    {
        return $this->db
            ->where('is_approve', 1)
            ->order_by('id', 'DESC')
            ->get('formcuti_lain')
            ->result_array();
    }

    // =======================
    // 🔥 COUNT DATA
    // =======================

    public function countUser()
    {
        return $this->db->count_all('mst_user');
    }

    public function countCutiTahunan()
    {
        return $this->db
            ->where('is_approve', 1)
            ->count_all_results('form_cuti');
    }

    public function countCutiLuarTanggungan()
    {
        return $this->db
            ->where('is_approve', 1)
            ->count_all_results('formcuti_lain');
    }

    public function countCutiDitolak()
    {
        return $this->db
            ->where('is_approve', 2)
            ->count_all_results('form_cuti');
    }

    // =======================
    // 🔥 DETAIL
    // =======================

    public function getDetailPegawai($id)
    {
        return $this->db
            ->select('*')
            ->from('mst_user')
            ->join('data_pegawai', 'mst_user.id = data_pegawai.pegawai_id', 'left')
            ->where('mst_user.id', $id)
            ->get()
            ->row_array();
    }

    // =======================
    // 🔥 CUTI STAF
    // =======================

    public function getListCutiStaf()
    {
        return $this->db
            ->where('role_id', 3)
            ->order_by('id', 'DESC')
            ->get('form_cuti')
            ->result_array();
    }

    public function getListCutiLainStaf()
    {
        return $this->db
            ->where('role_id', 3)
            ->order_by('id', 'DESC')
            ->get('formcuti_lain')
            ->result_array();
    }

    // =======================
    // 🔥 HITUNG GAJI
    // =======================

    public function hitung_gaji($id)
    {
        $karyawan = $this->db->get_where('mst_user', ['id' => $id])->row();

        $gaji_pokok = 3000000;

        $this->db->where('id_user', $id);
        $this->db->where('jenis_cuti', 'izin');
        $jumlah_izin = $this->db->count_all_results('form_cuti');

        $potongan_per_hari = $gaji_pokok / 31;
        $total_potongan = $jumlah_izin * $potongan_per_hari;

        return [
            'nama' => $karyawan->nama,
            'gaji_pokok' => $gaji_pokok,
            'izin' => $jumlah_izin,
            'potongan' => $total_potongan,
            'gaji_bersih' => $gaji_pokok - $total_potongan
        ];
    }
}