<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Pendanaan extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function index_get()
    {
        $query  = "select * from pendanaan";
        $coba = $this->db->query($query)->result();
        $this->response($coba, 200 );
    }
}