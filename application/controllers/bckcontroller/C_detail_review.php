<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_detail_review extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_fokus', 'Mfokus');
        $this->load->model('M_reviewer', 'reviewer');

        if (!$this->session->userdata('login') == true) {
            redirect('');
        }
    }

    private function response($res)
    {

        $pesan = ['code' => $res[0], 'pesan' => $res[1]];

        return $pesan;
    }

    public function detail($id)
    {
        // content
        $get_id_review = $this->reviewer->get_where("tb_reviewer", ["nidn" => $this->session->userdata('nidn')])->row();
        if ($get_id_review == null) {
            return false;
        }
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_REVIEWER . 'content_detail';
        $data['username'] = $username;
        $data['judul'] = 'Detail Proposal';
        $data['brdcrmb'] = 'Beranda / Detail Proposal';

        $detail = $this->reviewer->get_proposalnya($id);
        if ($detail->id_event == 1) {
            $data['luaran'] = $this->Mfokus->kel_luaran_penelitian_dosen("tb_luaran")->result();
            $data['kelompok'] = $this->Mfokus->kel_luaran_penelitian_dosen("tb_kelompok_pengajuan")->result();
        } elseif ($detail->id_event == 2) {
            $data['luaran'] = $this->Mfokus->kel_luaran_pengabdian_dosen("tb_luaran")->result();
            $data['kelompok'] = $this->Mfokus->kel_luaran_pengabdian_dosen("tb_kelompok_pengajuan")->result();
        } else {
            $data['luaran'] = $this->Mfokus->kel_luaran_penelitian_plp("tb_luaran")->result();
            $data['kelompok'] = $this->Mfokus->kel_luaran_penelitian_plp("tb_kelompok_pengajuan")->result();
        }

        $data['dt_proposal'] = $this->reviewer->get_proposalnya($id);
        $data['luaran_checked'] = null;
        $data['luaran_tambahan'] = null;
        if (isset($data['dt_proposal']->id_pengajuan_detail)) {
            $data['status'] = $this->reviewer->status_kerjaan_revisi($get_id_review->id_reviewer, $data['dt_proposal']->id_pengajuan_detail);
            // var_dump($data['status']);
            // return;
            if ($data['status'] === null) {
                echo 'Halaman Kerjaan Tidak Bisa Di Ditemukan';
                return;
            }
            $arr = [];
            foreach ($this->reviewer->get_luaran_checked($data['dt_proposal']->id_pengajuan_detail) as $value) {
                array_push($arr, $value->id_luaran);
            }

            if ($data['dt_proposal']->is_nambah_luaran === "1") {
                $data['luaran_tambahan'] = $this->reviewer->luaran_tambahan($data['dt_proposal']->id_pengajuan_detail);
            }

            $data['luaran_checked'] = $arr;
        } else {
            echo 'Halaman Tidak Bisa Di Akses';
            return;
        }

        $this->load->view('index', $data);
    }




    public function test($event)
    {
        $sql_soal = "select id_soal, soal, tb_soal.id_jenis_soal from tb_soal inner join tb_jenis_soal a on a.id_jenis_soal = tb_soal.id_jenis_soal where tb_soal.status=" . 1 . " and a.id_event=" . $event;
        $exec_soal = $this->db->query($sql_soal)->result();
        $sql_jenis = "select id_jenis_soal, nm_jenis_soal from tb_jenis_soal where status=" . 1 . " and id_event=" . $event;
        $exec_jenis = $this->db->query($sql_jenis)->result();
        $kumpulan_soal = [];

        if (count($exec_soal) <= 0 || count($exec_jenis) <= 0) {
            return null;
        }

        for ($i = 0; $i <= count($exec_jenis) - 1; $i++) {
            $kumpulan_soal[$i]['jenis_soal'] = $exec_jenis[$i]->nm_jenis_soal;
            $h = 0;
            for ($j = 0; $j <= count($exec_soal) - 1; $j++) {
                if ($exec_soal[$j]->id_jenis_soal === $exec_jenis[$i]->id_jenis_soal) {
                    $kumpulan_soal[$i]['soal_pilihan'][$h]['nomer'] = intval($h + 1);
                    $kumpulan_soal[$i]['soal_pilihan'][$h]['soal'] = $exec_soal[$j]->soal;
                    $sql_pilihan = "select id_pilihan, deskripsi_pilihan,score from tb_pilihan where id_soal =" . $exec_soal[$j]->id_soal;
                    $exec_pilihan = $this->db->query($sql_pilihan)->result();
                    $kumpulan_soal[$i]['soal_pilihan'][$h]['pilihan'] = $exec_pilihan;
                    $h++;
                }
            }
        }

        return $kumpulan_soal;
    }
    public function review_proposal($id, $event)
    {
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_REVIEWER . 'content_review_proposal';
        $data['username'] = $username;
        $data['judul'] = 'Reviewer';
        $data['brdcrmb'] = 'Beranda / Reviewer / Review Proposal';
        $data['idproposal'] = $id;
        $id_proposal = $this->reviewer->get_id_proposal($id);
        if ($id_proposal === null) {
            echo 'ada yang salah nih.';
            return;
        }

        $get_id_review = $this->reviewer->get_where("tb_reviewer", ["nidn" => $this->session->userdata('nidn')])->row();
        if ($get_id_review == null) {
            return false;
        }
        $data['dt_proposal'] = $this->reviewer->get_proposalnya($id_proposal->id_pengajuan_detail);

        if ($data['dt_proposal'] !== null) {
            $data['status'] = $this->reviewer->status_kerjaan_revisi($get_id_review->id_reviewer, $data['dt_proposal']->id_pengajuan_detail);
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
            echo 'Tidak Bisa';
            return;
        }

        $data['soalnya'] = $this->test($event);

        $this->load->view('index', $data);
    }
    // akhircontroller
    public function simpan_review()
    {
        // $rekomendasi = $_POST['rekomendasi'];
        $masukan = $_POST['masukan'];
        $id_event = $this->input->post('id_eventny');
        // unset($_POST['rekomendasi']);
        if ($id_event == 1) {
            $hitung = $this->reviewer->get_soal()->num_rows();
            // print_r($hitung);
            // return;
        } else if ($id_event == 2) {
            $hitung = $this->reviewer->get_soal2('tb_soal')->num_rows();
            // print_r($hitung);
            // return;
        } else {
            $hitung = $this->reviewer->get_soal3('tb_soal')->num_rows();
        }

        $id_kerjaan = $_POST['id_kerjaan'];
        $cek_kerjaan = $this->reviewer->cek_kerjaan($id_kerjaan);

        if ($cek_kerjaan === null) {
            echo 'Tidak Bisa';
            return;
        } else {
            if ($cek_kerjaan->kerjaan_selesai == 1) {
                echo 'Tidak Bisa';
                return;
            }
        }

        $this->db->trans_start();
        for ($i = 0; $i <= $hitung - 1; $i++) {
            if ($this->input->post('jawaban' . $i) == '') {
                $res = $this->response([0, 'Error Pada inputan nomor ' . $hitung . ' kosong']);
                echo json_encode($res);
                return;
            }
            $jawab = $this->input->post('jawaban' . $i);

            $data = array(
                'id_pilihan' => $jawab,
                'id_kerjaan' => $id_kerjaan,
            );
            $data_rekomendasi = array(
                'id_kerjaan' => $id_kerjaan,
                // 'rekomendasi' => $rekomendasi,
                'masukan_reviewer' => $masukan

            );
            $this->db->set('created_at', 'NOW()', FALSE);
            $this->db->set('updated_at', 'NOW()', FALSE);

            $this->reviewer->insert('tb_penilaian', $data);
        }
        $this->reviewer->insert('rekomendasi_reviewer', $data_rekomendasi);
        $this->reviewer->update_status_kerjaan($id_kerjaan);
        $this->db->trans_complete();
        $res = $this->response([1, 'Berhasil Tambah ']);
        echo json_encode($res);

        $this->session->set_flashdata('success','Berhasil Simpan Review');
        redirect('C_dashboard');
        // return;
    }

    public function edit_penilaian()
    {
        // $rekomendasi = $_POST['rekomendasi'];
        $masukan = $_POST['masukan'];

        // unset($_POST['rekomendasi']);
        $id_kerjaan = $_POST['id_kerjaan'];
        $cek_kerjaan = $this->reviewer->cek_kerjaan($id_kerjaan);

        if ($cek_kerjaan === null) {
            echo 'Tidak Bisa';
            return;
        } else {
            if ($cek_kerjaan->kerjaan_selesai != 1) {
                echo 'gabisa woi, becanda kamu';
                return;
            }
        }

        $nilai = $this->reviewer->get_nilai($id_kerjaan);

        //get pilihan by id_kerjaan

        for ($i = 0; $i < count($nilai); $i++) {
            if ($_POST['jawaban-' . $nilai[$i]->id_penilaian] != $nilai[$i]->id_pilihan) {
                $data = ['id_penilaian' => $nilai[$i]->id_penilaian, 'id_pilihan' => $_POST['jawaban-' . $nilai[$i]->id_penilaian]];
                $this->reviewer->update_nilai($data);
                $this->reviewer->update_status_kerjaan($id_kerjaan);
            }
        }

        $dt_masukan = ['id_kerjaan' => $id_kerjaan, 'masukan' => $_POST['masukan']];
        $this->reviewer->update_masukan($dt_masukan);
        
        $this->session->set_flashdata('success','Berhasil Edit Review');
        redirect('C_dashboard');
        // print_r($_POST['jawaban-1']);
    }

    public function test_penilaian()
    {
        $username = $this->session->userdata('username');
        $data['content'] = VIEW_REVIEWER . 'content_review_proposal';
        $data['username'] = $username;
        $data['judul'] = 'Reviewer';
        $data['brdcrmb'] = 'Beranda / Reviewer / Review Proposal';
        $data['idproposal'] = $id;

        $this->load->view('index', $data);
    }
}
