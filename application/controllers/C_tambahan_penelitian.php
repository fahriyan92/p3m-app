<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_tambahan_penelitian extends CI_Controller
{
    public function __construct()
	{
		parent::__construct();
        if (!$this->session->userdata("login")) {
            redirect('');
        }
	}

    public function list_table_anggota($idlistevent,$idpengajuandetail = null)
    {
        $data = [];
        $nip_ketua = $this->session->userdata('nidn');

        //cek apakah idpengajuandetailnya kosong yang dikirim
        if($idpengajuandetail == null)
        {
            $query = "SELECT DISTINCT b.nidn, b.nama,b.sinta,b.scopus,b.unit,b.jenis_unit,b.telepon,b.jenis_job,a.id_list_event
                        FROM temp_anggota_polije a, dummy_dosen b 
                        WHERE a.nip_anggota = b.nidn
                        AND a.nip_ketua = '196409141997032001' AND a.id_list_event = 31;";
            $data['list_dosen'] = $this->db->query($query)->result();
            $data['jenis'] = 'temp';
            // $data = $this->db->query("SELECT DISTINCT b.nidn, b.nama,b.sinta,b.scopus,b.unit,b.jenis_unit,b.telepon FROM temp_anggota_polije a, dummy_dosen b WHERE a.nip_anggota = b.nidn
            // AND a.nip_ketua = '' AND a.id_list_event")->result();
           
        }
        if($idpengajuandetail != null)
        {
            $query = "SELECT DISTINCT b.nidn, b.nama,b.sinta,b.scopus,b.unit,b.jenis_unit,b.telepon,b.jenis_job,a.id_pengajuan_detail
            FROM  tb_anggota_dosen a,dummy_dosen b 
            WHERE a.nidn = b.nidn AND 
            a.id_pengajuan_detail = 1;";
            $data['list_dosen'] = $this->db->query($query)->result();
            $data['jenis'] = 'not temp';
        }
        return $this->load->view(VIEW_ADMIN . 'new/tambahan_penelitian/list_anggota_dosen_polije', $data); 
    }

    public function list_table_anggota_luar($idlistevent,$idpengajuandetail = null)
    {
        $data = [];
        $nip_ketua = $this->session->userdata('nidn');

        //cek apakah idpengajuandetailnya kosong yang dikirim
        if($idpengajuandetail == null)
        {
            $query = "SELECT DISTINCT b.noktp,b.nama,b.email,b.nohp,a.id_list_event
                        FROM temp_anggota_luar a, tb_anggota_dosen_luar b 
                        WHERE a.noktp = b.noktp
                        AND a.nip_ketua = '196409141997032001' AND a.id_list_event = 31;";
            $data['list_anggota'] = $this->db->query($query)->result();
            $data['jenis'] = 'temp';
            // $data = $this->db->query("SELECT DISTINCT b.nidn, b.nama,b.sinta,b.scopus,b.unit,b.jenis_unit,b.telepon FROM temp_anggota_polije a, dummy_dosen b WHERE a.nip_anggota = b.nidn
            // AND a.nip_ketua = '' AND a.id_list_event")->result();
           
        }
        if($idpengajuandetail != null)
        {
            $query = "SELECT DISTINCT b.noktp,b.nama,b.email,b.nohp,a.id_pengajuan_detail
            FROM tb_anggota_pengajuan_dosen_luar a, tb_anggota_dosen_luar b 
            WHERE a.noktp = b.noktp AND a.id_pengajuan_detail = 1;";
            $data['list_anggota'] = $this->db->query($query)->result();
            $data['jenis'] = 'not temp';
        }
        return $this->load->view(VIEW_ADMIN . 'new/tambahan_penelitian/list_anggota_dosen_luar', $data); 
    }

    public function delete_temp($nip,$idlistevent)
    {
        $nip_ketua = $this->session->userdata('nidn');
        $this->db->where(['id_list_event' => $idlistevent, 'nip_ketua' => $nip_ketua, 'nip_anggota' => $nip]);
        $halo = $this->db->delete('temp_anggota_polije');
        if($halo)
        {
            echo "sukses";
        }else {
            echo "error";
        }
    }

    public function delete_temp_luar($noktp,$idlistevent)
    {
        $nip_ketua = $this->session->userdata('nidn');
        $this->db->where(['id_list_event' => $idlistevent, 'nip_ketua' => $nip_ketua, 'noktp' => $noktp]);
        $halo = $this->db->delete('temp_anggota_luar');
        if($halo)
        {
            echo "sukses";
        }else {
            echo "error";
        }
    }

    public function delete_not_temp($nip,$idpengajuandetail)
    {
        $this->db->where(['id_pengajuan_detail' => $idpengajuandetail, 'nidn' => $nip]);
        $halo =  $this->db->delete('tb_anggota_dosen');
        if($halo)
        {
            echo "sukses";
        }else {
            echo "error";
        }
    }

    public function delete_not_temp_luar($noktp,$idpengajuandetail)
    {
        $this->db->where(['id_pengajuan_detail' => $idpengajuandetail, 'noktp' => $noktp]);
        $halo =  $this->db->delete('tb_anggota_pengajuan_dosen_luar');
        if($halo)
        {
            echo "sukses";
        }else {
            echo "error";
        }
    }

    public function cekJumlahTemp_polije($idlistevent,$skema,$id_pengajuan_detail = null)
    {
        $query = "SELECT * from tb_st_skema_event where id_list_event =".$idlistevent." AND id_skema = ".$skema;
        $cek_1 = $this->db->query($query)->row();
        $nip_ketua = $this->session->userdata('nidn');

        if($cek_1 != null)
        {
            if($id_pengajuan_detail == null)
            {
                //kalo null berati masih temp

                $query = "SELECT count(*) jmlh from temp_anggota_polije where id_list_event =".$idlistevent." AND nip_ketua = ".$nip_ketua;
                $cek = $this->db->query($query)->row();
                if($cek == null)
                {
                    echo "error";
                    return "error";
                }

                //ditambah satu karena di temp ketuanya tidak masuk di insert kesana 
                if(intval($cek_1->jml_agt_polije) <= intval(($cek->jmlh + 1)))
                {
                    echo "error";
                    return "error";
                }
                return "sukses";
            }
            if($id_pengajuan_detail != null)
            {
                $query = "SELECT count(*) jmlh from tb_anggota_dosen where id_pengajuan_detail =".$id_pengajuan_detail;
                $cek = $this->db->query($query)->row();
                if($cek == null)
                {
                    echo "error";
                    return "error";
                }

                if(intval($cek_1->jml_agt_polije) <= intval($cek->jmlh))
                {
                    echo "error";
                    return "error";
                }
                echo "sukses";
                return "sukses";
            }
        }

        //return sukses berati bisa insert / tambahan anggota . kalo error berati sudah tidak bisa (munculkan alert tidak bisa tambah)
    }

    public function cekJumlahTemp_luar($idlistevent,$skema,$id_pengajuan_detail = null)
    {
        $query = "SELECT * from tb_st_skema_event where id_list_event =".$idlistevent." AND id_skema = ".$skema;
        $cek_1 = $this->db->query($query)->row();
        $nip_ketua = $this->session->userdata('nidn');

        if($cek_1 != null)
        {
            if($id_pengajuan_detail == null)
            {
                //kalo null berati masih temp

                $query = "SELECT count(*) jmlh from temp_anggota_luar where id_list_event =".$idlistevent." AND nip_ketua = ".$nip_ketua;
                $cek = $this->db->query($query)->row();
                if($cek == null)
                {
                    echo "error";
                    return "error";
                }

                //ditambah satu karena di temp ketuanya tidak masuk di insert kesana 
                if(intval($cek_1->jml_agt_luar)  <= intval(($cek->jmlh + 1)) )
                {
                    echo "error";
                    return "error";
                }
                echo "sukses";
                return "sukses";
            }
            if($id_pengajuan_detail != null)
            {
                $query = "SELECT count(*) jmlh from tb_anggota_pengajuan_dosen_luar where id_pengajuan_detail =".$id_pengajuan_detail;
                $cek = $this->db->query($query)->row();
                if($cek == null)
                {
                    echo "error";
                    return "error";
                }

                if(intval($cek_1->jml_agt_luar)  <= intval($cek->jmlh))
                {
                    echo "error";
                    return "error";
                }
                echo "sukses";
                return "sukses";
            }
        }

        //return sukses berati bisa insert / tambahan anggota . kalo error berati sudah tidak bisa (munculkan alert tidak bisa tambah)
    }
}