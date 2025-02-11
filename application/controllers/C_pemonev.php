<?php

class C_pemonev extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('login') == true) {
            redirect('');
        }

        $this->load->model('M_Pemonev', 'pemonev');
        $this->load->model('M_reviewer', 'reviewer');
        $this->load->model('M_fokus', 'Mfokus');
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
            'ket_aktivitas' => 'MENUNJUK ' . $dosen->nama . '(' . $dosen->nip . ') UNTUK MEMONEV PROPOSAL ' . strtoupper($kerjaan->judul) . '(' . $kerjaan->tahun_usulan . ')',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        // print_r($insert_data);
        $this->db->insert('tb_log', $insert_data);
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

            'Anda Telah Di pilih sebagai Pemonev Oleh Admin P3M. Silahkan lakukan review melalui tautan berikut  <b><a href="https://p3m.nikwaf.com/">Disini</a></b>'
        );
        if ($this->email->send()) {
            $res = $this->response([1, 'Email ' . $emailny . ' Berhasil Dikirim']);
            return $res;
        } else {
            $res = $this->response([0, 'Email ' . $emailny . ' Gagal Dikirim, cek kembali email !']);
            return $res;
        }
    }

    private function check_event_pemonev($id_jenis_event)
    {

        $sql = "select id_list_event id_event, waktu_mulai mulai, waktu_akhir selesai from tb_list_event where id_jenis_event = $id_jenis_event AND id_tahapan = 6 AND (curdate() between waktu_mulai AND waktu_akhir) AND status = 1";
        $data = $this->db->query($sql)->row();

        return $data;
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

    public function index()
    {
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'content_pemonev';
        $data['username'] = $username;
        $data['judul'] = 'Pemonev';
        $data['brdcrmb'] = 'Beranda / Monitoring';
        $data['proposal'] = 0;
        $data['list_event'] = $this->reviewer->get_list_event();
        $data['dosen'] = $this->reviewer->get_all('dummy_dosen');
        $this->load->view('index', $data);
    }

    public function insert_pemonev()
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

                $this->reviewer->insert('tb_pemonev', $data);
            }
        }

        echo json_encode($kirim_email);
    }

    public function tambahPemonev($id = '')
    {
        $detail = $this->reviewer->get_proposalnya($id);
        if ($detail === null || $id === '') {
            redirect('C_pemonev');
        }

        $username = $this->session->userdata('username');
        $data['content'] = VIEW_ADMIN . 'content_tambah_pemonev';
        $data['username'] = $username;
        $data['judul'] = 'Detail Proposal';
        $data['brdcrmb'] = 'Beranda / Detail Proposal';
        $data['review'] = $this->reviewer->get_proposal_byId($id);
        $data['list_event'] = $this->reviewer->get_list_event();
        $data['reviewer'] = $this->pemonev->getReviewerByProposal_revisi($id);
        $id_event = $data['review']->row()->id_jenis_event;

        $data['dosen'] = $this->pemonev->get_MasterPemonev($id_event);
        $data['reviewer_diproposal'] = $this->get_reviewer_prop($id);
        $data['dt_proposal'] = $detail;
        $data['dtl_proposal'] = $this->reviewer->get_proposalnya($id);

        $data['luaran_checked'] = null;
        $data['rekap'] = false;
        $data['luaran_tambahan'] = null;
        $data['check_event_review'] = $this->check_event_pemonev($data['dtl_proposal']->id_jenis_event);

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

        $this->load->view('index', $data);
        // var_dump($pemonev);
    }

    public function hasil_kerjaan_pemonev($id, $event)
    {
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['judul'] = 'Pemonev';
        $data['brdcrmb'] = 'Beranda / Pemonev / Hasil Pemonev';
        $data['idproposal'] = $id;
        $data['idevents'] = $event;
        $id_proposal = $this->pemonev->get_id_proposal($id);
        $kelompok_pengajuan = $this->pemonev->get_kelompok_pengajuan($id_proposal->id_pengajuan_detail);
        $data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
        $data['laporan_monev'] = $this->pemonev->get_laporanPemonev($id);
        $data['pemonev'] = $this->pemonev->get_nama_pemonev($id);

        $data['dt_proposal'] = $this->reviewer->get_proposalnya($id_proposal->id_pengajuan_detail);


        //echo json_encode($data['soalnya']); return;
        $data['rekom'] = $this->pemonev->get_where('masukan_pemonev', ['id_kerjaan_monev' => $id])->row();

        if ($kelompok_pengajuan->id_kelompok_pengajuan == "14") {
            $data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
            $data['content'] = VIEW_ADMIN . 'content_hasilkerjaan_monev_PKLN';
            $data['terbit'] = $data['dt_proposal']->tahun_usulan;
        } elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "12") {
            $data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
            $data['content'] = VIEW_ADMIN . 'content_hasilkerjaan_monev_PVUJ';
            $data['terbit'] = $data['dt_proposal']->tahun_usulan;
        } elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "10") {
            $data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
            $data['content'] = VIEW_ADMIN . 'content_hasilkerjaan_monev_PTM';
            $data['terbit'] = $data['dt_proposal']->tahun_usulan;
        } elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "11") {
            $data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
            $data['content'] = VIEW_ADMIN . 'content_hasilkerjaan_monev_KKS';
            $data['terbit'] = $data['dt_proposal']->tahun_usulan;
        } elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "2") {
            $data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
            $data['content'] = VIEW_ADMIN . 'content_hasilkerjaan_monev_PDP';
            $data['terbit'] = $data['dt_proposal']->tahun_usulan;
        } elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "13") {
            $data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
            $data['content'] = VIEW_ADMIN . 'content_hasilkerjaan_monev_PKK';
            $data['terbit'] = $data['dt_proposal']->tahun_usulan;
        } elseif ($kelompok_pengajuan->id_kelompok_pengajuan == "9") {
            $data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
            $data['content'] = VIEW_ADMIN . 'content_hasilkerjaan_monev_PLP';
            $data['terbit'] = $data['dt_proposal']->tahun_usulan;
        } else {
            $data['namakelompok'] = $kelompok_pengajuan->nama_kelompok;
            $data['content'] = VIEW_ADMIN . 'content_hasilkerjaan_monev';
            $data['terbit'] = $data['dt_proposal']->tahun_usulan;
        }

        // var_dump($pemonev);
        $this->load->view('index', $data);
    }

    public function hapusPemonev($id)
    {
        $ini = $this->pemonev->hapusPemonev($id);
        redirect('C_pemonev/tambahPemonev/' . $ini);
    }

    public function prosesTambahPemonev($id = '')
    {
        if ($id === '') {
            redirect('C_pemonev');
        }
        $now = date('Y-m-d H:i:s');
        $nidsn = $this->input->post('NIDSN');
        if ($this->pemonev->checkNIDSN($nidsn)->num_rows() == 0) {
            $data = [
                'nidn' => $nidsn,
                'status' => 1,
            ];

            $this->pemonev->insert('tb_pemonev', $data);
            $last_id = $this->db->insert_id();
            $data2 = [
                'id_pemonev' => $last_id,
                'id_pengajuan_detail' => $id,
                'created_at' => $now,

            ];

            $this->pemonev->insert('tb_kerjaan_pemonev', $data2);
        } else {
            $id_reviewer = $this->pemonev->checkNIDSN($nidsn)->row();
            $data = [
                'id_pemonev' =>  $id_reviewer->id_pemonev,
                'id_pengajuan_detail' => $id,
                'created_at' => $now,
            ];

            $this->reviewer->insert('tb_kerjaan_pemonev', $data);
        }
        $this->insert_log($nidsn, $id);
        redirect('C_pemonev/tambahPemonev/' . $id);
        // $this->tambahReviewer($id);
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
        $get = $this->pemonev->get_tahun_proposal($id, $tahun, $skema, $fokus);
        $no = 1;

        if ($get->num_rows() > 0) {
            foreach ($get->result() as $key) {
                // <td>' . substr(strip_tags(ucfirst(strtolower($key->judul))), 0, 60) . '...</td>

                $tgl_update = $key->updated_at == null ? "-" :  date('j F Y H:i:s', strtotime($key->updated_at));
                $tgl_unggah = $key->created_at == null ? "-" :  date('j F Y H:i:s', strtotime($key->created_at));
                $output .= '
                      <tr>
                        <td class="text-center">
                            <a href="' . base_url() . 'C_pemonev/tambahPemonev/' . $key->id_pengajuan_detail . '" class="btn btn-sm btn-danger"> <i class="fa fa-paste"></i></a>
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

    private function kerjaan_pemonev($id_jenis_event)
    {
        $get_id_review = $this->pemonev->get_where("tb_pemonev", ["nidn" => $this->session->userdata('nidn')])->row();
        if ($get_id_review == null) {
            return false;
        }
        $selesai = [0, 1];
        $data_kirim = [];

        foreach ($selesai as $sl) {
            $data = $this->pemonev->get_proposalByPemonev_revisi($get_id_review->id_pemonev, $sl, $id_jenis_event)->result();
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

    public function pemonev($nama_event)
    {
        if ($nama_event == null) {
            echo "TIDAK BOLEH NULL";
        }
        $event = ["Penelitian_dosen" => 1, "Pengabdian_dosen" => 2, "Penelitian_plp" => 5,];

        if (!isset($event[$nama_event])) {
            echo "event tidak ada";
            return;
        }

        $data['content'] = VIEW_REVIEWER . 'content_kerjaan_pemonev';
        $data['review'] = $this->kerjaan_pemonev($event[$nama_event]);
        // data reviewer taruh sini
        $data['nama_event'] = str_replace("_", " ", $nama_event);
        $data['brdcrmb'] = 'Beranda';
        // var_dump($data['review']);
        $this->load->view('index', $data);
    }
}
