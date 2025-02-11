<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_master_data extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata("login")) {
            redirect('');
        }
        $this->load->model('M_pnbp', 'pnbp');
        $this->load->model('M_luaran', 'mLuaran');
        $this->load->model('M_hindex', 'hindex');
        $this->load->model('M_dosen', 'Mdosen');
        $this->load->model('M_fokus', 'Mfokus');
        $this->load->model('M_event', 'event');
        $this->load->model('M_reviewer', 'reviewer');
        $this->load->model('M_settings_user', 'setting');
        $this->load->library('form_validation');
    }

    private function response($res)
    {

        $pesan = ['code' => $res[0], 'pesan' => $res[1]];

        return json_encode($pesan);
    }
    private function insert_log($data)
    {
        $insert_data = [
            'id_staff' => $this->session->userdata('id'),
            'nama_staff' => $this->session->userdata('nama'),
            'role_staff' => $this->session->userdata('level'),
            'event_staff' => $data[0],
            'ket_aktivitas' => $data[1],
            'created_at' => date('Y-m-d H:i:s'),
        ];
        // print_r($insert_data);
        $this->db->insert('tb_log', $insert_data);
    }

    public function index()
    {
        $data['content'] = VIEW_ADMIN . 'content_master_data';
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['judul'] = 'Master Data User';
        $data['brdcrmb'] = 'Beranda / Master Data User';
        $data['dosen'] = $this->list_dosen();

        $this->load->view('index', $data);
    }

    private function list_prodi()
    {
        $data = $this->db->get("prodi")->result();
        return $data;
    }

    public function list_dosen()
    {
        $get_dosen = "select * from dummy_dosen";
        $dosen = $this->db->query($get_dosen)->result();
        return $dosen;
    }

    public function get_all_dosen()
    {
        $list = $this->Mdosen->get_all('dummy_dosen')->result();

        $result = '';
        for ($i = 0; $i <= count($list) - 1; $i++) {
            $nomer = $i + 1;
            $result .= '<tr>';
            $result .= '<td>' . $nomer . '</td>';
            $result .= '<td class="text-capitalize">' . $list[$i]->nidn . '</td>';
            $result .= '<td>' . $list[$i]->nama . '</td>';
            $result .= '<td class="text-uppercase">' . $list[$i]->jenis_job . '</td>';
            $result .= '<td class="text-uppercase">' . $list[$i]->jenis_unit . '</td>';
            $result .= '<td class="text-uppercase">' . $list[$i]->unit . '</td>';
            $result .= '<td class="text-center"><a href="' . base_url('C_master_data/detail_user/') . $list[$i]->nidn . '" id="' . $list[$i]->nidn . '" class="btn btn-xs btn-primary"><i class="fas fa-fw fa-eye"></i></a></td>';
            $result .= '</tr>';
        }

        echo $result;
    }

    public function detail_user($id = null)
    {
        if ($id === null) {
            redirect('C_master_data');
        }
        $data['content'] = VIEW_ADMIN . 'content_detail_user';
        $data['judul'] = 'Detail Data User';
        $data['brdcrmb'] = 'Beranda / Master Data / Detail User';
        $data['dosen'] = $this->setting->get_data($id)->row();
        $data['prodi'] = $this->list_prodi();
        if ($data['dosen'] === null) {
            echo "NIP dosen tidak ditemukan";
            return;
        }
        $data['hindex_ketua'] = $this->hindex->get_where("tb_hindex", array('nidsn_dosen' => $id))->result();
        $data['id'] = $id;
        //$data['histori'] = $this->Mdosen->get_history($id)->result();

        $this->load->view('index', $data);
    }
    public function update_profile()
    {
        $post = $this->input->post();
        $form_bagian = $post['form_bagian'];
        $nik = $post['nik'];
        $telepon = $post['telepon'];
        $pangkat = $post['pangkat'];
        $golongan = $post['golongan'];
        // $tanggal_masuk = $post['tanggal_masuk'];
        $gender = $post['gender'];
        $alamat = $post['alamat'];
        $sinta = $post['sinta'];
        $scopus = $post['scopus'];
        $email = $post['email'];
        $unit = $post['unit'];
        $nama = trim($post['nama']);
        $jenis_unit = $post['jenis_unit'];
        $bidang_penelitian = $post['bidang_penelitian'];
        $pendidikan_terakhir = $post['pendidikan_terakhir'];
        $hindex = floatval($post['hindex']);
        $hindex_scopus = floatval($post['hindex_scopus']);


        // $sinta = $post['sinta'];
        $nip = $post['nip'];
        $nidn = $post['nidn'];
        $redirect_admin = 'C_master_data/detail_user/';
        $redirect_dosen = 'C_settings_user/';
        $file_upload = "";

        if ($email !== '') {
            $woi = explode('@', $email);
            if ($woi[count($woi) - 1] !== 'polije.ac.id') {
                $this->session->set_flashdata('email-error', 'email harus @polije.ac.id :)');
                redirect(($form_bagian == NULL) ? $redirect_admin . $nip : $redirect_dosen);
            }

            $this->db->select('nip,file_cv');
            $this->db->where('nip !=', $nip);
            $this->db->where('email', $email);
            $cek = $this->db->get('dummy_dosen')->row();

            $cek_cv = $this->db->query("select file_cv from dummy_dosen where nip = '" . $this->session->userdata('nidn') . "'")->row();
            if ($cek !== null) {
                $this->session->set_flashdata('email-error', 'email sudah digunakan orang :)');
                redirect(($form_bagian == NULL) ? $redirect_admin . $nip : $redirect_dosen);
            }

            if ($_FILES['file_cv']['size'] == 0 && $_FILES['file_cv']['name'] == "") {
                if ($cek_cv != null) {
                    $file_upload = $cek_cv->file_cv;
                } else {
                    $file_upload = null;
                }
            } else {
                if ($cek_cv != null) {
                    if (file_exists(FCPATH . 'assets/berkas/file_cv/' . $cek_cv->file_cv)) {
                        unlink(FCPATH . 'assets/berkas/file_cv/' . $cek_cv->file_cv);
                    }
                }

                $file_upload = $this->upload();

                if ($file_upload == FALSE) {
                    $file_upload = null;
                }
            }
            $data = [
                'email' => $email,
                'nik' => $nik,
                'telepon' => $telepon,
                'pangkat' => $pangkat,
                'golongan' => $golongan,
                // 'tanggal_masuk' => $tanggal_masuk,
                'jenis_kelamin' => $gender,
                'alamat' => $alamat,
                'file_cv' => $file_upload,
                'unit' => $unit,
                'jenis_unit' => $jenis_unit,
                'sinta' => $sinta,
                'scopus' => $scopus,
                'nama' => $nama,
                'bidang' => $bidang_penelitian,
                'nidn_real' => $nidn,
                'pendidikan_terakhir' => $pendidikan_terakhir
            ];
            $this->db->trans_start();
            $av_hindex = $this->db->query("select id_hindex from tb_hindex where nidsn_dosen = '" . $this->session->userdata('nidn') . "'")->row();
            $nama = $this->db->query("select nama from dummy_dosen where nip = '" . $this->session->userdata('nidn') . "'")->row();
            if ($av_hindex != null) {
                $this->db->where('id_hindex', $av_hindex->id_hindex);
                $this->db->update('tb_hindex', ['h_index_scopus' => $hindex_scopus, 'h_index_schoolar' => $hindex]);
            } else {
                $this->db->insert('tb_hindex', ['nama_dosen' => $nama->nama, 'nidsn_dosen' => $this->session->userdata('nidn'), 'h_index_scopus' => $hindex_scopus, 'h_index_schoolar' => $hindex]);
            }
            $this->db->where('nip', $nip);
            $this->db->update('dummy_dosen', $data);
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('insert-status', 'error');
                $this->session->set_flashdata('insert-message', 'Tidak berhasil menyimpan data');
            } else {
                if($nama != ""){
                    $_SESSION['nama'] = trim($this->input->post('nama'));
                }
                $this->session->set_flashdata('insert-status', 'success');
                $this->session->set_flashdata('insert-message', 'Berhasil menyimpan data');
            }
            redirect(($form_bagian == NULL) ? $redirect_admin . $nip : $redirect_dosen);
        }

        redirect(site_url(($form_bagian == NULL) ? $redirect_admin . $nip : $redirect_dosen));
    }

    public function check_duplicate($nip = null, $nilai = null, $jenis = null)
    {
        if ($nip == null && $nilai == null && $jenis == null) {
            $get = $this->input->get();
            $nip = $get['nip'];
            $nilai = $get['nilai'];
            $jenis = $get['jenis'];
        }
        //nidn = nip
        //jenis = yang akan dicari duplicate nya . contol apa email,nip,atau
        $pilihan_jenis = ['nip' => 'nidn', 'email' => 'email', 'nidn' => 'nidn_real', 'nik' => 'nik', 'sinta' => 'sinta', 'scopus' => 'scopus', 'telepon' => 'telepon'];
        if (!array_key_exists($jenis, $pilihan_jenis)) {
            echo false;
            return false;
        }

        $data = $this->db->query("select 1 from dummy_dosen where " . $pilihan_jenis[$jenis] . " = '" . $nilai . "' AND nidn != '" . $nip . "'")->row();
        if ($data != null) {
            echo false;
            return false;
        }
        echo true;
        return true;
        //false berarti nip nya duplicate
    }

    private function check_editable_nip($nip)
    {
        $query =  "SELECT 1 FROM `tb_pengajuan` WHERE nidn_ketua='" . $nip . "' 
                    UNION 
                    SELECT 1 FROM `tb_anggota_dosen` WHERE nidn='" . $nip . "' 
                    UNION 
                    SELECT 1 FROM `anggota_dosen_mandiri` WHERE nip='" . $nip . "' 
                    UNION  
                    SELECT 1 FROM `pengajuan_mandiri` WHERE nip_ketua='" . $nip . "'";
        $data = $this->db->query($query)->row();
        if ($data != null) {
            //kalau ada nip di pengajuan,anggota
            return false;
        }

        return true;
    }

    public function update_profile_admin()
    {
        $redirect_admin = 'C_master_data/detail_user/';
        $post = $this->input->post();
        $nik = $post['nik'];
        $nip_old = $post['nip_old'];
        $email = $post['email'];
        $telepon = $post['telepon'];
        $alamat = $post['alamat'];
        $nip = $post['nip'];
        $nidn = $post['nidn'];
        $unit = $post['unit'];
        $pangkat = $post['pangkat'];
        $golongan = $post['golongan'];
        $sinta = $post['sinta'];
        $scopus = $post['scopus'];
        $nama = $post['nama'];
        $jenis_job = $post['jenis_job'];

        $check_email = $email != "" || $email != null ?  $this->check_duplicate($nip_old, $email, "email") : true;
        $check_nip = $nip != "" || $nip != null ?  $this->check_duplicate($nip_old, $nip, "nip") : true;

        if (!$check_nip) {
            $this->session->set_flashdata('insert-status', 'error');
            $this->session->set_flashdata('insert-message', 'Tidak berhasil menyimpan data');
            redirect(site_url($redirect_admin . $nip_old));
        }

        //ketika ingin mengubah nip di cek dlu apakah ada data pengajuan dengan nip tsb 
        if (trim($nip_old) != trim($nip)) {
            $editable_nip = $this->check_editable_nip($nip_old);

            if (!$editable_nip) {
                $this->session->set_flashdata('insert-status', 'error');
                $this->session->set_flashdata('insert-message', 'Tidak Bisa ngedit NIP, karena ada data pengajuan');
                redirect(site_url($redirect_admin . $nip_old));
            }
        }

        $update_data = array();
        unset($post['nip_old']);
        $input_keys = array_keys($post);

        $will_update = [];
        foreach ($input_keys as $key) {
            if ($post[$key] == null || $post[$key] == "") {
                continue;
            }

            if ($key != "nip" && $key != "nidn" && $key != "gender") {
                $will_update[$key] = $post[$key];
                continue;
            }
            //nip -> nidn , nip 
            //nidn -> nidn_real 
            //gender -> jenis_kelamin

            if ($key == "nip") {
                $will_update["nidn"] = $post[$key];
                $will_update["nip"] = $post[$key];
            }
            if ($key == "nidn") {
                $will_update["nidn_real"] = $post[$key];
            }
            if ($key == "gender") {
                $will_update["jenis_kelamin"] = $post[$key];
            }
        }

        $this->db->trans_start();
        $this->db->where("nidn", $nip_old);
        $this->db->update("dummy_dosen", $will_update);
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            $this->session->set_flashdata('insert-status', 'error');
            $this->session->set_flashdata('insert-message', 'Tidak berhasil menyimpan data');
            redirect(site_url($redirect_admin . $nip));
        }

        $this->session->set_flashdata('insert-status', 'success');
        $this->session->set_flashdata('insert-message', 'Berhasil menyimpan data');
        redirect(site_url($redirect_admin . $nip));

        // echo json_encode($will_update);
        // redirect($redirect_admin);

        // echo json_encode($input_keys[1]);
        // echo json_encode(array_keys($post));
        // echo $this->input->post('nip_old');
    }

    public function fokus()
    {
        $data['content'] = VIEW_ADMIN . 'content_fokus';
        $data['judul'] = 'Fokus Penelitian';
        $data['brdcrmb'] = 'Beranda / Master Data / Data Fokus Penelitian';
        $data['event'] = $this->Mfokus->get_all('tb_event')->result();
        $data['fokusdtl'] = $this->Mfokus->get_All_fokus()->result();
        $data['fokus'] = $this->Mfokus->get_detail_fks()->result();

        $this->load->view('index', $data);
    }
    public function store_fokus()
    {
        $post = $this->input->post();
        $fokus = [
            'bidang_fokus' => $post['fokus'],
            'status' => 1
        ];
        $insert_fokus = $this->Mfokus->store_fokus($fokus);
        if ($insert_fokus['status'] === false) {
            echo json_encode($this->response([0, 'Tidak berhasil Menyimpan Data']));
            return;
        }
        $fokus_dtl = [
            'id_fokus' => $insert_fokus['last_id'],
            'id_event' => $post['event'],
            'status' => 1
        ];
        $insert_fokus_dtl = $this->Mfokus->store_fokusdtl($fokus_dtl);
        if ($insert_fokus_dtl === false) {
            echo json_encode($this->response([0, 'Tidak berhasil Menyimpan Data']));
            return;
        }

        $this->insert_log(['CREATE', 'CREATE PADA FOKUS']);
        echo json_encode($this->response([1, 'Berhasil Menyimpan Data']));
    }
    public function store_fokusdtl()
    {
        $post = $this->input->post();
        $soal = [
            'id_fokus' => $post['event'],
            'id_event' => $post['fokusdtl'],
            'status' => 1
        ];

        $insert = $this->Mfokus->store_fokusdtl($soal);

        if ($insert === false) {
            echo json_encode($this->response([0, 'Tidak berhasil Menyimpan Data']));
            return;
        }

        echo json_encode($this->response([1, 'Berhasil Menyimpan Data']));
    }
    public function luaran()
    {

        $data['content'] = VIEW_ADMIN . 'content_luaran';
        $data['judul'] = 'Luaran Penelitian';
        $data['brdcrmb'] = 'Beranda / Master Data / Data Luaran Penelitian';
        $data['luaran'] = $this->Mfokus->get_all('tb_luaran')->result();

        $this->load->view('index', $data);
    }

    public function store_luaran()
    {
        $post = $this->input->post();
        $soal = [
            'judul_luaran' => $post['luaran'],
            'jenis_luaran' => $post['jnsluaran'],
            'status' => 1
        ];

        $insert = $this->Mfokus->store_luaran($soal);

        if ($insert === false) {
            echo json_encode($this->response([0, 'Tidak berhasil Menyimpan Data']));
            return;
        }
        $this->insert_log(['CREATE', 'CREATE PADA LUARAN']);
        echo json_encode($this->response([1, 'Berhasil Menyimpan Data']));
    }

    public function dataEditLuaran()
    {
        $id = $this->input->post("id");
        $getData = $this->setting->getWhere($id);
        echo json_encode($getData);
    }
    public function dataEditfokus()
    {
        $id = $this->input->post("id");
        $getData = $this->Mfokus->get_detail_fks($id)->result();
        echo json_encode($getData);
    }
    public function get_list_proposal()
    {
        $id = $this->input->post('id');
        $nip = $this->input->post('nip');
        $output = '';
        $data = [];

        if ($id == 1) {
            $this->db->select('a.id_pengajuan_detail id_detail,DATE_FORMAT(a.created_at, "%Y-%m-%d") tanggal,b.judul,b.tema_penelitian tema, b.tahun_usulan tahun,c.id_jenis');
            $this->db->from('pengajuan_detail_mandiri a');
            $this->db->join('identitas_pengajuan_mandiri b', 'a.id_pengajuan_detail = b.id_pengajuan_detail');
            $this->db->join('pengajuan_mandiri c', 'a.id_pengajuan = c.id_pengajuan');
            $this->db->join('anggota_dosen_mandiri d', 'a.id_pengajuan_detail = d.id_pengajuan_detail');
            $this->db->where(['a.status >' => 7, 'd.nip' => $nip, 'd.status' => 2, 'a.status_koreksi' => 1]);
            $data = $this->db->get()->result();


            if ($data !== null) {
                foreach ($data as $value) {
                    $jenis = $value->id_jenis == 1 ? ' Penelitian' : 'Pengabdian';
                    $tanggal = tp_indo($value->tanggal);
                    $output .=
                        "<tr><td class='text-capitalize'>$tanggal</td><td class='text-capitalize'>$value->judul</td><td class='text-capitalize'>$value->tema</td><td class='text-capitalize'>$value->tahun</td><td class='text-capitalize'>$jenis</td><td><a class='btn btn-xs btn-success' href='#'>DITERIMA</a></td><td class='text-capitalize'><a href='#'  class='btn btn-primary'><i class='fas fa-fw fa-eye'></i></a></td></tr>";
                }
            }
        } else {
            $this->db->select('a.id_pengajuan_detail id_detail, b.judul, b.tahun_usulan tahun, b.tema_penelitian tema,bb.id_jenis_event id_jenis,a.status_keputusan keputusan');
            $this->db->from('tb_pengajuan_detail as a');
            $this->db->join('tb_identitas_pengajuan as b', 'b.id_pengajuan_detail = a.id_pengajuan_detail');
            $this->db->join('tb_pengajuan as dd', 'dd.id_pengajuan = a.id_pengajuan');
            $this->db->join('tb_dokumen_pengajuan as cc', 'cc.id_pengajuan_detail = b.id_pengajuan_detail');

            $this->db->join('tb_list_event as bb', 'bb.id_list_event = dd.id_list_event');
            $this->db->join('tb_jenis_event as aa', 'aa.id_jenis_event = bb.id_jenis_event');
            $this->db->join('tb_anggota_dosen as zz', 'zz.id_pengajuan_detail = a.id_pengajuan_detail');

            $this->db->where(['zz.nidn' => $nip, 'cc.file_rab != ' => NULL, 'cc.file_proposal != ' => NULL]);
            $data = $this->db->get()->result();

            if ($data !== null) {
                foreach ($data as $value) {
                    $jenis = $value->id_jenis == 1 ? ' Penelitian' : 'Pengabdian';
                    if ($value->keputusan == NULL) {
                        $keputusan = "<a class='btn btn-xs btn-warning' href='#'>MENUNGGU</a>";
                    } elseif ($value->keputusan == 2) {
                        $keputusan = "<a class='btn btn-xs btn-danger' href='#'>DITOLAK</a>";
                    } else {
                        $keputusan = "<a class='btn btn-xs btn-success' href='#'>DITERIMA</a>";
                    }
                    $tanggal = '-';
                    $output .=
                        "<tr><td class='text-capitalize'>$tanggal</td><td class='text-capitalize'>$value->judul</td><td class='text-capitalize'>$value->tema</td><td class='text-capitalize'>$value->tahun</td><td class='text-capitalize'>$jenis</td><td>$keputusan</td><td class='text-capitalize'><a href='#'  class='btn btn-primary'><i class='fas fa-fw fa-eye'></i></a></td></tr>";
                }
            }
        }

        echo json_encode(['code' => 1, 'data' => $output]);
    }

    public function update_luaran()
    {
        $post = $this->input->post();
        $luaran = $post['luaran'];
        $jnsluaran = $post['jnsluaran'];
        $status = $post['status'];
        $idluaran = $post['id'];

        $data = [
            'judul_luaran' => $luaran,
            'jenis_luaran' => $jnsluaran,
            'status' => $status
        ];

        $this->db->where('id_luaran', $idluaran);
        $update = $this->db->update('tb_luaran', $data);

        if ($update === false) {
            print_r($this->response([0, 'Tidak berhasil Mengedit Data']));
            return;
        }
        $this->insert_log(['UPDATE', 'UPDATE PADA LUARAN']);
        print_r($this->response([1, 'berhasil Mengedit Data']));
        return;
    }
    public function update_fokus()
    {
        $post = $this->input->post();
        $fokus = $post['fokus'];
        $status = $post['status'];
        $idfokus = $post['id'];

        $data = [
            'bidang_fokus' => $fokus,
            'status' => $status
        ];
        $data_dtl = [
            'status' => $status
        ];
        $this->db->trans_start();

        $this->db->where('id_fokus', $idfokus);
        $this->db->update('tb_fokus', $data);
        $this->db->where('id_fokus', $idfokus);
        $this->db->update('tb_fokus_detail', $data_dtl);

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            print_r($this->response([0, 'Tidak berhasil Mengedit Data']));
            return;
        }
        $this->insert_log(['UPDATE', 'UPDATE PADA FOKUS']);
        print_r($this->response([1, 'berhasil Mengedit Data']));
        return;
    }
    public function insertuser()
    {
        $post = $this->input->post();
        $data['content'] = VIEW_ADMIN . 'content_add_user';
        $data['judul'] = 'Tambahkan User';
        $data['brdcrmb'] = 'Beranda / Master Data / Tambah User';
        $rules = [
            [
                'field' => 'nip',
                'label' => 'NIP',
                'rules' => 'trim|required|callback_duplicateNip'
            ],
            [
                'field' => 'nama',
                'label' => 'Nama',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|callback_emailPolije|callback_duplicateEmail'
            ],
            [
                'field' => 'jenis_user',
                'label' => 'Jenis User',
                'rules' => 'trim|required'
            ]
        ];
        $this->form_validation->set_message('required', '%s harus diisi');
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('index', $data);
            return;
        }
        $data_simpan = [
            'nidn' => $post['nip'],
            'nip' => $post['nip'],
            'jenis_job' => $post['jenis_user'],
            'nama' => $post['nama'],
            'email' => $post['email']
        ];
        if ($this->db->insert('dummy_dosen', $data_simpan)) {
            $this->tambah_hindex($post['nip']);
            $this->session->set_flashdata('success', 'Data Berhasil disimpan');
            $this->session->set_flashdata('key', 'success');
            redirect('C_master_data/insertuser');
        }
        $this->load->view('index', $data);
    }
    public function tambah_hindex($nip)
    {
        $this->load->model('M_auth', 'auth');
        $get_data = $this->auth->get_where('tb_hindex', ['nidsn_dosen' => $nip])->row();
        if ($get_data === null) {
            $user_data = $this->auth->get_where('dummy_dosen', ['nidn' => $nip])->row();
            $jml_penelitian = 1;
            $jml_pengabdian = 0;
            if ($user_data->jenis_job == "dosen") {
                $jml_penelitian = 2;
                $jml_pengabdian = 1;
            }
            $this->db->insert('tb_hindex', ['nidsn_dosen' => $user_data->nip, 'nama_dosen' => $user_data->nama, 'h_index_scopus' => 0, 'h_index_schoolar' => 0, 'limit_pengabdian' => $jml_pengabdian, 'sisa_limit_pengabdian' => $jml_pengabdian, 'limit_penelitian' => $jml_penelitian, 'sisa_limit_penelitian' => $jml_penelitian]);
        }
    }
    public function duplicateEmail($email)
    {
        if ($email === "") return true;
        $cek = $this->db->query("select nip from dummy_dosen where email='$email'")->row();
        if ($cek !== null) {
            $this->form_validation->set_message('duplicateEmail', '{field} sudah digunakan user lain');
            return false;
        }
        return true;
    }
    public function duplicateNip($nip)
    {
        if ($nip === "") return true;
        if(!is_numeric($nip)){
            $this->form_validation->set_message("duplicateNip", "{field} harus angka");
            return false;
        }
        $cek = $this->db->query("select nip from dummy_dosen where nidn='$nip'")->row();
        if ($cek !== null) {
            $this->form_validation->set_message("duplicateNip", "{field} sudah digunakan user lain");
            return false;
        }
        return true;
    }
    public function emailPolije($email)
    {
        if ($email === "") return true;
        $email = explode('@', $email);
        if ($email[1] !== "polije.ac.id") {
            $this->form_validation->set_message("emailPolije", "{field} harus menggunakan email polije");
            return false;
        }
        return true;
    }

    public function jenis_proposal()
    {

        $data['content'] = VIEW_ADMIN . 'content_jns_proposal';
        $data['judul'] = 'Jenis Proposal';
        $data['brdcrmb'] = 'Beranda / Master Data / Data Jenis Proposal';
        $data['kelompok'] = $this->Mfokus->get_all('tb_kelompok_pengajuan')->result();
        $data['luaran'] = $this->mLuaran->get_all('tb_luaran')->result();

        $this->load->view('index', $data);
    }

    public function store_jenis_proposal()
    {
        $post = $this->input->post();
        if (isset($post['luaran_pilih'])) {
            $luaran_pilih = $post['luaran_pilih'];
            $kelompok_luaran = implode(",", $luaran_pilih);
            $soal = [
                'nama_kelompok' => $post['nmkelompok'],
                'biaya_proposal' => $post['biaya'],
                'kelompok_luaran' => $kelompok_luaran,
                'status' => 1
            ];

            $insert = $this->Mfokus->store_jnsproposal($soal);
        } else {
            echo json_encode($this->response([0, 'Pilihan Luaran tidak boleh kosong!']));
            return;
        }
        if ($insert === false) {
            echo json_encode($this->response([0, 'Tidak berhasil Menyimpan Data']));
            return;
        }
        $this->insert_log(['CREATE', 'CREATE PADA JENIS PROPOSAL']);
        echo json_encode($this->response([1, 'Berhasil Menyimpan Data']));
    }

    public function dataEditjnsproposal()
    {
        $id = $this->input->post("id");
        $getData = $this->setting->getWherejns($id);
        echo json_encode($getData);
    }

    public function update_jnsproposal()
    {
        $post = $this->input->post();
        if (isset($post['luaran_pilih'])) {
            $nmkelompok = $post['nmkelompok'];
            $biayaproposal = $post['biaya'];
            $status = $post['status'];
            $idpengajuan = $post['id'];
            $luaran_pilih = $post['luaran_pilih'];
            $kelompok_luaran = implode(",", $luaran_pilih);

            $data = [
                'nama_kelompok' => $nmkelompok,
                'biaya_proposal' => $biayaproposal,
                'kelompok_luaran' => $kelompok_luaran,
                'status' => $status
            ];

            $this->db->where('id_kelompok_pengajuan', $idpengajuan);
            $update = $this->db->update('tb_kelompok_pengajuan', $data);
        } else {
            echo json_encode($this->response([0, 'Pilihan Luaran tidak boleh kosong!']));
            return;
        }
        if ($update === false) {
            print_r($this->response([0, 'Tidak berhasil Mengedit Data']));
            return;
        }
        $this->insert_log(['UPDATE', 'UPDATE PADA JENIS PROPOSAL']);
        print_r($this->response([1, 'berhasil Mengedit Data']));
        return;
    }


    public function upload()
    {
        $dir_cv = realpath(APPPATH . '../assets/berkas/file_cv/');
        $name = $_FILES['file_cv']['name'];
        $tmp = $_FILES['file_cv']['tmp_name'];
        $coba = explode('.', $name);
        $extension = $coba[count($coba) - 1];
        $nama_file = 'cv_' . $_SESSION['nidn'] . '_' . date("Y-m-d") . '.' . $extension;
        if (move_uploaded_file($tmp, $dir_cv . '/' . $nama_file)) {
            return $nama_file;
        } else {
            return false;
        }
    }

    public function reviewer()
    {
        $data['content'] = VIEW_ADMIN . 'content_master_reviewer';
        $data['judul'] = 'Master Reviewer';
        $data['brdcrmb'] = 'Beranda / Master Data / Data Master Reviewer';
        $dataDosen = $this->reviewer->reviewer_get_all();
        if ($dataDosen == null) {
            $data['dosen'] = $this->reviewer->get_all("dummy_dosen")->result();
        } else {
            $data['dosen'] = $dataDosen;
        }
        $data['dosen2'] = $this->reviewer->get_all("dummy_dosen")->result();
        $data['event'] = $this->event->get_dataEvent()->result();

        $this->load->view('index', $data);
    }

    public function get_list_master_reviewer()
    {
        $list = $this->reviewer->list_reviewer_asc();
        $a = 0;
        $reviewer = "";
        for ($i = 0; $i <= count($list) - 1; $i++) {
            $eventGroup = "";
            $a++;
            $reviewer .= '<tr>';
            $reviewer .= '<td class="text-uppercase">' . $a . '.</td>';
            $reviewer .= '<td class="text-uppercase">' . $list[$i]->nama . '</td>';
            $event = explode(",", $list[$i]->id_event);
            for ($j = 0; $j < count($event); $j++) {
                $listEvent = $this->event->list_event_id2($event[$j]);
                $eventGroup .= $listEvent[0]->nm_event . ", ";
            }
            $reviewer .= '<td class="text-uppercase">' . substr($eventGroup, 0, -2) . '</td>';
            $reviewer .= '<td class="text-center"><a href="#" id="' . $list[$i]->id_reviewer . '" class="btn btn-xs btn-warning btn-edit"><i class="fa fa-fw fa-edit"></i></a><a href="#" id="' . $list[$i]->id_reviewer . '" class="btn btn-xs btn-danger btn_delete"><i class="fa fa-fw fa-trash"></i></a></td>';
            $reviewer .= '</tr>';
        }

        echo json_encode($reviewer);
    }

    public function store_MasterReviewer()
    {
        $post = $this->input->post();

        $eventIds = $post['eventIds'];
        $event = implode(",", $eventIds);

        if ($post['nidn'] === '' || $eventIds === '') {
            echo json_encode($this->response([0, 'Form Hurus Lengkap!']));
            return;
        } else {
            $cek_nidn = $this->reviewer->cek_nidn($post['nidn'], date("Y"));
            if ($cek_nidn == 0) {
                $soal = [
                    'nidn' => $post['nidn'],
                    'id_event' => $event,
                    'tahun' => date("Y"),
                    'status' => 1
                ];

                $insert = $this->reviewer->insert("tb_reviewer", $soal);
            } else {
                echo json_encode($this->response([0, 'Dosen Sudah Didata Ditahun Ini!']));
                return;
            }
        }
        if ($insert === false) {
            echo json_encode($this->response([0, 'Tidak berhasil Menyimpan Data']));
            return;
        }
        echo json_encode($this->response([1, 'Berhasil Menyimpan Data']));
    }

    public function get_list_reviewer_by_id()
    {
        $id = $this->input->post('id');

        $get_list = $this->reviewer->list_reviewer_id($id);
        echo json_encode($get_list);
    }

    public function updateReviewer()
    {
        $id = $this->input->post('id_reviewer');
        $reviewer = $this->input->post('reviewer');
        $eventIds = $this->input->post('event');
        $event = implode(",", $eventIds);
        $status = $this->input->post('status');

        if ($reviewer === '' || $event === '' || $status === '') {
            echo json_encode($this->response([0, 'Form Hurus Lengkap!']));
            return;
        } else {

            $data = array(
                'nidn' => $reviewer,
                'id_event' => $event,
            );

            $this->reviewer->update('tb_reviewer', $data, array('id_reviewer' => $id));
            echo json_encode($this->response([1, 'Berhasil Mengubah Data']));
        }
    }


    public function deleteReviewer()
    {
        $post = $this->input->post();
        $id_list = $post['id'];

        $data = [
            'status' => 0
        ];

        $this->db->where('id_reviewer', $id_list);
        $delete = $this->db->update('tb_reviewer', $data);
        // return ($this->db->affected_rows() > 0);

        // if ($delete == false) {
        //     $res = $this->response([0, 'Failed Delete Your Data.']);
        //     echo json_encode($res);
        //     return;
        // }
        $res = $this->response([1, 'Success Delete Your Data.']);
        echo json_encode($res);
        return;
    }
    // akhircontroller

}
