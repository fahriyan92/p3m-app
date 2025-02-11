<?php 

class Unggah_berkas extends CI_Controller{

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
                if($id_detail->status < 6){
                    $this->session->set_flashdata('danger', 'Opps ada yang salah');
                    $this->session->set_flashdata('key', 'danger');
                    redirect('C_pengabdian_dsn_mandiri/mandiri_pengajuan_pengabdian');  
                }
    
                $dokumen = $this->mandiri->get_dokumen($id_detail->id_detail);
                if($dokumen !== null){
                    if($dokumen->file_proposal != NULL && $dokumen->file_rab != NULL){
                        $data['mode'] = 'edot';
                        $data['dokumen'] = $dokumen;
                    } else{
                      $data['mode'] = 'tambah';
                    }
                } else{
                    $this->session->set_flashdata('danger', 'Opps ada yang salah');
                    $this->session->set_flashdata('key', 'danger');
                    redirect('C_pengabdian_dsn_mandiri/mandiri_pengajuan_pengabdian');  
                    $data['mode'] = 'tambah';
                }
                $data['dokumen'] = $dokumen;
            }
    
         
          } else { 
            $data['mode'] = 'tambah';
          }


        $data['judul'] = $data['mode'] === 'edit' ? 'Edit Berkas Pengajuan' :'Unggah Berkas Pengajuan';
        $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';
        $data['content'] = VIEW_DOSEN . 'pengajuan_mandiri_pengabdian/unggah_berkas.php';    
        $this->load->view('index', $data);        
    }

    public function store()
    {
        $post = $this->input->post();
        $rules = array();
        if(empty($_FILES['file_proposal']['name']) && !$this->input->post('proposal_lama')){
            $hello = 
            array(
                'field' => 'file_proposal',
                'label' => 'File Proposal',
                'rules' => 'required|xss_clean'
            );
            array_push($rules, $hello);
        } else{ 
            $hello = 
            array(
                'field' => 'file_proposal',
                'label' => 'File Proposal',
                'rules' => 'xss_clean'
            );
            array_push($rules, $hello);
        }

        if(empty($_FILES['file_rab']['name']) && !$this->input->post('rab_lama')){
            $hello = 
            array(
                'field' => 'file_rab',
                'label' => 'File RAB',
                'rules' => 'required|xss_clean'
            );
            array_push($rules, $hello);
        } else{
            $hello = 
            array(
                'field' => 'file_rab',
                'label' => 'File RAB',
                'rules' => 'xss_clean'
            );
            array_push($rules, $hello);
        }

        $this->form_validation->set_message('required','%s harus dilampirkan');
        $this->form_validation->set_rules($rules);


        if($this->form_validation->run() === FALSE){
            $data['mode'] = 'tambah';
            $id_pengajuan = $this->mandiri->id_pengajuan();
            $id_detail = null;
      
            if($id_pengajuan !== null){
                $where = ['id_pengajuan' => $id_pengajuan->id_pengajuan, 'status !=' => 8];
                $id_detail = $this->mandiri->pengajuan_mandiri($where)->row();
          
        
                if($id_detail !== null){
                    if($id_detail->status < 6){
                        $this->session->set_flashdata('danger', 'Opps ada yang salah');
                        $this->session->set_flashdata('key', 'danger');
                        redirect('C_pengabdian_dsn_mandiri/mandiri_pengajuan_pengabdian');  
                    }
        
                    $dokumen = $this->mandiri->get_dokumen($id_detail->id_detail);
                    if($dokumen !== null){
                        if($dokumen->file_proposal != NULL && $dokumen->file_rab != NULL){
                            $data['mode'] = 'edot';
                            $data['dokumen'] = $dokumen;
                        } else{
                            $data['mode'] = 'tambah';
                        }
                    } else{
                        $this->session->set_flashdata('danger', 'Opps ada yang salah');
                        $this->session->set_flashdata('key', 'danger');
                        redirect('C_pengabdian_dsn_mandiri/mandiri_pengajuan_pengabdian');  
                        $data['mode'] = 'tambah';
                    }
                    $data['dokumen'] = $dokumen;
                }
        
            
              }            

            $data['judul'] = $data['mode'] === 'edit' ? 'Edit Berkas Pengajuan' :'Unggah Berkas Pengajuan';
            $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';
            $data['content'] = VIEW_DOSEN . 'pengajuan_mandiri_pengabdian/unggah_berkas.php'; 
            $this->load->view('index', $data);        
      
            return;
          }    
        $dir_proposal = realpath(APPPATH . '../assets/berkas/file_proposal/');
        $dir_rab = realpath(APPPATH . '../assets/berkas/file_rab/');
        $proposal = '';
        $rab = '';

        if(isset($_POST['proposal_lama'])){
            if($_FILES['file_proposal']['name'] != ''){
                if(file_exists(FCPATH.'assets/berkas/file_proposal/' . $post['proposal_lama'])){
                    unlink(FCPATH.'assets/berkas/file_proposal/' . $post['proposal_lama']);
                }
    
                $upload = $this->upload('file_proposal',$dir_proposal);
                if($upload !== false){
                    $proposal = $upload;
                }
            }

        } else{ 
            $upload = $this->upload('file_proposal',$dir_proposal);
            if($upload !== false){
                $proposal = $upload;
            }
        }

        if(isset($_POST['rab_lama'])){
            if($_FILES['file_rab']['name'] != ''){
                if(file_exists(FCPATH.'assets/berkas/file_rab/' . $post['proposal_lama'])){
                    unlink(FCPATH.'assets/berkas/file_rab/' . $post['proposal_lama']);
                }
    
                $upload = $this->upload('file_rab',$dir_rab);
                if($upload !== false){
                    $rab = $upload;
                }            
            }
        } else{ 
            $upload = $this->upload('file_rab',$dir_rab);
            if($upload !== false){
                $rab = $upload;
            }  
        }

        $kirim = [
            'file_proposal' => $proposal, 
            'file_rab' => $rab
        ];

        $tambahkan = $this->mandiri->update_file($kirim);
        if($tambahkan){
            $this->session->set_flashdata('success', 'Lampiran berkas berhasil disimpan!');
            $this->session->set_flashdata('key', 'success');
            redirect('C_pengabdian_dsn_mandiri/mandiri_pengajuan_pengabdian');
        } else{
            $this->session->set_flashdata('danger', 'Lampiran berkas tidak berhasil disimpan!');
            $this->session->set_flashdata('key', 'danger');
            redirect('C_pengabdian_dsn_mandiri/mandiri_pengajuan_pengabdian');
        }
    }

    public function upload($jenis,$dir_cv)
    { 
        $name = $_FILES[$jenis]['name'];
        $tmp = $_FILES[$jenis]['tmp_name'];
        $coba = explode('.', $name);
        $extension = $coba[count($coba)-1];
        $nama_file = 'proposal_mandiri_'. $_SESSION['nidn']. '_'.date("Y-m-d").'.'. $extension;
        if(move_uploaded_file($tmp, $dir_cv . '/' . $nama_file)){
            return $nama_file;
        } else{ 
            return false;
        }
        
    }


}