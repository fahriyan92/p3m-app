<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_settings_user extends CI_Controller
{
	private $session_id;
	private $post;
	private $tanggal_now;
	public function __construct()
	{
		parent::__construct();
        if (!$this->session->userdata("login")) {
            redirect('');
        }
		$this->session_id =  $this->session->userdata('id');
		$this->post  = $this->input->post();
		$this->tanggal_now =  date("Y-m-d H:i:s");
		$this->load->model('M_settings_user', 'setting');
	}

	public function index()
	{
		$data['content'] = VIEW_DOSEN . 'content_profile';
		$data['judul'] = 'Profil';
		$data['brdcrmb'] = 'Pengaturan / Profil Dosen';
		$data['dosen'] = $this->setting->get_data($this->session->userdata('nidn'))->result();

		$this->load->view('index', $data);
	}



	private function get_old_password()
	{
		$password = $this->setting->get_old_password($this->session_id);
		return $password;
	}


	private function response($res)
	{
		$pesan = ['code' => $res[0], 'pesan' => $res[1]];
		return $pesan;
	}
	public function login_google(){
		$_SESSION['nidn'] = 195508081987031001;
		// $_SESSION['lvl'] = 195508081987031001;
                $data_session = array(
                    'nama' => "Dummy",
                    'id' => 99,
                    'level' => "2",
                    'is_reviewer' => 0,
                    'login' => true
                );

                $this->session->set_userdata($data_session);
		$data['content'] = VIEW_DOSEN . 'content_profile';
		$data['judul'] = 'Profil';
		$data['brdcrmb'] = 'Pengaturan / Profil Dosen';
		$data['dosen'] = $this->setting->get_data($this->session->userdata('nidn'))->result();

		$this->load->view('index', $data);
	}
	public function edit_password()
	{
		$old_password = $this->get_old_password();
		$password = $this->post['password_lama']; //sesuai data postnya
		$password_baru = $this->post['password_baru'];
		$password_baru_re = $this->post['password_baru_re'];
		$state_salah = true;
		$state_tidak_sama = true;
		$res = '';

		if ($password === '' || $password_baru === '' || $password_baru_re === '') {
			$res = $this->response([0, 'Form Harus Diisi Semua']);
			echo json_encode($res);
			return;
		}

		if (!password_verify($password, $old_password->password)) {
			$state_salah = false;
		}

		if ($password_baru <> $password_baru_re) {
			$state_tidak_sama = false;
		}


		if ($state_salah === false && $state_tidak_sama === false) {
			$res = $this->response([1, 'Password Salah Dan Konfirmasi Password Konfirmasi Tidak Sama']);
			echo json_encode($res);
			return;
		}

		if ($state_salah === true && $state_tidak_sama === false) {
			$res = $this->response([2, 'Password Benar Dan Konfirmasi Password Konfirmasi Tidak Sama']);
			echo json_encode($res);
			return;
		}

		if ($state_salah === false && $state_tidak_sama === true) {
			$res = $this->response([3, 'Password Salah Dan Konfirmasi Password Konfirmasi Sama']);
			echo json_encode($res);
			return;
		}

		if ($state_salah === true && $state_tidak_sama === true) {
			$data_edit = ['password' => password_hash($password_baru, PASSWORD_DEFAULT), 'updated_date' => $this->tanggal_now];
			$edit = $this->setting->edit_password($data_edit);
			if ($edit) {
				$res = $this->response([4, 'Password Berhasil Diganti']);
				echo json_encode($res);
				return;
			}

			$res = $this->response([5, 'Password Gagal Diganti']);
			echo json_encode($res);
			return;
		}
	}
}
