<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Master_dosen extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function index_get()
    {
        $nip = $this->get('nip');
        $limit = $this->get('limit');
        $offset = $this->get('offset');
        $jenis_job = $this->get('jenis_job');
        $query  = "select nip,nik,nidn,nama,jenis_job,pangkat,email,telepon,alamat,tanggal_masuk,jenis_kelamin from dummy_dosen where 1";

        if($nip != null){
          $query .= " AND nip ='".$nip."'";
        }

        if($jenis_job != null){
          $query .= " AND jenis_job ='".$jenis_job."'";
        }

        if($limit == null) {
            $limit = 1000;
        } 

        if($offset == null) {
            $offset = 0;
        } 

        $add_limit = " LIMIT ".$offset.",".$limit;

        $query .= $add_limit;

        $coba = $this->db->query($query)->result();
        $this->response($coba, 200 );
    }
}