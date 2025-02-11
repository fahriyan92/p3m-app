<?php

class M_luaranwajib extends CI_Model
{


    public function tampil_luaran()
    {
        $this->db->select('*');
        $this->db->from('tb_luaran');
        return $this->db->get()->result();
    }

    public function tambah_laporan($data)
    {
        $this->db->insert('tb_progresspengabdian', $data);
    }

    // public function fungsiTambah()
    // {
    //     $progress = $this->input->post('')
    // }

    // function insertDataLuaranPengabdian($data) {
    //     $this
    // }

    public function progress()
    {
        $this->db->select('*');
        $where = "field is NOT NULL";
        $this->db->from('tb_progresspengabdian');
        return $this->db->get()->result();
    }

    public function progressPenelitian()
    {
        $this->db->select('*');
        $this->db->from('tb_progresspenelitian');
        return $this->db->get()->result();
    }

    function all_data()
    {
        return $this->db->get('tb_user');
    }
    public function id_pengajuan($list_event = null)
    {
        $this->db->select('id_pengajuan');
        $this->db->where('nidn_ketua', $this->session->userdata('nidn'));
        if ($list_event != null) {
            $this->db->where('id_list_event', $list_event);
        }
        return $this->db->get('tb_pengajuan')->row();
    }

    function check_ketua($nidsn, $event)
    {
        $sql = "SELECT nidn_ketua FROM `tb_pengajuan` WHERE YEAR(created_at) = YEAR(CURDATE()) AND nidn_ketua = '" . $nidsn . "' AND id_list_event ='" . $event . "'";

        $data = $this->db->query($sql);

        return $data;
    }
    public function check_anggota($nidsn)
    {
        $sql = "SELECT nidn FROM `tb_anggota_dosen` WHERE YEAR(created_date) = YEAR(CURDATE()) AND nidn = '" . $nidsn . "' AND nidn != '" . $nidsn . "'";

        $data = $this->db->query($sql);

        return $data;
    }
    public function insert($table = '', $data = '')
    {
        $this->db->insert($table, $data);
    }

    public function get_all($table)
    {
        $this->db->from($table);

        return $this->db->get();
    }
    public function check_selesai($nidsn, $id_list_event)
    {
        // $sql = "SELECT a.id_pengajuan_detail FROM tb_pengajuan_detail as a JOIN tb_dokumen_pengajuan as c ON a.id_pengajuan_detail = c.id_pengajuan_detail WHERE a.id_pengajuan = '" . $id_pengajuan . "' AND c.file_proposal IS NULL";
        $sql = "SELECT a.id_pengajuan_detail FROM tb_pengajuan_detail as a JOIN tb_pengajuan as b ON a.id_pengajuan = b.id_pengajuan JOIN tb_dokumen_pengajuan as c ON a.id_pengajuan_detail = c.id_pengajuan_detail WHERE b.nidn_ketua = '" . $nidsn . "' AND b.id_list_event = '" . $id_list_event . "' AND c.file_proposal IS NULL AND c.file_rab IS NULL";
        $data = $this->db->query($sql);

        return $data;
    }
    public function get_proposal_dosen($nidsn, $id_list_event)
    {
        $sql = "SELECT A.id_pengajuan_detail, B.judul, B.tahun_usulan 
		FROM tb_anggota_dosen as A 
		INNER JOIN tb_identitas_pengajuan as B ON A.id_pengajuan_detail = B.id_pengajuan_detail 
		JOIN tb_pengajuan_detail as D ON A.id_pengajuan_detail = D.id_pengajuan_detail 
		JOIN tb_pengajuan as C ON D.id_pengajuan = C.id_pengajuan 
		WHERE A.nidn = '" . $nidsn . "' AND C.id_list_event = '" . $id_list_event . "' ";
        $data = $this->db->query($sql);

        return $data;
    }
    public function list_proposal_status_penelitian($nidsn, $id_event)
    {

        $sql = "SELECT H.file_proposal,H.file_rab, D.status_keputusan, A.id_pengajuan_detail, B.judul, B.tahun_usulan , G.nm_event, F.id_jenis_event, D.created_at, D.updated_at
		FROM tb_anggota_dosen as A 
			INNER JOIN tb_identitas_pengajuan as B ON A.id_pengajuan_detail = B.id_pengajuan_detail 
			JOIN tb_pengajuan_detail as D ON A.id_pengajuan_detail = D.id_pengajuan_detail 
			JOIN tb_pengajuan as C ON D.id_pengajuan = C.id_pengajuan 
			JOIN tb_list_event as E ON C.id_list_event = E.id_list_event
			JOIN tb_jenis_event as F ON E.id_jenis_event = F.id_jenis_event
			JOIN tb_event as G ON F.id_event = G.id_event
			JOIN tb_dokumen_pengajuan as H ON A.id_pengajuan_detail = H.id_pengajuan_detail 
		WHERE A.nidn = '" . $nidsn . "' 
			AND F.id_event = '" . $id_event . "' ";

        $data = $this->db->query($sql);
        return $data;
    }
    public function check_edit_pengajuan($id)
    {
        $sql = "SELECT a.file_proposal, a.file_rab FROM tb_dokumen_pengajuan as a  WHERE a.id_pengajuan_detail = '" . $id . "' AND a.file_proposal IS NOT NULL";

        $out = $this->db->query($sql);

        return $out;
    }

    public function check_permintaan_anggota($id)
    {
        $sql = "SELECT a.status_permintaan FROM tb_permintaan_anggota as a  WHERE a.id_pengajuan_detail = '" . $id . "' AND a.status_permintaan = 0";

        $out = $this->db->query($sql);

        return $out;
    }
    public function store_pengajuan_kedua($data)
    {
        $this->db->trans_start();
        // log terakhirkali mengubah data
        $this->db->where('id_pengajuan_detail', $data['id_pengajuan_detail']);
        $this->db->update('tb_pengajuan_detail', $data['det_pengajuan']);

        // insert tahap kedua pada tahap data mahasiswa
        $this->db->where('id_pengajuan_detail', $data['id_pengajuan_detail']);
        $this->db->delete('tb_anggota_mhs');
        foreach ($data['mahasiswa'] as $value) {
            $this->db->insert('tb_anggota_mhs', $value);
        }
        // insert kedua pada tahap dokumen pengajuan
        $this->db->set($data['dokumen_pengajuan']);
        $this->db->where('id_pengajuan_detail', $data['id_pengajuan_detail']);
        $this->db->update('tb_dokumen_pengajuan');
        $this->db->trans_complete();

        return $this->db->trans_status();
    }
    public function store_pengajuan_kedua_plp($data)
    {
        $this->db->trans_start();
        // insert kedua pada tahap dokumen pengajuan
        $this->db->set($data['dokumen_pengajuan']);
        $this->db->where('id_pengajuan_detail', $data['id_pengajuan_detail']);
        $this->db->update('tb_dokumen_pengajuan');
        $this->db->trans_complete();

        return $this->db->trans_status();
    }
    public function store_pengajuan_plp($data)
    {
        $this->db->trans_start();

        $id_pengajuan = $this->id_pengajuan($data['pengajuan']['id_list_event']);

        if ($id_pengajuan !== null) {
            $id_pengajuan = $id_pengajuan->id_pengajuan;
        } else {
            // insert pengajuan
            $this->db->insert('tb_pengajuan', $data['pengajuan']);
            $id_pengajuan = $this->db->insert_id();
        }


        // insert detail pengajuan
        $data['det_pengajuan']['id_pengajuan'] = $id_pengajuan;
        $this->db->insert('tb_pengajuan_detail', $data['det_pengajuan']);
        $id_detail = $this->db->insert_id();
        // set id det pengajuan
        $now = date('Y-m-d H:i:s');
        $data['identitas_pengajuan']['id_pengajuan_detail'] = $id_detail;
        $data['dokumen_pengajuan']['id_pengajuan_detail'] = $id_detail;
        $data['luaran_tambahan']['id_pengajuan_detail'] = $id_detail;

        // insert data dosen
        foreach ($data['dosen'] as $value) {
            $value['id_pengajuan_detail'] = $id_detail;
            $this->db->insert('tb_anggota_dosen', $value);

            // insert ke tb_permintaan_anggota
            $id_anggota_dsn = $this->db->insert_id();
            $cek_ketua = $this->get_ketua($data['pengajuan']['nidn_ketua']);

            if ($data['pengajuan']['nidn_ketua'] == $value['nidn']) {
                $data_anggota = [
                    'id_anggota' => $id_anggota_dsn,
                    'id_pengajuan_detail' => $id_detail,
                    'status_permintaan' => 1,
                    'status_notifikasi' => 1,
                    'created_at' => $now

                ];
            } else {

                $get = $this->get_where('dummy_dosen', ['nidn' => $value['nidn']])->row();

                $kirim_email = $this->send_email($get->email, $data['identitas_pengajuan']['judul']);

                $data_anggota = [
                    'id_anggota' => $id_anggota_dsn,
                    'id_pengajuan_detail' => $id_detail,
                    'status_permintaan' => 0,
                    'status_notifikasi' => 0,
                    'created_at' => $now

                ];
            }
            $this->db->insert('tb_permintaan_anggota', $data_anggota);
        }
        // insert data mahasiswa
        foreach ($data['mahasiswa'] as $value) {
            $value['id_pengajuan_detail'] = $id_detail;
            $this->db->insert('tb_anggota_mhs', $value);
        }
        // insert luaran
        if (count($data['luaran']) > 0) {
            foreach ($data['luaran'] as $value) {
                $value['id_pengajuan_detail'] = $id_detail;
                $this->db->insert('tb_target_luaran', $value);
            }
        }
        // insert tb_identitas_pengajuan
        $this->db->insert('tb_identitas_pengajuan', $data['identitas_pengajuan']);
        // insert tb_dokumen_pengajuan
        $this->db->insert('tb_dokumen_pengajuan', $data['dokumen_pengajuan']);
        // insert luaran_tambahan
        if ($data['luaran_tambahan']['judul_luaran_tambahan'] != "null") {
            $this->db->insert('tb_luaran_tambahan', $data['luaran_tambahan']);
        }

        $this->db->where('nidsn_dosen', $data['pengajuan']['nidn_ketua']);
        $this->db->update('tb_hindex', $data['update_limit']);

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            return false;
        }

        return true;
    }

    public function store_pengajuan($data)
    {
        $this->db->trans_start();

        $id_pengajuan = $this->id_pengajuan($data['pengajuan']['id_list_event']);

        if ($id_pengajuan !== null) {
            $id_pengajuan = $id_pengajuan->id_pengajuan;
        } else {
            // insert pengajuan
            $this->db->insert('tb_pengajuan', $data['pengajuan']);
            $id_pengajuan = $this->db->insert_id();
        }


        // insert detail pengajuan
        $data['det_pengajuan']['id_pengajuan'] = $id_pengajuan;
        $this->db->insert('tb_pengajuan_detail', $data['det_pengajuan']);
        $id_detail = $this->db->insert_id();
        // set id det pengajuan
        $now = date('Y-m-d H:i:s');
        $data['identitas_pengajuan']['id_pengajuan_detail'] = $id_detail;
        $data['dokumen_pengajuan']['id_pengajuan_detail'] = $id_detail;
        $data['luaran_tambahan']['id_pengajuan_detail'] = $id_detail;

        // get dosen dari temp anggota
        //anggota polije
        $query = "SELECT DISTINCT b.nidn
					FROM temp_anggota_polije a, dummy_dosen b 
					WHERE a.nip_anggota = b.nidn
					AND a.nip_ketua = '" . $data['pengajuan']['nidn_ketua'] . "' AND a.id_list_event = '" . $data['pengajuan']['id_list_event'] . "'";
        $anggota_polije = $this->db->query($query)->result_array();
        $anggota_polije[] = ['nidn' => $data['pengajuan']['nidn_ketua']];
        //anggota luar
        $query1 = "SELECT DISTINCT b.noktp
					FROM temp_anggota_luar a, tb_anggota_dosen_luar b 
					WHERE a.noktp = b.noktp
					AND a.nip_ketua = '" . $data['pengajuan']['nidn_ketua'] . "' AND a.id_list_event = '" . $data['pengajuan']['id_list_event'] . "'";
        $anggota_luar = $this->db->query($query1)->result_array();
        // insert data dosen
        //anggota luar
        // if($data['identitas_pengajuan']['id_kelompok_pengajuan'] == 7){
        foreach ($anggota_luar as $value2) {
            $value2['id_pengajuan_detail'] = $id_detail;
            $this->db->insert('tb_anggota_pengajuan_dosen_luar', $value2);
        }
        // }
        //anggota polije
        foreach ($anggota_polije as $value) {
            $value['id_pengajuan_detail'] = $id_detail;
            $value['status'] = 1;

            $this->db->insert('tb_anggota_dosen', $value);

            // insert ke tb_permintaan_anggota
            $id_anggota_dsn = $this->db->insert_id();
            $cek_ketua = $this->get_ketua($data['pengajuan']['nidn_ketua']);

            if ($data['pengajuan']['nidn_ketua'] == $value['nidn']) {
                $data_anggota = [
                    'id_anggota' => $id_anggota_dsn,
                    'id_pengajuan_detail' => $id_detail,
                    'status_permintaan' => 1,
                    'status_notifikasi' => 1,
                    'created_at' => $now

                ];
            } else {

                // $get = $this->get_where('dummy_dosen', ['nidn' => $value['nip_anggota']])->row();

                // $kirim_email = $this->send_email($get->email, $data['identitas_pengajuan']['judul']);

                $data_anggota = [
                    'id_anggota' => $id_anggota_dsn,
                    'id_pengajuan_detail' => $id_detail,
                    'status_permintaan' => 0,
                    'status_notifikasi' => 0,
                    'created_at' => $now

                ];
            }
            $this->db->insert('tb_permintaan_anggota', $data_anggota);
        }
        // insert data mahasiswa
        // edited by irfan
        // foreach ($data['mahasiswa'] as $value) {
        // 	$value['id_pengajuan_detail'] = $id_detail;
        // 	$this->db->insert('tb_anggota_mhs', $value);
        // }
        // edited by irfan

        // insert luaran
        if (count($data['luaran']) > 0) {
            foreach ($data['luaran'] as $value) {
                $value['id_pengajuan_detail'] = $id_detail;
                $this->db->insert('tb_target_luaran', $value);
            }
        }
        // insert tb_identitas_pengajuan
        $this->db->insert('tb_identitas_pengajuan', $data['identitas_pengajuan']);
        // insert tb_dokumen_pengajuan
        $this->db->insert('tb_dokumen_pengajuan', $data['dokumen_pengajuan']);
        // insert luaran_tambahan
        if ($data['luaran_tambahan']['judul_luaran_tambahan'] != "null") {
            $this->db->insert('tb_luaran_tambahan', $data['luaran_tambahan']);
        }

        $this->db->where('nidsn_dosen', $data['pengajuan']['nidn_ketua']);
        $this->db->update('tb_hindex', $data['update_limit']);

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            return false;
        }

        return true;
    }

    public function edit_pertama($data, $id_pengajuan_detail)
    {
        $this->db->trans_start();
        $this->db->where('id_pengajuan_detail', $id_pengajuan_detail);
        $this->update('tb_pengajuan_detail', $data['det_pengajuan']);
        $now = date('Y-m-d H:i:s');

        $this->db->where('id_pengajuan_detail', $id_pengajuan_detail);
        $this->db->delete('tb_anggota_dosen');

        $this->db->where(['id_pengajuan_detail' => $id_pengajuan_detail]);
        $this->db->delete('tb_permintaan_anggota');

        foreach ($data['dosen'] as $value) {
            $value['id_pengajuan_detail'] = $id_pengajuan_detail;
            if ($value['nidn'] === $data['pengajuan']['nidn_ketua']) {
            }
            $this->db->insert('tb_anggota_dosen', $value);

            // insert ke tb_permintaan_anggota
            $id_anggota_dsn = $this->db->insert_id();


            if ($data['pengajuan']['nidn_ketua'] == $value['nidn']) {
                $data_anggota = [
                    'id_anggota' => $id_anggota_dsn,
                    'id_pengajuan_detail' => $id_pengajuan_detail,
                    'status_permintaan' => 1,
                    'status_notifikasi' => 1,
                    'created_at' => $now

                ];
            } else {

                $get = $this->get_where('dummy_dosen', ['nidn' => $value['nidn']])->row();

                $kirim_email = $this->send_email($get->email, $data['identitas_pengajuan']['judul']);

                $data_anggota = [
                    'id_anggota' => $id_anggota_dsn,
                    'id_pengajuan_detail' => $id_pengajuan_detail,
                    'status_permintaan' => 0,
                    'status_notifikasi' => 0,
                    'created_at' => $now

                ];
            }
            $this->db->insert('tb_permintaan_anggota', $data_anggota);
        }

        if (isset($data['mahasiswa'])) {
            foreach ($data['mahasiswa'] as $value) {
                $value['id_pengajuan_detail'] = $id_pengajuan_detail;
                $this->db->insert('tb_anggota_mhs', $value);
            }
        }

        $this->db->where('id_pengajuan_detail', $id_pengajuan_detail);
        $this->db->delete('tb_target_luaran');
        if (count($data['luaran']) > 0) {
            foreach ($data['luaran'] as $value) {
                $value['id_pengajuan_detail'] = $id_pengajuan_detail;
                $this->db->insert('tb_target_luaran', $value);
            }
        }

        $this->db->where('id_pengajuan_detail', $id_pengajuan_detail);
        $this->db->update('tb_identitas_pengajuan', $data['identitas_pengajuan']);
        $this->db->where('id_pengajuan_detail', $id_pengajuan_detail);
        $this->db->update('tb_dokumen_pengajuan', $data['dokumen_pengajuan']);

        if ($data['luaran_tambahan']['judul_luaran_tambahan'] != "null") {
            $this->db->where('id_pengajuan_detail', $id_pengajuan_detail);
            $this->db->update('tb_luaran_tambahan', $data['luaran_tambahan']);
        }



        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            return false;
        }

        return true;
    }

    public function edit_sungguhan_dua($data, $id_pengajuan)
    {
        $this->db->trans_start();
        $this->db->where('id_pengajuan_detail', $id_pengajuan);
        $this->db->update('tb_pengajuan_detail', $data['det_pengajuan']);
        $now = date('Y-m-d H:i:s');

        // $this->db->where('id_pengajuan_detail', $id_pengajuan);
        // $this->db->delete('tb_anggota_dosen');
        // ========================== EDITED BY IRFAN ============================

        // foreach ($data['dosen'] as $value) {
        // 	$value['id_pengajuan_detail'] = $id_pengajuan;
        // 	if ($value['nidn'] === $data['pengajuan']['nidn_ketua']) { }
        // 	$this->db->insert('tb_anggota_dosen', $value);

        // 	// insert ke tb_permintaan_anggota
        // 	$id_anggota_dsn = $this->db->insert_id();


        // 	if ($data['pengajuan']['nidn_ketua'] == $value['nidn']) {
        // 		$data_anggota = [
        // 			'id_anggota' => $id_anggota_dsn,
        // 			'id_pengajuan_detail' => $id_pengajuan,
        // 			'status_permintaan' => 1,
        // 			'status_notifikasi' => 1,
        // 			'created_at' => $now

        // 		];
        // 	} else {

        // 		$data_anggota = [
        // 			'id_anggota' => $id_anggota_dsn,
        // 			'id_pengajuan_detail' => $id_pengajuan,
        // 			'status_permintaan' => 1,
        // 			'status_notifikasi' => 1,
        // 			'created_at' => $now

        // 		];
        // 	}
        // 	$this->db->insert('tb_permintaan_anggota', $data_anggota);
        // }	

        // ========================== END EDITED BY IRFAN ============================

        if (isset($data['mahasiswa'])) {
            $this->db->where('id_pengajuan_detail', $id_pengajuan);
            $this->db->delete('tb_anggota_mhs');
            foreach ($data['mahasiswa'] as $value) {
                $value['id_pengajuan_detail'] = $id_pengajuan;
                $this->db->insert('tb_anggota_mhs', $value);
            }
        }

        $this->db->where('id_pengajuan_detail', $id_pengajuan);
        $this->db->delete('tb_target_luaran');
        if (count($data['luaran']) > 0) {
            foreach ($data['luaran'] as $value) {
                $value['id_pengajuan_detail'] = $id_pengajuan;
                $this->db->insert('tb_target_luaran', $value);
            }
        }

        $this->db->where('id_pengajuan_detail', $id_pengajuan);
        $this->db->update('tb_identitas_pengajuan', $data['identitas_pengajuan']);
        $this->db->where('id_pengajuan_detail', $id_pengajuan);
        $this->db->update('tb_dokumen_pengajuan', $data['dokumen_pengajuan']);

        if ($data['luaran_tambahan']['judul_luaran_tambahan'] != "null") {
            $this->db->where('id_pengajuan_detail', $id_pengajuan);
            $this->db->update('tb_luaran_tambahan', $data['luaran_tambahan']);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            return false;
        }

        return true;
    }

    public function edit_sungguhan_dua_plp($data, $id_pengajuan)
    {
        $this->db->trans_start();
        $this->db->where('id_pengajuan_detail', $id_pengajuan);
        $this->db->update('tb_pengajuan_detail', $data['det_pengajuan']);
        $now = date('Y-m-d H:i:s');

        $this->db->where('id_pengajuan_detail', $id_pengajuan);
        $this->db->delete('tb_anggota_dosen');

        foreach ($data['dosen'] as $value) {
            $value['id_pengajuan_detail'] = $id_pengajuan;
            if ($value['nidn'] === $data['pengajuan']['nidn_ketua']) {
            }
            $this->db->insert('tb_anggota_dosen', $value);

            // insert ke tb_permintaan_anggota
            $id_anggota_dsn = $this->db->insert_id();


            if ($data['pengajuan']['nidn_ketua'] == $value['nidn']) {
                $data_anggota = [
                    'id_anggota' => $id_anggota_dsn,
                    'id_pengajuan_detail' => $id_pengajuan,
                    'status_permintaan' => 1,
                    'status_notifikasi' => 1,
                    'created_at' => $now

                ];
            } else {

                $data_anggota = [
                    'id_anggota' => $id_anggota_dsn,
                    'id_pengajuan_detail' => $id_pengajuan,
                    'status_permintaan' => 1,
                    'status_notifikasi' => 1,
                    'created_at' => $now

                ];
            }
            $this->db->insert('tb_permintaan_anggota', $data_anggota);
        }

        $this->db->where('id_pengajuan_detail', $id_pengajuan);
        $this->db->delete('tb_target_luaran');
        if (count($data['luaran']) > 0) {
            foreach ($data['luaran'] as $value) {
                $value['id_pengajuan_detail'] = $id_pengajuan;
                $this->db->insert('tb_target_luaran', $value);
            }
        }

        $this->db->where('id_pengajuan_detail', $id_pengajuan);
        $this->db->update('tb_identitas_pengajuan', $data['identitas_pengajuan']);
        $this->db->where('id_pengajuan_detail', $id_pengajuan);
        $this->db->update('tb_dokumen_pengajuan', $data['dokumen_pengajuan']);

        if ($data['luaran_tambahan']['judul_luaran_tambahan'] != "null") {
            $this->db->where('id_pengajuan_detail', $id_pengajuan);
            $this->db->update('tb_luaran_tambahan', $data['luaran_tambahan']);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            return false;
        }

        return true;
    }

    public function edit_sungguhan_satu($data, $id_pengajuan)
    {
        $this->db->trans_start();
        $this->db->where('id_pengajuan_detail', $id_pengajuan);
        $this->db->update('tb_pengajuan_detail', $data['det_pengajuan']);
        $now = date('Y-m-d H:i:s');

        // $this->db->where('id_pengajuan',$id_pengajuan);
        // $this->db->delete('tb_anggota_dosen');

        // $this->db->where(['id_pengajuan' => $id_pengajuan]);
        // $this->db->delete('tb_permintaan_anggota');

        $permintaan = "select a.id_anggota,b.nidn nidn from tb_permintaan_anggota a join tb_anggota_dosen b on a.id_anggota = b.id_anggota_dsn where a.id_pengajuan_detail=" . $id_pengajuan;
        $qPermintaan = $this->db->query($permintaan)->result_array();

        foreach ($data['dosen'] as $value) {
            $value['id_pengajuan_detail'] = $id_pengajuan;

            if ($value['nidn'] === $data['pengajuan']['nidn_ketua']) {
                continue;
            }
            if (!array_search($value['nidn'], array_column($qPermintaan, 'nidn'))) {
                $this->db->insert('tb_anggota_dosen', $value);
                $id_anggota_dsn = $this->db->insert_id();

                $data_anggota = [
                    'id_anggota' => $id_anggota_dsn,
                    'id_pengajuan_detail' => $id_pengajuan,
                    'status_permintaan' => 0,
                    'status_notifikasi' => 0,
                    'created_at' => $now
                ];

                $this->db->insert('tb_permintaan_anggota', $data_anggota);
            }
            // insert ke tb_permintaan_anggota

        }

        $this->db->where('id_pengajuan_detail', $id_pengajuan);
        $this->db->delete('tb_target_luaran');
        if (count($data['luaran']) > 0) {
            foreach ($data['luaran'] as $value) {
                $value['id_pengajuan_detail'] = $id_pengajuan;
                $this->db->insert('tb_target_luaran', $value);
            }
        }

        $this->db->where('id_pengajuan_detail', $id_pengajuan);
        $this->db->update('tb_identitas_pengajuan', $data['identitas_pengajuan']);
        $this->db->where('id_pengajuan_detail', $id_pengajuan);
        $this->db->update('tb_dokumen_pengajuan', $data['dokumen_pengajuan']);

        if ($data['luaran_tambahan']['judul_luaran_tambahan'] != "null") {
            $this->db->where('id_pengajuan_detail', $id_pengajuan);
            $this->db->update('tb_luaran_tambahan', $data['luaran_tambahan']);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            return false;
        }

        return true;
    }



    private function get_ketua($ketua)
    {
        $sql = "SELECT id_anggota_dsn, nidn, id_pengajuan_detail FROM tb_anggota_dosen WHERE nidn = '" . $ketua . "' ";

        $data = $this->db->query($sql)->row();

        return $data;
    }
    function simpen_pengajuan($data)
    {
        $this->db->trans_start();
        $this->db->insert('tb_pengajuan_proposal', $data['proposal']);
        $id_proposal = $this->db->insert_id();
        $now = date('Y-m-d H:i:s');

        foreach ($data['dosen'] as $value) {
            $value['id_pengajuan_proposal'] = $id_proposal;
            $this->db->insert('tb_anggota_dosen', $value);

            // insert ke tb_permintaan_anggota
            $id_anggota_dsn = $this->db->insert_id();
            $cek_ketua = $this->get_ketua($data['pengajuan']['nidn_ketua']);

            if ($data['pengajuan']['nidn_ketua'] == $value['nidn']) {
                $data_anggota = [
                    'id_anggota' => $id_anggota_dsn,
                    'id_pengajuan' => $id_proposal,
                    'status_permintaan' => 1,
                    'status_notifikasi' => 1,
                    'created_at' => $now

                ];
            } else {

                $get = $this->get_where('dummy_dosen', ['nidn' => $value['nidn']])->row();

                $kirim_email = $this->send_email($get->email, $data['proposal']['judul']);

                $data_anggota = [
                    'id_anggota' => $id_anggota_dsn,
                    'id_pengajuan' => $id_proposal,
                    'status_permintaan' => 0,
                    'status_notifikasi' => 0,
                    'created_at' => $now

                ];
            }


            $this->db->insert('tb_permintaan_anggota', $data_anggota);
        }

        foreach ($data['mahasiswa'] as $value) {
            $value['id_pengajuan_proposal'] = $id_proposal;
            $this->db->insert('tb_anggota_mhs', $value);
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            return false;
        }

        return true;
    }

    function get_where($table = null, $where = null)
    {
        $this->db->from($table);
        $this->db->where($where);

        return $this->db->get();
    }
    function update($table = null, $data = null, $where = null)
    {
        $this->db->update($table, $data, $where);
    }

    function cari_dosen($id_dosen)
    {
        $this->db->select('*');
        $this->db->from('dummy_dosen td');
        // $this->db->join('tb_dummy_jurusan tj', 'td.jurusan=tj.id_jurusan', 'left');

        $this->db->where('td.NIDSN', $id_dosen);

        $query = $this->db->get();
        return $query;
    }
    function get_id_proposal()
    {
        $q = $this->db->select('id_pengajuan_proposal')->order_by('id_pengajuan_proposal', "desc")->limit(1)->get('tb_pengajuan_proposal')->result();
        $id = "";
        if (count($q) > 0) {
            foreach ($q as $k) {

                $tmp = ((int) $k->id_pengajuan_proposal) + 1;
                $id = $tmp;
            }
        } else {
            $id = 1;
        }

        return $id;
    }
    private function send_email($emailny, $pesan)
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

            'Anda Telah Di pilih sebagai Anggota untuk judul penelitian : "' . $pesan . '" . Silahkan lakukan konfirmasi pada website melalui tautan berikut <b><a href="https://p3m.nikwaf.com/">Disini</a></b>'
        );
        if ($this->email->send()) {
            $res = $this->response([1, 'Email ' . $emailny . ' Berhasil Dikirim']);
            return $res;
        } else {
            $res = $this->response([0, 'Email ' . $emailny . ' Gagal Dikirim, cek kembali email !']);
            return $res;
        }
    }
    private function response($res)
    {

        $pesan = ['code' => $res[0], 'pesan' => $res[1]];

        return $pesan;
    }

    public function insert_temp_anggota_polije($data)
    {
        return $this->db->insert('temp_anggota_polije', $data);
    }
    public function insert_not_temp_anggota_polije($data)
    {

        $this->db->insert('tb_anggota_dosen', $data);
        $id_anggota_dsn = $this->db->insert_id();

        $now = date('Y-m-d H:i:s');
        $permintaan = [
            'id_anggota' => $id_anggota_dsn,
            'id_pengajuan_detail' => $data['id_pengajuan_detail'],
            'status_permintaan' => 0,
            'status_notifikasi' => 0,
            'created_at' => $now,

        ];
        $this->db->insert('tb_permintaan_anggota', $permintaan);
    }

    public function insert_not_temp_dosen_luar($data_anggota_pengajuan_luar, $data_anggota_luar)
    {
        $this->db->insert('tb_anggota_dosen_luar', $data_anggota_luar); // insert ke master dosen luar
        $this->db->insert('tb_anggota_pengajuan_dosen_luar', $data_anggota_pengajuan_luar); // insert ke anggota pengajuan luar

    }

    public function insert_temp_anggota_luar($data_temp, $data_anggota_luar)
    {
        $this->db->insert('temp_anggota_luar', $data_temp);
        $this->db->insert('tb_anggota_dosen_luar', $data_anggota_luar);
    }
}
