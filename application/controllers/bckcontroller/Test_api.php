<?php 

class Test_api extends CI_Controller{

  public function index()
  {
    $this->load->library('data_api');
    $dosen = json_decode($this->data_api->get_data(""));
    $plp = json_decode($this->data_api->get_data('jab_struktur=Teknisi / PLP'));

    echo json_encode($dosen);
    return;
    // foreach ($dosen as $val) {
    //   $data = ['nidn' => $val->nip, 'nip' => $val->nip, 'jenis_job' => 'dosen', 'nama' => $val->nama_lengkap, 'password' => password_hash('coba', PASSWORD_DEFAULT), 'badge' => $val->badge,'jenis_unit' => $val->jenis_unit, 'unit' => $val->unit];

    //   if($val->nip === '199009232015092001'){
    //     continue;
    //   }
      
    //   if(!$this->db->insert('dummy_dosen', $data)){
    //     continue;
    //   }
    // }
    // foreach ($plp as $val) {
    //   $data = ['nidn' => $val->nip, 'nip' => $val->nip, 'jenis_job' => 'plp', 'nama' => $val->nama_lengkap, 'password' => password_hash('coba', PASSWORD_DEFAULT), 'badge' => $val->badge,'jenis_unit' => $val->jenis_unit, 'unit' => $val->unit];

    //   if(!$this->db->insert('dummy_dosen', $data)){
    //     continue;
    //   }
    // }

  }

  public function hoho()
  {
    $this->load->library('data_api');
    $dosen = json_decode($this->data_api->get_data('nip=199009232015092001'));
    // $plp = json_decode($this->data_api->get_data('jab_struktur=Teknisi / PLP'));

    print_r($dosen);

    // foreach ($dosen as $val) {
    //   $data = ['nidn' => $val->nip, 'nip' => $val->nip, 'jenis_job' => 0, 'nama' => $val->nama_lengkap, 'password' => password_hash('coba', PASSWORD_DEFAULT), 'badge' => $val->badge,'jenis_unit' => $val->jenis_unit, 'unit' => $val->unit];

    //   $this->db->insert('dummy_dosen', $data);
    // }
    // foreach ($plp as $val) {
    //   $data = ['nidn' => $val->nip, 'nip' => $val->nip, 'jenis_job' => 0, 'nama' => $val->nama_lengkap, 'password' => password_hash('coba', PASSWORD_DEFAULT), 'badge' => $val->badge,'jenis_unit' => $val->jenis_unit, 'unit' => $val->unit];

    //   $this->db->insert('dummy_dosen', $data);
    // }

  }  
}