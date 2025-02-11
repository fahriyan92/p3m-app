<?php 

class M_rekap extends CI_Model{
    public function get_proposal($tahun,$type,$status){
        //type 1 = penelitian, 2 = pengabdian, status = NULL belum diproses, 1 = diterima , 2 = ditolak, 3 = lolos administrasi , 4 = tidak lolos administrasi
        //kalo 2 = pengabdian tidak usah di kalikan dengan bobot
    
        if($status === NULL){
            $keputusan = " IS NULL OR a.status_keputusan = 3";
       } else { 
            $keputusan = " = $status ";
       }
       $sql_pengajuan = $this->db->query("SELECT a.id_pengajuan_detail AS id,c.judul AS judul,e.nama AS nama_ketua, e.nip AS nip_ketua from tb_pengajuan_detail a INNER JOIN tb_pengajuan b ON  a.id_pengajuan = b.id_pengajuan INNER JOIN tb_identitas_pengajuan c ON a.id_pengajuan_detail = c.id_pengajuan_detail INNER JOIN tb_list_event d ON d.id_list_event = b.id_list_event INNER JOIN dummy_dosen e ON b.nidn_ketua = e.nidn WHERE c.tahun_usulan = '$tahun' AND d.id_jenis_event = $type AND ( a.status_keputusan $keputusan ) AND a.id_pengajuan_detail IN (SELECT DISTINCT id_pengajuan_detail FROM tb_kerjaan_reviewer WHERE kerjaan_selesai = 1)")->result();

       $i=0;
       foreach ($sql_pengajuan as $pengajuan ) {
         $sql_score = $this->db->query("SELECT ROUND(AVG(scorenya.nilai_fix),2) AS nilainya FROM (SELECT SUM(nilai_satu.nilai_sementara) AS nilai_fix FROM (SELECT kj.id_kerjaan,kj.id_pengajuan_detail,js.id_jenis_soal,(
             CASE 
                WHEN js.id_event = 1 THEN (SUM(pl.score)*js.bobot/100)
                WHEN js.id_event = 2 THEN IF(js.id_jenis_soal = 4,(SUM((pl.score / 7)*js.bobot*pl.prosentase))/100,SUM((pl.score * pl.prosentase))/100)
                WHEN js.id_event = 3 THEN IF(js.id_jenis_soal = 4,(SUM((pl.score / 7)*js.bobot*pl.prosentase))/100,SUM((pl.score * pl.prosentase))/100)
                ELSE 0
             END)
              AS nilai_sementara FROM tb_penilaian pn INNER JOIN tb_pilihan as pl ON pl.id_pilihan = pn.id_pilihan INNER JOIN tb_soal sl ON sl.id_soal = pl.id_soal INNER JOIN tb_jenis_soal js ON sl.id_jenis_soal = js.id_jenis_soal INNER JOIN tb_kerjaan_reviewer kj ON kj.id_kerjaan = pn.id_kerjaan WHERE kj.id_pengajuan_detail = ".$pengajuan->id." AND pl.status = 1 AND sl.status = 1 GROUP BY kj.id_kerjaan,js.id_jenis_soal) AS nilai_satu WHERE nilai_satu.id_pengajuan_detail = ".$pengajuan->id." GROUP BY nilai_satu.id_kerjaan) AS scorenya")->row();
         $sql_pengajuan[$i]->nilai_rata = $sql_score->nilainya;
        $i++;
       }

       //foreach ($sql_pengajuan as $pengajuan ) {
         //$sql_score = $this->db->query("SELECT AVG(scorenya.nilai_fix) AS nilainya FROM (SELECT SUM(nilai_satu.nilai_sementara) AS nilai_fix FROM (SELECT kj.id_kerjaan,kj.id_pengajuan_detail,js.id_jenis_soal,(SUM(pl.score)*js.bobot/100) AS nilai_sementara FROM tb_penilaian pn INNER JOIN tb_pilihan as pl ON pl.id_pilihan = pn.id_pilihan INNER JOIN tb_soal sl ON sl.id_soal = pl.id_soal INNER JOIN tb_jenis_soal js ON sl.id_jenis_soal = js.id_jenis_soal INNER JOIN tb_kerjaan_reviewer kj ON kj.id_kerjaan = pn.id_kerjaan WHERE kj.id_pengajuan_detail = ".$pengajuan->id." AND pl.status = 1 AND sl.status = 1 GROUP BY kj.id_kerjaan,js.id_jenis_soal) AS nilai_satu WHERE nilai_satu.id_pengajuan_detail = ".$pengajuan->id." GROUP BY nilai_satu.id_kerjaan) AS scorenya")->row();
         //$sql_pengajuan[$i]->nilai_rata = $sql_score->nilainya;
        //$i++;

    //   $sql = "SELECT data.*, (SELECT AVG(scorenya.nilai_fix) FROM (SELECT SUM(nilai_satu.nilai_sementara) AS nilai_fix FROM (SELECT kj.id_kerjaan,kj.id_pengajuan_detail,js.id_jenis_soal,(SUM(pl.score)*js.bobot/100) AS nilai_sementara FROM tb_penilaian pn INNER JOIN tb_pilihan as pl ON pl.id_pilihan = pn.id_pilihan INNER JOIN tb_soal sl ON sl.id_soal = pl.id_soal INNER JOIN tb_jenis_soal js ON sl.id_jenis_soal = js.id_jenis_soal INNER JOIN tb_kerjaan_reviewer kj ON kj.id_kerjaan = pn.id_kerjaan WHERE kj.id_pengajuan_detail = data.id GROUP BY kj.id_kerjaan,js.id_jenis_soal) AS nilai_satu WHERE nilai_satu.id_pengajuan_detail = data.id GROUP BY nilai_satu.id_kerjaan) AS scorenya) AS nilai FROM (SELECT a.id_pengajuan_detail AS id,c.judul AS judul,e.nama AS nama_ketua, e.nip AS nip_ketua from tb_pengajuan_detail a INNER JOIN tb_pengajuan b ON  a.id_pengajuan = b.id_pengajuan INNER JOIN tb_identitas_pengajuan c ON a.id_pengajuan_detail = c.id_pengajuan_detail INNER JOIN tb_list_event d ON d.id_list_event = b.id_list_event INNER JOIN dummy_dosen e ON b.nidn_ketua = e.nidn WHERE c.tahun_usulan = '$tahun' AND d.id_jenis_event = $type AND a.status_keputusan $keputusan) AS data ";
        // return $this->db->query($sql)->result();
        return $sql_pengajuan;
    }
    public function get_reviewer_score($id){
         $sql_score = $this->db->query("SELECT dosen.nama,dosen.nip, ROUND(SUM(nilai_satu.nilai_sementara),2)  AS nilai_fix FROM (SELECT kj.id_kerjaan,kj.id_reviewer,kj.id_pengajuan_detail,js.id_jenis_soal,(
             CASE 
                WHEN js.id_event = 1 THEN (SUM(pl.score)*js.bobot/100)
                WHEN js.id_event = 2 THEN IF(js.id_jenis_soal = 4,(SUM((pl.score / 7)*js.bobot*pl.prosentase))/100,SUM((pl.score * pl.prosentase))/100)
                WHEN js.id_event = 3 THEN IF(js.id_jenis_soal = 4,(SUM((pl.score / 7)*js.bobot*pl.prosentase))/100,SUM((pl.score * pl.prosentase))/100)
                ELSE 0
             END) AS nilai_sementara FROM tb_penilaian pn INNER JOIN tb_pilihan as pl ON pl.id_pilihan = pn.id_pilihan INNER JOIN tb_soal sl ON sl.id_soal = pl.id_soal INNER JOIN tb_jenis_soal js ON sl.id_jenis_soal = js.id_jenis_soal INNER JOIN tb_kerjaan_reviewer kj ON kj.id_kerjaan = pn.id_kerjaan WHERE kj.id_pengajuan_detail = ".$id." AND pl.status = 1 AND sl.status = 1 GROUP BY kj.id_kerjaan,js.id_jenis_soal) AS nilai_satu INNER JOIN tb_reviewer  ON nilai_satu.id_reviewer = tb_reviewer.id_reviewer INNER JOIN dummy_dosen dosen ON tb_reviewer.nidn = dosen.nidn WHERE nilai_satu.id_pengajuan_detail = ".$id." GROUP BY nilai_satu.id_kerjaan")->result();
         return $sql_score;
    }
}