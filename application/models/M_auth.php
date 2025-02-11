<?php

class M_auth extends CI_Model
{
    function all_data()
    {
        return $this->db->get('tb_user');
    }

	function insert($table = '', $data= ''){
		$this->db->insert($table,$data);
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

	public function terdaftarkah($uid)
	{
		$this->db->select('email,nip,nama nama_lengkap,jenis_job jab_struktur');
		$this->db->from('dummy_dosen');
		$this->db->where('oath_uid',$uid);
		return $this->db->get()->row();
	}

	public function update_user($nip,$data)
	{
		$this->db->where('nidn',$nip);
		return $this->db->update('dummy_dosen' ,$data);
	}

	public function insert_user($data)
	{
		return $this->db->insert('dummy_dosen',$data);
	}
}
