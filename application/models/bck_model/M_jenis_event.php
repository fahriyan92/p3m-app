<?php

class M_jenis_event extends CI_Model
{
    function all_data()
    {
        return $this->db->get('tb_jenis_event');
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


}
