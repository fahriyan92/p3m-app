<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_event_new extends CI_Controller{ 
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata("login")) {
            redirect('');
        }
        $this->load->model('M_event', 'event');
        $this->load->model('M_jenis_event', 'MjnsEvent');
    }

    public function index()
    {
        // content
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'new/event/content_event_index';
        $data['username'] = $username;
        $data['judul'] = 'Event';
        $data['brdcrmb'] = 'Beranda / Event / List Event';
        $data['jenis_pendanaan'] = $this->event->get_data('tb_pendanaan');
        $data['tahapan'] = $this->event->get_data('tb_tahapan');
        $data['jns'] = $this->MjnsEvent->all_data()->result();

        $this->load->view('index', $data);
    }

    public function index_tambah(){
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['content'] = VIEW_ADMIN . 'new/event/content_event_tambah';
        $data['tahapan'] = $this->get_tahapan();
        $data['judul'] = 'Event';
        $data['jenis_event'] = $this->jenis_event();
        $data['brdcrmb'] = 'Beranda / Event / Tambah Event';

        $this->load->view('index', $data);
    }

    private function jenis_event(){
        $data = $this->db->query("select distinct a.id_jenis_event id_event, b.nm_event from tb_jenis_event a, tb_event b where a.id_event = b.id_event AND a.id_pendanaan = 1 AND a.status =1 ")->result();
        return $data;
    }

    private function get_tahapan(){
        $data = $this->db->query("select distinct id_tahapan, nama_tahapan from tb_tahapan where status = 1")->result();
        return $data;
    }  

    public function get_skema($id_jenis){
        $query = "select id_kelompok_pengajuan id, nama_kelompok nama from tb_kelompok_pengajuan where status = 1 AND ";
        switch ($id_jenis) {
            case '1':
                $query .= "flag_pengabdian IS NULL AND flag_plp IS NULL";
                break;
            case '2':
                $query .= "flag_pengabdian IS NOT NULL AND flag_plp IS NULL";
                break;
            case '5':
                $query .= "flag_pengabdian IS NULL AND flag_plp IS NOT NULL";
                break;
            default:
                break;
        }

        $data['skema'] = $this->db->query($query)->result();
        $this->output->set_content_type('text/html', 'UTF-8');
        $this->load->view(VIEW_ADMIN . 'new/event/content_event_skema', $data); 
    } 

    public function testLagi(){
        $start1 = date('Y-m-d','2021-04-19');
        $end1 = date('Y-m-d','2021-04-19');

    }

    //check if date range same as ... event
    private function getEventByYear($year){
        $query = "select id,tahapan,pendanaan from view_list_event where date_format(mulai,'%Y') = '$year'";
        $id = $this->db->query($query)->result();
        return $id;
    }
    public function checkRangeDate(){
        $post = $this->input->post();
        $year = "";

        $getEvent;
        $kumpul = [];
        $error = [];
        $penerimaan = [];
        $penerimaanEnd = [];
        $id_list_event;
        $tahunnya;
        //echo json_encode($post['jadwal'][0][2]);

        if($post['jadwal'][1][2] == "")
        {
            echo json_encode(['status' => 'error' , 'message' => 'Tanggal mulai penerimaan harus diisi!','row' => 1]);
            return;
        }

        $tglpenerimaan = date('Y',strtotime($post['jadwal'][1][2]));
        $cekevent = $this->db->query("select id_list_event,year(waktu_mulai) mulai from tb_list_event where year(waktu_mulai) = '".$tglpenerimaan."' and id_jenis_event =".$post['jenis_event'])->row();
        if($cekevent != null){
            $id_list_event = $cekevent->id_list_event;
            $tahunnya = $cekevent->mulai;
        }else { 
            $tahunnya = date("Y");
        }

        $this->db->trans_start();
        for($i = 0; $i <= count($post['jadwal'][0]); $i++){
            if($year == ""){
                if($post['jadwal'][$i][2] != "" && $post['jadwal'][$i][2] != null){
                    $year = explode("-",$post['jadwal'][$i][2])[2];
                    $getEvent = $this->getEventByYear($year);
                }
            }

            $iStart = null;
            $iEnd = null;

            if($post['jadwal'][$i][2] != null)
            {
                $iStart = date('d-m-Y',strtotime($post['jadwal'][$i][2])) ;
            }
            if($post['jadwal'][$i][3] != null)
            {
                $iEnd = date('d-m-Y',strtotime($post['jadwal'][$i][3])) ;
            }
            
            $captJadwal = strtolower($post['jadwal'][$i][1]);

            if($captJadwal == "penerimaan proposal" || $captJadwal == "review proposal"){
                $penerimaan[str_replace(" ","_",$captJadwal)] = $iStart;
                $penerimaanEnd[str_replace(" ","_",$captJadwal)] = $iEnd;
                if($iStart == "" || $iStart == NULL || $iEnd == NULL || $iEnd == ""){
                    echo json_encode(['status' => 'error' , 'message' => 'Tanggal mulai dan akhir '. strtolower($post['jadwal'][$i][1]).' harus diisi!','row' => $i]);
                    return;
                    break;
                }
            }
            if(isset($penerimaan['penerimaan_proposal']) && isset($penerimaan['review_proposal'])){
    //if (startDate1 <= endDate2 && startDate2 <= endDate1)
                if ($penerimaan['penerimaan_proposal'] <= $penerimaanEnd['review_proposal'] && $penerimaan['review_proposal'] <= $penerimaanEnd['penerimaan_proposal']){
                    echo json_encode(['status' => 'error' , 'message' => 'Tanggal mulai dan akhir penerimaan dan review proposal tidak boleh bersinggungan','row' => $i]);
                    return;
                    break;
                }
            }
            //if ($iStart != null && $iStart != '' && $iStart != null && $iStart != ''){
                //$iStart = date('d-m-Y',$post['mulai']);
                //$iEnd = date('d-m-Y',$post['']);
            //}

            //insert disini 
            $cekevent = $this->db->query("select id_list_event from tb_list_event where year(waktu_mulai) = '".$tahunnya."' and id_jenis_event =".$post['jenis_event']." and id_tahapan = ".$post['jadwal'][$i][0])->row();

            $insertakhir = NULL;
            $insertawal = NULL;
            if($post['jadwal'][$i][2] != null)
            {
                $insertawal = date('Y-m-d',strtotime($post['jadwal'][$i][2])) ;
            }
            if($post['jadwal'][$i][3] != null)
            {
                $insertakhir = date('Y-m-d',strtotime($post['jadwal'][$i][3])) ;
            }
            
            if($insertawal != NULL)
            {
                if($cekevent != null)
                {
                    $this->db->where('id_list_event',$cekevent->id_list_event);
                    $this->db->update('tb_list_event',['waktu_mulai' => $insertawal, 'waktu_akhir' =>  $insertakhir]);
                }else {
                    $this->db->insert('tb_list_event',['id_jenis_event' => $post['jenis_event'], 'id_tahapan'=> $post['jadwal'][$i][0], 'waktu_mulai' =>  $insertawal, 'waktu_akhir' =>  $insertakhir, 'status' => 1]);
                    if($post['jadwal'][$i][0] == "2")
                    {
                        $id_list_event = $this->db->insert_id();
                    }
                }
            }



            // $penerimaan['penerimaan_proposal']


        }
        for($i = 0; $i < count($post['skema']); $i++){
            if($id_list_event != null)
            {
                $cekevent = $this->db->query("select * from tb_st_skema_event where id_list_event = ".$id_list_event." and id_skema = ".$post['skema'][$i][0])->row();
                $polije =  $post['skema'][$i][2];
                $luar =  $post['skema'][$i][3];
                if($cekevent != null)
                {
                    $this->db->where( ['id_list_event' => $cekevent->id_list_event , 'id_skema' => $post['skema'][$i][0]]);
                    $this->db->update('tb_st_skema_event',['jml_agt_polije' => $polije , 'jml_agt_luar' =>  $luar]);
                }else { 
                    $this->db->insert('tb_st_skema_event',['id_list_event' => $id_list_event,'id_skema' => $post['skema'][$i][0], 'jml_agt_polije' => $polije , 'jml_agt_luar' =>  $luar]);
                }
            }
        }

        $this->db->trans_complete();
        if($this->db->trans_status() == FALSE)
        {
            echo json_encode(['status' => 'error']);    
            return;
        } 

        echo json_encode(['status' => 'success']);
        // if ((startDate2 >= startDate1 &&  startDate2 <= endDate1) || 
        // (endDate2   >= startDate1 && endDate2   <= endDate1)){
            
        // }
        // $start1 = date('d-m-Y',$post['mulai']);
        // $end1 = date('d-m-Y',$post['akhir']);

        // echo $year;
    } 
} 