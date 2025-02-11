<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_penelitian_tkns extends CI_Controller
{
    public function index()
    {
        // content
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_DOSEN . 'content_penelitian_teknisi';
        $data['username'] = $username;
        $data['judul'] = 'Pengajuan Penelitian Teknisi';
        $data['brdcrmb'] = 'Beranda / Penelitian Tenisi';

        $this->load->view('index', $data);
    }

    public function noEvent()
    {
        // content
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_DOSEN . 'content_noEvent';
        $data['username'] = $username;
        $data['judul'] = 'Pengajuan Penelitian Teknisi';
        $data['brdcrmb'] = 'Beranda / Penelitian Tenisi';

        $this->load->view('index', $data);
    }

    public function status()
    {
        // content
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_DOSEN . 'content_status';
        $data['username'] = $username;
        $data['judul'] = 'Pengajuan Penelitian Teknisi';
        $data['brdcrmb'] = 'Beranda / Penelitian Tenisi';

        $this->load->view('index', $data);
    }

    // akhircontroller

}
