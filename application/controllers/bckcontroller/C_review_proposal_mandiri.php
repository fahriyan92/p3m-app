<?php 

class C_review_proposal_mandiri extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    if (!$this->session->userdata("login")) {
      redirect('');
    }
    $this->load->model('M_reviewer', 'reviewer');
  }

  public function index()
  {
    $username = $this->session->userdata('username');
    $data['username'] = $username;
    $data['brdcrmb'] = 'Beranda';
    $data['role'] = 'Admin';
    $data['content'] = VIEW_ADMIN . 'content_review_proposal_mandiri';
    // $data['review'] = $this->kerjaan_reviewer();

    $this->load->view('index', $data);
  }


  public function list_proposal_mandiri()
  {
      $id_jenis = $this->input->post('id_jenis');
      $status = $this->input->post('status');
      $tahun = $this->input->post('tahun');


      if ($tahun === null ){
        $tahun = date('Y');
      }

      $where = ['a.status >' => 7, 'c.id_jenis' => $id_jenis,'(a.status_koreksi = 0 OR a.status_koreksi = 2)' => null];
      if($status == 1){
        $where = ['a.status >' => 7, 'c.id_jenis' => $id_jenis,'a.status_koreksi' => 1];
      } 
      $where['b.tahun_usulan'] = $tahun;

      $dt = $this->reviewer->get_proposal_mandiri_byEvent($where);

      echo json_encode($dt);
  }



}