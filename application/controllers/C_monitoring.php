<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_monitoring extends CI_Controller
{
	private $session_id;
	private $post;
	private $tanggal_now;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_rekap', 'rekap');
		$this->load->model('M_reviewer', 'reviewer');
		$this->load->model('M_Pemonev', 'pemonev');
		$this->load->model('M_fokus', 'Mfokus');
		$this->load->model('M_luaranwajib', 'test');
	}
	private function insert_log($data)
	{
		$insert_data = [
			'id_staff' => $this->session->userdata('id'),
			'nama_staff' => $this->session->userdata('nama'),
			'role_staff' => $this->session->userdata('level'),
			'event_staff' => $data[0],
			'ket_aktivitas' => $data[1],
			'created_at' => date('Y-m-d H:i:s'),
		];
		// print_r($insert_data);
		$this->db->insert('tb_log', $insert_data);
	}

	private function response($res)
	{

		$pesan = ['code' => $res[0], 'pesan' => $res[1]];

		return $pesan;
	}

	public function test($event)
	{
		$sql_soal = "select id_soal, soal, tb_soal.id_jenis_soal from tb_soal inner join tb_jenis_soal a on a.id_jenis_soal = tb_soal.id_jenis_soal where tb_soal.status=" . 1 . " and a.id_event=" . $event;
		$exec_soal = $this->db->query($sql_soal)->result();
		$sql_jenis = "select id_jenis_soal, nm_jenis_soal from tb_jenis_soal where status=" . 1 . " and id_event=" . $event;
		$exec_jenis = $this->db->query($sql_jenis)->result();
		$kumpulan_soal = [];

		if (count($exec_soal) <= 0 || count($exec_jenis) <= 0) {
			return null;
		}

		for ($i = 0; $i <= count($exec_jenis) - 1; $i++) {
			$kumpulan_soal[$i]['jenis_soal'] = $exec_jenis[$i]->nm_jenis_soal;
			$h = 0;
			for ($j = 0; $j <= count($exec_soal) - 1; $j++) {
				if ($exec_soal[$j]->id_jenis_soal === $exec_jenis[$i]->id_jenis_soal) {
					$kumpulan_soal[$i]['soal_pilihan'][$h]['nomer'] = intval($h + 1);
					$kumpulan_soal[$i]['soal_pilihan'][$h]['soal'] = $exec_soal[$j]->soal;
					$sql_pilihan = "select id_pilihan, deskripsi_pilihan,score from tb_pilihan where id_soal =" . $exec_soal[$j]->id_soal;
					$exec_pilihan = $this->db->query($sql_pilihan)->result();
					$kumpulan_soal[$i]['soal_pilihan'][$h]['pilihan'] = $exec_pilihan;
					$h++;
				}
			}
		}

		return $kumpulan_soal;
	}

	// REKAP PENELITIAN PNBP DOSEN

	public function Rekap_PNBP()
	{
		$data['content'] = VIEW_ADMIN . 'content_rekap_pnbp_monitoring';
		$data['judul'] = 'Rekap Penelitian PNBP';
		$data['brdcrmb'] = 'Beranda / Monitoring / Rekap Proposal PNBP';
		$this->load->view('index', $data);
	}

	// REKAP PENELITIAN  PLP / TEKNISI
	public function Rekap_plp()
	{
		$data['content'] = VIEW_ADMIN . 'content_rekap_plp_monitoring';
		$data['judul'] = 'Rekap Penelitian PLP';
		$data['brdcrmb'] = 'Beranda / Rekap Proposal PLP';
		$this->load->view('index', $data);
	}
	public function list_proposal_pnbp()
	{
		$tahun = $this->input->post('tahun');
		$jenis = $this->input->post('jenis');
		$status = $this->input->post('status');
		if ($tahun === '' || $jenis === '' || $status === '') {
			echo json_encode(['status' => 'error', 'data' => []]);
			return;
		}
		if ($jenis == "3") {
			$jenis = 5;
		}
		$pengajuan = $this->rekap->get_proposal($tahun, $jenis, $status == 0 ? NULL : $status);
		echo json_encode(['status' => 'ok', 'data' => $pengajuan]);
		return;
	}
	public function list_reviewer_score()
	{
		$id_pengajuan_detail = $this->input->post('id');
		$data = $this->rekap->get_reviewer_score($id_pengajuan_detail);
		echo json_encode($data);
		return;
	}
	public function get_reviewer_score($id_pengajuan_detail)
	{
		//$id_pengajuan_detail = 6;
		$data = $this->rekap->get_reviewer_score($id_pengajuan_detail);
		echo json_encode($data);
		return;
	}
	// REKAP PENGABDIAN DOSEN

	public function Rekap_Pengabdian()
	{
		$data['content'] = VIEW_ADMIN . 'content_rekap_pengabdian_monitoring';
		$data['judul'] = 'Monitoring Rekap Proposal PNBP';
		$data['brdcrmb'] = 'Beranda / Monitoring / Rekap Proposal PNBP';
		//$data['list_event'] = $this->reviewer->get_list_event();

		$this->load->view('index', $data);
	}
	public function edit_status()
	{
		$id_pengajuan_detail = $this->input->post('id');
		$status = $this->input->post('status');
		$judul = $this->input->post('judul');
		$this->db->where('id_pengajuan_detail', $id_pengajuan_detail);
		$update = $this->db->update('tb_pengajuan_detail', ['status_keputusan' => $status == 0 ? NULL : $status]);
		if ($update) {
			echo json_encode(['status' => 'ok']);
			if ($status == 1) {
				$this->insert_log(['UPDATE', " MENERIMA PROPOSAL '" . $judul . "'"]);
			}
			if ($status == 2) {
				$this->insert_log(['UPDATE', " MENOLAK PROPOSAL '" . $judul . "'"]);
			}
			if ($status == 0) {
				$this->insert_log(['UPDATE', " MENGEMBALIKAN PROPOSAL '" . $judul . "'"]);
			}
		} else {
			echo json_encode(['status' => 'error']);
		}
	}
	public function get_reviewer_prop($id)
	{

		$ret_reviewer = $this->reviewer->get_reviewer_proposal($id);
		$ret_anggota = $this->reviewer->get_anggota_proposal($id);

		$arr = [];
		foreach ($ret_reviewer->result_array() as $key) {
			array_push($arr, $key['nidn']);
		}
		foreach ($ret_anggota->result_array() as $key) {
			array_push($arr, $key['nidn']);
		}
		return $arr;
	}

	public function viewDetail($id = '')
	{
		$detail = $this->reviewer->get_proposalnya($id);
		if ($detail === null || $id === '') {
			redirect('C_reviewer');
		}
		// content
		$username = $this->session->userdata('username');
		$data['content'] = VIEW_ADMIN . 'content_tambah_reviewer';
		$data['username'] = $username;
		$data['judul'] = 'Detail Proposal';
		$data['brdcrmb'] = 'Beranda / Rekap Proposal PNBP / Detail Proposal';
		$data['review'] = $this->reviewer->get_proposal_byId($id);
		$data['list_event'] = $this->reviewer->get_list_event();
		$data['reviewer'] = $this->reviewer->getReviewerByProposal($id);
		$get_dosen = "select nidn,nama from dummy_dosen where jenis_job = 'dosen'";
		$query = $this->db->query($get_dosen);
		$data['dosen'] = $query;
		$data['reviewer_diproposal'] = $this->get_reviewer_prop($id);
		$data['dt_proposal'] = $detail;
		$data['luaran'] = $this->reviewer->get_luaran();
		$data['kelompok'] = $this->Mfokus->get_all('tb_kelompok_pengajuan')->result();

		$data['dtl_proposal'] = $this->reviewer->get_proposalnya($id);
		$data['luaran_checked'] = null;
		$data['luaran_tambahan'] = null;
		$data['rekap'] = true;

		if (isset($data['dtl_proposal']->id_pengajuan)) {
			$arr = [];
			foreach ($this->reviewer->get_luaran_checked($data['dtl_proposal']->id_pengajuan) as $value) {
				array_push($arr, $value->id_luaran);
			}

			if ($data['dtl_proposal']->is_nambah_luaran === "1") {
				$data['luaran_tambahan'] = $this->reviewer->luaran_tambahan($data['dtl_proposal']->id_pengajuan);
			}

			$data['luaran_checked'] = $arr;
		} else {
			echo 'Telah Terjadi Kesalahan';
			return;
		}

		$this->load->view('index', $data);
	}

	public function detail($id)
	{
		// content
		$get_id_pemonev = $this->pemonev->get_where("tb_pemonev", ["nidn" => $this->session->userdata('nidn')])->row();
		if ($get_id_pemonev == null) {
			return false;
		}
		$username = $this->session->userdata('username');
		$data['content'] = VIEW_REVIEWER . 'content_detail_monev';
		$data['username'] = $username;
		$data['judul'] = 'Detail Proposal';
		$data['brdcrmb'] = 'Beranda / Detail Proposal';

		$detail = $this->reviewer->get_proposalnya($id);
		if ($detail->id_event == 1) {
			$data['luaran'] = $this->Mfokus->kel_luaran_penelitian_dosen("tb_luaran")->result();
			$data['kelompok'] = $this->Mfokus->kel_luaran_penelitian_dosen("tb_kelompok_pengajuan")->result();
		} elseif ($detail->id_event == 2) {
			$data['luaran'] = $this->Mfokus->kel_luaran_pengabdian_dosen("tb_luaran")->result();
			$data['kelompok'] = $this->Mfokus->kel_luaran_pengabdian_dosen("tb_kelompok_pengajuan")->result();
		} else {
			$data['luaran'] = $this->Mfokus->kel_luaran_penelitian_plp("tb_luaran")->result();
			$data['kelompok'] = $this->Mfokus->kel_luaran_penelitian_plp("tb_kelompok_pengajuan")->result();
		}

		$data['dt_proposal'] = $this->reviewer->get_proposalnya($id);
		$data['luaran_checked'] = null;
		$data['luaran_tambahan'] = null;
		if (isset($data['dt_proposal']->id_pengajuan_detail)) {
			$data['status'] = $this->pemonev->status_kerjaan_revisi($get_id_pemonev->id_pemonev, $data['dt_proposal']->id_pengajuan_detail);
			// var_dump($data['status']);
			// return;
			if ($data['status'] === null) {
				echo 'Halaman Kerjaan Tidak Bisa Di Ditemukan';
				return;
			}
			$arr = [];
			foreach ($this->reviewer->get_luaran_checked($data['dt_proposal']->id_pengajuan_detail) as $value) {
				array_push($arr, $value->id_luaran);
			}

			if ($data['dt_proposal']->is_nambah_luaran === "1") {
				$data['luaran_tambahan'] = $this->reviewer->luaran_tambahan($data['dt_proposal']->id_pengajuan_detail);
			}

			$data['luaran_checked'] = $arr;
		} else {
			echo 'Halaman Tidak Bisa Di Akses';
			return;
		}
		// var_dump($data['dt_proposal']);
		$this->load->view('index', $data);
	}

	public function monev_proposal($id, $event)
	{
		$username = $this->session->userdata('username');
		$data['username'] = $username;
		$data['judul'] = 'Pemonev';
		$data['brdcrmb'] = 'Beranda / Pemonev / Monev Proposal';
		$data['idproposal'] = $id;
		$id_proposal = $this->pemonev->get_id_proposal($id);
		$kelompok_pengajuan = $this->pemonev->get_kelompok_pengajuan($id_proposal->id_pengajuan_detail);
		if ($id_proposal === null) {
			echo 'ada yang salah nih.';
			return;
		}

		$get_id_pemonev = $this->pemonev->get_where("tb_pemonev", ["nidn" => $this->session->userdata('nidn')])->row();
		if ($get_id_pemonev == null) {
			return false;
		}
		$data['dt_proposal'] = $this->reviewer->get_proposalnya($id_proposal->id_pengajuan_detail);
		$data['laporan_monev'] = $this->pemonev->get_laporanPemonev($id);

		$detail = $this->reviewer->get_proposalnya($id_proposal->id_pengajuan_detail);

		if ($data['dt_proposal'] !== null) {
				$data['status'] = $this->pemonev->status_kerjaan_revisi($get_id_pemonev->id_pemonev, $data['dt_proposal']->id_pengajuan_detail);
				if ($data['status']->status == 1) {
						$masukan = $this->pemonev->get_masukan($data['status']->id_kerjaan_monev);

						$data['masukan'] =  $masukan->masukan_pemonev;
				}
			}

		if ($detail->id_event == 1) {
			$data['luaran'] = $this->Mfokus->kel_luaran_penelitian_dosen("tb_luaran")->result();
			$data['kelompok'] = $this->Mfokus->kel_luaran_penelitian_dosen("tb_kelompok_pengajuan")->result();
		} elseif ($detail->id_event == 2) {
			$data['luaran'] = $this->Mfokus->kel_luaran_pengabdian_dosen("tb_luaran")->result();
			$data['kelompok'] = $this->Mfokus->kel_luaran_pengabdian_dosen("tb_kelompok_pengajuan")->result();
		} else {
			$data['luaran'] = $this->Mfokus->kel_luaran_penelitian_plp("tb_luaran")->result();
			$data['kelompok'] = $this->Mfokus->kel_luaran_penelitian_plp("tb_kelompok_pengajuan")->result();
		}

		$data['luaran_checked'] = null;
		$data['luaran_tambahan'] = null;

		if (isset($data['dt_proposal'])) {
			$data['status'] = $this->pemonev->status_kerjaan_revisi($get_id_pemonev->id_pemonev, $data['dt_proposal']->id_pengajuan_detail);
			// var_dump($data['status']);
			// return;
			$arr = [];
			foreach ($this->reviewer->get_luaran_checked($data['dt_proposal']->id_pengajuan_detail) as $value) {
				array_push($arr, $value->id_luaran);
			}

			if ($data['dt_proposal']->is_nambah_luaran === "1") {
				$data['luaran_tambahan'] = $this->reviewer->luaran_tambahan($data['dt_proposal']->id_pengajuan_detail);
			}

			$data['luaran_checked'] = $arr;
		} else {
			echo 'Halaman Tidak Bisa Di Akses';
			return;
		}

		if ($kelompok_pengajuan->id_kelompok_pengajuan == "14") {
			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
			$data['content'] = VIEW_REVIEWER . 'content_penelitianPKLN';
			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
		} elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "12") {
			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
			$data['content'] = VIEW_REVIEWER . 'content_penelitianPVUJ';
			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
		} elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "10") {
			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
			$data['content'] = VIEW_REVIEWER . 'content_penelitianPTM';
			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
		} elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "11") {
			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
			$data['content'] = VIEW_REVIEWER . 'content_penelitianKKS';
			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
		} elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "2") {
			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
			$data['content'] = VIEW_REVIEWER . 'content_penelitianPDP';
			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
		} elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "13") {
			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
			$data['content'] = VIEW_REVIEWER . 'content_penelitianPKK';
			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
		} elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "9") {
			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
			$data['content'] = VIEW_REVIEWER . 'content_penelitianPLP';
			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
		} else {
			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
			$data['content'] = VIEW_REVIEWER . 'content_penelitianPemonev';
			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
		}

		// var_dump($data['laporan_monev']);
		$this->load->view('index', $data);
	}

	public function simpan_monev()
	{
			// $rekomendasi = $_POST['rekomendasi'];
			$masukan = $_POST['masukan'];

			$nama_ketua = $_POST['nama_ketua'];
			$jenis_proposal = $_POST['jenis_proposal'];

			$keterangan1 = $_POST['keterangan1'];
			$bobot1 = $_POST['ket1_bobot'];
			$skor1 = $_POST['ket1_skor'];
			$nilai1 = $_POST['ket1_nilai'];

			$keterangan2 = $_POST['keterangan2'];
			$bobot2 = $_POST['ket2_bobot'];
			$skor2 = $_POST['ket2_skor'];
			$nilai2 = $_POST['ket2_nilai'];

			$keterangan3 = $_POST['keterangan3'];
			$bobot3 = $_POST['ket3_bobot'];
			$skor3 = $_POST['ket3_skor'];
			$nilai3 = $_POST['ket3_nilai'];

			$keterangan4 = $_POST['keterangan4'];
			$bobot4 = $_POST['ket4_bobot'];
			$skor4 = $_POST['ket4_skor'];
			$nilai4 = $_POST['ket4_nilai'];

			$keterangan5 = $_POST['keterangan5'];
			$bobot5 = $_POST['ket5_bobot'];
			$skor5 = $_POST['ket5_skor'];
			$nilai5 = $_POST['ket5_nilai'];

			// $keterangan6 = $_POST['keterangan6'];
			// $bobot6 = $_POST['ket6_bobot'];
			// $skor6 = $_POST['ket6_skor'];
			// $nilai6 = $_POST['ket6_nilai'];

			$tambahan1 = $_POST['tambahan1'];
			$bobot_tambahan1 = $_POST['tambahan1_bobot'];
			$skor_tambahan1 = $_POST['tambahan1_skor'];
			$nilai_tambahan1 = $_POST['tambahan1_nilai'];

			$tambahan2 = $_POST['tambahan2'];
			$bobot_tambahan2 = $_POST['tambahan2_bobot'];
			$skor_tambahan2 = $_POST['tambahan2_skor'];
			$nilai_tambahan2 = $_POST['tambahan2_nilai'];

			$tambahan3 = $_POST['tambahan3'];
			$bobot_tambahan3 = $_POST['tambahan3_bobot'];
			$skor_tambahan3 = $_POST['tambahan3_skor'];
			$nilai_tambahan3 = $_POST['tambahan3_nilai'];

			$tambahan4 = $_POST['tambahan4'];
			$bobot_tambahan4 = $_POST['tambahan4_bobot'];
			$skor_tambahan4 = $_POST['tambahan4_skor'];
			$nilai_tambahan4 = $_POST['tambahan4_nilai'];

			$tambahan5 = $_POST['tambahan5'];
			$bobot_tambahan5 = $_POST['tambahan5_bobot'];
			$skor_tambahan5 = $_POST['tambahan5_skor'];
			$nilai_tambahan5 = $_POST['tambahan5_nilai'];

			$total = $_POST['total_nilai_luaran_wajib'];

			// $tambahan6 = $_POST['tambahan6'];
			// $bobot_tambahan6 = $_POST['tambahan6_bobot'];
			// $skor_tambahan6 = $_POST['tambahan6_skor'];
			// $nilai_tambahan6 = $_POST['tambahan6_nilai'];

			// $tambahan7 = $_POST['tambahan7'];
			// $bobot_tambahan7 = $_POST['tambahan7_bobot'];
			// $skor_tambahan7 = $_POST['tambahan7_skor'];
			// $nilai_tambahan7 = $_POST['tambahan7_nilai'];

			// $tambahan8 = $_POST['tambahan8'];
			// $bobot_tambahan8 = $_POST['tambahan8_bobot'];
			// $skor_tambahan8 = $_POST['tambahan8_skor'];
			// $nilai_tambahan8 = $_POST['tambahan8_nilai'];

			$id_kerjaan = $_POST['id_kerjaan_monev'];
			$cek_kerjaan = $this->pemonev->cek_kerjaan($id_kerjaan);

			if ($cek_kerjaan === null) {
					echo 'Tidak Bisa';
					return;
			} else {
					if ($cek_kerjaan->kerjaan_selesai == 1) {
							echo 'Tidak Bisa';
							return;
					}
			}

			$this->db->trans_start();

			$data_laporan = array(
					'id_kerjaan_monev' => $id_kerjaan,
					'nama_ketua' => $nama_ketua,
					'jenis_proposal' => $jenis_proposal,

					'komponen_keterangan1' => $keterangan1,
					'komponen_bobot1' => $bobot1,
					'komponen_skor1' => $skor1,
					'komponen_nilai1' => $nilai1,

					'komponen_keterangan2' => $keterangan2,
					'komponen_bobot2' => $bobot2,
					'komponen_skor2' => $skor2,
					'komponen_nilai2' => $nilai2,

					'komponen_keterangan3' => $keterangan3,
					'komponen_bobot3' => $bobot3,
					'komponen_skor3' => $skor3,
					'komponen_nilai3' => $nilai3,

					'komponen_keterangan4' => $keterangan4,
					'komponen_bobot4' => $bobot4,
					'komponen_skor4' => $skor4,
					'komponen_nilai4' => $nilai4,

					'komponen_keterangan5' => $keterangan5,
					'komponen_bobot5' => $bobot5,
					'komponen_skor5' => $skor5,
					'komponen_nilai5' => $nilai5,

					// 'komponen_keterangan6' => $keterangan6,
					// 'komponen_bobot6' => $bobot6,
					// 'komponen_skor6' => $skor6,
					// 'komponen_nilai6' => $nilai6,

					'komponen_keterangan_tambahan1' => $tambahan1,
					'komponen_bobot_tambahan1' => $bobot_tambahan1,
					'komponen_skor_tambahan1' => $skor_tambahan1,
					'komponen_nilai_tambahan1' => $nilai_tambahan1,

					'komponen_keterangan_tambahan2' => $tambahan2,
					'komponen_bobot_tambahan2' => $bobot_tambahan2,
					'komponen_skor_tambahan2' => $skor_tambahan2,
					'komponen_nilai_tambahan2' => $nilai_tambahan2,

					'komponen_keterangan_tambahan3' => $tambahan3,
					'komponen_bobot_tambahan3' => $bobot_tambahan3,
					'komponen_skor_tambahan3' => $skor_tambahan3,
					'komponen_nilai_tambahan3' => $nilai_tambahan3,

					'komponen_keterangan_tambahan4' => $tambahan4,
					'komponen_bobot_tambahan4' => $bobot_tambahan4,
					'komponen_skor_tambahan4' => $skor_tambahan4,
					'komponen_nilai_tambahan4' => $nilai_tambahan4,

					'komponen_keterangan_tambahan5' => $tambahan5,
					'komponen_bobot_tambahan5' => $bobot_tambahan5,
					'komponen_skor_tambahan5' => $skor_tambahan5,
					'komponen_nilai_tambahan5' => $nilai_tambahan5,

					'total_nilai_wajib' => $total,

					// 'komponen_keterangan_tambahan6' => $tambahan6,
					// 'komponen_bobot_tambahan6' => $bobot_tambahan6,
					// 'komponen_skor_tambahan6' => $skor_tambahan6,
					// 'komponen_nilai_tambahan6' => $nilai_tambahan6,
					//
					// 'komponen_keterangan_tambahan7' => $tambahan7,
					// 'komponen_bobot_tambahan7' => $bobot_tambahan7,
					// 'komponen_skor_tambahan7' => $skor_tambahan7,
					// 'komponen_nilai_tambahan7' => $nilai_tambahan7,
					//
					// 'komponen_keterangan_tambahan8' => $tambahan8,
					// 'komponen_bobot_tambahan8' => $bobot_tambahan8,
					// 'komponen_skor_tambahan8' => $skor_tambahan8,
					// 'komponen_nilai_tambahan8' => $nilai_tambahan8,
			);

			$data_rekomendasi = array(
					'id_kerjaan_monev' => $id_kerjaan,
					// 'rekomendasi' => $rekomendasi,
					'masukan_pemonev' => $masukan

			);
			$this->db->set('created_at', 'NOW()', FALSE);
			$this->db->set('updated_at', 'NOW()', FALSE);

			$this->pemonev->insert('laporan_pemonev', $data_laporan);
			$this->pemonev->insert('masukan_pemonev', $data_rekomendasi);
			$this->pemonev->update_status_kerjaan($id_kerjaan);
			$this->db->trans_complete();
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Simpan Monev');
			redirect('C_dashboard');
			// return;
	}

	public function edit_monev()
	{
		// $rekomendasi = $_POST['rekomendasi'];
		$masukan = $_POST['masukan'];

		$keterangan1 = $_POST['keterangan1'];
		$bobot1 = $_POST['ket1_bobot'];
		$skor1 = $_POST['ket1_skor'];
		$nilai1 = $_POST['ket1_nilai'];

		$keterangan2 = $_POST['keterangan2'];
		$bobot2 = $_POST['ket2_bobot'];
		$skor2 = $_POST['ket2_skor'];
		$nilai2 = $_POST['ket2_nilai'];

		$keterangan3 = $_POST['keterangan3'];
		$bobot3 = $_POST['ket3_bobot'];
		$skor3 = $_POST['ket3_skor'];
		$nilai3 = $_POST['ket3_nilai'];

		$keterangan4 = $_POST['keterangan4'];
		$bobot4 = $_POST['ket4_bobot'];
		$skor4 = $_POST['ket4_skor'];
		$nilai4 = $_POST['ket4_nilai'];

		$keterangan5 = $_POST['keterangan5'];
		$bobot5 = $_POST['ket5_bobot'];
		$skor5 = $_POST['ket5_skor'];
		$nilai5 = $_POST['ket5_nilai'];

		$tambahan1 = $_POST['tambahan1'];
		$bobot_tambahan1 = $_POST['tambahan1_bobot'];
		$skor_tambahan1 = $_POST['tambahan1_skor'];
		$nilai_tambahan1 = $_POST['tambahan1_nilai'];

		$tambahan2 = $_POST['tambahan2'];
		$bobot_tambahan2 = $_POST['tambahan2_bobot'];
		$skor_tambahan2 = $_POST['tambahan2_skor'];
		$nilai_tambahan2 = $_POST['tambahan2_nilai'];

		$tambahan3 = $_POST['tambahan3'];
		$bobot_tambahan3 = $_POST['tambahan3_bobot'];
		$skor_tambahan3 = $_POST['tambahan3_skor'];
		$nilai_tambahan3 = $_POST['tambahan3_nilai'];

		$tambahan4 = $_POST['tambahan4'];
		$bobot_tambahan4 = $_POST['tambahan4_bobot'];
		$skor_tambahan4 = $_POST['tambahan4_skor'];
		$nilai_tambahan4 = $_POST['tambahan4_nilai'];

		$tambahan5 = $_POST['tambahan5'];
		$bobot_tambahan5 = $_POST['tambahan5_bobot'];
		$skor_tambahan5 = $_POST['tambahan5_skor'];
		$nilai_tambahan5 = $_POST['tambahan5_nilai'];

		$total = $_POST['total_nilai_luaran_wajib'];

		// unset($_POST['rekomendasi']);
		$id_kerjaan_monev = $_POST['id_kerjaan_monev'];
		$cek_kerjaan = $this->pemonev->cek_kerjaan($id_kerjaan_monev);

		if ($cek_kerjaan === null) {
				echo 'Tidak Bisa';
				return;
		} else {
				if ($cek_kerjaan->kerjaan_selesai != 1) {
						echo 'Error';
						return;
				}
		}

		$dt_laporan = [
			'id_kerjaan_monev' => $id_kerjaan_monev,

			'komponen_keterangan1' => $keterangan1,
			'komponen_bobot1' => $bobot1,
			'komponen_skor1' => $skor1,
			'komponen_nilai1' => $nilai1,

			'komponen_keterangan2' => $keterangan2,
			'komponen_bobot2' => $bobot2,
			'komponen_skor2' => $skor2,
			'komponen_nilai2' => $nilai2,

			'komponen_keterangan3' => $keterangan3,
			'komponen_bobot3' => $bobot3,
			'komponen_skor3' => $skor3,
			'komponen_nilai3' => $nilai3,

			'komponen_keterangan4' => $keterangan4,
			'komponen_bobot4' => $bobot4,
			'komponen_skor4' => $skor4,
			'komponen_nilai4' => $nilai4,

			'komponen_keterangan5' => $keterangan5,
			'komponen_bobot5' => $bobot5,
			'komponen_skor5' => $skor5,
			'komponen_nilai5' => $nilai5,

			'komponen_keterangan_tambahan1' => $tambahan1,
			'komponen_bobot_tambahan1' => $bobot_tambahan1,
			'komponen_skor_tambahan1' => $skor_tambahan1,
			'komponen_nilai_tambahan1' => $nilai_tambahan1,

			'komponen_keterangan_tambahan2' => $tambahan2,
			'komponen_bobot_tambahan2' => $bobot_tambahan2,
			'komponen_skor_tambahan2' => $skor_tambahan2,
			'komponen_nilai_tambahan2' => $nilai_tambahan2,

			'komponen_keterangan_tambahan3' => $tambahan3,
			'komponen_bobot_tambahan3' => $bobot_tambahan3,
			'komponen_skor_tambahan3' => $skor_tambahan3,
			'komponen_nilai_tambahan3' => $nilai_tambahan3,

			'komponen_keterangan_tambahan4' => $tambahan4,
			'komponen_bobot_tambahan4' => $bobot_tambahan4,
			'komponen_skor_tambahan4' => $skor_tambahan4,
			'komponen_nilai_tambahan4' => $nilai_tambahan4,

			'komponen_keterangan_tambahan5' => $tambahan5,
			'komponen_bobot_tambahan5' => $bobot_tambahan5,
			'komponen_skor_tambahan5' => $skor_tambahan5,
			'komponen_nilai_tambahan5' => $nilai_tambahan5,

			'total_nilai_wajib' => $total,
		];

		$dt_masukan = ['id_kerjaan_monev' => $id_kerjaan_monev, 'masukan_pemonev' => $masukan];
		$this->pemonev->update_laporan_monev($dt_laporan);
		$this->pemonev->update_masukan($dt_masukan);

		$this->session->set_flashdata('success', 'Berhasil Edit Monev');
		redirect('C_dashboard');
		// print_r($_POST['jawaban-1']);
	}

	public function simpan_monev_pkln()
	{
			// $rekomendasi = $_POST['rekomendasi'];
			$masukan = $_POST['masukan'];

			$nama_ketua = $_POST['nama_ketua'];
			$jenis_proposal = $_POST['jenis_proposal'];

			$keterangan1 = $_POST['keterangan1'];
			$bobot1 = $_POST['ket1_bobot'];
			$skor1 = $_POST['ket1_skor'];
			$nilai1 = $_POST['ket1_nilai'];

			$keterangan2 = $_POST['keterangan2'];
			$bobot2 = $_POST['ket2_bobot'];
			$skor2 = $_POST['ket2_skor'];
			$nilai2 = $_POST['ket2_nilai'];

			$keterangan3 = $_POST['keterangan3'];
			$bobot3 = $_POST['ket3_bobot'];
			$skor3 = $_POST['ket3_skor'];
			$nilai3 = $_POST['ket3_nilai'];

			$tambahan1 = $_POST['tambahan1'];
			$bobot_tambahan1 = $_POST['tambahan1_bobot'];
			$skor_tambahan1 = $_POST['tambahan1_skor'];
			$nilai_tambahan1 = $_POST['tambahan1_nilai'];

			$tambahan2 = $_POST['tambahan2'];
			$bobot_tambahan2 = $_POST['tambahan2_bobot'];
			$skor_tambahan2 = $_POST['tambahan2_skor'];
			$nilai_tambahan2 = $_POST['tambahan2_nilai'];

			$tambahan3 = $_POST['tambahan3'];
			$bobot_tambahan3 = $_POST['tambahan3_bobot'];
			$skor_tambahan3 = $_POST['tambahan3_skor'];
			$nilai_tambahan3 = $_POST['tambahan3_nilai'];

			$tambahan4 = $_POST['tambahan4'];
			$bobot_tambahan4 = $_POST['tambahan4_bobot'];
			$skor_tambahan4 = $_POST['tambahan4_skor'];
			$nilai_tambahan4 = $_POST['tambahan4_nilai'];

			$tambahan5 = $_POST['tambahan5'];
			$bobot_tambahan5 = $_POST['tambahan5_bobot'];
			$skor_tambahan5 = $_POST['tambahan5_skor'];
			$nilai_tambahan5 = $_POST['tambahan5_nilai'];

			$tambahan6 = $_POST['tambahan6'];
			$bobot_tambahan6 = $_POST['tambahan6_bobot'];
			$skor_tambahan6 = $_POST['tambahan6_skor'];
			$nilai_tambahan6 = $_POST['tambahan6_nilai'];

			$tambahan7 = $_POST['tambahan7'];
			$bobot_tambahan7 = $_POST['tambahan7_bobot'];
			$skor_tambahan7 = $_POST['tambahan7_skor'];
			$nilai_tambahan7 = $_POST['tambahan7_nilai'];

			$tambahan8 = $_POST['tambahan8'];
			$bobot_tambahan8 = $_POST['tambahan8_bobot'];
			$skor_tambahan8 = $_POST['tambahan8_skor'];
			$nilai_tambahan8 = $_POST['tambahan8_nilai'];

			$total = $_POST['total_nilai_luaran_wajib'];

			$id_kerjaan = $_POST['id_kerjaan_monev'];
			$cek_kerjaan = $this->pemonev->cek_kerjaan($id_kerjaan);

			if ($cek_kerjaan === null) {
					echo 'Tidak Bisa';
					return;
			} else {
					if ($cek_kerjaan->kerjaan_selesai == 1) {
							echo 'Tidak Bisa';
							return;
					}
			}

			$this->db->trans_start();

			$data_laporan = array(
					'id_kerjaan_monev' => $id_kerjaan,
					'nama_ketua' => $nama_ketua,
					'jenis_proposal' => $jenis_proposal,

					'komponen_keterangan1' => $keterangan1,
					'komponen_bobot1' => $bobot1,
					'komponen_skor1' => $skor1,
					'komponen_nilai1' => $nilai1,

					'komponen_keterangan2' => $keterangan2,
					'komponen_bobot2' => $bobot2,
					'komponen_skor2' => $skor2,
					'komponen_nilai2' => $nilai2,

					'komponen_keterangan3' => $keterangan3,
					'komponen_bobot3' => $bobot3,
					'komponen_skor3' => $skor3,
					'komponen_nilai3' => $nilai3,

					'komponen_keterangan_tambahan1' => $tambahan1,
					'komponen_bobot_tambahan1' => $bobot_tambahan1,
					'komponen_skor_tambahan1' => $skor_tambahan1,
					'komponen_nilai_tambahan1' => $nilai_tambahan1,

					'komponen_keterangan_tambahan2' => $tambahan2,
					'komponen_bobot_tambahan2' => $bobot_tambahan2,
					'komponen_skor_tambahan2' => $skor_tambahan2,
					'komponen_nilai_tambahan2' => $nilai_tambahan2,

					'komponen_keterangan_tambahan3' => $tambahan3,
					'komponen_bobot_tambahan3' => $bobot_tambahan3,
					'komponen_skor_tambahan3' => $skor_tambahan3,
					'komponen_nilai_tambahan3' => $nilai_tambahan3,

					'komponen_keterangan_tambahan4' => $tambahan4,
					'komponen_bobot_tambahan4' => $bobot_tambahan4,
					'komponen_skor_tambahan4' => $skor_tambahan4,
					'komponen_nilai_tambahan4' => $nilai_tambahan4,

					'komponen_keterangan_tambahan5' => $tambahan5,
					'komponen_bobot_tambahan5' => $bobot_tambahan5,
					'komponen_skor_tambahan5' => $skor_tambahan5,
					'komponen_nilai_tambahan5' => $nilai_tambahan5,

					'komponen_keterangan_tambahan6' => $tambahan6,
					'komponen_bobot_tambahan6' => $bobot_tambahan6,
					'komponen_skor_tambahan6' => $skor_tambahan6,
					'komponen_nilai_tambahan6' => $nilai_tambahan6,

					'komponen_keterangan_tambahan7' => $tambahan7,
					'komponen_bobot_tambahan7' => $bobot_tambahan7,
					'komponen_skor_tambahan7' => $skor_tambahan7,
					'komponen_nilai_tambahan7' => $nilai_tambahan7,

					'komponen_keterangan_tambahan8' => $tambahan8,
					'komponen_bobot_tambahan8' => $bobot_tambahan8,
					'komponen_skor_tambahan8' => $skor_tambahan8,
					'komponen_nilai_tambahan8' => $nilai_tambahan8,

					'total_nilai_wajib' => $total,
			);

			$data_rekomendasi = array(
					'id_kerjaan_monev' => $id_kerjaan,
					// 'rekomendasi' => $rekomendasi,
					'masukan_pemonev' => $masukan

			);
			$this->db->set('created_at', 'NOW()', FALSE);
			$this->db->set('updated_at', 'NOW()', FALSE);

			$this->pemonev->insert('laporan_pemonev', $data_laporan);
			$this->pemonev->insert('masukan_pemonev', $data_rekomendasi);
			$this->pemonev->update_status_kerjaan($id_kerjaan);
			$this->db->trans_complete();
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Simpan Monev');
			redirect('C_dashboard');
			// return;
	}

	public function edit_monev_pkln()
	{
		// $rekomendasi = $_POST['rekomendasi'];
		$masukan = $_POST['masukan'];

		$nama_ketua = $_POST['nama_ketua'];
		$jenis_proposal = $_POST['jenis_proposal'];

		$keterangan1 = $_POST['keterangan1'];
		$bobot1 = $_POST['ket1_bobot'];
		$skor1 = $_POST['ket1_skor'];
		$nilai1 = $_POST['ket1_nilai'];

		$keterangan2 = $_POST['keterangan2'];
		$bobot2 = $_POST['ket2_bobot'];
		$skor2 = $_POST['ket2_skor'];
		$nilai2 = $_POST['ket2_nilai'];

		$keterangan3 = $_POST['keterangan3'];
		$bobot3 = $_POST['ket3_bobot'];
		$skor3 = $_POST['ket3_skor'];
		$nilai3 = $_POST['ket3_nilai'];

		$tambahan1 = $_POST['tambahan1'];
		$bobot_tambahan1 = $_POST['tambahan1_bobot'];
		$skor_tambahan1 = $_POST['tambahan1_skor'];
		$nilai_tambahan1 = $_POST['tambahan1_nilai'];

		$tambahan2 = $_POST['tambahan2'];
		$bobot_tambahan2 = $_POST['tambahan2_bobot'];
		$skor_tambahan2 = $_POST['tambahan2_skor'];
		$nilai_tambahan2 = $_POST['tambahan2_nilai'];

		$tambahan3 = $_POST['tambahan3'];
		$bobot_tambahan3 = $_POST['tambahan3_bobot'];
		$skor_tambahan3 = $_POST['tambahan3_skor'];
		$nilai_tambahan3 = $_POST['tambahan3_nilai'];

		$tambahan4 = $_POST['tambahan4'];
		$bobot_tambahan4 = $_POST['tambahan4_bobot'];
		$skor_tambahan4 = $_POST['tambahan4_skor'];
		$nilai_tambahan4 = $_POST['tambahan4_nilai'];

		$tambahan5 = $_POST['tambahan5'];
		$bobot_tambahan5 = $_POST['tambahan5_bobot'];
		$skor_tambahan5 = $_POST['tambahan5_skor'];
		$nilai_tambahan5 = $_POST['tambahan5_nilai'];

		$tambahan6 = $_POST['tambahan6'];
		$bobot_tambahan6 = $_POST['tambahan6_bobot'];
		$skor_tambahan6 = $_POST['tambahan6_skor'];
		$nilai_tambahan6 = $_POST['tambahan6_nilai'];

		$tambahan7 = $_POST['tambahan7'];
		$bobot_tambahan7 = $_POST['tambahan7_bobot'];
		$skor_tambahan7 = $_POST['tambahan7_skor'];
		$nilai_tambahan7 = $_POST['tambahan7_nilai'];

		$tambahan8 = $_POST['tambahan8'];
		$bobot_tambahan8 = $_POST['tambahan8_bobot'];
		$skor_tambahan8 = $_POST['tambahan8_skor'];
		$nilai_tambahan8 = $_POST['tambahan8_nilai'];

		$total = $_POST['total_nilai_luaran_wajib'];

		// unset($_POST['rekomendasi']);
		$id_kerjaan_monev = $_POST['id_kerjaan_monev'];
		$cek_kerjaan = $this->pemonev->cek_kerjaan($id_kerjaan_monev);

		if ($cek_kerjaan === null) {
				echo 'Tidak Bisa';
				return;
		} else {
				if ($cek_kerjaan->kerjaan_selesai != 1) {
						echo 'Error';
						return;
				}
		}

		$dt_laporan = [
			'id_kerjaan_monev' => $id_kerjaan_monev,

			'komponen_keterangan1' => $keterangan1,
			'komponen_bobot1' => $bobot1,
			'komponen_skor1' => $skor1,
			'komponen_nilai1' => $nilai1,

			'komponen_keterangan2' => $keterangan2,
			'komponen_bobot2' => $bobot2,
			'komponen_skor2' => $skor2,
			'komponen_nilai2' => $nilai2,

			'komponen_keterangan3' => $keterangan3,
			'komponen_bobot3' => $bobot3,
			'komponen_skor3' => $skor3,
			'komponen_nilai3' => $nilai3,

			'komponen_keterangan_tambahan1' => $tambahan1,
			'komponen_bobot_tambahan1' => $bobot_tambahan1,
			'komponen_skor_tambahan1' => $skor_tambahan1,
			'komponen_nilai_tambahan1' => $nilai_tambahan1,

			'komponen_keterangan_tambahan2' => $tambahan2,
			'komponen_bobot_tambahan2' => $bobot_tambahan2,
			'komponen_skor_tambahan2' => $skor_tambahan2,
			'komponen_nilai_tambahan2' => $nilai_tambahan2,

			'komponen_keterangan_tambahan3' => $tambahan3,
			'komponen_bobot_tambahan3' => $bobot_tambahan3,
			'komponen_skor_tambahan3' => $skor_tambahan3,
			'komponen_nilai_tambahan3' => $nilai_tambahan3,

			'komponen_keterangan_tambahan4' => $tambahan4,
			'komponen_bobot_tambahan4' => $bobot_tambahan4,
			'komponen_skor_tambahan4' => $skor_tambahan4,
			'komponen_nilai_tambahan4' => $nilai_tambahan4,

			'komponen_keterangan_tambahan5' => $tambahan5,
			'komponen_bobot_tambahan5' => $bobot_tambahan5,
			'komponen_skor_tambahan5' => $skor_tambahan5,
			'komponen_nilai_tambahan5' => $nilai_tambahan5,

			'komponen_keterangan_tambahan6' => $tambahan6,
			'komponen_bobot_tambahan6' => $bobot_tambahan6,
			'komponen_skor_tambahan6' => $skor_tambahan6,
			'komponen_nilai_tambahan6' => $nilai_tambahan6,

			'komponen_keterangan_tambahan7' => $tambahan7,
			'komponen_bobot_tambahan7' => $bobot_tambahan7,
			'komponen_skor_tambahan7' => $skor_tambahan7,
			'komponen_nilai_tambahan7' => $nilai_tambahan7,

			'komponen_keterangan_tambahan8' => $tambahan8,
			'komponen_bobot_tambahan8' => $bobot_tambahan8,
			'komponen_skor_tambahan8' => $skor_tambahan8,
			'komponen_nilai_tambahan8' => $nilai_tambahan8,

			'total_nilai_wajib' => $total,
		];

		$dt_masukan = ['id_kerjaan_monev' => $id_kerjaan_monev, 'masukan_pemonev' => $_POST['masukan']];
		$this->pemonev->update_laporan_PKLN($dt_laporan);
		$this->pemonev->update_masukan($dt_masukan);

		$this->session->set_flashdata('success', 'Berhasil Edit Monev');
		redirect('C_dashboard');
		// print_r($_POST['jawaban-1']);
	}

	public function simpan_monev_pvuj()
	{
			// $rekomendasi = $_POST['rekomendasi'];
			$masukan = $_POST['masukan'];

			$nama_ketua = $_POST['nama_ketua'];
			$jenis_proposal = $_POST['jenis_proposal'];

			$keterangan1 = $_POST['keterangan1'];
			$bobot1 = $_POST['ket1_bobot'];
			$skor1 = $_POST['ket1_skor'];
			$nilai1 = $_POST['ket1_nilai'];

			$keterangan2 = $_POST['keterangan2'];
			$bobot2 = $_POST['ket2_bobot'];
			$skor2 = $_POST['ket2_skor'];
			$nilai2 = $_POST['ket2_nilai'];

			$keterangan3 = $_POST['keterangan3'];
			$bobot3 = $_POST['ket3_bobot'];
			$skor3 = $_POST['ket3_skor'];
			$nilai3 = $_POST['ket3_nilai'];

			$keterangan4 = $_POST['keterangan4'];
			$bobot4 = $_POST['ket4_bobot'];
			$skor4 = $_POST['ket4_skor'];
			$nilai4 = $_POST['ket4_nilai'];

			// $keterangan5 = $_POST['keterangan5'];
			// $bobot5 = $_POST['ket5_bobot'];
			// $skor5 = $_POST['ket5_skor'];
			// $nilai5 = $_POST['ket5_nilai'];
			//
			// $keterangan6 = $_POST['keterangan6'];
			// $bobot6 = $_POST['ket6_bobot'];
			// $skor6 = $_POST['ket6_skor'];
			// $nilai6 = $_POST['ket6_nilai'];

			$tambahan1 = $_POST['tambahan1'];
			$bobot_tambahan1 = $_POST['tambahan1_bobot'];
			$skor_tambahan1 = $_POST['tambahan1_skor'];
			$nilai_tambahan1 = $_POST['tambahan1_nilai'];

			$tambahan2 = $_POST['tambahan2'];
			$bobot_tambahan2 = $_POST['tambahan2_bobot'];
			$skor_tambahan2 = $_POST['tambahan2_skor'];
			$nilai_tambahan2 = $_POST['tambahan2_nilai'];

			$tambahan3 = $_POST['tambahan3'];
			$bobot_tambahan3 = $_POST['tambahan3_bobot'];
			$skor_tambahan3 = $_POST['tambahan3_skor'];
			$nilai_tambahan3 = $_POST['tambahan3_nilai'];

			$tambahan4 = $_POST['tambahan4'];
			$bobot_tambahan4 = $_POST['tambahan4_bobot'];
			$skor_tambahan4 = $_POST['tambahan4_skor'];
			$nilai_tambahan4 = $_POST['tambahan4_nilai'];

			$tambahan5 = $_POST['tambahan5'];
			$bobot_tambahan5 = $_POST['tambahan5_bobot'];
			$skor_tambahan5 = $_POST['tambahan5_skor'];
			$nilai_tambahan5 = $_POST['tambahan5_nilai'];

			$tambahan6 = $_POST['tambahan6'];
			$bobot_tambahan6 = $_POST['tambahan6_bobot'];
			$skor_tambahan6 = $_POST['tambahan6_skor'];
			$nilai_tambahan6 = $_POST['tambahan6_nilai'];

			$tambahan7 = $_POST['tambahan7'];
			$bobot_tambahan7 = $_POST['tambahan7_bobot'];
			$skor_tambahan7 = $_POST['tambahan7_skor'];
			$nilai_tambahan7 = $_POST['tambahan7_nilai'];

			$tambahan8 = $_POST['tambahan8'];
			$bobot_tambahan8 = $_POST['tambahan8_bobot'];
			$skor_tambahan8 = $_POST['tambahan8_skor'];
			$nilai_tambahan8 = $_POST['tambahan8_nilai'];

			$total = $_POST['total_nilai_luaran_wajib'];

			$id_kerjaan = $_POST['id_kerjaan_monev'];
			$cek_kerjaan = $this->pemonev->cek_kerjaan($id_kerjaan);

			if ($cek_kerjaan === null) {
					echo 'Tidak Bisa';
					return;
			} else {
					if ($cek_kerjaan->kerjaan_selesai == 1) {
							echo 'Tidak Bisa';
							return;
					}
			}

			$this->db->trans_start();

			$data_laporan = array(
					'id_kerjaan_monev' => $id_kerjaan,
					'nama_ketua' => $nama_ketua,
					'jenis_proposal' => $jenis_proposal,

					'komponen_keterangan1' => $keterangan1,
					'komponen_bobot1' => $bobot1,
					'komponen_skor1' => $skor1,
					'komponen_nilai1' => $nilai1,

					'komponen_keterangan2' => $keterangan2,
					'komponen_bobot2' => $bobot2,
					'komponen_skor2' => $skor2,
					'komponen_nilai2' => $nilai2,

					'komponen_keterangan3' => $keterangan3,
					'komponen_bobot3' => $bobot3,
					'komponen_skor3' => $skor3,
					'komponen_nilai3' => $nilai3,

					'komponen_keterangan4' => $keterangan4,
					'komponen_bobot4' => $bobot4,
					'komponen_skor4' => $skor4,
					'komponen_nilai4' => $nilai4,

					// 'komponen_keterangan5' => $keterangan5,
					// 'komponen_bobot5' => $bobot5,
					// 'komponen_skor5' => $skor5,
					// 'komponen_nilai5' => $nilai5,
					//
					// 'komponen_keterangan6' => $keterangan6,
					// 'komponen_bobot6' => $bobot6,
					// 'komponen_skor6' => $skor6,
					// 'komponen_nilai6' => $nilai6,

					'komponen_keterangan_tambahan1' => $tambahan1,
					'komponen_bobot_tambahan1' => $bobot_tambahan1,
					'komponen_skor_tambahan1' => $skor_tambahan1,
					'komponen_nilai_tambahan1' => $nilai_tambahan1,

					'komponen_keterangan_tambahan2' => $tambahan2,
					'komponen_bobot_tambahan2' => $bobot_tambahan2,
					'komponen_skor_tambahan2' => $skor_tambahan2,
					'komponen_nilai_tambahan2' => $nilai_tambahan2,

					'komponen_keterangan_tambahan3' => $tambahan3,
					'komponen_bobot_tambahan3' => $bobot_tambahan3,
					'komponen_skor_tambahan3' => $skor_tambahan3,
					'komponen_nilai_tambahan3' => $nilai_tambahan3,

					'komponen_keterangan_tambahan4' => $tambahan4,
					'komponen_bobot_tambahan4' => $bobot_tambahan4,
					'komponen_skor_tambahan4' => $skor_tambahan4,
					'komponen_nilai_tambahan4' => $nilai_tambahan4,

					'komponen_keterangan_tambahan5' => $tambahan5,
					'komponen_bobot_tambahan5' => $bobot_tambahan5,
					'komponen_skor_tambahan5' => $skor_tambahan5,
					'komponen_nilai_tambahan5' => $nilai_tambahan5,

					'komponen_keterangan_tambahan6' => $tambahan6,
					'komponen_bobot_tambahan6' => $bobot_tambahan6,
					'komponen_skor_tambahan6' => $skor_tambahan6,
					'komponen_nilai_tambahan6' => $nilai_tambahan6,

					'komponen_keterangan_tambahan7' => $tambahan7,
					'komponen_bobot_tambahan7' => $bobot_tambahan7,
					'komponen_skor_tambahan7' => $skor_tambahan7,
					'komponen_nilai_tambahan7' => $nilai_tambahan7,

					'komponen_keterangan_tambahan8' => $tambahan8,
					'komponen_bobot_tambahan8' => $bobot_tambahan8,
					'komponen_skor_tambahan8' => $skor_tambahan8,
					'komponen_nilai_tambahan8' => $nilai_tambahan8,

					'total_nilai_wajib' => $total,
			);

			$data_rekomendasi = array(
					'id_kerjaan_monev' => $id_kerjaan,
					// 'rekomendasi' => $rekomendasi,
					'masukan_pemonev' => $masukan

			);
			$this->db->set('created_at', 'NOW()', FALSE);
			$this->db->set('updated_at', 'NOW()', FALSE);

			$this->pemonev->insert('laporan_pemonev', $data_laporan);
			$this->pemonev->insert('masukan_pemonev', $data_rekomendasi);
			$this->pemonev->update_status_kerjaan($id_kerjaan);
			$this->db->trans_complete();
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Simpan Monev');
			redirect('C_dashboard');
			// return;
	}

	public function edit_monev_pvuj()
	{
		// $rekomendasi = $_POST['rekomendasi'];
		$masukan = $_POST['masukan'];

		$keterangan1 = $_POST['keterangan1'];
		$bobot1 = $_POST['ket1_bobot'];
		$skor1 = $_POST['ket1_skor'];
		$nilai1 = $_POST['ket1_nilai'];

		$keterangan2 = $_POST['keterangan2'];
		$bobot2 = $_POST['ket2_bobot'];
		$skor2 = $_POST['ket2_skor'];
		$nilai2 = $_POST['ket2_nilai'];

		$keterangan3 = $_POST['keterangan3'];
		$bobot3 = $_POST['ket3_bobot'];
		$skor3 = $_POST['ket3_skor'];
		$nilai3 = $_POST['ket3_nilai'];

		$keterangan4 = $_POST['keterangan4'];
		$bobot4 = $_POST['ket4_bobot'];
		$skor4 = $_POST['ket4_skor'];
		$nilai4 = $_POST['ket4_nilai'];

		// $keterangan5 = $_POST['keterangan5'];
		// $bobot5 = $_POST['ket5_bobot'];
		// $skor5 = $_POST['ket5_skor'];
		// $nilai5 = $_POST['ket5_nilai'];

		$tambahan1 = $_POST['tambahan1'];
		$bobot_tambahan1 = $_POST['tambahan1_bobot'];
		$skor_tambahan1 = $_POST['tambahan1_skor'];
		$nilai_tambahan1 = $_POST['tambahan1_nilai'];

		$tambahan2 = $_POST['tambahan2'];
		$bobot_tambahan2 = $_POST['tambahan2_bobot'];
		$skor_tambahan2 = $_POST['tambahan2_skor'];
		$nilai_tambahan2 = $_POST['tambahan2_nilai'];

		$tambahan3 = $_POST['tambahan3'];
		$bobot_tambahan3 = $_POST['tambahan3_bobot'];
		$skor_tambahan3 = $_POST['tambahan3_skor'];
		$nilai_tambahan3 = $_POST['tambahan3_nilai'];

		$tambahan4 = $_POST['tambahan4'];
		$bobot_tambahan4 = $_POST['tambahan4_bobot'];
		$skor_tambahan4 = $_POST['tambahan4_skor'];
		$nilai_tambahan4 = $_POST['tambahan4_nilai'];

		$tambahan5 = $_POST['tambahan5'];
		$bobot_tambahan5 = $_POST['tambahan5_bobot'];
		$skor_tambahan5 = $_POST['tambahan5_skor'];
		$nilai_tambahan5 = $_POST['tambahan5_nilai'];

		$tambahan6 = $_POST['tambahan6'];
		$bobot_tambahan6 = $_POST['tambahan6_bobot'];
		$skor_tambahan6 = $_POST['tambahan6_skor'];
		$nilai_tambahan6 = $_POST['tambahan6_nilai'];

		$tambahan7 = $_POST['tambahan7'];
		$bobot_tambahan7 = $_POST['tambahan7_bobot'];
		$skor_tambahan7 = $_POST['tambahan7_skor'];
		$nilai_tambahan7 = $_POST['tambahan7_nilai'];

		$tambahan8 = $_POST['tambahan8'];
		$bobot_tambahan8 = $_POST['tambahan8_bobot'];
		$skor_tambahan8 = $_POST['tambahan8_skor'];
		$nilai_tambahan8 = $_POST['tambahan8_nilai'];

		$total = $_POST['total_nilai_luaran_wajib'];

		// unset($_POST['rekomendasi']);
		$id_kerjaan_monev = $_POST['id_kerjaan_monev'];
		$cek_kerjaan = $this->pemonev->cek_kerjaan($id_kerjaan_monev);

		if ($cek_kerjaan === null) {
				echo 'Tidak Bisa';
				return;
		} else {
				if ($cek_kerjaan->kerjaan_selesai != 1) {
						echo 'Error';
						return;
				}
		}

		$dt_laporan = [
			'id_kerjaan_monev' => $id_kerjaan_monev,

			'komponen_keterangan1' => $keterangan1,
			'komponen_bobot1' => $bobot1,
			'komponen_skor1' => $skor1,
			'komponen_nilai1' => $nilai1,

			'komponen_keterangan2' => $keterangan2,
			'komponen_bobot2' => $bobot2,
			'komponen_skor2' => $skor2,
			'komponen_nilai2' => $nilai2,

			'komponen_keterangan3' => $keterangan3,
			'komponen_bobot3' => $bobot3,
			'komponen_skor3' => $skor3,
			'komponen_nilai3' => $nilai3,

			'komponen_keterangan4' => $keterangan4,
			'komponen_bobot4' => $bobot4,
			'komponen_skor4' => $skor4,
			'komponen_nilai4' => $nilai4,

			// 'komponen_keterangan5' => $keterangan5,
			// 'komponen_bobot5' => $bobot5,
			// 'komponen_skor5' => $skor5,
			// 'komponen_nilai5' => $nilai5,

			'komponen_keterangan_tambahan1' => $tambahan1,
			'komponen_bobot_tambahan1' => $bobot_tambahan1,
			'komponen_skor_tambahan1' => $skor_tambahan1,
			'komponen_nilai_tambahan1' => $nilai_tambahan1,

			'komponen_keterangan_tambahan2' => $tambahan2,
			'komponen_bobot_tambahan2' => $bobot_tambahan2,
			'komponen_skor_tambahan2' => $skor_tambahan2,
			'komponen_nilai_tambahan2' => $nilai_tambahan2,

			'komponen_keterangan_tambahan3' => $tambahan3,
			'komponen_bobot_tambahan3' => $bobot_tambahan3,
			'komponen_skor_tambahan3' => $skor_tambahan3,
			'komponen_nilai_tambahan3' => $nilai_tambahan3,

			'komponen_keterangan_tambahan4' => $tambahan4,
			'komponen_bobot_tambahan4' => $bobot_tambahan4,
			'komponen_skor_tambahan4' => $skor_tambahan4,
			'komponen_nilai_tambahan4' => $nilai_tambahan4,

			'komponen_keterangan_tambahan5' => $tambahan5,
			'komponen_bobot_tambahan5' => $bobot_tambahan5,
			'komponen_skor_tambahan5' => $skor_tambahan5,
			'komponen_nilai_tambahan5' => $nilai_tambahan5,

			'komponen_keterangan_tambahan6' => $tambahan6,
			'komponen_bobot_tambahan6' => $bobot_tambahan6,
			'komponen_skor_tambahan6' => $skor_tambahan6,
			'komponen_nilai_tambahan6' => $nilai_tambahan6,

			'komponen_keterangan_tambahan7' => $tambahan7,
			'komponen_bobot_tambahan7' => $bobot_tambahan7,
			'komponen_skor_tambahan7' => $skor_tambahan7,
			'komponen_nilai_tambahan7' => $nilai_tambahan7,

			'komponen_keterangan_tambahan8' => $tambahan8,
			'komponen_bobot_tambahan8' => $bobot_tambahan8,
			'komponen_skor_tambahan8' => $skor_tambahan8,
			'komponen_nilai_tambahan8' => $nilai_tambahan8,

			'total_nilai_wajib' => $total,
		];

		$dt_masukan = ['id_kerjaan_monev' => $id_kerjaan_monev, 'masukan_pemonev' => $masukan];
		$this->pemonev->update_laporan_PVUJ($dt_laporan);
		$this->pemonev->update_masukan($dt_masukan);

		$this->session->set_flashdata('success', 'Berhasil Edit Monev');
		redirect('C_dashboard');
		// print_r($_POST['jawaban-1']);
	}

	public function simpan_monev_kks()
	{
			// $rekomendasi = $_POST['rekomendasi'];
			$masukan = $_POST['masukan'];

			$nama_ketua = $_POST['nama_ketua'];
			$jenis_proposal = $_POST['jenis_proposal'];

			$keterangan1 = $_POST['keterangan1'];
			$bobot1 = $_POST['ket1_bobot'];
			$skor1 = $_POST['ket1_skor'];
			$nilai1 = $_POST['ket1_nilai'];

			$keterangan2 = $_POST['keterangan2'];
			$bobot2 = $_POST['ket2_bobot'];
			$skor2 = $_POST['ket2_skor'];
			$nilai2 = $_POST['ket2_nilai'];

			$keterangan3 = $_POST['keterangan3'];
			$bobot3 = $_POST['ket3_bobot'];
			$skor3 = $_POST['ket3_skor'];
			$nilai3 = $_POST['ket3_nilai'];

			// $keterangan4 = $_POST['keterangan4'];
			// $bobot4 = $_POST['ket4_bobot'];
			// $skor4 = $_POST['ket4_skor'];
			// $nilai4 = $_POST['ket4_nilai'];

			// $keterangan5 = $_POST['keterangan5'];
			// $bobot5 = $_POST['ket5_bobot'];
			// $skor5 = $_POST['ket5_skor'];
			// $nilai5 = $_POST['ket5_nilai'];
			//
			// $keterangan6 = $_POST['keterangan6'];
			// $bobot6 = $_POST['ket6_bobot'];
			// $skor6 = $_POST['ket6_skor'];
			// $nilai6 = $_POST['ket6_nilai'];

			$tambahan1 = $_POST['tambahan1'];
			$bobot_tambahan1 = $_POST['tambahan1_bobot'];
			$skor_tambahan1 = $_POST['tambahan1_skor'];
			$nilai_tambahan1 = $_POST['tambahan1_nilai'];

			$tambahan2 = $_POST['tambahan2'];
			$bobot_tambahan2 = $_POST['tambahan2_bobot'];
			$skor_tambahan2 = $_POST['tambahan2_skor'];
			$nilai_tambahan2 = $_POST['tambahan2_nilai'];

			$tambahan3 = $_POST['tambahan3'];
			$bobot_tambahan3 = $_POST['tambahan3_bobot'];
			$skor_tambahan3 = $_POST['tambahan3_skor'];
			$nilai_tambahan3 = $_POST['tambahan3_nilai'];

			$tambahan4 = $_POST['tambahan4'];
			$bobot_tambahan4 = $_POST['tambahan4_bobot'];
			$skor_tambahan4 = $_POST['tambahan4_skor'];
			$nilai_tambahan4 = $_POST['tambahan4_nilai'];

			$tambahan5 = $_POST['tambahan5'];
			$bobot_tambahan5 = $_POST['tambahan5_bobot'];
			$skor_tambahan5 = $_POST['tambahan5_skor'];
			$nilai_tambahan5 = $_POST['tambahan5_nilai'];

			$tambahan6 = $_POST['tambahan6'];
			$bobot_tambahan6 = $_POST['tambahan6_bobot'];
			$skor_tambahan6 = $_POST['tambahan6_skor'];
			$nilai_tambahan6 = $_POST['tambahan6_nilai'];

			$tambahan7 = $_POST['tambahan7'];
			$bobot_tambahan7 = $_POST['tambahan7_bobot'];
			$skor_tambahan7 = $_POST['tambahan7_skor'];
			$nilai_tambahan7 = $_POST['tambahan7_nilai'];

			$tambahan8 = $_POST['tambahan8'];
			$bobot_tambahan8 = $_POST['tambahan8_bobot'];
			$skor_tambahan8 = $_POST['tambahan8_skor'];
			$nilai_tambahan8 = $_POST['tambahan8_nilai'];

			$total = $_POST['total_nilai_luaran_wajib'];

			$id_kerjaan = $_POST['id_kerjaan_monev'];
			$cek_kerjaan = $this->pemonev->cek_kerjaan($id_kerjaan);

			if ($cek_kerjaan === null) {
					echo 'Tidak Bisa';
					return;
			} else {
					if ($cek_kerjaan->kerjaan_selesai == 1) {
							echo 'Tidak Bisa';
							return;
					}
			}

			$this->db->trans_start();

			$data_laporan = array(
					'id_kerjaan_monev' => $id_kerjaan,
					'nama_ketua' => $nama_ketua,
					'jenis_proposal' => $jenis_proposal,

					'komponen_keterangan1' => $keterangan1,
					'komponen_bobot1' => $bobot1,
					'komponen_skor1' => $skor1,
					'komponen_nilai1' => $nilai1,

					'komponen_keterangan2' => $keterangan2,
					'komponen_bobot2' => $bobot2,
					'komponen_skor2' => $skor2,
					'komponen_nilai2' => $nilai2,

					'komponen_keterangan3' => $keterangan3,
					'komponen_bobot3' => $bobot3,
					'komponen_skor3' => $skor3,
					'komponen_nilai3' => $nilai3,

					// 'komponen_keterangan4' => $keterangan4,
					// 'komponen_bobot4' => $bobot4,
					// 'komponen_skor4' => $skor4,
					// 'komponen_nilai4' => $nilai4,

					// 'komponen_keterangan5' => $keterangan5,
					// 'komponen_bobot5' => $bobot5,
					// 'komponen_skor5' => $skor5,
					// 'komponen_nilai5' => $nilai5,
					//
					// 'komponen_keterangan6' => $keterangan6,
					// 'komponen_bobot6' => $bobot6,
					// 'komponen_skor6' => $skor6,
					// 'komponen_nilai6' => $nilai6,

					'komponen_keterangan_tambahan1' => $tambahan1,
					'komponen_bobot_tambahan1' => $bobot_tambahan1,
					'komponen_skor_tambahan1' => $skor_tambahan1,
					'komponen_nilai_tambahan1' => $nilai_tambahan1,

					'komponen_keterangan_tambahan2' => $tambahan2,
					'komponen_bobot_tambahan2' => $bobot_tambahan2,
					'komponen_skor_tambahan2' => $skor_tambahan2,
					'komponen_nilai_tambahan2' => $nilai_tambahan2,

					'komponen_keterangan_tambahan3' => $tambahan3,
					'komponen_bobot_tambahan3' => $bobot_tambahan3,
					'komponen_skor_tambahan3' => $skor_tambahan3,
					'komponen_nilai_tambahan3' => $nilai_tambahan3,

					'komponen_keterangan_tambahan4' => $tambahan4,
					'komponen_bobot_tambahan4' => $bobot_tambahan4,
					'komponen_skor_tambahan4' => $skor_tambahan4,
					'komponen_nilai_tambahan4' => $nilai_tambahan4,

					'komponen_keterangan_tambahan5' => $tambahan5,
					'komponen_bobot_tambahan5' => $bobot_tambahan5,
					'komponen_skor_tambahan5' => $skor_tambahan5,
					'komponen_nilai_tambahan5' => $nilai_tambahan5,

					'komponen_keterangan_tambahan6' => $tambahan6,
					'komponen_bobot_tambahan6' => $bobot_tambahan6,
					'komponen_skor_tambahan6' => $skor_tambahan6,
					'komponen_nilai_tambahan6' => $nilai_tambahan6,

					'komponen_keterangan_tambahan7' => $tambahan7,
					'komponen_bobot_tambahan7' => $bobot_tambahan7,
					'komponen_skor_tambahan7' => $skor_tambahan7,
					'komponen_nilai_tambahan7' => $nilai_tambahan7,

					'komponen_keterangan_tambahan8' => $tambahan8,
					'komponen_bobot_tambahan8' => $bobot_tambahan8,
					'komponen_skor_tambahan8' => $skor_tambahan8,
					'komponen_nilai_tambahan8' => $nilai_tambahan8,

					'total_nilai_wajib' => $total,
			);

			$data_rekomendasi = array(
					'id_kerjaan_monev' => $id_kerjaan,
					// 'rekomendasi' => $rekomendasi,
					'masukan_pemonev' => $masukan

			);
			$this->db->set('created_at', 'NOW()', FALSE);
			$this->db->set('updated_at', 'NOW()', FALSE);

			$this->pemonev->insert('laporan_pemonev', $data_laporan);
			$this->pemonev->insert('masukan_pemonev', $data_rekomendasi);
			$this->pemonev->update_status_kerjaan($id_kerjaan);
			$this->db->trans_complete();
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Simpan Monev');
			redirect('C_dashboard');
			// return;
	}

	public function edit_monev_kks()
	{
		// $rekomendasi = $_POST['rekomendasi'];
		$masukan = $_POST['masukan'];

		$keterangan1 = $_POST['keterangan1'];
		$bobot1 = $_POST['ket1_bobot'];
		$skor1 = $_POST['ket1_skor'];
		$nilai1 = $_POST['ket1_nilai'];

		$keterangan2 = $_POST['keterangan2'];
		$bobot2 = $_POST['ket2_bobot'];
		$skor2 = $_POST['ket2_skor'];
		$nilai2 = $_POST['ket2_nilai'];

		$keterangan3 = $_POST['keterangan3'];
		$bobot3 = $_POST['ket3_bobot'];
		$skor3 = $_POST['ket3_skor'];
		$nilai3 = $_POST['ket3_nilai'];

		// $keterangan4 = $_POST['keterangan4'];
		// $bobot4 = $_POST['ket4_bobot'];
		// $skor4 = $_POST['ket4_skor'];
		// $nilai4 = $_POST['ket4_nilai'];

		// $keterangan5 = $_POST['keterangan5'];
		// $bobot5 = $_POST['ket5_bobot'];
		// $skor5 = $_POST['ket5_skor'];
		// $nilai5 = $_POST['ket5_nilai'];

		$tambahan1 = $_POST['tambahan1'];
		$bobot_tambahan1 = $_POST['tambahan1_bobot'];
		$skor_tambahan1 = $_POST['tambahan1_skor'];
		$nilai_tambahan1 = $_POST['tambahan1_nilai'];

		$tambahan2 = $_POST['tambahan2'];
		$bobot_tambahan2 = $_POST['tambahan2_bobot'];
		$skor_tambahan2 = $_POST['tambahan2_skor'];
		$nilai_tambahan2 = $_POST['tambahan2_nilai'];

		$tambahan3 = $_POST['tambahan3'];
		$bobot_tambahan3 = $_POST['tambahan3_bobot'];
		$skor_tambahan3 = $_POST['tambahan3_skor'];
		$nilai_tambahan3 = $_POST['tambahan3_nilai'];

		$tambahan4 = $_POST['tambahan4'];
		$bobot_tambahan4 = $_POST['tambahan4_bobot'];
		$skor_tambahan4 = $_POST['tambahan4_skor'];
		$nilai_tambahan4 = $_POST['tambahan4_nilai'];

		$tambahan5 = $_POST['tambahan5'];
		$bobot_tambahan5 = $_POST['tambahan5_bobot'];
		$skor_tambahan5 = $_POST['tambahan5_skor'];
		$nilai_tambahan5 = $_POST['tambahan5_nilai'];

		$tambahan6 = $_POST['tambahan6'];
		$bobot_tambahan6 = $_POST['tambahan6_bobot'];
		$skor_tambahan6 = $_POST['tambahan6_skor'];
		$nilai_tambahan6 = $_POST['tambahan6_nilai'];

		$tambahan7 = $_POST['tambahan7'];
		$bobot_tambahan7 = $_POST['tambahan7_bobot'];
		$skor_tambahan7 = $_POST['tambahan7_skor'];
		$nilai_tambahan7 = $_POST['tambahan7_nilai'];

		$tambahan8 = $_POST['tambahan8'];
		$bobot_tambahan8 = $_POST['tambahan8_bobot'];
		$skor_tambahan8 = $_POST['tambahan8_skor'];
		$nilai_tambahan8 = $_POST['tambahan8_nilai'];

		$total = $_POST['total_nilai_luaran_wajib'];

		// unset($_POST['rekomendasi']);
		$id_kerjaan_monev = $_POST['id_kerjaan_monev'];
		$cek_kerjaan = $this->pemonev->cek_kerjaan($id_kerjaan_monev);

		if ($cek_kerjaan === null) {
				echo 'Tidak Bisa';
				return;
		} else {
				if ($cek_kerjaan->kerjaan_selesai != 1) {
						echo 'Error';
						return;
				}
		}

		$dt_laporan = [
			'id_kerjaan_monev' => $id_kerjaan_monev,

			'komponen_keterangan1' => $keterangan1,
			'komponen_bobot1' => $bobot1,
			'komponen_skor1' => $skor1,
			'komponen_nilai1' => $nilai1,

			'komponen_keterangan2' => $keterangan2,
			'komponen_bobot2' => $bobot2,
			'komponen_skor2' => $skor2,
			'komponen_nilai2' => $nilai2,

			'komponen_keterangan3' => $keterangan3,
			'komponen_bobot3' => $bobot3,
			'komponen_skor3' => $skor3,
			'komponen_nilai3' => $nilai3,

			// 'komponen_keterangan4' => $keterangan4,
			// 'komponen_bobot4' => $bobot4,
			// 'komponen_skor4' => $skor4,
			// 'komponen_nilai4' => $nilai4,

			// 'komponen_keterangan5' => $keterangan5,
			// 'komponen_bobot5' => $bobot5,
			// 'komponen_skor5' => $skor5,
			// 'komponen_nilai5' => $nilai5,

			'komponen_keterangan_tambahan1' => $tambahan1,
			'komponen_bobot_tambahan1' => $bobot_tambahan1,
			'komponen_skor_tambahan1' => $skor_tambahan1,
			'komponen_nilai_tambahan1' => $nilai_tambahan1,

			'komponen_keterangan_tambahan2' => $tambahan2,
			'komponen_bobot_tambahan2' => $bobot_tambahan2,
			'komponen_skor_tambahan2' => $skor_tambahan2,
			'komponen_nilai_tambahan2' => $nilai_tambahan2,

			'komponen_keterangan_tambahan3' => $tambahan3,
			'komponen_bobot_tambahan3' => $bobot_tambahan3,
			'komponen_skor_tambahan3' => $skor_tambahan3,
			'komponen_nilai_tambahan3' => $nilai_tambahan3,

			'komponen_keterangan_tambahan4' => $tambahan4,
			'komponen_bobot_tambahan4' => $bobot_tambahan4,
			'komponen_skor_tambahan4' => $skor_tambahan4,
			'komponen_nilai_tambahan4' => $nilai_tambahan4,

			'komponen_keterangan_tambahan5' => $tambahan5,
			'komponen_bobot_tambahan5' => $bobot_tambahan5,
			'komponen_skor_tambahan5' => $skor_tambahan5,
			'komponen_nilai_tambahan5' => $nilai_tambahan5,

			'komponen_keterangan_tambahan6' => $tambahan6,
			'komponen_bobot_tambahan6' => $bobot_tambahan6,
			'komponen_skor_tambahan6' => $skor_tambahan6,
			'komponen_nilai_tambahan6' => $nilai_tambahan6,

			'komponen_keterangan_tambahan7' => $tambahan7,
			'komponen_bobot_tambahan7' => $bobot_tambahan7,
			'komponen_skor_tambahan7' => $skor_tambahan7,
			'komponen_nilai_tambahan7' => $nilai_tambahan7,

			'komponen_keterangan_tambahan8' => $tambahan8,
			'komponen_bobot_tambahan8' => $bobot_tambahan8,
			'komponen_skor_tambahan8' => $skor_tambahan8,
			'komponen_nilai_tambahan8' => $nilai_tambahan8,

			'total_nilai_wajib' => $total,
		];

		$dt_masukan = ['id_kerjaan_monev' => $id_kerjaan_monev, 'masukan_pemonev' => $masukan];
		$this->pemonev->update_laporan_KKS($dt_laporan);
		$this->pemonev->update_masukan($dt_masukan);

		$this->session->set_flashdata('success', 'Berhasil Edit Monev');
		redirect('C_dashboard');
		// print_r($_POST['jawaban-1']);
	}

	public function simpan_monev_ptm()
	{
			// $rekomendasi = $_POST['rekomendasi'];
			$masukan = $_POST['masukan'];

			$nama_ketua = $_POST['nama_ketua'];
			$jenis_proposal = $_POST['jenis_proposal'];

			$keterangan1 = $_POST['keterangan1'];
			$bobot1 = $_POST['ket1_bobot'];
			$skor1 = $_POST['ket1_skor'];
			$nilai1 = $_POST['ket1_nilai'];

			$keterangan2 = $_POST['keterangan2'];
			$bobot2 = $_POST['ket2_bobot'];
			$skor2 = $_POST['ket2_skor'];
			$nilai2 = $_POST['ket2_nilai'];

			$keterangan3 = $_POST['keterangan3'];
			$bobot3 = $_POST['ket3_bobot'];
			$skor3 = $_POST['ket3_skor'];
			$nilai3 = $_POST['ket3_nilai'];

			$keterangan4 = $_POST['keterangan4'];
			$bobot4 = $_POST['ket4_bobot'];
			$skor4 = $_POST['ket4_skor'];
			$nilai4 = $_POST['ket4_nilai'];

			// $keterangan5 = $_POST['keterangan5'];
			// $bobot5 = $_POST['ket5_bobot'];
			// $skor5 = $_POST['ket5_skor'];
			// $nilai5 = $_POST['ket5_nilai'];
			//
			// $keterangan6 = $_POST['keterangan6'];
			// $bobot6 = $_POST['ket6_bobot'];
			// $skor6 = $_POST['ket6_skor'];
			// $nilai6 = $_POST['ket6_nilai'];

			$tambahan1 = $_POST['tambahan1'];
			$bobot_tambahan1 = $_POST['tambahan1_bobot'];
			$skor_tambahan1 = $_POST['tambahan1_skor'];
			$nilai_tambahan1 = $_POST['tambahan1_nilai'];

			$tambahan2 = $_POST['tambahan2'];
			$bobot_tambahan2 = $_POST['tambahan2_bobot'];
			$skor_tambahan2 = $_POST['tambahan2_skor'];
			$nilai_tambahan2 = $_POST['tambahan2_nilai'];

			$tambahan3 = $_POST['tambahan3'];
			$bobot_tambahan3 = $_POST['tambahan3_bobot'];
			$skor_tambahan3 = $_POST['tambahan3_skor'];
			$nilai_tambahan3 = $_POST['tambahan3_nilai'];

			$tambahan4 = $_POST['tambahan4'];
			$bobot_tambahan4 = $_POST['tambahan4_bobot'];
			$skor_tambahan4 = $_POST['tambahan4_skor'];
			$nilai_tambahan4 = $_POST['tambahan4_nilai'];

			$tambahan5 = $_POST['tambahan5'];
			$bobot_tambahan5 = $_POST['tambahan5_bobot'];
			$skor_tambahan5 = $_POST['tambahan5_skor'];
			$nilai_tambahan5 = $_POST['tambahan5_nilai'];

			$tambahan6 = $_POST['tambahan6'];
			$bobot_tambahan6 = $_POST['tambahan6_bobot'];
			$skor_tambahan6 = $_POST['tambahan6_skor'];
			$nilai_tambahan6 = $_POST['tambahan6_nilai'];

			$tambahan7 = $_POST['tambahan7'];
			$bobot_tambahan7 = $_POST['tambahan7_bobot'];
			$skor_tambahan7 = $_POST['tambahan7_skor'];
			$nilai_tambahan7 = $_POST['tambahan7_nilai'];

			$tambahan8 = $_POST['tambahan8'];
			$bobot_tambahan8 = $_POST['tambahan8_bobot'];
			$skor_tambahan8 = $_POST['tambahan8_skor'];
			$nilai_tambahan8 = $_POST['tambahan8_nilai'];

			$total = $_POST['total_nilai_luaran_wajib'];

			$id_kerjaan = $_POST['id_kerjaan_monev'];
			$cek_kerjaan = $this->pemonev->cek_kerjaan($id_kerjaan);

			if ($cek_kerjaan === null) {
					echo 'Tidak Bisa';
					return;
			} else {
					if ($cek_kerjaan->kerjaan_selesai == 1) {
							echo 'Tidak Bisa';
							return;
					}
			}

			$this->db->trans_start();

			$data_laporan = array(
					'id_kerjaan_monev' => $id_kerjaan,
					'nama_ketua' => $nama_ketua,
					'jenis_proposal' => $jenis_proposal,

					'komponen_keterangan1' => $keterangan1,
					'komponen_bobot1' => $bobot1,
					'komponen_skor1' => $skor1,
					'komponen_nilai1' => $nilai1,

					'komponen_keterangan2' => $keterangan2,
					'komponen_bobot2' => $bobot2,
					'komponen_skor2' => $skor2,
					'komponen_nilai2' => $nilai2,

					'komponen_keterangan3' => $keterangan3,
					'komponen_bobot3' => $bobot3,
					'komponen_skor3' => $skor3,
					'komponen_nilai3' => $nilai3,

					'komponen_keterangan4' => $keterangan4,
					'komponen_bobot4' => $bobot4,
					'komponen_skor4' => $skor4,
					'komponen_nilai4' => $nilai4,

					// 'komponen_keterangan5' => $keterangan5,
					// 'komponen_bobot5' => $bobot5,
					// 'komponen_skor5' => $skor5,
					// 'komponen_nilai5' => $nilai5,
					//
					// 'komponen_keterangan6' => $keterangan6,
					// 'komponen_bobot6' => $bobot6,
					// 'komponen_skor6' => $skor6,
					// 'komponen_nilai6' => $nilai6,

					'komponen_keterangan_tambahan1' => $tambahan1,
					'komponen_bobot_tambahan1' => $bobot_tambahan1,
					'komponen_skor_tambahan1' => $skor_tambahan1,
					'komponen_nilai_tambahan1' => $nilai_tambahan1,

					'komponen_keterangan_tambahan2' => $tambahan2,
					'komponen_bobot_tambahan2' => $bobot_tambahan2,
					'komponen_skor_tambahan2' => $skor_tambahan2,
					'komponen_nilai_tambahan2' => $nilai_tambahan2,

					'komponen_keterangan_tambahan3' => $tambahan3,
					'komponen_bobot_tambahan3' => $bobot_tambahan3,
					'komponen_skor_tambahan3' => $skor_tambahan3,
					'komponen_nilai_tambahan3' => $nilai_tambahan3,

					'komponen_keterangan_tambahan4' => $tambahan4,
					'komponen_bobot_tambahan4' => $bobot_tambahan4,
					'komponen_skor_tambahan4' => $skor_tambahan4,
					'komponen_nilai_tambahan4' => $nilai_tambahan4,

					'komponen_keterangan_tambahan5' => $tambahan5,
					'komponen_bobot_tambahan5' => $bobot_tambahan5,
					'komponen_skor_tambahan5' => $skor_tambahan5,
					'komponen_nilai_tambahan5' => $nilai_tambahan5,

					'komponen_keterangan_tambahan6' => $tambahan6,
					'komponen_bobot_tambahan6' => $bobot_tambahan6,
					'komponen_skor_tambahan6' => $skor_tambahan6,
					'komponen_nilai_tambahan6' => $nilai_tambahan6,

					'komponen_keterangan_tambahan7' => $tambahan7,
					'komponen_bobot_tambahan7' => $bobot_tambahan7,
					'komponen_skor_tambahan7' => $skor_tambahan7,
					'komponen_nilai_tambahan7' => $nilai_tambahan7,

					'komponen_keterangan_tambahan8' => $tambahan8,
					'komponen_bobot_tambahan8' => $bobot_tambahan8,
					'komponen_skor_tambahan8' => $skor_tambahan8,
					'komponen_nilai_tambahan8' => $nilai_tambahan8,

					'total_nilai_wajib' => $total,
			);

			$data_rekomendasi = array(
					'id_kerjaan_monev' => $id_kerjaan,
					// 'rekomendasi' => $rekomendasi,
					'masukan_pemonev' => $masukan

			);
			$this->db->set('created_at', 'NOW()', FALSE);
			$this->db->set('updated_at', 'NOW()', FALSE);

			$this->pemonev->insert('laporan_pemonev', $data_laporan);
			$this->pemonev->insert('masukan_pemonev', $data_rekomendasi);
			$this->pemonev->update_status_kerjaan($id_kerjaan);
			$this->db->trans_complete();
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Simpan Monev');
			redirect('C_dashboard');
			// return;
	}

	public function edit_monev_ptm()
	{
		// $rekomendasi = $_POST['rekomendasi'];
		$masukan = $_POST['masukan'];

		$keterangan1 = $_POST['keterangan1'];
		$bobot1 = $_POST['ket1_bobot'];
		$skor1 = $_POST['ket1_skor'];
		$nilai1 = $_POST['ket1_nilai'];

		$keterangan2 = $_POST['keterangan2'];
		$bobot2 = $_POST['ket2_bobot'];
		$skor2 = $_POST['ket2_skor'];
		$nilai2 = $_POST['ket2_nilai'];

		$keterangan3 = $_POST['keterangan3'];
		$bobot3 = $_POST['ket3_bobot'];
		$skor3 = $_POST['ket3_skor'];
		$nilai3 = $_POST['ket3_nilai'];

		$keterangan4 = $_POST['keterangan4'];
		$bobot4 = $_POST['ket4_bobot'];
		$skor4 = $_POST['ket4_skor'];
		$nilai4 = $_POST['ket4_nilai'];

		// $keterangan5 = $_POST['keterangan5'];
		// $bobot5 = $_POST['ket5_bobot'];
		// $skor5 = $_POST['ket5_skor'];
		// $nilai5 = $_POST['ket5_nilai'];

		$tambahan1 = $_POST['tambahan1'];
		$bobot_tambahan1 = $_POST['tambahan1_bobot'];
		$skor_tambahan1 = $_POST['tambahan1_skor'];
		$nilai_tambahan1 = $_POST['tambahan1_nilai'];

		$tambahan2 = $_POST['tambahan2'];
		$bobot_tambahan2 = $_POST['tambahan2_bobot'];
		$skor_tambahan2 = $_POST['tambahan2_skor'];
		$nilai_tambahan2 = $_POST['tambahan2_nilai'];

		$tambahan3 = $_POST['tambahan3'];
		$bobot_tambahan3 = $_POST['tambahan3_bobot'];
		$skor_tambahan3 = $_POST['tambahan3_skor'];
		$nilai_tambahan3 = $_POST['tambahan3_nilai'];

		$tambahan4 = $_POST['tambahan4'];
		$bobot_tambahan4 = $_POST['tambahan4_bobot'];
		$skor_tambahan4 = $_POST['tambahan4_skor'];
		$nilai_tambahan4 = $_POST['tambahan4_nilai'];

		$tambahan5 = $_POST['tambahan5'];
		$bobot_tambahan5 = $_POST['tambahan5_bobot'];
		$skor_tambahan5 = $_POST['tambahan5_skor'];
		$nilai_tambahan5 = $_POST['tambahan5_nilai'];

		$tambahan6 = $_POST['tambahan6'];
		$bobot_tambahan6 = $_POST['tambahan6_bobot'];
		$skor_tambahan6 = $_POST['tambahan6_skor'];
		$nilai_tambahan6 = $_POST['tambahan6_nilai'];

		$tambahan7 = $_POST['tambahan7'];
		$bobot_tambahan7 = $_POST['tambahan7_bobot'];
		$skor_tambahan7 = $_POST['tambahan7_skor'];
		$nilai_tambahan7 = $_POST['tambahan7_nilai'];

		$tambahan8 = $_POST['tambahan8'];
		$bobot_tambahan8 = $_POST['tambahan8_bobot'];
		$skor_tambahan8 = $_POST['tambahan8_skor'];
		$nilai_tambahan8 = $_POST['tambahan8_nilai'];

		$total = $_POST['total_nilai_luaran_wajib'];

		// unset($_POST['rekomendasi']);
		$id_kerjaan_monev = $_POST['id_kerjaan_monev'];
		$cek_kerjaan = $this->pemonev->cek_kerjaan($id_kerjaan_monev);

		if ($cek_kerjaan === null) {
				echo 'Tidak Bisa';
				return;
		} else {
				if ($cek_kerjaan->kerjaan_selesai != 1) {
						echo 'Error';
						return;
				}
		}

		$dt_laporan = [
			'id_kerjaan_monev' => $id_kerjaan_monev,

			'komponen_keterangan1' => $keterangan1,
			'komponen_bobot1' => $bobot1,
			'komponen_skor1' => $skor1,
			'komponen_nilai1' => $nilai1,

			'komponen_keterangan2' => $keterangan2,
			'komponen_bobot2' => $bobot2,
			'komponen_skor2' => $skor2,
			'komponen_nilai2' => $nilai2,

			'komponen_keterangan3' => $keterangan3,
			'komponen_bobot3' => $bobot3,
			'komponen_skor3' => $skor3,
			'komponen_nilai3' => $nilai3,

			'komponen_keterangan4' => $keterangan4,
			'komponen_bobot4' => $bobot4,
			'komponen_skor4' => $skor4,
			'komponen_nilai4' => $nilai4,

			// 'komponen_keterangan5' => $keterangan5,
			// 'komponen_bobot5' => $bobot5,
			// 'komponen_skor5' => $skor5,
			// 'komponen_nilai5' => $nilai5,

			'komponen_keterangan_tambahan1' => $tambahan1,
			'komponen_bobot_tambahan1' => $bobot_tambahan1,
			'komponen_skor_tambahan1' => $skor_tambahan1,
			'komponen_nilai_tambahan1' => $nilai_tambahan1,

			'komponen_keterangan_tambahan2' => $tambahan2,
			'komponen_bobot_tambahan2' => $bobot_tambahan2,
			'komponen_skor_tambahan2' => $skor_tambahan2,
			'komponen_nilai_tambahan2' => $nilai_tambahan2,

			'komponen_keterangan_tambahan3' => $tambahan3,
			'komponen_bobot_tambahan3' => $bobot_tambahan3,
			'komponen_skor_tambahan3' => $skor_tambahan3,
			'komponen_nilai_tambahan3' => $nilai_tambahan3,

			'komponen_keterangan_tambahan4' => $tambahan4,
			'komponen_bobot_tambahan4' => $bobot_tambahan4,
			'komponen_skor_tambahan4' => $skor_tambahan4,
			'komponen_nilai_tambahan4' => $nilai_tambahan4,

			'komponen_keterangan_tambahan5' => $tambahan5,
			'komponen_bobot_tambahan5' => $bobot_tambahan5,
			'komponen_skor_tambahan5' => $skor_tambahan5,
			'komponen_nilai_tambahan5' => $nilai_tambahan5,

			'komponen_keterangan_tambahan6' => $tambahan6,
			'komponen_bobot_tambahan6' => $bobot_tambahan6,
			'komponen_skor_tambahan6' => $skor_tambahan6,
			'komponen_nilai_tambahan6' => $nilai_tambahan6,

			'komponen_keterangan_tambahan7' => $tambahan7,
			'komponen_bobot_tambahan7' => $bobot_tambahan7,
			'komponen_skor_tambahan7' => $skor_tambahan7,
			'komponen_nilai_tambahan7' => $nilai_tambahan7,

			'komponen_keterangan_tambahan8' => $tambahan8,
			'komponen_bobot_tambahan8' => $bobot_tambahan8,
			'komponen_skor_tambahan8' => $skor_tambahan8,
			'komponen_nilai_tambahan8' => $nilai_tambahan8,

			'total_nilai_wajib' => $total,
		];

		$dt_masukan = ['id_kerjaan_monev' => $id_kerjaan_monev, 'masukan_pemonev' => $masukan];
		$this->pemonev->update_laporan_PTM($dt_laporan);
		$this->pemonev->update_masukan($dt_masukan);

		$this->session->set_flashdata('success', 'Berhasil Edit Monev');
		redirect('C_dashboard');
		// print_r($_POST['jawaban-1']);
	}

	public function simpan_monev_pdp()
	{
			// $rekomendasi = $_POST['rekomendasi'];
			$masukan = $_POST['masukan'];

			$nama_ketua = $_POST['nama_ketua'];
			$jenis_proposal = $_POST['jenis_proposal'];

			$keterangan1 = $_POST['keterangan1'];
			$bobot1 = $_POST['ket1_bobot'];
			$skor1 = $_POST['ket1_skor'];
			$nilai1 = $_POST['ket1_nilai'];

			$keterangan2 = $_POST['keterangan2'];
			$bobot2 = $_POST['ket2_bobot'];
			$skor2 = $_POST['ket2_skor'];
			$nilai2 = $_POST['ket2_nilai'];

			$keterangan3 = $_POST['keterangan3'];
			$bobot3 = $_POST['ket3_bobot'];
			$skor3 = $_POST['ket3_skor'];
			$nilai3 = $_POST['ket3_nilai'];

			// $keterangan4 = $_POST['keterangan4'];
			// $bobot4 = $_POST['ket4_bobot'];
			// $skor4 = $_POST['ket4_skor'];
			// $nilai4 = $_POST['ket4_nilai'];

			// $keterangan5 = $_POST['keterangan5'];
			// $bobot5 = $_POST['ket5_bobot'];
			// $skor5 = $_POST['ket5_skor'];
			// $nilai5 = $_POST['ket5_nilai'];
			//
			// $keterangan6 = $_POST['keterangan6'];
			// $bobot6 = $_POST['ket6_bobot'];
			// $skor6 = $_POST['ket6_skor'];
			// $nilai6 = $_POST['ket6_nilai'];

			$tambahan1 = $_POST['tambahan1'];
			$bobot_tambahan1 = $_POST['tambahan1_bobot'];
			$skor_tambahan1 = $_POST['tambahan1_skor'];
			$nilai_tambahan1 = $_POST['tambahan1_nilai'];

			$tambahan2 = $_POST['tambahan2'];
			$bobot_tambahan2 = $_POST['tambahan2_bobot'];
			$skor_tambahan2 = $_POST['tambahan2_skor'];
			$nilai_tambahan2 = $_POST['tambahan2_nilai'];

			$tambahan3 = $_POST['tambahan3'];
			$bobot_tambahan3 = $_POST['tambahan3_bobot'];
			$skor_tambahan3 = $_POST['tambahan3_skor'];
			$nilai_tambahan3 = $_POST['tambahan3_nilai'];

			$tambahan4 = $_POST['tambahan4'];
			$bobot_tambahan4 = $_POST['tambahan4_bobot'];
			$skor_tambahan4 = $_POST['tambahan4_skor'];
			$nilai_tambahan4 = $_POST['tambahan4_nilai'];

			$tambahan5 = $_POST['tambahan5'];
			$bobot_tambahan5 = $_POST['tambahan5_bobot'];
			$skor_tambahan5 = $_POST['tambahan5_skor'];
			$nilai_tambahan5 = $_POST['tambahan5_nilai'];

			$tambahan6 = $_POST['tambahan6'];
			$bobot_tambahan6 = $_POST['tambahan6_bobot'];
			$skor_tambahan6 = $_POST['tambahan6_skor'];
			$nilai_tambahan6 = $_POST['tambahan6_nilai'];

			$tambahan7 = $_POST['tambahan7'];
			$bobot_tambahan7 = $_POST['tambahan7_bobot'];
			$skor_tambahan7 = $_POST['tambahan7_skor'];
			$nilai_tambahan7 = $_POST['tambahan7_nilai'];

			$tambahan8 = $_POST['tambahan8'];
			$bobot_tambahan8 = $_POST['tambahan8_bobot'];
			$skor_tambahan8 = $_POST['tambahan8_skor'];
			$nilai_tambahan8 = $_POST['tambahan8_nilai'];

			$total = $_POST['total_nilai_luaran_wajib'];

			$id_kerjaan = $_POST['id_kerjaan_monev'];
			$cek_kerjaan = $this->pemonev->cek_kerjaan($id_kerjaan);

			if ($cek_kerjaan === null) {
					echo 'Tidak Bisa';
					return;
			} else {
					if ($cek_kerjaan->kerjaan_selesai == 1) {
							echo 'Tidak Bisa';
							return;
					}
			}

			$this->db->trans_start();

			$data_laporan = array(
					'id_kerjaan_monev' => $id_kerjaan,
					'nama_ketua' => $nama_ketua,
					'jenis_proposal' => $jenis_proposal,

					'komponen_keterangan1' => $keterangan1,
					'komponen_bobot1' => $bobot1,
					'komponen_skor1' => $skor1,
					'komponen_nilai1' => $nilai1,

					'komponen_keterangan2' => $keterangan2,
					'komponen_bobot2' => $bobot2,
					'komponen_skor2' => $skor2,
					'komponen_nilai2' => $nilai2,

					'komponen_keterangan3' => $keterangan3,
					'komponen_bobot3' => $bobot3,
					'komponen_skor3' => $skor3,
					'komponen_nilai3' => $nilai3,

					// 'komponen_keterangan4' => $keterangan4,
					// 'komponen_bobot4' => $bobot4,
					// 'komponen_skor4' => $skor4,
					// 'komponen_nilai4' => $nilai4,

					// 'komponen_keterangan5' => $keterangan5,
					// 'komponen_bobot5' => $bobot5,
					// 'komponen_skor5' => $skor5,
					// 'komponen_nilai5' => $nilai5,
					//
					// 'komponen_keterangan6' => $keterangan6,
					// 'komponen_bobot6' => $bobot6,
					// 'komponen_skor6' => $skor6,
					// 'komponen_nilai6' => $nilai6,

					'komponen_keterangan_tambahan1' => $tambahan1,
					'komponen_bobot_tambahan1' => $bobot_tambahan1,
					'komponen_skor_tambahan1' => $skor_tambahan1,
					'komponen_nilai_tambahan1' => $nilai_tambahan1,

					'komponen_keterangan_tambahan2' => $tambahan2,
					'komponen_bobot_tambahan2' => $bobot_tambahan2,
					'komponen_skor_tambahan2' => $skor_tambahan2,
					'komponen_nilai_tambahan2' => $nilai_tambahan2,

					'komponen_keterangan_tambahan3' => $tambahan3,
					'komponen_bobot_tambahan3' => $bobot_tambahan3,
					'komponen_skor_tambahan3' => $skor_tambahan3,
					'komponen_nilai_tambahan3' => $nilai_tambahan3,

					'komponen_keterangan_tambahan4' => $tambahan4,
					'komponen_bobot_tambahan4' => $bobot_tambahan4,
					'komponen_skor_tambahan4' => $skor_tambahan4,
					'komponen_nilai_tambahan4' => $nilai_tambahan4,

					'komponen_keterangan_tambahan5' => $tambahan5,
					'komponen_bobot_tambahan5' => $bobot_tambahan5,
					'komponen_skor_tambahan5' => $skor_tambahan5,
					'komponen_nilai_tambahan5' => $nilai_tambahan5,

					'komponen_keterangan_tambahan6' => $tambahan6,
					'komponen_bobot_tambahan6' => $bobot_tambahan6,
					'komponen_skor_tambahan6' => $skor_tambahan6,
					'komponen_nilai_tambahan6' => $nilai_tambahan6,

					'komponen_keterangan_tambahan7' => $tambahan7,
					'komponen_bobot_tambahan7' => $bobot_tambahan7,
					'komponen_skor_tambahan7' => $skor_tambahan7,
					'komponen_nilai_tambahan7' => $nilai_tambahan7,

					'komponen_keterangan_tambahan8' => $tambahan8,
					'komponen_bobot_tambahan8' => $bobot_tambahan8,
					'komponen_skor_tambahan8' => $skor_tambahan8,
					'komponen_nilai_tambahan8' => $nilai_tambahan8,

					'total_nilai_wajib' => $total,
			);

			$data_rekomendasi = array(
					'id_kerjaan_monev' => $id_kerjaan,
					// 'rekomendasi' => $rekomendasi,
					'masukan_pemonev' => $masukan

			);
			$this->db->set('created_at', 'NOW()', FALSE);
			$this->db->set('updated_at', 'NOW()', FALSE);

			$this->pemonev->insert('laporan_pemonev', $data_laporan);
			$this->pemonev->insert('masukan_pemonev', $data_rekomendasi);
			$this->pemonev->update_status_kerjaan($id_kerjaan);
			$this->db->trans_complete();
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Simpan Monev');
			redirect('C_dashboard');
			// return;
	}

	public function edit_monev_pdp()
	{
		// $rekomendasi = $_POST['rekomendasi'];
		$masukan = $_POST['masukan'];

		$keterangan1 = $_POST['keterangan1'];
		$bobot1 = $_POST['ket1_bobot'];
		$skor1 = $_POST['ket1_skor'];
		$nilai1 = $_POST['ket1_nilai'];

		$keterangan2 = $_POST['keterangan2'];
		$bobot2 = $_POST['ket2_bobot'];
		$skor2 = $_POST['ket2_skor'];
		$nilai2 = $_POST['ket2_nilai'];

		$keterangan3 = $_POST['keterangan3'];
		$bobot3 = $_POST['ket3_bobot'];
		$skor3 = $_POST['ket3_skor'];
		$nilai3 = $_POST['ket3_nilai'];

		// $keterangan4 = $_POST['keterangan4'];
		// $bobot4 = $_POST['ket4_bobot'];
		// $skor4 = $_POST['ket4_skor'];
		// $nilai4 = $_POST['ket4_nilai'];

		// $keterangan5 = $_POST['keterangan5'];
		// $bobot5 = $_POST['ket5_bobot'];
		// $skor5 = $_POST['ket5_skor'];
		// $nilai5 = $_POST['ket5_nilai'];

		$tambahan1 = $_POST['tambahan1'];
		$bobot_tambahan1 = $_POST['tambahan1_bobot'];
		$skor_tambahan1 = $_POST['tambahan1_skor'];
		$nilai_tambahan1 = $_POST['tambahan1_nilai'];

		$tambahan2 = $_POST['tambahan2'];
		$bobot_tambahan2 = $_POST['tambahan2_bobot'];
		$skor_tambahan2 = $_POST['tambahan2_skor'];
		$nilai_tambahan2 = $_POST['tambahan2_nilai'];

		$tambahan3 = $_POST['tambahan3'];
		$bobot_tambahan3 = $_POST['tambahan3_bobot'];
		$skor_tambahan3 = $_POST['tambahan3_skor'];
		$nilai_tambahan3 = $_POST['tambahan3_nilai'];

		$tambahan4 = $_POST['tambahan4'];
		$bobot_tambahan4 = $_POST['tambahan4_bobot'];
		$skor_tambahan4 = $_POST['tambahan4_skor'];
		$nilai_tambahan4 = $_POST['tambahan4_nilai'];

		$tambahan5 = $_POST['tambahan5'];
		$bobot_tambahan5 = $_POST['tambahan5_bobot'];
		$skor_tambahan5 = $_POST['tambahan5_skor'];
		$nilai_tambahan5 = $_POST['tambahan5_nilai'];

		$tambahan6 = $_POST['tambahan6'];
		$bobot_tambahan6 = $_POST['tambahan6_bobot'];
		$skor_tambahan6 = $_POST['tambahan6_skor'];
		$nilai_tambahan6 = $_POST['tambahan6_nilai'];

		$tambahan7 = $_POST['tambahan7'];
		$bobot_tambahan7 = $_POST['tambahan7_bobot'];
		$skor_tambahan7 = $_POST['tambahan7_skor'];
		$nilai_tambahan7 = $_POST['tambahan7_nilai'];

		$tambahan8 = $_POST['tambahan8'];
		$bobot_tambahan8 = $_POST['tambahan8_bobot'];
		$skor_tambahan8 = $_POST['tambahan8_skor'];
		$nilai_tambahan8 = $_POST['tambahan8_nilai'];

		$total = $_POST['total_nilai_luaran_wajib'];

		// unset($_POST['rekomendasi']);
		$id_kerjaan_monev = $_POST['id_kerjaan_monev'];
		$cek_kerjaan = $this->pemonev->cek_kerjaan($id_kerjaan_monev);

		if ($cek_kerjaan === null) {
				echo 'Tidak Bisa';
				return;
		} else {
				if ($cek_kerjaan->kerjaan_selesai != 1) {
						echo 'Error';
						return;
				}
		}

		$dt_laporan = [
			'id_kerjaan_monev' => $id_kerjaan_monev,

			'komponen_keterangan1' => $keterangan1,
			'komponen_bobot1' => $bobot1,
			'komponen_skor1' => $skor1,
			'komponen_nilai1' => $nilai1,

			'komponen_keterangan2' => $keterangan2,
			'komponen_bobot2' => $bobot2,
			'komponen_skor2' => $skor2,
			'komponen_nilai2' => $nilai2,

			'komponen_keterangan3' => $keterangan3,
			'komponen_bobot3' => $bobot3,
			'komponen_skor3' => $skor3,
			'komponen_nilai3' => $nilai3,

			// 'komponen_keterangan4' => $keterangan4,
			// 'komponen_bobot4' => $bobot4,
			// 'komponen_skor4' => $skor4,
			// 'komponen_nilai4' => $nilai4,

			// 'komponen_keterangan5' => $keterangan5,
			// 'komponen_bobot5' => $bobot5,
			// 'komponen_skor5' => $skor5,
			// 'komponen_nilai5' => $nilai5,

			'komponen_keterangan_tambahan1' => $tambahan1,
			'komponen_bobot_tambahan1' => $bobot_tambahan1,
			'komponen_skor_tambahan1' => $skor_tambahan1,
			'komponen_nilai_tambahan1' => $nilai_tambahan1,

			'komponen_keterangan_tambahan2' => $tambahan2,
			'komponen_bobot_tambahan2' => $bobot_tambahan2,
			'komponen_skor_tambahan2' => $skor_tambahan2,
			'komponen_nilai_tambahan2' => $nilai_tambahan2,

			'komponen_keterangan_tambahan3' => $tambahan3,
			'komponen_bobot_tambahan3' => $bobot_tambahan3,
			'komponen_skor_tambahan3' => $skor_tambahan3,
			'komponen_nilai_tambahan3' => $nilai_tambahan3,

			'komponen_keterangan_tambahan4' => $tambahan4,
			'komponen_bobot_tambahan4' => $bobot_tambahan4,
			'komponen_skor_tambahan4' => $skor_tambahan4,
			'komponen_nilai_tambahan4' => $nilai_tambahan4,

			'komponen_keterangan_tambahan5' => $tambahan5,
			'komponen_bobot_tambahan5' => $bobot_tambahan5,
			'komponen_skor_tambahan5' => $skor_tambahan5,
			'komponen_nilai_tambahan5' => $nilai_tambahan5,

			'komponen_keterangan_tambahan6' => $tambahan6,
			'komponen_bobot_tambahan6' => $bobot_tambahan6,
			'komponen_skor_tambahan6' => $skor_tambahan6,
			'komponen_nilai_tambahan6' => $nilai_tambahan6,

			'komponen_keterangan_tambahan7' => $tambahan7,
			'komponen_bobot_tambahan7' => $bobot_tambahan7,
			'komponen_skor_tambahan7' => $skor_tambahan7,
			'komponen_nilai_tambahan7' => $nilai_tambahan7,

			'komponen_keterangan_tambahan8' => $tambahan8,
			'komponen_bobot_tambahan8' => $bobot_tambahan8,
			'komponen_skor_tambahan8' => $skor_tambahan8,
			'komponen_nilai_tambahan8' => $nilai_tambahan8,

			'total_nilai_wajib' => $total,
		];

		$dt_masukan = ['id_kerjaan_monev' => $id_kerjaan_monev, 'masukan_pemonev' => $masukan];
		$this->pemonev->update_laporan_PDP($dt_laporan);
		$this->pemonev->update_masukan($dt_masukan);

		$this->session->set_flashdata('success', 'Berhasil Edit Monev');
		redirect('C_dashboard');
		// print_r($_POST['jawaban-1']);
	}

	public function simpan_monev_plp()
	{
			// $rekomendasi = $_POST['rekomendasi'];
			$masukan = $_POST['masukan'];

			$nama_ketua = $_POST['nama_ketua'];
			$jenis_proposal = $_POST['jenis_proposal'];

			$keterangan1 = $_POST['keterangan1'];
			$bobot1 = $_POST['ket1_bobot'];
			$skor1 = $_POST['ket1_skor'];
			$nilai1 = $_POST['ket1_nilai'];

			// $keterangan4 = $_POST['keterangan4'];
			// $bobot4 = $_POST['ket4_bobot'];
			// $skor4 = $_POST['ket4_skor'];
			// $nilai4 = $_POST['ket4_nilai'];

			// $keterangan5 = $_POST['keterangan5'];
			// $bobot5 = $_POST['ket5_bobot'];
			// $skor5 = $_POST['ket5_skor'];
			// $nilai5 = $_POST['ket5_nilai'];
			//
			// $keterangan6 = $_POST['keterangan6'];
			// $bobot6 = $_POST['ket6_bobot'];
			// $skor6 = $_POST['ket6_skor'];
			// $nilai6 = $_POST['ket6_nilai'];

			$tambahan1 = $_POST['tambahan1'];
			$bobot_tambahan1 = $_POST['tambahan1_bobot'];
			$skor_tambahan1 = $_POST['tambahan1_skor'];
			$nilai_tambahan1 = $_POST['tambahan1_nilai'];

			$tambahan2 = $_POST['tambahan2'];
			$bobot_tambahan2 = $_POST['tambahan2_bobot'];
			$skor_tambahan2 = $_POST['tambahan2_skor'];
			$nilai_tambahan2 = $_POST['tambahan2_nilai'];

			$tambahan3 = $_POST['tambahan3'];
			$bobot_tambahan3 = $_POST['tambahan3_bobot'];
			$skor_tambahan3 = $_POST['tambahan3_skor'];
			$nilai_tambahan3 = $_POST['tambahan3_nilai'];

			$tambahan4 = $_POST['tambahan4'];
			$bobot_tambahan4 = $_POST['tambahan4_bobot'];
			$skor_tambahan4 = $_POST['tambahan4_skor'];
			$nilai_tambahan4 = $_POST['tambahan4_nilai'];

			$tambahan5 = $_POST['tambahan5'];
			$bobot_tambahan5 = $_POST['tambahan5_bobot'];
			$skor_tambahan5 = $_POST['tambahan5_skor'];
			$nilai_tambahan5 = $_POST['tambahan5_nilai'];

			$tambahan6 = $_POST['tambahan6'];
			$bobot_tambahan6 = $_POST['tambahan6_bobot'];
			$skor_tambahan6 = $_POST['tambahan6_skor'];
			$nilai_tambahan6 = $_POST['tambahan6_nilai'];

			$tambahan7 = $_POST['tambahan7'];
			$bobot_tambahan7 = $_POST['tambahan7_bobot'];
			$skor_tambahan7 = $_POST['tambahan7_skor'];
			$nilai_tambahan7 = $_POST['tambahan7_nilai'];

			$tambahan8 = $_POST['tambahan8'];
			$bobot_tambahan8 = $_POST['tambahan8_bobot'];
			$skor_tambahan8 = $_POST['tambahan8_skor'];
			$nilai_tambahan8 = $_POST['tambahan8_nilai'];

			$total = $_POST['total_nilai_luaran_wajib'];

			$id_kerjaan = $_POST['id_kerjaan_monev'];
			$cek_kerjaan = $this->pemonev->cek_kerjaan($id_kerjaan);

			if ($cek_kerjaan === null) {
					echo 'Tidak Bisa';
					return;
			} else {
					if ($cek_kerjaan->kerjaan_selesai == 1) {
							echo 'Tidak Bisa';
							return;
					}
			}

			$this->db->trans_start();

			$data_laporan = array(
					'id_kerjaan_monev' => $id_kerjaan,
					'nama_ketua' => $nama_ketua,
					'jenis_proposal' => $jenis_proposal,

					'komponen_keterangan1' => $keterangan1,
					'komponen_bobot1' => $bobot1,
					'komponen_skor1' => $skor1,
					'komponen_nilai1' => $nilai1,

					// 'komponen_keterangan4' => $keterangan4,
					// 'komponen_bobot4' => $bobot4,
					// 'komponen_skor4' => $skor4,
					// 'komponen_nilai4' => $nilai4,

					// 'komponen_keterangan5' => $keterangan5,
					// 'komponen_bobot5' => $bobot5,
					// 'komponen_skor5' => $skor5,
					// 'komponen_nilai5' => $nilai5,
					//
					// 'komponen_keterangan6' => $keterangan6,
					// 'komponen_bobot6' => $bobot6,
					// 'komponen_skor6' => $skor6,
					// 'komponen_nilai6' => $nilai6,

					'komponen_keterangan_tambahan1' => $tambahan1,
					'komponen_bobot_tambahan1' => $bobot_tambahan1,
					'komponen_skor_tambahan1' => $skor_tambahan1,
					'komponen_nilai_tambahan1' => $nilai_tambahan1,

					'komponen_keterangan_tambahan2' => $tambahan2,
					'komponen_bobot_tambahan2' => $bobot_tambahan2,
					'komponen_skor_tambahan2' => $skor_tambahan2,
					'komponen_nilai_tambahan2' => $nilai_tambahan2,

					'komponen_keterangan_tambahan3' => $tambahan3,
					'komponen_bobot_tambahan3' => $bobot_tambahan3,
					'komponen_skor_tambahan3' => $skor_tambahan3,
					'komponen_nilai_tambahan3' => $nilai_tambahan3,

					'komponen_keterangan_tambahan4' => $tambahan4,
					'komponen_bobot_tambahan4' => $bobot_tambahan4,
					'komponen_skor_tambahan4' => $skor_tambahan4,
					'komponen_nilai_tambahan4' => $nilai_tambahan4,

					'komponen_keterangan_tambahan5' => $tambahan5,
					'komponen_bobot_tambahan5' => $bobot_tambahan5,
					'komponen_skor_tambahan5' => $skor_tambahan5,
					'komponen_nilai_tambahan5' => $nilai_tambahan5,

					'komponen_keterangan_tambahan6' => $tambahan6,
					'komponen_bobot_tambahan6' => $bobot_tambahan6,
					'komponen_skor_tambahan6' => $skor_tambahan6,
					'komponen_nilai_tambahan6' => $nilai_tambahan6,

					'komponen_keterangan_tambahan7' => $tambahan7,
					'komponen_bobot_tambahan7' => $bobot_tambahan7,
					'komponen_skor_tambahan7' => $skor_tambahan7,
					'komponen_nilai_tambahan7' => $nilai_tambahan7,

					'komponen_keterangan_tambahan8' => $tambahan8,
					'komponen_bobot_tambahan8' => $bobot_tambahan8,
					'komponen_skor_tambahan8' => $skor_tambahan8,
					'komponen_nilai_tambahan8' => $nilai_tambahan8,

					'total_nilai_wajib' => $total,
			);

			$data_rekomendasi = array(
					'id_kerjaan_monev' => $id_kerjaan,
					// 'rekomendasi' => $rekomendasi,
					'masukan_pemonev' => $masukan

			);
			$this->db->set('created_at', 'NOW()', FALSE);
			$this->db->set('updated_at', 'NOW()', FALSE);

			$this->pemonev->insert('laporan_pemonev', $data_laporan);
			$this->pemonev->insert('masukan_pemonev', $data_rekomendasi);
			$this->pemonev->update_status_kerjaan($id_kerjaan);
			$this->db->trans_complete();
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Simpan Monev');
			redirect('C_dashboard');
			// return;
	}

	public function edit_monev_plp()
	{
		// $rekomendasi = $_POST['rekomendasi'];
		$masukan = $_POST['masukan'];

		$keterangan1 = $_POST['keterangan1'];
		$bobot1 = $_POST['ket1_bobot'];
		$skor1 = $_POST['ket1_skor'];
		$nilai1 = $_POST['ket1_nilai'];

		// $keterangan4 = $_POST['keterangan4'];
		// $bobot4 = $_POST['ket4_bobot'];
		// $skor4 = $_POST['ket4_skor'];
		// $nilai4 = $_POST['ket4_nilai'];

		// $keterangan5 = $_POST['keterangan5'];
		// $bobot5 = $_POST['ket5_bobot'];
		// $skor5 = $_POST['ket5_skor'];
		// $nilai5 = $_POST['ket5_nilai'];

		$tambahan1 = $_POST['tambahan1'];
		$bobot_tambahan1 = $_POST['tambahan1_bobot'];
		$skor_tambahan1 = $_POST['tambahan1_skor'];
		$nilai_tambahan1 = $_POST['tambahan1_nilai'];

		$tambahan2 = $_POST['tambahan2'];
		$bobot_tambahan2 = $_POST['tambahan2_bobot'];
		$skor_tambahan2 = $_POST['tambahan2_skor'];
		$nilai_tambahan2 = $_POST['tambahan2_nilai'];

		$tambahan3 = $_POST['tambahan3'];
		$bobot_tambahan3 = $_POST['tambahan3_bobot'];
		$skor_tambahan3 = $_POST['tambahan3_skor'];
		$nilai_tambahan3 = $_POST['tambahan3_nilai'];

		$tambahan4 = $_POST['tambahan4'];
		$bobot_tambahan4 = $_POST['tambahan4_bobot'];
		$skor_tambahan4 = $_POST['tambahan4_skor'];
		$nilai_tambahan4 = $_POST['tambahan4_nilai'];

		$tambahan5 = $_POST['tambahan5'];
		$bobot_tambahan5 = $_POST['tambahan5_bobot'];
		$skor_tambahan5 = $_POST['tambahan5_skor'];
		$nilai_tambahan5 = $_POST['tambahan5_nilai'];

		$tambahan6 = $_POST['tambahan6'];
		$bobot_tambahan6 = $_POST['tambahan6_bobot'];
		$skor_tambahan6 = $_POST['tambahan6_skor'];
		$nilai_tambahan6 = $_POST['tambahan6_nilai'];

		$tambahan7 = $_POST['tambahan7'];
		$bobot_tambahan7 = $_POST['tambahan7_bobot'];
		$skor_tambahan7 = $_POST['tambahan7_skor'];
		$nilai_tambahan7 = $_POST['tambahan7_nilai'];

		$tambahan8 = $_POST['tambahan8'];
		$bobot_tambahan8 = $_POST['tambahan8_bobot'];
		$skor_tambahan8 = $_POST['tambahan8_skor'];
		$nilai_tambahan8 = $_POST['tambahan8_nilai'];

		$total = $_POST['total_nilai_luaran_wajib'];

		// unset($_POST['rekomendasi']);
		$id_kerjaan_monev = $_POST['id_kerjaan_monev'];
		$cek_kerjaan = $this->pemonev->cek_kerjaan($id_kerjaan_monev);

		if ($cek_kerjaan === null) {
				echo 'Tidak Bisa';
				return;
		} else {
				if ($cek_kerjaan->kerjaan_selesai != 1) {
						echo 'Error';
						return;
				}
		}

		$dt_laporan = [
			'id_kerjaan_monev' => $id_kerjaan_monev,

			'komponen_keterangan1' => $keterangan1,
			'komponen_bobot1' => $bobot1,
			'komponen_skor1' => $skor1,
			'komponen_nilai1' => $nilai1,

			// 'komponen_keterangan4' => $keterangan4,
			// 'komponen_bobot4' => $bobot4,
			// 'komponen_skor4' => $skor4,
			// 'komponen_nilai4' => $nilai4,

			// 'komponen_keterangan5' => $keterangan5,
			// 'komponen_bobot5' => $bobot5,
			// 'komponen_skor5' => $skor5,
			// 'komponen_nilai5' => $nilai5,

			'komponen_keterangan_tambahan1' => $tambahan1,
			'komponen_bobot_tambahan1' => $bobot_tambahan1,
			'komponen_skor_tambahan1' => $skor_tambahan1,
			'komponen_nilai_tambahan1' => $nilai_tambahan1,

			'komponen_keterangan_tambahan2' => $tambahan2,
			'komponen_bobot_tambahan2' => $bobot_tambahan2,
			'komponen_skor_tambahan2' => $skor_tambahan2,
			'komponen_nilai_tambahan2' => $nilai_tambahan2,

			'komponen_keterangan_tambahan3' => $tambahan3,
			'komponen_bobot_tambahan3' => $bobot_tambahan3,
			'komponen_skor_tambahan3' => $skor_tambahan3,
			'komponen_nilai_tambahan3' => $nilai_tambahan3,

			'komponen_keterangan_tambahan4' => $tambahan4,
			'komponen_bobot_tambahan4' => $bobot_tambahan4,
			'komponen_skor_tambahan4' => $skor_tambahan4,
			'komponen_nilai_tambahan4' => $nilai_tambahan4,

			'komponen_keterangan_tambahan5' => $tambahan5,
			'komponen_bobot_tambahan5' => $bobot_tambahan5,
			'komponen_skor_tambahan5' => $skor_tambahan5,
			'komponen_nilai_tambahan5' => $nilai_tambahan5,

			'komponen_keterangan_tambahan6' => $tambahan6,
			'komponen_bobot_tambahan6' => $bobot_tambahan6,
			'komponen_skor_tambahan6' => $skor_tambahan6,
			'komponen_nilai_tambahan6' => $nilai_tambahan6,

			'komponen_keterangan_tambahan7' => $tambahan7,
			'komponen_bobot_tambahan7' => $bobot_tambahan7,
			'komponen_skor_tambahan7' => $skor_tambahan7,
			'komponen_nilai_tambahan7' => $nilai_tambahan7,

			'komponen_keterangan_tambahan8' => $tambahan8,
			'komponen_bobot_tambahan8' => $bobot_tambahan8,
			'komponen_skor_tambahan8' => $skor_tambahan8,
			'komponen_nilai_tambahan8' => $nilai_tambahan8,

			'total_nilai_wajib' => $total,
		];

		$dt_masukan = ['id_kerjaan_monev' => $id_kerjaan_monev, 'masukan_pemonev' => $masukan];
		$this->pemonev->update_laporan_PLP($dt_laporan);
		$this->pemonev->update_masukan($dt_masukan);

		$this->session->set_flashdata('success', 'Berhasil Edit Monev');
		redirect('C_dashboard');
		// print_r($_POST['jawaban-1']);
	}

	public function simpan_monev_pkk()
	{
			// $rekomendasi = $_POST['rekomendasi'];
			$masukan = $_POST['masukan'];

			$nama_ketua = $_POST['nama_ketua'];
			$jenis_proposal = $_POST['jenis_proposal'];

			$keterangan1 = $_POST['keterangan1'];
			$bobot1 = $_POST['ket1_bobot'];
			$skor1 = $_POST['ket1_skor'];
			$nilai1 = $_POST['ket1_nilai'];

			$keterangan2 = $_POST['keterangan2'];
			$bobot2 = $_POST['ket2_bobot'];
			$skor2 = $_POST['ket2_skor'];
			$nilai2 = $_POST['ket2_nilai'];

			$keterangan3 = $_POST['keterangan3'];
			$bobot3 = $_POST['ket3_bobot'];
			$skor3 = $_POST['ket3_skor'];
			$nilai3 = $_POST['ket3_nilai'];

			// $keterangan4 = $_POST['keterangan4'];
			// $bobot4 = $_POST['ket4_bobot'];
			// $skor4 = $_POST['ket4_skor'];
			// $nilai4 = $_POST['ket4_nilai'];

			// $keterangan5 = $_POST['keterangan5'];
			// $bobot5 = $_POST['ket5_bobot'];
			// $skor5 = $_POST['ket5_skor'];
			// $nilai5 = $_POST['ket5_nilai'];
			//
			// $keterangan6 = $_POST['keterangan6'];
			// $bobot6 = $_POST['ket6_bobot'];
			// $skor6 = $_POST['ket6_skor'];
			// $nilai6 = $_POST['ket6_nilai'];

			$tambahan1 = $_POST['tambahan1'];
			$bobot_tambahan1 = $_POST['tambahan1_bobot'];
			$skor_tambahan1 = $_POST['tambahan1_skor'];
			$nilai_tambahan1 = $_POST['tambahan1_nilai'];

			$tambahan2 = $_POST['tambahan2'];
			$bobot_tambahan2 = $_POST['tambahan2_bobot'];
			$skor_tambahan2 = $_POST['tambahan2_skor'];
			$nilai_tambahan2 = $_POST['tambahan2_nilai'];

			$tambahan3 = $_POST['tambahan3'];
			$bobot_tambahan3 = $_POST['tambahan3_bobot'];
			$skor_tambahan3 = $_POST['tambahan3_skor'];
			$nilai_tambahan3 = $_POST['tambahan3_nilai'];

			$tambahan4 = $_POST['tambahan4'];
			$bobot_tambahan4 = $_POST['tambahan4_bobot'];
			$skor_tambahan4 = $_POST['tambahan4_skor'];
			$nilai_tambahan4 = $_POST['tambahan4_nilai'];

			$tambahan5 = $_POST['tambahan5'];
			$bobot_tambahan5 = $_POST['tambahan5_bobot'];
			$skor_tambahan5 = $_POST['tambahan5_skor'];
			$nilai_tambahan5 = $_POST['tambahan5_nilai'];

			$tambahan6 = $_POST['tambahan6'];
			$bobot_tambahan6 = $_POST['tambahan6_bobot'];
			$skor_tambahan6 = $_POST['tambahan6_skor'];
			$nilai_tambahan6 = $_POST['tambahan6_nilai'];

			$tambahan7 = $_POST['tambahan7'];
			$bobot_tambahan7 = $_POST['tambahan7_bobot'];
			$skor_tambahan7 = $_POST['tambahan7_skor'];
			$nilai_tambahan7 = $_POST['tambahan7_nilai'];

			$tambahan8 = $_POST['tambahan8'];
			$bobot_tambahan8 = $_POST['tambahan8_bobot'];
			$skor_tambahan8 = $_POST['tambahan8_skor'];
			$nilai_tambahan8 = $_POST['tambahan8_nilai'];

			$total = $_POST['total_nilai_luaran_wajib'];

			$id_kerjaan = $_POST['id_kerjaan_monev'];
			$cek_kerjaan = $this->pemonev->cek_kerjaan($id_kerjaan);

			if ($cek_kerjaan === null) {
					echo 'Tidak Bisa';
					return;
			} else {
					if ($cek_kerjaan->kerjaan_selesai == 1) {
							echo 'Tidak Bisa';
							return;
					}
			}

			$this->db->trans_start();

			$data_laporan = array(
					'id_kerjaan_monev' => $id_kerjaan,
					'nama_ketua' => $nama_ketua,
					'jenis_proposal' => $jenis_proposal,

					'komponen_keterangan1' => $keterangan1,
					'komponen_bobot1' => $bobot1,
					'komponen_skor1' => $skor1,
					'komponen_nilai1' => $nilai1,

					'komponen_keterangan2' => $keterangan2,
					'komponen_bobot2' => $bobot2,
					'komponen_skor2' => $skor2,
					'komponen_nilai2' => $nilai2,

					'komponen_keterangan3' => $keterangan3,
					'komponen_bobot3' => $bobot3,
					'komponen_skor3' => $skor3,
					'komponen_nilai3' => $nilai3,

					// 'komponen_keterangan4' => $keterangan4,
					// 'komponen_bobot4' => $bobot4,
					// 'komponen_skor4' => $skor4,
					// 'komponen_nilai4' => $nilai4,

					// 'komponen_keterangan5' => $keterangan5,
					// 'komponen_bobot5' => $bobot5,
					// 'komponen_skor5' => $skor5,
					// 'komponen_nilai5' => $nilai5,
					//
					// 'komponen_keterangan6' => $keterangan6,
					// 'komponen_bobot6' => $bobot6,
					// 'komponen_skor6' => $skor6,
					// 'komponen_nilai6' => $nilai6,

					'komponen_keterangan_tambahan1' => $tambahan1,
					'komponen_bobot_tambahan1' => $bobot_tambahan1,
					'komponen_skor_tambahan1' => $skor_tambahan1,
					'komponen_nilai_tambahan1' => $nilai_tambahan1,

					'komponen_keterangan_tambahan2' => $tambahan2,
					'komponen_bobot_tambahan2' => $bobot_tambahan2,
					'komponen_skor_tambahan2' => $skor_tambahan2,
					'komponen_nilai_tambahan2' => $nilai_tambahan2,

					'komponen_keterangan_tambahan3' => $tambahan3,
					'komponen_bobot_tambahan3' => $bobot_tambahan3,
					'komponen_skor_tambahan3' => $skor_tambahan3,
					'komponen_nilai_tambahan3' => $nilai_tambahan3,

					'komponen_keterangan_tambahan4' => $tambahan4,
					'komponen_bobot_tambahan4' => $bobot_tambahan4,
					'komponen_skor_tambahan4' => $skor_tambahan4,
					'komponen_nilai_tambahan4' => $nilai_tambahan4,

					'komponen_keterangan_tambahan5' => $tambahan5,
					'komponen_bobot_tambahan5' => $bobot_tambahan5,
					'komponen_skor_tambahan5' => $skor_tambahan5,
					'komponen_nilai_tambahan5' => $nilai_tambahan5,

					'komponen_keterangan_tambahan6' => $tambahan6,
					'komponen_bobot_tambahan6' => $bobot_tambahan6,
					'komponen_skor_tambahan6' => $skor_tambahan6,
					'komponen_nilai_tambahan6' => $nilai_tambahan6,

					'komponen_keterangan_tambahan7' => $tambahan7,
					'komponen_bobot_tambahan7' => $bobot_tambahan7,
					'komponen_skor_tambahan7' => $skor_tambahan7,
					'komponen_nilai_tambahan7' => $nilai_tambahan7,

					'komponen_keterangan_tambahan8' => $tambahan8,
					'komponen_bobot_tambahan8' => $bobot_tambahan8,
					'komponen_skor_tambahan8' => $skor_tambahan8,
					'komponen_nilai_tambahan8' => $nilai_tambahan8,

					'total_nilai_wajib' => $total,
			);

			$data_rekomendasi = array(
					'id_kerjaan_monev' => $id_kerjaan,
					// 'rekomendasi' => $rekomendasi,
					'masukan_pemonev' => $masukan

			);
			$this->db->set('created_at', 'NOW()', FALSE);
			$this->db->set('updated_at', 'NOW()', FALSE);

			$this->pemonev->insert('laporan_pemonev', $data_laporan);
			$this->pemonev->insert('masukan_pemonev', $data_rekomendasi);
			$this->pemonev->update_status_kerjaan($id_kerjaan);
			$this->db->trans_complete();
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Simpan Monev');
			redirect('C_dashboard');
			// return;
	}

	public function edit_monev_pkk()
	{
		// $rekomendasi = $_POST['rekomendasi'];
		$masukan = $_POST['masukan'];

		$keterangan1 = $_POST['keterangan1'];
		$bobot1 = $_POST['ket1_bobot'];
		$skor1 = $_POST['ket1_skor'];
		$nilai1 = $_POST['ket1_nilai'];

		$keterangan2 = $_POST['keterangan2'];
		$bobot2 = $_POST['ket2_bobot'];
		$skor2 = $_POST['ket2_skor'];
		$nilai2 = $_POST['ket2_nilai'];

		$keterangan3 = $_POST['keterangan3'];
		$bobot3 = $_POST['ket3_bobot'];
		$skor3 = $_POST['ket3_skor'];
		$nilai3 = $_POST['ket3_nilai'];

		// $keterangan4 = $_POST['keterangan4'];
		// $bobot4 = $_POST['ket4_bobot'];
		// $skor4 = $_POST['ket4_skor'];
		// $nilai4 = $_POST['ket4_nilai'];

		// $keterangan5 = $_POST['keterangan5'];
		// $bobot5 = $_POST['ket5_bobot'];
		// $skor5 = $_POST['ket5_skor'];
		// $nilai5 = $_POST['ket5_nilai'];

		$tambahan1 = $_POST['tambahan1'];
		$bobot_tambahan1 = $_POST['tambahan1_bobot'];
		$skor_tambahan1 = $_POST['tambahan1_skor'];
		$nilai_tambahan1 = $_POST['tambahan1_nilai'];

		$tambahan2 = $_POST['tambahan2'];
		$bobot_tambahan2 = $_POST['tambahan2_bobot'];
		$skor_tambahan2 = $_POST['tambahan2_skor'];
		$nilai_tambahan2 = $_POST['tambahan2_nilai'];

		$tambahan3 = $_POST['tambahan3'];
		$bobot_tambahan3 = $_POST['tambahan3_bobot'];
		$skor_tambahan3 = $_POST['tambahan3_skor'];
		$nilai_tambahan3 = $_POST['tambahan3_nilai'];

		$tambahan4 = $_POST['tambahan4'];
		$bobot_tambahan4 = $_POST['tambahan4_bobot'];
		$skor_tambahan4 = $_POST['tambahan4_skor'];
		$nilai_tambahan4 = $_POST['tambahan4_nilai'];

		$tambahan5 = $_POST['tambahan5'];
		$bobot_tambahan5 = $_POST['tambahan5_bobot'];
		$skor_tambahan5 = $_POST['tambahan5_skor'];
		$nilai_tambahan5 = $_POST['tambahan5_nilai'];

		$tambahan6 = $_POST['tambahan6'];
		$bobot_tambahan6 = $_POST['tambahan6_bobot'];
		$skor_tambahan6 = $_POST['tambahan6_skor'];
		$nilai_tambahan6 = $_POST['tambahan6_nilai'];

		$tambahan7 = $_POST['tambahan7'];
		$bobot_tambahan7 = $_POST['tambahan7_bobot'];
		$skor_tambahan7 = $_POST['tambahan7_skor'];
		$nilai_tambahan7 = $_POST['tambahan7_nilai'];

		$tambahan8 = $_POST['tambahan8'];
		$bobot_tambahan8 = $_POST['tambahan8_bobot'];
		$skor_tambahan8 = $_POST['tambahan8_skor'];
		$nilai_tambahan8 = $_POST['tambahan8_nilai'];

		$total = $_POST['total_nilai_luaran_wajib'];

		// unset($_POST['rekomendasi']);
		$id_kerjaan_monev = $_POST['id_kerjaan_monev'];
		$cek_kerjaan = $this->pemonev->cek_kerjaan($id_kerjaan_monev);

		if ($cek_kerjaan === null) {
				echo 'Tidak Bisa';
				return;
		} else {
				if ($cek_kerjaan->kerjaan_selesai != 1) {
						echo 'Error';
						return;
				}
		}

		$dt_laporan = [
			'id_kerjaan_monev' => $id_kerjaan_monev,

			'komponen_keterangan1' => $keterangan1,
			'komponen_bobot1' => $bobot1,
			'komponen_skor1' => $skor1,
			'komponen_nilai1' => $nilai1,

			'komponen_keterangan2' => $keterangan2,
			'komponen_bobot2' => $bobot2,
			'komponen_skor2' => $skor2,
			'komponen_nilai2' => $nilai2,

			'komponen_keterangan3' => $keterangan3,
			'komponen_bobot3' => $bobot3,
			'komponen_skor3' => $skor3,
			'komponen_nilai3' => $nilai3,

			// 'komponen_keterangan4' => $keterangan4,
			// 'komponen_bobot4' => $bobot4,
			// 'komponen_skor4' => $skor4,
			// 'komponen_nilai4' => $nilai4,

			// 'komponen_keterangan5' => $keterangan5,
			// 'komponen_bobot5' => $bobot5,
			// 'komponen_skor5' => $skor5,
			// 'komponen_nilai5' => $nilai5,

			'komponen_keterangan_tambahan1' => $tambahan1,
			'komponen_bobot_tambahan1' => $bobot_tambahan1,
			'komponen_skor_tambahan1' => $skor_tambahan1,
			'komponen_nilai_tambahan1' => $nilai_tambahan1,

			'komponen_keterangan_tambahan2' => $tambahan2,
			'komponen_bobot_tambahan2' => $bobot_tambahan2,
			'komponen_skor_tambahan2' => $skor_tambahan2,
			'komponen_nilai_tambahan2' => $nilai_tambahan2,

			'komponen_keterangan_tambahan3' => $tambahan3,
			'komponen_bobot_tambahan3' => $bobot_tambahan3,
			'komponen_skor_tambahan3' => $skor_tambahan3,
			'komponen_nilai_tambahan3' => $nilai_tambahan3,

			'komponen_keterangan_tambahan4' => $tambahan4,
			'komponen_bobot_tambahan4' => $bobot_tambahan4,
			'komponen_skor_tambahan4' => $skor_tambahan4,
			'komponen_nilai_tambahan4' => $nilai_tambahan4,

			'komponen_keterangan_tambahan5' => $tambahan5,
			'komponen_bobot_tambahan5' => $bobot_tambahan5,
			'komponen_skor_tambahan5' => $skor_tambahan5,
			'komponen_nilai_tambahan5' => $nilai_tambahan5,

			'komponen_keterangan_tambahan6' => $tambahan6,
			'komponen_bobot_tambahan6' => $bobot_tambahan6,
			'komponen_skor_tambahan6' => $skor_tambahan6,
			'komponen_nilai_tambahan6' => $nilai_tambahan6,

			'komponen_keterangan_tambahan7' => $tambahan7,
			'komponen_bobot_tambahan7' => $bobot_tambahan7,
			'komponen_skor_tambahan7' => $skor_tambahan7,
			'komponen_nilai_tambahan7' => $nilai_tambahan7,

			'komponen_keterangan_tambahan8' => $tambahan8,
			'komponen_bobot_tambahan8' => $bobot_tambahan8,
			'komponen_skor_tambahan8' => $skor_tambahan8,
			'komponen_nilai_tambahan8' => $nilai_tambahan8,

			'total_nilai_wajib' => $total,
		];

		$dt_masukan = ['id_kerjaan_monev' => $id_kerjaan_monev, 'masukan_pemonev' => $masukan];
		$this->pemonev->update_laporan_PKK($dt_laporan);
		$this->pemonev->update_masukan($dt_masukan);

		$this->session->set_flashdata('success', 'Berhasil Edit Monev');
		redirect('C_dashboard');
		// print_r($_POST['jawaban-1']);
	}
}
