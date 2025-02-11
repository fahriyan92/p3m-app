<?php 

class Ganti_nama_file extends CI_Controller{
  public function __construct(){
    parent::__construct();
  }

  public function index(){

  } 
  function namabaru($n, $p, $s){
    $nama = trim($n);
    $nama_fix = str_replace(" ","_",$nama);
    $nip = $p;
    $skema = trim($s);
    $skema_fix = str_replace(" ","_",$skema);
    $nama_file = $nama_fix."_".$nip."_".$skema_fix."_".time();
    return strtolower($nama_file);
  }
  function rename_win($oldfile,$newfile) {
    if (!rename($oldfile,$newfile)) {
        if (copy ($oldfile,$newfile)) {
            unlink($oldfile);
            return TRUE;
        }
        return FALSE;
    }
    return TRUE;
}
function pindah($oldfile,$newfile) {
    copy ($oldfile,$newfile);
    return TRUE;
}
public function pindah_file(){
  $data = $this->db->query("select distinct a.id_pengajuan_detail,c.file_proposal, c.file_rab,d.judul, d.tahun_usulan, b.nidn_ketua, e.nama, f.nama_kelompok,
  case b.id_list_event 
      when 1 then 'Penelitian Dosen'
        when 12 then 'Pengabdian'
        when 22 then 'PLP'
        else ''
    end as jenis_proposal
from tb_pengajuan_detail a
inner join tb_pengajuan b on a.id_pengajuan = b.id_pengajuan
inner join tb_dokumen_pengajuan c on a.id_pengajuan_detail = c.id_pengajuan_detail
inner join tb_identitas_pengajuan d on d.id_pengajuan_detail = a.id_pengajuan_detail
inner join dummy_dosen e on b.nidn_ketua = e.nidn
inner join tb_kelompok_pengajuan f on f.id_kelompok_pengajuan = d.id_kelompok_pengajuan
where ((c.file_proposal != '' OR c.file_proposal is not null ) AND (c.file_rab != '' OR c.file_rab is not null ))
        ")->result();
        // proposal_' . $post['nidn_ketua'] . '' . str_replace(' ', '', $fix_judul) . $post['tahun_usulan']  . $extension_proposal
  $index = 0 ;
  $takde = [];

  foreach ($data as $dt) {
    $ex_prop = explode(".",$dt->file_proposal);
    $ex_rab = explode(".",$dt->file_rab);

    $exstensi_prop = $ex_prop[count($ex_prop)-1];
    $exstensi_rab =  $ex_rab[count($ex_rab)-1];
    $proposal = false;
    $rab = false;
    $skemanya =  $dt->jenis_proposal;
    if(strtolower($dt->jenis_proposal) == "penelitian dosen"){
      $skemanya = $dt->nama_kelompok;
      if (file_exists(FCPATH . 'assets/berkas/file_proposal/' . $dt->file_proposal)) {
        $this->pindah(FCPATH . 'assets/berkas/file_proposal/' . $dt->file_proposal, FCPATH . 'assets/berkas/proposal_pnbp_dosen/' . $dt->file_proposal);
  
        // $this->db->where("id_pengajuan_detail",$dt->id_pengajuan_detail);
        // $this->db->update('tb_dokumen_pengajuan', ["file_proposal" => $nama_prop]);
  
        $data[$index]->proposal = true;
        $proposal = true;
      }else { 
        $data[$index]->proposal = false;
      }
      if (file_exists(FCPATH . 'assets/berkas/file_rab/' . $dt->file_rab)) {
        $this->pindah(FCPATH . 'assets/berkas/file_rab/' . $dt->file_rab, FCPATH . 'assets/berkas/rab_pnbp_dosen/' . $dt->file_rab);
  
        // $this->db->where("id_pengajuan_detail",$dt->id_pengajuan_detail);
        // $this->db->update('tb_dokumen_pengajuan', ["file_rab" => $nama_rab]);
  
        $rab = true;
        $data[$index]->rab = true;
      }else { 
        $data[$index]->rab = false;
      }
    }
    // $nama_prop = $this->namabaru($dt->nama,$dt->nidn_ketua,$skemanya).".".$exstensi_prop;
    // $nama_rab = $this->namabaru($dt->nama,$dt->nidn_ketua,$skemanya).".".$exstensi_rab;


    if($proposal === false || $rab === false){
      array_push($takde,$data[$index]);
    }
    $index++;
  }

  echo json_encode($takde);
  return $data;
}
  public function get_file_name(){
    $data = $this->db->query("select distinct a.id_pengajuan_detail,c.file_proposal, c.file_rab,d.judul, d.tahun_usulan, b.nidn_ketua, e.nama, f.nama_kelompok,
    case b.id_list_event 
        when 1 then 'Penelitian Dosen'
          when 12 then 'Pengabdian'
          when 22 then 'PLP'
          else ''
      end as jenis_proposal
  from tb_pengajuan_detail a
  inner join tb_pengajuan b on a.id_pengajuan = b.id_pengajuan
  inner join tb_dokumen_pengajuan c on a.id_pengajuan_detail = c.id_pengajuan_detail
  inner join tb_identitas_pengajuan d on d.id_pengajuan_detail = a.id_pengajuan_detail
  inner join dummy_dosen e on b.nidn_ketua = e.nidn
  inner join tb_kelompok_pengajuan f on f.id_kelompok_pengajuan = d.id_kelompok_pengajuan
  where ((c.file_proposal != '' OR c.file_proposal is not null ) AND (c.file_rab != '' OR c.file_rab is not null ))
          ")->result();
          // proposal_' . $post['nidn_ketua'] . '' . str_replace(' ', '', $fix_judul) . $post['tahun_usulan']  . $extension_proposal
    $index = 0 ;
    $takde = [];

    foreach ($data as $dt) {
      $ex_prop = explode(".",$dt->file_proposal);
      $ex_rab = explode(".",$dt->file_rab);

      $exstensi_prop = $ex_prop[count($ex_prop)-1];
      $exstensi_rab =  $ex_rab[count($ex_rab)-1];
      $proposal = false;
      $rab = false;
      $skemanya =  $dt->jenis_proposal;
      if(strtolower($dt->jenis_proposal) == "penelitian dosen"){
        $skemanya = $dt->nama_kelompok;
      }
      $nama_prop = $this->namabaru($dt->nama,$dt->nidn_ketua,$skemanya).".".$exstensi_prop;
      $nama_rab = $this->namabaru($dt->nama,$dt->nidn_ketua,$skemanya).".".$exstensi_rab;
      if (file_exists(FCPATH . 'assets/berkas/file_proposal/' . $dt->file_proposal)) {
        $this->rename_win(FCPATH . 'assets/berkas/file_proposal/' . $dt->file_proposal, FCPATH . 'assets/berkas/file_proposal/'.$nama_prop);

        $this->db->where("id_pengajuan_detail",$dt->id_pengajuan_detail);
        $this->db->update('tb_dokumen_pengajuan', ["file_proposal" => $nama_prop]);

        $data[$index]->proposal = true;
        $proposal = true;
      }else { 
        $data[$index]->proposal = false;
      }
      if (file_exists(FCPATH . 'assets/berkas/file_rab/' . $dt->file_rab)) {
        $this->rename_win(FCPATH . 'assets/berkas/file_rab/' . $dt->file_rab, FCPATH . 'assets/berkas/file_rab/'.$nama_rab);

        $this->db->where("id_pengajuan_detail",$dt->id_pengajuan_detail);
        $this->db->update('tb_dokumen_pengajuan', ["file_rab" => $nama_rab]);

        $rab = true;
        $data[$index]->rab = true;
      }else { 
        $data[$index]->rab = false;
      }

      if($proposal === false || $rab === false){
        array_push($takde,$data[$index]);
      }
      $index++;
    }

    echo json_encode($takde);
    return $data;
  }

  public function test(){
    $text = "proposal_199009172019032024_aplikasi_cerdas_sistem_moitoring_dan_pemetaan_stunting__(smart_ting)_pada_balita_berbasis_android_di_kabupaten_jember2021.pdf";
    $encode = urlencode($text);
    $decode = urldecode($encode);
    // $hola = iconv("UTF-8", "ASCII//TRANSLIT", $text);
    echo json_encode([$encode,$decode]);
  }

  public function download(){
    $filenya = "proposal_199009172019032024_aplikasi_cerdas_sistem_moitoring_dan_pemetaan_stunting__%28smart_ting%29_pada_balita_berbasis_android_di_kabupaten_jember2021.pdf";

    $decode = urldecode($filenya);
    $url = base_url('assets/berkas/file_proposal/'.$decode);
    header("Location: $url");
  }
}