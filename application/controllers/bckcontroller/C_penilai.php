<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_penilai extends CI_Controller
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
		$this->load->model('M_soal_penilaian', 'soal');
		$this->load->model('M_event', 'event');
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

	public function index()
	{
		$data['content'] = VIEW_ADMIN . 'content_penilai';
		$data['judul'] = 'Data Kriteria Penilaian';
		$data['brdcrmb'] = 'Beranda / Data Kriteria Penilaian';
		$data['soal'] = $this->mreview->get_soal()->result();
		$data['jns'] = $this->mreview->get_Jenis_Soal()->result();
		$data['soal2'] = $this->mreview->get_soal2()->result();
		$data['jns2'] = $this->mreview->get_Jenis_Soal2()->result();
		$data['soal3'] = $this->mreview->get_soal3()->result();
		$data['jns3'] = $this->mreview->get_Jenis_Soal3()->result();

		$this->load->view('index', $data);
	}

	public function editSoal($id)
	{
		$data['content'] = VIEW_ADMIN . 'content_editSoal_angket';
		$data['judul'] = 'Data Kriteria Penilaian';
		$data['brdcrmb'] = 'Beranda / Data Kriteria Penilaian / Edit Kriteria';
		$data['jns'] = $this->mreview->get_ALLJenis_Soal()->result();
		$data['dataSoal'] = $this->mreview->get_soal_byId($id)->result();
		$data['idSoal'] = $id;

		$this->load->view('index', $data);
	}

	public function editJnsSoal($id)
	{
		$data['content'] = VIEW_ADMIN . 'content_editjns_angket';
		$data['judul'] = 'Data Kriteria Penilaian';
		$data['brdcrmb'] = 'Beranda / Data Kriteria Penilaian / Edit Jenis Kriteria';
		$data['jns'] = $this->mreview->get_Jenis_SoalbyId($id);
		$data['idSoal'] = $id;

		$this->load->view('index', $data);
	}

	public function dtlSoal($id)
	{
		$data['content'] = VIEW_ADMIN . 'content_detail_angket';
		$data['judul'] = 'Data Kriteria Penilaian';
		$data['brdcrmb'] = 'Beranda / Data Kriteria Penilaian / Detail Soal Kriteria';
		$data['jns'] = $this->mreview->get_ALLJenis_Soal()->result();
		$data['pilihan'] = $this->mreview->get_Pilihan($id)->result();
		$data['dataSoal'] = $this->mreview->get_soal_byId($id)->result();
		$data['event'] = $this->event->get_jenisEvent($id)->result();


		$this->load->view('index', $data);
	}

	public function pilihanById()
	{
		$id = $this->input->post('id');
		$pilihan = $this->mreview->get_Pilihan_by_id($id);
		echo json_encode($pilihan);
	}

	private function response($res)
	{

		$pesan = ['code' => $res[0], 'pesan' => $res[1]];

		return json_encode($pesan);
	}

	public function update_kriteria()
	{
		$post = $this->input->post();
		$jnsSoal = $post['jnsSoal'];
		$status = $post['status'];
		$soal = $post['soal'];
		$id = $post['id'];

		$data = [
			'id_jenis_soal' => $jnsSoal,
			'soal' => $soal,
			'status' => $status
		];

		$this->db->where('id_soal', $id);
		$update = $this->db->update('tb_soal', $data);

		if ($update === false) {
			print_r($this->response([0, 'Tidak berhasil Mengedit Data']));
			return;
		}
		$this->insert_log(['UPDATE', 'UPDATE PADA KRITERIA']);
		print_r($this->response([1, 'berhasil Mengedit Data']));
		return;
	}
	public function update_jnskriteria()
	{
		$post = $this->input->post();
		$jns = $post['jns'];
		$status = $post['status'];
		$bobot = $post['bobot'];
		$id = $post['id'];

		$data = [
			'nm_jenis_soal' => $jns,
			'bobot' => $bobot,
			'status' => $status
		];

		$this->db->where('id_jenis_soal', $id);
		$update = $this->db->update('tb_jenis_soal', $data);

		if ($update === false) {
			print_r($this->response([0, 'Tidak berhasil Mengedit Data']));
			return;
		}
		$this->insert_log(['UPDATE', 'UPDATE PADA JENIS KRITERIA']);

		print_r($this->response([1, 'berhasil Mengedit Data']));
		return;
	}

	public function update_pilihan()
	{
		$post = $this->input->post();
		$pilihan = $post['pilihan'];
		$status = $post['gender'];
		$bobot = $post['bobot'];
		$persen = $post['persen'];
		$id = $post['id'];
		$idSoal = $post['idSoal'];

		$data = [
			'deskripsi_pilihan' => $pilihan,
			'score' => $bobot,
			'prosentase' => $persen,
			'status' => $status,
			'id_soal' => $idSoal
		];

		$this->db->where('id_pilihan', $id);
		$update = $this->db->update('tb_pilihan', $data);

		if ($update === false) {
			print_r($this->response([0, 'Tidak berhasil Mengedit Data']));
			return;
		} else if ($update === true) {
			print_r($this->response([1, 'berhasil Mengedit Data']));
			$this->insert_log(['UPDATE', 'UPDATE PADA PILIHAN']);

			return;
		}
	}

	public function add_pilihan()
	{
		$post = $this->input->post();
		$pilihan = $post['pilihan'];
		$status = 1;
		$bobot = $post['bobot'];
		$persen = $post['persen'];
		$id = $post['id'];

		$data = [
			'deskripsi_pilihan' => $pilihan,
			'score' => $bobot,
			'prosentase' => $persen,
			'status' => $status,
			'id_soal' => $id
		];

		$insert = $this->db->insert('tb_pilihan', $data);

		if ($insert === false) {
			print_r($this->response([0, 'Tidak berhasil Menyimpan Data']));
			return;
		} else if ($insert === true) {
			print_r($this->response([1, 'berhasil Menyimpan Data']));
			$this->insert_log(['CREATE', 'CREATE PADA PILIHAN']);

			return;
		}
	}

	public function store_soal()
	{
		$post = $this->input->post();
		$soal = [
			'soal' => $post['soal'],
			'id_jenis_soal' => $post['jenis'],
			'status' => 1
		];

		$insert = $this->soal->store_soal($soal, $post['pilihan'], $post['bobot']);

		if ($insert === false) {
			echo json_encode($this->response([0, 'Tidak berhasil Menyimpan Data']));
			return;
		}
		$this->insert_log(['CREATE', 'CREATE PADA SOAL']);

		echo json_encode($this->response([1, 'Berhasil Menyimpan Data']));
	}

	public function store_jnsoalpne()
	{
		$post = $this->input->post();
		$soal = [
			'nm_jenis_soal' => $post['jns'],
			'bobot' => $post['bobotjns'],
			'id_event' => 1,
			'status' => 1
		];

		$insert = $this->soal->store_jnsoal($soal);

		if ($insert === false) {
			echo json_encode($this->response([0, 'Tidak berhasil Menyimpan Data']));
			return;
		}
		$this->insert_log(['CREATE', 'CREATE PADA JENIS SOAL']);

		echo json_encode($this->response([1, 'Berhasil Menyimpan Data']));
	}

	public function store_soalpge()
	{
		$post = $this->input->post();
		$soal = [
			'soal' => $post['soalpge'],
			'id_jenis_soal' => $post['jnsSoalpge'],
			'status' => 1
		];

		$insert = $this->soal->store_soalpge($soal, $post['pilihanpge'], $post['bobotpge'], $post['persen']);

		if ($insert === false) {
			echo json_encode($this->response([0, 'Tidak berhasil Menyimpan Data']));
			return;
		}
		$this->insert_log(['CREATE', 'CREATE PADA JENIS SOAL']);

		echo json_encode($this->response([1, 'Berhasil Menyimpan Data']));
	}

	public function store_jnsoalpge()
	{
		$post = $this->input->post();
		$soal = [
			'nm_jenis_soal' => $post['jnspge'],
			'bobot' => $post['bobotjnspge'],
			'id_event' => 2,
			'status' => 1
		];

		$insert = $this->soal->store_jnsoalpge($soal);

		if ($insert === false) {
			echo json_encode($this->response([0, 'Tidak berhasil Menyimpan Data']));
			return;
		}
		$this->insert_log(['CREATE', 'CREATE PADA JENIS SOAL']);

		echo json_encode($this->response([1, 'Berhasil Menyimpan Data']));
	}

	public function store_soalplp()
	{
		$post = $this->input->post();
		$soal = [
			'soal' => $post['soalplp'],
			'id_jenis_soal' => $post['jnsSoalplp'],
			'status' => 1
		];

		$insert = $this->soal->store_soalplp($soal, $post['pilihanplp'], $post['bobotplp'], $post['persenplp']);

		if ($insert === false) {
			echo json_encode($this->response([0, 'Tidak berhasil Menyimpan Data']));
			return;
		}
		$this->insert_log(['CREATE', 'CREATE PADA JENIS SOAL']);

		echo json_encode($this->response([1, 'Berhasil Menyimpan Data']));
	}

	public function store_jnsoalplp()
	{
		$post = $this->input->post();
		$soal = [
			'nm_jenis_soal' => $post['jnsplp'],
			'bobot' => $post['bobotjnsplp'],
			'id_event' => 3,
			'status' => 1
		];

		$insert = $this->soal->store_jnsoalplp($soal);

		if ($insert === false) {
			echo json_encode($this->response([0, 'Tidak berhasil Menyimpan Data']));
			return;
		}
		$this->insert_log(['CREATE', 'CREATE PADA JENIS SOAL']);

		echo json_encode($this->response([1, 'Berhasil Menyimpan Data']));
	}
}
