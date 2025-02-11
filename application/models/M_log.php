<?php

class M_log extends CI_Model
{
	private $session_id;
	function __construct()
	{
		parent::__construct();
		$this->session_id = $this->session->userdata('id');
	}

	public function get_data()
	{
		$this->db->select("a.nama_staff, c.nama_level_staff, a.event_staff, a.ket_aktivitas, a.created_at");
		$this->db->from("tb_log as a");
		$this->db->join('tb_staff as b', 'a.id_staff=b.id_staff');
		$this->db->join('tb_level_staff as c', 'a.role_staff=c.id_level_staff');

		return $this->db->get();
	}
}
