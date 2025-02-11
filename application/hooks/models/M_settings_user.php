<?php

class M_settings_user extends CI_Model
{
	private $session_id;
	function __construct()
	{
		parent::__construct();
		$this->session_id = $this->session->userdata('id');
	}

	public function get_data($id)
	{
		$this->db->select("*");
		$this->db->from("dummy_dosen");
		$this->db->where('nidn', $id);

		return $this->db->get();
	}

	public function userAdmin()
	{
		$this->db->select("*");
		$this->db->from("tb_staff as a");
		$this->db->join('tb_level_staff as b', 'a.id_level_staff = b.id_level_staff');

		return $this->db->get();
	}
	public function getWhere($id)
	{
		$this->db->select('*');
		$this->db->from("tb_luaran");
		$this->db->where("id_luaran", $id);
		return $this->db->get()->row();
	}

	public function getWherejns($id)
	{
		$this->db->select('*');
		$this->db->from("tb_kelompok_pengajuan");
		$this->db->where("id_kelompok_pengajuan", $id);
		return $this->db->get()->row();
	}
}
