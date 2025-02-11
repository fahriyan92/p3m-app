<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_user_admin extends CI_Controller
{
	private $session_id;
	private $post;
	private $tanggal_now;
	public function __construct()
	{
		parent::__construct();
		$this->session_id =  $this->session->userdata('id');
		$this->post  = $this->input->post();
		$this->tanggal_now =  date("Y-m-d H:i:s");
		$this->load->model('M_settings_user', 'setting');
		$this->load->model('M_reviewer', 'mreview');
	}

	public function index()
	{
		$data['content'] = VIEW_SUPERADMIN . 'content_user_admin';
		$data['judul'] = 'Data User Admin';
		$data['brdcrmb'] = 'Beranda / Data User Admin';
		$data['admin'] = $this->setting->userAdmin()->result();

		$this->load->view('index', $data);
	}

	public function editSoal($id)
	{
		$data['content'] = VIEW_ADMIN . 'content_editSoal_angket';
		$data['judul'] = 'Data Angket Penilaian';
		$data['brdcrmb'] = 'Beranda / Data Angket Penilaian';
		$data['jns'] = $this->mreview->get_Jenis_Soal()->result();
		$data['dataSoal'] = $this->mreview->get_soal_byId($id)->result();

		$this->load->view('index', $data);
	}

	public function editJnsSoal($id)
	{
		$data['content'] = VIEW_ADMIN . 'content_editjns_angket';
		$data['judul'] = 'Data Angket Penilaian';
		$data['brdcrmb'] = 'Beranda / Data Angket Penilaian';
		$data['jns'] = $this->mreview->get_Jenis_SoalbyId($id);

		$this->load->view('index', $data);
	}

	public function dtlSoal($id)
	{
		$data['content'] = VIEW_ADMIN . 'content_detail_angket';
		$data['judul'] = 'Data Angket Penilaian';
		$data['brdcrmb'] = 'Beranda / Data Angket Penilaian';
		$data['jns'] = $this->mreview->get_Jenis_Soal()->result();
		$data['pilihan'] = $this->mreview->get_Pilihan($id)->result();
		$data['dataSoal'] = $this->mreview->get_soal_byId($id)->result();


		$this->load->view('index', $data);
	}
}
