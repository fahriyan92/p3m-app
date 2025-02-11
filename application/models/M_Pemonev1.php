<?php

class M_Pemonev1 extends CI_Model{

    function insert($table = '', $data = '')
	{
		$this->db->insert($table, $data);
	}

    function update($table = null, $data = null, $where = null)
	{
		$this->db->update($table, $data, $where);
	}

        function get_all($table)
	{
		$this->db->where("jenis_job", "dosen");
		$this->db->from($table);
		return $this->db->get();
	}

        function get_where($table = null, $where = null)
	{
		$this->db->from($table);
		$this->db->where($where);

		return $this->db->get();
	}
        
        public function getAllPemonev()
        {
                $this->db->select('dummypemonev.*, dummy_dosen.nama');
                $this->db->from('dummypemonev');
                $this->db->join('dummy_dosen', 'dummypemonev.nidn = dummy_dosen.nidn');
                $query = $this->db->get();
                return $query;

        }

        public function getDosenPemonev($tahun)
        {
                $this->db->select('a.id_kerjaan, a.id_pemonev, a.id_pengajuan_detail, COUNT(a.id_pengajuan_detail) AS total, c.nama, c.nidn');
                $this->db->from('tb_kerjaan_pemonev AS a');
                $this->db->join('dummypemonev AS b', 'a.id_pemonev = b.id_pemonev');
                $this->db->join('dummy_dosen AS c', 'b.nidn = c.nidn');
                $this->db->join('tb_identitas_pengajuan_monev AS d', 'd.id_pengajuan_monev_detail = a.id_pengajuan_detail');
                $this->db->where('d.tahun_usulan', $tahun);
                $this->db->group_by('id_pemonev');
                $this->db->order_by('id_pemonev', 'ASC');
                $query = $this->db->get();
                return $query;
        }

        public function getProposalPemonev($id)
        {
                $this->db->select('a.id_kerjaan, a.id_pemonev, d.id_pengajuan_monev, f.nama AS rvw, c.nidn, b.judul, b.tema_penelitian AS tema, b.biaya, b.tahun_usulan, e.nama AS ketua');
                $this->db->from(' tb_kerjaan_pemonev AS a');
                $this->db->join('tb_identitas_pengajuan AS b', 'a.id_pengajuan_detail = b.id_pengajuan_detail');
                $this->db->join('dummypemonev AS c', 'a.id_pemonev = c.id_pemonev');
                $this->db->join('dummy_dosen AS f', 'c.nidn = f.nidn');
                $this->db->join('tb_pengajuan_monev_detail AS cc', 'cc.id_pengajuan_monev_detail = a.id_pengajuan_detail');
                $this->db->join('tb_pengajuan_monev AS d', 'd.id_pengajuan_monev = cc.id_pengajuan_monev');
                $this->db->join('dummy_dosen AS e', 'd.nidn_ketua = e.nidn');
                $this->db->where('a.id_pemonev', $id);
                $query = $this->db->get();
                return $query;
        }

        public function getListPropsoal($id)
        {
                $this->db->select('g.id_event, a.id_pengajuan_monev_detail pengajuan_monev_detail, e.id_pengajuan_monev, c.id_kelompok_pengajuan, c.tema_penelitian tema, c.sasaran, c.biaya, a.id_fokus, e.nidn_ketua nidn_ketua, a.is_nambah_luaran, b.nama nama_ketua, c.judul judul, c.tanggal_mulai_kgt mulai, c.tanggal_akhir_kgt akhir, c.biaya biaya_usulan, c.tahun_usulan tahun_usulan, d.ringkasan_pengajuan ringkasan, d.metode metode, d.tinjauan_pustaka tinjauan, d.file_proposal proposal, d.file_rab rab, a.status_keputusan, e.id_list_event, c.identitas_tkt, g.id_jenis_event');
                $this->db->from('tb_pengajuan_monev_detail a');
                $this->db->join('tb_pengajuan_monev e', 'e.id_pengajuan_monev = a.id_pengajuan_monev');
                $this->db->join('dummy_dosen b', 'e.nidn_ketua = b.nidn');
                $this->db->join('tb_identitas_pengajuan_monev c', 'a.id_pengajuan_monev_detail = c.id_pengajuan_monev_detail');
                $this->db->join('tb_dokumen_pengajuan_monev d', 'a.id_pengajuan_monev_detail = d.id_pengajuan_detail');
                $this->db->join('tb_list_event f', 'f.id_list_event = e.id_list_event');
                $this->db->join('tb_jenis_event g', 'g.id_jenis_event = f.id_jenis_event');
                $this->db->where('a.id_pengajuan_monev_detail', $id);
                return $this->db->get()->row();
        }

        public function get_id_proposal($id_kerjaan)
	{
		$this->db->select('id_pengajuan_detail');
		$this->db->from('tb_kerjaan_pemonev');
		$this->db->where('id_kerjaan', $id_kerjaan);
		return $this->db->get()->row();
	}

    public function admin_status_kerjaan_pemonev($id_kerjaan)
	{
		$this->db->select('id_kerjaan,updated_at dinilai, kerjaan_selesai status');
		$this->db->from('tb_kerjaan_pemonev');
		$this->db->where(['id_kerjaan' => $id_kerjaan]);
		return $this->db->get()->row();
	}

    public function get_nilai($id_kerjaan)
	{
		$this->db->select('id_penilaian,id_pilihan');
		$this->db->from('tb_penilaian');
		$this->db->where('id_kerjaan', $id_kerjaan);
		return $this->db->get()->result();
	}

    public function get_rekomendasi($id_kerjaan)
	{
		$this->db->select('masukan_pemonev');
		$this->db->from('rekomendasi_pemonev');
		$this->db->where('id_kerjaan', $id_kerjaan);
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

        public function getProposalID($id)
        {
                $this->db->select('*');
		$this->db->from('tb_identitas_pengajuan_monev AS a');
		$this->db->join('tb_pengajuan_monev_detail AS b', 'b.id_pengajuan_monev = a.id_pengajuan_monev_detail');
		$this->db->join('tb_pengajuan_monev AS bb', 'b.id_pengajuan_monev = bb.id_pengajuan_monev');
		$this->db->join('dummy_dosen as c', 'c.nidn = bb.nidn_ketua');
		$this->db->join('tb_dokumen_pengajuan_monev AS d', 'd.id_pengajuan_detail = b.id_pengajuan_monev');
		$this->db->join('tb_list_event as e', 'bb.id_list_event = e.id_list_event');
		$this->db->where('b.id_pengajuan_monev', $id);
		return $this->db->get();
        }

        public function getListEvent()
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

    public function checkNIDSN($id)
	{
		$this->db->select('*');
		$this->db->from('dummypemonev as a');
		$this->db->where('nidn', $id);
		return $this->db->get();
	}

    public function hapusPemonev($id)
	{

		$this->db->select('id_pemonev, id_pengajuan_detail');
		$this->db->from('tb_kerjaan_pemonev');
		$this->db->where('id_kerjaan', $id);
		$rev = $this->db->get()->row();

		$this->db->delete('tb_pemonev', array('id_pemonev' => $rev->id_pemonev));
		$this->db->delete('tb_kerjaan_pemonev', array('id_kerjaan' => $id));

		return $rev->id_pengajuan;
	}

        public function get_MasterPemonev($id_event)
	{
		$this->db->select('*');
		$this->db->from('dummypemonev AS a');
		$this->db->join('dummy_dosen AS c', 'a.nidn = c.nidn');
		$this->db->like('a.id_event', $id_event);

		return $this->db->get();
	}

        public function get_pemonev_proposal($id)
	{

		$this->db->select('a.id_pemonev, a.id_pengajuan_detail, b.id_pemonev, b.nidn, b.status');
		$this->db->from('tb_kerjaan_pemonev AS a');
		$this->db->join('dummypemonev AS b', 'a.id_pemonev = b.id_pemonev');
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
		// $this->db->select('a.id_anggota, a.status_notifikasi, b.id_sinta, a.id_pengajuan_detail, a.status_permintaan, b.nidn, b.status, b.id_anggota_dsn, c.nama,c.file_cv cv');
		// $this->db->from('tb_permintaan_anggota as a');
		// $this->db->join('tb_anggota_dosen as b', 'b.id_anggota_dsn=a.id_anggota');
		// $this->db->join('dummy_dosen as c', 'c.nip=b.nidn');
		// $this->db->where('b.status', 1);
		// $this->db->where('a.id_pengajuan_detail', $id);
		// $ret = $this->db->get();

		$this->db->select('a.id_anggota, a.status_notifikasi, b.id_sinta, a.id_pengajuan_monev_detail, a.status_permintaan, b.nidn, b.status, b.id_anggota_dsn, c.nama,c.file_cv cv');
		$this->db->from('tb_permintaan_anggota as a');
		$this->db->join('tb_anggota_dosen as b', 'b.id_anggota_dsn=a.id_anggota');
		$this->db->join('dummy_dosen as c', 'c.nip=b.nidn');
		$this->db->where('b.status', 1);
		$this->db->where('a.id_pengajuan_monev_detail', $id);
		$ret = $this->db->get();
		return $ret;
	}

    public function anggota_mhs_Byproposal($id)
	{

		$this->db->select('a.nim, a.nama, a.prodi, a.id_pengajuan_monev_detail, a.status, a.id_anggota_mhs');
		$this->db->from('tb_anggota_mhs as a');
		$this->db->where('a.id_pengajuan_monev_detail', $id);
		$ret = $this->db->get();

		return $ret;
	}

        public function get_tahun_proposal($id, $tahun, $skema, $fokus)
	{
		$this->db->select('a.id_det_pengajuan_monev, a.id_pengajuan_monev_detail, a.judul, a.tahun_usulan, b.id_pengajuan_monev_detail, dd.id_list_event, dd.nidn_ketua, dd.status, c.nidn, c.nama, b.updated_at, b.created_at, klp.nama_kelompok');
		$this->db->from('tb_identitas_pengajuan_monev AS a');
		$this->db->join('tb_pengajuan_monev_detail AS b', 'b.id_pengajuan_monev_detail = a.id_pengajuan_monev_detail');
		$this->db->join('tb_pengajuan_monev AS dd', 'dd.id_pengajuan_monev = b.id_pengajuan_monev');
		$this->db->join('dummy_dosen AS c', 'c.nidn = dd.nidn_ketua');
		$this->db->join('tb_dokumen_pengajuan_monev AS cc', 'cc.id_pengajuan_detail = b.id_pengajuan_monev_detail');

		$this->db->join('tb_list_event AS bb', 'bb.id_list_event = dd.id_list_event');
		$this->db->join('tb_jenis_event AS aa', 'aa.id_jenis_event = bb.id_jenis_event');
		$this->db->join('tb_kelompok_pengajuan klp', 'a.id_kelompok_pengajuan = klp.id_kelompok_pengajuan');

		$this->db->where('bb.id_jenis_event', $id);
		$this->db->where('a.tahun_usulan', $tahun);
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

    public function get_totalscore($id = '', $jenis = '', $event = '')
	{
		$this->db->select('bobot');
		$this->db->from('tb_jenis_soal');
		$this->db->where('id_jenis_soal', $jenis);
		$rev = $this->db->get()->row();

		if ($id != '' && $jenis != '') {
			# code...
			if ($event == 2 || $event == 3) {
				if ($jenis == 4 || $jenis == 5) {
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
        
        public function getPemonevByProposal_revisi($id)
	{
		$query = "SELECT
                nilai_satu.id_kerjaan,
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
                    'Belum Review'
                ) AS nilai_fix
            FROM
                (
                SELECT
                    kj.id_kerjaan,
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
                kj.id_kerjaan = pn.id_kerjaan
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
                kj.id_kerjaan,
                js.id_jenis_soal
            ) AS nilai_satu
            INNER JOIN dummypemonev ON nilai_satu.id_pemonev = dummypemonev.id_pemonev
            INNER JOIN dummy_dosen dosen ON
                dummypemonev.nidn = dosen.nidn
            WHERE
                nilai_satu.id_pengajuan_detail = " . $id . "
            GROUP BY
                nilai_satu.id_kerjaan;";

		return $this->db->query($query);
	}
}