<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_auth extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('M_auth', 'auth');
    }

    private function response($res)
    {

        $pesan = ['code' => $res[0], 'pesan' => $res[1]];

        return $pesan;
    }

    function index()
    {

        if ($this->session->userdata("login")) {
            redirect('C_dashboard');
        } else {

            $this->load->view('content/login.php');
        }
    }

    function auth_dosen()
    {
        if ($this->session->userdata('login') == true) {
            redirect('C_dashboard');
        }

        $this->load->view('content/login_dosen.php');
    }


    public function redirect_google()
    {
        $this->load->library('google');
        redirect($this->google->getLoginUrl());
        // redirect($url);
    }

    function auth_staff()
    {
        if ($this->session->userdata('login') == true) {
            redirect('C_dashboard');
        }
        $this->load->view('content/login_staff.php');
    }
    function aksi_login_staff()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // $cek = $this->auth->cek_login("tb_user", $where)->num_rows();
        $cek = $this->auth->get_where('tb_staff', array('username_staff' => $username));

        if ($cek->num_rows() > 0) {

            $data = $cek->row();

            if (password_verify($password, $data->password)) {

                $data_session = array(
                    'nama' => $data->nama_staff,
                    'id' => $data->id_staff,
                    'level' => $data->id_level_staff,
                    'is_reviewer' => 0,
                    'login' => true
                );

                $this->session->set_userdata($data_session);

                echo json_encode(['status' => 'success', 'pesan' => 'Berhasil']);
                return;

                // redirect(base_url("C_dashboard"));

            } else {
                echo json_encode(['status' => 'fail', 'pesan' => 'password salah']);
                return;
            }
        } else {
            echo json_encode(['status' => 'fail', 'pesan' => 'username tidak dapat ditemukan']);
            return;
        }
    }


    public function register_email()
    {
        $nidn = $this->input->post('nidn');
        // $nidn = "195509291987031002";
        // $password = $this->input->post('password');

        $this->db->select('nip,email');
        $this->db->from('dummy_dosen');
        $this->db->where('nip',$nidn);
        $data = $this->db->get()->row();
        // echo json_encode($data);
        if($data === null){
            echo json_encode(['status' => 'fail', 'pesan' => 'nip tidak dapat ditemukan']);
            return;
        }
        if($data->email != ""){
            echo json_encode(['status' => 'fail', 'pesan' => 'anda sudah melakukan registrasi,silahkan login dengan sso']);
            return;
        }
        $this->session->set_userdata('nip_register',$nidn);
        echo json_encode(['status' => 'success', 'pesan' => 'ready to go!']);
        return;
    }

    public function aksi_login_dosen()
    {
        $nidn = $this->input->post('nidn');
        $password = $this->input->post('password');

        $url = base_url() . "api/dosen/get_dosen_data/" . $nidn;
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_HEADER, 0);
        // curl_close($ch);
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $data = curl_exec($ch);
        // $data_decode = json_decode($data);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);

        curl_close($ch);
        $data_decode = json_decode($response);

        if (count($data_decode->data) < 1) {
            echo json_encode(['status' => 'fail', 'pesan' => 'nidn tidak dapat ditemukan']);
            return;
        }


        if (!password_verify($password, $data_decode->data[0]->password)) {
            echo json_encode(['status' => 'fail', 'pesan' => 'password salah']);
            return;
        }


        $sql_reviewer = "select id_reviewer from tb_reviewer where nidn = '" . $nidn . "'";
        $apakah_reviewer = $this->db->query($sql_reviewer)->row();

        $pesan = 'selamat login reviewer';
        $is_reviewer = 1;

        if ($apakah_reviewer === null) {
            $pesan = 'selamat login dosen biasa';
            $is_reviewer = 0;
        } else {
            $is_reviewer = $apakah_reviewer->id_reviewer;
        }

        $this->session_login($data_decode->data[0], $is_reviewer);

        echo json_encode(['status' => 'success', 'pesan' => $pesan]);
        return;
    }

    public function superAdmin()
    {
        $data_session = array(
            'nama' => "SUPER ADMIN",
            'id' => "",
            'level' => "4",
            'is_reviewer' => "0",
            'login' => true
        );
        $this->session->set_userdata($data_session);

        redirect(base_url("C_user_admin"));
    }

    public function admin()
    {
        $data_session = array(
            'nama' => "admin",
            'id' => "2",
            'level' => "1",
            'is_reviewer' => "0",
            'login' => true
        );
        $this->session->set_userdata($data_session);

        redirect(base_url("C_dashboard"));
    }

    public function session_login($data, $is_reviewer)
    {
        $data_session = array(
            'nama' => $data->nama,
            'nidn' => $data->nidn,
            'level' => "2",
            'is_reviewer' => $is_reviewer,
            'login' => true,
            'job' => $data->jenis_job
        );

        if ($is_reviewer > 0) {
            $data_session['level'] = "3";
            $data_session['is_reviewer'] = 1;
            $data_session['id_reviewer'] = $is_reviewer;
            $data_session['job'] = $data->jenis_job;
        }

        $this->session->set_userdata($data_session);
    }

    public function dosen()
    {
        $data_session = array(
            'nama' => "ini dosen 1",
            'NIDSN' => "1234561231",
            'level' => "2",
            'is_reviewer' => "0",
            'login' => true
        );
        $this->session->set_userdata($data_session);

        redirect(base_url("C_dashboard"));
    }
    public function reviewer()
    {
        $data_session = array(
            'nama' => "reviewer",
            'id' => "2",
            'level' => "3",
            'is_reviewer' => "1",
            'login' => true
        );
        $this->session->set_userdata($data_session);

        redirect(base_url("C_dashboard"));
    }

    function logout()
    {
        $this->session->sess_destroy();
        $this->load->library('google');
        $this->google->logout();
        redirect(base_url('/'));
    }

    public function ceksesi()
    {
        print_r(json_encode($_SESSION));
    }
}
