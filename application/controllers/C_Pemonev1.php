<?php

class C_Pemonev1 extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('login') == true) {
            redirect('');
        }

        $this->load->model('M_Pemonev1');
    }

    private function checkTahapanPemonev($id_jenis_event)
    {
        $sql = "select id_list_event id_event, waktu_mulai mulai, waktu_akhir selesai from tb_list_event where id_jenis_event = $id_jenis_event AND id_tahapan = 6 AND (curdate() between waktu_mulai AND waktu_akhir) AND status = 1";
        $data = $this->db->query($sql)->row();

        return $data;
    }

    public function point_penilaian($id_kerjaan, $event)
    {
        $sql_soal = "select id_soal, soal, tb_soal.id_jenis_soal from tb_soal inner join tb_jenis_soal a on a.id_jenis_soal = tb_soal.id_jenis_soal where tb_soal.status=" . 1 . " and a.id_event=" . $event;
        $exec_soal = $this->db->query($sql_soal)->result();
        $sql_jenis = "select id_jenis_soal, nm_jenis_soal, bobot from tb_jenis_soal where status=" . 1 . " and id_event=" . $event;
        $exec_jenis = $this->db->query($sql_jenis)->result();
        $kumpulan_soal = [];

        if (count($exec_soal) <= 0 || count($exec_jenis) <= 0) {
            return null;
        }

        for ($i = 0; $i <= count($exec_jenis) - 1; $i++) {
            $kumpulan_soal[$i]['jenis_soal'] = $exec_jenis[$i]->nm_jenis_soal;
            $kumpulan_soal[$i]['bobot'] = $exec_jenis[$i]->bobot;
            $sql_score = $this->M_Pemonev1->get_totalscore($id_kerjaan, $exec_jenis[$i]->id_jenis_soal, $event);
            if (empty($sql_score)) {
                return null;
            }
            $kumpulan_soal[$i]['total_score'] = $sql_score[0]->TotalScore;

            $h = 0;
            for ($j = 0; $j <= count($exec_soal) - 1; $j++) {
                if ($exec_soal[$j]->id_jenis_soal === $exec_jenis[$i]->id_jenis_soal) {
                    $sql_jawaban = "select id_pilihan from tb_penilaian where id_kerjaan =" . $id_kerjaan;
                    $exec_jawaban = $this->db->query($sql_jawaban)->result();
                    if (empty($exec_jawaban)) {
                        return null;
                    }
                    $kumpulan_soal[$i]['soal_pilihan'][$h]['nomer'] = intval($h + 1);
                    $kumpulan_soal[$i]['soal_pilihan'][$h]['soal'] = $exec_soal[$j]->soal;



                    $kumpulan_soal[$i]['soal_pilihan'][$h]['jawaban'] = $exec_jawaban[$j]->id_pilihan;

                    $sql_pilihan = "select id_pilihan, deskripsi_pilihan, prosentase, score from tb_pilihan where id_soal =" . $exec_soal[$j]->id_soal;
                    $exec_pilihan = $this->db->query($sql_pilihan)->result();
                    $kumpulan_soal[$i]['soal_pilihan'][$h]['pilihan'] = $exec_pilihan;

                    $h++;
                }
            }
        }
        return $kumpulan_soal;

        // print "<pre>";
        // print_r($kumpulan_soal);
        // print "</pre>";    
    }

    public function index()
    {
        $username = $this->session->userdata('username');

        $data['content'] = VIEW_ADMIN . 'V_Pemonev';
        $data['username'] = $username;
        $data['judul'] = 'Dosen Pemonev';
        $data['brdcrmb'] = 'Beranda / Reviewer / Dosen Pemonev';
        $data['Pemonev'] = $this->M_Pemonev1->getAllPemonev()->result();

        $this->load->view('index', $data);
        
    }

    public function list(){
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'V_ListPemonev';
        $data['username'] = $username;
        $data['judul'] = 'Pemonev';
        $data['brdcrmb'] = 'Beranda / Pemonev';
        $data['proposal'] = 0;
        $data['list_event'] = $this->M_Pemonev1->getListEvent();
        $data['dosen'] = $this->M_Pemonev1->get_all('dummy_dosen');

        $this->load->view('index', $data);
    }

    public function get_pemonev_prop($id)
    {

        $ret_pemonev = $this->M_Pemonev1->get_pemonev_proposal($id);
        $ret_anggota = $this->M_Pemonev1->get_anggota_proposal($id);

        $arr = [];
        foreach ($ret_pemonev->result_array() as $key) {
            array_push($arr, $key['nidn']);
        }
        foreach ($ret_anggota->result_array() as $key) {
            array_push($arr, $key['nidn']);
        }
        return $arr;
        // print "<pre>";
        // print_r($arr);
        // print "</pre>";   
    }

    public function list_dosen_pemonev($tahun = null)
    {
        if ($tahun == null) {
            $tahun = date('Y');
        }
        $data = $this->M_Pemonev1->getDosenPemonev($tahun)->result();
        echo json_encode($data);

    }

    public function proposalPemonev($id)
    {
        $username = $this->session->userdata('username');
        
        $data['content'] = VIEW_ADMIN . 'V_DetailPemonev';
        $data['username'] = $username;
        $data['judul'] = 'Proposal yang Dimonev';
        $data['brdcrmb'] = 'Beranda / Pemonev / Dosen Pemonev';
        $data['propos'] = $this->M_Pemonev1->getProposalPemonev($id)->result();

        $this->load->view('index', $data);

    }

    public function get_modal()
    {

        $idnya = $this->input->post('idnya');
        if ($idnya == '') {
            $res = $this->response([0, 'id Kosong']);
            echo json_encode($res);
            return;
        } else {
            $data = $this->M_Pemonev1->get_where('tb_pengajuan_monev', ['id_pengajuan_monev' => $idnya])->row();
            echo json_encode($data);
            return;
        }
    }

    public function get_tahun_proposal()
    {
        $post = $this->input->post();
        $id = $this->input->post('id_list_event');
        // $tahun = $this->input->post('tahun');
        $tahun = date('Y');
        $skema = "ALL";
        $fokus = "ALL";
        // $skema = $this->input->post('skema');
        // $fokus = $this->input->post('fokus');

        if (isset($post['skema'])) {
            if ($post['skema'] != "") {
                $skema = $this->input->post('skema');
            }
        }
        if (isset($post['fokus'])) {
            if ($post['fokus'] != "") {
                $fokus = $this->input->post('fokus');
            }
        }

        if (isset($post['tahun'])) {
            if ($post['tahun'] != "") {
                $tahun = $post['tahun'];
            }
        }

        $output = '';
        $get = $this->M_Pemonev1->get_tahun_proposal($id, $tahun, $skema, $fokus);
        $no = 1;

        if ($get->num_rows() > 0) {
            foreach ($get->result() as $key) {
                // <td>' . substr(strip_tags(ucfirst(strtolower($key->judul))), 0, 60) . '...</td>

                $tgl_update = $key->updated_at == null ? "-" :  date('j F Y H:i:s', strtotime($key->updated_at));
                $tgl_unggah = $key->created_at == null ? "-" :  date('j F Y H:i:s', strtotime($key->created_at));
                $output .= '
                      <tr>
                        <td class="text-center">
                            <a href="' . base_url() . 'C_Pemonev1/tambahPemonev/' . $key->id_pengajuan_monev_detail . '" class="btn btn-sm btn-danger"> <i class="fa fa-paste"></i></a>
                        </td>
                        <td>' . $no . '.</td>
                        <td>' . $key->nama . '-' . $key->nidn . '</td>
                        <td>' . strip_tags(ucfirst(strtolower($key->judul))).'</td>
                        <td>' . $key->tahun_usulan . '</td>
                        <td>' . $key->nama_kelompok . '</td>
                        <td>' . $tgl_unggah . '</td>
                        <td>' . $tgl_update . '</td>
                      </tr>';
                $no++;
            }
        }else 
        {
            $output .= '
            <tr>
              <td colspan="8" style="text-align: center;">Belum Ada Data Proposal</td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            <td style="display:none;"></td>
            </tr>';
        }

        $data = [
            'datany' => $output,
            'code' => 1,
            'pesan' => 'berhasil'

        ];

        echo json_encode($data);
        return;
        
        if ($id == 2) {
            $dt = $this->reviewer->get_proposal_mandiri_byEvent();
            foreach ($dt as $key) {
                $tgl_update = $key->updated_at == null ? "-" :  date('j F Y H:i:s', strtotime($key->updated_at));
                $tgl_unggah = $key->created_at == null ? "-" :  date('j F Y H:i:s', strtotime($key->created_at));
                $output .= '
                      <tr>
                        <td class="text-center">
                            <a href="' . base_url() . 'C_nilai_mandiri/index/' . $key->id_detail . '" class="btn btn-sm btn-danger"> <i class="fa fa-paste"></i></a>
                        </td>
                        <td>' . $no . '.</td>
                        <td>' . $key->nama . '-' . $key->nidn . '</td>
                        <td>' . strip_tags(ucfirst(strtolower($key->judul))) . '</td>
                        <td>' . $key->tahun_usulan . '</td>
                        <td>' . $key->nama_kelompok . '</td>
                        <td>' . $tgl_unggah . '</td>
                        <td>' . $tgl_update  . '</td>

                      </tr>';

                $no++;
            }
        } elseif ($id == 5) {
            $dt = $this->reviewer->get_proposal_mandiri_byEvent(2);
            foreach ($dt as $key) {
                $tgl_update =  $key->updated_at == null ? "-" :  date('j F Y H:i:s', strtotime($key->updated_at));
                $tgl_unggah = $key->created_at == null ? "-" :  date('j F Y H:i:s', strtotime($key->created_at));
                $output .= '
                      <tr>
                        <td class="text-center">
                            <a href="' . base_url() . 'C_nilai_mandiri/index/' . $key->id_detail . '" class="btn btn-sm btn-danger"> <i class="fa fa-paste"></i></a>
                        </td>
                        <td>' . $no . '.</td>
                        <td>' . $key->nama . '-' . $key->nidn . '</td>
                        <td>' . strip_tags(ucfirst(strtolower($key->judul))) . '</td>
                        <td>' . $key->tahun_usulan . '</td>
                        <td>' . $key->nama_kelompok . '</td>
                        <td>' . $tgl_unggah . '</td>
                        <td>' . $tgl_update . '</td>

                      </tr>';
                $no++;
            }
        } else {
            $output .= '
                    <tr>
                      <td colspan="8" style="text-align: center;">Belum Ada Data Proposal</td>
                    <td style="display:none;"></td>
                    <td style="display:none;"></td>
                    <td style="display:none;"></td>
                    <td style="display:none;"></td>
                    <td style="display:none;"></td>
                    <td style="display:none;"></td>
                    <td style="display:none;"></td>
                    </tr>';
        }
        $data = [
            'datany' => $output,
            'code' => 1,
            'pesan' => 'berhasil'

        ];

        echo json_encode($data);
    }

    public function fokus_skema_list()
    {
        $id_event = $this->input->post('id_event');
        $skema = [];
        $fokus = $this->Mfokus->get_fokus($id_event);

        if ($id_event == 1) {
            $skema = $this->Mfokus->kel_luaran_penelitian_dosen("tb_kelompok_pengajuan")->result();
        } elseif ($id_event == 2) {
            $skema = $this->Mfokus->kel_luaran_pengabdian_dosen("tb_kelompok_pengajuan")->result();
        } else {
            $skema = $this->Mfokus->kel_luaran_penelitian_plp("tb_kelompok_pengajuan")->result();
        }

        echo json_encode(['fokus' => $fokus, 'skema' => $skema]);
    }

    public function get_anggota_dosen()
    {
        $input = $this->input->post();
        $id_proposal = $input['id_proposal'];

        $get = $this->M_Pemonev1->anggota_dosen_Byproposal($id_proposal);

        $output = '';

        if ($get->num_rows() > 0) {

            foreach ($get->result() as $key) {
                $file_cv = base_url("assets/berkas/file_cv/") . $key->cv;
                $output .= '
                      <tr>
                        <td class="text-center">' . $key->nidn . '</td>
                        <td class="text-center">' . $key->nama . '</td>
                        <td class="text-center"><a target="_blank" class="btn btn-sm btn-primary" href="' . $file_cv . '">Lihat CV</a></td>
                        <td class="text-center">';
                if ($key->status_permintaan == 1) {
                    $output .= '
                    <span class="badge badge-success">Menerima Permintaan</span>';
                } else {
                    $output .= '
                    <span class="badge badge-warning">Menunggu Konfirmasi</span>';
                }
                $output .= '
                                   </td>
                                  </tr>';
            }
        } else {
            $output .= '
                    <tr>
                      <td colspan="3" style="text-align: center;">Belum Ada Data Anggota Dosen</td>
                    </tr>';
        }
        $data = [
            'datany' => $output,
            'code' => 1,
            'pesan' => 'berhasil'

        ];

        echo json_encode($data);
    }

    public function get_anggota_mhs()
    {
        $input = $this->input->post();
        $id_proposal = $input['id_proposal'];

        $get = $this->M_Pemonev1->anggota_mhs_Byproposal($id_proposal);

        $output = '';

        if ($get->num_rows() > 0) {

            foreach ($get->result() as $key) {

                $output .= '
                    <tr>
                        <td class="text-center">' . $key->nim . '</td>
                        <td class="text-center">' . $key->nama . '</td>
                        <td class="text-center">' . $key->prodi . '</td>
                    </tr>';
            }
        } else {
            $output .= '
                    <tr>
                      <td colspan="3" style="text-align: center;">Belum Ada Data Anggota Mahasiswa</td>
                    </tr>';
        }
        $data = [
            'datany' => $output,
            'code' => 1,
            'pesan' => 'berhasil'

        ];

        echo json_encode($data);
    }

    public function hasil_kerjaan_pemonev($id, $event)
    {
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'V_KerjaanPemonev';
        $data['username'] = $username;
        $data['judul'] = 'Pemonev';
        $data['brdcrmb'] = 'Beranda / Pemonev / Hasil Monev';
        $data['idproposal'] = $id;
        $data['idevents'] = $event;
        $id_proposal = $this->M_Pemonev1->get_id_proposal($id);

        $data['dt_proposal'] = $this->M_Pemonev1->getListPropsoal($id_proposal->id_pengajuan_detail);

        if ($data['dt_proposal'] !== null) {
            $data['status'] = $this->M_Pemonev1->admin_status_kerjaan_pemonev($id);
            if ($data['status']->status == 1) {
                $penilaian = $this->M_Pemonev1->get_nilai($data['status']->id_kerjaan);
                $rekomendasi = $this->M_Pemonev1->get_rekomendasi($data['status']->id_kerjaan);

                if (count($penilaian) <= 0 && $rekomendasi === null) {
                    echo 'ada yang salah maaf';
                    return;
                } else {
                    $ceked = [];
                    $id_ceked = [];
                    for ($i = 0; $i <=  count($penilaian) - 1; $i++) {
                        array_push($ceked, $penilaian[$i]->id_pilihan);
                        array_push($id_ceked, $penilaian[$i]->id_penilaian);
                    }
                    // $data['rekomendasi'] =  $rekomendasi->rekomendasi;   
                    $data['masukan'] =  $rekomendasi->masukan_pemonev;
                    $data['id_penilaian'] = $id_ceked;
                    $data['pilihan'] = $ceked;
                }
            }

            if ($data['status'] === null) {
                echo 'Tidak Bisa';
                return;
            }
        } else {
            echo 'Tidak Bisa id tak ketemu';
            return;
        }

        $data['soalnya'] = $this->point_penilaian($id, $event);
        //echo json_encode($data['soalnya']); return;
        $data['rekom'] = $this->M_Pemonev1->get_where('rekomendasi_pemonev', ['id_kerjaan' => $id])->row();


        $this->load->view('index', $data);
    }

    public function hapusPemonev($id)
    {
        $ini = $this->M_Pemonev1->hapusPemonev($id);
        redirect('C_reviewer/tambahPemonev/' . $ini);
    }

    public function prosesTambahPemonev($id = '')
    {
        if ($id === '') {
            redirect('C_Pemonev1');
        }
        $now = date('Y-m-d H:i:s');
        $nidsn = $this->input->post('NIDSN');
        if ($this->M_Pemonev1->checkNIDSN($nidsn)->num_rows() == 0) {
            $data = [
                'nidn' => $nidsn,
                'status' => 1,
            ];

            $this->M_Pemonev1->insert('dummypemonev', $data);
            $last_id = $this->db->insert_id();
            $data2 = [
                'id_pemonev' => $last_id,
                'id_pengajuan_detail' => $id,
                'created_at' => $now,

            ];

            $this->M_Pemonev1->insert('tb_kerjaan_pemonev', $data2);
        } else {
            $id_pemonev = $this->M_Pemonev1->checkNIDSN($nidsn)->row();
            $data = [
                'id_pemonev' =>  $id_pemonev->id_pemonev,
                'id_pengajuan_detail' => $id,
                'created_at' => $now,
            ];

            $this->M_Pemonev1->insert('tb_kerjaan_pemonev', $data);
        }
        $this->insert_log($nidsn, $id);
        redirect('C_Pemonev1/tambahPemonev/' . $id);
        // $this->tambahReviewer($id);
    }

    private function insert_log($nidn, $id_proposal)
    {
        $dosen = $this->db->query("SELECT nama,nip FROM dummy_dosen where nidn = '$nidn'")->row();
        $kerjaan =  $this->db->query("SELECT judul,tahun_usulan FROM tb_identitas_pengajuan_monev WHERE id_pengajuan_monev_detail = $id_proposal")->row();
        $insert_data = [
            'id_staff' => $this->session->userdata('id'),
            'nama_staff' => $this->session->userdata('nama'),
            'role_staff' => $this->session->userdata('level'),
            'event_staff' => 'INSERT',
            'ket_aktivitas' => 'MENUNJUK ' . $dosen->nama . '(' . $dosen->nip . ') UNTUK MEMONEV PROPOSAL ' . strtoupper($kerjaan->judul) . '(' . $kerjaan->tahun_usulan . ')',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        // print_r($insert_data);
        $this->db->insert('tb_log', $insert_data);
    }

    public function tambahPemonev($id = '')
    {

        
        $detail = $this->M_Pemonev1->getListPropsoal($id);
        if ($detail === null || $id === '') {
            redirect('C_pemonev1');
        }

        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'V_TambahPemonev';
        $data['username'] = $username;
        $data['judul'] = 'Detail Proposal';
        $data['brdcrmb'] = 'Beranda / Detail Proposal';
        $data['review'] = $this->M_Pemonev1->getProposalID($id);
        $data['list_event'] = $this->M_Pemonev1->getListEvent();
        $data['reviewer'] = $this->M_Pemonev1->getPemonevByProposal_revisi($id);

        $id_event = $data['review']->row()->id_jenis_event;
        $data['dosen'] = $this->M_Pemonev1->get_MasterPemonev($id_event);
        $data['reviewer_diproposal'] = $this->get_pemonev_prop($id);
        $data['dt_proposal'] = $detail;
        $data['dtl_proposal'] = $this->M_Pemonev1->getListPropsoal($id);

        $data['luaran_checked'] = null;
        $data['rekap'] = false;
        $data['luaran_tambahan'] = null;
        $data['check_event_review'] = $this->checkTahapanPemonev($data['dtl_proposal']->id_jenis_event);

        $this->load->model("M_fokus", "fokus");

        if ($detail->id_event == 1) {
            $data['luaran'] = $this->fokus->kel_luaran_penelitian_dosen("tb_luaran")->result();
            $data['kelompok'] = $this->fokus->kel_luaran_penelitian_dosen("tb_kelompok_pengajuan")->result();
        } elseif ($detail->id_event == 2) {
            $data['luaran'] = $this->fokus->kel_luaran_pengabdian_dosen("tb_luaran")->result();
            $data['kelompok'] = $this->fokus->kel_luaran_pengabdian_dosen("tb_kelompok_pengajuan")->result();
        } else {
            $data['luaran'] = $this->fokus->kel_luaran_penelitian_plp("tb_luaran")->result();
            $data['kelompok'] = $this->fokus->kel_luaran_penelitian_plp("tb_kelompok_pengajuan")->result();
        }

        if (isset($data['dtl_proposal']->pengajuan_monev_detail)) {
            $arr = [];
            foreach ($this->M_Pemonev1->get_luaran_checked($data['dtl_proposal']->pengajuan_monev_detail) as $value) {
                array_push($arr, $value->id_luaran);
            }

            if ($data['dtl_proposal']->is_nambah_luaran === "1") {
                $data['luaran_tambahan'] = $this->M_Pemonev1->luaran_tambahan($data['dtl_proposal']->id_pengajuan_monev);
            }

            $data['luaran_checked'] = $arr;
        } else {
            echo 'Halaman Tidak Bisa Di Akses';
            return;
        }

        $this->load->view('index', $data);
    }
}