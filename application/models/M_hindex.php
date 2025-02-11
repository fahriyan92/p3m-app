<?php

class M_hindex extends CI_Model
{
	function all_data()
	{
		return $this->db->get('tb_hindex');
	}

function get_data_all_relational()
    {

        $table_hindex = 'tb_hindex';
        $table_dosen = 'dummy_dosen';

        $this->db->select('h.*, d.jenis_job');
        $this->db->from($table_hindex . ' AS h');
        $this->db->join($table_dosen . ' AS d', 'h.nidsn_dosen = d.nidn');

        return $this->db->get();
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
		$this->db->trans_start();

		$this->db->update($table, $data, $where);
		
		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	public function get_data($table)
	{
			return $this->db->get($table)->result();
	}


}
