<?php

class M_dosen extends CI_Model
{

	function get_where($table = null, $where = null)
	{
		$this->db->from($table);
		$this->db->where($where);

		return $this->db->get();
	}
	public function TolakPermintaan($data)
	{

		$this->db->delete('tb_permintaan_anggota', array('id_anggota' => $data['id_anggota']));
		$this->db->delete('tb_anggota_dosen', array('id_anggota_dsn' => $data['id_anggota']));
	}
	public function permintaan($data)
	{
		$sql = "UPDATE tb_permintaan_anggota SET status_permintaan = '" . $data['status_permintaan'] . "' WHERE id_pengajuan_detail = '" . $data['id_pengajuan_proposal'] . "' AND id_anggota = '" . $data['id_anggota'] . "' ";

		$this->db->query($sql);
	}

	public function get_notif_kosong($data)
	{
		$sql = "SELECT id_anggota, id_pengajuan_detail FROM tb_permintaan_anggota WHERE status_permintaan = '" . $data['status_permintaan'] . "' AND id_pengajuan_detail = '" . $data['id_pengajuan_proposal'] . "' AND id_anggota = '" . $data['id_anggota'] . "' ";

		$out = $this->db->query($sql);

		return $out;
	}
	public function check_tipe_pengajuan($id)
	{
		$sql = "SELECT c.id_event FROM tb_pengajuan as a JOIN tb_list_event as b ON a.id_list_event=b.id_list_event JOIN tb_jenis_event c on b.id_jenis_event = c.id_jenis_event WHERE a.id_pengajuan = '" . $id . "'";

		$out = $this->db->query($sql);

		return $out;
	}
	public function get_permintaan($data)
	{
		$sql = "SELECT a.id_anggota, a.id_pengajuan_detail, b.id_pengajuan_detail, d.judul, a.status_permintaan FROM tb_permintaan_anggota as a JOIN tb_pengajuan_detail as b ON a.id_pengajuan_detail=b.id_pengajuan_detail JOIN tb_identitas_pengajuan d on d.id_pengajuan_detail = a.id_pengajuan_detail WHERE a.id_anggota = '" . $data['id_anggota'] . "' AND a.status_permintaan = 0 ";

		$out = $this->db->query($sql);

		return $out;
	}
	public function get_proposal_byId($id)
	{
		$this->db->from('tb_pengajuan as a');
		$this->db->select('*');
		$this->db->join('dummy_dosen as c', 'a.nidn_ketua = c.nidn');
		$this->db->where('a.id_pengajuan', $id);
		return $this->db->get();
	}

	public function get_list_event()
	{
		return $this->db->get('view_list_event')->result();
	}

	public function list_by_jenis($jenis)
	{
		$this->db->select('tahapan, mulai,akhir');
		$this->db->from('view_list_event');
		$this->db->where('id_jenis', $jenis);
		$this->db->where('status',1);
		$this->db->order_by('mulai', 'asc');
		return $this->db->get()->result();
	}

	public function get_all($table)
	{
		return $this->db->get($table);
	}

	public function get_history($id)
	{
		$this->db->select('a.id_pengajuan_detail, nidn, judul, tema_penelitian, tahun_usulan');
		$this->db->from('tb_anggota_dosen as a');
		$this->db->join('tb_identitas_pengajuan as b', 'a.id_pengajuan_detail=b.id_pengajuan_detail');
		$this->db->where('a.nidn', $id);

		return $this->db->get();
	}
}
