<?php 

class Anggota_mahasiswa extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata("login")) {
          redirect('');
      }
        $this->load->library('form_validation');
        $this->load->model('M_mandiri_pengabdian', 'mandiri');
    }


    public function index()
    {
      $id_pengajuan = $this->mandiri->id_pengajuan();
      $id_detail = null;

      if($id_pengajuan !== null){
        $where = ['id_pengajuan' => $id_pengajuan->id_pengajuan, 'status !=' => 8];
        $id_detail = $this->mandiri->pengajuan_mandiri($where)->row();

        if($id_detail !== null){
            if($id_detail->status < 3){
                $this->session->set_flashdata('danger', 'Opps ada yang salah');
                $this->session->set_flashdata('key', 'danger');
                redirect('C_pengabdian_dsn_mandiri/mandiri_pengajuan_pengabdian');  
            }

            $mahasiswa = $this->mandiri->get_mahasiswa(['id_pengajuan_detail' => $id_detail->id_detail])->result();
            if(count($mahasiswa) > 0 ){
                $data['mode'] = 'edit';
            } else{
                $data['mode'] = 'tambah';
            }
            $data['mahasiswa'] = $mahasiswa;
        }

     
      } else { 
        $data['mode'] = 'tambah';
      }

      $data['judul'] = $data['mode'] === 'edit' ? 'Edit Anggota Mahasiswa' :'Isi Anggota mahasiswa';
      $data['brdcrmb'] = 'Beranda / Pengabdian Dosen / Mandiri';
      $data['content'] = VIEW_DOSEN . 'pengajuan_mandiri_pengabdian/anggota_mahasiswa.php';    
      $this->load->view('index', $data);        
    }

    public function store()
    {
        $post = $this->input->post();
        $rules = array(
            array(
              'field' => 'nim1',
              'label' => 'Nim',
              'rules' => 'trim|required'
            ),
            array(
                'field' => 'nama1',
                'label' => 'Nama Mahasiswa',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'jurusan1',
                'label' => 'Jurusan',
                'rules' => 'trim|required'
              ),
              array(
                'field' => 'angkatan1',
                'label' => 'Angkatan',
                'rules' => 'trim|required'
              )
        );

        if($post['nim2'] !== ''){
            array_push($rules, [ 'field' => 'nama2',
            'label' => 'Nama',
            'rules' => 'trim|required']);
            array_push($rules, [ 'field' => 'jurusan2',
            'label' => 'Jurusan',
            'rules' => 'trim|required']);
            array_push($rules, [ 'field' => 'angkatan2',
            'label' => 'Angkatan',
            'rules' => 'trim|required']);
        }

        $this->form_validation->set_message('required','%s harus diisi');
        $this->form_validation->set_rules($rules);

        if($this->form_validation->run() === FALSE){
          $data['mode'] = 'tambah';
          $data['judul'] = $data['mode'] === 'edit' ? 'Edit Anggota Mahasiswa' :'Isi Anggota mahasiswa';
          $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';
          $data['content'] = VIEW_DOSEN . 'pengajuan_mandiri_pengabdian/anggota_mahasiswa.php'; 
          $this->load->view('index', $data);        
    
          return;
        }    
        

        $kirim = [
          'date_created' => date("Y-m-d H:i:s"), 
          'nim1' => $post['nim1'],
          'nama1' => $post['nama1'],
          'jurusan1' => $post['jurusan1'],
          'angkatan1' => $post['angkatan1'],
          'nim2' => $post['nim2'],
          'nama2' => $post['nama2'],
          'jurusan2' => $post['jurusan2'],
          'angkatan2' => $post['angkatan2'],
        ];
        

        if($this->mandiri->insert_mahasiswa($kirim)){
          $this->session->set_flashdata('success', 'Data Anggota Mahasiswa');
          $this->session->set_flashdata('key', 'success');
          redirect('C_pengabdian_dsn_mandiri/mandiri_pengajuan_pengabdian');
          return;
        } else{ 
          $this->session->set_flashdata('danger', 'Data berhasil Ditambahkan');
          $this->session->set_flashdata('key', 'danger');
          redirect('C_pengabdian_dsn_mandiri/mandiri_pengajuan_pengabdian');
          return;
        }
        


    }

    public function edit()
    {
      $post = $this->input->post();
      $rules = array(
        array(
          'field' => 'nim1',
          'label' => 'Nim',
          'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama1',
            'label' => 'Nama Mahasiswa',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'jurusan1',
            'label' => 'Jurusan',
            'rules' => 'trim|required'
          ),
          array(
            'field' => 'angkatan1',
            'label' => 'Angkatan',
            'rules' => 'trim|required'
          )
      );
      if($post['nim2'] !== ''){
          array_push($rules, [ 'field' => 'nama2',
          'label' => 'Nama',
          'rules' => 'trim|required']);
          array_push($rules, [ 'field' => 'jurusan2',
          'label' => 'Jurusan',
          'rules' => 'trim|required']);
          array_push($rules, [ 'field' => 'angkatan2',
          'label' => 'Angkatan',
          'rules' => 'trim|required']);
      }
      $this->form_validation->set_message('required','%s harus diisi');
    $this->form_validation->set_rules($rules);

      if($this->form_validation->run() === FALSE){
        $id_pengajuan = $this->mandiri->id_pengajuan();
        $id_detail = null;
  
        if($id_pengajuan !== null){
          $where = ['id_pengajuan' => $id_pengajuan->id_pengajuan, 'status !=' => 8];
          $id_detail = $this->mandiri->pengajuan_mandiri($where)->row();
  
          if($id_detail !== null){
              if($id_detail->status < 5){
                  $this->session->set_flashdata('danger', 'Opps ada yang salah');
                  $this->session->set_flashdata('key', 'danger');
                  redirect('C_pengabdian_dsn_mandiri/mandiri_pengajuan_pengabdian');  
              }
  
              $mahasiswa = $this->mandiri->get_mahasiswa(['id_pengajuan_detail' => $id_detail->id_detail])->result();
              if(count($mahasiswa) > 0 ){
                  $data['mode'] = 'edit';
              } else{
                  $data['mode'] = 'tambah';
              }
              $data['mahasiswa'] = $mahasiswa;
          }
        }

        $data['mode'] = 'edit';
        $data['judul'] = $data['mode'] === 'edit' ? 'Edit Anggota Mahasiswa' :'Isi Anggota mahasiswa';
        $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';
        $data['content'] = VIEW_DOSEN . 'pengajuan_mandiri_pengabdian/anggota_mahasiswa.php'; 
        $this->load->view('index', $data);        
  
        return;
      }    

      $kirim = [
        'date_created' => date("Y-m-d H:i:s"), 
        'nim1' => $post['nim1'],
        'nama1' => $post['nama1'],
        'jurusan1' => $post['jurusan1'],
        'angkatan1' => $post['angkatan1'],
        'nim2' => $post['nim2'],
        'nama2' => $post['nama2'],
        'jurusan2' => $post['jurusan2'],
        'angkatan2' => $post['angkatan2'],
      ];
      
      if($this->mandiri->update_mahasiswa($kirim)){
        $this->session->set_flashdata('success', 'Data Anggota Mahasiswa!');
        $this->session->set_flashdata('key', 'success');
        redirect('C_pengabdian_dsn_mandiri/mandiri_pengajuan_pengabdian');
        return;
      } else{
        $this->session->set_flashdata('danger', 'Data berhasil Ditambahkan');
        $this->session->set_flashdata('key', 'danger');
        redirect('C_pengabdian_dsn_mandiri/mandiri_pengajuan_pengabdian');
        return;
      }


    }
    

    
}