<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_landing_page extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if($this->google->isLoggedIn()){
            redirect('C_dashboard');
        }
        
    }

    public function index()
    {


        // if ($this->session->userdata('login') == true) {
        //     redirect('C_dashboard');
        // }

        $this->load->view('landing/index');
    }

    // akhircontroller

}
