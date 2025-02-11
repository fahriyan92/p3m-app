<?php 


class Registrasi_dosen extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    
  }

  public function registrasi()
  {
    $post = $this->input->post();
    $this->load->library('data_api');

    //terima post nya 
    
    //get data where nip
    $data_dosen = json_decode($this->data_api->get_data('jab_struktur=Dosen&nip='.$post['nip']));
    
    // if(count($data_dosen) > 0 ){
    //   // isi ke db 
    // } else {
    //   $data_plp = json_decode($this->data_api->get_data('jab_struktur=Dosen&nip='.$post['nip']));
    // }

    $data_plp = $this->data_api->get_data('jab_struktur=Teknisi / PLP&nip=198112162003121003');
    //insert ke dummy dosen 
  }

  private function store($jenis)
  {

  }
}