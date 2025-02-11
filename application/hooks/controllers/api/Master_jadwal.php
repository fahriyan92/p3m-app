<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Master_jadwal extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function index_get()
    {
        $query = 'SELECT DATE_FORMAT(mulai,"%Y") AS tahun,upper(event) AS event, mulai tanggal_mulai, akhir AS tanggal_selesai FROM view_list_event where tahapan = "monev"';

        $tahun = $this->get('tahun');
        $event = $this->get('event');

        $limit = $this->get('limit');
        $offset = $this->get('offset');

        if($tahun != null){
          $query .= " AND DATE_FORMAT(mulai,'%Y') ='".$tahun."'";
        }

        if($event != null){
            $event = strtoupper($event);
            if($event == "PENELITIAN" || $event === "PENGABDIAN") {
                $query .= " AND UPPER(event) = '".$event."'";
            }
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