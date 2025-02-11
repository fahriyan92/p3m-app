<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_hindex extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata("login")) {
            redirect('');
        }
        $this->load->model('M_pnbp', 'pnbp');
        $this->load->model('M_hindex', 'hindex');
    }
    private function response($res)
    {

        $pesan = ['code' => $res[0], 'pesan' => $res[1]];

        return json_encode($pesan);
    }
    private function insert_log($data){
      $insert_data = [
        'id_staff' => $this->session->userdata('id'),
        'nama_staff' => $this->session->userdata('nama'),
        'role_staff' => $this->session->userdata('level'),
        'event_staff' => $data[0],
        'ket_aktivitas' => $data[1],
        'created_at' => date('Y-m-d H:i:s'),
      ];
      // print_r($insert_data);
      $this->db->insert('tb_log', $insert_data);
    }

    private function get_pegawai()
    {
        $this->load->library('data_api');
        return json_decode($this->data_api->get_data());
    }

    public function index()
    {
        // content
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'content_hindex';
        $data['username'] = $username;
        $data['judul'] = 'Kuota Pengajuan Proposal';
        $data['brdcrmb'] = 'Beranda / Kuota Pengajuan Proposal / Tambah';

        $this->load->view('index', $data);
    }

    public function tambah_Hindex()
    {
        // content
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'content_tambah_hindex';
        $data['username'] = $username;
        $data['judul'] = 'Limit Proposal';
        $data['brdcrmb'] = 'Beranda / Limit Proposal / Tambah';
        $data['dosen'] = $this->list_dosen();

        $this->load->view('index', $data);
    }
    public function edit_Hindex($id)
    {
        $id_dsn = $this->uri->segment(3);
        // content
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'content_edit_hindex';
        $data['username'] = $username;
        $data['judul'] = 'Edit Limit Proposal';
        $data['brdcrmb'] = 'Beranda / Limit Proposal / Edit';
        $data['datanya'] = $this->hindex->get_where('tb_hindex', array('id_hindex' => $id_dsn))->row_array();
        // print_r($a);
        // return ;
        $this->load->view('index', $data);
    }
    public function action_store()
    {
        $post = $this->input->post();

        $kirim = array(

            'nidsn_dosen' => $post['nidn'],
            'nama_dosen' => $post['nama'],
            // 'id_sinta' => $post['sinta'],
            'h_index_scopus' => $post['hindex_scopus'],
            'h_index_schoolar' => $post['hindex_schoolar'],
            'limit_pengabdian' => $post['limit_pengabdian'],
            'limit_penelitian' => $post['limit_penelitian'],

        );

        $insert = $this->hindex->insert('tb_hindex', $kirim);

        if ($insert === false) {
            print_r($this->response([0, 'tidak berhasil menambahkan data']));
            return;
        }
        $this->insert_log(['CREATE', 'CREATE PADA LIMIT DOSEN']);
        print_r($this->response([1, 'berhasil menambahkan data']));
        return;
    }
    public function action_edit()
    {

        $post = $this->input->post();

        $kirim = array(

            'nidsn_dosen' => $post['nidn'],
            'nama_dosen' => $post['nama'],
            // 'id_sinta' => $post['sinta'],
            'h_index_scopus' => $post['hindex_scopus'],
            'h_index_schoolar' => $post['hindex_schoolar'],
            'limit_pengabdian' => $post['limit_pengabdian'],
            'limit_penelitian' => $post['limit_penelitian'],

        );

        $insert = $this->hindex->update('tb_hindex', $kirim, array('id_hindex' => $post['id_hindex']));

        if ($insert === false) {
            print_r($this->response([0, 'tidak berhasil update data']));
            return;
        }
        $this->insert_log(['UPDATE', 'UPDATE PADA LIMIT DOSEN']);

        print_r($this->response([1, 'berhasil update data']));
        return;
    }
    public function action_delete()
    {
        $id_dsn = $this->uri->segment(3);

        $this->db->delete('tb_hindex', array('id_hindex' => $id_dsn));
        $this->insert_log(['DELETE', 'DELETE PADA LIMIT DOSEN']);


        redirect('C_hindex');
        return;
    }
    public function get_hindex_dosen()
    {
        $list = $this->hindex->get_data_all_relational()->result();
        $bg = '';



        $result = '';
        for ($i = 0; $i <= count($list) - 1; $i++) {
            if ($list[$i]->jenis_job == "dosen") {
                $bg = "class = 'badge badge-info'";
            } elseif ($list[$i]->jenis_job == "plp") {
                $bg = "class = 'badge badge-secondary'";
            } else {
                $bg = "class = 'badge badge-danger'";
            }
            $result .= '<tr>';
            $result .= '<td class="text-capitalize">' . $list[$i]->nidsn_dosen . '</td>';
            $result .= '<td>' . $list[$i]->nama_dosen . '</td>';
            // $result .= '<td>' . $list[$i]->id_sinta . '</td>';
            $result .= '<td>' . $list[$i]->h_index_scopus . '</td>';
            $result .= '<td>' . $list[$i]->h_index_schoolar . '</td>';
            $result .= '<td>' . $list[$i]->limit_penelitian . '</td>';
            $result .= '<td>' . $list[$i]->limit_pengabdian . '</td>';
            $result .= '<td class="text-center" > <span ' . $bg . '>' . $list[$i]->jenis_job . '</span></td>';

            $result .= '<td class="text-center"><a href="' . base_url('C_hindex/edit_Hindex/') . $list[$i]->id_hindex . '" id="' . $list[$i]->id_hindex . '" class="btn btn-sm btn-warning"><i class="fa fa-fw fa-edit"></i></a><a href="' . base_url('C_hindex/action_delete/') . $list[$i]->id_hindex . '" id="' . $list[$i]->id_hindex . '" class="btn btn-sm btn-danger"><i class="fa fa-fw fa-trash"></i></a></td>';
            $result .= '</tr>'; }
        echo $result;
        // print_r(json_encode($list));
    }
    public function list_dosen()
    {
        $get_dosen = "select nidn,nama from dummy_dosen ";
        $query = $this->db->query($get_dosen)->result();
        $check_dosen = "select nidsn_dosen from tb_hindex";
        $query_anggota = $this->db->query($check_dosen)->result_array();
        $dosen = [];
        // print_r($query);
        // return;
        foreach ($query as $value) {
            if (array_search(trim($value->nidn), array_column($query_anggota, 'nidsn_dosen')) == false) {
                array_push($dosen, $value);
            }
        }
        return $dosen;
    }
    // akhircontroller

}
