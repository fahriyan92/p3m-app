<?php 

class C_hehe extends CI_Controller{
  public function __construct(){
    parent::__construct();
  }

  public function list_pengajuan(){
    $sql = 'select a.id_pengajuan_detail id  from tb_pengajuan_detail a
    inner join tb_pengajuan b on a.id_pengajuan = b.id_pengajuan
    where b.nidn_ketua in 
    ("197806142013101001","195909181989031003","199104012019031010","195906121987031001","195903191988031005","199208202017082001","199005152019031011","198801192018032001","199004272019031014","198804042019031013","199205282018032001","197308312008011003","195908221988031001","195908221988031001","198906222018031001","198101192014041001","195905201989031002","197901132005012001","198903292019031007","199003262018031001","196802022000121002","198406252015041004","197011282003121001","197808172003121005","195712121989031004","199002282019032018","197810112005012002","196003071987032001","198303282017032001","196912192000032001","197608312010122001","197009132005012001","198308192018091001","199102202015102001","196905021994032004","197712172018092001","199504122019031004","197202042001122003","196201291989031002","196611191992021001","198410302019032012","197210052003121001","196710171995121001","199002272018032001","198908252019031008","197801032008121001","197501292001122001","197005202002122001","198701212014091001","199012252019031013","198608022015042002","199308102017102001","196409141997032001","198301242010122003","199004062015092001")
      and id_list_event = 1;';

    $exec = $this->db->query($sql)->result();
    //echo json_encode($exec);
    return $exec;
  }

  public function tambah_reviewer(){
    $list = $this->list_pengajuan();
    $hoy = [];
    $this->db->trans_start();
    foreach ($list as $val) {
      $data = [
        'id_reviewer' =>  1,
        'id_pengajuan_detail' => $val->id,
        'created_at' => date('Y-m-d H:i:s'),
      ];  

      if(!$this->db->insert('tb_kerjaan_reviewer', $data)){
        array_push($hoy,$data);
      } 
    }
    $this->db->trans_complete();

    if(count($hoy) <= 0){
      echo "berhasil semua";
      return;
    }
    echo json_encode($hoy);
  }

  public function review_proposal(){
    $list = $this->list_pengajuan();
    $hoy = [];
    $jawaban =[
      "3",
      "8",
      "13",
      "18",
      "23",
      "27",
      "30",
      "33",
      "36",
      "41",
      "46",
      "49",
      "51",
      "55"];
      
    $this->db->trans_start();
    foreach ($list as $val) {
      $sql = 'select id_kerjaan from tb_kerjaan_reviewer where id_pengajuan_detail = '.$val->id;
      $exec = $this->db->query($sql)->row();
      foreach ($jawaban as $jwb) {
        $data = [
          'id_pilihan' => intval($jwb),
          'id_kerjaan' => intval($exec->id_kerjaan),
          'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('tb_penilaian', $data);

        $data_rekomendasi = array(
          'id_kerjaan' => intval($exec->id_kerjaan),
          // 'rekomendasi' => $rekomendasi,
          'masukan_reviewer' => "mantap"
      );

      $this->db->insert('rekomendasi_reviewer', $data_rekomendasi);
      }
      $this->db->where('id_kerjaan', intval($exec->id_kerjaan));
      if(!$this->db->update('tb_kerjaan_reviewer', ['kerjaan_selesai' => 1, 'updated_at' => date('Y-m-d H:i:s')])){
        array_push($hoy,$data);
      }      
    }
    $this->db->trans_complete();
    echo json_encode($hoy);
  }
}