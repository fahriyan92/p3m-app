<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_penelitian_plp_pnbp extends CI_Controller
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
    }

    private function get_event()
    {
        // id_jenis_event DARI tb_jenis_event , dengan id_event PLP
        $sql = "select waktu_mulai mulai,waktu_akhir selesai from tb_list_event where id_jenis_event= 5 AND id_tahapan = 2 AND YEAR(waktu_mulai) = YEAR(CURDATE()) AND status =1 ";
        $data = $this->db->query($sql)->row();

        return $data;
    }

    private function get_id_event_evaluasi()
    {
        $sql = "select id_list_event id_event, waktu_mulai mulai,waktu_akhir selesai from tb_list_event where id_jenis_event = 5 AND id_tahapan = 11 AND (curdate() between waktu_mulai AND waktu_akhir) AND status = 1;";
        $data = $this->db->query($sql)->row();

        return $data;
    }

    public function check_jml_pengajuan($nidsn, $event)
    {
        if ($event == null) {
            return false;
        }
        $hitungan = 0;
        $max_pengajuan = $this->pnbp->get_where('tb_hindex', ['nidsn_dosen' => $nidsn])->row();

        $get_jumlah_pengajuan = $this->pnbp->get_proposal_dosen($this->session->userdata('nidn'), $event)->num_rows();

        if (empty($max_pengajuan) || $max_pengajuan->limit_penelitian <= 0) {
            return false;
        } else {
            return true;
        }
    }

    public function get_id_event()
    {
        $sql = "select id_list_event id_event, waktu_mulai mulai, waktu_akhir selesai from tb_list_event where id_jenis_event = 5 AND id_tahapan = 2 AND (curdate() between waktu_mulai AND waktu_akhir) AND status = 1";
        $data = $this->db->query($sql)->row();

        return $data;
    }

    private function check_status_dosen($id_list_event)
    {
        $nidsn = $this->session->userdata('nidn');
        $sql = "SELECT C.id_pengajuan, C.id_list_event, C.created_at, C.nidn_ketua, D.id_list_event, D.id_jenis_event FROM tb_pengajuan as C JOIN tb_list_event as D ON C.id_list_event=D.id_list_event WHERE C.nidn_ketua= '" . $nidsn . "' AND D.id_list_event = '" . $id_list_event . "' AND D.id_jenis_event = 5 ";
        $data = $this->db->query($sql)->row();

        return $data;
    }

    public function check_permintaan_anggota($id)
    {
        $cek_event = $this->get_id_event();

        if ($id == 0) {
            $res = $this->response([4, 'Belum Submit Tahap 1']);
            echo json_encode($res);
            return;
        }
        $id_pengajuan = $this->pnbp->get_proposal_dosen($this->session->userdata('nidn'), $cek_event->id_event)->row();
        if (empty($id_pengajuan)) {
            $res = $this->response([4, 'Belum Submit Tahap 1']);
            echo json_encode($res);
            return;
        }
        $check_anggota = $this->pnbp->check_permintaan_anggota($id)->result();
        $count = count($check_anggota);
        $sql = "SELECT a.status_permintaan FROM tb_permintaan_anggota as a  WHERE a.id_pengajuan_detail = '" . $id . "' AND a.status_permintaan = 1";
        if ($count > 0) {
            $res = $this->response([1, $check_anggota]);
            echo json_encode($res);
            return;
        } else {
            if (count($this->db->query($sql)->result()) === 1) {
                $res = $this->response([3, 'Tidak ada anggotanya']);
                echo json_encode($res);
                return;
            } else {
                $res = $this->response([0, 'Permintaan sudah di acc semua']);
                echo json_encode($res);
                return;
            }
        }
    }

    public function cari_biaya()
    {
        $id = $this->input->post('id');
        $html = '';
        $get_biaya = $this->Mfokus->get_biaya($id)->row();
        $get_luaran = $this->Mfokus->kel_luaran_penelitian_plp('tb_luaran')->result();
        $myArray = [];
        if ($get_biaya && $get_biaya->kelompok_luaran !== null) {
            $myArray = explode(',', $get_biaya->kelompok_luaran);
        }
        // echo json_encode($get_luaran);
        // return;    
        foreach ($get_luaran as $lrt) {
            if ($lrt->jenis_luaran == 2) {
                $html .= '
                     <input type="checkbox" id="luaran1" name="luaran[]" ' . (in_array($lrt->id_luaran, $myArray) ? 'checked' : '') . ' value="' . $lrt->id_luaran . '">
                     <span for="luaran1"> ' . $lrt->judul_luaran . '</span><br>
             ';
            }
        }

        echo json_encode([$get_biaya, $html]);
    }

    public function halaman_identitas()
    {
        // content
        $cek = $this->get_id_event();
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['judul'] = 'Pengajuan Penelitian PNBP Identitas';
        $data['brdcrmb'] = 'Beranda / Penelitian Dosen / PNBP';

        if ($cek === null) {
            $data['content'] = VIEW_DOSEN . 'content_noEvent.php';
            return $this->load->view('index', $data);
        }

        $data['content'] = VIEW_DOSEN . 'halaman_pengajuan/content_identitas';
        $data['dosen'] = $this->list_dosen();
        $data['mahasiswa'] = $this->list_mahasiswa();
        $data['fokus'] = $this->Mfokus->get_fokus(1);
        $data['luaran'] = $this->Mfokus->kel_luaran_penelitian_plp('tb_luaran')->result();
        $data['id_event'] = $cek->id_event;

        $this->load->view('index', $data);
    }

    public function halaman_data_dosen()
    {
        // content
        $cek = $this->get_id_event();
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['judul'] = 'Pengajuan Penelitian PNBP DATA PLP';
        $data['brdcrmb'] = 'Beranda / Penelitian Dosen / PNBP';

        if ($cek === null) {
            $data['content'] = VIEW_DOSEN . 'content_noEvent.php';
            return $this->load->view('index', $data);
        }

        $data['content'] = VIEW_DOSEN . 'halaman_pengajuan/content_data_dosen';
        $data['dosen'] = $this->list_dosen();
        $data['mahasiswa'] = $this->list_mahasiswa();
        $data['fokus'] = $this->Mfokus->get_fokus(1);
        $data['luaran'] = $this->Mfokus->kel_luaran_penelitian_plp('tb_luaran')->result();
        $data['id_event'] = $cek->id_event;

        $this->load->view('index', $data);
    }

    public function lihat_dulu()
    {
        $cek_event = $this->get_id_event();
        $tgl_event = $this->get_event();
        $id_pengajuan = $this->pnbp->get_proposal_dosen($this->session->userdata('nidn'))->row();
        $check_anggota = $this->pnbp->check_permintaan_anggota($id_pengajuan->id_pengajuan)->result_array();
        $halo = [$check_anggota];
        print_r($halo);
    }

    public function preview($id = null)
    {
        if ($id == null) {
            $this->session->set_flashdata('error_access', 'Halaman Tidak Dapat Di Akses');
            redirect("C_penelitian_plp_pnbp");
        }
        $query_isAnggota = "select * from tb_anggota_dosen WHERE  id_pengajuan_detail = '" . $id . "' AND nidn = '" . $this->session->userdata('nidn') . "' ";
        $check_isAnggota = $this->db->query($query_isAnggota)->result();
        if ($check_isAnggota == null) {
            $this->session->set_flashdata('error_access', 'Tidak Dapat Di Akses, Anda Bukan Anggota di proposal ini');
            redirect("C_penelitian_plp_pnbp");
        }
        // content
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_DOSEN . 'plp/content_review_plp';
        $data['username'] = $username;
        $data['judul'] = 'Detail Proposal';
        $data['brdcrmb'] = 'Beranda / Detail Proposal';
        $data['dt_proposal'] = $this->reviewer->get_proposalnya($id);
        $data['luaran'] = $this->Mfokus->kel_luaran_penelitian_plp('tb_luaran')->result();
        $check_anggota = $this->pnbp->check_edit_pengajuan($id)->result();
        // print_r($check_anggota);
        // return;
        if (!empty($check_anggota)) {
            $count = count($check_anggota);
        } else {
            $count = 0;
        }

        $data['pengajuan_url'] = 'C_penelitian_plp_pnbp/halaman_pengajuan/' . $id . '';
        $data['edit_pengajuan_url'] = 'C_penelitian_plp_pnbp/halaman_edit/' . $id . '';
        $data['pengajuan_evaluasi_url'] = 'C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id . '';
        $data['cek_event_evaluasi'] = $this->get_id_event_evaluasi();
        $data['cek_edit'] = $count;
        $data['cek_event'] = $this->get_id_event();
        $data['luaran_checked'] = null;
        $data['luaran_tambahan'] = null;
        if (isset($data['dt_proposal']->id_pengajuan_detail)) {
            $arr = [];
            foreach ($this->reviewer->get_luaran_checked($data['dt_proposal']->id_pengajuan_detail) as $value) {
                array_push($arr, $value->id_luaran);
            }

            if ($data['dt_proposal']->is_nambah_luaran === "1") {
                $data['luaran_tambahan'] = $this->reviewer->luaran_tambahan($data['dt_proposal']->id_pengajuan_detail);
            }

            $data['luaran_checked'] = $arr;
        }

        $this->load->view('index', $data);
    }

    private function cek_kelengkapan_profile()
    {
        $query = $this->db->query("select a.*,b.h_index_schoolar hindex, b.h_index_scopus hindex_scopus from dummy_dosen a left join tb_hindex b on nidn = nidsn_dosen where nidn ='" . $this->session->userdata('nidn') . "'")->row();

        if ($query == null) {
            return "belum lengkap";
        }

        if ($query->file_cv !== null && $query->file_cv !== ""  && $query->nik !== "" && $query->nik !== null && $query->email !== "" && $query->email !== null && $query->telepon !== "" && $query->telepon !== null) {
            return "lengkap";
        }
        return "belum lengkap";
    }

    private function namabaru($n, $p, $s)
    {
        $nama = trim($n);
        $nama_fix = str_replace(" ", "_", $nama);
        $nip = $p;
        $skema = trim($s);
        $skema_fix = "plp";
        $nama_file = $nama_fix . "_" . $nip . "_" . $skema_fix . "_" . time();
        return strtolower($nama_file);
    }

    public function index()
    {
        // content
        $cek_event = $this->get_id_event();
        $cek_event_evaluasi = $this->get_id_event_evaluasi();
        $tgl_event = $cek_event;
        $tgl_event_evaluasi = $cek_event_evaluasi;
        $cek_dosen = $this->check_status_dosen($cek_event !== null ? $cek_event->id_event : 0);
        $username = $this->session->userdata('username');
        $id_pengajuan = $this->pnbp->get_proposal_dosen($this->session->userdata('nidn'), $cek_event !== null ? $cek_event->id_event : 0)->row();
        if (!empty($id_pengajuan)) {
            $check_anggota = $this->pnbp->check_edit_pengajuan($id_pengajuan->id_pengajuan_detail)->result();
            $count = count($check_anggota);
        } else {
            $count = 0;
        }

        $data['cek_pengajuan_selesai'] = $this->pnbp->check_selesai($this->session->userdata('nidn'), $cek_event !== null ? $cek_event->id_event : 0)->num_rows();

        $data['content'] = VIEW_DOSEN . 'plp/content_status';
        $data['cek_event'] = $cek_event;
        $data['cek_event_evaluasi'] = $cek_event_evaluasi;
        $data['cek_tutup'] = $tgl_event;
        $data['cek_tutup_evaluasi'] = $tgl_event_evaluasi;
        // echo json_encode([$cek_event,$tgl_event]);
        // return;
        $data['username'] = $username;
        $data['kelengkapan'] = $this->cek_kelengkapan_profile();
        $data['pengajuan_url'] = 'C_penelitian_plp_pnbp/halaman_pengajuan';
        $data['edit_pengajuan_url'] = 'C_penelitian_plp_pnbp/halaman_edit';
        $data['brdcrmb'] = 'Beranda / Penelitian PLP / PNBP';
        $data['judul'] = 'Pengajuan Penelitian PLP PNBP';
        $data['hindex'] = $this->pnbp->get_where('tb_hindex', ['nidsn_dosen' => $this->session->userdata('nidn')])->row();
        $data['get_proposal'] = $this->pnbp->list_proposal_status_penelitian($this->session->userdata('nidn'), '3')->result(); // 3 adalah id_event di tb_event PLP
        $data['dah_max_blum'] = $cek_event == null ? true : $this->check_jml_pengajuan($_SESSION['nidn'], $cek_event !== null ? $cek_event->id_event : 0);
        $data['cek_edit'] = $count;

        if ($cek_dosen === null) {
            $data['status'] = 'Belum ada Pengajuan';
            $data['created'] = '-';
            $data['tombol'] = '0';
        } else {
            $data['status'] = 'Sudah Mengajukan';
            $data['created'] = $cek_dosen->created_at;
            $data['tombol'] = '1';
        }
        if ($cek_event === null) {
            $data['akhir'] = '-';

            $data['sisa'] = "-";
        } else {
            $date1 = $tgl_event->selesai;
            $date2 = date('Y-m-d');
            $datetime1 = new DateTime($date1);
            $datetime2 = new DateTime($date2);
            $difference = $datetime1->diff($datetime2);
            $data['akhir'] = $tgl_event->selesai;

            $data['sisa'] = $difference->days;;
        }
        if ($cek_event_evaluasi === null) {
            $data['akhir_evaluasi'] = '-';

            $data['sisa_evaluasi'] = "-";
        } else {
            $date1_evaluasi = $tgl_event_evaluasi->selesai;
            $date2_evaluasi = date('Y-m-d');
            $datetime1_evaluasi = new DateTime($date1_evaluasi);
            $datetime2_evaluasi = new DateTime($date2_evaluasi);
            $difference_evaluasi = $datetime1_evaluasi->diff($datetime2_evaluasi);
            $data['akhir_evaluasi'] = $tgl_event_evaluasi->selesai;

            $data['sisa_evaluasi'] = $difference_evaluasi->days;;
        }

        $this->load->view('index', $data);
    }

    public function noEvent()
    {
        // content
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_DOSEN . 'content_noEvent';
        $data['username'] = $username;
        $data['judul'] = 'Pengajuan Penelitian PLP PNBP';
        $data['brdcrmb'] = 'Beranda / Penelitian PLP / PNBP';

        $this->load->view('index', $data);
    }

    public function get_lanjutan_dosen($id_pengajuan)
    {
        // $sql = "select a.*,b.status_permintaan status_notifikasi , c.file_cv, c.scopus from tb_anggota_dosen a join tb_permintaan_anggota b on a.id_anggota_dsn = b.id_anggota join dummy_dosen c on a.nidn = c.nidn where a.id_pengajuan_detail = " . $id_pengajuan;
        $sql = "select 	a.*,
        b.status_permintaan status_notifikasi,
        c.nidn, 
        c.nip,
        c.nama,
        c.jenis_job,
        c.jenis_unit,
        c.unit,
        c.sinta,
        c.scopus,
        c.file_cv,
        c.scopus  from tb_anggota_dosen a join tb_permintaan_anggota b on a.id_anggota_dsn = b.id_anggota join dummy_dosen c on a.nidn = c.nidn where a.id_pengajuan_detail = " . $id_pengajuan;
        $ketua = [];
        $anggota = [];
        $hel = $this->db->query($sql)->result();
        foreach ($hel as $val) {
            if ($val->nidn === $_SESSION['nidn']) {
                array_push($ketua, $val);
            } else {
                array_push($anggota, $val);
            }
        }

        return ['ketua' => $ketua, 'anggota' => $anggota];
    }

    public function halaman_pengajuan($id = null)
    {
        if ($id != null) {
            $id_pengajuan = $this->reviewer->get_proposalnya($id);

            $query_isAnggota = "select * from tb_anggota_dosen WHERE  id_pengajuan_detail = '" . $id . "' AND nidn = '" . $this->session->userdata('nidn') . "' ";
            $check_isAnggota = $this->db->query($query_isAnggota)->result();
            if ($check_isAnggota == null) {
                $this->session->set_flashdata('error_access', 'Tidak Dapat Di Akses, Anda Bukan Anggota di proposal ini');
                redirect("C_penelitian_dsn_pnbp");
            }
            if ($id_pengajuan->nidn_ketua != $this->session->userdata('nidn')) {
                $this->session->set_flashdata('error_access', 'Tidak Dapat Di Akses, Anda Bukan Ketua di proposal ini');
                redirect("C_penelitian_dsn_pnbp");
            }
        }
        $cek_event = $this->get_id_event();
        $id_eventnya = '';

        if ($cek_event === null) {
            $this->session->set_flashdata('error_access', 'Halaman Tidak Dapat Di Akses, Event Sudah Di Tutup');
            redirect("C_penelitian_plp_pnbp/");
        } else {
            $id_eventnya = $cek_event->id_event;
        }

        // content
        $id_pengajuan = $this->pnbp->get_proposal_dosen($this->session->userdata('nidn'), $cek_event->id_event)->row();
        if ($id != null) {
            $check_anggota = $this->pnbp->check_permintaan_anggota($id)->result();
            $count = count($check_anggota);
            $data['lanjut_dosen'] = $this->get_lanjutan_dosen($id);
            $data['dosen'] = $this->list_dosen('lanjut', $id_eventnya);
            $this->load->model('M_reviewer', 'reviewer');
            $data['dt_proposal'] = $this->reviewer->get_proposalnya($id);
            $data['luaran_checked'] = null;
            $data['luaran_tambahan'] = null;
            if (isset($data['dt_proposal']->id_pengajuan_detail)) {
                $arr = [];
                foreach ($this->reviewer->get_luaran_checked($data['dt_proposal']->id_pengajuan_detail) as $value) {
                    array_push($arr, $value->id_luaran);
                }

                if ($data['dt_proposal']->is_nambah_luaran === "1") {
                    $data['luaran_tambahan'] = $this->reviewer->luaran_tambahan($data['dt_proposal']->id_pengajuan_detail);
                }

                $data['luaran_checked'] = $arr;
            } else {
                $this->session->set_flashdata('error_access', 'Tidak Dapat Di Akses');
                redirect("C_penelitian_dsn_pnbp");
                return;
            }
        } else {

            $count = 0;
            $data['lanjut_dosen'] = null;
            $data['dosen'] = $this->list_dosen('tidak', $id_eventnya);
        }
        $cek = $this->get_id_event();
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['judul'] = 'Pengajuan Penelitian PNBP';
        $data['brdcrmb'] = 'Beranda / Penelitian PLP / PNBP';

        if ($cek === null) {
            $data['content'] = VIEW_DOSEN . 'content_noEvent.php';
            return $this->load->view('index', $data);
        }

        $data['content'] = VIEW_DOSEN . 'plp/content_penelitian_plp_pnbp';

        $data['mahasiswa'] = $this->list_mahasiswa();
        $data['temas'] = $this->Mfokus->list_tema(3);
        $data['luaran'] = $this->Mfokus->kel_luaran_penelitian_plp('tb_luaran')->result();
        $data['kelompok'] = $this->Mfokus->kel_luaran_penelitian_plp('tb_kelompok_pengajuan')->result();
        $data['id_event'] = $cek->id_event;
        $data['cek_lanjut'] = $count;
        // echo "<pre>";
        // print_r($data['lanjut_dosen']);
        // die();
        // return;
        $this->load->view('index', $data);
    }

    public function get_all_dosen()
    {
        $dosen = $this->pnbp->get_all('dummy_dosen')->result();
        echo json_encode($dosen);
    }

    public function get_max_pengajuan($nidsn)
    {
        $max_pengajuan = $this->pnbp->get_where('tb_hindex', ['nidsn_dosen' => $nidsn])->row();
        return $max_pengajuan->limit_penelitian;
    }

    public function halaman_edit_pengajuan()
    {
        // content
        $cek = $this->get_id_event();
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['judul'] = 'Pengajuan Penelitian PLP PNBP';
        $data['brdcrmb'] = 'Beranda / Penelitian PLP / PNBP';

        if ($cek === null) {
            $data['content'] = VIEW_DOSEN . 'content_noEvent.php';
            return $this->load->view('index', $data);
        }
        $data['kelompok'] = $this->Mfokus->kel_luaran_penelitian_plp('tb_kelompok_pengajuan')->result();

        $data['content'] = VIEW_DOSEN . 'plp/content_edit_penelitian_plp_pnbp';
        $data['dosen'] = $this->pnbp->get_all('dummy_dosen');
        // $data['mhs'] = $this->pnbp->get_all('tb_dummy_jurusan');
        // $data['d_jurusan'] = $this->pnbp->get_all('tb_dummy_jurusan');
        $data['id_event'] = $cek->id_event;

        $this->load->view('index', $data);
    }

    private function response($res)
    {

        $pesan = ['code' => $res[0], 'pesan' => $res[1]];

        return $pesan;
    }
    public function ehey()
    {
        print_r([$_FILES, $_POST]);
    }

    public function store_pengajuan_kedua()
    {

        $id_event = $this->get_id_event();
        $tgl_now = date('Y-m-d H:i:s');

        // $id_pengajuan = $this->pnbp->get_proposal_dosen($this->session->userdata('nidn'))->row();

        if ($id_event === null) {
            echo json_encode(['message' => 'tidak ada event']);
            return;
        }

        $post = $this->input->post();
        $mhs = [];
        $tgl_now = date('Y-m-d');
        $id_list_event = $id_event->id_event;

        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();
        $nama_filenya = $this->namabaru($data_nama->nama, $this->session->userdata('nidn'), "penelitian plp");

        $fix_judul = strtolower(preg_replace("/[\/\&%#\$]/", " ", $post['judul']));
        $dir_proposal = realpath(APPPATH . '../assets/berkas/file_proposal/');
        $name_proposal = $_FILES['file_proposal']['name'];
        $extension_proposal = substr($name_proposal, strpos($name_proposal, '.'), strlen($name_proposal) - 1);
        $nm_proposal = $nama_filenya . $extension_proposal;
        $tmp_proposal = $_FILES['file_proposal']['tmp_name'];

        $up_proposal = move_uploaded_file($tmp_proposal, $dir_proposal . '/' . $nm_proposal);
        if (!$up_proposal) {
            echo json_encode(['message' => 'error check file']);
            return;
        }

        $dir_rab = realpath(APPPATH . '../assets/berkas/file_rab/');
        $name_rab = $_FILES['file_rab']['name'];
        $extension_rab = substr($name_rab, strpos($name_rab, '.'), strlen($name_rab) - 1);
        $nm_rab = $nama_filenya . $extension_rab;
        $tmp_rab = $_FILES['file_rab']['tmp_name'];

        $up_rab = move_uploaded_file($tmp_rab, $dir_rab . '/' . $nm_rab);
        if (!$up_rab) {
            echo json_encode(['message' => 'error check file']);
            return;
        }

        $insertkan = [
            'dokumen_pengajuan' => [
                'file_proposal' => $nm_proposal,
                'file_rab' => $nm_rab,
            ],
            'id_pengajuan_detail' => $post['id_pengajuan_detail']
        ];

        $insert = $this->pnbp->store_pengajuan_kedua_plp($insertkan);
        if ($insert) {
            $res = $this->response([1, 'Berhasil Insert Tahap Dua']);
            echo json_encode($res);
            return;
        } else {
            echo $insert;
        }
    }

    public function store_pengajuan()
    {
        $id_event = $this->get_id_event();
        $tgl_now = date('Y-m-d H:i:s');

        if ($id_event === null) {
            echo json_encode(['message' => 'tidak ada event']);
            return;
        }

        $post = $this->input->post();
        $mhs = [];
        $dsn = [];
        $tgl_now = date('Y-m-d');
        $id_list_event = $id_event->id_event;
        $mode = $post['mode'];
        // $dir_cv = realpath(APPPATH . '../assets/berkas/file_cv/');


        //mhs
        // $nim = explode(',', $post['nim']);

        //dosen
        $nidn = explode(',', $post['nidn']);
        $sinta = explode(',', $post['sinta']);

        for ($i = 0; $i < count($nidn); $i++) {

            $dsn[$i] = [
                'nidn' => $nidn[$i],
                'status' => 1
            ];
        }

        $is_nambah_luaran = 0;
        if ($post['luaran_tambahan'] !== null) {
            $is_nambah_luaran = 1;
        }

        $luaran = [];
        if ($post['luaran'] !== "") {
            $target = explode(',', $post['luaran']);

            for ($i = 0; $i < count($target); $i++) {
                $luaran[$i] = [
                    'id_luaran' => $target[$i],
                    'status' => 1
                ];
            }
        }


        $insertkan = [
            'pengajuan' => [
                'id_list_event' => $id_list_event,
                'nidn_ketua' => $post['nidn_ketua'],
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            'det_pengajuan' => [
                'id_pengajuan' => null,
                'is_nambah_luaran' => $is_nambah_luaran,
                'id_fokus' => $post['fokus'],

            ],
            'identitas_pengajuan' => [
                'id_pengajuan_detail' => null,
                'tema_penelitian' => $post['tema'],
                'sasaran' => $post['sasaran'],
                'judul' => $post['judul'],
                'id_kelompok_pengajuan' => $post['jnsproposal'],
                'tanggal_mulai_kgt' => $post['mulai'],
                'tanggal_akhir_kgt' => $post['akhir'],
                'biaya' => intval($post['biaya']),
                'tahun_usulan' => $post['tahun_usulan'],
                'identitas_tkt' => $post['identitas_tkt'],
            ],
            'dokumen_pengajuan' => [
                'id_pengajuan_detail' => null,
                'ringkasan_pengajuan' => $post['ringkasan'],
                'metode' => $post['metode'],
                'tinjauan_pustaka' => $post['tinjauan'],
                'status' => 1
            ],
            'luaran_tambahan' => [
                'id_pengajuan_detail' => null,
                'judul_luaran_tambahan' => $post['luaran_tambahan'],
                'status' => 1
            ],
            'update_limit' => [
                'limit_penelitian' => $this->get_max_pengajuan($this->session->userdata('nidn')) - 1
            ],
            'dosen' => $dsn,
            'luaran' => $luaran,
            'mahasiswa' => $mhs
        ];


        if (!isset($post['id_pengajuan_detail']) && $mode === 'simpan') {
            $insert = $this->pnbp->store_pengajuan_plp($insertkan);
            if ($insert) {
                $res = $this->response([1, 'Berhasil, Tunggu Persetujuan anggota !']);
                echo json_encode($res);
                return;
            }
        } else {
            $updatekan = [

                'pengajuan' => [
                    'id_list_event' => $id_list_event,
                    'nidn_ketua' => $post['nidn_ketua'],
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ],
                'det_pengajuan' => [
                    'is_nambah_luaran' => $is_nambah_luaran,
                    'id_fokus' => $post['fokus'],

                ],
                'identitas_pengajuan' => [
                    'id_pengajuan_detail' => $post['id_pengajuan_detail'],
                    'judul' => $post['judul'],
                    'id_kelompok_pengajuan' => $post['jnsproposal'],
                    'tanggal_mulai_kgt' => $post['mulai'],
                    'tanggal_akhir_kgt' => $post['akhir'],
                    'biaya' => intval($post['biaya']),
                    'tahun_usulan' => $post['tahun_usulan'],
                    'identitas_tkt' => $post['identitas_tkt'],

                ],
                'dokumen_pengajuan' => [
                    'id_pengajuan_detail' => $post['id_pengajuan_detail'],
                    'ringkasan_pengajuan' => $post['ringkasan'],
                    'metode' => $post['metode'],
                    'tinjauan_pustaka' => $post['tinjauan'],
                    'status' => 1
                ],
                'luaran_tambahan' => [
                    'id_pengajuan_detail' => $post['id_pengajuan_detail'],
                    'judul_luaran_tambahan' => $post['luaran_tambahan'],
                    'status' => 1
                ],
                'dosen' => $dsn,
                'luaran' => $luaran,
            ];
            $update = $this->pnbp->edit_pertama($updatekan, $post['id_pengajuan_detail']);
            if ($update) {
                $res = $this->response([1, 'Berhasil, Tunggu Persetujuan anggota !']);
                echo json_encode($res);
                return;
            }
        }
    }

    private function list_mahasiswa($jenis = null)
    {
        $sql_anggota = "select nim from tb_anggota_mhs";
        $query_anggota = $this->db->query($sql_anggota)->result();
        $hasil = array();
        $sql = "select * from dummy_mahasiswa";
        $query = $this->db->query($sql)->result();

        if (count($query_anggota) > 0) {
            foreach ($query as $value) {
                if ($jenis !== 'edit') {
                    if (array_search($value->nim, array_column($query_anggota, 'nim')) === false) {
                        array_push($hasil, $value);
                    }
                } else {
                    array_push($hasil, $value);
                }
            }

            return $hasil;
        } else {
            return $query;
        }
    }

    private function list_dosen($jenis, $event)
    {
        $sql = "select nidn,nama,jenis_job,jenis_unit,unit,sinta,scopus,file_cv from dummy_dosen, tb_hindex b WHERE file_cv != '' AND email != ''  AND jenis_job = 'plp' AND nidn = b.nidsn_dosen AND b.limit_penelitian > 0";
        $query = $this->db->query($sql)->result();
        $sql_anggota_dsn = "select nidn from tb_anggota_dosen ";

        $query_anggota = $this->db->query($sql_anggota_dsn)->result();
        $dosen = [];
        $semua = [];
        $ketua = [];
        $cek_event = $this->get_id_event();

        foreach ($query as $value) {
            if ($value->nidn === $this->session->userdata('nidn')) {
                array_push($ketua, $value);
            } else {
                // if (count($query_anggota) > 0) {
                //     if (array_search($value->nidn, array_column($query_anggota, 'nidn')) === false) {
                //         array_push($dosen, $value);
                //     } else {
                //         if ($jenis === 'lanjut') {
                //             array_push($dosen, $value);
                //         }
                //     }
                // } else {
                // if ($jenis === 'lanjut') {
                array_push($semua, $value);
                // } else {
                $check = $this->check_jml_pengajuan($value->nidn, $event);
                if ($check === true) {
                    // if(array_search($value->nidn, array_column($query_anggota, 'nidn'))=== false){
                    array_push($dosen, $value);
                    // } 
                }
                // }


                // array_push($dosen, $value);
                // }
            }
        }

        $data = ['ketua' => $ketua, 'dosen' => $dosen, 'all' => $semua];
        // echo "<pre>";
        // print_r($data);
        // die();
        return $data;
    }

    public function get_data_pengajuan()
    {
        $nidn_ketua = $_SESSION['nidn'];

        $sql_id_pengajuan = "select * from tb_pengajuan where nidn_ketua = '" . $nidn_ketua . "'";
        $id_pengajuan = $this->db->query($sql_id_pengajuan)->row();

        if ($id_pengajuan === null) {
            return false;
        }


        $sql_dsn = "select nidn, id_sinta sinta from tb_anggota_dosen";
        $sql_mhs = "select nim from tb_anggota_mhs";

        $res_dsn = $this->db->query($sql_dsn)->result();
        $res_mhs = $this->db->query($sql_mhs)->result();


        // $sql_proposal = "select * from tb_pengajuan_proposal a join "

        print_r(json_encode(['proposal' => $id_pengajuan, 'dsn' => $res_dsn, 'mhs' => $res_mhs]));
    }

    public function lihatsession()
    {
        print_r(json_encode($_SESSION));
    }

    private function lanjutan_mahasiswa($id_pengajuan)
    {
        $sql = "select id_anggota_mhs id,nim,nama,jurusan,angkatan from tb_anggota_mhs where id_pengajuan_detail=" . $id_pengajuan;
        $query = $this->db->query($sql)->result();
        return $query;
    }

    public function halaman_edit($id = null)
    {
        if ($id == null) {
            $this->session->set_flashdata('error_access', 'Halaman Tidak Dapat Di Akses');
            redirect("C_penelitian_plp_pnbp");
        }
        $cek_event = $this->get_id_event();
        $id_eventnya = '';
        $id_pengajuan = $this->reviewer->get_proposalnya($id);

        if ($cek_event === null) {
            $this->session->set_flashdata('error_access', 'Halaman Tidak Dapat Di Akses, Event Sudah Di Tutup');
            redirect("C_penelitian_plp_pnbp/preview/$id");
        } else {
            $id_eventnya = $cek_event->id_event;
        }

        $query_isAnggota = "select * from tb_anggota_dosen WHERE  id_pengajuan_detail = '" . $id . "' AND nidn = '" . $this->session->userdata('nidn') . "' ";
        $check_isAnggota = $this->db->query($query_isAnggota)->result();
        if ($check_isAnggota == null) {
            $this->session->set_flashdata('error_access', 'Tidak Dapat Di Akses, Anda Bukan Anggota di proposal ini');
            redirect("C_penelitian_plp_pnbp");
        }
        if ($id_pengajuan->nidn_ketua != $this->session->userdata('nidn')) {
            $this->session->set_flashdata('error_access', 'Tidak Dapat Di Akses, Anda Bukan Ketua di proposal ini');
            redirect("C_penelitian_plp_pnbp");
        }
        // content
        if ($id_pengajuan->id_list_event == $cek_event->id_event) {
            $check_anggota = $this->pnbp->check_permintaan_anggota($id)->result();
            $count = count($check_anggota);
            $data['lanjut_dosen'] = $this->get_lanjutan_dosen($id);
            $data['lanjut_mhs'] = $this->lanjutan_mahasiswa($id);
            $data['dosen'] = $this->list_dosen('lanjut', $id_eventnya);
            $this->load->model('M_reviewer', 'reviewer');
            $data['dt_proposal'] = $this->reviewer->get_proposalnya($id);
            $data['luaran_checked'] = null;
            $data['luaran_tambahan'] = null;
            if (isset($id)) {
                $arr = [];
                foreach ($this->reviewer->get_luaran_checked($id) as $value) {
                    array_push($arr, $value->id_luaran);
                }

                if ($data['dt_proposal']->is_nambah_luaran === "1") {
                    $data['luaran_tambahan'] = $this->reviewer->luaran_tambahan($id);
                }

                $data['luaran_checked'] = $arr;
            } else {
                $this->session->set_flashdata('error_access', 'Tidak Dapat Di Akses');
                redirect("C_penelitian_plp_pnbp");
                return;
            }
        } else {
            $this->session->set_flashdata('error_access', 'Event Pada Saat Pengajuan Proposal ini Sudah Di tutup');
            redirect("C_penelitian_plp_pnbp/preview/$id");

            // $count = 0;
            // $data['dosen'] = $this->list_dosen('tidak',$id_eventnya);
        }
        $cek = $this->get_id_event();
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['judul'] = 'Edit Penelitian PNBP';
        $data['brdcrmb'] = 'Beranda / Penelitian PLP / PNBP';

        if ($cek === null) {
            $data['content'] = VIEW_DOSEN . 'content_noEvent.php';
            return $this->load->view('index', $data);
        }

        $data['content'] = VIEW_DOSEN . '/plp/content_edit_penelitian_plp_pnbp';
        $data['kelompok'] = $this->Mfokus->kel_luaran_penelitian_plp('tb_kelompok_pengajuan')->result();

        //   $data['mahasiswa'] = $this->list_mahasiswa('edit');
        $data['tema'] = $this->Mfokus->list_tema(3);
        $data['luaran'] = $this->Mfokus->kel_luaran_penelitian_plp('tb_luaran')->result();
        $data['id_event'] = $cek->id_event;
        $data['cek_lanjut'] = $count;

        // echo "<pre>";
        // print_r($data['lanjut_dosen']);
        // die();
        // return;
        $this->load->view('index', $data);
    }

    public function store_pengajuan_edit_satu()
    {
        $id_event = $this->get_id_event();
        $tgl_now = date('Y-m-d H:i:s');

        if ($id_event === null) {
            echo json_encode(['message' => 'tidak ada event']);
            return;
        }

        $post = $this->input->post();
        $dsn = [];
        $tgl_now = date('Y-m-d');
        $id_list_event = $id_event->id_event;
        // $dir_cv = realpath(APPPATH . '../assets/berkas/file_cv/');

        $nidn = explode(',', $post['nidn']);
        $sinta = explode(',', $post['sinta']);
        // $cv_moment = explode(',', $post['status_cv']);



        // for ($i = 0; $i < count($nidn); $i++) {
        //     if ($cv_moment[$i] != 'tidak') {
        //         $sql = "select file_cv from tb_anggota_dosen where nidn=" . $nidn[$i];
        //         $query = $this->db->query($sql)->result();

        //         foreach ($query as $val) {
        //             if (file_exists($dir_cv . $val->file_cv)) {
        //                 $hapus = unlink($dir_cv . $val->file_cv);
        //             }
        //         }
        //     }
        // }

        $ber_cv = 0;
        $woi = [];
        $file_cv = [];
        for ($i = 0; $i < count($nidn); $i++) {
            $name = '';
            $extension = '';
            // if ($cv_moment[$i] != 'tidak') {
            //     $name = $_FILES['filecv']['name'][$ber_cv];
            //     $extension = substr($name, strpos($name, '.'), strlen($name) - 1);
            //     $ber_cv++;
            // }

            $bro = [
                'nidn' => $nidn[$i],
                // 'id_sinta' => $sinta[$i],
                'status' => 1
            ];

            // if ($name !== '') {
            //     array_push($file_cv, 'cv_' . $nidn[$i] . '_' . date("Y-m-d") . $extension);
            // } else {
            // if (isset($post['file_lama'])) {
            //     $coco = explode(',', $post['file_lama']);
            //     if (count($coco) > 1) {
            //         for ($c = 0; count($coco) > $c; $c++) {
            //             $bro = explode('?', $coco[$c]);
            //             if ($nidn[$i] === $bro[0]) {
            //                 $namanya = $bro[1];
            //                 array_push($file_cv, $namanya);
            //             }
            //         }
            //     } else {
            //         $hehe = explode('?', $post['file_lama']);
            //         if ($nidn[$i] === $hehe[0]) {
            //             $namanya = $hehe[1];
            //             array_push($file_cv, $namanya);
            //         }
            //     }
            // } else {
            //     array_push($file_cv, 'cv_' . $nidn[$i] . '_' . date("Y-m-d") . $extension);
            // }
            // }
        }

        for ($i = 0; count($nidn) > $i; $i++) {
            $dsn[$i] = [
                'nidn' => $nidn[$i],
                // 'id_sinta' => $sinta[$i],
                // 'file_cv' => $file_cv[$i],
                'status' => 1
            ];
        }

        $status_cv = [];
        $urutan_cv = 0;

        // for ($i = 0; $i < count($dsn); $i++) {
        //     if ($cv_moment[$i] != 'tidak') {
        //         $name = $_FILES['filecv']['name'][$urutan_cv];
        //         $extension = substr($name, strpos($name, '.'), strlen($name) - 1);

        //         $nama_file = 'cv_' . $nidn[$i] . '_' . date("Y-m-d") .  $extension;
        //         $tmp = $_FILES['filecv']['tmp_name'][$urutan_cv];

        //         $unggah = move_uploaded_file($tmp, $dir_cv . '/' . $nama_file);
        //         if ($unggah) {
        //             array_push($status_cv, true);
        //         }
        //         $urutan_cv++;
        //     }
        // }

        $stat_del = 0;
        // if (in_array(false, $status_cv)) {
        //     for ($i = 0; $i < count($dsn); $i++) {
        //         if ($cv_moment[$i] != 'tidak') {
        //             $name = $_FILES['filecv']['name'][$stat_del];
        //             $extension = substr($name, strpos($name, '.'), strlen($name) - 1);
        //             $nama_file = 'file_cv_' . $nidn[$stat_del] . $extension;
        //             $hapus = unlink($dir_cv . $nama_file);
        //             $stat_del++;
        //         }
        //     }

        //     echo json_encode(['message' => 'error check file']);
        //     return;
        // }

        $is_nambah_luaran = 0;
        if ($post['luaran_tambahan'] !== null) {
            $is_nambah_luaran = 1;
        }

        $luaran = [];
        if ($post['luaran'] !== "") {
            $target = explode(',', $post['luaran']);

            for ($i = 0; $i < count($target); $i++) {
                $luaran[$i] = [
                    'id_luaran' => $target[$i],
                    'status' => 1
                ];
            }
        }

        $updatekan = [
            'pengajuan' => [
                'id_list_event' => $id_list_event,
                'nidn_ketua' => $post['nidn_ketua'],
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            'det_pengajuan' => [
                'is_nambah_luaran' => $is_nambah_luaran,
                'id_fokus' => $post['fokus'],

            ],
            'identitas_pengajuan' => [
                'id_pengajuan_detail' => $post['id_pengajuan_detail'],
                'tema_penelitian' => $post['tema'],
                'sasaran' => $post['sasaran'],
                'judul' => $post['judul'],
                'id_kelompok_pengajuan' => $post['jnsproposal'],
                'tanggal_mulai_kgt' => $post['mulai'],
                'tanggal_akhir_kgt' => $post['akhir'],
                'biaya' => intval($post['biaya']),
                'tahun_usulan' => $post['tahun_usulan'],
                'identitas_tkt' => $post['identitas_tkt'],

            ],
            'dokumen_pengajuan' => [
                'id_pengajuan_detail' => $post['id_pengajuan_detail'],
                'ringkasan_pengajuan' => $post['ringkasan'],
                'metode' => $post['metode'],
                'tinjauan_pustaka' => $post['tinjauan'],
                // 'file_proposal' => $nm_proposal,
                // 'file_rab' => $nm_rab,
                'status' => 1
            ],
            'luaran_tambahan' => [
                'id_pengajuan_detail' => $post['id_pengajuan_detail'],
                'judul_luaran_tambahan' => $post['luaran_tambahan'],
                'status' => 1
            ],
            'dosen' => $dsn,
            'luaran' => $luaran,
        ];

        $update = $this->pnbp->edit_sungguhan_satu($updatekan, $post['id_pengajuan_detail']);
        if ($update) {
            $res = $this->response([1, 'Berhasil, Tunggu Persetujuan anggota !']);
            echo json_encode($res);
            return;
        }
    }

    public function store_pengajuan_edit_dua()
    {
        $id_event = $this->get_id_event();
        $tgl_now = date('Y-m-d H:i:s');

        if ($id_event === null) {
            echo json_encode(['message' => 'tidak ada event']);
            return;
        }

        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();
        $nama_filenya = $this->namabaru($data_nama->nama, $this->session->userdata('nidn'), "penelitian plp");

        $post = $this->input->post();
        $dsn = [];
        $tgl_now = date('Y-m-d');
        $id_list_event = $id_event->id_event;
        // $dir_cv = realpath(APPPATH . '../assets/berkas/file_cv/');

        $nidn = explode(',', $post['nidn']);
        $sinta = explode(',', $post['sinta']);
        // $cv_moment = explode(',', $post['status_cv']);



        // for ($i = 0; $i < count($nidn); $i++) {
        //     if ($cv_moment[$i] != 'tidak') {
        //         $sql = "select file_cv from tb_anggota_dosen where nidn=" . $nidn[$i];
        //         $query = $this->db->query($sql)->result();

        //         foreach ($query as $val) {
        //             if (file_exists(FCPATH . 'assets/berkas/file_cv/' . $val->file_cv)) {
        //                 $hapus = unlink(FCPATH . 'assets/berkas/file_cv/' . $val->file_cv);
        //             }
        //         }
        //     }
        // }

        // $ber_cv = 0;
        // $woi = [];
        // $file_cv = [];
        for ($i = 0; $i < count($nidn); $i++) {
            $name = '';
            $extension = '';
            // if ($cv_moment[$i] != 'tidak') {
            //     $name = $_FILES['filecv']['name'][$ber_cv];
            //     $extension = substr($name, strpos($name, '.'), strlen($name) - 1);
            //     $ber_cv++;
            // }

            $bro = [
                'nidn' => $nidn[$i],
                // 'id_sinta' => $sinta[$i],
                'status' => 1
            ];

            // if ($name !== '') {
            //     array_push($file_cv, 'cv_' . $nidn[$i] . '_' . date("Y-m-d") . $extension);
            // } else {
            //     if (isset($post['file_lama'])) {
            //         $coco = explode(',', $post['file_lama']);
            //         if (count($coco) > 1) {
            //             for ($c = 0; count($coco) > $c; $c++) {
            //                 $bro = explode('?', $coco[$c]);
            //                 if ($nidn[$i] === $bro[0]) {
            //                     $namanya = $bro[1];
            //                     array_push($file_cv, $namanya);
            //                 }
            //             }
            //         } else {
            //             $hehe = explode('?', $post['file_lama']);
            //             if ($nidn[$i] === $hehe[0]) {
            //                 $namanya = $hehe[1];
            //                 array_push($file_cv, $namanya);
            //             }
            //         }
            //     } else {
            //         array_push($file_cv, 'cv_' . $nidn[$i] . '_' . date("Y-m-d") . $extension);
            //     }
            // }
        }

        for ($i = 0; count($nidn) > $i; $i++) {
            $dsn[$i] = [
                'nidn' => $nidn[$i],
                // 'id_sinta' => $sinta[$i],
                // 'file_cv' => $file_cv[$i],
                'status' => 1
            ];
        }

        // $status_cv = [];
        // $urutan_cv = 0;

        // for ($i = 0; $i < count($dsn); $i++) {
        //     if ($cv_moment[$i] != 'tidak') {
        //         $name = $_FILES['filecv']['name'][$urutan_cv];
        //         $extension = substr($name, strpos($name, '.'), strlen($name) - 1);

        //         $nama_file = 'cv_' . $nidn[$i] . '_' . date("Y-m-d") .  $extension;
        //         $tmp = $_FILES['filecv']['tmp_name'][$urutan_cv];

        //         $unggah = move_uploaded_file($tmp, $dir_cv . '/' . $nama_file);
        //         if ($unggah) {
        //             array_push($status_cv, true);
        //         }
        //         $urutan_cv++;
        //     }
        // }

        // $stat_del = 0;
        // if (in_array(false, $status_cv)) {
        //     for ($i = 0; $i < count($dsn); $i++) {
        //         if ($cv_moment[$i] != 'tidak') {
        //             $name = $_FILES['filecv']['name'][$stat_del];
        //             $extension = substr($name, strpos($name, '.'), strlen($name) - 1);
        //             $nama_file = 'file_cv_' . $nidn[$stat_del] . $extension;
        //             $hapus = unlink($dir_cv . $nama_file);
        //             $stat_del++;
        //         }
        //     }

        //     echo json_encode(['message' => 'error check file']);
        //     return;
        // }


        $fix_judul = strtolower(preg_replace("/[\/\&%#\$]/", " ", $post['judul']));
        if (isset($_FILES['file_proposal']['name'])) {
            $dir_proposal = realpath(APPPATH . '../assets/berkas/file_proposal/');

            if (file_exists(FCPATH . 'assets/berkas/file_proposal/' . $post['proposal_lama'])) {
                unlink(FCPATH . 'assets/berkas/file_proposal/' . $post['proposal_lama']);
            }

            $name_proposal = $_FILES['file_proposal']['name'];
            $extension_proposal = substr($name_proposal, strpos($name_proposal, '.'), strlen($name_proposal) - 1);
            $nm_proposal = $nama_filenya  . $extension_proposal;
            $tmp_proposal = $_FILES['file_proposal']['tmp_name'];

            $up_proposal = move_uploaded_file($tmp_proposal, $dir_proposal . '/' . $nm_proposal);
            if (!$up_proposal) {
                echo json_encode(['message' => 'error check file']);
                return;
            }
        }

        if (isset($_FILES['file_rab']['name'])) {
            $dir_rab = realpath(APPPATH . '../assets/berkas/file_rab/');

            if (file_exists(FCPATH . 'assets/berkas/file_rab/' . $post['rab_lama'])) {
                unlink(FCPATH . 'assets/berkas/file_rab/' . $post['rab_lama']);
            }

            $name_rab = $_FILES['file_rab']['name'];
            $extension_rab = substr($name_rab, strpos($name_rab, '.'), strlen($name_rab) - 1);
            $nm_rab = $nama_filenya . $extension_rab;
            $tmp_rab = $_FILES['file_rab']['tmp_name'];

            $up_rab = move_uploaded_file($tmp_rab, $dir_rab . '/' . $nm_rab);
            if (!$up_rab) {
                echo json_encode(['message' => 'error check file']);
                return;
            }
        }

        $is_nambah_luaran = 0;
        if ($post['luaran_tambahan'] !== null) {
            $is_nambah_luaran = 1;
        }

        $luaran = [];
        if ($post['luaran'] !== "") {
            $target = explode(',', $post['luaran']);

            for ($i = 0; $i < count($target); $i++) {
                $luaran[$i] = [
                    'id_luaran' => $target[$i],
                    'status' => 1
                ];
            }
        }

        $updatekan = [
            'pengajuan' => [
                'id_list_event' => $id_list_event,
                'nidn_ketua' => $post['nidn_ketua'],
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            'det_pengajuan' => [
                'is_nambah_luaran' => $is_nambah_luaran,
                'id_fokus' => $post['fokus'],

            ],
            'identitas_pengajuan' => [
                'id_pengajuan_detail' => $post['id_pengajuan_detail'],
                'tema_penelitian' => $post['tema'],
                'sasaran' => $post['sasaran'],
                'judul' => $post['judul'],
                'id_kelompok_pengajuan' => $post['jnsproposal'],
                'tanggal_mulai_kgt' => $post['mulai'],
                'tanggal_akhir_kgt' => $post['akhir'],
                'biaya' => intval($post['biaya']),
                'tahun_usulan' => $post['tahun_usulan'],
                'identitas_tkt' => $post['identitas_tkt'],
            ],
            'dokumen_pengajuan' => [
                'id_pengajuan_detail' => $post['id_pengajuan_detail'],
                'ringkasan_pengajuan' => $post['ringkasan'],
                'metode' => $post['metode'],
                'tinjauan_pustaka' => $post['tinjauan'],
                'file_proposal' => isset($_FILES['file_proposal']['name']) ? $nm_proposal : $post['proposal_lama'],
                'file_rab' => isset($_FILES['file_rab']['name']) ? $nm_rab : $post['rab_lama'],
                'status' => 1
            ],
            'luaran_tambahan' => [
                'id_pengajuan_detail' => $post['id_pengajuan_detail'],
                'judul_luaran_tambahan' => $post['luaran_tambahan'],
                'status' => 1
            ],
            'dosen' => $dsn,
            'luaran' => $luaran
        ];

        $update = $this->pnbp->edit_sungguhan_dua($updatekan, $post['id_pengajuan_detail']);
        if ($update) {
            $res = $this->response([1, 'Berhasil Edit Pengajuan !']);
            echo json_encode($res);
            return;
        }
    }
}
