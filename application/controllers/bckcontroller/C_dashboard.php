<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('M_fokus', 'Mfokus');
		$this->load->model('M_dosen', 'dosen');

		if (!$this->session->userdata('login') == true) {
			redirect('');
		}

		$this->load->model('M_reviewer', 'reviewer');
	}
	public function test()
	{
		$a = $this->session->userdata();
		var_dump($a);
	}

	private function send_email($emailny, $pesan)
	{

		$this->load->library('email');

		$config['charset'] = 'utf-8';
		$config['useragent'] = 'P3M';
		$config['protocol'] = 'smtp';
		$config['mailtype'] = 'html';
		$config['smtp_host'] = 'ssl://smtp.gmail.com';
		$config['smtp_port'] = '465';
		$config['smtp_timeout'] = '5';
		$config['smtp_user'] = 'triplets.cv@gmail.com'; //email gmail
		$config['smtp_pass'] = 'polije123'; //isi passowrd email
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['wordwrap'] = TRUE;

		$this->email->initialize($config);


		$this->email->from('triplets.cv@gmail.com', "P3M POLIJE");
		$this->email->to($emailny);
		$this->email->subject('P3M POLIJE');
		$this->email->message(

			'Anggota anda telah ' . $pesan . ' permintaan anda , silahkan check di website P3M melalui link berikut  <b><a href="https://p3m.nikwaf.com/">Disini</a></b>'
		);
		if ($this->email->send()) {
			$res = $this->response([1, 'Email ' . $emailny . ' Berhasil Dikirim']);
			return $res;
		} else {
			$res = $this->response([0, 'Email ' . $emailny . ' Gagal Dikirim, cek kembali email !']);
			return $res;
		}
	}

	private function response($res)
	{

		$pesan = ['code' => $res[0], 'pesan' => $res[1]];

		return $pesan;
	}
	private function get_id_anggota()
	{
		$nidsn = $this->session->userdata('nidn');
		// $sql = "SELECT id_anggota_dsn, nidn, id_pengajuan_detail FROM tb_anggota_dosen WHERE nidn = '" . $nidsn . "' ";
		$sql = "SELECT a.id_anggota_dsn, nidn, a.id_pengajuan_detail FROM tb_anggota_dosen as a JOIN tb_permintaan_anggota as b ON a.id_anggota_dsn = b.id_anggota WHERE a.nidn = '" . $nidsn . "' AND b.status_permintaan = 0 ";
		$data = $this->db->query($sql)->row();
		// print_r($data);
		return $data;
	}

	public function index()
	{
		// content
		$username = $this->session->userdata('username');
		if ($this->session->userdata('level') == "4") {
			$data['role'] = 'Superadmin';
			$data['content'] = VIEW_SUPERADMIN . 'content_dashboard';
		} elseif ($this->session->userdata('level') == "1") {
			$data['role'] = 'Admin';
			$data['content'] = VIEW_ADMIN . 'content_dashboard';
		} elseif ($this->session->userdata('level') == "2") {
			$data['role'] = $this->session->userdata('job') === "dosen" ? 'Dosen' : 'PLP';
			$data['list_event'] = $this->list_event();
			$data['mandiri'] = $this->list_judul_mandiri();
			$data['content'] = VIEW_DOSEN . 'content_dashboard';
		} elseif ($this->session->userdata('level') == "3") {
			$data['role'] = 'Reviewer';
			$data['mandiri'] = $this->list_judul_mandiri();
			$data['content'] = VIEW_REVIEWER . 'content_dashboard';
			$data['review'] = $this->kerjaan_reviewer();
			// data reviewer taruh sini 
		}
		$data['username'] = $username;
		$data['brdcrmb'] = 'Beranda';

		$this->load->view('index', $data);
	}

	public function list_judul_mandiri()
	{
		$sql = "select id_pengajuan_detail id_detail from anggota_dosen_mandiri where nip ='" . $this->session->userdata('nidn') . "' AND status = 1";
		$id_permintaan = $this->db->query($sql)->result();

		$data = [];
		foreach ($id_permintaan as $wo) {
			$sql2 = "select judul from identitas_pengajuan_mandiri where id_pengajuan_detail =" . $wo->id_detail;
			$proposal = $this->db->query($sql2)->row();
			$proposal->id_proposal = $wo->id_detail;
			array_push($data, $proposal);
		}

		return count($data) == 0 ? 0 : $data;
	}

	public function proposal_mandiri($id = null)
	{
		if ($id == null) {
			redirect('C_dashboard');
		}

		// content
		$username = $this->session->userdata('username');
		$data['content'] = VIEW_DOSEN . 'content_detail_proposal_mandiri';
		$data['username'] = $username;
		$data['judul'] = 'Detail Proposal';
		$data['brdcrmb'] = 'Beranda / Detail Proposal';
		$data['dt_proposal'] = $this->reviewer->get_proposalnya_mandiri($id);

		if ($data['dt_proposal']->id_event == 1) {
			$data['luaran'] = $this->Mfokus->kel_luaran_penelitian_dosen('tb_luaran')->result();
			$data['kelompok'] = $this->Mfokus->kel_luaran_penelitian_dosen('tb_kelompok_pengajuan')->result();
		} else {
			$data['luaran'] = $this->Mfokus->kel_luaran_pengabdian_dosen('tb_luaran')->result();
			$data['kelompok'] = $this->Mfokus->kel_luaran_pengabdian_dosen('tb_kelompok_pengajuan')->result();
		}

		$data['luaran_checked'] = null;
		$data['luaran_tambahan'] = null;
		if (isset($data['dt_proposal']->id_pengajuan)) {
			$arr = [];
			foreach ($this->reviewer->get_luaran_checked_mandiri($data['dt_proposal']->id_pengajuan) as $value) {
				array_push($arr, $value->id_luaran);
			}

			if ($data['dt_proposal']->is_nambah_luaran === "1") {
				$data['luaran_tambahan'] = $this->reviewer->luaran_tambahan_mandiri($data['dt_proposal']->id_pengajuan);
			}

			$data['luaran_checked'] = $arr;
		}

		$this->load->view('index', $data);
	}


	private function kerjaan_reviewer()
	{
		$selesai = [0, 1];
		$data_kirim = [];

		foreach ($selesai as $sl) {
			$data = $this->reviewer->get_proposalByReviewer($this->session->userdata('id_reviewer'), $sl)->result();
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
	public function get_max_pengajuan($nidsn, $event)
	{
		$max_pengajuan = $this->dosen->get_where('tb_hindex', ['nidsn_dosen' => $nidsn])->row();

		if($event == 1){
			return $max_pengajuan->limit_penelitian;
		}elseif($event == 2){
			return $max_pengajuan->limit_pengabdian;
		}else{
			return $max_pengajuan->limit_penelitian;
		}
	}
	public function tombol_permintaan()
	{

		$input = $this->input->post();
		$id = $input['id_proposal'];
		$status = $input['status'];

		$anggota = $this->get_id_anggota();
		$nidsn = $this->session->userdata('nidn');
		if ($id != '') {

			if ($status == 2) {
				$data = [
					'status_permintaan' => 2,
					'id_anggota' => $anggota->id_anggota_dsn,
					'id_pengajuan_proposal' => $anggota->id_pengajuan_detail,
				];

				$get = $this->reviewer->get_where('dummy_dosen', ['nidn' => $nidsn])->row();

				$kirim_email = $this->send_email($get->email, "Menolak");

				$this->dosen->TolakPermintaan($data);

				$res = [$kirim_email, $this->response([1, 'Berhasil tolak'])];
				echo json_encode($res);
			} else {
				$data = [
					'status_permintaan' => 1,
					'id_anggota' => $anggota->id_anggota_dsn,
					'id_pengajuan_proposal' => $anggota->id_pengajuan_detail,
				];

				$get = $this->reviewer->get_where('dummy_dosen', ['nidn' => $nidsn])->row();

				$kirim_email = $this->send_email($get->email, "Menerima");

				$this->dosen->permintaan($data);

				$cek = $this->dosen->check_tipe_pengajuan($input['id_pengajuan'])->row();
				$get_max = $this->get_max_pengajuan($nidsn, $cek->id_event);

				$this->db->where('nidsn_dosen', $nidsn);
				if($cek->id_event == 1){
					$this->db->update('tb_hindex', ['limit_penelitian' => $get_max - 1]);
				}elseif($cek->id_event == 2){
					$this->db->update('tb_hindex', ['limit_pengabdian' => $get_max - 1]);
				}else{
					$this->db->update('tb_hindex', ['limit_penelitian' => $get_max - 1]);
				}

				$res = [$kirim_email, $this->response([1, 'Berhasil Menerima'])];
				echo json_encode($res);
			}
		}
	}
	public function detail_proposal($id = null)
	{
		if ($id == null) {
			$this->session->set_flashdata('error_access', 'Halaman Tidak Dapat Di Akses');
			redirect("C_dashboard");
		}
		$query_isAnggota = "select * from tb_anggota_dosen WHERE  id_pengajuan_detail = '" . $id . "' AND nidn = '" . $this->session->userdata('nidn') . "' ";
		$check_isAnggota = $this->db->query($query_isAnggota)->result();
		if ($check_isAnggota == null) {
			$this->session->set_flashdata('error_access', 'Tidak Dapat Di Akses, Anda Bukan Anggota di proposal ini');
			redirect("C_dashboard");
		}
		$query_isAcc = "select * from tb_permintaan_anggota a JOIN tb_anggota_dosen b on a.id_anggota = b.id_anggota_dsn where a.id_pengajuan_detail = '" . $id . "' AND a.status_permintaan = 0 AND b.nidn = '" . $this->session->userdata('nidn') . "' ";
		$check_isAcc = $this->db->query($query_isAcc)->result();
		if ($check_isAcc == null) {
			$this->session->set_flashdata('error_access', 'Tidak Dapat Di Akses, Anda Sudah Menerima Permintaan ini');
			redirect("C_dashboard");
		}
		// content
		$username = $this->session->userdata('username');
		$data['content'] = VIEW_DOSEN . 'content_detail_proposal';
		$data['username'] = $username;
		$data['judul'] = 'Detail Proposal';
		$data['brdcrmb'] = 'Beranda / Detail Proposal';
		$data['dt_proposal'] = $this->reviewer->get_proposalnya($id);

		$data['luaran_checked'] = null;
		$data['luaran_tambahan'] = null;
		if (isset($data['dt_proposal']->id_pengajuan_detail)) {
			$arr = [];
			foreach ($this->reviewer->get_luaran_checked($data['dt_proposal']->id_pengajuan_detail) as $value) {
				array_push($arr, $value->id_luaran);
			}

			if ($data['dt_proposal']->is_nambah_luaran === "1") {
				$data['luaran_tambahan'] = $this->reviewer->luaran_tambahan($data['dt_proposal']->id_pengajuan_detail);
			}

			$data['luaran_checked'] = $arr;
		}
		$data['luaran'] = "";
		$data['kelompok'] = "";
		if ($data['dt_proposal']->id_event == 1) {
			$data['luaran'] = $this->Mfokus->kel_luaran_penelitian_dosen('tb_luaran')->result();
			$data['kelompok'] = $this->Mfokus->kel_luaran_penelitian_dosen('tb_kelompok_pengajuan')->result();
		} elseif ($data['dt_proposal']->id_event == 2) {
			$data['luaran'] = $this->Mfokus->kel_luaran_pengabdian_dosen('tb_luaran')->result();
			$data['kelompok'] = $this->Mfokus->kel_luaran_pengabdian_dosen('tb_kelompok_pengajuan')->result();
		} else {
			$data['content'] = VIEW_DOSEN . 'plp/content_detail_proposal_plp';
			$data['luaran'] = $this->Mfokus->kel_luaran_penelitian_plp('tb_luaran')->result();
			$data['kelompok'] = $this->Mfokus->kel_luaran_penelitian_plp('tb_kelompok_pengajuan')->result();
		}

		$this->load->view('index', $data);
	}
	public function notifikasi()
	{

		$input = $this->input->post();
		$lihat = $input['lihat'];
		$output = '';
		$data_notif = '';
		$update_notif = '';
		$anggota = $this->get_id_anggota();

		if (!empty($anggota)) {


			$data_notif = [
				'status_permintaan' => 0,
				'id_anggota' => $anggota->id_anggota_dsn,
				'id_pengajuan_proposal' => $anggota->id_pengajuan_detail,
			];


			$notif = $this->dosen->get_permintaan($data_notif);

			if ($notif->num_rows() > 0) {
				$no = 1;

				foreach ($notif->result() as $key) {
					$output .= '


                      <tr>
                        <td>' . $no . '</td>
                        <td>' . substr(strip_tags(ucfirst(strtolower($key->judul))), 0, 60) . '</td>
                        <td>
                          <a href="' . base_url() . 'C_dashboard/detail_proposal/' . $key->id_pengajuan_detail . '" class="btn btn-xs btn-danger"> <i class="fa fa-paste"></i></a>
                        </td>
                      </tr>
';
					$no++;
				}
			} else {
				$output .= '
                    <tr>
                      <td colspan="3" style="text-align: center;">Belum Ada Permintaan</td>
                    </tr>';
			}

			$notif_kosong = $this->dosen->get_notif_kosong($data_notif);

			$hitung = $notif_kosong->num_rows();

			$data = [
				'notif' => $output,
				'hitung_notif' => $hitung
			];

			echo json_encode($data);
		}
	}

	public function list_event()
	{
		$jenis_event = $this->dosen->get_all('tb_jenis_event')->result();
		$data = [];

		for ($i = 0; $i <= count($jenis_event) - 1; $i++) {
			$event = $this->dosen->list_by_jenis($jenis_event[$i]->id_jenis_event);

			if ($jenis_event[$i]->id_jenis_event === "1") {
				if (count($event) > 0) {
					$data['p_penelitian'] = $event;
				} else {
					$data['p_penelitian'] = null;
				}
			}


			if ($jenis_event[$i]->id_jenis_event === "2") {
				if (count($event) > 0) {
					$data['p_pengabdian'] = $event;
				} else {
					$data['p_pengabdian'] = null;
				}
			}

			if ($jenis_event[$i]->id_jenis_event === "3") {
				if (count($event) > 0) {
					$data['m_penelitian'] = $event;
				} else {
					$data['m_penelitian'] = null;
				}
			}

			if ($jenis_event[$i]->id_jenis_event === "4") {
				if (count($event) > 0) {
					$data['m_pengabdian'] = $event;
				} else {
					$data['m_pengabdian'] = null;
				}
			}

			if ($jenis_event[$i]->id_jenis_event === "5") {
				if (count($event) > 0) {
					$data['p_plp_penelitian'] = $event;
				} else {
					$data['p_plp_penelitian'] = null;
				}
			}
		}

		return $data;
	}


	public function lihat_session()
	{
		print_r($_SESSION);
	}

	public function tombol_permintaan_mandiri()
	{
		$input = $this->input->post();
		$id = $input['id_proposal'];
		$status = $input['status'];

		$nip = $this->session->userdata('nidn');

		$this->db->trans_start();

		$this->db->where(['id_pengajuan_detail' => $id, 'nip' => $nip]);
		$this->db->update('anggota_dosen_mandiri', ['status' => $status]);

		if ($status == "2") {
			$this->db->select('status');
			$this->db->where(['id_pengajuan_detail' => $id, 'status >' => 3]);
			$ada = $this->db->get('pengajuan_detail_mandiri')->row();

			$this->db->where('id_pengajuan_detail', $id);
			if ($ada !== null) {
				$this->db->update('pengajuan_detail_mandiri', ['updated_at' => date("Y-m-d H:i:s")]);
			} else {
				$this->db->update('pengajuan_detail_mandiri', ['status' => 3, 'updated_at' => date("Y-m-d H:i:s")]);
			}
		}

		$this->db->trans_complete();


		$res = ['woi', $this->response([1, 'Berhasil Menerima'])];
		echo json_encode($res);
	}

	// akhircontroller

}
