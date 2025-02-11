<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_penelitian_dsn_mandiri extends CI_Controller
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
        $this->load->model('M_mandiri', 'mandiri');
    }


    private function check_status_dosen()
    {
        $nidsn = $this->session->userdata('nidn');
        $sql = "select nidn,created_date  from tb_anggota_dosen where nidn = '" . $nidsn . "'";
        $data = $this->db->query($sql)->row();

        return $data;
    }

    public function check_jml_pengajuan($nidsn, $event)
    {
        $hitungan = 0;
        $max_pengajuan = $this->pnbp->get_where('tb_hindex', ['nidsn_dosen' => $nidsn])->row();
        // print_r($max_pengajuan);

        $check_ketua = $this->pnbp->check_ketua($nidsn, $event)->num_rows();
        echo $check_ketua;

        $check_anggota = $this->pnbp->check_anggota($nidsn)->num_rows();
        print_r($check_anggota);

        $total_pengajuan = $check_ketua + $check_anggota;
        echo $total_pengajuan;
        return;
        if (empty($max_pengajuan)) {
            return false;
        } else if ($total_pengajuan >= $max_pengajuan->jumlah_pengajuan_ketua + $max->jumlah_pengajuan_anggota || $max_pengajuan->jumlah_pengajuan == 0) {
            return true;
        }
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

    private function list_mahasiswa()
    {
        $sql_anggota = "select nim from tb_anggota_mhs";
        $query_anggota = $this->db->query($sql_anggota)->result();
        $hasil = array();
        $sql = "select * from dummy_mahasiswa";
        $query = $this->db->query($sql)->result();

        if (count($query_anggota) > 0) {
            foreach ($query as $value) {
                if (array_search($value->nim, array_column($query_anggota, 'nim')) === false) {
                    array_push($hasil, $value);
                }
            }

            return $hasil;
        } else {
            return $query;
        }
    }

    public function index()
    {
        // content
        // $data['content'] = VIEW_DOSEN . 'content_status_masih_disiapkan';
        // $data['judul'] = 'Pengusulan Penelitian Dosen Mandiri';
        // $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';
        // $this->load->view('index', $data);
        // return;
        
        $data['content'] = VIEW_DOSEN . 'content_status_mandiri';
        // $data['cek_event'] = $cek_event;
        // $data['cek_tutup'] = $tgl_event;
        // $data['username'] = $username;
        $data['pengajuan_url'] = 'C_penelitian_dsn_pnbp/halaman_pengajuan';
        $data['edit_pengajuan_url'] = 'C_penelitian_dsn_pnbp/halaman_edit';
        $data['judul'] = 'Pengusulan Penelitian Dosen Mandiri';
        $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';
        $data['informasi'] = $this->informasi_dashboard();

        $propo = $this->mandiri->get_all_proposal();
        $data['get_proposal'] = count($propo) == 0 ? null : $propo;
        $this->load->view('index', $data);
    }


    public function halaman_pengajuan()
    {
        // content
        // $id_pengajuan = $this->pnbp->get_proposal_dosen($this->session->userdata('nidn'))->row();
        if (!empty($id_pengajuan)) {
            $check_anggota = $this->pnbp->check_permintaan_anggota($id_pengajuan->id_pengajuan)->result();
            $count = count($check_anggota);
            // $data['lanjut_dosen'] = $this->get_lanjutan_dosen($id_pengajuan->id_pengajuan);
            $data['dosen'] = $this->list_dosen('lanjut');
            $this->load->model('M_reviewer', 'reviewer');
            $data['dt_proposal'] = $this->reviewer->get_proposalnya($id_pengajuan->id_pengajuan);
            $data['luaran_checked'] = null;
            $data['luaran_tambahan'] = null;
            if (isset($data['dt_proposal']->id_pengajuan)) {
                $arr = [];
                foreach ($this->reviewer->get_luaran_checked($data['dt_proposal']->id_pengajuan) as $value) {
                    array_push($arr, $value->id_luaran);
                }

                if ($data['dt_proposal']->is_nambah_luaran === "1") {
                    $data['luaran_tambahan'] = $this->reviewer->luaran_tambahan($data['dt_proposal']->id_pengajuan);
                }

                $data['luaran_checked'] = $arr;
            } else {
                echo 'gabisa woi';
                return;
            }
        } else {
            $count = 0;
            $data['dosen'] = $this->list_dosen('tidak');
        }
        $cek = $this->get_id_event();
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['judul'] = 'Pengajuan Penelitian Mandiri';
        $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';

        if ($cek === null) {
            $data['content'] = VIEW_DOSEN . 'content_noEvent.php';
            return $this->load->view('index', $data);
        }

        $data['content'] = VIEW_DOSEN . 'content_penelitian_dsn_mandiri';

        $data['mahasiswa'] = $this->list_mahasiswa();
        $data['fokus'] = $this->Mfokus->get_fokus(1);
        $data['luaran'] = $this->Mfokus->get_all('tb_luaran')->result();
        $data['id_event'] = $cek->id_event;
        $data['cek_lanjut'] = $count;

        $this->load->view('index', $data);
    }

    public function finalkan()
    {
        $cek = $this->mandiri->get_status();

        if ($cek == null) {
            $this->session->set_flashdata('danger', 'Opps ada yang salah');
            $this->session->set_flashdata('key', 'danger');
            redirect('C_penelitian_dsn_mandiri/mandiri_pengajuan_penelitian');
        } else {
            if ($cek['status'] < 7) {
                $this->session->set_flashdata('danger', 'Opps ada yang salah');
                $this->session->set_flashdata('key', 'danger');
                redirect('C_penelitian_dsn_mandiri/mandiri_pengajuan_penelitian');
            }
        }

        $this->db->where('id_pengajuan_detail', $cek['id_detail']);
        $this->db->update('pengajuan_detail_mandiri', ['status' => 8]);

        $this->session->set_flashdata('success', 'Berhasil Memfinalkan');
        $this->session->set_flashdata('key', 'success');
        redirect('C_penelitian_dsn_mandiri');
    }

    public function mandiri_pengajuan_penelitian()
    {
        $statusnya = $this->mandiri->status_penelitian();
        $data['status'] = $statusnya[0];
        $data['id_detail'] = $statusnya[1];
        $data['komentar'] = $statusnya[2];
        $data['status_koreksi'] = $statusnya[3];

        if ($data['status'] > 2) {
            $where = ['a.nip !=' => $this->session->userdata('nidn'), 'id_pengajuan_detail' => $data['id_detail'], 'status' => 1];
            $cek = $this->mandiri->get_anggota($where)->row();
            if ($cek === null) {
                $data['stat_anggota'] = 1;
            }
        }

        $data['judul'] = 'Halaman Pengajuan Penelitian Mandiri';
        $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';
        $data['content'] = VIEW_DOSEN . 'pengajuan_mandiri/dashboard_pengajuan.php';
        $this->load->view('index', $data);
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
        if ($id_pengajuan !== null) {
            $where = ['id_pengajuan' => $id_pengajuan->id_pengajuan, 'status !=' => 8];
            $detail = $this->mandiri->pengajuan_mandiri($where)->row();

            if ($detail !== null) {
                $data['update'] = tp_indo($detail->edit);
                $data['create'] = tp_indo($detail->buat);
                $data['tombol'] = 1;
                $data['status_pengusulan'] = "Pengajuan belum difinalisasi";
            }
        }

        return $data;
    }



    public function noEvent()
    {
        // content
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_DOSEN . 'content_noEvent';
        $data['username'] = $username;
        $data['judul'] = 'Pengusulan Penelitian Dosen Mandiri';
        $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';

        $this->load->view('index', $data);
    }

    public function status()
    {
        // content
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_DOSEN . 'content_status';
        $data['username'] = $username;
        $data['judul'] = 'Pengusulan Penelitian Dosen Mandiri';
        $data['brdcrmb'] = 'Beranda / Penelitian Dosen / Mandiri';

        $this->load->view('index', $data);
    }

    public function view_pengajuan($id = null)
    {

        if ($id === null) {
            redirect('C_penelitian_dsn_mandiri');
        }

       
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'content_view_pengajuan_mandiri';
        $data['username'] = $username;
        $data['judul'] = 'Nilai Pengajuan';
        $data['brdcrmb'] = 'Beranda / Nilai Pengajuan Mandiri';

        $data['dt_proposal'] = $this->mandiri->get_proposalnya_mandiri($id);
        $data['luaran'] = $this->Mfokus->kel_luaran_penelitian_dosen("tb_luaran")->result();
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
