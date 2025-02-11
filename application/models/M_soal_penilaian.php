<?php

class M_soal_penilaian extends CI_Model
{

    public function store_soal($soal, $pilihan, $bobot)
    {
        $this->db->trans_start();
        $this->db->insert('tb_soal', $soal);
        $id_soal = $this->db->insert_id();

        for ($i = 0; count($pilihan) > $i; $i++) {
            $data = ['id_soal' => $id_soal, 'deskripsi_pilihan' => $pilihan[$i], 'score' => $bobot[$i], 'status' => 1];
            $this->db->insert('tb_pilihan', $data);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function store_jnsoal($soal)
    {
        $this->db->trans_start();
        $this->db->insert('tb_jenis_soal', $soal);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function store_soalpge($soal, $pilihan, $bobot, $persen)
    {
        $this->db->trans_start();
        $this->db->insert('tb_soal', $soal);
        $id_soal = $this->db->insert_id();

        for ($i = 0; count($pilihan) > $i; $i++) {
            $data = ['id_soal' => $id_soal, 'deskripsi_pilihan' => $pilihan[$i], 'score' => $bobot[$i], 'prosentase' => $persen[$i], 'status' => 1];
            $this->db->insert('tb_pilihan', $data);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function store_jnsoalpge($soal)
    {
        $this->db->trans_start();
        $this->db->insert('tb_jenis_soal', $soal);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function store_soalplp($soal, $pilihan, $bobot, $persen)
    {
        $this->db->trans_start();
        $this->db->insert('tb_soal', $soal);
        $id_soal = $this->db->insert_id();

        for ($i = 0; count($pilihan) > $i; $i++) {
            $data = ['id_soal' => $id_soal, 'deskripsi_pilihan' => $pilihan[$i], 'score' => $bobot[$i], 'prosentase' => $persen[$i], 'status' => 1];
            $this->db->insert('tb_pilihan', $data);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function store_jnsoalplp($soal)
    {
        $this->db->trans_start();
        $this->db->insert('tb_jenis_soal', $soal);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
