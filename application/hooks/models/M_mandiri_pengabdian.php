<?php

class M_mandiri_pengabdian extends CI_Model
{ 
    public function id_pengajuan()
    {
        $this->db->select('id_pengajuan');
        $this->db->where(['nip_ketua' => $this->session->userdata('nidn') ,'id_jenis' => 2]);
        return $this->db->get('pengajuan_mandiri')->row();
    }

    public function pengajuan_mandiri($where)
    {
        $this->db->select('id_pengajuan_detail id_detail, status,created_at buat, updated_at edit, id_fokus, is_nambah_luaran nambah_ga');
        $this->db->where($where);
        return $this->db->get('pengajuan_detail_mandiri');
    }

    public function get_status ()
    {
        $id_pengajuan = $this->id_pengajuan();
        if($id_pengajuan == null){
            return false;
        } 
        $where = ['id_pengajuan' => $id_pengajuan->id_pengajuan, 'status !=' => 8];
        $id_detail = $this->pengajuan_mandiri($where)->row();
        if($id_detail == null){
            return false;
        } 
        
        return ['id_detail' => $id_detail->id_detail, 'status' => $id_detail->status];
    }

    public function get_anggota($where)
    {
        $this->db->select('a.nip,a.sinta,a.file_cv,a.status,b.nama,b.jenis_unit, b.unit');
        $this->db->where($where);
        $this->db->join('dummy_dosen b','b.nip = a.nip');
        return $this->db->get('anggota_dosen_mandiri a');
    }

    public function get_identitas($id_detail)
    {
        $this->db->select('id_identitas,judul,tema_penelitian tema, sasaran, tanggal_mulai mulai, tanggal_akhir akhir, biaya, tahun_usulan tahun');
        $this->db->where('id_pengajuan_detail',$id_detail);
        return $this->db->get('identitas_pengajuan_mandiri')->row();
    }

    public function get_all_where($table, $id_detail)
    {
        $this->db->where('id_pengajuan_detail',$id_detail);
        return $this->db->get($table);
    }

    public function get_dokumen($id_detail)
    {
        $this->db->select('id_dokumen, ringkasan_pengajuan ringkasan, metode, tinjauan_pustaka tinjauan, file_proposal, file_rab');
        $this->db->where('id_pengajuan_detail', $id_detail);
        return $this->db->get('dokumen_pengajuan_mandiri')->row();
    }

    public function insert_identitas($data)
    {
        $this->db->trans_start();
            $id_pengajuan = $this->id_pengajuan();
            
            if($id_pengajuan !== null){
                $id_pengajuan = $id_pengajuan->id_pengajuan;
            } else{ 
                $this->db->insert('pengajuan_mandiri',['status' => 1, 'nip_ketua' => $this->session->userdata('nidn'), 'created_at' => $data['created_at'], 'id_jenis' => 2]);
                $id_pengajuan = $this->db->insert_id();
            }

            $this->db->insert('pengajuan_detail_mandiri', ['id_pengajuan' => $id_pengajuan,'is_nambah_luaran' => $data['nambah_ga'], 'id_fokus' => $data['id_fokus'], 'status' => 1, 'created_at' => $data['created_at'], 'status_koreksi' => 0]);
            $id_detail = $this->db->insert_id();

            if(isset($data['luaran_tambahan'])){
                $this->db->insert('luaran_tambahan_mandiri', ['id_pengajuan_detail' => $id_detail, 'judul_luaran_tambahan' => $data['luaran_tambahan'], 'status' => 1]);
            }

            if($data['luaran'] !== null){
                foreach($data['luaran'] as $lr){
                    $this->db->insert('target_luaran_mandiri', ['id_luaran' => $lr, 'id_pengajuan_detail' => $id_detail, 'status' => 1]);
                }
            }

            $this->db->insert('identitas_pengajuan_mandiri', ['id_pengajuan_detail' => $id_detail, 'judul' => $data['judul'], 'tema_penelitian' => $data['tema_penelitian'], 'sasaran' => $data['sasaran'], 'tanggal_mulai' => $data['tanggal_mulai'], 'tanggal_akhir' => $data['tanggal_akhir'], 'biaya' => $data['biaya'], 'tahun_usulan' => $data['tahun_usulan'] ]);


            $this->db->insert('dokumen_pengajuan_mandiri', ['id_pengajuan_detail' => $id_detail, 'ringkasan_pengajuan' => $data['ringkasan'], 'metode' => $data['metode'], 'tinjauan_pustaka' => $data['tinjauan'], 'status' => 1, 'file_proposal' => NULL, 'file_rab' => NULL]);
            
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function insert_mahasiswa($data)
    {
        $this->db->trans_start();
        $id_pengajuan = $this->id_pengajuan();
        if($id_pengajuan !== null){
            $id_pengajuan = $id_pengajuan->id_pengajuan;
        } else{ 
            return false;
        }

        $where = ['id_pengajuan' => $id_pengajuan, 'status !=' => 8];
        $id_detail = $this->pengajuan_mandiri($where)->row();

        if($id_detail !== null){
            $id_detail = $id_detail->id_detail;
        } else{ 
            return false;
        }

        $this->db->where('id_pengajuan_detail', $id_detail);
        $this->db->update('pengajuan_detail_mandiri', ['status' => 6, 'updated_at' => $data['date_created']]);

        $this->db->insert('anggota_mhs_mandiri', ['id_pengajuan_detail' => $id_detail,'nim' => $data['nim1'], 'nama' => $data['nama1'],'jurusan' => $data['jurusan1'], 'angkatan' => $data['angkatan1'], 'status' => 1]);
    
        if($data['nim2'] !== ''){
            $this->db->insert('anggota_mhs_mandiri', ['id_pengajuan_detail' => $id_detail,'nim' => $data['nim2'], 'nama' => $data['nama2'],'jurusan' => $data['jurusan2'], 'angkatan' => $data['angkatan2'], 'status' => 1]);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function update_identitas($data)
    {
        $this->db->trans_start();
        $id_pengajuan = $this->id_pengajuan();
        if($id_pengajuan !== null){
            $id_pengajuan = $id_pengajuan->id_pengajuan;
        } else{ 
            return false;
        }

        $where = ['id_pengajuan' => $id_pengajuan, 'status !=' => 8];
        $id_detail = $this->pengajuan_mandiri($where)->row();

        if($id_detail !== null){
            $id_detail = $id_detail->id_detail;
        } else{ 
            return false;
        }
        $this->db->where('id_pengajuan', $id_pengajuan);
        $this->db->update('pengajuan_mandiri', ['updated_at' => $data['updated_at']]);

        $this->db->where(['id_pengajuan' => $id_pengajuan, 'id_pengajuan_detail' => $id_detail]);
        $this->db->update('pengajuan_detail_mandiri', ['id_fokus' => $data['id_fokus'], 'updated_at' => $data['updated_at'], 'is_nambah_luaran' => $data['nambah_ga']]);

        $this->db->where('id_pengajuan_detail', $id_detail);
        $this->db->update('identitas_pengajuan_mandiri', ['judul' => $data['judul'], 'tema_penelitian' => $data['tema_penelitian'], 'sasaran' => $data['sasaran'], 'tanggal_mulai' => $data['tanggal_mulai'], 'tanggal_akhir' => $data['tanggal_akhir'], 'biaya' => $data['biaya'], 'tahun_usulan' => $data['tahun_usulan'] ]);

        $this->db->where('id_pengajuan_detail', $id_detail);
        $this->db->update('dokumen_pengajuan_mandiri', ['ringkasan_pengajuan' => $data['ringkasan'], 'metode' => $data['metode'], 'tinjauan_pustaka' => $data['tinjauan']]);

        $this->db->where('id_pengajuan_detail', $id_detail);
        $this->db->delete('target_luaran_mandiri');

        if($data['luaran'] !== null){
            foreach($data['luaran'] as $lr){
                $this->db->insert('target_luaran_mandiri', ['id_luaran' => $lr, 'id_pengajuan_detail' => $id_detail, 'status' => 1]);
            }
        }

        $this->db->where('id_pengajuan_detail', $id_detail);
        $this->db->delete('luaran_tambahan_mandiri');
        if(isset($data['luaran_tambahan'])){
            $this->db->insert('luaran_tambahan_mandiri', ['id_pengajuan_detail' => $id_detail, 'judul_luaran_tambahan' =>  $data['luaran_tambahan'], 'status' => 1]);
        } 


        $this->db->trans_complete();


        return $this->db->trans_status();
    }

    public function update_mahasiswa($data)
    {
        $this->db->trans_start();
        $id_pengajuan = $this->id_pengajuan();
        if($id_pengajuan !== null){
            $id_pengajuan = $id_pengajuan->id_pengajuan;
        } else{ 
            return false;
        }

        $where = ['id_pengajuan' => $id_pengajuan, 'status !=' => 8];
        $id_detail = $this->pengajuan_mandiri($where)->row();

        if($id_detail !== null){
            $id_detail = $id_detail->id_detail;
        } else{ 
            return false;
        }

        $this->db->where('id_pengajuan_detail', $id_detail);
        $this->db->update('pengajuan_detail_mandiri', ['updated_at' => $data['date_created']]);

        $this->db->where('id_pengajuan_detail', $id_detail);
        $this->db->delete('anggota_mhs_mandiri');

        $this->db->insert('anggota_mhs_mandiri', ['id_pengajuan_detail' => $id_detail,'nim' => $data['nim1'], 'nama' => $data['nama1'],'jurusan' => $data['jurusan1'], 'angkatan' => $data['angkatan1'], 'status' => 1]);

        if($data['nim2'] !== ''){
            $this->db->insert('anggota_mhs_mandiri', ['id_pengajuan_detail' => $id_detail,'nim' => $data['nim2'], 'nama' => $data['nama2'],'jurusan' => $data['jurusan2'], 'angkatan' => $data['angkatan2'], 'status' => 1]);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function tambah_anggota($data)
    {
        $this->db->trans_start();
        $id_pengajuan = $this->id_pengajuan();
        if($id_pengajuan !== null){
            $id_pengajuan = $id_pengajuan->id_pengajuan;
        } else{ 
            return false;
        }

        $where = ['id_pengajuan' => $id_pengajuan, 'status !=' => 8];
        $id_detail = $this->pengajuan_mandiri($where)->row();

        if($id_detail !== null){
            $id_detail = $id_detail->id_detail;
        } else{ 
            return false;
        }

        $this->db->where('id_pengajuan', $id_pengajuan);
        $this->db->update('pengajuan_mandiri', ['updated_at' => $data['created_date']]);

        $this->db->where('id_pengajuan_detail', $id_detail);
        $this->db->update('pengajuan_detail_mandiri', ['updated_at' => $data['created_date'], 'status' => 2]);

        $this->db->insert('anggota_dosen_mandiri', ['id_pengajuan_detail' => $id_detail, 'nip' => $data['nip_ketua'], 'sinta' => $data['sinta1'], 'status' => 2, 'created_at' => $data['created_date'], 'file_cv' => $data['file_cv1']]);

        $this->db->insert('anggota_dosen_mandiri', ['id_pengajuan_detail' => $id_detail, 'nip' => $data['nip1'], 'sinta' => $data['sinta2'], 'status' => 1, 'created_at' => $data['created_date'], 'file_cv' => $data['file_cv2']]);

        if($data['pake_gak'] == 1){
            $this->db->insert('anggota_dosen_mandiri', ['id_pengajuan_detail' => $id_detail, 'nip' => $data['nip3'], 'sinta' => $data['sinta3'], 'status' => 1, 'created_at' => $data['created_date'], 'file_cv' => $data['file_cv3']]);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
    public function store($data){
        $this->db->trans_start();
        $id_pengajuan = $this->id_pengajuan();
        $status = $this->get_status();
        $this->db->where('id_pengajuan', $id_pengajuan->id_pengajuan);
        $this->db->update('pengajuan_mandiri', ['updated_at' => date('Y-m-d H:i:s')]);
        $this->db->where('id_pengajuan_detail', $data['id_pengajuan_detail']);
        if($status['status'] == 1){
            $this->db->update('pengajuan_detail_mandiri',['updated_at' => date('Y-m-d H:i:s') , 'status' => 2]);
        } else {
            $this->db->update('pengajuan_detail_mandiri',['updated_at' => date('Y-m-d H:i:s')]);
        }
        //update status jika status masih 1
        $this->db->insert('anggota_dosen_mandiri',$data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function status_penelitian()
    {
        $pengajuan = $this->id_pengajuan();
        $status = 0;
        $id_identitas = 0;
        $komentar = null;
        $status_koreksi = 0;
        if($pengajuan !== null){
            $this->db->select('status, id_pengajuan_detail id_detail,status_koreksi');
            $this->db->where(['id_pengajuan' => $pengajuan->id_pengajuan, 'status_koreksi !=' => 1]);
            $detail = $this->db->get('pengajuan_detail_mandiri')->row();

            $status = $detail !== null ? $detail->status : 0;
            $id_identitas = $detail !== null ? $detail->id_detail : 0;

            if($detail !== null){
                $this->db->select('komentar');
                $this->db->where('id_pengajuan_detail',$detail->id_detail);
                $kom = $this->db->get('komentar_mandiri')->row();
                $komentar = $kom !== null ? $kom->komentar : null;
                $status_koreksi = $detail->status_koreksi;
            }
        } 

        return [$status,$id_identitas,$komentar,$status_koreksi];
        // return 0;
    }

    public function get_data_anggota($where)
    {
        $this->db->where($where);
        return $this->db->get('anggota_dosen_mandiri');
    }

    public function update_file($data)
    {
        $this->db->trans_start();
        $id_pengajuan = $this->id_pengajuan();
        if($id_pengajuan !== null){
            $id_pengajuan = $id_pengajuan->id_pengajuan;
        } else{ 
            return false;
        }

        $where = ['id_pengajuan' => $id_pengajuan, 'status !=' => 8];
        $id_detail = $this->pengajuan_mandiri($where)->row();

        if($id_detail !== null){
            $id_detail = $id_detail->id_detail;
        } else{ 
            return false;
        }

        if($data['file_proposal'] !== ''){
            $this->db->where('id_pengajuan_detail', $id_detail);
            $this->db->update('dokumen_pengajuan_mandiri', ['file_proposal' => $data['file_proposal']]);
        }
        if($data['file_rab'] !== ''){
            $this->db->where('id_pengajuan_detail', $id_detail);
            $this->db->update('dokumen_pengajuan_mandiri', ['file_rab' => $data['file_rab']]);
        }

        $this->db->where('id_pengajuan_detail', $id_detail);
        if($id_detail->status == 7){
            $this->db->update('pengajuan_detail_mandiri', ['updated_at' => $data['created_date']]);

        } else {
            $this->db->update('pengajuan_detail_mandiri', ['updated_at' => $data['created_date'], 'status' => 7]);
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_data_anggota_join($where)
    {
        $this->db->select('b.nip nip , b.nama nama, a.sinta, a.file_cv,a.status, b.unit, b.jenis_unit');
        $this->db->where($where);
        $this->db->join('dummy_dosen b', 'a.nip = b.nip');
        return $this->db->get('anggota_dosen_mandiri a');
    }


    public function get_mahasiswa($where)
    {
        $this->db->where($where);
        return $this->db->get('anggota_mhs_mandiri'); 
    }

    public function get_all_proposal($tahun = null)
    {
        $this->db->select('a.id_pengajuan_detail id_detail,b.judul,a.status, b.tahun_usulan tahun, d.nama, i.nip, a.status_koreksi');
		$this->db->from('pengajuan_detail_mandiri a');
		$this->db->join('identitas_pengajuan_mandiri b', 'a.id_pengajuan_detail = b.id_pengajuan_detail');
		$this->db->join('pengajuan_mandiri c', 'a.id_pengajuan = c.id_pengajuan');
        $this->db->join('dummy_dosen d', 'c.nip_ketua = d.nip');
        $this->db->join('anggota_dosen_mandiri i', 'i.id_pengajuan_detail = a.id_pengajuan_detail');
		$this->db->where(['a.status >' => 7, 'c.id_jenis' => 2, 'i.nip' => $this->session->userdata('nidn'), 'a.status_koreksi' => 1]);

        if($tahun != null){
            $this->db->where('b.tahun_usulan',$tahun);
        }
		return $this->db->get()->result();
    }

	public function get_proposalnya_mandiri($id)
	{
		$this->db->select('a.id_pengajuan_detail id_pengajuan,c.tema_penelitian tema,c.sasaran,c.biaya,a.id_fokus,e.nip_ketua nidn_ketua, a.is_nambah_luaran ,b.nama nama_ketua, c.judul judul, c.tanggal_mulai mulai, c.tanggal_akhir akhir, c.biaya biaya_usulan, c.tahun_usulan tahun_usulan, d.ringkasan_pengajuan ringkasan, d.metode metode , d.tinjauan_pustaka tinjauan, d.file_proposal proposal, d.file_rab rab, a.status, j.komentar');
        $this->db->from('pengajuan_detail_mandiri a');
		$this->db->join('pengajuan_mandiri e', 'a.id_pengajuan = e.id_pengajuan');
		$this->db->join('dummy_dosen b', 'e.nip_ketua = b.nidn');
		$this->db->join('identitas_pengajuan_mandiri c', 'a.id_pengajuan_detail = c.id_pengajuan_detail');
        $this->db->join('dokumen_pengajuan_mandiri d', 'a.id_pengajuan_detail = d.id_pengajuan_detail'); 
		$this->db->join('komentar_mandiri j', 'a.id_pengajuan_detail = j.id_pengajuan_detail'); 
		$this->db->where(['a.id_pengajuan_detail' => $id, 'e.id_jenis' => 2,'a.status_koreksi' => 1, 'a.status' => 8]);
		return $this->db->get()->row();
    }        
    
} 
