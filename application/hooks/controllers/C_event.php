<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_event extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata("login")) {
            redirect('');
        }
        $this->load->model('M_event', 'event');
        $this->load->model('M_jenis_event', 'MjnsEvent');
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

    // public function index()
    // {
    //     // content
    //     $username = $this->session->userdata('username');
    //     $data['content'] = VIEW_ADMIN . 'content_event';
    //     $data['username'] = $username;
    //     $data['judul'] = 'Event';
    //     $data['brdcrmb'] = 'Beranda / Event';
    //     $data['event'] = $this->db->get('tb_event')->result();

    //     $this->load->view('index', $data);
    // }
    public function index()
    {
        // content
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'content_tambah_event';
        $data['username'] = $username;
        $data['judul'] = 'Event';
        $data['brdcrmb'] = 'Beranda / Event / Tambah';
        $data['jenis_event'] = $this->event->get_data('tb_event');
        $data['jenis_pendanaan'] = $this->event->get_data('tb_pendanaan');
        $data['tahapan'] = $this->event->get_data('tb_tahapan');
        $data['jns'] = $this->MjnsEvent->all_data()->result();

        $this->load->view('index', $data);
    }
    public function proses_update()
    {
        $id = $this->uri->segment(3);
        $judul = $this->input->post('inputJudul');
        $start_date = $this->input->post('inputStart');
        $end_date = $this->input->post('inputEnd');
        $jenis = $this->input->post('inputJenis');

        if ($judul === '' || $start_date === '' || $end_date === '' || $jenis === '') {
            $this->session->set_flashdata('alert', 'Form Harus Di isi Semua');
            redirect('C_event');
        } else {

            $data = array(
                'nama_event' => $judul,
                'tanggal_mulai' => $start_date,
                'tanggal_selesai' => $end_date,
                'jenis_event' => $jenis,
            );


            $this->db->set('updated_date', 'NOW()', FALSE);
            $this->event->update('tb_event', $data, array('id_event' => $id));
            $this->session->set_flashdata('success', 'Di ubah');



            redirect('C_event');
        }
    }

    public function update()
    {
        $post = $this->input->post();
        $id_list = $post['id'];
        $id_tahapan = $post['id_tahapan'];
        $id_jenis = $post['id_jenis'];
        $mulai = $post['mulai'];
        $akhir = $post['akhir'];

        $data = [
            'id_jenis_event' => $post['id_jenis'],
            'id_tahapan' => $post['id_tahapan'],
            'waktu_mulai' => $post['mulai'],
            'waktu_akhir' => $post['akhir'] === '' ? null : $post['akhir']
        ];            

        $this->db->where('id_list_event', $id_list);
        $update = $this->db->update('tb_list_event', $data);

        if ($update === false) {
            print_r($this->response([0, 'Tidak berhasil Mengedit Data']));
            return;
        }

        $this->insert_log(['UPDATE', 'UPDATE PADA EVENT']);

        print_r($this->response([1, 'berhasil Mengedit Data']));
        return;
    }

    public function delete()
    {
        $post = $this->input->post();
        $id_list = $post['id'];

        $check_deletable = $this->check_deletable($id_list);

        if ($check_deletable === false) {
            print_r($this->response([0, 'Tidak Bisa Menghapus Data, Ada Pengajuan Di Event Ini']));
            return;
        }

        $data = [
            'status' => 0
        ];            

        $this->db->where('id_list_event', $id_list);
        $delete = $this->db->update('tb_list_event', $data);

        if ($delete === false) {
            print_r($this->response([0, 'Tidak berhasil Menghapus Data']));
            return;
        }
        $this->insert_log(['DELETE', 'DELETE PADA EVENT']);

        print_r($this->response([1, 'berhasil Menghapus Data']));
        return;
    }    

    public function check_deletable($id = null){
        if($id == null){
            $id = 0;
        }
        $query = "
            select 1
            from tb_pengajuan
            where id_list_event = 
            (
            select id from view_list_event where tahapan = 'penerimaan proposal' AND status = 1  AND date_format(mulai,'%Y') = 
                (
                    select date_format(mulai,'%Y') as tahun from view_list_event where id = ".$id." 
                ) 
            )
            limit 1;
        ";
        $e_query = $this->db->query($query)->row();
        if($e_query != null){
            return false;
            //echo "false";
        } else {
            return true;
            //echo "true";
        }

        //kalo return true berati false berati ada proposal di event itu dan tidak bisa lanjut, kalo false berati tidak ada dan bisa lanjut
    }

    public function get_list_event($tahun = null)
    {
        if($tahun == null){
            $tahun = date('Y');
        }
        $list = $this->event->list_event_asc($tahun);

        $penelitian = '';
        $pengabdian = '';
        $a=0;
        $b=0;
        for ($i = 0; $i <= count($list) - 1; $i++) {
            if($list[$i]->id_event == 1){
                $a++;
                $akhir = $list[$i]->akhir === null ? '-' : tanggal_indo($list[$i]->akhir);
                $penelitian .= '<tr>';
                $penelitian .= '<td class="text-uppercase">' . $a . '.</td>';
                $penelitian .= '<td class="text-uppercase">' . $list[$i]->tahapan . '</td>';
                $penelitian .= '<td class="text-center">' . tanggal_indo($list[$i]->mulai) . '</td>';
                $penelitian .= '<td class="text-center">' . $akhir . '</td>';
                $penelitian .= '<td class="text-center"><a href="#" id="' . $list[$i]->id . '" class="btn btn-xs btn-warning btn-edit"><i class="fa fa-fw fa-edit"></i></a><a href="#" id="' . $list[$i]->id . '" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-fw fa-trash"></i></a></td>';
                $penelitian .= '</tr>';
            } else{ 
                $b++;
                $akhir = $list[$i]->akhir === null ? '-' : tanggal_indo($list[$i]->akhir);
                $pengabdian .= '<tr>';
                $pengabdian .= '<td class="text-capitalize">' . $b . '</td>';
                $pengabdian .= '<td class="text-uppercase">' . $list[$i]->tahapan . '</td>';
                $pengabdian .= '<td class="text-center">' . tanggal_indo($list[$i]->mulai) . '</td>';
                $pengabdian .= '<td class="text-center">' . $akhir . '</td>';
                $pengabdian .= '<td class="text-center"><a href="#" id="' . $list[$i]->id . '" class="btn btn-xs btn-warning btn-edit"><i class="fa fa-fw fa-edit"></i></a><a href="#" id="' . $list[$i]->id . '" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-fw fa-trash"></i></a></td>';
                $pengabdian .= '</tr>';                
            }
        }

        echo json_encode([$penelitian,$pengabdian]);
        // print_r(json_encode($list));
    }

    public function action_store()
    {
        $post = $this->input->post();
        $wr_jenis = ['id_pendanaan' => 1, 'id_event' => $post['event']];
        $id_jenis_event = $this->event->get_where('tb_jenis_event', $wr_jenis)->row();
        $tgl_sama = $this->event->tanggal_cek($post['mulai']);

        if ($tgl_sama !== null) {
            print_r($this->response([2, 'Sudah ada event di tanggal itu.']));
            return;
        }

        $kirim = array(
            'list' => array(
                'id_jenis_event' => $post['event'],
                'id_tahapan' => $post['tahapan'],
                'waktu_mulai' => $post['mulai'],
                'waktu_akhir' => $post['akhir'] === '' ? null : $post['akhir'],
                'status' => 1
            )
        );

        if ($id_jenis_event !== null) {
            $kirim['list']['id_jenis_event'] = $id_jenis_event->id_jenis_event;
        }

        $thn = explode('-',$post['mulai']);
        $wowo = 'select id_list_event from tb_list_event where status = 1 AND id_jenis_event = '.$post['event'].' AND id_tahapan = '.$post['tahapan'].' AND DATE_FORMAT(waktu_mulai, "%Y") = '.$thn[0];

        $gege = $this->db->query($wowo)->row();

        if($gege !== null){
            print_r($this->response([0, 'Tahapan ini sudah ada pada Tahunnya']));
            return;            
        }

        $insert = $this->event->store_event($kirim);

        if ($insert === false) {
            print_r($this->response([0, 'Tidak berhasil Menambahkan data']));
            return;
        }
        $this->insert_log(['CREATE', 'CREATE PADA EVENT']);

        print_r($this->response([1, 'berhasil menambahkan data']));
        return;
    }

    public function get_list_event_by_id()
    {
        $id = $this->input->post('id');

        $get_list = $this->event->list_event_id($id);
        echo json_encode($get_list);
    }
}
