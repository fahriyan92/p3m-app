<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_landing_page extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('google');
        if ($this->google->isLoggedIn()) {
            redirect('C_dashboard');
        }
        $this->load->model('M_event', 'event');
        $this->load->model('M_jenis_event', 'MjnsEvent');
    }

    public function index()
    {
        $tahun = date('Y');
        $data['list'] = $this->event->list_event_asc2($tahun);
        $data['jenis_event'] = $this->event->get_data('tb_event');
        $data['jenis_pendanaan'] = $this->event->get_data('tb_pendanaan');
        $data['tahapan'] = $this->event->list_event_asc2($tahun);
        $this->load->view('landing/index', $data);
    }

    // akhircontroller

}
