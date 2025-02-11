<?php 

class C_nilai_mandiri extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_reviewer', 'reviewer');
        $this->load->model('M_fokus','Mfokus');
    }

    public function index($id = null)
    {
        if($id === null){
            redirect('C_review_proposal_mandiri');
        }

              
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'content_penilaian_mandiri';
        $data['username'] = $username;
        $data['judul'] = 'Review Pengajuan';
        $data['brdcrmb'] = 'Beranda / Nilai Pengajuan Mandiri';

        $data['dt_proposal'] = $this->reviewer->get_proposalnya_mandiri($id);
        $data['luaran'] = $this->reviewer->get_luaran();
		if($data['dt_proposal']->id_event == 1){
			$data['luaran'] = $this->Mfokus->kel_luaran_penelitian_dosen('tb_luaran')->result();
			// $data['kelompok'] = $this->Mfokus->kel_luaran_penelitian_dosen('tb_kelompok_pengajuan')->result();		
		} else{
			$data['luaran'] = $this->Mfokus->kel_luaran_pengabdian_dosen('tb_luaran')->result();
        }        
        $data['luaran_checked'] = null;
        $data['luaran_tambahan'] = null;
        if (isset($data['dt_proposal']->id_pengajuan)) {
            $data['dosen'] = $this->reviewer->get_anggota_dosen($data['dt_proposal']->id_pengajuan);
            $data['mahasiswa'] = $this->reviewer->get_anggota_mahasiswa($data['dt_proposal']->id_pengajuan);
            $arr = [];
            foreach ($this->reviewer->get_luaran_checked_mandiri($data['dt_proposal']->id_pengajuan) as $value) {
                array_push($arr, $value->id_luaran);
            }

            if ($data['dt_proposal']->is_nambah_luaran === "1") {
                $data['luaran_tambahan'] = $this->reviewer->luaran_tambahan_mandiri($data['dt_proposal']->id_pengajuan);
            }

            $data['luaran_checked'] = $arr;
        } else {
            echo 'gabisa';
            return;
        }

        $this->load->view('index', $data);        
    }

    public function store_komentar()
    {
        $post = $this->input->post();
        $status = $post['diterima'];
        $komentar = $post['komentar'];
        $id = $post['id_pengajuan'];

        $this->db->trans_start();
        $this->db->where('id_pengajuan_detail', $id);
        $this->db->update('pengajuan_detail_mandiri', ['status_koreksi' => $status , 'status' => $status == 1 ? 8 : 7]);    

        $this->db->select('id_komentar');
        $this->db->where('id_pengajuan_detail',$id);
        $id_komentar = $this->db->get('komentar_mandiri')->row();


        if($id_komentar === null){
            $this->db->insert('komentar_mandiri', ['id_pengajuan_detail' => $id, 'komentar' => $komentar]);
        } else{ 
            $this->db->where('id_komentar', $id_komentar->id_komentar);
            $this->db->update('komentar_mandiri', ['komentar' => $komentar]);
        }
     
        $this->db->trans_complete();

        redirect('C_review_proposal_mandiri');
    }
}