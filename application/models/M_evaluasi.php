<?php

class M_evaluasi extends CI_Model
{
    public function get_proposalByEvaluasi_revisi($reviewer, $where, $id_jenis_event)
	{
		$this->db->select('*');
		$this->db->from('tb_kerjaan_evaluasi as a');
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
		$this->db->select('id_kerjaan_evaluasi, updated_at as dinilai, kerjaan_selesai as status');
		$this->db->from('tb_kerjaan_evaluasi');
		$this->db->where(['id_pemonev' => $id_pemonev, 'id_pengajuan_detail' => $di_pengajuan]);
		return $this->db->get()->row();
	}

    public function get_masukan($id_kerjaan)
	{
		$this->db->select('masukan_evaluasi');
		$this->db->from('masukan_evaluasi');
		$this->db->where('id_kerjaan_evaluasi', $id_kerjaan);
		return $this->db->get()->row();
	}

	public function get_tahun_proposal($id, $tahun, $skema, $fokus)
	{
		$this->db->select('a.id_det_pengajuan, a.id_pengajuan_detail, a.judul, a.tahun_usulan, b.id_pengajuan_detail, dd.id_list_event, dd.nidn_ketua, dd.status, c.nidn, c.nama, b.updated_at, b.created_at, b.status_keputusan, klp.nama_kelompok');
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
		$this->db->where('b.status_keputusan', 9);
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

	public function getReviewerByProposal_revisi($id)
	{
		$query = "SELECT
		nilai_satu.id_kerjaan_evaluasi,
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
			'Belum Dievaluasi'
		) AS nilai_fix
	FROM
		(
		SELECT
			kj.id_kerjaan_evaluasi,
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
		tb_kerjaan_evaluasi kj
	LEFT JOIN tb_penilaian pn ON
		kj.id_kerjaan_evaluasi = pn.id_kerjaan_monev
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
		kj.id_kerjaan_evaluasi,
		js.id_jenis_soal
	) AS nilai_satu
	INNER JOIN tb_pemonev ON nilai_satu.id_pemonev = tb_pemonev.id_pemonev
	INNER JOIN dummy_dosen dosen ON
		tb_pemonev.nidn = dosen.nidn
	WHERE
		nilai_satu.id_pengajuan_detail = " . $id . "
	GROUP BY
		nilai_satu.id_kerjaan_evaluasi;";

		return $this->db->query($query);
	}

	public function get_id_proposal($id_kerjaan)
	{
		$this->db->select('id_pengajuan_detail');
		$this->db->from('tb_kerjaan_evaluasi');
		$this->db->where('id_kerjaan_evaluasi', $id_kerjaan);
		return $this->db->get()->row();
	}

	public function get_laporanPemonev($id_proposal)
	{
		$this->db->select('*');
		$this->db->from('laporan_pemonev');
		$this->db->join('tb_kerjaan_pemonev', 'laporan_pemonev.id_kerjaan_monev = tb_kerjaan_pemonev.id_kerjaan_monev');
		$this->db->where('tb_kerjaan_pemonev.id_pengajuan_detail', $id_proposal);
		return $this->db->get()->row();
	}

	public function get_laporanEvaluasi($id_proposal)
	{
		$this->db->select('*');
		$this->db->from('laporan_evaluasi');
		$this->db->join('tb_kerjaan_evaluasi', 'laporan_evaluasi.id_kerjaan_evaluasi = tb_kerjaan_evaluasi.id_kerjaan_evaluasi');
		$this->db->where('tb_kerjaan_evaluasi.id_pengajuan_detail', $id_proposal);
		return $this->db->get()->row();
	}

	public function get_masukanEvaluasi($id)
	{
		$this->db->select('*');
		$this->db->from('masukan_evaluasi');
		$this->db->where('id_kerjaan_evaluasi', $id);
		return $this->db->get()->row();
	}
	public function update_status_kerjaan($id_kerjaan_evaluasi)
	{
		$this->db->where('id_kerjaan_evaluasi', $id_kerjaan_evaluasi);
		return $this->db->update('tb_kerjaan_evaluasi', ['kerjaan_selesai' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
	}

	public function get_kerjaan_laporan_evaluasi($id)
	{
		$this->db->select('a.*, b.masukan_evaluasi');
		$this->db->from('laporan_evaluasi as a');
		$this->db->join('masukan_evaluasi as b', 'a.id_kerjaan_evaluasi = b.id_kerjaan_evaluasi');
		$this->db->join('tb_kerjaan_evaluasi as c', 'c.id_kerjaan_evaluasi = a.id_kerjaan_evaluasi');
		$this->db->join('tb_pengajuan_detail as d', 'd.id_pengajuan_detail = c.id_pengajuan_detail');
		$this->db->where('a.id_kerjaan_evaluasi', $id);
		return $this->db->get()->row();
	}
}