<?php 

class M_laporan extends CI_Model{
  public function get_all_akhir($tahun,$skema,$event,$status){
    $this->db->select('a.id_det_pengajuan, a.id_pengajuan_detail, a.judul, a.tahun_usulan, b.id_pengajuan_detail, dd.id_list_event, dd.nidn_ketua, dd.status, c.nidn, c.nama,b.updated_at,b.created_at, klp.nama_kelompok');
		$this->db->from('tb_identitas_pengajuan as a');
		$this->db->join('tb_pengajuan_detail as b', 'b.id_pengajuan_detail = a.id_pengajuan_detail');
		$this->db->join('tb_pengajuan as dd', 'dd.id_pengajuan = b.id_pengajuan');
		$this->db->join('dummy_dosen as c', 'c.nidn = dd.nidn_ketua');
		$this->db->join('tb_dokumen_pengajuan as cc', 'cc.id_pengajuan_detail = b.id_pengajuan_detail');

		$this->db->join('tb_list_event as bb', 'bb.id_list_event = dd.id_list_event');
		$this->db->join('tb_jenis_event as aa', 'aa.id_jenis_event = bb.id_jenis_event');
		$this->db->join('tb_kelompok_pengajuan klp', 'a.id_kelompok_pengajuan = klp.id_kelompok_pengajuan');

		$this->db->where('bb.id_jenis_event', $event);
		$this->db->where('a.tahun_usulan', $tahun);
		if ($skema != "ALL") {
			$this->db->where('a.id_kelompok_pengajuan', $skema);
		}

		$where = "cc.file_rab is  NOT NULL AND cc.file_proposal is NOT NULL";
    if($status !== NULL){
      $this->db->where("b.status_keputusan",$status);
    } else {
      $where .= "  AND (b.status_keputusan IS NULL OR b.status_keputusan = 3)";
		}
		$this->db->where($where);
		// $this->db->where('b.status_keputusan',4);
		return $this->db->get();
 }
}