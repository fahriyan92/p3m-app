<?php

class M_pemonev extends CI_Model
{
	function insert($table = '', $data = '')
	{
		$this->db->insert($table, $data);
	}

	function update($table = '', $data = '')
	{
		$this->db->update($table, $data);
	}

	function get_where($table = null, $where = null)
	{
		$this->db->from($table);
		$this->db->where($where);

		return $this->db->get();
	}

	function get_all($table)
	{
		$this->db->where("jenis_job", "dosen");
		$this->db->from($table);
		return $this->db->get();
	}

	public function getReviewerByProposal_revisi($id)
	{
		$query = "SELECT
		nilai_satu.id_kerjaan_monev,
		dosen.nama,
		dosen.nip,
		dosen.unit,
		IF(
			ROUND(
				SUM(nilai_satu.nilai_sementara),
				2
			) != 0.00,
			ROUND(
				SUM(nilai_satu.nilai_sementara),
				2
			),
			'Belum Dimonev'
		) AS nilai_fix
	FROM
		(
		SELECT
			kj.id_kerjaan_monev,
			kj.id_pemonev,
			kj.id_pengajuan_detail,
			(
				CASE WHEN js.id_event = 1 THEN(SUM(pl.score) * js.bobot / 100) WHEN js.id_event = 2 THEN IF(
					js.id_jenis_soal = 4,
					(
						SUM(
							(pl.score / 7) * js.bobot * pl.prosentase
						)
					) / 100,
					SUM((pl.score * pl.prosentase)) / 100
				) WHEN js.id_event = 3 THEN IF(
					js.id_jenis_soal = 5,
					(
						SUM(
							(pl.score / 7) * js.bobot * pl.prosentase
						)
					) / 100,
					SUM((pl.score * pl.prosentase)) / 100
				) ELSE 0
			END
	) AS nilai_sementara
	FROM
		tb_kerjaan_pemonev kj
	LEFT JOIN tb_penilaian pn ON
		kj.id_kerjaan_monev = pn.id_kerjaan_monev
	LEFT JOIN tb_pilihan AS pl
	ON
		pl.id_pilihan = pn.id_pilihan
	LEFT JOIN tb_soal sl ON
		sl.id_soal = pl.id_soal AND pl.status = 1
	LEFT JOIN tb_jenis_soal js ON
		sl.id_jenis_soal = js.id_jenis_soal AND sl.status = 1
	WHERE
		kj.id_pengajuan_detail = " . $id . "
	GROUP BY
		kj.id_kerjaan_monev,
		js.id_jenis_soal
	) AS nilai_satu
	INNER JOIN tb_pemonev ON nilai_satu.id_pemonev = tb_pemonev.id_pemonev
	INNER JOIN dummy_dosen dosen ON
		tb_pemonev.nidn = dosen.nidn
	WHERE
		nilai_satu.id_pengajuan_detail = " . $id . "
	GROUP BY
		nilai_satu.id_kerjaan_monev;";

		return $this->db->query($query);
	}

	public function hapusPemonev($id)
	{

		$this->db->select('id_pemonev, id_pengajuan_detail');
		$this->db->from('tb_kerjaan_pemonev');
		$this->db->where('id_kerjaan_monev', $id);
		$rev = $this->db->get()->row();

		$this->db->delete('tb_pemonev', array('id_pemonev' => $rev->id_pemonev));
		$this->db->delete('tb_kerjaan_pemonev', array('id_kerjaan_monev' => $id));

		return $rev->id_pengajuan;
	}

	public function get_MasterPemonev($id_event)
	{
		$this->db->select('*');
		$this->db->from('tb_pemonev as a');
		$this->db->join('dummy_dosen as c', 'a.nidn = c.nidn');
		$this->db->like('a.id_event', $id_event);

		return $this->db->get();
	}

	function pemonev_get_all()
	{
		$this->db->select("nidn");
		$this->db->where("status", 1);
		$query1 = $this->db->get("tb_pemonev")->result();
		if (!empty($query1)) {
			$listId = "";
			foreach ($query1 as $key) {
				$listId .= $key->nidn . ",";
			}
			$listId = substr($listId, 0, -1);

			$sql = "Select * from dummy_dosen WHERE jenis_job = 'dosen' AND nidn NOT IN ($listId)";
			$query2 = $this->db->query($sql);
			return $query2->result();
		}
	}

	public function admin_status_kerjaan_pemonev($id_kerjaan)
	{
		$this->db->select('id_kerjaan_monev,updated_at dinilai, kerjaan_selesai status');
		$this->db->from('tb_kerjaan_pemonev');
		$this->db->where(['id_kerjaan_monev' => $id_kerjaan]);
		return $this->db->get()->row();
	}

	public function list_pemonev_asc()
	{
		$this->db->select('tb_pemonev.id_pemonev, tb_pemonev.id_event, dummy_dosen.nama, tb_pemonev.status');
		$this->db->join('dummy_dosen', 'dummy_dosen.nidn = tb_pemonev.nidn');
		// $this->db->join('tb_event', 'tb_event.id_event = tb_reviewer.id_event');
		$this->db->where('status', '1');
		$this->db->order_by('id_pemonev', 'asc');
		return $this->db->get('tb_pemonev')->result();
	}

	public function checkNIDSN($id)
	{
		$this->db->select('*');
		$this->db->from('tb_pemonev as a');
		$this->db->where('nidn', $id);
		return $this->db->get();
	}

	public function cek_nidn($id, $tahun)
	{
		$this->db->select('*');
		$this->db->where('id_pemonev', $id);
		$this->db->where('tahun', $tahun);
		return $this->db->get('tb_pemonev')->num_rows();
	}

	public function get_tahun_proposal($id, $tahun, $skema, $fokus)
	{
		$this->db->select('a.id_det_pengajuan, a.id_pengajuan_detail, a.judul, a.tahun_usulan, b.id_pengajuan_detail, dd.id_list_event, dd.nidn_ketua, dd.status, c.nidn, c.nama, c.pangkat,  c.nip, b.updated_at, b.created_at, b.status_keputusan, klp.nama_kelompok');
		$this->db->from('tb_identitas_pengajuan AS a');
		$this->db->join('tb_pengajuan_detail AS b', 'b.id_pengajuan_detail = a.id_pengajuan_detail');
		$this->db->join('tb_pengajuan as dd', 'dd.id_pengajuan = b.id_pengajuan');
		$this->db->join('dummy_dosen as c', 'c.nidn = dd.nidn_ketua');
		$this->db->join('tb_dokumen_pengajuan as cc', 'cc.id_pengajuan_detail = b.id_pengajuan_detail');

		$this->db->join('tb_list_event as bb', 'bb.id_list_event = dd.id_list_event');
		$this->db->join('tb_jenis_event as aa', 'aa.id_jenis_event = bb.id_jenis_event');
		$this->db->join('tb_kelompok_pengajuan klp', 'a.id_kelompok_pengajuan = klp.id_kelompok_pengajuan');

		$this->db->where('bb.id_jenis_event', $id);
		$this->db->where('a.tahun_usulan', $tahun);
		$this->db->where('b.status_keputusan', 6);
		if ($skema != "ALL") {
			$this->db->where('a.id_kelompok_pengajuan', $skema);
		}

		if ($fokus != "ALL") {
			$this->db->where('b.id_fokus ', $fokus);
		}
		$where = "cc.file_rab is  NOT NULL AND cc.file_proposal is NOT NULL";
		$this->db->where($where);
		// $this->db->where('b.status_keputusan',4);
		return $this->db->get();
	}

	public function get_proposalByPemonev_revisi($reviewer, $where, $id_jenis_event)
	{
		$this->db->select('*');
		$this->db->from('tb_kerjaan_pemonev as a');
		$this->db->join('tb_pemonev as rr', 'rr.id_pemonev = a.id_pemonev');
		$this->db->join('tb_pengajuan_detail as b', 'b.id_pengajuan_detail = a.id_pengajuan_detail');
		$this->db->join('tb_pengajuan as zz', 'b.id_pengajuan = zz.id_pengajuan');
		$this->db->join('tb_list_event as bb', 'bb.id_list_event = zz.id_list_event');
		$this->db->join('tb_jenis_event as aa', 'aa.id_jenis_event = bb.id_jenis_event');
		$this->db->join('tb_event as cc', 'cc.id_event=aa.id_event');
		$this->db->join('tb_pendanaan as dd', 'dd.id_pendanaan=aa.id_pendanaan');
		$this->db->join('dummy_dosen as c', 'c.nidn = zz.nidn_ketua');
		$this->db->join('tb_dokumen_pengajuan as d', 'd.id_pengajuan_detail = a.id_pengajuan_detail');
		$this->db->join('tb_identitas_pengajuan as e', 'e.id_pengajuan_detail = a.id_pengajuan_detail');
		$this->db->where('a.id_pemonev', $reviewer);
		$this->db->where('a.kerjaan_selesai', $where);
		$this->db->where('aa.id_jenis_event', $id_jenis_event);
		return $this->db->get();
	}

	public function status_kerjaan_revisi($id_pemonev, $di_pengajuan)
	{
		$this->db->select('id_kerjaan_monev, updated_at dinilai, kerjaan_selesai status');
		$this->db->from('tb_kerjaan_pemonev');
		$this->db->where(['id_pemonev' => $id_pemonev, 'id_pengajuan_detail' => $di_pengajuan]);
		return $this->db->get()->row();
	}

	public function get_tanggal_update_pemonev($id_kerjaan_monev, $id_pengajuan)
	{
		$this->db->select('`id_kerjaan_monev`, `id_pemonev`, `id_pengajuan_detail`, `updated_at`');
		$this->db->from('tb_kerjaan_pemonev');
		$this->db->where('id_kerjaan_monev', $id_kerjaan_monev);
		$this->db->where('id_pengajuan_detail', $id_pengajuan);
		return $this->db->get()->result();
	}

	public function get_nama_pemonev($id_kerjaan)
	{
		$this->db->select('lp.id_kerjaan_monev, p.id_pemonev, p.nidn, dm.nama, kp.kerjaan_selesai');
		$this->db->from('laporan_pemonev as lp');
		$this->db->join('tb_kerjaan_pemonev as kp', 'lp.id_kerjaan_monev = kp.id_kerjaan_monev');
		$this->db->join('tb_pemonev as p', 'kp.id_pemonev = p.id_pemonev');
		$this->db->join('dummy_dosen as dm', 'p.nidn = dm.nidn');
		$this->db->where('lp.id_kerjaan_monev', $id_kerjaan);
		return $this->db->get()->row();
	}

	public function get_status_pemonev($id_pengajuan_detail)
	{
		$this->db->select('lp.id_kerjaan_monev, p.id_pemonev, p.nidn, dm.nama, kp.kerjaan_selesai');
		$this->db->from('laporan_pemonev as lp');
		$this->db->join('tb_kerjaan_pemonev as kp', 'lp.id_kerjaan_monev = kp.id_kerjaan_monev');
		$this->db->join('tb_pemonev as p', 'kp.id_pemonev = p.id_pemonev');
		$this->db->join('dummy_dosen as dm', 'p.nidn = dm.nidn');
		$this->db->where('kp.id_pengajuan_detail', $id_pengajuan_detail);
		return $this->db->get()->row();
	}

	public function get_masukan($id_kerjaan)
	{
		$this->db->select('masukan_pemonev');
		$this->db->from('masukan_pemonev');
		$this->db->where('id_kerjaan_monev', $id_kerjaan);
		return $this->db->get()->row();
	}

	public function get_id_proposal($id_kerjaan)
	{
		$this->db->select('id_pengajuan_detail');
		$this->db->from('tb_kerjaan_pemonev');
		$this->db->where('id_kerjaan_monev', $id_kerjaan);
		return $this->db->get()->row();
	}

	public function cek_kerjaan($id_kerjaan)
	{
		$this->db->select('kerjaan_selesai');
		$this->db->from('tb_kerjaan_pemonev');
		$this->db->where('id_kerjaan_monev', $id_kerjaan);
		return $this->db->get()->row();
	}

	public function dummy_cek_kerjaan_monev($id_kerjaan)
	{
		$this->db->select('kerjaan_selesai');
		$this->db->from('dummy_kerjaan_pemonev');
		$this->db->where('id_kerjaan', $id_kerjaan);
		return $this->db->get()->row();
	}

	public function get_pemonev_score($id)
	{
		$sql_score = $this->db->query("SELECT dosen.nama, dosen.nip, laporanmonev.total_nilai_wajib FROM dummy_dosen AS dosen JOIN tb_pemonev AS pemonev ON dosen.nip = pemonev.nidn JOIN tb_kerjaan_pemonev AS kerjamonev ON pemonev.id_pemonev = kerjamonev.id_pemonev JOIN laporan_pemonev AS laporanmonev ON laporanmonev.id_kerjaan_monev = kerjamonev.id_kerjaan_monev JOIN tb_pengajuan_detail AS pengajuandetail ON pengajuandetail.id_pengajuan_detail = kerjamonev.id_pengajuan_detail WHERE kerjamonev.id_pengajuan_detail = $id")->result();
		return $sql_score;
	}

	public function update_status_kerjaan($id_kerjaan_monev)
	{
		$this->db->where('id_kerjaan_monev', $id_kerjaan_monev);
		return $this->db->update('tb_kerjaan_pemonev', ['kerjaan_selesai' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
	}

	public function dummy_update_status_kerjaan($id_kerjaan_monev)
	{
		$this->db->where('id_kerjaan_monev', $id_kerjaan_monev);
		return $this->db->update('dummy_kerjaan_pemonev', ['kerjaan_selesai' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
	}

	public function update_masukan($data)
	{
		$this->db->where('id_kerjaan_monev', $data['id_kerjaan_monev']);
		return $this->db->update('masukan_pemonev', ['masukan_pemonev' => $data['masukan_pemonev']]);
	}

	public function update_laporan_monev($data)
	{
		$this->db->where('id_kerjaan_monev', $data['id_kerjaan_monev']);
		return $this->db->update(
			'laporan_pemonev',
			[
				'komponen_keterangan1' => $data['komponen_keterangan1'],
				'komponen_bobot1' => $data['komponen_bobot1'],
				'komponen_skor1' => $data['komponen_skor1'],
				'komponen_nilai1' => $data['komponen_nilai1'],
				'komponen_keterangan2' => $data['komponen_keterangan2'],
				'komponen_bobot2' => $data['komponen_bobot2'],
				'komponen_skor2' => $data['komponen_skor2'],
				'komponen_nilai2' => $data['komponen_nilai2'],
				'komponen_keterangan3' => $data['komponen_keterangan3'],
				'komponen_bobot3' => $data['komponen_bobot3'],
				'komponen_skor3' => $data['komponen_skor3'],
				'komponen_nilai3' => $data['komponen_nilai3'],
				'komponen_keterangan4' => $data['komponen_keterangan4'],
				'komponen_bobot4' => $data['komponen_bobot4'],
				'komponen_skor4' => $data['komponen_skor4'],
				'komponen_nilai4' => $data['komponen_nilai4'],
				'komponen_keterangan5' => $data['komponen_keterangan5'],
				'komponen_bobot5' => $data['komponen_bobot5'],
				'komponen_skor5' => $data['komponen_skor5'],
				'komponen_nilai5' => $data['komponen_nilai5'],
				'komponen_keterangan_tambahan1' => $data['komponen_keterangan_tambahan1'],
				'komponen_bobot_tambahan1' => $data['komponen_bobot_tambahan1'],
				'komponen_skor_tambahan1' => $data['komponen_skor_tambahan1'],
				'komponen_nilai_tambahan1' => $data['komponen_nilai_tambahan1'],
				'komponen_keterangan_tambahan2' => $data['komponen_keterangan_tambahan2'],
				'komponen_bobot_tambahan2' => $data['komponen_bobot_tambahan2'],
				'komponen_skor_tambahan2' => $data['komponen_skor_tambahan2'],
				'komponen_nilai_tambahan2' => $data['komponen_nilai_tambahan2'],
				'komponen_keterangan_tambahan3' => $data['komponen_keterangan_tambahan3'],
				'komponen_bobot_tambahan3' => $data['komponen_bobot_tambahan3'],
				'komponen_skor_tambahan3' => $data['komponen_skor_tambahan3'],
				'komponen_nilai_tambahan3' => $data['komponen_nilai_tambahan3'],
				'komponen_keterangan_tambahan4' => $data['komponen_keterangan_tambahan4'],
				'komponen_bobot_tambahan4' => $data['komponen_bobot_tambahan4'],
				'komponen_skor_tambahan4' => $data['komponen_skor_tambahan4'],
				'komponen_nilai_tambahan4' => $data['komponen_nilai_tambahan4'],
				'komponen_keterangan_tambahan5' => $data['komponen_keterangan_tambahan5'],
				'komponen_bobot_tambahan5' => $data['komponen_bobot_tambahan5'],
				'komponen_skor_tambahan5' => $data['komponen_skor_tambahan5'],
				'komponen_nilai_tambahan5' => $data['komponen_nilai_tambahan5'],
				'total_nilai_wajib' => $data['total_nilai_wajib'],
			]
		);
	}

	public function update_laporan_PKLN($data)
	{
		$this->db->where('id_kerjaan_monev', $data['id_kerjaan_monev']);
		return $this->db->update(
			'laporan_pemonev',
			[
				'komponen_keterangan1' => $data['komponen_keterangan1'],
				'komponen_bobot1' => $data['komponen_bobot1'],
				'komponen_skor1' => $data['komponen_skor1'],
				'komponen_nilai1' => $data['komponen_nilai1'],
				'komponen_keterangan2' => $data['komponen_keterangan2'],
				'komponen_bobot2' => $data['komponen_bobot2'],
				'komponen_skor2' => $data['komponen_skor2'],
				'komponen_nilai2' => $data['komponen_nilai2'],
				'komponen_keterangan3' => $data['komponen_keterangan3'],
				'komponen_bobot3' => $data['komponen_bobot3'],
				'komponen_skor3' => $data['komponen_skor3'],
				'komponen_nilai3' => $data['komponen_nilai3'],
				'komponen_keterangan_tambahan1' => $data['komponen_keterangan_tambahan1'],
				'komponen_bobot_tambahan1' => $data['komponen_bobot_tambahan1'],
				'komponen_skor_tambahan1' => $data['komponen_skor_tambahan1'],
				'komponen_nilai_tambahan1' => $data['komponen_nilai_tambahan1'],
				'komponen_keterangan_tambahan2' => $data['komponen_keterangan_tambahan2'],
				'komponen_bobot_tambahan2' => $data['komponen_bobot_tambahan2'],
				'komponen_skor_tambahan2' => $data['komponen_skor_tambahan2'],
				'komponen_nilai_tambahan2' => $data['komponen_nilai_tambahan2'],
				'komponen_keterangan_tambahan3' => $data['komponen_keterangan_tambahan3'],
				'komponen_bobot_tambahan3' => $data['komponen_bobot_tambahan3'],
				'komponen_skor_tambahan3' => $data['komponen_skor_tambahan3'],
				'komponen_nilai_tambahan3' => $data['komponen_nilai_tambahan3'],
				'komponen_keterangan_tambahan4' => $data['komponen_keterangan_tambahan4'],
				'komponen_bobot_tambahan4' => $data['komponen_bobot_tambahan4'],
				'komponen_skor_tambahan4' => $data['komponen_skor_tambahan4'],
				'komponen_nilai_tambahan4' => $data['komponen_nilai_tambahan4'],
				'komponen_keterangan_tambahan5' => $data['komponen_keterangan_tambahan5'],
				'komponen_bobot_tambahan5' => $data['komponen_bobot_tambahan5'],
				'komponen_skor_tambahan5' => $data['komponen_skor_tambahan5'],
				'komponen_nilai_tambahan5' => $data['komponen_nilai_tambahan5'],
				'komponen_keterangan_tambahan6' => $data['komponen_keterangan_tambahan6'],
				'komponen_bobot_tambahan6' => $data['komponen_bobot_tambahan6'],
				'komponen_skor_tambahan6' => $data['komponen_skor_tambahan6'],
				'komponen_nilai_tambahan6' => $data['komponen_nilai_tambahan6'],
				'komponen_keterangan_tambahan7' => $data['komponen_keterangan_tambahan7'],
				'komponen_bobot_tambahan7' => $data['komponen_bobot_tambahan7'],
				'komponen_skor_tambahan7' => $data['komponen_skor_tambahan7'],
				'komponen_nilai_tambahan7' => $data['komponen_nilai_tambahan7'],
				'komponen_keterangan_tambahan8' => $data['komponen_keterangan_tambahan8'],
				'komponen_bobot_tambahan8' => $data['komponen_bobot_tambahan8'],
				'komponen_skor_tambahan8' => $data['komponen_skor_tambahan8'],
				'komponen_nilai_tambahan8' => $data['komponen_nilai_tambahan8'],
				'total_nilai_wajib' => $data['total_nilai_wajib'],
			]
		);
	}

	public function update_laporan_PVUJ($data)
	{
		$this->db->where('id_kerjaan_monev', $data['id_kerjaan_monev']);
		return $this->db->update(
			'laporan_pemonev',
			[
				'komponen_keterangan1' => $data['komponen_keterangan1'],
				'komponen_bobot1' => $data['komponen_bobot1'],
				'komponen_skor1' => $data['komponen_skor1'],
				'komponen_nilai1' => $data['komponen_nilai1'],
				'komponen_keterangan2' => $data['komponen_keterangan2'],
				'komponen_bobot2' => $data['komponen_bobot2'],
				'komponen_skor2' => $data['komponen_skor2'],
				'komponen_nilai2' => $data['komponen_nilai2'],
				'komponen_keterangan3' => $data['komponen_keterangan3'],
				'komponen_bobot3' => $data['komponen_bobot3'],
				'komponen_skor3' => $data['komponen_skor3'],
				'komponen_nilai3' => $data['komponen_nilai3'],
				'komponen_keterangan4' => $data['komponen_keterangan4'],
				'komponen_bobot4' => $data['komponen_bobot4'],
				'komponen_skor4' => $data['komponen_skor4'],
				'komponen_nilai4' => $data['komponen_nilai4'],
				'komponen_keterangan_tambahan1' => $data['komponen_keterangan_tambahan1'],
				'komponen_bobot_tambahan1' => $data['komponen_bobot_tambahan1'],
				'komponen_skor_tambahan1' => $data['komponen_skor_tambahan1'],
				'komponen_nilai_tambahan1' => $data['komponen_nilai_tambahan1'],
				'komponen_keterangan_tambahan2' => $data['komponen_keterangan_tambahan2'],
				'komponen_bobot_tambahan2' => $data['komponen_bobot_tambahan2'],
				'komponen_skor_tambahan2' => $data['komponen_skor_tambahan2'],
				'komponen_nilai_tambahan2' => $data['komponen_nilai_tambahan2'],
				'komponen_keterangan_tambahan3' => $data['komponen_keterangan_tambahan3'],
				'komponen_bobot_tambahan3' => $data['komponen_bobot_tambahan3'],
				'komponen_skor_tambahan3' => $data['komponen_skor_tambahan3'],
				'komponen_nilai_tambahan3' => $data['komponen_nilai_tambahan3'],
				'komponen_keterangan_tambahan4' => $data['komponen_keterangan_tambahan4'],
				'komponen_bobot_tambahan4' => $data['komponen_bobot_tambahan4'],
				'komponen_skor_tambahan4' => $data['komponen_skor_tambahan4'],
				'komponen_nilai_tambahan4' => $data['komponen_nilai_tambahan4'],
				'komponen_keterangan_tambahan5' => $data['komponen_keterangan_tambahan5'],
				'komponen_bobot_tambahan5' => $data['komponen_bobot_tambahan5'],
				'komponen_skor_tambahan5' => $data['komponen_skor_tambahan5'],
				'komponen_nilai_tambahan5' => $data['komponen_nilai_tambahan5'],
				'komponen_keterangan_tambahan6' => $data['komponen_keterangan_tambahan6'],
				'komponen_bobot_tambahan6' => $data['komponen_bobot_tambahan6'],
				'komponen_skor_tambahan6' => $data['komponen_skor_tambahan6'],
				'komponen_nilai_tambahan6' => $data['komponen_nilai_tambahan6'],
				'komponen_keterangan_tambahan7' => $data['komponen_keterangan_tambahan7'],
				'komponen_bobot_tambahan7' => $data['komponen_bobot_tambahan7'],
				'komponen_skor_tambahan7' => $data['komponen_skor_tambahan7'],
				'komponen_nilai_tambahan7' => $data['komponen_nilai_tambahan7'],
				'komponen_keterangan_tambahan8' => $data['komponen_keterangan_tambahan8'],
				'komponen_bobot_tambahan8' => $data['komponen_bobot_tambahan8'],
				'komponen_skor_tambahan8' => $data['komponen_skor_tambahan8'],
				'komponen_nilai_tambahan8' => $data['komponen_nilai_tambahan8'],
				'total_nilai_wajib' => $data['total_nilai_wajib'],
			]
		);
	}

	public function update_laporan_KKS($data)
	{
		$this->db->where('id_kerjaan_monev', $data['id_kerjaan_monev']);
		return $this->db->update(
			'laporan_pemonev',
			[
				'komponen_keterangan1' => $data['komponen_keterangan1'],
				'komponen_bobot1' => $data['komponen_bobot1'],
				'komponen_skor1' => $data['komponen_skor1'],
				'komponen_nilai1' => $data['komponen_nilai1'],
				'komponen_keterangan2' => $data['komponen_keterangan2'],
				'komponen_bobot2' => $data['komponen_bobot2'],
				'komponen_skor2' => $data['komponen_skor2'],
				'komponen_nilai2' => $data['komponen_nilai2'],
				'komponen_keterangan3' => $data['komponen_keterangan3'],
				'komponen_bobot3' => $data['komponen_bobot3'],
				'komponen_skor3' => $data['komponen_skor3'],
				'komponen_nilai3' => $data['komponen_nilai3'],
				// 'komponen_keterangan4' => $data['komponen_keterangan4'],
				// 'komponen_bobot4' => $data['komponen_bobot4'],
				// 'komponen_skor4' => $data['komponen_skor4'],
				// 'komponen_nilai4' => $data['komponen_nilai4'],
				//
				// 'komponen_keterangan5' => $data['komponen_keterangan5'],
				// 'komponen_bobot5' => $data['komponen_bobot5'],
				// 'komponen_skor5' => $data['komponen_skor5'],
				// 'komponen_nilai5' => $data['komponen_nilai5'],
				//
				// 'komponen_keterangan6' => $data['komponen_keterangan6'],
				// 'komponen_bobot6' => $data['komponen_bobot6'],
				// 'komponen_skor6' => $data['komponen_skor6'],
				// 'komponen_nilai6' => $data['komponen_nilai6'],

				'komponen_keterangan_tambahan1' => $data['komponen_keterangan_tambahan1'],
				'komponen_bobot_tambahan1' => $data['komponen_bobot_tambahan1'],
				'komponen_skor_tambahan1' => $data['komponen_skor_tambahan1'],
				'komponen_nilai_tambahan1' => $data['komponen_nilai_tambahan1'],
				'komponen_keterangan_tambahan2' => $data['komponen_keterangan_tambahan2'],
				'komponen_bobot_tambahan2' => $data['komponen_bobot_tambahan2'],
				'komponen_skor_tambahan2' => $data['komponen_skor_tambahan2'],
				'komponen_nilai_tambahan2' => $data['komponen_nilai_tambahan2'],
				'komponen_keterangan_tambahan3' => $data['komponen_keterangan_tambahan3'],
				'komponen_bobot_tambahan3' => $data['komponen_bobot_tambahan3'],
				'komponen_skor_tambahan3' => $data['komponen_skor_tambahan3'],
				'komponen_nilai_tambahan3' => $data['komponen_nilai_tambahan3'],
				'komponen_keterangan_tambahan4' => $data['komponen_keterangan_tambahan4'],
				'komponen_bobot_tambahan4' => $data['komponen_bobot_tambahan4'],
				'komponen_skor_tambahan4' => $data['komponen_skor_tambahan4'],
				'komponen_nilai_tambahan4' => $data['komponen_nilai_tambahan4'],
				'komponen_keterangan_tambahan5' => $data['komponen_keterangan_tambahan5'],
				'komponen_bobot_tambahan5' => $data['komponen_bobot_tambahan5'],
				'komponen_skor_tambahan5' => $data['komponen_skor_tambahan5'],
				'komponen_nilai_tambahan5' => $data['komponen_nilai_tambahan5'],
				'komponen_keterangan_tambahan6' => $data['komponen_keterangan_tambahan6'],
				'komponen_bobot_tambahan6' => $data['komponen_bobot_tambahan6'],
				'komponen_skor_tambahan6' => $data['komponen_skor_tambahan6'],
				'komponen_nilai_tambahan6' => $data['komponen_nilai_tambahan6'],
				'komponen_keterangan_tambahan7' => $data['komponen_keterangan_tambahan7'],
				'komponen_bobot_tambahan7' => $data['komponen_bobot_tambahan7'],
				'komponen_skor_tambahan7' => $data['komponen_skor_tambahan7'],
				'komponen_nilai_tambahan7' => $data['komponen_nilai_tambahan7'],
				'komponen_keterangan_tambahan8' => $data['komponen_keterangan_tambahan8'],
				'komponen_bobot_tambahan8' => $data['komponen_bobot_tambahan8'],
				'komponen_skor_tambahan8' => $data['komponen_skor_tambahan8'],
				'komponen_nilai_tambahan8' => $data['komponen_nilai_tambahan8'],
				'total_nilai_wajib' => $data['total_nilai_wajib'],
			]
		);
	}

	public function update_laporan_PTM($data)
	{
		$this->db->where('id_kerjaan_monev', $data['id_kerjaan_monev']);
		return $this->db->update(
			'laporan_pemonev',
			[
				'komponen_keterangan1' => $data['komponen_keterangan1'],
				'komponen_bobot1' => $data['komponen_bobot1'],
				'komponen_skor1' => $data['komponen_skor1'],
				'komponen_nilai1' => $data['komponen_nilai1'],
				'komponen_keterangan2' => $data['komponen_keterangan2'],
				'komponen_bobot2' => $data['komponen_bobot2'],
				'komponen_skor2' => $data['komponen_skor2'],
				'komponen_nilai2' => $data['komponen_nilai2'],
				'komponen_keterangan3' => $data['komponen_keterangan3'],
				'komponen_bobot3' => $data['komponen_bobot3'],
				'komponen_skor3' => $data['komponen_skor3'],
				'komponen_nilai3' => $data['komponen_nilai3'],
				'komponen_keterangan4' => $data['komponen_keterangan4'],
				'komponen_bobot4' => $data['komponen_bobot4'],
				'komponen_skor4' => $data['komponen_skor4'],
				'komponen_nilai4' => $data['komponen_nilai4'],
				//
				// 'komponen_keterangan5' => $data['komponen_keterangan5'],
				// 'komponen_bobot5' => $data['komponen_bobot5'],
				// 'komponen_skor5' => $data['komponen_skor5'],
				// 'komponen_nilai5' => $data['komponen_nilai5'],
				//
				// 'komponen_keterangan6' => $data['komponen_keterangan6'],
				// 'komponen_bobot6' => $data['komponen_bobot6'],
				// 'komponen_skor6' => $data['komponen_skor6'],
				// 'komponen_nilai6' => $data['komponen_nilai6'],

				'komponen_keterangan_tambahan1' => $data['komponen_keterangan_tambahan1'],
				'komponen_bobot_tambahan1' => $data['komponen_bobot_tambahan1'],
				'komponen_skor_tambahan1' => $data['komponen_skor_tambahan1'],
				'komponen_nilai_tambahan1' => $data['komponen_nilai_tambahan1'],
				'komponen_keterangan_tambahan2' => $data['komponen_keterangan_tambahan2'],
				'komponen_bobot_tambahan2' => $data['komponen_bobot_tambahan2'],
				'komponen_skor_tambahan2' => $data['komponen_skor_tambahan2'],
				'komponen_nilai_tambahan2' => $data['komponen_nilai_tambahan2'],
				'komponen_keterangan_tambahan3' => $data['komponen_keterangan_tambahan3'],
				'komponen_bobot_tambahan3' => $data['komponen_bobot_tambahan3'],
				'komponen_skor_tambahan3' => $data['komponen_skor_tambahan3'],
				'komponen_nilai_tambahan3' => $data['komponen_nilai_tambahan3'],
				'komponen_keterangan_tambahan4' => $data['komponen_keterangan_tambahan4'],
				'komponen_bobot_tambahan4' => $data['komponen_bobot_tambahan4'],
				'komponen_skor_tambahan4' => $data['komponen_skor_tambahan4'],
				'komponen_nilai_tambahan4' => $data['komponen_nilai_tambahan4'],
				'komponen_keterangan_tambahan5' => $data['komponen_keterangan_tambahan5'],
				'komponen_bobot_tambahan5' => $data['komponen_bobot_tambahan5'],
				'komponen_skor_tambahan5' => $data['komponen_skor_tambahan5'],
				'komponen_nilai_tambahan5' => $data['komponen_nilai_tambahan5'],
				'komponen_keterangan_tambahan6' => $data['komponen_keterangan_tambahan6'],
				'komponen_bobot_tambahan6' => $data['komponen_bobot_tambahan6'],
				'komponen_skor_tambahan6' => $data['komponen_skor_tambahan6'],
				'komponen_nilai_tambahan6' => $data['komponen_nilai_tambahan6'],
				'komponen_keterangan_tambahan7' => $data['komponen_keterangan_tambahan7'],
				'komponen_bobot_tambahan7' => $data['komponen_bobot_tambahan7'],
				'komponen_skor_tambahan7' => $data['komponen_skor_tambahan7'],
				'komponen_nilai_tambahan7' => $data['komponen_nilai_tambahan7'],
				'komponen_keterangan_tambahan8' => $data['komponen_keterangan_tambahan8'],
				'komponen_bobot_tambahan8' => $data['komponen_bobot_tambahan8'],
				'komponen_skor_tambahan8' => $data['komponen_skor_tambahan8'],
				'komponen_nilai_tambahan8' => $data['komponen_nilai_tambahan8'],
				'total_nilai_wajib' => $data['total_nilai_wajib'],
			]
		);
	}

	public function update_laporan_PDP($data)
	{
		$this->db->where('id_kerjaan_monev', $data['id_kerjaan_monev']);
		return $this->db->update(
			'laporan_pemonev',
			[
				'komponen_keterangan1' => $data['komponen_keterangan1'],
				'komponen_bobot1' => $data['komponen_bobot1'],
				'komponen_skor1' => $data['komponen_skor1'],
				'komponen_nilai1' => $data['komponen_nilai1'],
				'komponen_keterangan2' => $data['komponen_keterangan2'],
				'komponen_bobot2' => $data['komponen_bobot2'],
				'komponen_skor2' => $data['komponen_skor2'],
				'komponen_nilai2' => $data['komponen_nilai2'],
				'komponen_keterangan3' => $data['komponen_keterangan3'],
				'komponen_bobot3' => $data['komponen_bobot3'],
				'komponen_skor3' => $data['komponen_skor3'],
				'komponen_nilai3' => $data['komponen_nilai3'],
				// 'komponen_keterangan4' => $data['komponen_keterangan4'],
				// 'komponen_bobot4' => $data['komponen_bobot4'],
				// 'komponen_skor4' => $data['komponen_skor4'],
				// 'komponen_nilai4' => $data['komponen_nilai4'],
				//
				// 'komponen_keterangan5' => $data['komponen_keterangan5'],
				// 'komponen_bobot5' => $data['komponen_bobot5'],
				// 'komponen_skor5' => $data['komponen_skor5'],
				// 'komponen_nilai5' => $data['komponen_nilai5'],
				//
				// 'komponen_keterangan6' => $data['komponen_keterangan6'],
				// 'komponen_bobot6' => $data['komponen_bobot6'],
				// 'komponen_skor6' => $data['komponen_skor6'],
				// 'komponen_nilai6' => $data['komponen_nilai6'],

				'komponen_keterangan_tambahan1' => $data['komponen_keterangan_tambahan1'],
				'komponen_bobot_tambahan1' => $data['komponen_bobot_tambahan1'],
				'komponen_skor_tambahan1' => $data['komponen_skor_tambahan1'],
				'komponen_nilai_tambahan1' => $data['komponen_nilai_tambahan1'],
				'komponen_keterangan_tambahan2' => $data['komponen_keterangan_tambahan2'],
				'komponen_bobot_tambahan2' => $data['komponen_bobot_tambahan2'],
				'komponen_skor_tambahan2' => $data['komponen_skor_tambahan2'],
				'komponen_nilai_tambahan2' => $data['komponen_nilai_tambahan2'],
				'komponen_keterangan_tambahan3' => $data['komponen_keterangan_tambahan3'],
				'komponen_bobot_tambahan3' => $data['komponen_bobot_tambahan3'],
				'komponen_skor_tambahan3' => $data['komponen_skor_tambahan3'],
				'komponen_nilai_tambahan3' => $data['komponen_nilai_tambahan3'],
				'komponen_keterangan_tambahan4' => $data['komponen_keterangan_tambahan4'],
				'komponen_bobot_tambahan4' => $data['komponen_bobot_tambahan4'],
				'komponen_skor_tambahan4' => $data['komponen_skor_tambahan4'],
				'komponen_nilai_tambahan4' => $data['komponen_nilai_tambahan4'],
				'komponen_keterangan_tambahan5' => $data['komponen_keterangan_tambahan5'],
				'komponen_bobot_tambahan5' => $data['komponen_bobot_tambahan5'],
				'komponen_skor_tambahan5' => $data['komponen_skor_tambahan5'],
				'komponen_nilai_tambahan5' => $data['komponen_nilai_tambahan5'],
				'komponen_keterangan_tambahan6' => $data['komponen_keterangan_tambahan6'],
				'komponen_bobot_tambahan6' => $data['komponen_bobot_tambahan6'],
				'komponen_skor_tambahan6' => $data['komponen_skor_tambahan6'],
				'komponen_nilai_tambahan6' => $data['komponen_nilai_tambahan6'],
				'komponen_keterangan_tambahan7' => $data['komponen_keterangan_tambahan7'],
				'komponen_bobot_tambahan7' => $data['komponen_bobot_tambahan7'],
				'komponen_skor_tambahan7' => $data['komponen_skor_tambahan7'],
				'komponen_nilai_tambahan7' => $data['komponen_nilai_tambahan7'],
				'komponen_keterangan_tambahan8' => $data['komponen_keterangan_tambahan8'],
				'komponen_bobot_tambahan8' => $data['komponen_bobot_tambahan8'],
				'komponen_skor_tambahan8' => $data['komponen_skor_tambahan8'],
				'komponen_nilai_tambahan8' => $data['komponen_nilai_tambahan8'],
				'total_nilai_wajib' => $data['total_nilai_wajib'],
			]
		);
	}

	public function update_laporan_PLP($data)
	{
		$this->db->where('id_kerjaan_monev', $data['id_kerjaan_monev']);
		return $this->db->update(
			'laporan_pemonev',
			[
				'komponen_keterangan1' => $data['komponen_keterangan1'],
				'komponen_bobot1' => $data['komponen_bobot1'],
				'komponen_skor1' => $data['komponen_skor1'],
				'komponen_nilai1' => $data['komponen_nilai1'],
				// 'komponen_keterangan4' => $data['komponen_keterangan4'],
				// 'komponen_bobot4' => $data['komponen_bobot4'],
				// 'komponen_skor4' => $data['komponen_skor4'],
				// 'komponen_nilai4' => $data['komponen_nilai4'],
				//
				// 'komponen_keterangan5' => $data['komponen_keterangan5'],
				// 'komponen_bobot5' => $data['komponen_bobot5'],
				// 'komponen_skor5' => $data['komponen_skor5'],
				// 'komponen_nilai5' => $data['komponen_nilai5'],
				//
				// 'komponen_keterangan6' => $data['komponen_keterangan6'],
				// 'komponen_bobot6' => $data['komponen_bobot6'],
				// 'komponen_skor6' => $data['komponen_skor6'],
				// 'komponen_nilai6' => $data['komponen_nilai6'],

				'komponen_keterangan_tambahan1' => $data['komponen_keterangan_tambahan1'],
				'komponen_bobot_tambahan1' => $data['komponen_bobot_tambahan1'],
				'komponen_skor_tambahan1' => $data['komponen_skor_tambahan1'],
				'komponen_nilai_tambahan1' => $data['komponen_nilai_tambahan1'],
				'komponen_keterangan_tambahan2' => $data['komponen_keterangan_tambahan2'],
				'komponen_bobot_tambahan2' => $data['komponen_bobot_tambahan2'],
				'komponen_skor_tambahan2' => $data['komponen_skor_tambahan2'],
				'komponen_nilai_tambahan2' => $data['komponen_nilai_tambahan2'],
				'komponen_keterangan_tambahan3' => $data['komponen_keterangan_tambahan3'],
				'komponen_bobot_tambahan3' => $data['komponen_bobot_tambahan3'],
				'komponen_skor_tambahan3' => $data['komponen_skor_tambahan3'],
				'komponen_nilai_tambahan3' => $data['komponen_nilai_tambahan3'],
				'komponen_keterangan_tambahan4' => $data['komponen_keterangan_tambahan4'],
				'komponen_bobot_tambahan4' => $data['komponen_bobot_tambahan4'],
				'komponen_skor_tambahan4' => $data['komponen_skor_tambahan4'],
				'komponen_nilai_tambahan4' => $data['komponen_nilai_tambahan4'],
				'komponen_keterangan_tambahan5' => $data['komponen_keterangan_tambahan5'],
				'komponen_bobot_tambahan5' => $data['komponen_bobot_tambahan5'],
				'komponen_skor_tambahan5' => $data['komponen_skor_tambahan5'],
				'komponen_nilai_tambahan5' => $data['komponen_nilai_tambahan5'],
				'komponen_keterangan_tambahan6' => $data['komponen_keterangan_tambahan6'],
				'komponen_bobot_tambahan6' => $data['komponen_bobot_tambahan6'],
				'komponen_skor_tambahan6' => $data['komponen_skor_tambahan6'],
				'komponen_nilai_tambahan6' => $data['komponen_nilai_tambahan6'],
				'komponen_keterangan_tambahan7' => $data['komponen_keterangan_tambahan7'],
				'komponen_bobot_tambahan7' => $data['komponen_bobot_tambahan7'],
				'komponen_skor_tambahan7' => $data['komponen_skor_tambahan7'],
				'komponen_nilai_tambahan7' => $data['komponen_nilai_tambahan7'],
				'komponen_keterangan_tambahan8' => $data['komponen_keterangan_tambahan8'],
				'komponen_bobot_tambahan8' => $data['komponen_bobot_tambahan8'],
				'komponen_skor_tambahan8' => $data['komponen_skor_tambahan8'],
				'komponen_nilai_tambahan8' => $data['komponen_nilai_tambahan8'],
				'total_nilai_wajib' => $data['total_nilai_wajib'],
			]
		);
	}

	public function update_laporan_PKK($data)
	{
		$this->db->where('id_kerjaan_monev', $data['id_kerjaan_monev']);
		return $this->db->update(
			'laporan_pemonev',
			[
				'komponen_keterangan1' => $data['komponen_keterangan1'],
				'komponen_bobot1' => $data['komponen_bobot1'],
				'komponen_skor1' => $data['komponen_skor1'],
				'komponen_nilai1' => $data['komponen_nilai1'],
				'komponen_keterangan2' => $data['komponen_keterangan2'],
				'komponen_bobot2' => $data['komponen_bobot2'],
				'komponen_skor2' => $data['komponen_skor2'],
				'komponen_nilai2' => $data['komponen_nilai2'],
				'komponen_keterangan3' => $data['komponen_keterangan3'],
				'komponen_bobot3' => $data['komponen_bobot3'],
				'komponen_skor3' => $data['komponen_skor3'],
				'komponen_nilai3' => $data['komponen_nilai3'],
				// 'komponen_keterangan4' => $data['komponen_keterangan4'],
				// 'komponen_bobot4' => $data['komponen_bobot4'],
				// 'komponen_skor4' => $data['komponen_skor4'],
				// 'komponen_nilai4' => $data['komponen_nilai4'],
				//
				// 'komponen_keterangan5' => $data['komponen_keterangan5'],
				// 'komponen_bobot5' => $data['komponen_bobot5'],
				// 'komponen_skor5' => $data['komponen_skor5'],
				// 'komponen_nilai5' => $data['komponen_nilai5'],
				//
				// 'komponen_keterangan6' => $data['komponen_keterangan6'],
				// 'komponen_bobot6' => $data['komponen_bobot6'],
				// 'komponen_skor6' => $data['komponen_skor6'],
				// 'komponen_nilai6' => $data['komponen_nilai6'],

				'komponen_keterangan_tambahan1' => $data['komponen_keterangan_tambahan1'],
				'komponen_bobot_tambahan1' => $data['komponen_bobot_tambahan1'],
				'komponen_skor_tambahan1' => $data['komponen_skor_tambahan1'],
				'komponen_nilai_tambahan1' => $data['komponen_nilai_tambahan1'],
				'komponen_keterangan_tambahan2' => $data['komponen_keterangan_tambahan2'],
				'komponen_bobot_tambahan2' => $data['komponen_bobot_tambahan2'],
				'komponen_skor_tambahan2' => $data['komponen_skor_tambahan2'],
				'komponen_nilai_tambahan2' => $data['komponen_nilai_tambahan2'],
				'komponen_keterangan_tambahan3' => $data['komponen_keterangan_tambahan3'],
				'komponen_bobot_tambahan3' => $data['komponen_bobot_tambahan3'],
				'komponen_skor_tambahan3' => $data['komponen_skor_tambahan3'],
				'komponen_nilai_tambahan3' => $data['komponen_nilai_tambahan3'],
				'komponen_keterangan_tambahan4' => $data['komponen_keterangan_tambahan4'],
				'komponen_bobot_tambahan4' => $data['komponen_bobot_tambahan4'],
				'komponen_skor_tambahan4' => $data['komponen_skor_tambahan4'],
				'komponen_nilai_tambahan4' => $data['komponen_nilai_tambahan4'],
				'komponen_keterangan_tambahan5' => $data['komponen_keterangan_tambahan5'],
				'komponen_bobot_tambahan5' => $data['komponen_bobot_tambahan5'],
				'komponen_skor_tambahan5' => $data['komponen_skor_tambahan5'],
				'komponen_nilai_tambahan5' => $data['komponen_nilai_tambahan5'],
				'komponen_keterangan_tambahan6' => $data['komponen_keterangan_tambahan6'],
				'komponen_bobot_tambahan6' => $data['komponen_bobot_tambahan6'],
				'komponen_skor_tambahan6' => $data['komponen_skor_tambahan6'],
				'komponen_nilai_tambahan6' => $data['komponen_nilai_tambahan6'],
				'komponen_keterangan_tambahan7' => $data['komponen_keterangan_tambahan7'],
				'komponen_bobot_tambahan7' => $data['komponen_bobot_tambahan7'],
				'komponen_skor_tambahan7' => $data['komponen_skor_tambahan7'],
				'komponen_nilai_tambahan7' => $data['komponen_nilai_tambahan7'],
				'komponen_keterangan_tambahan8' => $data['komponen_keterangan_tambahan8'],
				'komponen_bobot_tambahan8' => $data['komponen_bobot_tambahan8'],
				'komponen_skor_tambahan8' => $data['komponen_skor_tambahan8'],
				'komponen_nilai_tambahan8' => $data['komponen_nilai_tambahan8'],
				'total_nilai_wajib' => $data['total_nilai_wajib'],
			]
		);
	}

	public function hasil_kerjaan_pemonev($id_kerjaan_monev)
	{
		$this->db->select('*');
		$this->db->from('tb_progresspengabdian');
		$this->db->where('id_kerjaan_monev', $id_kerjaan_monev);
		return $this->db->get()->result();
	}

	public function get_Pemonevdsn($tahun)
	{
		$this->db->select('a.id_kerjaan_monev, a.id_pemonev, a.id_pengajuan_detail, COUNT(a.id_pengajuan_detail) AS total, c.nama, c.nidn');
		$this->db->from('tb_kerjaan_pemonev as a');
		$this->db->join('tb_pemonev as b', 'a.id_pemonev = b.id_pemonev');
		$this->db->join('dummy_dosen as c', 'b.nidn = c.nidn');
		//ini get tahun dari tahun usulan proposal yang akan di review
		$this->db->join('tb_identitas_pengajuan as d', 'd.id_pengajuan_detail = a.id_pengajuan_detail');
		$this->db->where("d.tahun_usulan", $tahun);
		$this->db->group_by('id_pemonev');
		$this->db->order_by('id_pemonev', 'ASC');

		return $this->db->get();
	}

	public function get_proposalMnv($id)
	{
		$this->db->select('a.id_kerjaan_monev, a.id_pemonev, d.id_pengajuan, f.nama AS rvw, c.nidn, b.judul, b.tema_penelitian AS tema, b.biaya, b.tahun_usulan, e.nama AS ketua');
		$this->db->from('tb_kerjaan_pemonev as a');
		$this->db->join('tb_identitas_pengajuan as b', 'a.id_pengajuan_detail = b.id_pengajuan_detail');
		$this->db->join('tb_pemonev as c', 'a.id_pemonev = c.id_pemonev');
		$this->db->join('dummy_dosen as f', 'c.nidn = f.nidn');
		$this->db->join('tb_pengajuan_detail as cc', 'cc.id_pengajuan_detail=a.id_pengajuan_detail');
		$this->db->join('tb_pengajuan as d', 'd.id_pengajuan = cc.id_pengajuan');
		$this->db->join('dummy_dosen as e', 'd.nidn_ketua = e.nidn');
		$this->db->where('a.id_pemonev', $id);

		return $this->db->get();
	}

	public function get_proposal_list($tahun, $type, $status)
	{

		if ($status === NULL) {
			$keputusan = " IS NULL OR a.status_keputusan = 3";
		} else {
			$keputusan = " = $status ";
		}
		$sql_pengajuan = $this->db->query("SELECT a.id_pengajuan_detail AS id,c.judul AS judul,e.nama AS nama_ketua, e.nip AS nip_ketua from tb_pengajuan_detail a INNER JOIN tb_pengajuan b ON  a.id_pengajuan = b.id_pengajuan INNER JOIN tb_identitas_pengajuan c ON a.id_pengajuan_detail = c.id_pengajuan_detail INNER JOIN tb_list_event d ON d.id_list_event = b.id_list_event INNER JOIN dummy_dosen e ON b.nidn_ketua = e.nidn WHERE c.tahun_usulan = '$tahun' AND d.id_jenis_event = $type AND ( a.status_keputusan $keputusan ) AND a.id_pengajuan_detail IN (SELECT DISTINCT id_pengajuan_detail FROM tb_kerjaan_pemonev WHERE kerjaan_selesai = 1)")->result();

		$i = 0;
		foreach ($sql_pengajuan as $pengajuan) {
			$sql_score = $this->db->query("SELECT dosen.nama, dosen.nip, laporanmonev.total_nilai_wajib FROM dummy_dosen AS dosen JOIN tb_pemonev AS pemonev ON dosen.nip = pemonev.nidn JOIN tb_kerjaan_pemonev AS kerjamonev ON pemonev.id_pemonev = kerjamonev.id_pemonev JOIN laporan_pemonev AS laporanmonev ON laporanmonev.id_kerjaan_monev = kerjamonev.id_kerjaan_monev JOIN tb_pengajuan_detail AS pengajuandetail ON pengajuandetail.id_pengajuan_detail = kerjamonev.id_pengajuan_detail WHERE kerjamonev.id_pengajuan_detail = $pengajuan->id")->row();
			$sql_pengajuan[$i]->total_nilai_wajib = $sql_score->total_nilai_wajib;
			$i++;
		}
		return $sql_pengajuan;
	}

	public function check_pemonev($nidn)
	{
		$this->db->select('id_event');
		$this->db->from('tb_pemonev');
		$this->db->where('nidn', $nidn);
		$this->db->where('status', 1);
	}

	public function get_all_akhir($tahun, $skema, $event, $status)
	{
		$this->db->select('a.id_det_pengajuan, a.id_pengajuan_detail, a.judul, a.tahun_usulan, b.id_pengajuan_detail, dd.id_list_event, dd.nidn_ketua, dd.status, c.nidn, c.nama, c.pangkat, c.nip, b.updated_at,b.created_at, klp.nama_kelompok');
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
		if ($status !== NULL) {
			$this->db->where("b.status_keputusan", $status);
		} else {
			$where .= "  AND (b.status_keputusan IS NULL OR b.status_keputusan = 3)";
		}
		$this->db->where($where);
		// $this->db->where('b.status_keputusan',4);
		return $this->db->get();
	}

	public function get_kelompok_pengajuan($id)
	{
		$this->db->select('kp.`id_kelompok_pengajuan`, kp.`nama_kelompok`, ip.`id_kelompok_pengajuan`, ip.`id_pengajuan_detail`');
		$this->db->from('`tb_kelompok_pengajuan` as kp');
		$this->db->join('`tb_identitas_pengajuan` as ip', 'kp.`id_kelompok_pengajuan` = ip.`id_kelompok_pengajuan`');
		$this->db->where('id_pengajuan_detail', $id);

		return $this->db->get()->row();
	}

	public function get_laporanPemonev($id)
	{
		$this->db->select('*');
		$this->db->from('laporan_pemonev');
		$this->db->where('id_kerjaan_monev', $id);

		return $this->db->get()->row();
	}

	public function relasiTargetLuaran($id)
	{
		$this->db->select("tb_target_luaran.id_pengajuan_detail, GROUP_CONCAT(tb_luaran.judul_luaran) as luaranWajib");
		$this->db->from("tb_target_luaran");
		$this->db->join("tb_luaran", "tb_luaran.id_luaran = tb_target_luaran.id_luaran");
		$this->db->where("id_pengajuan_detail", $id);
		return $this->db->get()->row();
	}

	function dataBerkas_evaluasi_penelitian($id)
	{
		$this->db->select('*');
		$this->db->from('tb_berkas_evaluasi_penelitian');
		$this->db->where('id_pengajuan_detail', $id);
		return $this->db->get()->row();
	}

	function dataBerkas_evaluasi_pengabdian($id)
	{
		$this->db->select('*');
		$this->db->from('tb_berkas_evaluasi_penelitian');
		$this->db->where('id_pengajuan_detail', $id);
		return $this->db->get()->row();
	}
    
    function dataDeskripsi_evaluasi_pengabdian($id)
	{
		$this->db->select('*');
		$this->db->from('tb_deskripsi_evaluasi_penelitian');
		$this->db->where('id_pengajuan_detail', $id);
		return $this->db->get()->row();
	}
}