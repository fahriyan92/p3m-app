<?php

class M_event extends CI_Model
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

	public function get_data($table)
	{
		return $this->db->get($table)->result();
	}

	public function get_dataEvent()
	{
		$this->db->select('a.id_jenis_event,a.id_jenis_event, b.nm_event');
		$this->db->join('tb_event b', 'a.id_event = b.id_event');
		$this->db->where('id_pendanaan', 1);
		return $this->db->get("tb_jenis_event a");
	}

	function store_event($data)
	{
		$this->db->trans_start();

		if ($data['list']['id_jenis_event'] === null) {
			$this->db->insert('tb_jenis_event', $data['jenis']);
			$data['list']['id_jenis_event'] = $this->db->insert_id();
		}

		$this->db->insert('tb_list_event', $data['list']);
		$this->db->trans_complete();

		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			return false;
		}

		$this->db->trans_commit();
		return true;
	}

	public function tanggal_cek($tgl)
	{
		$this->db->select('waktu_mulai');
		$this->db->from('tb_list_event');
		$this->db->where('waktu_mulai', $tgl);
		$this->db->where('status', 1);

		return $this->db->get()->row();
	}

	public function list_event_asc($tahun)
	{
		$this->db->order_by('mulai', 'asc');
		$this->db->order_by('id_tahapan', 'asc');
		$this->db->where('status', 1);
		$this->db->where('DATE_FORMAT(mulai,"%Y")', $tahun);
		return $this->db->get('view_list_event')->result();
	}

	public function list_event_asc2($tahun)
	{
		$this->db->order_by('mulai', 'asc');
		$this->db->order_by('id_tahapan', 'asc');
		// $this->db->group_by('id_jenis');
		$this->db->where('status', 1);
		$this->db->where('DATE_FORMAT(mulai,"%Y")', $tahun);
		return $this->db->get('view_list_event')->result();
	}

	public function list_event_id($id)
	{
		return $this->db->get_where('view_list_event', ['id' => $id])->row();
	}

	public function list_event_id2($id)
	{
		$this->db->select('nm_event');
		$this->db->join('tb_event b', 'a.id_event = b.id_event');
		return $this->db->get_where('tb_jenis_event a', ['id_jenis_event' => $id])->result();
	}

	public function get_jenisEvent($id)
	{
		$this->db->select('a.id_soal, a.id_jenis_soal, b.id_event');
		$this->db->from('tb_soal a');
		$this->db->join('tb_jenis_soal b', 'a.id_jenis_soal = b.id_jenis_soal');
		$this->db->where('a.id_soal', $id);
		$this->db->where('a.status', 1);

		return $this->db->get();
	}
}
