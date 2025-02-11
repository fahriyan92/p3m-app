
<?php 

class Anggota_dosen_revisi extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('login')){
            redirect('');
        }
        $this->load->model('M_mandiri','mandiri');
    }
    public function index()
    {
        $cek = $this->mandiri->get_status();
        $view = '';
        if(!$cek){
            $this->session->set_flashdata('danger','Oops ada yang salah');
            $this->session->set_flashdata('key','danger');
            redirect('C_penelitian_dsn_mandiri/mandiri_pengajuan_penelitian');
        }
        $view = VIEW_DOSEN . 'pengajuan_mandiri/anggota_dosen_revisi.php';
        $data['id_pengajuan'] = $cek['id_detail'];
        $ketua = $this->db->query("select id_anggota,sinta,file_cv from anggota_dosen_mandiri where nip='".$this->session->userdata('nidn')."' AND id_pengajuan_detail = ".$data['id_pengajuan'])->row();
        if($ketua !== null){
            $data['edit_ketua'] = $ketua;
        }
        $data['dosen'] = $this->list_dosen($cek['id_detail']);
        $data['judul'] = "Data Anggota Dosen";
        $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';
        $data['content'] = $view;
        $this->load->view('index', $data); 
    }
    private function list_dosen($id)    
    {
        $nip_ketua = $this->session->userdata('nidn');
        $sql = "select nidn,nama,jenis_job,jenis_unit,unit from dummy_dosen where jenis_job='dosen' AND nidn NOT IN((SELECT nip FROM anggota_dosen_mandiri WHERE id_pengajuan_detail = $id AND nip != '$nip_ketua' ))";
        $query = $this->db->query($sql)->result();
        $dosen = [];
        $ketua = [];

        foreach ($query as $value) {
            if ($value->nidn === $nip_ketua) {
                array_push($ketua, $value);
            } else {
                array_push($dosen, $value);
            }
        }

        $data = ['ketua' => $ketua, 'dosen' => $dosen];
        return $data;
    }
    public function get_anggota_dosen($id = null)
    {
        $status = $this->mandiri->get_status();
        if($status === null) {
            echo json_encode(['status' => 'error']);
            return;
        }
        $id_pengajuan = $status['id_detail'];
        $sql = "SELECT id_pengajuan_detail, id_anggota,a.sinta, a.nip, file_cv,a.status,b.nama, b.unit,b.jenis_unit FROM anggota_dosen_mandiri a INNER JOIN dummy_dosen b ON a.nip = b.nidn WHERE id_pengajuan_detail = '$id_pengajuan' AND a.status != 0 ";
        if($id !== null){
            $sql .= " AND id_anggota = $id";
        }
        $sql .= " ORDER BY a.status";
        $data = $this->db->query($sql)->result();
        echo json_encode(['status' => 'ok', 'data' => $data]);
        return;
    }
    public function store()
    {
        $post = $this->input->post();
        $nip = $post['nip'];
        $sinta = $post['sinta'];
        $id = $post['id_detail'];
        $upload_cv = $this->upload_cv($nip);
        $status = $nip == $this->session->userdata('nidn') ? 2 : 1;
        $kirim = ['id_pengajuan_detail' => $id, 'nip' => $nip, 'sinta' => $sinta, 'file_cv' => $upload_cv, 'status' => $status, 'created_at' => date('Y-m-d H:i:s')];
        $insert = $this->mandiri->store($kirim);
        echo json_encode(['status' => $insert]);
        return;
    } 
    public function update()
    {
        $post = $this->input->post();
        $id = $post['id_anggota'];
        $sinta = $post['sinta'];
        $id_detail = $post['id_detail'];

        $update = ['sinta' => $sinta, 'updated_at' => date('Y-m-d H:i:s')];
        if(isset($_FILES['cv'])){
            $data = $this->db->query("select file_cv,nip from anggota_dosen_mandiri where id_anggota = $id")->row();
            $this->delete_cv($data->file_cv);
            $upload = $this->upload_cv($data->nip);
            $update['file_cv'] = $upload;
        } 

        $this->db->trans_start();
        $this->db->where('id_pengajuan_detail', $id_detail);
        $this->db->update('pengajuan_detail_mandiri', ['updated_at' => date('Y-m-d H:i:s')]);
        $this->db->where('id_anggota', $id);
        $this->db->update('anggota_dosen_mandiri', $update);
        $this->db->trans_complete();

        echo json_encode(['status' => 'ok']);
        //get data anggota where nip 
        //dapet nasma file cv lama 
        //delete cv 
        //upload cv 
        //edit biasa where nip
    } 
    public function upload_cv($nip)
    {
        // $dir_cv = realpath(APPPATH . '../assets/berkas/file_cv/').'/';
        $name = $_FILES['cv']['name'];
        $coba = explode('.',$name);
        $extension = $coba[count($coba) -1];
        $nama_file = 'cv_'.$nip.'_'.date("Y-m-d-H:i:s") . '.'. $extension;
        $config['upload_path'] = realpath(APPPATH . '../assets/berkas/file_cv/');
        $config['allowed_types'] = 'pdf';
        $config['file_name'] = 'cv_'.$nip.'_'.date("YmdHis") ;
        $this->load->library('upload',$config);

        if($this->upload->do_upload('cv')){
            return $this->upload->data('file_name');
        } else {
            return false;
        }
    }
    private function delete_cv($cv)
    {
        $dir_cv = realpath(APPPATH . '../assets/berkas/file_cv/');
        if(file_exists($dir_cv.'/'.$cv))
        {
            $hapus = unlink($dir_cv.'/'. $cv);
            return true;
        } else{
            return false;
        }
    }

}
