<?php

class C_evaluasi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('login') == true) {
			redirect('');
		}

		$this->load->model('M_Pemonev', 'pemonev');
		$this->load->model('M_reviewer', 'reviewer');
		$this->load->model('M_evaluasi', 'Mevaluasi');
		$this->load->model('M_fokus', 'Mfokus');
	}

	private function response($res)
	{

		$pesan = ['code' => $res[0], 'pesan' => $res[1]];

		return $pesan;
	}

	private function check_event_subjekEvaluasi($id_jenis_event)
	{

		$sql = "select id_list_event id_event, waktu_mulai mulai, waktu_akhir selesai from tb_list_event where id_jenis_event = $id_jenis_event AND id_tahapan = 12 AND (curdate() between waktu_mulai AND waktu_akhir) AND status = 1";
		$data = $this->db->query($sql)->row();

		return $data;
	}

	private function kerjaan_evaluasi($id_jenis_event)
	{
		$get_id_review = $this->pemonev->get_where("tb_pemonev", ["nidn" => $this->session->userdata('nidn')])->row();
		if ($get_id_review == null) {
			return false;
		}
		$selesai = [0, 1];
		$data_kirim = [];

		foreach ($selesai as $sl) {
			$data = $this->Mevaluasi->get_proposalByEvaluasi_revisi($get_id_review->id_pemonev, $sl, $id_jenis_event)->result();
			if ($sl === 0) {
				if ($data !== null) {
					$data_kirim['belum'] = $data;
				} else {
					$data_kirim['belum'] = null;
				}
			}

			if ($sl === 1) {
				if ($data !== null) {
					$data_kirim['sudah'] = $data;
				} else {
					$data_kirim['sudah'] = null;
				}
			}
		}

		return $data_kirim;
	}

	public function subjekEvaluasi($nama_event)
	{
		if ($nama_event == null) {
			echo "TIDAK BOLEH NULL";
		}
		$event = ["Penelitian_dosen" => 1, "Pengabdian_dosen" => 2, "Penelitian_plp" => 5,];

		if (!isset($event[$nama_event])) {
			echo "event tidak ada";
			return;
		}

		$data['content'] = VIEW_REVIEWER . 'evaluasi/content_kerjaan_evaluasi';
		$data['review'] = $this->kerjaan_evaluasi($event[$nama_event]);
		// data reviewer taruh sini
		$data['nama_event'] = str_replace("_", " ", $nama_event);
		$data['brdcrmb'] = 'Beranda';
		// $get_id = $this->pemonev->get_where("tb_pemonev",["nidn" => $this->session->userdata('nidn')])->row();
		// var_dump($get_id);
		$this->load->view('index', $data);
	}

	public function detail_objekEvaluasi($id)
	{
		// content
		$get_id_pemonev = $this->pemonev->get_where("tb_pemonev", ["nidn" => $this->session->userdata('nidn')])->row();
		if ($get_id_pemonev == null) {
			return false;
		}
		$username = $this->session->userdata('username');
		$data['content'] = VIEW_REVIEWER . 'evaluasi/content_detail_evaluasi';
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
			$data['status'] = $this->Mevaluasi->status_kerjaan_revisi($get_id_pemonev->id_pemonev, $data['dt_proposal']->id_pengajuan_detail);
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
		// var_dump($data['status']);
		$this->load->view('index', $data);
	}

	public function evaluasi_proposal($id, $event)
	{
		$username = $this->session->userdata('username');
		$data['username'] = $username;
		$data['judul'] = 'Evaluasi';
		$data['brdcrmb'] = 'Beranda / Evaluasi / Evaluasi Proposal';
		$data['idproposal'] = $id;
		$id_proposal = $this->Mevaluasi->get_id_proposal($id);
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
		$data['laporan_monev'] = $this->Mevaluasi->get_laporanPemonev($id_proposal->id_pengajuan_detail);
		$data['laporan_evaluasi'] = $this->Mevaluasi->get_laporanEvaluasi($id_proposal->id_pengajuan_detail);
		$data['berkas'] = $this->pemonev->dataBerkas_evaluasi_penelitian($id_proposal->id_pengajuan_detail);
		$data['masukan'] = $this->Mevaluasi->get_masukanEvaluasi($id);
		$data['kelompok_pengajuan'] = $kelompok_pengajuan;
		$data['id_pemonev'] = $get_id_pemonev;

		$detail = $this->reviewer->get_proposalnya($id_proposal->id_pengajuan_detail);

		if ($data['dt_proposal'] !== null) {
			$data['status'] = $this->Mevaluasi->status_kerjaan_revisi($get_id_pemonev->id_pemonev, $data['dt_proposal']->id_pengajuan_detail);
			// if ($data['status']->status == 1) {
			// 		$masukan = $this->Mevaluasi->get_masukan($data['status']->id_kerjaan_monev);

			// 		$data['masukan'] =  $masukan->masukan_evaluasi;
			// }
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
			$data['status'] = $this->Mevaluasi->status_kerjaan_revisi($get_id_pemonev->id_pemonev, $data['dt_proposal']->id_pengajuan_detail);
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
			$data['content'] = VIEW_REVIEWER . 'evaluasi/skema/pkln';
			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
		} elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "12") {
			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
			$data['content'] = VIEW_REVIEWER . 'evaluasi/skema/pvuj';
			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
		} elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "10") {
			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
			$data['content'] = VIEW_REVIEWER . 'evaluasi/skema/ptm';
			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
		} elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "11") {
			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
			$data['content'] = VIEW_REVIEWER . 'evaluasi/skema/kks';
			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
		} elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "2") {
			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
			$data['content'] = VIEW_REVIEWER . 'evaluasi/skema/pdp';
			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
		} elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "13") {
			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
			$data['content'] = VIEW_REVIEWER . 'evaluasi/skema/pkk';
			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
		} elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "9") {
			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
			$data['content'] = VIEW_REVIEWER . 'evaluasi/skema/plp';
			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
		} else {
			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
			$data['content'] = VIEW_REVIEWER . 'evaluasi/skema/pengabdian';
			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
		}

		// var_dump($data['masukan']);
		$this->load->view('index', $data);
	}

	// Admin Section
	public function pengevaluasi()
	{
		$username = $this->session->userdata('username');
		$data['content'] = VIEW_ADMIN . 'evaluasi/content_pengevaluasi';
		$data['username'] = $username;
		$data['judul'] = 'Pengevaluasi';
		$data['brdcrmb'] = 'Beranda / Evaluasi';
		$data['proposal'] = 0;
		$data['list_event'] = $this->reviewer->get_list_event();
		$data['dosen'] = $this->reviewer->get_all('dummy_dosen');
		// var_dump($data['dosen']);
		$this->load->view('index', $data);
	}
	public function get_tahun_proposal()
	{
		$post = $this->input->post();
		$id = $this->input->post('id_list_event');
		// $tahun = $this->input->post('tahun');
		$tahun = date('Y');
		$skema = "ALL";
		$fokus = "ALL";
		// $skema = $this->input->post('skema');
		// $fokus = $this->input->post('fokus');

		if (isset($post['skema'])) {
			if ($post['skema'] != "") {
				$skema = $this->input->post('skema');
			}
		}
		if (isset($post['fokus'])) {
			if ($post['fokus'] != "") {
				$fokus = $this->input->post('fokus');
			}
		}

		if (isset($post['tahun'])) {
			if ($post['tahun'] != "") {
				$tahun = $post['tahun'];
			}
		}

		$output = '';
		$get = $this->Mevaluasi->get_tahun_proposal($id, $tahun, $skema, $fokus);
		$no = 1;

		if ($get->num_rows() > 0) {
			foreach ($get->result() as $key) {
				// <td>' . substr(strip_tags(ucfirst(strtolower($key->judul))), 0, 60) . '...</td>

				$tgl_update = $key->updated_at == null ? "-" :  date('j F Y H:i:s', strtotime($key->updated_at));
				$tgl_unggah = $key->created_at == null ? "-" :  date('j F Y H:i:s', strtotime($key->created_at));
				$output .= '
                      <tr>
                        <td class="text-center">
                            <a href="' . base_url() . 'C_evaluasi/detailPengevaluasi/' . $key->id_pengajuan_detail . '" class="btn btn-sm btn-danger"> <i class="fa fa-paste"></i></a>
                        </td>
                        <td>' . $no . '.</td>
                        <td>' . $key->nama . '-' . $key->nidn . '</td>
                        <td>' . strip_tags(ucfirst(strtolower($key->judul))) . '</td>
                        <td>' . $key->tahun_usulan . '</td>
                        <td>' . $key->nama_kelompok . '</td>
                        <td>' . $tgl_unggah . '</td>
                        <td>' . $tgl_update . '</td>
                      </tr>';
				$no++;
			}
		} else {
			$output .= '
            <tr>
              <td colspan="8" style="text-align: center;">Belum Ada Data Proposal</td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            </tr>';
		}

		$data = [
			'datany' => $output,
			'code' => 1,
			'pesan' => 'berhasil'

		];

		echo json_encode($data);
		return;

		if ($id == 2) {
			$dt = $this->reviewer->get_proposal_mandiri_byEvent();
			foreach ($dt as $key) {
				$tgl_update = $key->updated_at == null ? "-" :  date('j F Y H:i:s', strtotime($key->updated_at));
				$tgl_unggah = $key->created_at == null ? "-" :  date('j F Y H:i:s', strtotime($key->created_at));
				$output .= '
                      <tr>
                        <td class="text-center">
                            <a href="' . base_url() . 'C_nilai_mandiri/index/' . $key->id_detail . '" class="btn btn-sm btn-danger"> <i class="fa fa-paste"></i></a>
                        </td>
                        <td>' . $no . '.</td>
                        <td>' . $key->nama . '-' . $key->nidn . '</td>
                        <td>' . strip_tags(ucfirst(strtolower($key->judul))) . '</td>
                        <td>' . $key->tahun_usulan . '</td>
                        <td>' . $key->nama_kelompok . '</td>
                        <td>' . $tgl_unggah . '</td>
                        <td>' . $tgl_update  . '</td>

                      </tr>';

				$no++;
			}
		} elseif ($id == 5) {
			$dt = $this->reviewer->get_proposal_mandiri_byEvent(2);
			foreach ($dt as $key) {
				$tgl_update =  $key->updated_at == null ? "-" :  date('j F Y H:i:s', strtotime($key->updated_at));
				$tgl_unggah = $key->created_at == null ? "-" :  date('j F Y H:i:s', strtotime($key->created_at));
				$output .= '
                      <tr>
                        <td class="text-center">
                            <a href="' . base_url() . 'C_nilai_mandiri/index/' . $key->id_detail . '" class="btn btn-sm btn-danger"> <i class="fa fa-paste"></i></a>
                        </td>
                        <td>' . $no . '.</td>
                        <td>' . $key->nama . '-' . $key->nidn . '</td>
                        <td>' . strip_tags(ucfirst(strtolower($key->judul))) . '</td>
                        <td>' . $key->tahun_usulan . '</td>
                        <td>' . $key->nama_kelompok . '</td>
                        <td>' . $tgl_unggah . '</td>
                        <td>' . $tgl_update . '</td>

                      </tr>';
				$no++;
			}
		} else {
			$output .= '
                    <tr>
                      <td colspan="8" style="text-align: center;">Belum Ada Data Proposal</td>
                    <td style="display:none;"></td>
                    <td style="display:none;"></td>
                    <td style="display:none;"></td>
                    <td style="display:none;"></td>
                    <td style="display:none;"></td>
                    <td style="display:none;"></td>
                    <td style="display:none;"></td>
                    </tr>';
		}
		$data = [
			'datany' => $output,
			'code' => 1,
			'pesan' => 'berhasil'

		];

		echo json_encode($data);
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
		// print "<pre>";
		// print_r($arr);
		// print "</pre>";
	}
	public function detailPengevaluasi($id = '')
	{
		$detail = $this->reviewer->get_proposalnya($id);
		if ($detail === null || $id === '') {
			redirect('C_pemonev');
		}

		$username = $this->session->userdata('username');
		$data['content'] = VIEW_ADMIN . 'evaluasi/content_detail_pengevaluasi';
		$data['username'] = $username;
		$data['judul'] = 'Detail Proposal';
		$data['brdcrmb'] = 'Beranda / Detail Proposal';
		$data['review'] = $this->reviewer->get_proposal_byId($id);
		$data['list_event'] = $this->reviewer->get_list_event();
		$data['reviewer'] = $this->Mevaluasi->getReviewerByProposal_revisi($id);
		$id_event = $data['review']->row()->id_jenis_event;

		$data['dosen'] = $this->pemonev->get_MasterPemonev($id_event);
		$data['reviewer_diproposal'] = $this->get_reviewer_prop($id);
		$data['dt_proposal'] = $detail;
		$data['dtl_proposal'] = $this->reviewer->get_proposalnya($id);

		$data['luaran_checked'] = null;
		$data['rekap'] = false;
		$data['luaran_tambahan'] = null;
		$data['check_event_review'] = $this->check_event_subjekEvaluasi($data['dtl_proposal']->id_jenis_event);

		$this->load->model("M_fokus", "fokus");

		if ($detail->id_event == 1) {
			$data['luaran'] = $this->fokus->kel_luaran_penelitian_dosen("tb_luaran")->result();
			$data['kelompok'] = $this->fokus->kel_luaran_penelitian_dosen("tb_kelompok_pengajuan")->result();
		} elseif ($detail->id_event == 2) {
			$data['luaran'] = $this->fokus->kel_luaran_pengabdian_dosen("tb_luaran")->result();
			$data['kelompok'] = $this->fokus->kel_luaran_pengabdian_dosen("tb_kelompok_pengajuan")->result();
		} else {
			$data['luaran'] = $this->fokus->kel_luaran_penelitian_plp("tb_luaran")->result();
			$data['kelompok'] = $this->fokus->kel_luaran_penelitian_plp("tb_kelompok_pengajuan")->result();
		}

		if (isset($data['dtl_proposal']->id_pengajuan_detail)) {
			$arr = [];
			foreach ($this->reviewer->get_luaran_checked($data['dtl_proposal']->id_pengajuan_detail) as $value) {
				array_push($arr, $value->id_luaran);
			}

			if ($data['dtl_proposal']->is_nambah_luaran === "1") {
				$data['luaran_tambahan'] = $this->reviewer->luaran_tambahan($data['dtl_proposal']->id_pengajuan);
			}

			$data['luaran_checked'] = $arr;
		} else {
			echo 'Halaman Tidak Bisa Di Akses';
			return;
		}

		$this->load->view('index', $data);
		// var_dump($re['nilai_fix']);
	}

	public function hasil_kerjaan_pengevaluasi($id, $event)
    {
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['judul'] = 'Evaluasi';
        $data['brdcrmb'] = 'Beranda / Evaluasi / Hasil Evaluasi';
        $data['idproposal'] = $id;
        $data['idevents'] = $event;
        $id_proposal = $this->Mevaluasi->get_id_proposal($id);
        $kelompok_pengajuan = $this->pemonev->get_kelompok_pengajuan($id_proposal->id_pengajuan_detail);
        $data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
        $data['laporan_evaluasi'] = $this->Mevaluasi->get_kerjaan_laporan_evaluasi($id);
        $data['pemonev'] = $this->pemonev->get_nama_pemonev($id);
		$data['laporan_monev'] = $this->Mevaluasi->get_laporanPemonev($id_proposal->id_pengajuan_detail);
		$data['berkas'] = $this->pemonev->dataBerkas_evaluasi_penelitian($id_proposal->id_pengajuan_detail);
		$data['masukan'] = $this->Mevaluasi->get_masukanEvaluasi($id);

        $data['dt_proposal'] = $this->reviewer->get_proposalnya($id_proposal->id_pengajuan_detail);


        //echo json_encode($data['soalnya']); return;
        $data['rekom'] = $this->pemonev->get_where('masukan_evaluasi', ['id_kerjaan_evaluasi' => $id])->row();

        if ($kelompok_pengajuan->id_kelompok_pengajuan == "14") {
    			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
    			$data['content'] = VIEW_ADMIN . '/evaluasi/content_hasil_kerjaan_evaluasi_PKLN';
    			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
    		} elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "12") {
    			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
    			$data['content'] = VIEW_ADMIN . 'evaluasi/content_hasil_kerjaan_evaluasi_PVUJ';
    			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
    		} elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "10") {
    			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
    			$data['content'] = VIEW_ADMIN . 'evaluasi/content_hasil_kerjaan_evaluasi_PTM';
    			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
    		} elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "11") {
    			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
    			$data['content'] = VIEW_ADMIN . 'evaluasi/content_hasil_kerjaan_evaluasi_KKS';
    			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
    		} elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "2") {
    			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
    			$data['content'] = VIEW_ADMIN . '/evaluasi/content_hasil_kerjaan_evaluasi_PDP';
    			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
    		} elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "13") {
    			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
    			$data['content'] = VIEW_ADMIN . 'evaluasi/content_hasil_kerjaan_evaluasi_PKK';
    			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
    		} elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "9") {
    			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
    			$data['content'] = VIEW_ADMIN . 'evaluasi/content_hasil_kerjaan_evaluasi_PLP';
    			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
    		} else {
    			$data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
    			$data['content'] = VIEW_ADMIN . 'evaluasi/content_hasil_kerjaan_evaluasi_pengabdian';
    			$data['terbit'] = $data['dt_proposal']->tahun_usulan;
    		}

        // var_dump($data['laporan_monev']);
        $this->load->view('index', $data);
    }

	public function Rekap_PNBP()
	{
		$data['content'] = VIEW_ADMIN . 'evaluasi/content_rekap_pnbp_evaluasi';
		$data['judul'] = 'Rekap Penelitian PNBP';
		$data['brdcrmb'] = 'Beranda / Evaluasi / Rekap Proposal PNBP';
		$this->load->view('index', $data);
	}

	public function Rekap_Pengabdian()
	{
		$data['content'] = VIEW_ADMIN . 'evaluasi/content_rekap_pengabdian_evaluasi';
		$data['judul'] = 'Evaluasi Rekap Proposal PNBP';
		$data['brdcrmb'] = 'Beranda / Evaluasi / Rekap Proposal PNBP';
		//$data['list_event'] = $this->reviewer->get_list_event();

		$this->load->view('index', $data);
	}

	public function Rekap_plp()
	{
		$data['content'] = VIEW_ADMIN . 'evaluasi/content_rekap_plp_evaluasi';
		$data['judul'] = 'Rekap Penelitian PLP';
		$data['brdcrmb'] = 'Beranda / Rekap Proposal PLP';
		$this->load->view('index', $data);
	}

	public function submitEvaluasi($id_proposal)
	{
		$skema = $_POST['skema'];
		$id_kerjaan_evaluasi = $_POST['id_kerjaan'];
		$id_pemonev = $_POST['id_pemonev'];
		$nama_ketua = $_POST['nama_ketua'];
		$masukan = $_POST['masukan'];
		$tanggalSekarang = date('Y-m-d H:i:s');
		$kesimpulan_tambahan1 = $_POST['kesimpulan_komponen_tambahan1'];
		$kesimpulan_tambahan2 = $_POST['kesimpulan_komponen_tambahan2'];
		$kesimpulan_tambahan3 = $_POST['kesimpulan_komponen_tambahan3'];
		$kesimpulan_tambahan4 = $_POST['kesimpulan_komponen_tambahan4'];
		$kesimpulan_tambahan5 = $_POST['kesimpulan_komponen_tambahan5'];
		$kesimpulan_tambahan6 = $_POST['kesimpulan_komponen_tambahan6'];
		$kesimpulan_tambahan7 = $_POST['kesimpulan_komponen_tambahan7'];
		$kesimpulan_tambahan8 = $_POST['kesimpulan_komponen_tambahan8'];
		if ($skema == "12") {
			$kesimpulan_wajib1 = $_POST['kesimpulan_komponen1'];
			$kesimpulan_wajib2 = $_POST['kesimpulan_komponen2'];
			$kesimpulan_wajib3 = $_POST['kesimpulan_komponen3'];
			$kesimpulan_wajib4 = $_POST['kesimpulan_komponen4'];
			$dataKesimpulan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'nama_ketua' => $nama_ketua,
				'kesimpulan_wajib1' => $kesimpulan_wajib1,
				'kesimpulan_wajib2' => $kesimpulan_wajib2,
				'kesimpulan_wajib3' => $kesimpulan_wajib3,
				'kesimpulan_wajib4' => $kesimpulan_wajib4,
				'kesimpulan_tambahan1' => $kesimpulan_tambahan1,
				'kesimpulan_tambahan2' => $kesimpulan_tambahan2,
				'kesimpulan_tambahan3' => $kesimpulan_tambahan3,
				'kesimpulan_tambahan4' => $kesimpulan_tambahan4,
				'kesimpulan_tambahan5' => $kesimpulan_tambahan5,
				'kesimpulan_tambahan6' => $kesimpulan_tambahan6,
				'kesimpulan_tambahan7' => $kesimpulan_tambahan7,
				'kesimpulan_tambahan8' => $kesimpulan_tambahan8,
			);
			$dataMasukan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'masukan_evaluasi' => $masukan,
				'created_at' => $tanggalSekarang,
			);
			$dataKerjaan = array(
				'id_pemonev' => $id_pemonev,
				'updated_at' => $tanggalSekarang,
				'kerjaan_selesai' => "1",
			);
			$this->db->insert('laporan_evaluasi', $dataKesimpulan);
			$this->db->insert('masukan_evaluasi', $dataMasukan);
			$this->Mevaluasi->update_status_kerjaan($id_proposal);
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Menyimpan Data Evaluasi');
			redirect('C_dashboard');
		}
		elseif($skema == "14"){
			$kesimpulan_wajib1 = $_POST['kesimpulan_komponen1'];
			$kesimpulan_wajib2 = $_POST['kesimpulan_komponen2'];
			$kesimpulan_wajib3 = $_POST['kesimpulan_komponen3'];
			$dataKesimpulan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'nama_ketua' => $nama_ketua,
				'kesimpulan_wajib1' => $kesimpulan_wajib1,
				'kesimpulan_wajib2' => $kesimpulan_wajib2,
				'kesimpulan_wajib3' => $kesimpulan_wajib3,
				'kesimpulan_tambahan1' => $kesimpulan_tambahan1,
				'kesimpulan_tambahan2' => $kesimpulan_tambahan2,
				'kesimpulan_tambahan3' => $kesimpulan_tambahan3,
				'kesimpulan_tambahan4' => $kesimpulan_tambahan4,
				'kesimpulan_tambahan5' => $kesimpulan_tambahan5,
				'kesimpulan_tambahan6' => $kesimpulan_tambahan6,
				'kesimpulan_tambahan7' => $kesimpulan_tambahan7,
				'kesimpulan_tambahan8' => $kesimpulan_tambahan8,
			);
			$dataMasukan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'masukan_evaluasi' => $masukan,
				'created_at' => $tanggalSekarang,
			);
			$dataKerjaan = array(
				'id_pemonev' => $id_pemonev,
				'updated_at' => $tanggalSekarang,
				'kerjaan_selesai' => "1",
			);
			$this->db->insert('laporan_evaluasi', $dataKesimpulan);
			$this->db->insert('masukan_evaluasi', $dataMasukan);
			$this->Mevaluasi->update_status_kerjaan($id_proposal);
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Menyimpan Data Evaluasi');
			redirect('C_dashboard');
		}
		elseif($skema == "11"){
			$kesimpulan_wajib1 = $_POST['kesimpulan_komponen1'];
			$kesimpulan_wajib2 = $_POST['kesimpulan_komponen2'];
			$kesimpulan_wajib3 = $_POST['kesimpulan_komponen3'];
			$dataKesimpulan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'nama_ketua' => $nama_ketua,
				'kesimpulan_wajib1' => $kesimpulan_wajib1,
				'kesimpulan_wajib2' => $kesimpulan_wajib2,
				'kesimpulan_wajib3' => $kesimpulan_wajib3,
				'kesimpulan_tambahan1' => $kesimpulan_tambahan1,
				'kesimpulan_tambahan2' => $kesimpulan_tambahan2,
				'kesimpulan_tambahan3' => $kesimpulan_tambahan3,
				'kesimpulan_tambahan4' => $kesimpulan_tambahan4,
				'kesimpulan_tambahan5' => $kesimpulan_tambahan5,
				'kesimpulan_tambahan6' => $kesimpulan_tambahan6,
				'kesimpulan_tambahan7' => $kesimpulan_tambahan7,
				'kesimpulan_tambahan8' => $kesimpulan_tambahan8,
			);
			$dataMasukan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'masukan_evaluasi' => $masukan,
				'created_at' => $tanggalSekarang,
			);
			$dataKerjaan = array(
				'id_pemonev' => $id_pemonev,
				'updated_at' => $tanggalSekarang,
				'kerjaan_selesai' => "1",
			);
			$this->db->insert('laporan_evaluasi', $dataKesimpulan);
			$this->db->insert('masukan_evaluasi', $dataMasukan);
			$this->Mevaluasi->update_status_kerjaan($id_proposal);
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Menyimpan Data Evaluasi');
			redirect('C_dashboard');
		}
		elseif ($skema == "10") {
			$kesimpulan_wajib1 = $_POST['kesimpulan_komponen1'];
			$kesimpulan_wajib2 = $_POST['kesimpulan_komponen2'];
			$kesimpulan_wajib3 = $_POST['kesimpulan_komponen3'];
			$kesimpulan_wajib4 = $_POST['kesimpulan_komponen4'];
			$dataKesimpulan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'nama_ketua' => $nama_ketua,
				'kesimpulan_wajib1' => $kesimpulan_wajib1,
				'kesimpulan_wajib2' => $kesimpulan_wajib2,
				'kesimpulan_wajib3' => $kesimpulan_wajib3,
				'kesimpulan_wajib4' => $kesimpulan_wajib4,
				'kesimpulan_tambahan1' => $kesimpulan_tambahan1,
				'kesimpulan_tambahan2' => $kesimpulan_tambahan2,
				'kesimpulan_tambahan3' => $kesimpulan_tambahan3,
				'kesimpulan_tambahan4' => $kesimpulan_tambahan4,
				'kesimpulan_tambahan5' => $kesimpulan_tambahan5,
				'kesimpulan_tambahan6' => $kesimpulan_tambahan6,
				'kesimpulan_tambahan7' => $kesimpulan_tambahan7,
				'kesimpulan_tambahan8' => $kesimpulan_tambahan8,
			);
			$dataMasukan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'masukan_evaluasi' => $masukan,
				'created_at' => $tanggalSekarang,
			);
			$dataKerjaan = array(
				'id_pemonev' => $id_pemonev,
				'updated_at' => $tanggalSekarang,
				'kerjaan_selesai' => "1",
			);
			$this->db->insert('laporan_evaluasi', $dataKesimpulan);
			$this->db->insert('masukan_evaluasi', $dataMasukan);
			$this->Mevaluasi->update_status_kerjaan($id_proposal);
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Menyimpan Data Evaluasi');
			redirect('C_dashboard');
		}
		elseif($skema == "2"){
			$kesimpulan_wajib1 = $_POST['kesimpulan_komponen1'];
			$kesimpulan_wajib2 = $_POST['kesimpulan_komponen2'];
			$kesimpulan_wajib3 = $_POST['kesimpulan_komponen3'];
			$dataKesimpulan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'nama_ketua' => $nama_ketua,
				'kesimpulan_wajib1' => $kesimpulan_wajib1,
				'kesimpulan_wajib2' => $kesimpulan_wajib2,
				'kesimpulan_wajib3' => $kesimpulan_wajib3,
				'kesimpulan_tambahan1' => $kesimpulan_tambahan1,
				'kesimpulan_tambahan2' => $kesimpulan_tambahan2,
				'kesimpulan_tambahan3' => $kesimpulan_tambahan3,
				'kesimpulan_tambahan4' => $kesimpulan_tambahan4,
				'kesimpulan_tambahan5' => $kesimpulan_tambahan5,
				'kesimpulan_tambahan6' => $kesimpulan_tambahan6,
				'kesimpulan_tambahan7' => $kesimpulan_tambahan7,
				'kesimpulan_tambahan8' => $kesimpulan_tambahan8,
			);
			$dataMasukan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'masukan_evaluasi' => $masukan,
				'created_at' => $tanggalSekarang,
			);
			$dataKerjaan = array(
				'id_pemonev' => $id_pemonev,
				'updated_at' => $tanggalSekarang,
				'kerjaan_selesai' => "1",
			);
			$this->db->insert('laporan_evaluasi', $dataKesimpulan);
			$this->db->insert('masukan_evaluasi', $dataMasukan);
			$this->Mevaluasi->update_status_kerjaan($id_proposal);
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Menyimpan Data Evaluasi');
			redirect('C_dashboard');
		}
		elseif($skema == "13"){
			$kesimpulan_wajib1 = $_POST['kesimpulan_komponen1'];
			$kesimpulan_wajib2 = $_POST['kesimpulan_komponen2'];
			$kesimpulan_wajib3 = $_POST['kesimpulan_komponen3'];
			$dataKesimpulan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'nama_ketua' => $nama_ketua,
				'kesimpulan_wajib1' => $kesimpulan_wajib1,
				'kesimpulan_wajib2' => $kesimpulan_wajib2,
				'kesimpulan_wajib3' => $kesimpulan_wajib3,
				'kesimpulan_tambahan1' => $kesimpulan_tambahan1,
				'kesimpulan_tambahan2' => $kesimpulan_tambahan2,
				'kesimpulan_tambahan3' => $kesimpulan_tambahan3,
				'kesimpulan_tambahan4' => $kesimpulan_tambahan4,
				'kesimpulan_tambahan5' => $kesimpulan_tambahan5,
				'kesimpulan_tambahan6' => $kesimpulan_tambahan6,
				'kesimpulan_tambahan7' => $kesimpulan_tambahan7,
				'kesimpulan_tambahan8' => $kesimpulan_tambahan8,
			);
			$dataMasukan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'masukan_evaluasi' => $masukan,
				'created_at' => $tanggalSekarang,
			);
			$dataKerjaan = array(
				'id_pemonev' => $id_pemonev,
				'updated_at' => $tanggalSekarang,
				'kerjaan_selesai' => "1",
			);
			$this->db->insert('laporan_evaluasi', $dataKesimpulan);
			$this->db->insert('masukan_evaluasi', $dataMasukan);
			$this->Mevaluasi->update_status_kerjaan($id_proposal);
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Menyimpan Data Evaluasi');
			redirect('C_dashboard');
		}
		elseif($skema == "9"){
			$kesimpulan_wajib1 = $_POST['kesimpulan_komponen1'];
			$dataKesimpulan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'nama_ketua' => $nama_ketua,
				'kesimpulan_wajib1' => $kesimpulan_wajib1,
				'kesimpulan_tambahan1' => $kesimpulan_tambahan1,
				'kesimpulan_tambahan2' => $kesimpulan_tambahan2,
				'kesimpulan_tambahan3' => $kesimpulan_tambahan3,
				'kesimpulan_tambahan4' => $kesimpulan_tambahan4,
				'kesimpulan_tambahan5' => $kesimpulan_tambahan5,
				'kesimpulan_tambahan6' => $kesimpulan_tambahan6,
				'kesimpulan_tambahan7' => $kesimpulan_tambahan7,
				'kesimpulan_tambahan8' => $kesimpulan_tambahan8,
			);
			$dataMasukan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'masukan_evaluasi' => $masukan,
				'created_at' => $tanggalSekarang,
			);
			$dataKerjaan = array(
				'id_pemonev' => $id_pemonev,
				'updated_at' => $tanggalSekarang,
				'kerjaan_selesai' => "1",
			);
			$this->db->insert('laporan_evaluasi', $dataKesimpulan);
			$this->db->insert('masukan_evaluasi', $dataMasukan);
			$this->Mevaluasi->update_status_kerjaan($id_proposal);
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Menyimpan Data Evaluasi');
			redirect('C_dashboard');
		}
		else {
			$kesimpulan_wajib1 = $_POST['kesimpulan_komponen1'];
			$kesimpulan_wajib2 = $_POST['kesimpulan_komponen2'];
			$kesimpulan_wajib3 = $_POST['kesimpulan_komponen3'];
			$kesimpulan_wajib4 = $_POST['kesimpulan_komponen4'];
			$kesimpulan_wajib5 = $_POST['kesimpulan_komponen5'];
			$dataKesimpulan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'nama_ketua' => $nama_ketua,
				'kesimpulan_wajib1' => $kesimpulan_wajib1,
				'kesimpulan_wajib2' => $kesimpulan_wajib2,
				'kesimpulan_wajib3' => $kesimpulan_wajib3,
				'kesimpulan_wajib4' => $kesimpulan_wajib4,
				'kesimpulan_wajib5' => $kesimpulan_wajib5,
				'kesimpulan_tambahan1' => $kesimpulan_tambahan1,
				'kesimpulan_tambahan2' => $kesimpulan_tambahan2,
				'kesimpulan_tambahan3' => $kesimpulan_tambahan3,
				'kesimpulan_tambahan4' => $kesimpulan_tambahan4,
				'kesimpulan_tambahan5' => $kesimpulan_tambahan5,
			);
			$dataMasukan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'masukan_evaluasi' => $masukan,
				'created_at' => $tanggalSekarang,
			);
			$dataKerjaan = array(
				'id_pemonev' => $id_pemonev,
				'updated_at' => $tanggalSekarang,
				'kerjaan_selesai' => "1",
			);
			$this->db->insert('laporan_evaluasi', $dataKesimpulan);
			$this->db->insert('masukan_evaluasi', $dataMasukan);
			$this->Mevaluasi->update_status_kerjaan($id_proposal);
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Menyimpan Data Evaluasi');
			redirect('C_dashboard');
		}
	}

	public function editEvaluasi($id_proposal)
	{
		$skema = $_POST['skema'];
		$id_kerjaan_evaluasi = $_POST['id_kerjaan'];
		$id_pemonev = $_POST['id_pemonev'];
		$nama_ketua = $_POST['nama_ketua'];
		$masukan = $_POST['masukan'];
		$tanggalSekarang = date('Y-m-d H:i:s');
		$kesimpulan_tambahan1 = $_POST['kesimpulan_komponen_tambahan1'];
		$kesimpulan_tambahan2 = $_POST['kesimpulan_komponen_tambahan2'];
		$kesimpulan_tambahan3 = $_POST['kesimpulan_komponen_tambahan3'];
		$kesimpulan_tambahan4 = $_POST['kesimpulan_komponen_tambahan4'];
		$kesimpulan_tambahan5 = $_POST['kesimpulan_komponen_tambahan5'];
		$kesimpulan_tambahan6 = $_POST['kesimpulan_komponen_tambahan6'];
		$kesimpulan_tambahan7 = $_POST['kesimpulan_komponen_tambahan7'];
		$kesimpulan_tambahan8 = $_POST['kesimpulan_komponen_tambahan8'];
		if ($skema == "12") {
			$kesimpulan_wajib1 = $_POST['kesimpulan_komponen1'];
			$kesimpulan_wajib2 = $_POST['kesimpulan_komponen2'];
			$kesimpulan_wajib3 = $_POST['kesimpulan_komponen3'];
			$kesimpulan_wajib4 = $_POST['kesimpulan_komponen4'];
			$dataKesimpulan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'nama_ketua' => $nama_ketua,
				'kesimpulan_wajib1' => $kesimpulan_wajib1,
				'kesimpulan_wajib2' => $kesimpulan_wajib2,
				'kesimpulan_wajib3' => $kesimpulan_wajib3,
				'kesimpulan_wajib4' => $kesimpulan_wajib4,
				'kesimpulan_tambahan1' => $kesimpulan_tambahan1,
				'kesimpulan_tambahan2' => $kesimpulan_tambahan2,
				'kesimpulan_tambahan3' => $kesimpulan_tambahan3,
				'kesimpulan_tambahan4' => $kesimpulan_tambahan4,
				'kesimpulan_tambahan5' => $kesimpulan_tambahan5,
				'kesimpulan_tambahan6' => $kesimpulan_tambahan6,
				'kesimpulan_tambahan7' => $kesimpulan_tambahan7,
				'kesimpulan_tambahan8' => $kesimpulan_tambahan8,
			);
			$dataMasukan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'masukan_evaluasi' => $masukan,
				'updated_at' => $tanggalSekarang,
			);
			$dataKerjaan = array(
				'id_pemonev' => $id_pemonev,
				'updated_at' => $tanggalSekarang,
				'kerjaan_selesai' => "1",
			);
			$this->db->where('id_kerjaan_evaluasi', $id_kerjaan_evaluasi);
			$this->db->update('laporan_evaluasi', $dataKesimpulan);
			$this->db->update('masukan_evaluasi', $dataMasukan);
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Mengubah Data Evaluasi');
			redirect('C_dashboard');
		}
		elseif($skema == "14"){
			$kesimpulan_wajib1 = $_POST['kesimpulan_komponen1'];
			$kesimpulan_wajib2 = $_POST['kesimpulan_komponen2'];
			$kesimpulan_wajib3 = $_POST['kesimpulan_komponen3'];
			$dataKesimpulan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'nama_ketua' => $nama_ketua,
				'kesimpulan_wajib1' => $kesimpulan_wajib1,
				'kesimpulan_wajib2' => $kesimpulan_wajib2,
				'kesimpulan_wajib3' => $kesimpulan_wajib3,
				'kesimpulan_tambahan1' => $kesimpulan_tambahan1,
				'kesimpulan_tambahan2' => $kesimpulan_tambahan2,
				'kesimpulan_tambahan3' => $kesimpulan_tambahan3,
				'kesimpulan_tambahan4' => $kesimpulan_tambahan4,
				'kesimpulan_tambahan5' => $kesimpulan_tambahan5,
				'kesimpulan_tambahan6' => $kesimpulan_tambahan6,
				'kesimpulan_tambahan7' => $kesimpulan_tambahan7,
				'kesimpulan_tambahan8' => $kesimpulan_tambahan8,
			);
			$dataMasukan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'masukan_evaluasi' => $masukan,
				'updated_at' => $tanggalSekarang,
			);
			$dataKerjaan = array(
				'id_pemonev' => $id_pemonev,
				'updated_at' => $tanggalSekarang,
				'kerjaan_selesai' => "1",
			);
			$this->db->where('id_kerjaan_evaluasi', $id_kerjaan_evaluasi);
			$this->db->update('laporan_evaluasi', $dataKesimpulan);
			$this->db->update('masukan_evaluasi', $dataMasukan);
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Mengubah Data Evaluasi');
			redirect('C_dashboard');
		}
		elseif($skema == "11"){
			$kesimpulan_wajib1 = $_POST['kesimpulan_komponen1'];
			$kesimpulan_wajib2 = $_POST['kesimpulan_komponen2'];
			$kesimpulan_wajib3 = $_POST['kesimpulan_komponen3'];
			$dataKesimpulan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'nama_ketua' => $nama_ketua,
				'kesimpulan_wajib1' => $kesimpulan_wajib1,
				'kesimpulan_wajib2' => $kesimpulan_wajib2,
				'kesimpulan_wajib3' => $kesimpulan_wajib3,
				'kesimpulan_tambahan1' => $kesimpulan_tambahan1,
				'kesimpulan_tambahan2' => $kesimpulan_tambahan2,
				'kesimpulan_tambahan3' => $kesimpulan_tambahan3,
				'kesimpulan_tambahan4' => $kesimpulan_tambahan4,
				'kesimpulan_tambahan5' => $kesimpulan_tambahan5,
				'kesimpulan_tambahan6' => $kesimpulan_tambahan6,
				'kesimpulan_tambahan7' => $kesimpulan_tambahan7,
				'kesimpulan_tambahan8' => $kesimpulan_tambahan8,
			);
			$dataMasukan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'masukan_evaluasi' => $masukan,
				'updated_at' => $tanggalSekarang,
			);
			$dataKerjaan = array(
				'id_pemonev' => $id_pemonev,
				'updated_at' => $tanggalSekarang,
				'kerjaan_selesai' => "1",
			);
			$this->db->where('id_kerjaan_evaluasi', $id_kerjaan_evaluasi);
			$this->db->update('laporan_evaluasi', $dataKesimpulan);
			$this->db->update('masukan_evaluasi', $dataMasukan);
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Mengubah Data Evaluasi');
			redirect('C_dashboard');
		}
		elseif ($skema == "10") {
			$kesimpulan_wajib1 = $_POST['kesimpulan_komponen1'];
			$kesimpulan_wajib2 = $_POST['kesimpulan_komponen2'];
			$kesimpulan_wajib3 = $_POST['kesimpulan_komponen3'];
			$kesimpulan_wajib4 = $_POST['kesimpulan_komponen4'];
			$dataKesimpulan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'nama_ketua' => $nama_ketua,
				'kesimpulan_wajib1' => $kesimpulan_wajib1,
				'kesimpulan_wajib2' => $kesimpulan_wajib2,
				'kesimpulan_wajib3' => $kesimpulan_wajib3,
				'kesimpulan_wajib4' => $kesimpulan_wajib4,
				'kesimpulan_tambahan1' => $kesimpulan_tambahan1,
				'kesimpulan_tambahan2' => $kesimpulan_tambahan2,
				'kesimpulan_tambahan3' => $kesimpulan_tambahan3,
				'kesimpulan_tambahan4' => $kesimpulan_tambahan4,
				'kesimpulan_tambahan5' => $kesimpulan_tambahan5,
				'kesimpulan_tambahan6' => $kesimpulan_tambahan6,
				'kesimpulan_tambahan7' => $kesimpulan_tambahan7,
				'kesimpulan_tambahan8' => $kesimpulan_tambahan8,
			);
			$dataMasukan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'masukan_evaluasi' => $masukan,
				'updated_at' => $tanggalSekarang,
			);
			$dataKerjaan = array(
				'id_pemonev' => $id_pemonev,
				'updated_at' => $tanggalSekarang,
				'kerjaan_selesai' => "1",
			);
			$this->db->where('id_kerjaan_evaluasi', $id_kerjaan_evaluasi);
			$this->db->update('laporan_evaluasi', $dataKesimpulan);
			$this->db->update('masukan_evaluasi', $dataMasukan);
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Mengubah Data Evaluasi');
			redirect('C_dashboard');
		}
		elseif($skema == "2"){
			$kesimpulan_wajib1 = $_POST['kesimpulan_komponen1'];
			$kesimpulan_wajib2 = $_POST['kesimpulan_komponen2'];
			$kesimpulan_wajib3 = $_POST['kesimpulan_komponen3'];
			$dataKesimpulan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'nama_ketua' => $nama_ketua,
				'kesimpulan_wajib1' => $kesimpulan_wajib1,
				'kesimpulan_wajib2' => $kesimpulan_wajib2,
				'kesimpulan_wajib3' => $kesimpulan_wajib3,
				'kesimpulan_tambahan1' => $kesimpulan_tambahan1,
				'kesimpulan_tambahan2' => $kesimpulan_tambahan2,
				'kesimpulan_tambahan3' => $kesimpulan_tambahan3,
				'kesimpulan_tambahan4' => $kesimpulan_tambahan4,
				'kesimpulan_tambahan5' => $kesimpulan_tambahan5,
				'kesimpulan_tambahan6' => $kesimpulan_tambahan6,
				'kesimpulan_tambahan7' => $kesimpulan_tambahan7,
				'kesimpulan_tambahan8' => $kesimpulan_tambahan8,
			);
			$dataMasukan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'masukan_evaluasi' => $masukan,
				'updated_at' => $tanggalSekarang,
			);
			$dataKerjaan = array(
				'id_pemonev' => $id_pemonev,
				'updated_at' => $tanggalSekarang,
				'kerjaan_selesai' => "1",
			);
			$this->db->where('id_kerjaan_evaluasi', $id_kerjaan_evaluasi);
			$this->db->update('laporan_evaluasi', $dataKesimpulan);
			$this->db->update('masukan_evaluasi', $dataMasukan);
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Mengubah Data Evaluasi');
			redirect('C_dashboard');
		}
		elseif($skema == "13"){
			$kesimpulan_wajib1 = $_POST['kesimpulan_komponen1'];
			$kesimpulan_wajib2 = $_POST['kesimpulan_komponen2'];
			$kesimpulan_wajib3 = $_POST['kesimpulan_komponen3'];
			$dataKesimpulan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'nama_ketua' => $nama_ketua,
				'kesimpulan_wajib1' => $kesimpulan_wajib1,
				'kesimpulan_wajib2' => $kesimpulan_wajib2,
				'kesimpulan_wajib3' => $kesimpulan_wajib3,
				'kesimpulan_tambahan1' => $kesimpulan_tambahan1,
				'kesimpulan_tambahan2' => $kesimpulan_tambahan2,
				'kesimpulan_tambahan3' => $kesimpulan_tambahan3,
				'kesimpulan_tambahan4' => $kesimpulan_tambahan4,
				'kesimpulan_tambahan5' => $kesimpulan_tambahan5,
				'kesimpulan_tambahan6' => $kesimpulan_tambahan6,
				'kesimpulan_tambahan7' => $kesimpulan_tambahan7,
				'kesimpulan_tambahan8' => $kesimpulan_tambahan8,
			);
			$dataMasukan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'masukan_evaluasi' => $masukan,
				'updated_at' => $tanggalSekarang,
			);
			$dataKerjaan = array(
				'id_pemonev' => $id_pemonev,
				'updated_at' => $tanggalSekarang,
				'kerjaan_selesai' => "1",
			);
			$this->db->where('id_kerjaan_evaluasi', $id_kerjaan_evaluasi);
			$this->db->update('laporan_evaluasi', $dataKesimpulan);
			$this->db->update('masukan_evaluasi', $dataMasukan);
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Mengubah Data Evaluasi');
			redirect('C_dashboard');
		}
		elseif($skema == "9"){
			$kesimpulan_wajib1 = $_POST['kesimpulan_komponen1'];
			$dataKesimpulan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'nama_ketua' => $nama_ketua,
				'kesimpulan_wajib1' => $kesimpulan_wajib1,
				'kesimpulan_tambahan1' => $kesimpulan_tambahan1,
				'kesimpulan_tambahan2' => $kesimpulan_tambahan2,
				'kesimpulan_tambahan3' => $kesimpulan_tambahan3,
				'kesimpulan_tambahan4' => $kesimpulan_tambahan4,
				'kesimpulan_tambahan5' => $kesimpulan_tambahan5,
				'kesimpulan_tambahan6' => $kesimpulan_tambahan6,
				'kesimpulan_tambahan7' => $kesimpulan_tambahan7,
				'kesimpulan_tambahan8' => $kesimpulan_tambahan8,
			);
			$dataMasukan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'masukan_evaluasi' => $masukan,
				'updated_at' => $tanggalSekarang,
			);
			$dataKerjaan = array(
				'id_pemonev' => $id_pemonev,
				'updated_at' => $tanggalSekarang,
				'kerjaan_selesai' => "1",
			);
			$this->db->where('id_kerjaan_evaluasi', $id_kerjaan_evaluasi);
			$this->db->update('laporan_evaluasi', $dataKesimpulan);
			$this->db->update('masukan_evaluasi', $dataMasukan);
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Mengubah Data Evaluasi');
			redirect('C_dashboard');
		}
		else {
			$kesimpulan_wajib1 = $_POST['kesimpulan_komponen1'];
			$kesimpulan_wajib2 = $_POST['kesimpulan_komponen2'];
			$kesimpulan_wajib3 = $_POST['kesimpulan_komponen3'];
			$kesimpulan_wajib4 = $_POST['kesimpulan_komponen4'];
			$kesimpulan_wajib5 = $_POST['kesimpulan_komponen5'];
			$dataKesimpulan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'nama_ketua' => $nama_ketua,
				'kesimpulan_wajib1' => $kesimpulan_wajib1,
				'kesimpulan_wajib2' => $kesimpulan_wajib2,
				'kesimpulan_wajib3' => $kesimpulan_wajib3,
				'kesimpulan_wajib4' => $kesimpulan_wajib4,
				'kesimpulan_wajib5' => $kesimpulan_wajib5,
				'kesimpulan_tambahan1' => $kesimpulan_tambahan1,
				'kesimpulan_tambahan2' => $kesimpulan_tambahan2,
				'kesimpulan_tambahan3' => $kesimpulan_tambahan3,
				'kesimpulan_tambahan4' => $kesimpulan_tambahan4,
				'kesimpulan_tambahan5' => $kesimpulan_tambahan5,
			);
			$dataMasukan = array(
				'id_kerjaan_evaluasi' => $id_kerjaan_evaluasi,
				'masukan_evaluasi' => $masukan,
				'updated_at' => $tanggalSekarang,
			);
			$dataKerjaan = array(
				'id_pemonev' => $id_pemonev,
				'updated_at' => $tanggalSekarang,
				'kerjaan_selesai' => "1",
			);
			$this->db->where('id_kerjaan_evaluasi', $id_kerjaan_evaluasi);
			$this->db->update('laporan_evaluasi', $dataKesimpulan);
			$this->db->update('masukan_evaluasi', $dataMasukan);
			$res = $this->response([1, 'Berhasil Tambah ']);
			echo json_encode($res);

			$this->session->set_flashdata('success', 'Berhasil Mengubah Data Evaluasi');
			redirect('C_dashboard');
		}
	}
}
