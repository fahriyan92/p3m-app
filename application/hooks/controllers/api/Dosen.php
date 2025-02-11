<?php 

class Dosen extends CI_Controller{
  
  public function get_dosen_data($nidn = null){
    $sql = "select * from dummy_dosen a";
    
    if($nidn <> null){
      $sql .= " where nidn= '".$nidn."'";
    }

    $data = $this->db->query($sql)->result();
    
    $data_kirim = [
      'status' => 'success',
      'data' => $data
    ];

    echo json_encode($data_kirim);
  }
}