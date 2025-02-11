<?php 
class Report extends MX_Controller
{
    
    function __construct(){
        parent::__construct();
        $this->load->library('session');
        if(!$this->session->has_userdata('id')){
			redirect('auth');
		}
        $this->load->model('M_report');
        $this->session->set_userdata('mn_active', 'report');
    }

    function index(){
       if(cekrole_admin()){
            $this->report();
        } else {
            $this->my_report();
        }
    }
    function filtertk() {
        if ($this->input->post('filter_bulan')<>null && $this->input->post('filter_bulan')<>'' && $this->input->post('filter_tahun')<>null && $this->input->post('filter_tahun')<>''){
            $this->session->set_userdata('filter_tahun', $this->input->post('filter_tahun'));
            $this->session->set_userdata('filter_bulan', $this->input->post('filter_bulan'));
        }
        redirect('report');
    }
    function report(){
        $where = '';
        $date_start='';
        $date_end = '';
        if (!$this->session->has_userdata('filter_tahun')) {
            $this->session->set_userdata('filter_tahun', date('Y'));
        }
        if (!$this->session->has_userdata('filter_bulan')) {
            $this->session->set_userdata('filter_bulan', date('m'));
        }
        $date_start = $this->session->filter_tahun.'-'.$this->session->filter_bulan.'-1';
        $date_end = $this->session->filter_tahun.'-'.$this->session->filter_bulan.'-'.date('t', strtotime($date_start));
        if($date_start){
            $where .= ' AND DATE(jw.start) >= "'.$date_start.'" AND DATE(jw.start) <= "'.$date_end.'"';
        }
        $data['title'] = 'Report';
        $data['report'] = $this->M_report->reportReport($where);
        $data['module'] = 'report';
        $data['view_file'] = 'v_report';
        echo modules::run('template/loadview', $data);
    }
    function savesess($id = NULL, $id_user = NULL, $no_ujian = NULL) {
        if($id<>null) {
            $sessid = $id;
            $this->session->set_userdata('aidi_jw', $sessid);
            $this->session->set_userdata('aidi_us', $id_user);
            $this->session->set_userdata('aidi_ujian', $no_ujian);
            redirect('report/report_detail');
        } else {
            $sessid = $this->input->post('sessid');
            $this->session->set_userdata('aidi_jw', $sessid);
        }       
    }
    function report_detail(){
        $data['title'] = 'Report Detail';
        $email = $this->session->acc_email;
        $id = $this->session->aidi_jw;
        $id_uji_us = $this->session->aidi_ujian;
        if(cekrole_admin()){
            $data['isi_table_admin'] = $this->setup_html_report_detail_admin($id);
        }
        $data['v_jadwal'] = $this->M_report->getQuery("SELECT (select count(id) from ujian_user where jadwal_id = '$id' AND status in(2,4)) as REGISTERED, jw.nama AS jw_nama, jw.ket AS jw_keter, jw.kapasitas AS jw_quota, jw.start AS jw_start, jw.end AS jw_end, pk.nama AS pk_nama FROM jadwal jw JOIN paket pk ON jw.paket_id=pk.id WHERE jw.id = '$id' ")->row_array();
        $data['paket'] = $this->M_report->getQuery("SELECT paket.nama FROM `paket` JOIN jadwal ON paket.id = jadwal.paket_id JOIN ujian_user ON jadwal.id = ujian_user.jadwal_id WHERE ujian_user.id = '$id_uji_us'")->row_array();
        
        if(!cekrole_admin()){
            $data['user'] = $this->M_report->getData("user","email='$email'")->row_array();

            $score = $this->choose_score($id_uji_us);
            $data['score_all'] = $score['score_all'];
            $data['total_score'] = $score['total_score'];
        }
        $data['id_ujian'] = $id_uji_us;
        
        $data['profile'] = $this->M_report->getData('comp_profile', 'status<>0')->row();
        $data['module'] = 'report';
        $data['view_file'] = 'v_report_detail';
        echo modules::run('template/loadview', $data);
    }
    function get_or_update_total_score($id_ujian){
        $check = $this->M_report->getQuery("select total_score from ujian_user where id = '".$id_ujian."'")->row();
        if($check == null){
            return "0";
        }

        $score = "0";
        if($check->total_score != null){
            $score = $check->total_score;
        } else {
            $get_score = $this->count_score($id_ujian);
            $where = array('id' => $id_ujian);
            $fields = ['total_score' => $get_score['total_score'], 'reading_score' => $get_score['score_all']['reading'],'listening_score' => $get_score['score_all']['listening'],'structure_score' => $get_score['score_all']['structure']];
            $update = $this->M_report->updateData('ujian_user',$fields,$where);

            if($update){
                $score = $get_score['total_score'];
            }
        }

        return $score;
    }
    function setup_html_report_detail_admin($id){
        $data = $this->M_report->reportDetailJadwal_revisi($id)->result();
        $html = "";
        $no = 0;
        foreach ($data as $jw) {
            $no++;
            $time = strtotime($jw->end_ujian) == strtotime('0000-00-00') ? date('H:i', strtotime($jw->jw_end)) : date('H:i',strtotime($jw->end_ujian));
            $url = base_url('report/score/'.$jw->id_user.'/'.$jw->id_daftar);
            $score = $this->get_or_update_total_score($jw->id_daftar);
            $html .= "<tr data-item-id='".$no."'>";
            $html .= "<td>".$no."</td>";
            $html .= "<td class='py-1'>".date('H:i', strtotime($jw->mulai_ujian))."-".$time."</td>";
            //$html .= "<td class='py-1'>".date('H:i', strtotime($jw->mulai_ujian))."-".(strtotime($jw->end_ujian) == strtotime('0000-00-00'))? date('H:i', strtotime($jw->jw_end)) : date('H:i',strtotime($jw->end_ujian))."</td>";
            $html .= "<td class='py-1'>".$jw->nm_user."</td>";
            $html .= "<td class='py-1'>".$jw->em_user."</td>";
            $html .= "<td class='py-1'>".$jw->hp_user."</td>";
            $html .= "<td class='py-1'>".$score."</td>";
            $html .= "<td class='py-1'><a href='".$url."' type='button' class='mb-1 mt-1 mr-1 btn btn-xs btn-success'>Report Detail</a></td>";
            $html .= "</tr>";
        }

        return $html;
    }
    function choose_score($id_ujian){
        $score_exist = $this->M_report->getQuery("select reading_score reading, listening_score listening, structure_score structure, total_score  from ujian_user where id ='".$id_ujian."'")->row_array();

        $score = [];
        if($score_exist != null ){
            if($score_exist['total_score'] == null) {
                $score = $this->count_score($id_ujian);
            } else {
                $score['score_all'] = ['listening' => $score_exist['listening'], 'reading' => $score_exist['reading'] , 'structure' => $score_exist['structure'] ];
                $score['total_score'] =  $score_exist['total_score'];
            }
        } else {
            $score = $this->count_score($id_ujian);
        }

        return $score;
    }

    function score($id = NULL, $id_ujian_user = NULL) {
        if($id<>null) {
            $sessid = $id;
            $ujusid = $id_ujian_user;
            $this->session->set_userdata('aidi_sc', $sessid);
            $this->session->set_userdata('aidi_uj_us', $ujusid);
            redirect('report/score_detail');
        } else {
            $sessid = $this->input->post('sessid');
            $this->session->set_userdata('aidi_sc', $sessid);
        }       
    }
    private function  count_score($id_ujian){
        $data['score_all'] = $this->M_report->get_score($id_ujian);
        $a = $data['score_all']['listening'];
        $b = $data['score_all']['structure'];
        $c = $data['score_all']['reading'];
        $d = $a + $b + $c;
        $data['total_score'] = (substr(ceil(($d / 3 * 10)),-1)==0)?ceil(($d / 3 * 10)):((substr(ceil(($d / 3 * 10)),-1)==1)?ceil(($d / 3 * 10)+2):((substr(ceil(($d / 3 * 10)),-1)==2)?ceil(($d / 3 * 10)+1):((substr(ceil(($d / 3 * 10)),-1)==3)?ceil(213):((substr(ceil(($d / 3 * 10)),-1)==4)?ceil(($d / 3 * 10)+1):((substr(ceil(($d / 3 * 10)),-1)==5)?ceil(213):((substr(ceil(($d / 3 * 10)),-1)==6)?ceil(($d / 3 * 10)+1):((substr(ceil(($d / 3 * 10)),-1)==7)?ceil(($d / 3 * 10)):((substr(ceil(($d / 3 * 10)),-1)==8)?ceil(($d / 3 * 10)+2):ceil(($d / 3 * 10)+1)))))))));
        return $data;
    }
    function score_detail(){
        $id_user = $this->session->aidi_sc;
        $id_uji_us = $this->session->aidi_uj_us;
        $data['user'] = $this->M_report->getData("user","id='$id_user'")->row_array();
        $score = $this->choose_score($id_uji_us);
        $data['score_lst'] = $score['score_all']['listening'];
        $data['score_str'] = $score['score_all']['structure'];
        $data['score_red'] = $score['score_all']['reading'];
        $data['score_tot'] = $score['total_score'];
        $data['paket'] = $this->M_report->getQuery("SELECT paket.nama FROM `paket` JOIN jadwal ON paket.id = jadwal.paket_id JOIN ujian_user ON jadwal.id = ujian_user.jadwal_id WHERE ujian_user.id = '$id_uji_us'")->row_array();
        $data['profile'] = $this->M_report->getData('comp_profile', 'status<>0')->row();
        $data['tgl_test'] = $this->M_report->getQuery("SELECT jw.start FROM ujian_user uu JOIN jadwal jw ON jw.id = uu.jadwal_id WHERE uu.id = '$id_uji_us'")->row_array();
        $data['title'] = 'Report Detail';
        $data['module'] = 'report';
        $data['id_ujian'] = $id_uji_us;
        $data['view_file'] = 'v_score_detail';
        echo modules::run('template/loadview', $data);
    }
    function my_report(){
        $data['title'] = 'Report';
        $report = $this->M_report->my_report_report();
        for($i = 0 ; $i < count($report); $i++){
            $rapot = true;
            if($report[$i]->ujs_usr_status != 4){
                $get_data = $this->M_report->getData('ujian_jawaban_user',"ujian_user_id ='".$report[$i]->no_ujian."'")->row();
                if($get_data == null){
                    $rapot = false;
                }
            }
            $report[$i]->rapot = $rapot;
        }
        $data['report'] = $report;
        $data['module'] = 'report';
        $data['view_file'] = 'v_my_report';
        echo modules::run('template/loadview', $data);
    }
    function print_certificate($id_ujian = null){
        if($id_ujian == null){
            echo "id_ujian tidak ada";
            return;
        }

        if(!isset($_SESSION['type'])){
            echo "error";
            return;
        }

        $email = "";
        $id = "";
        if($_SESSION['type'] == "admin"){
            $query = "select b.email email, jadwal_id from  ujian_user a inner join user b ON a.user_id = b.id where a.id = '".$id_ujian."'";
            $res = $this->db->query($query)->row();
            if($res == null){
                echo "id_ujian tidak ada";
                return;
            }

            $email = $res->email;
            $id = $res->jadwal_id;
        } else {
            $email = $this->session->acc_email;
            $id = $this->session->aidi_jw;
        }

        $score = $this->choose_score($id_ujian);
        $user = $this->M_report->getData("user","email='$email'")->row();
        $v_jadwal = $this->M_report->getQuery("SELECT jw.start AS jw_start FROM jadwal jw WHERE jw.id = '$id' ")->row();
        $data['score_all'] = $score['score_all'];
        $data['total_score'] = $score['total_score'];
        $data['tgl_lahir'] = date('d F Y', strtotime($user->tgl_lahir));
        $data['tgl_ujian'] = date('d F Y', strtotime($v_jadwal->jw_start));
        $data['nama'] = $user->nama;

        $gambar = realpath(APPPATH . '../asset/img/sertifikat.jpeg');
        $font = realpath(APPPATH . '../asset/font/arial.ttf');

	$image = imagecreatefromjpeg($gambar);
	$white = imageColorAllocate($image, 255, 255, 255);
	$black = imageColorAllocate($image, 0, 0, 0);
    $size = 35;


    $image_width = imagesx($image);  
	$text_box = imagettfbbox(26,0,$font,strtoupper($data['nama']));
	$text_width = $text_box[2]-$text_box[0]; // lower right corner - lower left corner
	$text_height = $text_box[3]-$text_box[1];
	$x = ($image_width/2) - ($text_width/2);
	//definisikan lebar gambar agar posisi teks selalu ditengah berapapun jumlah hurufnya
	$image_width = imagesx($image);  
	//generate sertifikat beserta namanya
    imagettftext($image, 26, 0, $x, 265, $black, $font, strtoupper($data['nama']));
    imagettftext($image, 11, 0, 500, 367, $black, $font, $data['score_all']['listening']);
    imagettftext($image, 11, 0, 500, 390, $black, $font, $data['score_all']['structure']);
    imagettftext($image, 11, 0, 500, 410, $black, $font, $data['score_all']['reading']);
    imagettftext($image, 11, 0, 500, 430, $black, $font, $data['total_score']);
    imagettftext($image, 13, 0, 255, 492, $black, $font, ": " .$data['tgl_lahir']);
	imagettftext($image, 13, 0, 255, 522, $black, $font, ": " .$data['tgl_ujian']);
	//tampilkan di browser
    header("Content-type:  image/jpeg");
    header("Content-Disposition: attachment; filename=sertifikat.jpeg");

    //ob_start();
    imagejpeg($image, NULL,100);
    //$image_data = ob_get_contents();
    //ob_end_clean();
    //$image_base64 = base64_encode($image_data);
    imagedestroy($image);

    //return "<img src='data:image/jpeg;base64,$image_base64'>";
    }

    public function cetak_sertifikat($id_ujian) {
        //$data['id_ujian'] = $id_ujian;
        //$data['gambar'] = $this->print_certificate($id_ujian);
        $this->print_certificate($id_ujian);
        //$this->load->library("pdf");
        //$this->pdf->filename = "coba.pdf";
        //$this->pdf->test('report/sertifikat',$data);
    }
}
?>
