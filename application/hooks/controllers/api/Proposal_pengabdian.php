<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Proposal_pengabdian extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function index_get()
    {
        $judul = $this->get('judul');
        $nik_dsn = $this->get('nip');
        $thn = $this->get('tahun');
        $program = $this->get('program');
        $limit = $this->get('limit');
        $offset = $this->get('offset');

        $query = "";

        $q_pnbp = "
            SELECT 
            a.id_pengajuan_detail AS id, 
            c.judul AS judul,
            c.tahun_usulan AS tahun_pelaksanaan,
            c.tanggal_mulai_kgt AS tanggal_awal,
            c.tanggal_akhir_kgt AS tanggal_sampai,
            'PNBP' AS program,
            f.file_proposal,
            b.nidn_ketua AS nip_ketua,
            g.nama AS nama_ketua,
            c.biaya AS biaya_dana
            from tb_pengajuan_detail a 
            INNER JOIN tb_pengajuan b ON a.id_pengajuan = b.id_pengajuan 
            INNER JOIN tb_identitas_pengajuan c ON a.id_pengajuan_detail = c.id_pengajuan_detail 
            INNER JOIN tb_list_event d ON d.id_list_event = b.id_list_event 
            INNER JOIN tb_dokumen_pengajuan f ON c.id_pengajuan_detail = f.id_pengajuan_detail
            INNER JOIN dummy_dosen g ON b.nidn_ketua = g.nip
            WHERE a.id_pengajuan_detail IN (SELECT DISTINCT id_pengajuan_detail FROM tb_kerjaan_reviewer WHERE kerjaan_selesai = 1)  AND d.id_jenis_event = 2 AND 
	            a.status_keputusan = 1 
        ";

        //AND c.tahun_usulan = '2020'

        $q_mandiri = "
            SELECT 
            a.id_pengajuan_detail AS id,
            c.judul AS judul,
            c.tahun_usulan AS tahun_pelaksanaan,
            c.tanggal_mulai AS tanggal_awal,
            c.tanggal_akhir AS tanggal_sampai,
            'MANDIRI' AS program,
            d.file_proposal,
            b.nip_ketua AS nip_ketua ,
            f.nama AS nama_ketua,
            c.biaya AS biaya_dana
            FROM pengajuan_detail_mandiri a 
            INNER JOIN pengajuan_mandiri b ON a.id_pengajuan = b.id_pengajuan
            INNER JOIN identitas_pengajuan_mandiri  c ON a.id_pengajuan_detail = c.id_pengajuan_detail
            INNER JOIN dokumen_pengajuan_mandiri d ON d.id_pengajuan_detail = a.id_pengajuan_detail
            INNER JOIN dummy_dosen f ON b.nip_ketua = f.nip
            WHERE b.id_jenis = 2 AND a.status_koreksi = 1 AND a.status = 8
        ";

        $add_thn = "AND c.tahun_usulan ='".$thn."' ";
        $add_dsn = "AND b.nip_ketua ='".$nik_dsn."' ";
        $add_judul = "AND c.judul ='".$judul."' ";

        if($thn != null){
            $q_pnbp .= $add_thn;
            $q_mandiri .= $add_thn;
        }

        if($nik_dsn != null){
            $q_pnbp .= $add_dsn;
            $q_mandiri .= $add_dsn;
        }

        if($judul != null){
            $q_pnbp .= $add_judul;
            $q_mandiri .= $add_judul;
        }

        if($program != null){
            $program = strtoupper($program);
            if($program === "MANDIRI") {
                $query .= $q_mandiri;

            } elseif($program === "PNBP"){
                $query .= $q_pnbp;
            } else {
                $query .= "ngawor";
            }
        } else {
            $query .= $q_pnbp."UNION ALL ". $q_mandiri;
        }

        if($limit == null) {
            $limit = 1000;
        } 

        if($offset == null) {
            $offset = 0;
        } 

        $add_limit = " LIMIT ".$offset.",".$limit;

        $query .= $add_limit;

        if($query === "ngawor") {
            $this->response( [
                'status' => false,
                'message' => 'program tidak tersedia'
            ], 400 );
        }

        $coba = $this->db->query($query)->result();

        $jadi = [];
        if($coba != null){
            $i = 0;
           foreach ($coba as $value) {
               $jadi[$i]["judul"] = $value->judul;
               $jadi[$i]["program"] = $value->program;
               $jadi[$i]["tahun_pelaksanaan"] = $value->tahun_pelaksanaan;
               $jadi[$i]["tanggal_awal"] = $value->tanggal_awal;
               $jadi[$i]["tanggal_sampai"] = $value->tanggal_sampai;
               $jadi[$i]["file_proposal"] = $value->file_proposal;
               $jadi[$i]["nip_ketua"] = $value->nip_ketua;
               $jadi[$i]["nama_ketua"] = $value->nama_ketua;
               $jadi[$i]["biaya_dana"] = $value->biaya_dana;


                $tabel = ['PNBP' => 'tb_anggota_dosen','MANDIRI' => 'anggota_dosen_mandiri'];
                $field = ['PNBP' => 'nidn','MANDIRI' => 'nip'];
                $alias = ['PNBP' => 'a','MANDIRI' => 'b'];
                $q = "SELECT b.nip AS nip, b.nidn AS nidn, b.nama AS nama FROM ". $tabel[$value->program]." a INNER JOIN dummy_dosen b ON a.".$field[$value->program]." = b.nip WHERE ".$alias[$value->program].".".$field[$value->program]." != '".$value->nip_ketua."' AND a.id_pengajuan_detail = ".$value->id;
                $exec_q = $this->db->query($q)->result();

                if($exec_q != null){
                    $jadi[$i]["anggota"] = $exec_q;
                }

                $i++;
           } 
        }

        $this->response($jadi, 200 );
    }
}