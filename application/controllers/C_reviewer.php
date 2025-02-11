<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_reviewer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('M_reviewer', 'reviewer');
        $this->load->model('M_fokus', 'Mfokus');
        $this->load->model('M_Pemonev', 'pemonev');

        if (!$this->session->userdata('login') == true) {
            redirect('');
        }
    }
    private function check_event_review($id_jenis_event)
    {

        $sql = "select id_list_event id_event, waktu_mulai mulai, waktu_akhir selesai from tb_list_event where id_jenis_event = $id_jenis_event AND id_tahapan = 3 AND (curdate() between waktu_mulai AND waktu_akhir) AND status = 1";
        $data = $this->db->query($sql)->row();

        return $data;
    }
    private function response($res)
    {

        $pesan = ['code' => $res[0], 'pesan' => $res[1]];

        return $pesan;
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
            $sql_score = $this->reviewer->get_totalscore($id_kerjaan, $exec_jenis[$i]->id_jenis_soal, $event);
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

    public function get_reviewer_prop($id)
    {

        $ret_reviewer = $this->reviewer->get_reviewer_proposal($id);
        $ret_anggota = $this->reviewer->get_anggota_proposal($id);

        $arr = [];
        foreach ($ret_reviewer->result_array() as $key) {
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

    private function send_email($emailny)
    {

        $this->load->library('email');

        $config['charset'] = 'utf-8';
        $config['useragent'] = 'P3M';
        $config['protocol'] = 'smtp';
        $config['mailtype'] = 'html';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_timeout'] = '5';
        $config['smtp_user'] = 'triplets.cv@gmail.com'; //email gmail
        $config['smtp_pass'] = 'polije123'; //isi passowrd email
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);


        $this->email->from('triplets.cv@gmail.com', "P3M POLIJE");
        $this->email->to($emailny);
        $this->email->subject('P3M POLIJE');
        $this->email->message(

            'Anda Telah Di pilih sebagai Reviewer Oleh Admin P3M. Silahkan lakukan review melalui tautan berikut  <b><a href="https://p3m.nikwaf.com/">Disini</a></b>'
        );
        if ($this->email->send()) {
            $res = $this->response([1, 'Email ' . $emailny . ' Berhasil Dikirim']);
            return $res;
        } else {
            $res = $this->response([0, 'Email ' . $emailny . ' Gagal Dikirim, cek kembali email !']);
            return $res;
        }
    }

    function test()
    {
        // $a = $this->reviewer->get_proposal_byEvent(2)->result();
        // echo '<pre>'.var_dump($a).'</pre>';

        $a = $this->reviewer->get_reviewer_byproposal($this->uri->segment(3));

        echo var_dump($a);
    }

    public function get_list_event()
    {
        $id = $this->input->post('id_list_event');
        $output = '';
        $get = $this->reviewer->get_proposal_byEvent($id);

        if ($get->num_rows() > 0) {
            foreach ($get->result() as $key) {
                $output .= '
                      <tr>
                        <td>' . strip_tags(ucfirst(strtolower($key->judul))) . '</td>
                        <td>' . $key->tahun_usulan . '</td>
                        <td>' . $key->nama . '-' . $key->nidn . '</td>

                        <td>
                          <a href="' . base_url() . 'C_reviewer/tambahReviewer/' . $key->id_pengajuan_detail . '" class="btn btn-sm btn-danger"> <i class="fa fa-paste"></i></a>
                        </td>
                      </tr>';
            }
        } elseif ($id == 3) {
            $dt = $this->reviewer->get_proposal_mandiri_byEvent();
            foreach ($dt as $key) {
                $output .= '
                      <tr>
                        <td>' . strip_tags(ucfirst(strtolower($key->judul))) . '</td>
                        <td>' . $key->tahun . '</td>
                        <td>' . $key->nama . '-' . $key->nip . '</td>

                        <td>
                          <a href="' . base_url() . 'C_nilai_mandiri/index/' . $key->id_detail . '" class="btn btn-sm btn-danger"> <i class="fa fa-paste"></i></a>
                        </td>
                      </tr>';
            }
        } elseif ($id == 4) {
            $dt = $this->reviewer->get_proposal_mandiri_byEvent(2);
            foreach ($dt as $key) {
                $output .= '
                      <tr>
                        <td>' . strip_tags(ucfirst(strtolower($key->judul))) . '</td>
                        <td>' . $key->tahun . '</td>
                        <td>' . $key->nama . '-' . $key->nip . '</td>

                        <td>
                          <a href="' . base_url() . 'C_nilai_mandiri/index/' . $key->id_detail . '" class="btn btn-sm btn-danger"> <i class="fa fa-paste"></i></a>
                        </td>
                      </tr>';
            }
        } else {
            $output .= '
                    <tr>
                      <td colspan="5" style="text-align: center;">Belum Ada Data Proposal</td>
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
        $get = $this->reviewer->get_tahun_proposal($id, $tahun, $skema, $fokus);
        $no = 1;

        if ($get->num_rows() > 0) {
            foreach ($get->result() as $key) {
                // <td>' . substr(strip_tags(ucfirst(strtolower($key->judul))), 0, 60) . '...</td>

                $tgl_update = $key->updated_at == null ? "-" :  date('j F Y H:i:s', strtotime($key->updated_at));
                $tgl_unggah = $key->created_at == null ? "-" :  date('j F Y H:i:s', strtotime($key->created_at));
                $output .= '
                      <tr>
                        <td class="text-center">
                            <a href="' . base_url() . 'C_reviewer/tambahReviewer/' . $key->id_pengajuan_detail . '" class="btn btn-sm btn-danger"> <i class="fa fa-paste"></i></a>
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



    public function rvwMandiri1()
    {
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'content_review_mandiri';
        $data['username'] = $username;
        $data['judul'] = 'Review';
        $data['brdcrmb'] = 'Beranda / Review / Pengajuan Mandiri';
        $data['jdl'] = 'Penanaman Benih Padi';
        $data['akhir'] = '2021-08-12';
        $data['tema'] = 'Pertanian';
        $data['biaya'] = '25.000.000';
        $data['sasaran'] = 'Petani';
        $data['mulai'] = '2021-01-12';
        $data['thn'] = '2020';
        $data['luaran_tambahan'] = null;
        $data['luaran'] = $this->reviewer->get_luaran();


        $this->load->view('index', $data);
    }

    public function rvwMandiri2()
    {
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'content_review_mandiri';
        $data['username'] = $username;
        $data['judul'] = 'Review';
        $data['brdcrmb'] = 'Beranda / Review / Pengajuan Mandiri';
        $data['jdl'] = 'Bussines Plan Warung kopi';
        $data['akhir'] = '2021-08-12';
        $data['tema'] = 'Akutansi';
        $data['biaya'] = '6.000.000';
        $data['sasaran'] = 'Pengusaha';
        $data['mulai'] = '2021-01-12';
        $data['thn'] = '2020';
        $data['luaran_tambahan'] = null;
        $data['luaran'] = $this->reviewer->get_luaran();


        $this->load->view('index', $data);
    }

    public function index()
    {
        // if ($this->session->userdata('level') == 1) {
        // content
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'content_reviewer';
        $data['username'] = $username;
        $data['judul'] = 'Reviewer';
        $data['brdcrmb'] = 'Beranda / Reviewer';
        $data['proposal'] = 0;
        $data['list_event'] = $this->reviewer->get_list_event();
        // $data['fokus'] = $this->Mfokus->get_all('tb_fokus');
        // $data['skema'] = $this->Mfokus->get_all('tb_kelompok_pengajuan');

        // $this->reviewer->get_proposal_pnbp('tb_pengajuan');
        $data['dosen'] = $this->reviewer->get_all('dummy_dosen');

        $this->load->view('index', $data);
        // } elseif ($this->session->userdata('level') == 4) {
        //     // content
        //     $username = $this->session->userdata('username');
        //     $data['content'] = VIEW_SUPERADMIN . 'content_reviewer';
        //     $data['username'] = $username;
        //     $data['judul'] = 'Reviewer';
        //     $data['brdcrmb'] = 'Beranda / Reviewer';
        //     $data['rvwr'] = $this->reviewer->countProposal();
        //     $data['dosen'] = $this->reviewer->get_all('dummy_dosen');

        //     $this->load->view('index', $data);
        // }
    }

    public function detailReviewer($id)
    {
        // content
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_SUPERADMIN . 'content_detail_reviewer';
        $data['username'] = $username;
        $data['judul'] = 'Reviewer';
        $data['brdcrmb'] = 'Beranda / Reviewer';
        $data['rvwr'] = $this->reviewer->countProposal();
        $data['proposal'] = $this->reviewer->get_proposal_byreviewer($id);
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
            $data = $this->reviewer->get_where('tb_pengajuan', ['id_pengajuan' => $idnya])->row();
            echo json_encode($data);
            return;
        }
    }
    public function insert_reviewer()
    {
        $now = date('Y-m-d H:i:s');
        $reviewer = $this->input->post('reviewer');
        $id_prop = $this->input->post('id_prop');

        if ($id_prop === '' || $reviewer === '') {
            $res = $this->response([0, 'Field Tidak Boleh Kosong']);
            echo json_encode($res);
            return;
        } else {
            for ($i = 0; $i < count($reviewer); $i++) {
                $reviewer_clean = $reviewer[$i];

                $get = $this->reviewer->get_where('dummy_dosen', ['NIDSN' => $reviewer_clean])->row();

                $kirim_email[$i] = $this->send_email($get->email);

                $data = [
                    'NIDSN' => $get->NIDSN,
                    'created_date' => $now,
                ];

                $this->reviewer->insert('tb_reviewer', $data);
            }
        }

        echo json_encode($kirim_email);
    }
    // akhircontroller

    public function tambahReviewer($id = '')
    {
        $detail = $this->reviewer->get_proposalnya($id);
        if ($detail === null || $id === '') {
            redirect('C_reviewer');
        }
        // content
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'content_tambah_reviewer';
        $data['username'] = $username;
        $data['judul'] = 'Detail Proposal';
        $data['brdcrmb'] = 'Beranda / Detail Proposal';
        $data['review'] = $this->reviewer->get_proposal_byId($id);
        $data['list_event'] = $this->reviewer->get_list_event();
        $data['reviewer'] = $this->reviewer->getReviewerByProposal_revisi($id);

        $id_event = $data['review']->row()->id_jenis_event;
        // $get_dosen = "select nidn,nama from dummy_dosen where jenis_job = 'dosen'";
        // $query = $this->db->query($get_dosen);
        // $data['dosen'] = $query;
        $data['dosen'] = $this->reviewer->get_MasterReviewer($id_event);
        $data['reviewer_diproposal'] = $this->get_reviewer_prop($id);
        $data['dt_proposal'] = $detail;
        $data['dtl_proposal'] = $this->reviewer->get_proposalnya($id);

        $data['luaran_checked'] = null;
        $data['rekap'] = false;
        $data['luaran_tambahan'] = null;
        $data['check_event_review'] = $this->check_event_review($data['dtl_proposal']->id_jenis_event);

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

        if (isset($data['dtl_proposal']->id_pengajuan_detail)) {
            $arr = [];
            foreach ($this->reviewer->get_luaran_checked($data['dtl_proposal']->id_pengajuan_detail) as $value) {
                array_push($arr, $value->id_luaran);
            }

            if ($data['dtl_proposal']->is_nambah_luaran === "1") {
                $data['luaran_tambahan'] = $this->reviewer->luaran_tambahan($data['dtl_proposal']->id_pengajuan);
            }

            $data['luaran_checked'] = $arr;
        } else {
            echo 'Halaman Tidak Bisa Di Akses';
            return;
        }

        // echo json_encode($data['luaran_checked']);
        // echo json_encode($data['luaran']);
        // return;

        $this->load->view('index', $data);

        // $this->load->view('index', $data);
    }
    public function prosesKeputusan()
    {
        /*
            status = 1 (Lolos Pendanaan)
            status = 2 (Tidak Lolos Pendanaan)
            status = 3 (Lanjut Ke Tahap Review)
            status = 4 (Tidak Lolos Administrasi)
        */
        $input = $this->input->post();
        $id = $input['id_proposal'];
        $status = $input['status'];
        if ($status === "lanjut_review" || $status === "tolak_administrasi") {
            $updatekan = [
                'status_keputusan' => $status === "lanjut_review" ? 3 : 4,
            ];
        } else {
            $updatekan = [
                'status_keputusan' => $status === "terima" ? 1 : 2,
            ];
        }

        $this->db->where('id_pengajuan_detail', $id);
        $this->db->update('tb_pengajuan_detail', $updatekan);

        $res = $this->response([1, 'Berhasil']);
        echo json_encode($res);
        return;
    }

    public function prosesTambahReviewer($id = '')
    {
        if ($id === '') {
            redirect('C_reviewer');
        }
        $now = date('Y-m-d H:i:s');
        $nidsn = $this->input->post('NIDSN');
        if ($this->reviewer->checkNIDSN($nidsn)->num_rows() == 0) {
            $data = [
                'nidn' => $nidsn,
                'status' => 1,
            ];

            $this->reviewer->insert('tb_reviewer', $data);
            $last_id = $this->db->insert_id();
            $data2 = [
                'id_reviewer' => $last_id,
                'id_pengajuan_detail' => $id,
                'created_at' => $now,

            ];

            $this->reviewer->insert('tb_kerjaan_reviewer', $data2);
        } else {
            $id_reviewer = $this->reviewer->checkNIDSN($nidsn)->row();
            $data = [
                'id_reviewer' =>  $id_reviewer->id_reviewer,
                'id_pengajuan_detail' => $id,
                'created_at' => $now,
            ];

            $this->reviewer->insert('tb_kerjaan_reviewer', $data);
        }
        $this->insert_log($nidsn, $id);
        redirect('C_reviewer/tambahReviewer/' . $id);
        // $this->tambahReviewer($id);
    }
    private function insert_log($nidn, $id_proposal)
    {
        $dosen = $this->db->query("SELECT nama,nip FROM dummy_dosen where nidn = '$nidn'")->row();
        $kerjaan =  $this->db->query("SELECT judul,tahun_usulan FROM tb_identitas_pengajuan WHERE id_pengajuan_detail = $id_proposal")->row();
        $insert_data = [
            'id_staff' => $this->session->userdata('id'),
            'nama_staff' => $this->session->userdata('nama'),
            'role_staff' => $this->session->userdata('level'),
            'event_staff' => 'INSERT',
            'ket_aktivitas' => 'MENUNJUK ' . $dosen->nama . '(' . $dosen->nip . ') UNTUK MEREVIEW PROPOSAL ' . strtoupper($kerjaan->judul) . '(' . $kerjaan->tahun_usulan . ')',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        // print_r($insert_data);
        $this->db->insert('tb_log', $insert_data);
    }
    public function total($id)
    {
        $tot = $this->reviewer->get_totalscore($id)->result();
        print "<pre>";
        print_r($tot);
        print "</pre>";
    }
    public function hasil_kerjaan_reviewer($id, $event)
    {
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'content_kerjaan_reviewer';
        $data['username'] = $username;
        $data['judul'] = 'Reviewer';
        $data['brdcrmb'] = 'Beranda / Reviewer / Hasil Review';
        $data['idproposal'] = $id;
        $data['idevents'] = $event;
        $id_proposal = $this->reviewer->get_id_proposal($id);

        $data['dt_proposal'] = $this->reviewer->get_proposalnya($id_proposal->id_pengajuan_detail);

        if ($data['dt_proposal'] !== null) {
            $data['status'] = $this->reviewer->admin_status_kerjaan_reviewer($id);
            if ($data['status']->status == 1) {
                $penilaian = $this->reviewer->get_nilai($data['status']->id_kerjaan);
                $rekomendasi = $this->reviewer->get_rekomendasi($data['status']->id_kerjaan);

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
                    $data['masukan'] =  $rekomendasi->masukan_reviewer;
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
        $data['rekom'] = $this->reviewer->get_where('rekomendasi_reviewer', ['id_kerjaan' => $id])->row();


        $this->load->view('index', $data);
    }

    public function hapusReviewer($id)
    {
        $ini = $this->reviewer->hapusReviewer($id);
        redirect('C_reviewer/tambahReviewer/' . $ini);
    }

    public function get_anggota_dosen()
    {
        $input = $this->input->post();
        $id_proposal = $input['id_proposal'];

        $get = $this->reviewer->anggota_dosen_Byproposal($id_proposal);

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

        $get = $this->reviewer->anggota_mhs_Byproposal($id_proposal);

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

    public function dsnReviewer()
    {
        // content
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'content_dosen_reviewer';
        $data['username'] = $username;
        $data['judul'] = 'Dosen Reviewer';
        $data['brdcrmb'] = 'Beranda / Reviewer / Dosen Reviewer';
        $data['rvwr'] = $this->reviewer->get_Reviewerdsn("2021")->result();

        $this->load->view('index', $data);
    }

    public function dsnPemonev()
    {
        // content
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'content_dosen_pemonev';
        $data['username'] = $username;
        $data['judul'] = 'Dosen Pemonev';
        $data['brdcrmb'] = 'Beranda / Reviewer / Dosen Pemonev';
        $data['rvwr'] = $this->pemonev->get_Pemonevdsn("2022")->result();
        // var_dump($data['rvwr']);
        $this->load->view('index', $data);
    }

    public function list_dosen_reviewer($tahun = null)
    {
        if ($tahun == null) {
            $tahun = date('Y');
        }

        $data = $this->reviewer->get_Reviewerdsn($tahun)->result();
        echo json_encode($data);
    }

    public function list_dosen_pemonev($tahun = null)
    {
        if ($tahun == null) {
            $tahun = date('Y');
        }

        $data = $this->pemonev->get_Pemonevdsn($tahun)->result();
        echo json_encode($data);
    }

    public function proposalReviewer($id)
    {
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'content_dosen_detailreviewer';
        $data['username'] = $username;
        $data['judul'] = 'Proposal yang Direview';
        $data['brdcrmb'] = 'Beranda / Reviewer / Dosen Reviewer';
        $data['propos'] = $this->reviewer->get_proposalRvw($id)->result();

        $this->load->view('index', $data);
    }

    public function proposalPemonev($id)
    {
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'content_dosen_detailpemonev';
        $data['username'] = $username;
        $data['judul'] = 'Proposal yang Dimonev';
        $data['brdcrmb'] = 'Beranda / Pemonev / Dosen Pemonev';
        $data['propos'] = $this->pemonev->get_proposalMnv($id)->result();

        $this->load->view('index', $data);
    }


    public function reviewer($nama_event){
        if($nama_event == null){
            echo "TIDAK BOLEH NULL";
        }
        $event = ["Penelitian_dosen" => 1, "Pengabdian_dosen" => 2, "Penelitian_plp" => 5, ] ;

        if(!isset($event[$nama_event])){
           echo "event tidak ada";
           return;
        }

        $data['content'] = VIEW_REVIEWER . 'content_kerjaan_reviewer';
        $data['review'] = $this->kerjaan_reviewer($event[$nama_event]);
        // data reviewer taruh sini
        $data['nama_event'] = str_replace("_"," ",$nama_event);
        $data['brdcrmb'] = 'Beranda';

    $this->load->view('index', $data);
    }
	private function kerjaan_reviewer($id_jenis_event)
	{
        $get_id_review = $this->reviewer->get_where("tb_reviewer",["nidn" => $this->session->userdata('nidn')])->row();
        if($get_id_review == null ){
            return false;
        }
		$selesai = [0, 1];
		$data_kirim = [];

		foreach ($selesai as $sl) {
			$data = $this->reviewer->get_proposalByReviewer_revisi($get_id_review->id_reviewer, $sl, $id_jenis_event)->result();
			if ($sl === 0) {
				if ($data !== null) {
					$data_kirim['belum'] = $data;
				} else {
					$data_kirim['belum'] = null;
				}
			}

			if ($sl === 1) {
				if ($data !== null) {
					$data_kirim['sudah'] = $data;
				} else {
					$data_kirim['sudah'] = null;
				}
			}
		}

		return $data_kirim;
	}
}
