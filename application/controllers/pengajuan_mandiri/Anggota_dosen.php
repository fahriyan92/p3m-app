<?php 


class Anggota_dosen extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata("login")) {
            redirect('');
        }
        $this->load->library('form_validation');
        $this->load->model('M_mandiri','mandiri');
    }

    public function index()
    {
        $cek = $this->mandiri->get_status();
        $view = '';

        if(!$cek){
            $this->session->set_flashdata('danger', 'Opps ada yang salah');
            $this->session->set_flashdata('key', 'danger');
            redirect('C_penelitian_dsn_mandiri/mandiri_pengajuan_penelitian');
        } 

        if($cek['status'] == 1){
          // input anggota pertama kali
          $view = VIEW_DOSEN . 'pengajuan_mandiri/anggota_dosen.php';
        
        } elseif ($cek['status'] > 1) {
            $data_ketua = $this->mandiri->get_anggota(['id_pengajuan_detail' => $cek['id_detail'], 'a.nip' => $this->session->userdata('nidn')])->row();
            $anggota = $this->mandiri->get_anggota(['id_pengajuan_detail' => $cek['id_detail'], 'a.nip !=' => $this->session->userdata('nidn'), 'a.status !=' => 0])->result();
            $data['edit_ketua'] = $data_ketua;
            $data['edit_anggota'] = count($anggota) == 0 ? null : $anggota;
            $view = VIEW_DOSEN . 'pengajuan_mandiri/anggota_dosen_update.php';
            $data['id_detail'] = $cek['id_detail'];
        }   
        
        $data['pake_gak'] = '';
        $data['dosen'] = $this->list_dosen();
        $data['mode'] = 'tambah';
        $data['judul'] = $data['mode'] === 'edit' ? 'Edit Anggota Dosen' :'Tambahkan Anggota Dosen';
        $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';
        $data['content'] = $view;
        $this->load->view('index', $data); 
    }

    public function satu()
    {
        $id_pengajuan = $this->mandiri->id_pengajuan();
        $id_detail = null;
        if($id_pengajuan !== null){
            $where = ['id_pengajuan' => $id_pengajuan->id_pengajuan, 'status !=' => 8];
            $id_detail = $this->mandiri->pengajuan_mandiri($where)->row();

            if($id_detail !== null){
                $data['ketua'] = $this->mandiri->get_data_anggota(['nip' => $_SESSION['nidn'], 'id_pengajuan_detail' => $id_detail->id_detail])->row();

                $anggota = $this->mandiri->get_data_anggota_join(['a.nip !=' => $_SESSION['nidn'], 'a.id_pengajuan_detail' => $id_detail->id_detail])->result();

                $data['pake_gak'] = count($anggota) > 1 ? 'checked' : '';
                $data['anggota'] = $anggota;
            } else{ 
                $this->session->set_flashdata('danger', 'Opps ada yang salah');
                $this->session->set_flashdata('key', 'danger');
                redirect('C_penelitian_dsn_mandiri/mandiri_pengajuan_penelitian');  
            }
        } else{
            $this->session->set_flashdata('danger', 'Opps ada yang salah');
            $this->session->set_flashdata('key', 'danger');
            redirect('C_penelitian_dsn_mandiri/mandiri_pengajuan_penelitian');
        }    
        
        $data['pake_gak'] = '';
        $data['dosen'] = $this->list_dosen();
        $data['mode'] = 'tambah';
        $data['judul'] = 'Menunggu Respon Anggota';
        $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';
        $data['content'] = VIEW_DOSEN . 'pengajuan_mandiri/anggota_dosen_satu.php';
        $this->load->view('index', $data); 
    }   

    private function list_dosen()
    {
        $sql = "select nidn,nama,jenis_job,jenis_unit,unit from dummy_dosen where jenis_job='dosen'";
        $query = $this->db->query($sql)->result();
        $sql_anggota_dsn = "select nidn from tb_anggota_dosen";
        $query_anggota = $this->db->query($sql_anggota_dsn)->result();
        $dosen = [];
        $ketua = [];

        foreach ($query as $value) {
            if ($value->nidn === $this->session->userdata('nidn')) {
                array_push($ketua, $value);
            } else {
                array_push($dosen, $value);
            }
        }

        $data = ['ketua' => $ketua, 'dosen' => $dosen];
        return $data;
    }


    public function store()
    {
        //echo isset($_POST['pakegak']) ? 'make anggota 2' : 'gak make anggota 2';

        $post = $this->input->post();
        // echo json_encode($_FILES['cv1']['size']);
        $rules = array(
            array(
              'field' => 'sinta1',
              'label' => 'Sinta Ketua',
              'rules' => 'trim|required|max_length[8]'
            ), 
            array(
                'field' => 'nip2',
                'label' => 'Nip Anggota 1',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'sinta2',
                'label' => 'Sinta Anggota 1',
                'rules' => 'trim|required|max_length[8]'
            )                                        
        );

        if(isset($post['pakegak'])){
            array_push($rules, ['field' => 'nip3','label' => 'Nip Anggota 2','rules' => 'trim|required']);
            array_push($rules, ['field' => 'sinta3','label' => 'Sinta Anggota 2','rules' => 'trim|required|max_length[8]']);

            if(empty($_FILES['cv3']['name'])){
                $hello = 
                array(
                    'field' => 'cv3',
                    'label' => 'CV Anggota 2',
                    'rules' => 'required|xss_clean'
                );
                array_push($rules, $hello);
            }                 
            $data['pake_gak'] = 'checked';

        } else {
            $data['pake_gak'] = '';
        }

        if(empty($_FILES['cv1']['name'])){
            $hello = 
            array(
                'field' => 'cv1',
                'label' => 'CV Ketua',
                'rules' => 'required|xss_clean'
            );
            array_push($rules, $hello);
        }

        if(empty($_FILES['cv2']['name'])){
            $hello = 
            array(
                'field' => 'cv2',
                'label' => 'CV Anggota 1',
                'rules' => 'required|xss_clean'
            );
            array_push($rules, $hello);
        }        

        $this->form_validation->set_message('required','%s harus diisi');
        $this->form_validation->set_message('max','maksimal %d karakter');
        $this->form_validation->set_rules($rules);

        if($this->form_validation->run() === FALSE){
            $data['dosen'] = $this->list_dosen();
            $data['mode'] = 'tambah';
            $data['judul'] = $data['mode'] === 'edit' ? 'Edit Anggota Dosen' :'Tambahkan Anggota Dosen';
            $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';
            $data['content'] = VIEW_DOSEN . 'pengajuan_mandiri/anggota_dosen.php';
            $this->load->view('index', $data);        
    
          return;
        }   
        $cv1 = '';
        $cv2 = '';
        $cv3 = '';
        
        $kirim = [
            'nip_ketua' => $this->session->userdata('nidn'),
            'sinta1' => $post['sinta1'], 
            'nip1' => $post['nip2'],
            'sinta2' => $post['sinta2'],
            'pake_gak' => isset($post['pakegak']) ? 1 : 0,
            'created_date' => date("Y-m-d H:i:s")
        ];


        $nip = [$this->session->userdata('nidn'), $post['nip2']];
        $berapa = 3;
        if(isset($post['pakegak'])){
            array_push($nip, $post['nip3']);
            $berapa = 4;
        }
        
        $upload = $this->uplaod_cv($_FILES,$nip,$berapa);

        if(isset($post['pakegak'])){
            $kirim['nip3'] = $post['nip3'];
            $kirim['sinta3'] = $post['sinta3'];
            $kirim['file_cv3'] = $upload['file_cv'][2];
        } 

        if(!in_array(null, $upload['error'])){
            $this->session->set_flashdata('danger', 'Tidak Berhasil Menyimpan');
            $this->session->set_flashdata('key', 'danger');
            redirect('C_penelitian_dsn_mandiri/mandiri_pengajuan_penelitian');
        } 

        $kirim['file_cv1'] = $upload['file_cv'][0];
        $kirim['file_cv2'] = $upload['file_cv'][1];

        $tambahkan = $this->mandiri->tambah_anggota($kirim);
        if($tambahkan){
            $this->session->set_flashdata('success', 'Data Anggota dosen Berhasil disimpan!');
            $this->session->set_flashdata('key', 'success');
            redirect('C_penelitian_dsn_mandiri/mandiri_pengajuan_penelitian');
        } else{
            $this->session->set_flashdata('danger', 'Data Anggota dosen tidak berhasil disimpan!');
            $this->session->set_flashdata('key', 'danger');
            redirect('C_penelitian_dsn_mandiri/mandiri_pengajuan_penelitian');
        }
    }

    public function update()
    {
        $id_detail = $_POST['id_detail'];

        $this->db->trans_start();
        for($i=1 ; $i < 4 ; $i++){
            if(!isset($_POST['nip'.$i])){
                continue;
            } else{ 
                if($_POST['nip'.$i] == ''){
                    continue;
                }
            }            

            $nip = $_POST['nip'.$i];
            $sinta = $_POST['sinta'.$i];
            $cv = $_POST['cv'.$i];
            
            $where = ['a.nip' => $nip, 'id_pengajuan_detail' => $id_detail];
            $data_dosen = $this->mandiri->get_anggota($where)->row();

            if($data_dosen !== null){
                // 2 update , status tetap 2 , 0 , status jadikan 1     

                if(empty($_FILES['cv'.$i]['name'])){
                    $kirim = ['sinta' => $_POST['sinta'.$i], 'updated_at' => date('Y-m-d H:i:s')];
                    if($data_dosen->status == 0){
                        $kirim['status'] = 1;
                    }                        
                    $this->db->where(['id_pengajuan_detail' => $id_detail, 'nip' => $nip]); 
                    $this->db->update('anggota_dosen_mandiri', $kirim);
                } else{ 
                      $this->delete_cv($_POST['cv'.$i]);
                        $upload = $this->upload_document($nip, $i);
                        if($upload){
                            $kirim = ['sinta' => $_POST['sinta'.$i], 'updated_at' => date('Y-m-d H:i:s'), 'file_cv' => $upload];
                            if($data_dosen->status == 0){
                                $kirim['status'] = 1;
                            }                        
                            $this->db->where(['id_pengajuan_detail' => $id_detail, 'nip' => $nip]); 
                            $this->db->update('anggota_dosen_mandiri', $kirim);
                        }
                    
                }                

            } else { 
                $upload = $this->upload_document($nip, $i);
                if($upload){
                    $kirim = ['id_pengajuan_detail' => $id_detail, 'nip' => $nip, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'file_cv' => $upload, 'sinta' => $_POST['sinta'.$i]]; 

                    $this->db->insert('anggota_dosen_mandiri', $kirim);
                }
            }

            
            // ketika status = 2 itu update 
            
            // ketika null = insert  
        }
        $this->db->trans_complete();

        if($this->db->trans_status() === true){
            $this->session->set_flashdata('success', 'Data Anggota dosen Berhasil disimpan!');
            $this->session->set_flashdata('key', 'success');
            redirect('C_penelitian_dsn_mandiri/mandiri_pengajuan_penelitian');
        } else{
            $this->session->set_flashdata('danger', 'Data Anggota dosen tidak berhasil disimpan!');
            $this->session->set_flashdata('key', 'danger');
            redirect('C_penelitian_dsn_mandiri/mandiri_pengajuan_penelitian');
        }
    }

    public function delete_cv($cv)
    {
        $dir_cv = realpath(APPPATH . '../assets/berkas/file_cv/');
        if (file_exists($dir_cv .'/'. $cv)) {
            $hapus = unlink($dir_cv.'/' . $cv);
            return true;
        } else { 
            return false;
        }

    }

    public function insert()
    {
        
    }

    public function ngedit()
    {
        
    }

    public function upload_document($nip,$nomer)
    {
        $dir_cv = realpath(APPPATH . '../assets/berkas/file_cv/');
        $name = $_FILES['cv'.$nomer]['name'];
        $coba = explode('.', $name);
        $extension = $coba[count($coba)-1];
        $nama_file = 'cv_'. $nip. '_'.date("Y-m-d").'.'. $extension;
        $tmp = $_FILES['cv'.$nomer]['tmp_name'];

        if(!move_uploaded_file($tmp, $dir_cv. '/'.$nama_file)){
            return false; 
        } else { 
            return $nama_file; 
        }
    }

    private function uplaod_cv($files,$data,$berapa)
    {
        $dir_cv = realpath(APPPATH . '../assets/berkas/file_cv/');
        $nama_cv = [];
        $error = [];

        for($i = 1; $i < $berapa; $i++){
            $name = $_FILES['cv'.$i]['name'];
            $coba = explode('.', $name);
            $extension = $coba[count($coba)-1];
            $nama_file = 'cv_'. $data[$i-1]. '_'.date("Y-m-d").'.'. $extension;
            $tmp = $_FILES['cv'.$i]['tmp_name'];

            if(!move_uploaded_file($tmp, $dir_cv . '/' . $nama_file)){
                array_push($error, 'error');
                array_push($nama_cv,null);
            } else{ 
                array_push($error, null);
                array_push($nama_cv,$nama_file);
            }
        }

        return['file_cv' => $nama_cv, 'error' => $error];
    }

    public function simpan()
    {
        echo json_encode($_POST);
        echo '<br>';
        echo json_encode($_FILES);
        return;
    }
    
    
}