<?php

class M_reviewer extends CI_Model
{


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
	public function get_reviewer_proposal($id)
	{

		$this->db->select('a.id_reviewer, a.id_pengajuan_detail, b.id_reviewer, b.nidn, b.status');
		$this->db->from('tb_kerjaan_reviewer as a');
		$this->db->join('tb_reviewer as b', 'a.id_reviewer=b.id_reviewer');
		$this->db->where('b.status', 1);
		$this->db->where('a.id_pengajuan_detail', $id);
		$ret = $this->db->get();

		return $ret;
	}
	public function get_anggota_proposal($id)
	{

		$this->db->select('a.id_anggota_dsn, a.id_pengajuan_detail, a.nidn, a.status');
		$this->db->from('tb_anggota_dosen as a');
		$this->db->where('a.status', 1);
		$this->db->where('a.id_pengajuan_detail', $id);
		$ret = $this->db->get();

		return $ret;
	}
	public function anggota_dosen_Byproposal($id)
	{

		$this->db->select('a.id_anggota, a.status_notifikasi, b.id_sinta, a.id_pengajuan_detail, a.status_permintaan, b.nidn, b.status, b.id_anggota_dsn');
		$this->db->from('tb_permintaan_anggota as a');
		$this->db->join('tb_anggota_dosen as b', 'b.id_anggota_dsn=a.id_anggota');
		$this->db->where('b.status', 1);
		$this->db->where('a.id_pengajuan_detail', $id);
		$ret = $this->db->get();

		return $ret;
	}

	public function anggota_mhs_Byproposal($id)
	{

		$this->db->select('a.nim, a.nama, a.jurusan prodi, a.id_pengajuan_detail, a.status, a.id_anggota_mhs');
		$this->db->from('tb_anggota_mhs as a');
		$this->db->where('a.id_pengajuan_detail', $id);
		$ret = $this->db->get();

		return $ret;
	}
	public function get_list_event()
	{
		$this->db->select('a.id_jenis_event, a.id_pendanaan, a.id_event, a.status, b.id_event, b.nm_event, b.status, c.id_pendanaan, c.nm_pendanaan, c.status');
		$this->db->from('tb_jenis_event as a');
		$this->db->join('tb_event as b', 'b.id_event=a.id_event');
		$this->db->join('tb_pendanaan as c', 'c.id_pendanaan=a.id_pendanaan');
		$this->db->where('a.id_pendanaan', 1);
		$this->db->where('a.status', 1);
		$this->db->where('b.status', 1);
		$this->db->where('c.status', 1);

		return $this->db->get();
	}

	public function get_all_joinproposal()
	{
		$this->db->select('*');
		$this->db->from('tb_identitas_pengajuan as a');
		$this->db->join('tb_pengajuan as b', 'b.id_pengajuan = a.id_pengajuan');
		$this->db->join('dummy_dosen as c', 'c.nidn = b.nidn_ketua');
		$this->db->join('tb_dokumen_pengajuan as d', 'd.id_pengajuan = b.id_pengajuan');
		return $this->db->get();
	}
	public function get_proposalByReviewer($reviewer, $where)
	{
		$this->db->select('*');
		$this->db->from('tb_kerjaan_reviewer as a');
		$this->db->join('tb_reviewer as rr', 'rr.id_reviewer = a.id_reviewer');
		$this->db->join('tb_pengajuan_detail as b', 'b.id_pengajuan_detail = a.id_pengajuan_detail');
		$this->db->join('tb_pengajuan as zz', 'b.id_pengajuan = zz.id_pengajuan');
		$this->db->join('tb_list_event as bb', 'bb.id_list_event = zz.id_list_event');
		$this->db->join('tb_jenis_event as aa', 'aa.id_jenis_event = bb.id_jenis_event');
		$this->db->join('tb_event as cc', 'cc.id_event=aa.id_event');
		$this->db->join('tb_pendanaan as dd', 'dd.id_pendanaan=aa.id_pendanaan');
		$this->db->join('dummy_dosen as c', 'c.nidn = zz.nidn_ketua');
		$this->db->join('tb_dokumen_pengajuan as d', 'd.id_pengajuan_detail = a.id_pengajuan_detail');
		$this->db->join('tb_identitas_pengajuan as e', 'e.id_pengajuan_detail = a.id_pengajuan_detail');
		$this->db->where('a.id_reviewer', $reviewer);
		$this->db->where('a.kerjaan_selesai', $where);
		return $this->db->get();
	}
	public function get_proposal_byEvent($id)
	{
		$this->db->select('a.id_det_pengajuan, a.id_pengajuan_detail, a.judul, a.tahun_usulan, b.id_pengajuan_detail, dd.id_list_event, dd.nidn_ketua, dd.status, c.nidn, c.nama  ');
		$this->db->from('tb_identitas_pengajuan as a');
		$this->db->join('tb_pengajuan_detail as b', 'b.id_pengajuan_detail = a.id_pengajuan_detail');
		$this->db->join('tb_pengajuan as dd', 'dd.id_pengajuan = b.id_pengajuan');
		$this->db->join('dummy_dosen as c', 'c.nidn = dd.nidn_ketua');
		$this->db->join('tb_dokumen_pengajuan as cc', 'cc.id_pengajuan_detail = b.id_pengajuan_detail');

		$this->db->join('tb_list_event as bb', 'bb.id_list_event = dd.id_list_event');
		$this->db->join('tb_jenis_event as aa', 'aa.id_jenis_event = bb.id_jenis_event');

		$this->db->where('bb.id_jenis_event', $id);
		$where = "cc.file_rab is  NOT NULL AND cc.file_proposal is NOT NULL";
		$this->db->where($where);
		return $this->db->get();
	}

	public function get_tahun_proposal($id, $tahun)
	{
		$this->db->select('a.id_det_pengajuan, a.id_pengajuan_detail, a.judul, a.tahun_usulan, b.id_pengajuan_detail, dd.id_list_event, dd.nidn_ketua, dd.status, c.nidn, c.nama  ');
		$this->db->from('tb_identitas_pengajuan as a');
		$this->db->join('tb_pengajuan_detail as b', 'b.id_pengajuan_detail = a.id_pengajuan_detail');
		$this->db->join('tb_pengajuan as dd', 'dd.id_pengajuan = b.id_pengajuan');
		$this->db->join('dummy_dosen as c', 'c.nidn = dd.nidn_ketua');
		$this->db->join('tb_dokumen_pengajuan as cc', 'cc.id_pengajuan_detail = b.id_pengajuan_detail');

		$this->db->join('tb_list_event as bb', 'bb.id_list_event = dd.id_list_event');
		$this->db->join('tb_jenis_event as aa', 'aa.id_jenis_event = bb.id_jenis_event');

		$this->db->where('bb.id_jenis_event', $id);
		$this->db->where('a.tahun_usulan', $tahun);
		$where = "cc.file_rab is  NOT NULL AND cc.file_proposal is NOT NULL";
		$this->db->where($where);
		return $this->db->get();
	}

	public function get_proposal_mandiri_byEvent($where)
	{
		$this->db->select('a.id_pengajuan_detail id_detail,b.judul, b.tahun_usulan tahun, d.nama, d.nip');
		$this->db->from('pengajuan_detail_mandiri a');
		$this->db->join('identitas_pengajuan_mandiri b', 'a.id_pengajuan_detail = b.id_pengajuan_detail');
		$this->db->join('pengajuan_mandiri c', 'a.id_pengajuan = c.id_pengajuan');
		$this->db->join('dummy_dosen d', 'c.nip_ketua = d.nip');
		$this->db->where($where);
		return $this->db->get()->result();
	}
	public function get_proposal_byId($id)
	{
		$this->db->select('*');
		$this->db->from('tb_identitas_pengajuan as a');
		$this->db->join('tb_pengajuan_detail as b', 'b.id_pengajuan_detail = a.id_pengajuan_detail');
		$this->db->join('tb_pengajuan as bb', 'b.id_pengajuan = bb.id_pengajuan');
		$this->db->join('dummy_dosen as c', 'c.nidn = bb.nidn_ketua');
		$this->db->join('tb_dokumen_pengajuan as d', 'd.id_pengajuan_detail = b.id_pengajuan_detail');
		$this->db->where('b.id_pengajuan_detail', $id);
		return $this->db->get();
	}

	public function get_proposalnya($id)
	{
		$this->db->select('g.id_event, a.id_pengajuan_detail id_pengajuan_detail,e.id_pengajuan, c.id_kelompok_pengajuan, c.tema_penelitian tema,c.sasaran,c.biaya,a.id_fokus,e.nidn_ketua nidn_ketua, a.is_nambah_luaran ,b.nama nama_ketua, c.judul judul, c.tanggal_mulai_kgt mulai, c.tanggal_akhir_kgt akhir, c.biaya biaya_usulan, c.tahun_usulan tahun_usulan, d.ringkasan_pengajuan ringkasan, d.metode metode , d.tinjauan_pustaka tinjauan, d.file_proposal proposal, d.file_rab rab, a.status_keputusan');
		$this->db->from('tb_pengajuan_detail a');
		$this->db->join('tb_pengajuan e', 'e.id_pengajuan = a.id_pengajuan');
		$this->db->join('dummy_dosen b', 'e.nidn_ketua = b.nidn');
		$this->db->join('tb_identitas_pengajuan c', 'a.id_pengajuan_detail = c.id_pengajuan_detail');
		$this->db->join('tb_dokumen_pengajuan d', 'a.id_pengajuan_detail = d.id_pengajuan_detail');
		$this->db->join('tb_list_event f', 'f.id_list_event = e.id_list_event');
		$this->db->join('tb_jenis_event g', 'g.id_jenis_event = f.id_jenis_event');
		$this->db->where('a.id_pengajuan_detail', $id);
		return $this->db->get()->row();
	}

	public function status_kerjaan($di_pengajuan)
	{
		$this->db->select('id_kerjaan,updated_at dinilai, kerjaan_selesai status');
		$this->db->from('tb_kerjaan_reviewer');
		$this->db->where(['id_reviewer' => $this->session->userdata('id_reviewer'), 'id_pengajuan_detail' => $di_pengajuan]);
		return $this->db->get()->row();
	}
	public function admin_status_kerjaan_reviewer($id_kerjaan)
	{
		$this->db->select('id_kerjaan,updated_at dinilai, kerjaan_selesai status');
		$this->db->from('tb_kerjaan_reviewer');
		$this->db->where(['id_kerjaan' => $id_kerjaan]);
		return $this->db->get()->row();
	}
	public function get_luaran_checked($id)
	{
		$this->db->select('id_luaran');
		$this->db->from('tb_target_luaran');
		$this->db->where('id_pengajuan_detail', $id);
		$checked = $this->db->get()->result();

		return $checked;
	}

	public function luaran_tambahan($id)
	{
		$this->db->select('judul_luaran_tambahan judul');
		$this->db->from('tb_luaran_tambahan');
		$this->db->where('id_pengajuan_detail', $id);
		return $this->db->get()->row();
	}

	public function get_proposal_pnbp()
	{
		$sql = "select a.id_pengajuan, a.id_event, a.judul, a.NIDSN_ketua, b.jenis_event, b.id_event from tb_pengajuan as a join tb_event as b on a.id_event=b.id_event ";
		return $this->db->query($sql);
	}

	public function countProposal()
	{
		$this->db->select('COUNT(id_pengajuan) AS count, b.nidn as nidn, c.nama, c.unit, a.id_reviewer as id_reviewer');
		$this->db->from('tb_kerjaan_reviewer as a');
		$this->db->join('tb_reviewer as b', 'b.id_reviewer=a.id_reviewer');
		$this->db->join('dummy_dosen as c', 'c.nidn=b.nidn');
		// $this->db->join('tb_dummy_jurusan as d', 'd.id_jurusan=c.jurusan');
		$this->db->group_by('id_reviewer');
		return $this->db->get();
	}
	public function get_proposal_byreviewer($id)
	{
		$this->db->select('*');
		$this->db->from('tb_kerjaan_reviewer as a');
		$this->db->join('tb_pengajuan as b', 'b.id_pengajuan=a.id_pengajuan');
		$this->db->join('tb_identitas_pengajuan as c', 'c.id_pengajuan=b.id_pengajuan');
		$this->db->join('tb_list_event as d', 'd.id_list_event=b.id_list_event');
		$this->db->join('tb_jenis_event as e', 'e.id_jenis_event=d.id_jenis_event');
		$this->db->join('tb_pendanaan as f', 'f.id_pendanaan=e.id_pendanaan');
		$this->db->join('tb_event as g', 'g.id_event=e.id_event');
		// $this->db->join('tb_event as c', 'c.id_event=b.id_event');
		$this->db->where('a.id_reviewer', $id);
		return $this->db->get();
	}

	public function get_soal()
	{
		$this->db->select('a.id_soal, a.deskripsi_pilihan, a.score, b.id_soal, b.soal, b.id_jenis_soal, c.id_jenis_soal, c.nm_jenis_soal, a.id_pilihan, a.status, b.status');
		$this->db->from('tb_pilihan as a');
		$this->db->join('tb_soal as b', 'b.id_soal=a.id_soal');
		$this->db->join('tb_jenis_soal as c', 'c.id_jenis_soal=b.id_jenis_soal');
		$this->db->where('a.status', 1);
		$this->db->where('b.status', 1);
		$this->db->where('c.id_event', 1);
		$this->db->group_by('a.id_soal');

		return $this->db->get();
	}

	public function get_soal2()
	{
		$this->db->select('a.id_soal, a.prosentase, a.deskripsi_pilihan, a.score, b.id_soal, b.soal, b.id_jenis_soal, c.id_jenis_soal, c.nm_jenis_soal, a.id_pilihan, a.status, b.status');
		$this->db->from('tb_pilihan as a');
		$this->db->join('tb_soal as b', 'b.id_soal=a.id_soal');
		$this->db->join('tb_jenis_soal as c', 'c.id_jenis_soal=b.id_jenis_soal');
		$this->db->where('a.status', 1);
		$this->db->where('b.status', 1);
		$this->db->where('c.id_event', 2);
		$this->db->group_by('a.id_soal');

		return $this->db->get();
	}

	public function get_soal_byId($id)
	{
		$this->db->select('a.id_soal, a.deskripsi_pilihan, a.score, a.prosentase, b.id_soal, b.soal, b.id_jenis_soal, c.id_jenis_soal, c.nm_jenis_soal, a.id_pilihan, a.status, b.status');
		$this->db->from('tb_pilihan as a');
		$this->db->join('tb_soal as b', 'b.id_soal=a.id_soal');
		$this->db->join('tb_jenis_soal as c', 'c.id_jenis_soal=b.id_jenis_soal');
		$this->db->where('a.status', 1);
		$this->db->where('b.status', 1);
		$this->db->where('a.id_soal', $id);

		return $this->db->get();
	}

	public function checkNIDSN($id)
	{
		$this->db->select('*');
		$this->db->from('tb_reviewer as a');
		$this->db->where('nidn', $id);
		return $this->db->get();
	}

	public function getReviewerByProposal($id)
	{
		$this->db->select('*');
		$this->db->from('tb_kerjaan_reviewer as a');
		$this->db->join('tb_pengajuan_detail as b', 'b.id_pengajuan_detail=a.id_pengajuan_detail');
		$this->db->join('tb_pengajuan as f', 'b.id_pengajuan=f.id_pengajuan');
		$this->db->join('tb_reviewer as d', 'd.id_reviewer=a.id_reviewer');
		$this->db->join('dummy_dosen as c', 'c.nidn=d.nidn');
		$this->db->where('a.id_pengajuan_detail', $id);
		return $this->db->get();
	}

	public function hapusReviewer($id)
	{

		$this->db->select('id_reviewer, id_pengajuan_detail');
		$this->db->from('tb_kerjaan_reviewer');
		$this->db->where('id_kerjaan', $id);
		$rev = $this->db->get()->row();

		$this->db->delete('tb_reviewer', array('id_reviewer' => $rev->id_reviewer));
		$this->db->delete('tb_kerjaan_reviewer', array('id_kerjaan' => $id));

		return $rev->id_pengajuan;
	}

	public function get_totalscore($id = '', $jenis = '', $event = '')
	{
		$this->db->select('bobot');
		$this->db->from('tb_jenis_soal');
		$this->db->where('id_jenis_soal', $jenis);
		$rev = $this->db->get()->row();

		if ($id != '' && $jenis != '') {
			# code...
			if ($event == 2) {
				if ($jenis == 4) {
					$sql = 'SELECT SUM(hasilPersen) AS TotalScore FROM( SELECT (((b.score/7)*' . $rev->bobot . ') * b.prosentase/100) AS hasilPersen, b.id_soal, b.id_pilihan, b.status FROM tb_pilihan AS b GROUP BY b.id_pilihan ) AS d JOIN tb_soal AS c ON c.id_soal = d.id_soal JOIN tb_penilaian AS a ON a.id_pilihan = d.id_pilihan WHERE a.id_kerjaan = ' . $id . ' AND c.id_jenis_soal = ' . $jenis . ' AND d.status = 1 GROUP BY c.id_jenis_soal';
					return $this->db->query($sql)->result();
				} else {
					$sql = 'SELECT SUM(hasilPersen) AS TotalScore FROM( SELECT (b.score * b.prosentase/100) AS hasilPersen, b.id_soal, b.id_pilihan, b.status FROM tb_pilihan AS b GROUP BY b.id_pilihan ) AS d JOIN tb_soal AS c ON c.id_soal = d.id_soal JOIN tb_penilaian AS a ON a.id_pilihan = d.id_pilihan WHERE a.id_kerjaan = ' . $id . ' AND c.id_jenis_soal = ' . $jenis . ' AND d.status = 1 GROUP BY c.id_jenis_soal';
					return $this->db->query($sql)->result();
				}
			} else {
				$sql = 'SELECT SUM(b.score) AS TotalScore,a.id_pilihan ,a.id_kerjaan , b.id_pilihan, b.id_soal, c.id_soal, c.id_jenis_soal FROM tb_penilaian as a JOIN tb_pilihan as b ON a.id_pilihan = b.id_pilihan JOIN tb_soal as c ON c.id_soal = b.id_soal WHERE a.id_kerjaan = ' . $id . ' AND c.id_jenis_soal = ' . $jenis . ' AND b.status = 1';
				return $this->db->query($sql)->result();
			}
		}
	}
	public function get_luaran()
	{
		return $this->db->get_where('tb_luaran', ['status' => 1])->result();
	}

	public function cek_kerjaan($id_kerjaan)
	{
		$this->db->select('kerjaan_selesai');
		$this->db->from('tb_kerjaan_reviewer');
		$this->db->where('id_kerjaan', $id_kerjaan);
		return $this->db->get()->row();
	}

	public function update_status_kerjaan($id_kerjaan)
	{
		$this->db->where('id_kerjaan', $id_kerjaan);
		return $this->db->update('tb_kerjaan_reviewer', ['kerjaan_selesai' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
	}

	public function update_nilai($data)
	{
		$this->db->where('id_penilaian', $data['id_penilaian']);
		return $this->db->update('tb_penilaian', ['id_pilihan' => $data['id_pilihan'],  'updated_at' => date('Y-m-d H:i:s')]);
	}

	public function get_nilai_pilihan($id_pilihan)
	{
		$this->db->select('score');
		$this->db->where('id_pilihan', $id_pilihan);
		return $this->db->get('tb_pilihan')->row();
	}

	public function get_nilai($id_kerjaan)
	{
		$this->db->select('id_penilaian,id_pilihan');
		$this->db->from('tb_penilaian');
		$this->db->where('id_kerjaan', $id_kerjaan);
		return $this->db->get()->result();
	}

	public function update_masukan($data)
	{
		$this->db->where('id_kerjaan', $data['id_kerjaan']);
		return $this->db->update('rekomendasi_reviewer', ['masukan_reviewer' => $data['masukan']]);
	}

	public function get_rekomendasi($id_kerjaan)
	{
		$this->db->select(' masukan_reviewer');
		$this->db->from('rekomendasi_reviewer');
		$this->db->where('id_kerjaan', $id_kerjaan);
		return $this->db->get()->row();
	}

	public function get_id_proposal($id_kerjaan)
	{
		$this->db->select('id_pengajuan_detail');
		$this->db->from('tb_kerjaan_reviewer');
		$this->db->where('id_kerjaan', $id_kerjaan);
		return $this->db->get()->row();
	}

	public function get_ALLJenis_Soal()
	{
		$this->db->select('*');
		$this->db->from('tb_jenis_soal as a');
		$this->db->join('tb_event as b', 'a.id_event=b.id_event');
		return $this->db->get();
	}

	public function get_Jenis_Soal()
	{
		$this->db->select('*');
		$this->db->from('tb_jenis_soal');
		$this->db->where('id_event', 1);
		return $this->db->get();
	}

	public function get_Jenis_Soal2()
	{
		$this->db->select('*');
		$this->db->from('tb_jenis_soal');
		$this->db->where('id_event', 2);
		return $this->db->get();
	}

	public function get_Jenis_SoalbyId($id)
	{
		$this->db->select('*');
		$this->db->from('tb_jenis_soal');
		$this->db->where('id_jenis_soal', $id);

		return $this->db->get()->row();
	}

	public function get_Pilihan($id)
	{
		$this->db->select('*');
		$this->db->from('tb_pilihan');
		$this->db->where('id_soal', $id);

		return $this->db->get();
	}

	public function get_Pilihan_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('tb_pilihan');
		$this->db->where('id_pilihan', $id);

		return $this->db->get()->row();
	}

	public function get_Reviewerdsn($tahun)
	{
		$this->db->select('a.id_kerjaan, a.id_reviewer, a.id_pengajuan_detail, COUNT(a.id_pengajuan_detail) as total, c.nama, c.nidn');
		$this->db->from('tb_kerjaan_reviewer as a');
		$this->db->join('tb_reviewer as b', 'a.id_reviewer = b.id_reviewer');
		$this->db->join('dummy_dosen as c', 'b.nidn = c.nidn');
		//ini get tahun dari tahun usulan proposal yang akan di review
		$this->db->join('tb_identitas_pengajuan as d', 'd.id_pengajuan_detail = a.id_pengajuan_detail');
		$this->db->where("d.tahun_usulan",$tahun);
		$this->db->group_by('id_reviewer');
		$this->db->order_by('id_reviewer', 'ASC');

		return $this->db->get();
	}

	public function get_proposalRvw($id)
	{
		$this->db->select('a.id_kerjaan, a.id_reviewer, d.id_pengajuan, f.nama as rvw, c.nidn, b.judul, b.tema_penelitian as tema, b.biaya, b.tahun_usulan, e.nama as ketua');
		$this->db->from('tb_kerjaan_reviewer as a');
		$this->db->join('tb_identitas_pengajuan as b', 'a.id_pengajuan_detail = b.id_pengajuan_detail');
		$this->db->join('tb_reviewer as c', 'a.id_reviewer = c.id_reviewer');
		$this->db->join('dummy_dosen as f', 'c.nidn = f.nidn');
		$this->db->join('tb_pengajuan_detail as cc', 'cc.id_pengajuan_detail=a.id_pengajuan_detail');
		$this->db->join('tb_pengajuan as d', 'd.id_pengajuan = cc.id_pengajuan');
		$this->db->join('dummy_dosen as e', 'd.nidn_ketua = e.nidn');
		$this->db->where('a.id_reviewer', $id);

		return $this->db->get();
	}

	public function get_proposalnya_mandiri($id)
	{
		$this->db->select('a.id_pengajuan_detail id_pengajuan,c.tema_penelitian tema,c.sasaran,c.biaya,a.id_fokus,e.nip_ketua nidn_ketua, a.is_nambah_luaran ,b.nama nama_ketua, c.judul judul, c.tanggal_mulai mulai, c.tanggal_akhir akhir, c.biaya biaya_usulan, c.tahun_usulan tahun_usulan, d.ringkasan_pengajuan ringkasan, d.metode metode , d.tinjauan_pustaka tinjauan, d.file_proposal proposal, d.file_rab rab, a.status, a.status_koreksi');
		$this->db->from('pengajuan_detail_mandiri a');
		$this->db->join('pengajuan_mandiri e', 'a.id_pengajuan = e.id_pengajuan');
		$this->db->join('dummy_dosen b', 'e.nip_ketua = b.nidn');
		$this->db->join('identitas_pengajuan_mandiri c', 'a.id_pengajuan_detail = c.id_pengajuan_detail');
		$this->db->join('dokumen_pengajuan_mandiri d', 'a.id_pengajuan_detail = d.id_pengajuan_detail');
		$this->db->where('a.id_pengajuan_detail', $id);
		return $this->db->get()->row();
	}

	public function get_anggota_dosen($id)
	{
		$this->db->select('a.nip, a.file_cv, b.nama, b.jenis_unit, b.unit');
		$this->db->from('anggota_dosen_mandiri a');
		$this->db->join('dummy_dosen b', 'a.nip = b.nip');
		$this->db->where(['a.id_pengajuan_detail' => $id, 'a.status' => 2]);
		return $this->db->get()->result();
	}

	public function get_anggota_mahasiswa($id)
	{
		$this->db->select('nim,nama,jurusan,angkatan');
		$this->db->from('anggota_mhs_mandiri');
		$this->db->where(['id_pengajuan_detail' => $id, 'status' => 1]);
		return $this->db->get()->result();
	}


	public function get_luaran_checked_mandiri($id)
	{
		$this->db->select('id_luaran');
		$this->db->from('target_luaran_mandiri');
		$this->db->where('id_pengajuan_detail', $id);
		$checked = $this->db->get()->result();

		return $checked;
	}

	public function luaran_tambahan_mandiri($id)
	{
		$this->db->select('judul_luaran_tambahan judul');
		$this->db->from('luaran_tambahan_mandiri');
		$this->db->where('id_pengajuan_detail', $id);
		return $this->db->get()->row();
	}

	public function getBobotJenis($id)
	{
		$this->db->select('b.bobot, b.id_event');
		$this->db->from('tb_soal a');
		$this->db->join('tb_jenis_soal b', 'a.id_jenis_soal = b.id_jenis_soal');
		$this->db->where('a.id_soal', $id);
		$checked = $this->db->get()->row();

		return $checked;
	}
}
