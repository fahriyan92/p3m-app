<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_rekap extends CI_Controller
{
	private $session_id;
	private $post;
	private $tanggal_now;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_rekap', 'rekap');
		$this->load->model('M_reviewer', 'reviewer');
		$this->load->model('M_fokus', 'Mfokus');
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
	// REKAP PENELITIAN PNBP DOSEN
	public function Rekap_PNBP() 
	{
		$data['content'] = VIEW_ADMIN . 'content_rekap_pnbp';
		$data['judul'] = 'Rekap Penelitian PNBP';
		$data['brdcrmb'] = 'Beranda / Rekap Proposal PNBP';
		$this->load->view('index', $data);
	}
	// REKAP PENELITIAN  PLP / TEKNISI
	public function Rekap_plp()
	{
		$data['content'] = VIEW_ADMIN . 'content_rekap_plp';
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
		if($jenis == "3" || $jenis == 3){
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
		$data['content'] = VIEW_ADMIN . 'content_rekap_pengabdian';
		$data['judul'] = 'Rekap Proposal PNBP';
		$data['brdcrmb'] = 'Beranda / Rekap Proposal PNBP';
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
}
