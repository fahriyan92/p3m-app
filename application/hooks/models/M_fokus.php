<?php

class M_fokus extends CI_Model
{
    function all_data()
    {
        return $this->db->get('tb_user');
    }

    function insert($table = '', $data = '')
    {
        $this->db->insert($table, $data);
    }

    function get_all($table)
    {
        $this->db->from($table);

        return $this->db->get();
    }

    function get_where($table = null, $where = null)
    {
        $this->db->from($table);
        $this->db->where($where);

        return $this->db->get();
    }
    function update($table = null, $data = null, $where = null)
    {
        $this->db->update($table, $data, $where);
    }

    public function store_fokus($fokus)
    {
        $this->db->insert('tb_fokus', $fokus);
        return array(
            'status' => $this->db->trans_status(),
            'last_id' => $this->db->insert_id(),
        );
    }

    public function store_fokusdtl($fokus)
    {
        $this->db->insert('tb_fokus_detail', $fokus);
        return $this->db->trans_status();
    }

    public function get_fokus($id_event)
    {
        $this->db->select('b.id_fokus, b.bidang_fokus');
        $this->db->from('tb_fokus_detail a');
        $this->db->join('tb_fokus b', 'a.id_fokus = b.id_fokus');
        $this->db->where('a.status',1);
        $this->db->where('a.id_event', $id_event);
        return $this->db->get()->result();
    }

    public function get_All_fokus()
    {
        $this->db->select('*');
        $this->db->from('tb_fokus');
        return $this->db->get();
    }

    public function get_detail_fks($id = null)
    {
        $this->db->select('c.id_event, c.nm_event, a.id_detail_fokus, a.id_fokus, a.id_event, a.status as statusDt, b.id_fokus, b.bidang_fokus, b.status');
        $this->db->from('tb_fokus_detail a');
        $this->db->join('tb_fokus b', 'a.id_fokus = b.id_fokus');
        $this->db->join('tb_event c', 'a.id_event = c.id_event');
        if ($id !== null) {
            $this->db->where('a.id_fokus', $id);
        }
        return $this->db->get();
    }

    public function store_luaran($soal)
    {
        $this->db->trans_start();
        $this->db->insert('tb_luaran', $soal);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function store_jnsproposal($soal)
    {
        $this->db->trans_start();
        $this->db->insert('tb_kelompok_pengajuan', $soal);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_biaya($id)
    {
        $this->db->select('*');
        $this->db->from('tb_kelompok_pengajuan as a');
        $this->db->where('a.id_kelompok_pengajuan', $id);
        return $this->db->get();
    }
}
