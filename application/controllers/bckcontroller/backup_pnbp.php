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

        //mhs
        $nim = explode(',', $post['nim']);

        //dosen
        $nidn = explode(',', $post['nidn']);
        $sinta = explode(',', $post['sinta']);

        for ($i = 0; $i < count($nim); $i++) {
            $mhs[$i] = [
                'nim' => $nim[$i],
                'status' => 1
            ];
        }

        for ($i = 0; $i < count($nidn); $i++) {
            $name = $_FILES['filecv']['name'][$i];
            $extension = substr($name, strpos($name, '.'), strlen($name) - 1);

            $dsn[$i] = [
                'nidn' => $nidn[$i],
                'id_sinta' => $sinta[$i],
                'file_cv' => 'cv_' . $nidn[$i] . '_' . date("Y-m-d") . $extension,
                'status' => 1
            ];
        }

        $status_cv = [];
        $dir_cv = realpath(APPPATH . '../assets/berkas/file_cv/');
        for ($i = 0; $i < count($_FILES['filecv']['name']); $i++) {
            $name = $_FILES['filecv']['name'][$i];
            $extension = substr($name, strpos($name, '.'), strlen($name) - 1);

            $nama_file = 'cv_' . $nidn[$i] . '_' . date("Y-m-d") .  $extension;
            $tmp = $_FILES['filecv']['tmp_name'][$i];

            $unggah = move_uploaded_file($tmp, $dir_cv . '/' . $nama_file);
            if ($unggah) {
                array_push($status_cv, true);
            }
        }

        if (in_array(false, $status_cv)) {
            for ($i = 0; $i < count($_FILES['filecv']['name']); $i++) {
                $name = $_FILES['filecv']['name'][$i];
                $extension = substr($name, strpos($name, '.'), strlen($name) - 1);
                $nama_file = 'file_cv_' . $nidn[$i] . $extension;
                $hapus = unlink($dir_cv . $nama_file);
            }

            echo json_encode(['message' => 'error check file']);
            return;
        }

        $dir_proposal = realpath(APPPATH . '../assets/berkas/file_proposal/');
        $name_proposal = $_FILES['file_proposal']['name'];
        $extension_proposal = substr($name_proposal, strpos($name_proposal, '.'), strlen($name_proposal) - 1);
        $nm_proposal = 'proposal_' . $post['nidn_ketua'] . '_' . str_replace(' ', '_', strtolower($post['judul'])) . $post['tahun_usulan']  . $extension_proposal;
        $tmp_proposal = $_FILES['file_proposal']['tmp_name'];

        $up_proposal = move_uploaded_file($tmp_proposal, $dir_proposal . '/' . $nm_proposal);
        if (!$up_proposal) {
            echo json_encode(['message' => 'error check file']);
            return;
        }

        $dir_rab = realpath(APPPATH . '../assets/berkas/file_rab/');
        $name_rab = $_FILES['file_rab']['name'];
        $extension_rab = substr($name_rab, strpos($name_rab, '.'), strlen($name_rab) - 1);
        $nm_rab = 'rab_' . $post['nidn_ketua'] . '_' . str_replace(' ', '_', strtolower($post['judul'])) . $post['tahun_usulan'] . $extension_rab;
        $tmp_rab = $_FILES['file_rab']['tmp_name'];

        $up_rab = move_uploaded_file($tmp_rab, $dir_rab . '/' . $nm_rab);
        if (!$up_rab) {
            echo json_encode(['message' => 'error check file']);
            return;
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
                'is_nambah_luaran' => $is_nambah_luaran,
                'nidn_ketua' => $post['nidn_ketua'],
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            'identitas_pengajuan' => [
                'id_pengajuan' => null,
                'judul' => $post['judul'],
                'tanggal_mulai_kgt' => $post['mulai'],
                'tanggal_akhir_kgt' => $post['akhir'],
                'biaya' => intval($post['biaya']),
                'tahun_usulan' => $post['tahun_usulan']
            ],
            'dokumen_pengajuan' => [
                'id_pengajuan' => null,
                'ringkasan_pengajuan' => $post['ringkasan'],
                'metode' => $post['metode'],
                'tinjauan_pustaka' => $post['tinjauan'],
                'file_proposal' => $nm_proposal,
                'file_rab' => $nm_rab,
                'status' => 1
            ],
            'luaran_tambahan' => [
                'id_pengajuan' => null,
                'judul_luaran_tambahan' => $post['luaran_tambahan'],
                'status' => 1
            ],
            'dosen' => $dsn,
            'luaran' => $luaran,
            'mahasiswa' => $mhs
        ];

        $insert = $this->pnbp->store_pengajuan($insertkan);
        if ($insert) {
            $res = $this->response([1, 'Berhasil']);
            echo json_encode($res);
            return;
        }
    }