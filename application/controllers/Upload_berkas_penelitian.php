<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Upload_berkas_penelitian extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('login') == true) {
            redirect('');
        }

        $this->load->model('M_pemonev', 'pemonev');
        $this->load->model('M_reviewer', 'reviewer');
        $this->load->model('M_fokus', 'Mfokus');
        $this->load->model('M_pengabdian', 'pengabdian');
    }

    private function namabaru_evaluasi($n, $p, $s)
    {
        $nama = trim($n);
        $nama_fix = str_replace(" ", "_", $nama);
        $nip = $p;
        $skema = trim($s);
        $skema_fix = "penelitian";
        $nama_file = $nama_fix . "_" . $nip . "_" . $skema_fix . "_" . $skema . "_" . time();
        return strtolower($nama_file);
    }

    private function response($res)
    {

        $pesan = ['code' => $res[0], 'pesan' => $res[1]];

        return $pesan;
    }
    
    public function tambah_deskripsi_kemajuan($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        
        $nidn = $dataprops->nidn_ketua;
        
        $deskripsi = $_POST['deskripsi_kemajuan'];

        $dataDeskripsi = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'd_laporan_kemajuan' => $deskripsi,
        );

        $masuk = $this->db->insert('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function edit_deskripsi_kemajuan($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['deskripsi_kemajuan'];

        $dataDeskripsi = array(
            'd_laporan_kemajuan' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function hapus_deskripsi_kemajuan($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();

        $url = $_POST['deskripsi_kemajuan'];

        $dataBerkas = array(
            'd_laporan_kemajuan' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function tambah_deskripsi_akhir($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['deskripsi_akhir'];

        $dataDeskripsi = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'd_laporan_akhir' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menambah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function edit_deskripsi_akhir($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['deskripsi_akhir'];

        $dataDeskripsi = array(
            'd_laporan_akhir' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function hapus_deskripsi_akhir($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();

        $url = $_POST['deskripsi_akhir'];

        $dataBerkas = array(
            'd_laporan_akhir' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function tambah_deskripsi_keuangan($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['deskripsi_keuangan'];

        $dataDeskripsi = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'd_laporan_keuangan' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menambah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function edit_deskripsi_keuangan($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['deskripsi_keuangan'];

        $dataDeskripsi = array(
            'd_laporan_keuangan' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function hapus_deskripsi_keuangan($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();

        $url = $_POST['deskripsi_keuangan'];

        $dataBerkas = array(
            'd_laporan_keuangan' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function tambah_d_w1($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_w1'];

        $dataDeskripsi = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'd_w1' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menambah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function edit_d_w1($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_w1'];

        $dataDeskripsi = array(
            'd_w1' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function hapus_d_w1($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();

        $url = $_POST['d_w1'];

        $dataBerkas = array(
            'd_w1' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function tambah_d_w2($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_w2'];

        $dataDeskripsi = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'd_w2' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menambah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function edit_d_w2($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_w2'];

        $dataDeskripsi = array(
            'd_w2' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function hapus_d_w2($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();

        $url = $_POST['d_w2'];

        $dataBerkas = array(
            'd_w2' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function tambah_d_w3($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_w3'];

        $dataDeskripsi = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'd_w3' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menambah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function edit_d_w3($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_w3'];

        $dataDeskripsi = array(
            'd_w3' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function hapus_d_w3($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();

        $url = $_POST['d_w3'];

        $dataBerkas = array(
            'd_w3' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function tambah_d_w4($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_w4'];

        $dataDeskripsi = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'd_w4' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menambah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function edit_d_w4($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_w4'];

        $dataDeskripsi = array(
            'd_w4' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function hapus_d_w4($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();

        $url = $_POST['d_w4'];

        $dataBerkas = array(
            'd_w4' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function tambah_d_w5($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_w5'];

        $dataDeskripsi = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'd_w5' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menambah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function edit_d_w5($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_w5'];

        $dataDeskripsi = array(
            'd_w5' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function hapus_d_w5($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();

        $url = $_POST['d_w5'];

        $dataBerkas = array(
            'd_w5' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function tambah_d_t1($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_t1'];

        $dataDeskripsi = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'd_t1' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menambah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function edit_d_t1($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_t1'];

        $dataDeskripsi = array(
            'd_t1' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function hapus_d_t1($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();

        $url = $_POST['d_t1'];

        $dataBerkas = array(
            'd_t1' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function tambah_d_t2($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_t2'];

        $dataDeskripsi = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'd_t2' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menambah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function edit_d_t2($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_t2'];

        $dataDeskripsi = array(
            'd_t2' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function hapus_d_t2($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();

        $url = $_POST['d_t2'];

        $dataBerkas = array(
            'd_t2' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function tambah_d_t3($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_t3'];

        $dataDeskripsi = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'd_t3' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menambah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function edit_d_t3($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_t3'];

        $dataDeskripsi = array(
            'd_t3' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function hapus_d_t3($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();

        $url = $_POST['d_t3'];

        $dataBerkas = array(
            'd_t3' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function tambah_d_t4($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_t4'];

        $dataDeskripsi = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'd_t4' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menambah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function edit_d_t4($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_t4'];

        $dataDeskripsi = array(
            'd_t4' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function hapus_d_t4($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();

        $url = $_POST['d_t4'];

        $dataBerkas = array(
            'd_t4' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function tambah_d_t5($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_t5'];

        $dataDeskripsi = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'd_t5' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menambah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function edit_d_t5($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_t5'];

        $dataDeskripsi = array(
            'd_t5' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function hapus_d_t5($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();

        $url = $_POST['d_t5'];

        $dataBerkas = array(
            'd_t5' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function tambah_d_t6($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_t6'];

        $dataDeskripsi = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'd_t6' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menambah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function edit_d_t6($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_t6'];

        $dataDeskripsi = array(
            'd_t6' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function hapus_d_t6($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();

        $url = $_POST['d_t6'];

        $dataBerkas = array(
            'd_t6' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function tambah_d_t7($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_t7'];

        $dataDeskripsi = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'd_t7' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menambah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function edit_d_t7($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_t7'];

        $dataDeskripsi = array(
            'd_t7' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function hapus_d_t7($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();

        $url = $_POST['d_t7'];

        $dataBerkas = array(
            'd_t7' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function tambah_d_t8($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_t8'];

        $dataDeskripsi = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'd_t8' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menambah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function edit_d_t8($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $deskripsiList = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();
        
        $deskripsi = $_POST['d_t8'];

        $dataDeskripsi = array(
            'd_t8' => $deskripsi,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataDeskripsi);
        
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah Deskripsi');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    
    public function hapus_d_t8($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataDeskripsi_evaluasi_pengabdian($id);

        $post = $this->input->post();

        $url = $_POST['d_t8'];

        $dataBerkas = array(
            'd_t8' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_deskripsi_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_berkas_laporan_kemajuan($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "file_laporan_kemajuan");
        $dir_laporan = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');
        $name_berkas = $_FILES['berkas_laporan_kemajuan']['name'];
        $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
        $nm_berkas = $nama_filenya . $extension_berkas;
        $tmp_berkas = $_FILES['berkas_laporan_kemajuan']['tmp_name'];

        $up_berkas = move_uploaded_file($tmp_berkas, $dir_laporan . '/' . $nm_berkas);
        if (!$up_berkas) {
            $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
        }

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'b_laporan_kemajuan' => $nm_berkas,
        );

        $insert = $this->pemonev->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function edit_berkas_laporan_kemajuan($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "file_laporan_kemajuan");

        if (isset($_FILES['berkas_laporan_kemajuan']['name'])) {
            $dir_berkas = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');

            if (file_exists(FCPATH . 'assets/berkas/file_laporan/' . $berkas->w_b1)) {
                unlink(FCPATH . 'assets/berkas/file_laporan/' . $berkas->w_b1);
            }

            $name_berkas = $_FILES['berkas_laporan_kemajuan']['name'];
            $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
            $nm_berkas = $nama_filenya . $extension_berkas;
            $tmp_berkas = $_FILES['berkas_laporan_kemajuan']['tmp_name'];

            $up_berkas = move_uploaded_file($tmp_berkas, $dir_berkas . '/' . $nm_berkas);
            if (!$up_berkas) {
                $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
            }
        }

        $dataBerkas = array(
            'b_laporan_kemajuan' => isset($_FILES['berkas_laporan_kemajuan']['name']) ? $nm_berkas : $berkas->w_b1,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_berkas_laporan_kemajuan_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['berkas_laporan_kemajuan_url'];

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'b_laporan_kemajuan' => $url,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    public function edit_berkas_laporan_kemajuan_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['berkas_laporan_kemajuan_url'];

        $dataBerkas = array(
            'b_laporan_kemajuan' => isset($_POST['berkas_laporan_kemajuan_url']) ? $url : $berkas->w_b1,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function hapus_berkas_laporan_kemajuan($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['berkas_laporan_kemajuan_url'];

        $dataBerkas = array(
            'b_laporan_kemajuan' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_berkas_laporan_akhir($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "file_laporan_akhir");
        $dir_laporan = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');
        $name_berkas = $_FILES['berkas_laporan_akhir']['name'];
        $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
        $nm_berkas = $nama_filenya . $extension_berkas;
        $tmp_berkas = $_FILES['berkas_laporan_akhir']['tmp_name'];

        $up_berkas = move_uploaded_file($tmp_berkas, $dir_laporan . '/' . $nm_berkas);
        if (!$up_berkas) {
            $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
        }

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'b_laporan_akhir' => $nm_berkas,
        );

        $insert = $this->pemonev->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function edit_berkas_laporan_akhir($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "file_laporan_akhir");

        if (isset($_FILES['berkas_laporan_akhir']['name'])) {
            $dir_berkas = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');

            if (file_exists(FCPATH . 'assets/berkas/file_laporan/' . $berkas->w_b1)) {
                unlink(FCPATH . 'assets/berkas/file_laporan/' . $berkas->w_b1);
            }

            $name_berkas = $_FILES['berkas_laporan_akhir']['name'];
            $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
            $nm_berkas = $nama_filenya . $extension_berkas;
            $tmp_berkas = $_FILES['berkas_laporan_akhir']['tmp_name'];

            $up_berkas = move_uploaded_file($tmp_berkas, $dir_berkas . '/' . $nm_berkas);
            if (!$up_berkas) {
                $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
            }
        }

        $dataBerkas = array(
            'b_laporan_akhir' => isset($_FILES['berkas_laporan_akhir']['name']) ? $nm_berkas : $berkas->w_b1,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    public function up_berkas_laporan_akhir_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['berkas_laporan_akhir_url'];

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'b_laporan_akhir' => $url,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    public function edit_berkas_laporan_akhir_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['berkas_laporan_akhir_url'];

        $dataBerkas = array(
            'b_laporan_akhir' => isset($_POST['berkas_laporan_akhir_url']) ? $url : $berkas->w_b1,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function hapus_berkas_laporan_akhir($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['berkas_laporan_akhir_url'];

        $dataBerkas = array(
            'b_laporan_akhir' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_berkas_laporan_keuangan($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "file_laporan_keuangan");
        $dir_laporan = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');
        $name_berkas = $_FILES['berkas_laporan_keuangan']['name'];
        $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
        $nm_berkas = $nama_filenya . $extension_berkas;
        $tmp_berkas = $_FILES['berkas_laporan_keuangan']['tmp_name'];

        $up_berkas = move_uploaded_file($tmp_berkas, $dir_laporan . '/' . $nm_berkas);
        if (!$up_berkas) {
            $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
        }

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'b_laporan_keuangan' => $nm_berkas,
        );

        $insert = $this->pemonev->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function edit_berkas_laporan_keuangan($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "file_laporan_keuangan");

        if (isset($_FILES['berkas_laporan_keuangan']['name'])) {
            $dir_berkas = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');

            if (file_exists(FCPATH . 'assets/berkas/file_laporan/' . $berkas->w_b1)) {
                unlink(FCPATH . 'assets/berkas/file_laporan/' . $berkas->w_b1);
            }

            $name_berkas = $_FILES['berkas_laporan_keuangan']['name'];
            $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
            $nm_berkas = $nama_filenya . $extension_berkas;
            $tmp_berkas = $_FILES['berkas_laporan_keuangan']['tmp_name'];

            $up_berkas = move_uploaded_file($tmp_berkas, $dir_berkas . '/' . $nm_berkas);
            if (!$up_berkas) {
                $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
            }
        }

        $dataBerkas = array(
            'b_laporan_keuangan' => isset($_FILES['berkas_laporan_keuangan']['name']) ? $nm_berkas : $berkas->w_b1,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_berkas_laporan_keuangan_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['berkas_laporan_keuangan_url'];

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'b_laporan_keuangan' => $url,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    public function edit_berkas_laporan_keuangan_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['berkas_laporan_keuangan_url'];

        $dataBerkas = array(
            'b_laporan_keuangan' => isset($_POST['berkas_laporan_keuangan_url']) ? $url : $berkas->w_b1,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function hapus_berkas_laporan_keuangan($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['berkas_laporan_keuangan_url'];

        $dataBerkas = array(
            'b_laporan_keuangan' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Menghapus File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_wb1($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_wajib_1");
        $dir_laporan = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');
        $name_berkas = $_FILES['wb1']['name'];
        $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
        $nm_berkas = $nama_filenya . $extension_berkas;
        $tmp_berkas = $_FILES['wb1']['tmp_name'];

        $up_berkas = move_uploaded_file($tmp_berkas, $dir_laporan . '/' . $nm_berkas);
        if (!$up_berkas) {
            $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
        }

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'w_b1' => $nm_berkas,
        );

        $insert = $this->pemonev->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function edit_wb1($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_wajib_1");

        if (isset($_FILES['wb1']['name'])) {
            $dir_berkas = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');

            if (file_exists(FCPATH . 'assets/berkas/file_laporan/' . $berkas->w_b1)) {
                unlink(FCPATH . 'assets/berkas/file_laporan/' . $berkas->w_b1);
            }

            $name_berkas = $_FILES['wb1']['name'];
            $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
            $nm_berkas = $nama_filenya . $extension_berkas;
            $tmp_berkas = $_FILES['wb1']['tmp_name'];

            $up_berkas = move_uploaded_file($tmp_berkas, $dir_berkas . '/' . $nm_berkas);
            if (!$up_berkas) {
                $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
            }
        }

        $dataBerkas = array(
            'w_b1' => isset($_FILES['wb1']['name']) ? $nm_berkas : $berkas->w_b1,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_wb1_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['wb1'];

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'w_b1' => $url,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    public function edit_wb1_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['wb1'];

        $dataBerkas = array(
            'w_b1' => isset($_POST['wb1']) ? $url : $berkas->w_b1,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function hapus_wb1($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['wb1'];

        $dataBerkas = array(
            'w_b1' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }


    public function up_wb2($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_wajib_2");
        $dir_laporan = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');
        $name_berkas = $_FILES['wb2']['name'];
        $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
        $nm_berkas = $nama_filenya . $extension_berkas;
        $tmp_berkas = $_FILES['wb2']['tmp_name'];

        $up_berkas = move_uploaded_file($tmp_berkas, $dir_laporan . '/' . $nm_berkas);
        if (!$up_berkas) {
            $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
        }

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'w_b2' => $nm_berkas,
        );

        $insert = $this->pemonev->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function edit_wb2($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_wajib_2");

        if (isset($_FILES['wb2']['name'])) {
            $dir_berkas = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');

            if (file_exists(FCPATH . 'assets/berkas/file_laporan/' . $berkas->w_b2)) {
                unlink(FCPATH . 'assets/berkas/file_laporan/' . $berkas->w_b2);
            }

            $name_berkas = $_FILES['wb2']['name'];
            $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
            $nm_berkas = $nama_filenya . $extension_berkas;
            $tmp_berkas = $_FILES['wb2']['tmp_name'];

            $up_berkas = move_uploaded_file($tmp_berkas, $dir_berkas . '/' . $nm_berkas);
            if (!$up_berkas) {
                $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
            }
        }

        $dataBerkas = array(
            'w_b2' => isset($_FILES['wb2']['name']) ? $nm_berkas : $berkas->w_b2,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_wb2_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['wb2'];

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'w_b2' => $url,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    public function edit_wb2_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['wb2'];

        $dataBerkas = array(
            'w_b2' => isset($_POST['wb2']) ? $url : $berkas->w_b2,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function hapus_wb2($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['wb2'];

        $dataBerkas = array(
            'w_b2' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_wb3($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_wajib_3");
        $dir_laporan = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');
        $name_berkas = $_FILES['wb3']['name'];
        $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
        $nm_berkas = $nama_filenya . $extension_berkas;
        $tmp_berkas = $_FILES['wb3']['tmp_name'];

        $up_berkas = move_uploaded_file($tmp_berkas, $dir_laporan . '/' . $nm_berkas);
        if (!$up_berkas) {
            $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
        }

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'w_b3' => $nm_berkas,
        );

        $insert = $this->pemonev->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function edit_wb3($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_wajib_3");

        if (isset($_FILES['wb3']['name'])) {
            $dir_berkas = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');

            if (file_exists(FCPATH . 'assets/berkas/file_laporan/' . $post['berkas_lama'])) {
                unlink(FCPATH . 'assets/berkas/file_laporan/' . $post['berkas_lama']);
            }

            $name_berkas = $_FILES['wb3']['name'];
            $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
            $nm_berkas = $nama_filenya . $extension_berkas;
            $tmp_berkas = $_FILES['wb3']['tmp_name'];

            $up_berkas = move_uploaded_file($tmp_berkas, $dir_berkas . '/' . $nm_berkas);
            if (!$up_berkas) {
                $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
            }
        }

        $dataBerkas = array(
            'w_b3' => isset($_FILES['wb3']['name']) ? $nm_berkas : $post['berkas_lama'],
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_wb3_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['wb3'];

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'w_b3' => $url,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    public function edit_wb3_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['wb3'];

        $dataBerkas = array(
            'w_b3' => isset($_POST['wb3']) ? $url : $berkas->w_b3,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function hapus_wb3($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['wb3'];

        $dataBerkas = array(
            'w_b3' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_wb4($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_wajib_4");
        $dir_laporan = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');
        $name_berkas = $_FILES['wb4']['name'];
        $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
        $nm_berkas = $nama_filenya . $extension_berkas;
        $tmp_berkas = $_FILES['wb4']['tmp_name'];

        $up_berkas = move_uploaded_file($tmp_berkas, $dir_laporan . '/' . $nm_berkas);
        if (!$up_berkas) {
            $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
        }

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'w_b4' => $nm_berkas,
        );

        $insert = $this->pemonev->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function edit_wb4($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_wajib_4");

        if (isset($_FILES['wb4']['name'])) {
            $dir_berkas = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');

            if (file_exists(FCPATH . 'assets/berkas/file_laporan/' . $post['berkas_lama'])) {
                unlink(FCPATH . 'assets/berkas/file_laporan/' . $post['berkas_lama']);
            }

            $name_berkas = $_FILES['wb4']['name'];
            $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
            $nm_berkas = $nama_filenya . $extension_berkas;
            $tmp_berkas = $_FILES['wb4']['tmp_name'];

            $up_berkas = move_uploaded_file($tmp_berkas, $dir_berkas . '/' . $nm_berkas);
            if (!$up_berkas) {
                $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
            }
        }

        $dataBerkas = array(
            'w_b4' => isset($_FILES['wb4']['name']) ? $nm_berkas : $post['berkas_lama'],
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_wb4_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['wb4'];

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            'w_b4' => $url,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    public function edit_wb4_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['wb4'];

        $dataBerkas = array(
            'w_b4' => isset($_POST['wb4']) ? $url : $berkas->w_b4,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function hapus_wb4($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['wb4'];

        $dataBerkas = array(
            'w_b4' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_tb1($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_tambahan_1");
        $dir_laporan = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');
        $name_berkas = $_FILES['tb1']['name'];
        $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
        $nm_berkas = $nama_filenya . $extension_berkas;
        $tmp_berkas = $_FILES['tb1']['tmp_name'];

        $up_berkas = move_uploaded_file($tmp_berkas, $dir_laporan . '/' . $nm_berkas);
        if (!$up_berkas) {
            $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
        }

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            't_b1' => $nm_berkas,
        );

        $insert = $this->pemonev->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function edit_tb1($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_tambahan_1");

        if (isset($_FILES['tb1']['name'])) {
            $dir_berkas = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');

            if (file_exists(FCPATH . 'assets/berkas/file_laporan/' . $berkas->t_b1)) {
                unlink(FCPATH . 'assets/berkas/file_laporan/' . $berkas->t_b1);
            }

            $name_berkas = $_FILES['tb1']['name'];
            $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
            $nm_berkas = $nama_filenya . $extension_berkas;
            $tmp_berkas = $_FILES['tb1']['tmp_name'];

            $up_berkas = move_uploaded_file($tmp_berkas, $dir_berkas . '/' . $nm_berkas);
            if (!$up_berkas) {
                $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
            }
        }

        $dataBerkas = array(
            't_b1' => isset($_FILES['tb1']['name']) ? $nm_berkas : $berkas->t_b1,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_tb1_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb1'];

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            't_b1' => $url,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    public function edit_tb1_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb1'];

        $dataBerkas = array(
            't_b1' => isset($_POST['tb1']) ? $url : $berkas->t_b1,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function hapus_tb1($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb1'];

        $dataBerkas = array(
            't_b1' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_tb2($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_tambahan_2");
        $dir_laporan = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');
        $name_berkas = $_FILES['tb2']['name'];
        $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
        $nm_berkas = $nama_filenya . $extension_berkas;
        $tmp_berkas = $_FILES['tb2']['tmp_name'];

        $up_berkas = move_uploaded_file($tmp_berkas, $dir_laporan . '/' . $nm_berkas);
        if (!$up_berkas) {
            $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
        }

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            't_b2' => $nm_berkas,
        );

        $insert = $this->pemonev->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function edit_tb2($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_tambahan_2");

        if (isset($_FILES['tb2']['name'])) {
            $dir_berkas = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');

            if (file_exists(FCPATH . 'assets/berkas/file_laporan/' . $berkas->t_b2)) {
                unlink(FCPATH . 'assets/berkas/file_laporan/' . $berkas->t_b2);
            }

            $name_berkas = $_FILES['tb2']['name'];
            $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
            $nm_berkas = $nama_filenya . $extension_berkas;
            $tmp_berkas = $_FILES['tb2']['tmp_name'];

            $up_berkas = move_uploaded_file($tmp_berkas, $dir_berkas . '/' . $nm_berkas);
            if (!$up_berkas) {
                $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
            }
        }

        $dataBerkas = array(
            't_b2' => isset($_FILES['tb2']['name']) ? $nm_berkas : $berkas->t_b2,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_tb2_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb2'];

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            't_b2' => $url,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    public function edit_tb2_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb2'];

        $dataBerkas = array(
            't_b2' => isset($_POST['tb2']) ? $url : $berkas->t_b2,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function hapus_tb2($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb2'];

        $dataBerkas = array(
            't_b2' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_tb3($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_tambahan_3");
        $dir_laporan = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');
        $name_berkas = $_FILES['tb3']['name'];
        $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
        $nm_berkas = $nama_filenya . $extension_berkas;
        $tmp_berkas = $_FILES['tb3']['tmp_name'];

        $up_berkas = move_uploaded_file($tmp_berkas, $dir_laporan . '/' . $nm_berkas);
        if (!$up_berkas) {
            $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
        }

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            't_b3' => $nm_berkas,
        );

        $insert = $this->pemonev->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function edit_tb3($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_tambahan_3");

        if (isset($_FILES['tb3']['name'])) {
            $dir_berkas = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');

            if (file_exists(FCPATH . 'assets/berkas/file_laporan/' . $berkas->t_b3)) {
                unlink(FCPATH . 'assets/berkas/file_laporan/' . $berkas->t_b3);
            }

            $name_berkas = $_FILES['tb3']['name'];
            $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
            $nm_berkas = $nama_filenya . $extension_berkas;
            $tmp_berkas = $_FILES['tb3']['tmp_name'];

            $up_berkas = move_uploaded_file($tmp_berkas, $dir_berkas . '/' . $nm_berkas);
            if (!$up_berkas) {
                $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
            }
        }

        $dataBerkas = array(
            't_b3' => isset($_FILES['tb3']['name']) ? $nm_berkas : $berkas->t_b3,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_tb3_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb3'];

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            't_b3' => $url,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    public function edit_tb3_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb3'];

        $dataBerkas = array(
            't_b3' => isset($_POST['tb3']) ? $url : $berkas->t_b3,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function hapus_tb3($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb3'];

        $dataBerkas = array(
            't_b3' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_tb4($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_tambahan_4");
        $dir_laporan = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');
        $name_berkas = $_FILES['tb4']['name'];
        $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
        $nm_berkas = $nama_filenya . $extension_berkas;
        $tmp_berkas = $_FILES['tb4']['tmp_name'];

        $up_berkas = move_uploaded_file($tmp_berkas, $dir_laporan . '/' . $nm_berkas);
        if (!$up_berkas) {
            $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
        }

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            't_b4' => $nm_berkas,
        );

        $insert = $this->pemonev->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function edit_tb4($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_tambahan_4");

        if (isset($_FILES['tb4']['name'])) {
            $dir_berkas = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');

            if (file_exists(FCPATH . 'assets/berkas/file_laporan/' . $berkas->t_b4)) {
                unlink(FCPATH . 'assets/berkas/file_laporan/' . $berkas->t_b4);
            }

            $name_berkas = $_FILES['tb4']['name'];
            $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
            $nm_berkas = $nama_filenya . $extension_berkas;
            $tmp_berkas = $_FILES['tb4']['tmp_name'];

            $up_berkas = move_uploaded_file($tmp_berkas, $dir_berkas . '/' . $nm_berkas);
            if (!$up_berkas) {
                $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
            }
        }

        $dataBerkas = array(
            't_b4' => isset($_FILES['tb4']['name']) ? $nm_berkas : $berkas->t_b4,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_tb4_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb4'];

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            't_b4' => $url,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    public function edit_tb4_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb4'];

        $dataBerkas = array(
            't_b4' => isset($_POST['tb4']) ? $url : $berkas->t_b4,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function hapus_tb4($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb4'];

        $dataBerkas = array(
            't_b4' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_tb5($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_tambahan_5");
        $dir_laporan = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');
        $name_berkas = $_FILES['tb5']['name'];
        $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
        $nm_berkas = $nama_filenya . $extension_berkas;
        $tmp_berkas = $_FILES['tb5']['tmp_name'];

        $up_berkas = move_uploaded_file($tmp_berkas, $dir_laporan . '/' . $nm_berkas);
        if (!$up_berkas) {
            $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
        }

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            't_b5' => $nm_berkas,
        );

        $insert = $this->pemonev->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function edit_tb5($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_tambahan_5");

        if (isset($_FILES['tb5']['name'])) {
            $dir_berkas = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');

            if (file_exists(FCPATH . 'assets/berkas/file_laporan/' . $berkas->t_b5)) {
                unlink(FCPATH . 'assets/berkas/file_laporan/' . $berkas->t_b5);
            }

            $name_berkas = $_FILES['tb5']['name'];
            $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
            $nm_berkas = $nama_filenya . $extension_berkas;
            $tmp_berkas = $_FILES['tb5']['tmp_name'];

            $up_berkas = move_uploaded_file($tmp_berkas, $dir_berkas . '/' . $nm_berkas);
            if (!$up_berkas) {
                $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
            }
        }

        $dataBerkas = array(
            't_b5' => isset($_FILES['tb5']['name']) ? $nm_berkas : $berkas->t_b5,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_tb5_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb5'];

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            't_b5' => $url,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    public function edit_tb5_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb5'];

        $dataBerkas = array(
            't_b5' => isset($_POST['tb5']) ? $url : $berkas->t_b5,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function hapus_tb5($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb5'];

        $dataBerkas = array(
            't_b5' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_tb6($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_tambahan_6");
        $dir_laporan = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');
        $name_berkas = $_FILES['tb6']['name'];
        $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
        $nm_berkas = $nama_filenya . $extension_berkas;
        $tmp_berkas = $_FILES['tb6']['tmp_name'];

        $up_berkas = move_uploaded_file($tmp_berkas, $dir_laporan . '/' . $nm_berkas);
        if (!$up_berkas) {
            $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
        }

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            't_b6' => $nm_berkas,
        );

        $insert = $this->pemonev->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function edit_tb6($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_tambahan_6");

        if (isset($_FILES['tb6']['name'])) {
            $dir_berkas = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');

            if (file_exists(FCPATH . 'assets/berkas/file_laporan/' . $berkas->t_b6)) {
                unlink(FCPATH . 'assets/berkas/file_laporan/' . $berkas->t_b6);
            }

            $name_berkas = $_FILES['tb6']['name'];
            $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
            $nm_berkas = $nama_filenya . $extension_berkas;
            $tmp_berkas = $_FILES['tb6']['tmp_name'];

            $up_berkas = move_uploaded_file($tmp_berkas, $dir_berkas . '/' . $nm_berkas);
            if (!$up_berkas) {
                $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
            }
        }

        $dataBerkas = array(
            't_b6' => isset($_FILES['tb6']['name']) ? $nm_berkas : $berkas->t_b6,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_tb6_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb6'];

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            't_b6' => $url,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    public function edit_tb6_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb6'];

        $dataBerkas = array(
            't_b6' => isset($_POST['tb6']) ? $url : $berkas->t_b6,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function hapus_tb6($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb6'];

        $dataBerkas = array(
            't_b6' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_tb7($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_tambahan_7");
        $dir_laporan = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');
        $name_berkas = $_FILES['tb7']['name'];
        $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
        $nm_berkas = $nama_filenya . $extension_berkas;
        $tmp_berkas = $_FILES['tb7']['tmp_name'];

        $up_berkas = move_uploaded_file($tmp_berkas, $dir_laporan . '/' . $nm_berkas);
        if (!$up_berkas) {
            $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
        }

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            't_b7' => $nm_berkas,
        );

        $insert = $this->pemonev->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function edit_tb7($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_tambahan_7");

        if (isset($_FILES['tb7']['name'])) {
            $dir_berkas = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');

            if (file_exists(FCPATH . 'assets/berkas/file_laporan/' . $berkas->t_b7)) {
                unlink(FCPATH . 'assets/berkas/file_laporan/' . $berkas->t_b7);
            }

            $name_berkas = $_FILES['tb7']['name'];
            $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
            $nm_berkas = $nama_filenya . $extension_berkas;
            $tmp_berkas = $_FILES['tb7']['tmp_name'];

            $up_berkas = move_uploaded_file($tmp_berkas, $dir_berkas . '/' . $nm_berkas);
            if (!$up_berkas) {
                $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
            }
        }

        $dataBerkas = array(
            't_b7' => isset($_FILES['tb7']['name']) ? $nm_berkas : $berkas->t_b7,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_tb7_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb7'];

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            't_b7' => $url,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    public function edit_tb7_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb7'];

        $dataBerkas = array(
            't_b7' => isset($_POST['tb7']) ? $url : $berkas->t_b7,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function hapus_tb7($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb7'];

        $dataBerkas = array(
            't_b7' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_tb8($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_tambahan_8");
        $dir_laporan = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');
        $name_berkas = $_FILES['tb8']['name'];
        $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
        $nm_berkas = $nama_filenya . $extension_berkas;
        $tmp_berkas = $_FILES['tb8']['tmp_name'];

        $up_berkas = move_uploaded_file($tmp_berkas, $dir_laporan . '/' . $nm_berkas);
        if (!$up_berkas) {
            $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
        }

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            't_b8' => $nm_berkas,
        );

        $insert = $this->pemonev->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Upload File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function edit_tb8($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $q_skema = "select b.nama_kelompok skema from tb_identitas_pengajuan a, tb_kelompok_pengajuan b  where a.id_kelompok_pengajuan = b.id_kelompok_pengajuan AND a.id_pengajuan_detail = " . $id;
        $q_nama = "select nama from dummy_dosen where nidn = '" . $this->session->userdata('nidn') . "'";
        $data_nama = $this->db->query($q_nama)->row();

        $nama_filenya = $this->namabaru_evaluasi($data_nama->nama, $this->session->userdata('nidn'), "luaran_tambahan_8");

        if (isset($_FILES['tb8']['name'])) {
            $dir_berkas = realpath(APPPATH . '../assets/berkas/file_laporan/penelitian/');

            if (file_exists(FCPATH . 'assets/berkas/file_laporan/' . $berkas->t_b8)) {
                unlink(FCPATH . 'assets/berkas/file_laporan/' . $berkas->t_b8);
            }

            $name_berkas = $_FILES['tb8']['name'];
            $extension_berkas = substr($name_berkas, strpos($name_berkas, '.'), strlen($name_berkas) - 1);
            $nm_berkas = $nama_filenya . $extension_berkas;
            $tmp_berkas = $_FILES['tb8']['tmp_name'];

            $up_berkas = move_uploaded_file($tmp_berkas, $dir_berkas . '/' . $nm_berkas);
            if (!$up_berkas) {
                $this->session->set_flashdata('error_access', 'Gagal Mengunggah File');
                redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
                Exit();
            }
        }

        $dataBerkas = array(
            't_b8' => isset($_FILES['tb8']['name']) ? $nm_berkas : $berkas->t_b8,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($up_berkas) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function up_tb8_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb8'];

        $dataBerkas = array(
            'nidn' => $nidn,
            'id_pengajuan_detail' => $id,
            't_b8' => $url,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $masuk = $this->db->insert('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($masuk) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
    public function edit_tb8_url($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb8'];

        $dataBerkas = array(
            't_b8' => isset($_POST['tb8']) ? $url : $berkas->t_b8,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }

    public function hapus_tb8($id)
    {
        $dataprops = $this->reviewer->get_proposalnya($id);
        $nidn = $dataprops->nidn_ketua;

        $berkas = $this->pemonev->dataBerkas_evaluasi_penelitian($id);

        $post = $this->input->post();

        $url = $_POST['tb8'];

        $dataBerkas = array(
            't_b8' => NULL,
        );

        $this->db->where('nidn', $nidn);
        $this->db->where('id_pengajuan_detail', $id);
        $update = $this->db->update('tb_berkas_evaluasi_penelitian', $dataBerkas);
        if ($update) {
            $res = $this->response([1, 'Berhasil Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('success', 'Berhasil Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        } else {
            $res = $this->response([1, 'Gagal Tambah ']);
            echo json_encode($res);

            $this->session->set_flashdata('failed', 'Gagal Mengubah File');
            redirect('C_penelitian_dsn_pnbp/halaman_pengajuan_evaluasi/' . $id);
            Exit();
        }
    }
}

?>