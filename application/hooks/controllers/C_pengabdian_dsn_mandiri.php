<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_pengabdian_dsn_mandiri extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata("login")) {
            redirect('');
        }
        $this->load->model('M_pnbp', 'pnbp');
        $this->load->model('M_fokus', 'Mfokus');
        $this->load->model('M_reviewer', 'reviewer');
        $this->load->model('M_mandiri_pengabdian', 'mandiri');
    }

    private function list_dosen($jenis)
    {
        $sql = "select nidn,nama,jenis_job,jenis_unit,unit from dummy_dosen";
        $query = $this->db->query($sql)->result();
        $sql_anggota_dsn = "select nidn from tb_anggota_dosen";
        $query_anggota = $this->db->query($sql_anggota_dsn)->result();
        $dosen = [];
        $ketua = [];

        foreach ($query as $value) {
            if ($value->nidn === $this->session->userdata('nidn')) {
                array_push($ketua, $value);
            } else {
                if (count($query_anggota) > 0) {
                    if (array_search($value->nidn, array_column($query_anggota, 'nidn')) === false) {
                        array_push($dosen, $value);
                    } else {
                        if ($jenis === 'lanjut') {
                            array_push($dosen, $value);
                        }
                    }
                } else {
                    if ($jenis === 'lanjut') {
                        array_push($dosen, $value);
                    } else {
                        $check = $this->check_jml_pengajuan($value->nidn);
                        if ($check == true) {
                            // if(array_search($value->nidn, array_column($query_anggota, 'nidn'))=== false){
                            array_push($dosen, $value);
                            // } 
                        }
                    }


                    // array_push($dosen, $value);
                }
            }
        }

        $data = ['ketua' => $ketua, 'dosen' => $dosen];
        return $data;
    }

    public function index()
    {
        // content

        $data['content'] = VIEW_DOSEN . 'content_status_mandiri_pengabdian';
        // $data['cek_event'] = $cek_event;
        // $data['cek_tutup'] = $tgl_event;
        // $data['username'] = $username;
        $data['pengajuan_url'] = 'C_penelitian_dsn_pnbp/halaman_pengajuan';
        $data['edit_pengajuan_url'] = 'C_penelitian_dsn_pnbp/halaman_edit';
        $data['judul'] = 'Pengusulan Pengabdian Dosen Mandiri';
        $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';
        $data['informasi'] = $this->informasi_dashboard();
        
        $this->load->view('index', $data);
    }

    public function list_prop_mpengabdian($tahun = null){
        if($tahun == null){
            $tahun = date('Y');
        }

        $propo = $this->mandiri->get_all_proposal($tahun);
        echo json_encode($propo);
    }

    private function informasi_dashboard()
    {
        $id_pengajuan = $this->mandiri->id_pengajuan();
        $statusnya = $this->mandiri->status_penelitian();
        $data['status'] = $statusnya[0];
        $data['id_detail'] = $statusnya[1];
        $data['komentar'] = $statusnya[2];
        $data['status_koreksi'] = $statusnya[3];
        $data['status_pengusulan'] = "Belum ada pengajuan";
        $data['tombol'] = 0;
        $data['update'] = '-';
        $data['create'] = '-';
        if($id_pengajuan !== null){
            $where = ['id_pengajuan' => $id_pengajuan->id_pengajuan, 'status !=' => 8];
            $detail = $this->mandiri->pengajuan_mandiri($where)->row();

            if($detail !== null){
                $data['update'] = tp_indo($detail->edit);
                $data['create'] = tp_indo($detail->buat);
                $data['tombol'] = 1;
                $data['status_pengusulan'] = "Pengajuan belum difinalisasi";                
            } 
        } 
        
        return $data;
    }        

    public function finalkan()
    {
        $cek = $this->mandiri->get_status();

        if($cek == null){
            $this->session->set_flashdata('danger', 'Opps ada yang salah');
            $this->session->set_flashdata('key', 'danger');
            redirect('C_pengabdian_dsn_mandiri/mandiri_pengajuan_pengabdian');  
        } else{ 
            if($cek['status'] < 7 ){
                $this->session->set_flashdata('danger', 'Opps ada yang salah');
                $this->session->set_flashdata('key', 'danger');
                redirect('C_pengabdian_dsn_mandiri/mandiri_pengajuan_pengabdian');  
            }
        }

        $this->db->where('id_pengajuan_detail', $cek['id_detail']);
        $this->db->update('pengajuan_detail_mandiri', ['status' => 8]);

        $this->session->set_flashdata('success', 'Berhasil Memfinalkan');
        $this->session->set_flashdata('key', 'success');
        redirect('C_pengabdian_dsn_mandiri');  
    }    

    public function mandiri_pengajuan_pengabdian()
    {
        
        $statusnya = $this->mandiri->status_penelitian();
        $data['status'] = $statusnya[0];
        $data['id_detail'] = $statusnya[1];
        $data['komentar'] = $statusnya[2];        
        $data['status_koreksi'] = $statusnya[3];
        
        if($data['status'] > 2 ){
            $where = ['a.nip !=' => $this->session->userdata('nidn'), 'id_pengajuan_detail' => $data['id_detail'], 'status' => 1];
            $cek = $this->mandiri->get_anggota($where)->row();
            if($cek === null){
                $data['stat_anggota'] = 1;
            } 
        } 

        $data['judul'] = 'Halaman Pengajuan Pengabdian Mandiri';
        $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';
        $data['content'] = VIEW_DOSEN . 'pengajuan_mandiri_pengabdian/dashboard_pengajuan.php';
        $this->load->view('index', $data);
        
    }

    public function view_pengajuan($id = null)
    {

        if($id === null){
            redirect('C_pengabdian_dsn_mandiri');
        }

        $data['luaran'] = $this->reviewer->get_luaran();
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'content_view_pengajuan_mandiri';
        $data['username'] = $username;
        $data['judul'] = 'Nilai Pengajuan';
        $data['brdcrmb'] = 'Beranda / Nilai Pengajuan Mandiri';

        $data['dt_proposal'] = $this->mandiri->get_proposalnya_mandiri($id);
        $data['luaran_checked'] = null;
        $data['luaran_tambahan'] = null;
        if (isset($data['dt_proposal']->id_pengajuan)) {
            $data['dosen'] = $this->reviewer->get_anggota_dosen($data['dt_proposal']->id_pengajuan);
            $data['mahasiswa'] = $this->reviewer->get_anggota_mahasiswa($data['dt_proposal']->id_pengajuan);
            $arr = [];
            foreach ($this->reviewer->get_luaran_checked_mandiri($data['dt_proposal']->id_pengajuan) as $value) {
                array_push($arr, $value->id_luaran);
            }

            if ($data['dt_proposal']->is_nambah_luaran === "1") {
                $data['luaran_tambahan'] = $this->reviewer->luaran_tambahan_mandiri($data['dt_proposal']->id_pengajuan);
            }

            $data['luaran_checked'] = $arr;
        } else {
            echo 'gabisa';
            return;
        }

        $this->load->view('index', $data);   
    }

    // akhircontroller

}