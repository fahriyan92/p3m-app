<?php

class C_register extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_auth', 'auth');
    $this->load->library('data_api');
  }

  public function logout()
  {
    $this->load->library('google');
    $this->google->logout();
    redirect('/');
  }

  public function index()
  {
    $this->load->library('google');
    $this->google->setAccessToken();
    $user_data = $this->google->getUserInfo();
    $waktu_now = date('Y-m-d H:i:s');
    $data['email'] = $user_data['email'];
    $data['nama'] = $user_data['name'];
    $data['content'] = VIEW_DOSEN . 'content_register_mail';
    $get_user = $this->auth->get_where('dummy_dosen', ['email' => $user_data['email']])->row();
    if ($get_user !== null) {
      // $dosen = json_decode($this->data_api->get_data('nip=' . $get_user->nip));
      // if (count($dosen) !== 0) {
      //   //$insert_data = [
      //     //'nama' => $dosen[0]->nama_lengkap,
      //     //'jenis_job' => strtolower($dosen[0]->jab_struktur),
      //     //'badge' => $dosen[0]->badge,
      //     //'jenis_unit' => $dosen[0]->jenis_unit,
      //     //'unit' => $dosen[0]->unit
      //   //];
      //   //$this->auth->update_user($dosen[0]->nip, $insert_data);
      //   $get_user->nama_lengkap = $get_user->nama;
      //   $get_user->jab_struktur = $get_user->jenis_job;
      //   $this->check_reviewer($get_user);
      // } else {
        $get_user->nama_lengkap = $get_user->nama;
        $get_user->jab_struktur = $get_user->jenis_job;
        $this->check_reviewer($get_user);
        // $this->session->set_flashdata('sso-error', 'data nip anda tidak tersedia');
        // $this->logout();
      // }
    } else {
      //update data 
      $this->session->set_flashdata('sso-error', 'email belum terdaftar,silahkan registrasi email dulu :)');
      $this->logout();
    }
  }

  public function register_email()
  {
    if (!$this->session->userdata('nip_register')) {
      redirect('/');
    }

    $this->db->select('nama,nip,jenis_job');
    $this->db->from('dummy_dosen');
    $this->db->where('nip', $this->session->userdata('nip_register'));
    $data['data'] = $this->db->get()->row();

    $this->load->view(VIEW_DOSEN . 'content_register_mail', $data);
  }

  public function regist_email()
  {
    if (!$this->session->userdata('nip_register')) {
      echo json_encode(['status' => 'fail', 'pesan' => 'nip tidak ditemukan']);
      return;
    }
    if ($this->input->post('email')) {
      $exmail = explode('@', $this->input->post('email'));
      if ($exmail[1] !== 'polije.ac.id') {
        echo json_encode(['status' => 'fail', 'pesan' => 'Bukan email @polije.ac.id']);
        return;
      } else {
        $this->db->select('email');
        $this->db->from('dummy_dosen');
        $this->db->where(['email' => $this->input->post('email'), 'nip !=' => $this->session->userdata('nip_register')]);
        $data = $this->db->get()->row();

        if ($data !== null) {
          echo json_encode(['status' => 'fail', 'pesan' => 'Email sudah terdaftar, silahkan hubungi admin :)']);
          return;
        } else {
          $this->db->where('nip', $this->session->userdata('nip_register'));
          $this->db->update('dummy_dosen', ['email' => $this->input->post('email')]);
          $this->tambah_hindex($this->session->userdata('nip_register'));
          $this->session->unset_userdata('nip_register');
          echo json_encode(['status' => 'success', 'pesan' => 'berhasil']);
          return;
        }
      }
    } else {
      echo json_encode(['status' => 'fail', 'pesan' => 'Email kosong']);
      return;
    }
  }

  public function dummy($nip)
  {
    $dosen = $this->db->query("select * from dummy_dosen where nidn = '$nip'")->row();

    if ($dosen === null) {
      redirect('/');
    }
    $dosen->nama_lengkap = $dosen->nama;
    $dosen->jab_struktur = $dosen->jenis_job;
    $this->check_reviewer($dosen);
  }
  public function check_reviewer($data)
  {
    $sql_reviewer = "select id_reviewer from tb_reviewer where nidn = '" . $data->nip . "'";
    $apakah_reviewer = $this->db->query($sql_reviewer)->row();
    $is_reviewer = 0;
    // if ($apakah_reviewer === null) {
    //   $pesan = 'selamat login dosen biasa';
    //   $is_reviewer = 0;
    // } else {
    //   $bisa = false;
    //   $tahun = date('Y');
    //   $tgl_now = date('Y-m-d');
    //   $event_review = $this->db->query('SELECT id_list_event id, id_jenis_event jenis, waktu_mulai mulai, waktu_akhir akhir FROM tb_list_event a WHERE DATE_FORMAT(waktu_mulai,"%Y") = ' . $tahun . ' AND status = 1 AND id_tahapan = 3')->result();
    //   if ($event_review !== null) {
    //     $tanggal_now = strtotime(date('Y-m-d'));
    //     $jenis_event = 0;
    //     foreach ($event_review as $value) {
    //       $mulai = strtotime($value->mulai);
    //       $akhir = strtotime($value->akhir);
    //       if ($tanggal_now >= $mulai && $tanggal_now <= $akhir) {
    //         $jenis_event = $value->jenis;
    //       }
    //     }
    //     //sekarang disini sudah tau event penelitian atau pengabdian yang sedang dalam jadwal review
    //     if ($jenis_event !== 0) {
    //       //lalu dapatkan id_list event pengajuan event tersebut di tahun ini 
    //       $id_event_pengajuan = $this->db->query('SELECT id_list_event id FROM tb_list_event  WHERE DATE_FORMAT(waktu_mulai,"%Y") = "' . $tahun . '" AND status = 1 AND id_tahapan = 2 AND id_jenis_event = ' . $jenis_event . '')->row();
    //       //dari list event tsb. dilihat apa di kerjaan event tsb id_reviewer itu ada kerjaan
    //       $kerjaan = $this->db->query('SELECT id_kerjaan FROM tb_kerjaan_reviewer a INNER JOIN tb_pengajuan_detail b ON a.id_pengajuan_detail = b.id_pengajuan_detail INNER JOIN tb_pengajuan c ON c.id_pengajuan = b.id_pengajuan WHERE a.id_reviewer = ' . $apakah_reviewer->id_reviewer . ' AND c.id_list_event = ' . $id_event_pengajuan->id . '')->row();
    //       if ($kerjaan !== null) {
    //         $is_reviewer = $apakah_reviewer->id_reviewer;
    //       } else {
    //         $is_reviewer = 0;
    //       }
    //     } else {
    //       $is_reviewer = 0;
    //     }
    //   }
    // }
    $this->session_login($data, $is_reviewer);
    redirect('C_dashboard');
  }

  public function tambah_hindex($nip)
  {
    $get_data = $this->auth->get_where('tb_hindex', ['nidsn_dosen' => $nip])->row();
    if ($get_data === null) {
      $user_data = $this->auth->get_where('dummy_dosen', ['nidn' => $nip])->row();
      $jml_penelitian = 1;
      $jml_pengabdian = 0;
      if($user_data->jenis_job == "dosen"){
          $jml_penelitian = 2;
          $jml_pengabdian = 1;
      }      
      $this->db->insert('tb_hindex', ['nidsn_dosen' => $user_data->nip, 'nama_dosen' => $user_data->nama, 'h_index_scopus' => 0, 'h_index_schoolar' => 0, 'limit_pengabdian' => $jml_pengabdian, 'sisa_limit_pengabdian' => $jml_pengabdian, 'limit_penelitian' => $jml_penelitian, 'sisa_limit_penelitian' => $jml_penelitian]);
    }
  }

  private function session_login($data, $is_reviewer)
  {
    $data_session = array(
      'nama' => $data->nama_lengkap,
      'nidn' => $data->nip,
      'level' => "2",
      'is_reviewer' => $is_reviewer,
      'login' => true,
      'job' => strtolower($data->jab_struktur)
    );

    if ($is_reviewer > 0) {
      $data_session['level'] = "3";
      $data_session['is_reviewer'] = 1;
      $data_session['id_reviewer'] = $is_reviewer;
      $data_session['job'] = strtolower($data->jab_struktur);
    }

    $this->session->set_userdata($data_session);
  }

  public function store()
  {
    $this->load->library('google');
    echo json_encode($this->google->isLoggedIn());
  }
}
