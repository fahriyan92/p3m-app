<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_log extends CI_Controller
{
	private $session_id;
	private $post;
	private $tanggal_now;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_log', 'mlog');
	}

	public function index()
	{
		$data['content'] = VIEW_SUPERADMIN . 'content_log';
		$data['judul'] = 'Audit Log';
		$data['brdcrmb'] = 'Beranda / Audit Log';
		$data['log'] = $this->mlog->get_data();

		$this->load->view('index', $data);
	}
}
