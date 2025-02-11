<?php 

class Identitas_usulan extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata("login")) {
          redirect('');
      }
        $this->load->library('form_validation');
        $this->load->model('M_fokus', 'Mfokus');        
        $this->load->model('M_mandiri', 'mandiri');

    }

    public function index()
    {
      $id_pengajuan = $this->mandiri->id_pengajuan();
      $id_detail = null;

      if($id_pengajuan !== null){
        $where = ['id_pengajuan' => $id_pengajuan->id_pengajuan, 'status !=' => 8];
        $id_detail = $this->mandiri->pengajuan_mandiri($where)->row();

        if($id_detail !== null){
          $data['identitas'] = $this->mandiri->get_identitas($id_detail->id_detail);
          $data['identitas']->id_fokus = $id_detail->id_fokus;
          $data['dokumen'] =$this->mandiri->get_dokumen($id_detail->id_detail);
          $luaran = [];
          foreach ($this->mandiri->get_all_where('target_luaran_mandiri',$id_detail->id_detail)->result() as $val) {
            array_push($luaran, $val->id_luaran);
          }

          $data['luaran_checked'] =$luaran;
          if($id_detail->nambah_ga != 0){
            $data['luaran_tambahan'] = $this->mandiri->get_all_where('luaran_tambahan_mandiri',$id_detail->id_detail)->row();
          } else{ 
            $data['luaran_tambahan'] = null;
          }
        $data['mode'] = 'edit';

        } else{ 
          $data['mode'] = 'tambah';
        }
      } else { 
        $data['mode'] = 'tambah';
      }

      $data['judul'] = $data['mode'] === 'edit' ? 'Edit identitas usulan' :'Isi identitas usulan';
      $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';
      $data['content'] = VIEW_DOSEN . 'pengajuan_mandiri/identitas_usulan.php';
      $data['fokus'] = $this->Mfokus->get_fokus(1);
      $data['luaran'] = $this->Mfokus->get_all('tb_luaran')->result();        
      $this->load->view('index', $data);        
    }

    public function store()
    {
      $post = $this->input->post();
        $rules = array(
            array(
              'field' => 'fokus_penelitian',
              'label' => 'Fokus Penelitian',
              'rules' => 'trim|required'
            ),
            array(
                'field' => 'tema_penelitian',
                'label' => 'Tema Penelitian',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'judul_penelitian',
                'label' => 'Judul Penelitian',
                'rules' => 'trim|required'
              ),
              array(
                'field' => 'tahun_penelitian',
                'label' => 'Tahun Penelitian',
                'rules' => 'trim|required'
              ),
              array(
                'field' => 'tgl_mulai',
                'label' => 'Tanggal Mulai',
                'rules' => 'trim|required'
              ),   
              array(
                'field' => 'tgl_akhir',
                'label' => 'Tanggal Akhir',
                'rules' => 'trim|required'
              ),      
              array(
                'field' => 'sasaran_penelitian',
                'label' => 'Sasaran Penelitian',
                'rules' => 'trim'
              ), 
              array(
                'field' => 'biaya_diusulkan',
                'label' => 'Biaya Penelitian',
                'rules' => 'trim|required'
              ),                                                           
              array(
                'field' => 'ringkasan',
                'label' => 'Ringkasan Penelitian',
                'rules' => 'trim|required|callback_limaratus_kata'
              ),      
              array(
                'field' => 'tinjauan',
                'label' => 'Tinjauan Pustaka',
                'rules' => 'trim|required|callback_seribu_kata'
              ),    
              array(
                'field' => 'metode',
                'label' => 'Metode Penelitian',
                'rules' => 'trim|required|callback_enamratus_kata'
              ),                                           
        );
        if(!$this->input->post('luaran')){
          array_push($rules,['field' => 'luaran',
            'label' => 'Target Luaran',
            'rules' => 'trim|required']);
        } else{
           $data['luaran_validasi'] = $post['luaran'];
        }
        $this->form_validation->set_message('required','%s harus diisi');
        $this->form_validation->set_rules($rules);

        if($this->form_validation->run() === FALSE){
          $data['mode'] = 'tambah';
          $data['judul'] = 'Isi identitas usulan';
          $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';
          $data['content'] = VIEW_DOSEN . 'pengajuan_mandiri/identitas_usulan.php';
          $data['fokus'] = $this->Mfokus->get_fokus(1);
          $data['luaran'] = $this->Mfokus->get_all('tb_luaran')->result();        
          $this->load->view('index', $data);        
    
          return;
        }    
        
        $kirim = [
          'created_at' => date("Y-m-d H:i:s"),
          'id_fokus' => $post['fokus_penelitian'], 
          'luaran_tambahan' => $post['luaran_tambahan'], 
          'luaran' => isset($post['luaran']) ? $post['luaran'] : null,
          'judul' => $post['judul_penelitian'],
          'tema_penelitian' => $post['tema_penelitian'],
          'sasaran' => $post['sasaran_penelitian'], 
          'tanggal_mulai' => $post['tgl_mulai'], 
          'tanggal_akhir' => $post['tgl_akhir'],
          'biaya' => $post['biaya_diusulkan'],
          'tahun_usulan' => $post['tahun_penelitian'],
          'ringkasan' => $post['ringkasan'], 
          'metode' => $post['metode'],
          'tinjauan' => $post['tinjauan'],
          'nambah_ga' => $post['luaran_tambahan'] === '' ? 0 : 1
        ];



        if($this->mandiri->insert_identitas($kirim)){
          $this->session->set_flashdata('success', 'Data Identitas usulan Berhasil disimpan!');
          $this->session->set_flashdata('key', 'success');
          redirect('C_penelitian_dsn_mandiri/mandiri_pengajuan_penelitian');
          return;
        } else{ 
          $this->session->set_flashdata('danger', 'Data berhasil Ditambahkan');
          $this->session->set_flashdata('key', 'danger');
          redirect('C_penelitian_dsn_mandiri/mandiri_pengajuan_penelitian');
          return;
        }
    }

    public function limaratus_kata($str)
    {
      $count = str_word_count($str);

      if($count > 500){
        $this->form_validation->set_message('limaratus_kata', '{field} tidak boleh lebih dari 500 kata');
        return false;
      } else { 
        return true;
      }
    }

    public function seribu_kata($str)
    {
      $count = str_word_count($str);

      if($count > 1000){
        $this->form_validation->set_message('seribu_kata', '{field} tidak boleh lebih dari 1000 kata');
        return false;
      } else { 
        return true;
      }
    }

    public function enamratus_kata($str)
    {
      $count = str_word_count($str);

      if($count > 600){
        $this->form_validation->set_message('enamratus_kata', '{field} tidak boleh lebih dari 600 kata');
        return false;
      } else { 
        return true;
      }
    }


    public function edit()
    {
      $post = $this->input->post();
      $rules = array(
        array(
          'field' => 'fokus_penelitian',
          'label' => 'Fokus Penelitian',
          'rules' => 'trim|required'
        ),
        array(
            'field' => 'tema_penelitian',
            'label' => 'Tema Penelitian',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'judul_penelitian',
            'label' => 'Judul Penelitian',
            'rules' => 'trim|required'
          ),
          array(
            'field' => 'tahun_penelitian',
            'label' => 'Tahun Penelitian',
            'rules' => 'trim|required'
          ),
          array(
            'field' => 'tgl_mulai',
            'label' => 'Tanggal Mulai',
            'rules' => 'trim|required'
          ),   
          array(
            'field' => 'tgl_akhir',
            'label' => 'Tanggal Akhir',
            'rules' => 'trim|required'
          ),      
          array(
            'field' => 'sasaran_penelitian',
            'label' => 'Sasaran Penelitian',
            'rules' => 'trim'
          ), 
          array(
            'field' => 'biaya_diusulkan',
            'label' => 'Biaya Penelitian',
            'rules' => 'trim|required'
          ),                                                           
          array(
            'field' => 'ringkasan',
            'label' => 'Ringkasan Penelitian',
            'rules' => 'trim|required|callback_limaratus_kata'
          ),      
          array(
            'field' => 'tinjauan',
            'label' => 'Tinjauan Pustaka',
            'rules' => 'trim|required|callback_seribu_kata'
          ),    
          array(
            'field' => 'metode',
            'label' => 'Metode Penelitian',
            'rules' => 'trim|required|callback_enamratus_kata'
          ),                                           
    );

    if(!$this->input->post('luaran') && $post['luaran_tambahan'] === ''){
      array_push($rules,['field' => 'luaran',
        'label' => 'Target Luaran', 
        'rules' => 'trim|required']);
    } else{
       $data['luaran_validasi'] = $post['luaran'];
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
          $data['identitas'] = $this->mandiri->get_identitas($id_detail->id_detail);
          $data['identitas']->id_fokus = $id_detail->id_fokus;
          $data['dokumen'] =$this->mandiri->get_dokumen($id_detail->id_detail);
          $luaran = [];
          foreach ($this->mandiri->get_all_where('target_luaran_mandiri',$id_detail->id_detail)->result() as $val) {
            array_push($luaran, $val->id_luaran);
          }

          $data['luaran_checked'] =$luaran;
          if($id_detail->nambah_ga != 0){
            $data['luaran_tambahan'] = $this->mandiri->get_all_where('luaran_tambahan_mandiri',$id_detail->id_detail)->row();
          } else{ 
            $data['luaran_tambahan'] = null;
          }
        }
        $data['mode'] = 'edit';
      } else { 
        $data['mode'] = 'tambah';
      }

      $data['judul'] = 'Isi identitas usulan';
      $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';
      $data['content'] = VIEW_DOSEN . 'pengajuan_mandiri/identitas_usulan.php';
      $data['fokus'] = $this->Mfokus->get_fokus(1);
      $data['luaran'] = $this->Mfokus->get_all('tb_luaran')->result();        
      $this->load->view('index', $data);        

      return;
    }    

    $kirim = [
      'updated_at' => date("Y-m-d H:i:s"),
      'id_fokus' => $post['fokus_penelitian'], 
      'luaran_tambahan' => $post['luaran_tambahan'], 
      'luaran' => isset($post['luaran']) ? $post['luaran'] : null,
      'judul' => $post['judul_penelitian'],
      'tema_penelitian' => $post['tema_penelitian'],
      'sasaran' => $post['sasaran_penelitian'], 
      'tanggal_mulai' => $post['tgl_mulai'], 
      'tanggal_akhir' => $post['tgl_akhir'],
      'biaya' => $post['biaya_diusulkan'],
      'tahun_usulan' => $post['tahun_penelitian'],
      'ringkasan' => $post['ringkasan'], 
      'metode' => $post['metode'],
      'tinjauan' => $post['tinjauan'],
      'nambah_ga' => $post['luaran_tambahan'] === '' ? 0 : 1
    ];
    
    if($this->mandiri->update_identitas($kirim)){
      $this->session->set_flashdata('success', 'Data Identitas usulan Berhasil disimpan!');
      $this->session->set_flashdata('key', 'success');
      redirect('C_penelitian_dsn_mandiri/mandiri_pengajuan_penelitian');
      return;
    } else{
      $this->session->set_flashdata('danger', 'Data berhasil Ditambahkan');
      $this->session->set_flashdata('key', 'danger');
      redirect('C_penelitian_dsn_mandiri/mandiri_pengajuan_penelitian');
      return;
    }

  }

  public function update()
  {
    echo json_encode($this->input->post());
    $post = $this->input->post();


  }
}