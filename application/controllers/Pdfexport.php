<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pdfexport extends CI_Controller {

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

  public function test()
  {
    $this->load->library('pdf');
    $html = 'Dummy Export PDF';
    $this->pdf->createPDF($html, 'Title Dummy Export PDF', false);
  }

  public function puvj($id, $event)
  {
    $data['idproposal'] = $id;
    $data['idevents'] = $event;
    $id_proposal = $this->pemonev->get_id_proposal($id);
    $kelompok_pengajuan = $this->pemonev->get_kelompok_pengajuan($id_proposal->id_pengajuan_detail);
    $namakelompok = $kelompok_pengajuan->nama_kelompok;
    $laporan_monev = $this->pemonev->get_laporanPemonev($id);
    $dt_proposal = $this->reviewer->get_proposalnya($id_proposal->id_pengajuan_detail);
    $pemonev = $this->pemonev->get_nama_pemonev($id);
    $nama_pemonev = $pemonev->nama;
    // $get_tanggal_pemonev = $this->pemonev->get_tanggal_update_pemonev($id, $dt_proposal->id_pengajuan_detail);
    // $tanggal_pemonev = $get_tanggal_pemonev;
    // $tanggal_monev = (explode(" ", $tanggal_pemonev));

    $rekom = $this->pemonev->get_where('masukan_pemonev', ['id_kerjaan_monev' => $id])->row();

    $this->load->library('pdf');
    $html = '
    <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
      </head>
      <body>
        <!-- KOP Surat -->
        <div>
          <img width="18%" style="float: left;" src="https://i.ibb.co/M64tbjb/Logo-POLIJE-Hitam-Putih.png">
          <div style="text-align: center; border-bottom: 1px solid #000; margin: 0;">
            <h1 style="font-size: 20px; margin: 0; padding: 0;">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN,<br>RISET DAN TEKNOLOGI<br>POLITEKNIK NEGERI JEMBER</h1>
            <h2 style="font-size: 15px; margin: 0; padding: 0;">PUSAT PENELITIAN DAN PENGABDIAN MASYARAKAT</h2>
            <p style="font-size: 14px;">Jl. Mastrip Kotak Pos 164 Jember – 68101 Telp. (0331) 333532-333534 Fax. (0331) 333531<br>e-mail: politeknik@polije.ac.id laman: www.polije.ac.id</p>
          </div>
          <div style="clear:both"></div>
          <hr style="height: 5px; background-color: #000; margin-top: 2px; pading: 0;">
        </div>

        <div style="width: 100%;">
          <h1 style="font-size: 18px; text-align: center;">Borang Monitoring dan Evaluasi '. $namakelompok .'</h1>
        <table style="width: 100%;">
          <tr>
            <td style="width: 30%">Judul Pengabdian</td>
            <td>: '. $dt_proposal->judul .'</td>
          </tr>
          <tr>
            <td>Ketua Tim Pelaksana</td>
            <td>: '. $dt_proposal->nama_ketua .'</td>
          </tr>
          <tr>
            <td>NIDN</td>
            <td>: '. $dt_proposal->nidn_ketua .'</td>
          </tr>
          <tr>
            <td>Skema</td>
            <td>: '. $namakelompok .'</td>
          </tr>
          <tr>
            <td>Jangka Waktu Pelaksanaan</td>
            <td>: '. $dt_proposal->mulai .' S.d. '. $dt_proposal->akhir .'</td>
          </tr>
          <tr>
            <td>Biaya</td>
            <td>: '. rupiah($dt_proposal->biaya_usulan) .'</td>
          </tr>
        </table>

        <table style="width: 100%; border-collapse: collapse; text-align: center;">
          <tr>
            <th style="border: 1px solid #000; padding: 5px;">No</th>
            <th style="border: 1px solid #000; width: 40%;">Komponen Penilaian</th>
            <th style="border: 1px solid #000;">Keterangan</th>
            <th style="border: 1px solid #000;">Bobot</th>
            <th style="border: 1px solid #000;">Skor</th>
            <th style="border: 1px solid #000;">Nilai</th>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Luaran Wajib</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000; border-right: 1px solid #000;"></th>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">1</td>
            <td style="border: 1px solid #000; padding: 10px;">Satu artikel ilmiah (ICoFA atau ICoSHIP, atau publisher bereputasi lainnya, atau seminar internasional yang lain bila tidak lolos seleksi pada publisher prosiding ICoFA atau ICoSHIP</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai1 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">2</td>
            <td style="border: 1px solid #000; padding: 10px;">Satu artikel di Jurnal Internasional yang terindeks pada database bereputasi; atau di Jurnal Internasional; atau jurnal nasional terakreditasi SINTA 1-2 dengan status minimal terdaftar (submitted)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai2 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">3</td>
            <td style="border: 1px solid #000; padding: 10px;">Satu Paten atau Paten Sederhana atau Perlindungan Varietas Tanaman atau Desain Tata Letak Sirkuit Terpadu atau naskah kebijakan dengan status minimal terdaftar.
        </td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai3 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">4</td>
            <td style="border: 1px solid #000; padding: 10px;">Satu Kekayaan Intelektual berupa Hak Cipta dengan status Granted atas nama Politeknik Negeri Jember</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai4 .'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Luaran Tambahan</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000; border-right: 1px solid #000;"></th>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">1</td>
            <td style="border: 1px solid #000; padding: 10px;">Jurnal Nasional Terakreditasi /Jurnal Internasional / Jurnal Internasional Bereputasi</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan1 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">2</td>
            <td style="border: 1px solid #000; padding: 10px;">HKI berupa Paten, Paten Sederhana, Hak Cipta, Perlindungan Varietas Tanaman, Desain Tata Letak Sirkuit Terpadu, Naskah kebijakan dengan status Terdaftar</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan2 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">3</td>
            <td style="border: 1px solid #000; padding: 10px;">Draft Buku hasil penelitian atau bahan ajar</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan3 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">4</td>
            <td style="border: 1px solid #000; padding: 10px;">Book chapter yang diterbitkan oleh penerbit bereputasi dan ber-ISBN</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan4 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">5</td>
            <td style="border: 1px solid #000; padding: 10px;">Keynote speaker dalam temu ilmiah (internasional, nasional dan lokal)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan5 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">6</td>
            <td style="border: 1px solid #000; padding: 10px;">Pembicara kunci/visiting lecturer (internasional)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan6 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan6 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan6 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan6 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">7</td>
            <td style="border: 1px solid #000; padding: 10px;">Dokumen feasibility study, business plan</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan7 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan7 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan7 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan7 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">8</td>
            <td style="border: 1px solid #000; padding: 10px;">Naskah akademik (policy brief, rekomendasi kebijakan atau model kebijakan strategis)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan8 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan8 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan8 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan8 .'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Jumlah Luaran Wajib</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border: 1px solid #000;">'. $laporan_monev->total_nilai_wajib .'</th>
          </tr>
        </table>
        <div style="text-align: left;">
          <h3 style="margin: 0; padding: 0; margin-top: 30px;">Komentar Penilai :</h3>
          <p style="margin: 0; padding: 0; margin-top: 5px; margin-bottom: 10px; white-space: normal; word-wrap: break-word;word">' . $rekom->masukan_pemonev . '</p>
        </div>

        <div style="float: right; font-size: 14pt;">
          <p>Jember, '. $laporan_monev->updated_at .'</p>
          <p style="margin-bottom: 100px;">Penilai,</p>
          <p style="margin: 0; padding: 0;">'. $nama_pemonev .'</p>
        </div>
        </div>

      </body>
    </html>

    ';
    $this->pdf->createPDF($html, $dt_proposal->nama_ketua . ' - ' . $dt_proposal->judul, false);
    // var_dump($pemonev);
    // print_r($nama_pemonev);
  }

  public function pkln($id, $event)
  {
    $data['idproposal'] = $id;
    $data['idevents'] = $event;
    $id_proposal = $this->pemonev->get_id_proposal($id);
    $kelompok_pengajuan = $this->pemonev->get_kelompok_pengajuan($id_proposal->id_pengajuan_detail);
    $namakelompok = $kelompok_pengajuan->nama_kelompok;
    $laporan_monev = $this->pemonev->get_laporanPemonev($id);
    $dt_proposal = $this->reviewer->get_proposalnya($id_proposal->id_pengajuan_detail);
    $pemonev = $this->pemonev->get_nama_pemonev($id);
    $nama_pemonev = $pemonev->nama;
    // $get_tanggal_pemonev = $this->pemonev->get_tanggal_update_pemonev($id, $dt_proposal->id_pengajuan_detail);
    // $tanggal_pemonev = $get_tanggal_pemonev;
    // $tanggal_monev = (explode(" ", $tanggal_pemonev));

    $rekom = $this->pemonev->get_where('masukan_pemonev', ['id_kerjaan_monev' => $id])->row();

    $this->load->library('pdf');
    $html = '
    <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
      </head>
      <body>
        <!-- KOP Surat -->
        <div>
          <img width="18%" style="float: left;" src="https://i.ibb.co/M64tbjb/Logo-POLIJE-Hitam-Putih.png">
          <div style="text-align: center; border-bottom: 1px solid #000; margin: 0;">
            <h1 style="font-size: 20px; margin: 0; padding: 0;">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN,<br>RISET DAN TEKNOLOGI<br>POLITEKNIK NEGERI JEMBER</h1>
            <h2 style="font-size: 15px; margin: 0; padding: 0;">PUSAT PENELITIAN DAN PENGABDIAN MASYARAKAT</h2>
            <p style="font-size: 14px;">Jl. Mastrip Kotak Pos 164 Jember – 68101 Telp. (0331) 333532-333534 Fax. (0331) 333531<br>e-mail: politeknik@polije.ac.id laman: www.polije.ac.id</p>
          </div>
          <div style="clear:both"></div>
          <hr style="height: 5px; background-color: #000; margin-top: 2px; pading: 0;">
        </div>

        <div style="width: 100%;">
          <h1 style="font-size: 18px; text-align: center;">Borang Monitoring dan Evaluasi '. $namakelompok .'</h1>
        <table style="width: 100%;">
          <tr>
            <td style="width: 30%">Judul Pengabdian</td>
            <td>: '. $dt_proposal->judul .'</td>
          </tr>
          <tr>
            <td>Ketua Tim Pelaksana</td>
            <td>: '. $dt_proposal->nama_ketua .'</td>
          </tr>
          <tr>
            <td>NIDN</td>
            <td>: '. $dt_proposal->nidn_ketua .'</td>
          </tr>
          <tr>
            <td>Skema</td>
            <td>: '. $namakelompok .'</td>
          </tr>
          <tr>
            <td>Jangka Waktu Pelaksanaan</td>
            <td>: '. $dt_proposal->mulai .' S.d. '. $dt_proposal->akhir .'</td>
          </tr>
          <tr>
            <td>Biaya</td>
            <td>: '. rupiah($dt_proposal->biaya_usulan) .'</td>
          </tr>
        </table>

        <table style="width: 100%; border-collapse: collapse; text-align: center;">
          <tr>
            <th style="border: 1px solid #000; padding: 5px;">No</th>
            <th style="border: 1px solid #000; width: 40%;">Komponen Penilaian</th>
            <th style="border: 1px solid #000;">Keterangan</th>
            <th style="border: 1px solid #000;">Bobot</th>
            <th style="border: 1px solid #000;">Skor</th>
            <th style="border: 1px solid #000;">Nilai</th>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Luaran Wajib</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000; border-right: 1px solid #000;"></th>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">1</td>
            <td style="border: 1px solid #000; padding: 10px;">Berupa naskah akademik yang dapat berupa policy brief, rekomendasi kebijakan, atau model kebijakan strategis terhadap suatu permasalahan di unit institusi atau instansi lain.</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai1 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">2</td>
            <td style="border: 1px solid #000; padding: 10px;">Artikel di jurnal internasional yang terindeks pada database minimal Q3 dengan status minimal submitted</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai2 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">3</td>
            <td style="border: 1px solid #000; padding: 10px;">MoU (signed atau rintisan) kerjasama penelitian dengan mitra Luar Negeri</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai3 .'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Luaran Tambahan</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000; border-right: 1px solid #000;"></th>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">1</td>
            <td style="border: 1px solid #000; padding: 10px;">Jurnal Nasional Terakreditasi /Jurnal Internasional / Jurnal Internasional Bereputasi</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan1 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">2</td>
            <td style="border: 1px solid #000; padding: 10px;">HKI berupa Paten, Paten Sederhana, Hak Cipta, Perlindungan Varietas Tanaman, Desain Tata Letak Sirkuit Terpadu, Naskah kebijakan dengan status Terdaftar</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan2 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">3</td>
            <td style="border: 1px solid #000; padding: 10px;">Draft Buku hasil penelitian atau bahan ajar</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan3 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">4</td>
            <td style="border: 1px solid #000; padding: 10px;">Book chapter yang diterbitkan oleh penerbit bereputasi dan ber-ISBN</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan4 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">5</td>
            <td style="border: 1px solid #000; padding: 10px;">Keynote speaker dalam temu ilmiah (internasional, nasional dan lokal)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan5 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">6</td>
            <td style="border: 1px solid #000; padding: 10px;">Pembicara kunci/visiting lecturer (internasional)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan6 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan6 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan6 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan6 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">7</td>
            <td style="border: 1px solid #000; padding: 10px;">Dokumen feasibility study, business plan</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan7 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan7 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan7 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan7 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">8</td>
            <td style="border: 1px solid #000; padding: 10px;">Naskah akademik (policy brief, rekomendasi kebijakan atau model kebijakan strategis)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan8 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan8 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan8 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan8 .'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Jumlah Luaran Wajib</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border: 1px solid #000;">'. $laporan_monev->total_nilai_wajib .'</th>
          </tr>
        </table>
        <div style="text-align: left;">
          <h3 style="margin: 0; padding: 0; margin-top: 30px;">Komentar Penilai :</h3>
          <p style="margin: 0; padding: 0; margin-top: 5px; margin-bottom: 10px; white-space: normal; word-wrap: break-word;word">' . $rekom->masukan_pemonev . '</p>
        </div>

        <div style="float: right; font-size: 14pt;">
          <p>Jember, '. $laporan_monev->updated_at .'</p>
          <p style="margin-bottom: 100px;">Penilai,</p>
          <p style="margin: 0; padding: 0;">'. $nama_pemonev .'</p>
        </div>
        </div>

      </body>
    </html>

    ';
    $this->pdf->createPDF($html, $dt_proposal->nama_ketua . ' - ' . $dt_proposal->judul, false);
    // var_dump($rekom->masukan_pemonev);
    // print_r($nama_pemonev);
  }

  public function ptm($id, $event)
  {
    $data['idproposal'] = $id;
    $data['idevents'] = $event;
    $id_proposal = $this->pemonev->get_id_proposal($id);
    $kelompok_pengajuan = $this->pemonev->get_kelompok_pengajuan($id_proposal->id_pengajuan_detail);
    $namakelompok = $kelompok_pengajuan->nama_kelompok;
    $laporan_monev = $this->pemonev->get_laporanPemonev($id);
    $dt_proposal = $this->reviewer->get_proposalnya($id_proposal->id_pengajuan_detail);
    $pemonev = $this->pemonev->get_nama_pemonev($id);
    $nama_pemonev = $pemonev->nama;
    // $get_tanggal_pemonev = $this->pemonev->get_tanggal_update_pemonev($id, $dt_proposal->id_pengajuan_detail);
    // $tanggal_pemonev = $get_tanggal_pemonev;
    // $tanggal_monev = (explode(" ", $tanggal_pemonev));

    $rekom = $this->pemonev->get_where('masukan_pemonev', ['id_kerjaan_monev' => $id])->row();

    $this->load->library('pdf');
    $html = '
    <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
      </head>
      <body>
        <!-- KOP Surat -->
        <div>
          <img width="18%" style="float: left;" src="https://i.ibb.co/M64tbjb/Logo-POLIJE-Hitam-Putih.png">
          <div style="text-align: center; border-bottom: 1px solid #000; margin: 0;">
            <h1 style="font-size: 20px; margin: 0; padding: 0;">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN,<br>RISET DAN TEKNOLOGI<br>POLITEKNIK NEGERI JEMBER</h1>
            <h2 style="font-size: 15px; margin: 0; padding: 0;">PUSAT PENELITIAN DAN PENGABDIAN MASYARAKAT</h2>
            <p style="font-size: 14px;">Jl. Mastrip Kotak Pos 164 Jember – 68101 Telp. (0331) 333532-333534 Fax. (0331) 333531<br>e-mail: politeknik@polije.ac.id laman: www.polije.ac.id</p>
          </div>
          <div style="clear:both"></div>
          <hr style="height: 5px; background-color: #000; margin-top: 2px; pading: 0;">
        </div>

        <div style="width: 100%;">
          <h1 style="font-size: 18px; text-align: center;">Borang Monitoring dan Evaluasi '. $namakelompok .'</h1>
        <table style="width: 100%;">
          <tr>
            <td style="width: 30%">Judul Pengabdian</td>
            <td>: '. $dt_proposal->judul .'</td>
          </tr>
          <tr>
            <td>Ketua Tim Pelaksana</td>
            <td>: '. $dt_proposal->nama_ketua .'</td>
          </tr>
          <tr>
            <td>NIDN</td>
            <td>: '. $dt_proposal->nidn_ketua .'</td>
          </tr>
          <tr>
            <td>Skema</td>
            <td>: '. $namakelompok .'</td>
          </tr>
          <tr>
            <td>Jangka Waktu Pelaksanaan</td>
            <td>: '. $dt_proposal->mulai .' S.d. '. $dt_proposal->akhir .'</td>
          </tr>
          <tr>
            <td>Biaya</td>
            <td>: '. rupiah($dt_proposal->biaya_usulan) .'</td>
          </tr>
        </table>

        <table style="width: 100%; border-collapse: collapse; text-align: center;">
          <tr>
            <th style="border: 1px solid #000; padding: 5px;">No</th>
            <th style="border: 1px solid #000; width: 40%;">Komponen Penilaian</th>
            <th style="border: 1px solid #000;">Keterangan</th>
            <th style="border: 1px solid #000;">Bobot</th>
            <th style="border: 1px solid #000;">Skor</th>
            <th style="border: 1px solid #000;">Nilai</th>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Luaran Wajib</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000; border-right: 1px solid #000;"></th>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">1</td>
            <td style="border: 1px solid #000; padding: 10px;">Satu artikel ilmiah (ICoFA atau ICoSHIP, atau publisher bereputasi lainnya, atau seminar internasional yang lain bila tidak lolos seleksi pada publisher prosiding ICoFA atau ICoSHIP</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai1 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">2</td>
            <td style="border: 1px solid #000; padding: 10px;">Satu artikel yang dimuat dalam jurnal ilmiah nasional terakreditasi peringkat 1-2 atau satu artikel di jurnal internasional dengan status minimal submitted sebagai penulis pertama adalah mahasiswa yang dibimbing dan ketua peneliti sebagai corresponding author</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai2 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">3</td>
            <td style="border: 1px solid #000; padding: 10px;">Satu artikel jurnal ilmiah nasional terakreditasi peringkat 1-2 / satu artikel di jurnal internasional status submitted sebagai penulis pertama dan  corresponding author adalah ketua peneliti</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai3 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">4</td>
            <td style="border: 1px solid #000; padding: 10px;">Satu Kekayaan Intelektual berupa Hak Cipta dengan status Granted atas nama Politeknik Negeri Jember</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai3 .'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Luaran Tambahan</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000; border-right: 1px solid #000;"></th>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">1</td>
            <td style="border: 1px solid #000; padding: 10px;">Jurnal Nasional Terakreditasi /Jurnal Internasional / Jurnal Internasional Bereputasi</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan1 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">2</td>
            <td style="border: 1px solid #000; padding: 10px;">HKI berupa Paten, Paten Sederhana, Hak Cipta, Perlindungan Varietas Tanaman, Desain Tata Letak Sirkuit Terpadu, Naskah kebijakan dengan status Terdaftar</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan2 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">3</td>
            <td style="border: 1px solid #000; padding: 10px;">Draft Buku hasil penelitian atau bahan ajar</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan3 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">4</td>
            <td style="border: 1px solid #000; padding: 10px;">Book chapter yang diterbitkan oleh penerbit bereputasi dan ber-ISBN</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan4 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">5</td>
            <td style="border: 1px solid #000; padding: 10px;">Keynote speaker dalam temu ilmiah (internasional, nasional dan lokal)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan5 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">6</td>
            <td style="border: 1px solid #000; padding: 10px;">Pembicara kunci/visiting lecturer (internasional)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan6 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan6 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan6 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan6 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">7</td>
            <td style="border: 1px solid #000; padding: 10px;">Dokumen feasibility study, business plan</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan7 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan7 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan7 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan7 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">8</td>
            <td style="border: 1px solid #000; padding: 10px;">Naskah akademik (policy brief, rekomendasi kebijakan atau model kebijakan strategis)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan8 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan8 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan8 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan8 .'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Jumlah Luaran Wajib</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border: 1px solid #000;">'. $laporan_monev->total_nilai_wajib .'</th>
          </tr>
        </table>
        <div style="text-align: left;">
          <h3 style="margin: 0; padding: 0; margin-top: 30px;">Komentar Penilai :</h3>
          <p style="margin: 0; padding: 0; margin-top: 5px; margin-bottom: 10px; white-space: normal; word-wrap: break-word;word">' . $rekom->masukan_pemonev . '</p>
        </div>

        <div style="float: right; font-size: 14pt;">
          <p>Jember, '. $laporan_monev->updated_at .'</p>
          <p style="margin-bottom: 100px;">Penilai,</p>
          <p style="margin: 0; padding: 0;">'. $nama_pemonev .'</p>
        </div>
        </div>

      </body>
    </html>

    ';
    $this->pdf->createPDF($html, $dt_proposal->nama_ketua . ' - ' . $dt_proposal->judul, false);
    // var_dump($rekom->masukan_pemonev);
    // print_r($nama_pemonev);
  }

  public function kks($id, $event)
  {
    $data['idproposal'] = $id;
    $data['idevents'] = $event;
    $id_proposal = $this->pemonev->get_id_proposal($id);
    $kelompok_pengajuan = $this->pemonev->get_kelompok_pengajuan($id_proposal->id_pengajuan_detail);
    $namakelompok = $kelompok_pengajuan->nama_kelompok;
    $laporan_monev = $this->pemonev->get_laporanPemonev($id);
    $dt_proposal = $this->reviewer->get_proposalnya($id_proposal->id_pengajuan_detail);
    $pemonev = $this->pemonev->get_nama_pemonev($id);
    $nama_pemonev = $pemonev->nama;
    // $get_tanggal_pemonev = $this->pemonev->get_tanggal_update_pemonev($id, $dt_proposal->id_pengajuan_detail);
    // $tanggal_pemonev = $get_tanggal_pemonev;
    // $tanggal_monev = (explode(" ", $tanggal_pemonev));

    $rekom = $this->pemonev->get_where('masukan_pemonev', ['id_kerjaan_monev' => $id])->row();

    $this->load->library('pdf');
    $html = '
    <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
      </head>
      <body>
        <!-- KOP Surat -->
        <div>
          <img width="18%" style="float: left;" src="https://i.ibb.co/M64tbjb/Logo-POLIJE-Hitam-Putih.png">
          <div style="text-align: center; border-bottom: 1px solid #000; margin: 0;">
            <h1 style="font-size: 20px; margin: 0; padding: 0;">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN,<br>RISET DAN TEKNOLOGI<br>POLITEKNIK NEGERI JEMBER</h1>
            <h2 style="font-size: 15px; margin: 0; padding: 0;">PUSAT PENELITIAN DAN PENGABDIAN MASYARAKAT</h2>
            <p style="font-size: 14px;">Jl. Mastrip Kotak Pos 164 Jember – 68101 Telp. (0331) 333532-333534 Fax. (0331) 333531<br>e-mail: politeknik@polije.ac.id laman: www.polije.ac.id</p>
          </div>
          <div style="clear:both"></div>
          <hr style="height: 5px; background-color: #000; margin-top: 2px; pading: 0;">
        </div>

        <div style="width: 100%;">
          <h1 style="font-size: 18px; text-align: center;">Borang Monitoring dan Evaluasi '. $namakelompok .'</h1>
        <table style="width: 100%;">
          <tr>
            <td style="width: 30%">Judul Pengabdian</td>
            <td>: '. $dt_proposal->judul .'</td>
          </tr>
          <tr>
            <td>Ketua Tim Pelaksana</td>
            <td>: '. $dt_proposal->nama_ketua .'</td>
          </tr>
          <tr>
            <td>NIDN</td>
            <td>: '. $dt_proposal->nidn_ketua .'</td>
          </tr>
          <tr>
            <td>Skema</td>
            <td>: '. $namakelompok .'</td>
          </tr>
          <tr>
            <td>Jangka Waktu Pelaksanaan</td>
            <td>: '. $dt_proposal->mulai .' S.d. '. $dt_proposal->akhir .'</td>
          </tr>
          <tr>
            <td>Biaya</td>
            <td>: '. rupiah($dt_proposal->biaya_usulan) .'</td>
          </tr>
        </table>

        <table style="width: 100%; border-collapse: collapse; text-align: center;">
          <tr>
            <th style="border: 1px solid #000; padding: 5px;">No</th>
            <th style="border: 1px solid #000; width: 40%;">Komponen Penilaian</th>
            <th style="border: 1px solid #000;">Keterangan</th>
            <th style="border: 1px solid #000;">Bobot</th>
            <th style="border: 1px solid #000;">Skor</th>
            <th style="border: 1px solid #000;">Nilai</th>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Luaran Wajib</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000; border-right: 1px solid #000;"></th>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">1</td>
            <td style="border: 1px solid #000; padding: 10px;">Berupa naskah akademik yang dapat berupa policy brief, rekomendasi kebijakan, atau model kebijakan strategis terhadap suatu permasalahan di unit institusi atau instansi lain.</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai1 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">2</td>
            <td style="border: 1px solid #000; padding: 10px;">Satu artikel ilmiah berupa prosiding dari Seminar Internasional Polije (ICoFA atau ICoSHIP) yang diregistrasi di publisher bereputasi baik Institute of Physics (IOP) atau Atlantis Press(AP), atau publisher bereputasi lainnya, atau seminar internasional yang lain bila tidak lolos seleksi pada publisher prosiding ICoFA atau ICoSHIP
</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai2 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">3</td>
            <td style="border: 1px solid #000; padding: 10px;">Satu Kekayaan Intelektual berupa Hak Cipta dengan status Granted atas nama Politeknik Negeri Jember</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai3 .'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Luaran Tambahan</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000; border-right: 1px solid #000;"></th>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">1</td>
            <td style="border: 1px solid #000; padding: 10px;">Jurnal Nasional Terakreditasi /Jurnal Internasional / Jurnal Internasional Bereputasi</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan1 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">2</td>
            <td style="border: 1px solid #000; padding: 10px;">HKI berupa Paten, Paten Sederhana, Hak Cipta, Perlindungan Varietas Tanaman, Desain Tata Letak Sirkuit Terpadu, Naskah kebijakan dengan status Terdaftar</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan2 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">3</td>
            <td style="border: 1px solid #000; padding: 10px;">Draft Buku hasil penelitian atau bahan ajar</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan3 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">4</td>
            <td style="border: 1px solid #000; padding: 10px;">Book chapter yang diterbitkan oleh penerbit bereputasi dan ber-ISBN</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan4 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">5</td>
            <td style="border: 1px solid #000; padding: 10px;">Keynote speaker dalam temu ilmiah (internasional, nasional dan lokal)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan5 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">6</td>
            <td style="border: 1px solid #000; padding: 10px;">Pembicara kunci/visiting lecturer (internasional)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan6 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan6 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan6 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan6 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">7</td>
            <td style="border: 1px solid #000; padding: 10px;">Dokumen feasibility study, business plan</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan7 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan7 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan7 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan7 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">8</td>
            <td style="border: 1px solid #000; padding: 10px;">Naskah akademik (policy brief, rekomendasi kebijakan atau model kebijakan strategis)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan8 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan8 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan8 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan8 .'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Jumlah Luaran Wajib</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border: 1px solid #000;">'. $laporan_monev->total_nilai_wajib .'</th>
          </tr>
        </table>
        <div style="text-align: left;">
          <h3 style="margin: 0; padding: 0; margin-top: 30px;">Komentar Penilai :</h3>
          <p style="margin: 0; padding: 0; margin-top: 5px; margin-bottom: 10px; white-space: normal; word-wrap: break-word;word">' . $rekom->masukan_pemonev . '</p>
        </div>

        <div style="float: right; font-size: 14pt;">
          <p>Jember, '. $laporan_monev->updated_at .'</p>
          <p style="margin-bottom: 100px;">Penilai,</p>
          <p style="margin: 0; padding: 0;">'. $nama_pemonev .'</p>
        </div>
        </div>

      </body>
    </html>

    ';
    $this->pdf->createPDF($html, $dt_proposal->nama_ketua . ' - ' . $dt_proposal->judul, false);
    // var_dump($rekom->masukan_pemonev);
    // print_r($nama_pemonev);
  }

  public function pdp($id, $event)
  {
    $data['idproposal'] = $id;
    $data['idevents'] = $event;
    $id_proposal = $this->pemonev->get_id_proposal($id);
    $kelompok_pengajuan = $this->pemonev->get_kelompok_pengajuan($id_proposal->id_pengajuan_detail);
    $namakelompok = $kelompok_pengajuan->nama_kelompok;
    $laporan_monev = $this->pemonev->get_laporanPemonev($id);
    $dt_proposal = $this->reviewer->get_proposalnya($id_proposal->id_pengajuan_detail);
    $pemonev = $this->pemonev->get_nama_pemonev($id);
    $nama_pemonev = $pemonev->nama;
    // $get_tanggal_pemonev = $this->pemonev->get_tanggal_update_pemonev($id, $dt_proposal->id_pengajuan_detail);
    // $tanggal_pemonev = $get_tanggal_pemonev;
    // $tanggal_monev = (explode(" ", $tanggal_pemonev));

    $rekom = $this->pemonev->get_where('masukan_pemonev', ['id_kerjaan_monev' => $id])->row();

    $this->load->library('pdf');
    $html = '
    <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
      </head>
      <body>
        <!-- KOP Surat -->
        <div>
          <img width="18%" style="float: left;" src="https://i.ibb.co/M64tbjb/Logo-POLIJE-Hitam-Putih.png">
          <div style="text-align: center; border-bottom: 1px solid #000; margin: 0;">
            <h1 style="font-size: 20px; margin: 0; padding: 0;">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN,<br>RISET DAN TEKNOLOGI<br>POLITEKNIK NEGERI JEMBER</h1>
            <h2 style="font-size: 15px; margin: 0; padding: 0;">PUSAT PENELITIAN DAN PENGABDIAN MASYARAKAT</h2>
            <p style="font-size: 14px;">Jl. Mastrip Kotak Pos 164 Jember – 68101 Telp. (0331) 333532-333534 Fax. (0331) 333531<br>e-mail: politeknik@polije.ac.id laman: www.polije.ac.id</p>
          </div>
          <div style="clear:both"></div>
          <hr style="height: 5px; background-color: #000; margin-top: 2px; pading: 0;">
        </div>

        <div style="width: 100%;">
          <h1 style="font-size: 18px; text-align: center;">Borang Monitoring dan Evaluasi '. $namakelompok .'</h1>
        <table style="width: 100%;">
          <tr>
            <td style="width: 30%">Judul Pengabdian</td>
            <td>: '. $dt_proposal->judul .'</td>
          </tr>
          <tr>
            <td>Ketua Tim Pelaksana</td>
            <td>: '. $dt_proposal->nama_ketua .'</td>
          </tr>
          <tr>
            <td>NIDN</td>
            <td>: '. $dt_proposal->nidn_ketua .'</td>
          </tr>
          <tr>
            <td>Skema</td>
            <td>: '. $namakelompok .'</td>
          </tr>
          <tr>
            <td>Jangka Waktu Pelaksanaan</td>
            <td>: '. $dt_proposal->mulai .' S.d. '. $dt_proposal->akhir .'</td>
          </tr>
          <tr>
            <td>Biaya</td>
            <td>: '. rupiah($dt_proposal->biaya_usulan) .'</td>
          </tr>
        </table>

        <table style="width: 100%; border-collapse: collapse; text-align: center;">
          <tr>
            <th style="border: 1px solid #000; padding: 5px;">No</th>
            <th style="border: 1px solid #000; width: 40%;">Komponen Penilaian</th>
            <th style="border: 1px solid #000;">Keterangan</th>
            <th style="border: 1px solid #000;">Bobot</th>
            <th style="border: 1px solid #000;">Skor</th>
            <th style="border: 1px solid #000;">Nilai</th>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Luaran Wajib</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000; border-right: 1px solid #000;"></th>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">1</td>
            <td style="border: 1px solid #000; padding: 10px;">Satu artikel ilmiah (ICoFA atau ICoSHIP, atau publisher bereputasi lainnya, atau seminar internasional yang lain bila tidak lolos seleksi pada publisher prosiding ICoFA atau ICoSHIP</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai1 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">2</td>
            <td style="border: 1px solid #000; padding: 10px;">Artikel di jurnal nasional terakreditasi minimal SINTA 3 atau 4 dengan status minimal submitted
</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai2 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">3</td>
            <td style="border: 1px solid #000; padding: 10px;">Satu Kekayaan Intelektual berupa Hak Cipta dengan status Granted atas nama Politeknik Negeri Jember</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai3 .'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Luaran Tambahan</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000; border-right: 1px solid #000;"></th>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">1</td>
            <td style="border: 1px solid #000; padding: 10px;">Jurnal Nasional Terakreditasi /Jurnal Internasional / Jurnal Internasional Bereputasi</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan1 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">2</td>
            <td style="border: 1px solid #000; padding: 10px;">HKI berupa Paten, Paten Sederhana, Hak Cipta, Perlindungan Varietas Tanaman, Desain Tata Letak Sirkuit Terpadu, Naskah kebijakan dengan status Terdaftar</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan2 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">3</td>
            <td style="border: 1px solid #000; padding: 10px;">Draft Buku hasil penelitian atau bahan ajar</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan3 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">4</td>
            <td style="border: 1px solid #000; padding: 10px;">Book chapter yang diterbitkan oleh penerbit bereputasi dan ber-ISBN</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan4 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">5</td>
            <td style="border: 1px solid #000; padding: 10px;">Keynote speaker dalam temu ilmiah (internasional, nasional dan lokal)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan5 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">6</td>
            <td style="border: 1px solid #000; padding: 10px;">Pembicara kunci/visiting lecturer (internasional)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan6 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan6 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan6 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan6 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">7</td>
            <td style="border: 1px solid #000; padding: 10px;">Dokumen feasibility study, business plan</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan7 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan7 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan7 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan7 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">8</td>
            <td style="border: 1px solid #000; padding: 10px;">Naskah akademik (policy brief, rekomendasi kebijakan atau model kebijakan strategis)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan8 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan8 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan8 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan8 .'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Jumlah Luaran Wajib</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border: 1px solid #000;">'. $laporan_monev->total_nilai_wajib .'</th>
          </tr>
        </table>
        <div style="text-align: left;">
          <h3 style="margin: 0; padding: 0; margin-top: 30px;">Komentar Penilai :</h3>
          <p style="margin: 0; padding: 0; margin-top: 5px; margin-bottom: 10px; white-space: normal; word-wrap: break-word;word">' . $rekom->masukan_pemonev . '</p>
        </div>

        <div style="float: right; font-size: 14pt;">
          <p>Jember, '. $laporan_monev->updated_at .'</p>
          <p style="margin-bottom: 100px;">Penilai,</p>
          <p style="margin: 0; padding: 0;">'. $nama_pemonev .'</p>
        </div>
        </div>

      </body>
    </html>

    ';
    $this->pdf->createPDF($html, $dt_proposal->nama_ketua . ' - ' . $dt_proposal->judul, false);
    // var_dump($rekom->masukan_pemonev);
    // print_r($nama_pemonev);
  }

  public function pkk($id, $event)
  {
    $data['idproposal'] = $id;
    $data['idevents'] = $event;
    $id_proposal = $this->pemonev->get_id_proposal($id);
    $kelompok_pengajuan = $this->pemonev->get_kelompok_pengajuan($id_proposal->id_pengajuan_detail);
    $namakelompok = $kelompok_pengajuan->nama_kelompok;
    $laporan_monev = $this->pemonev->get_laporanPemonev($id);
    $dt_proposal = $this->reviewer->get_proposalnya($id_proposal->id_pengajuan_detail);
    $pemonev = $this->pemonev->get_nama_pemonev($id);
    $nama_pemonev = $pemonev->nama;
    // $get_tanggal_pemonev = $this->pemonev->get_tanggal_update_pemonev($id, $dt_proposal->id_pengajuan_detail);
    // $tanggal_pemonev = $get_tanggal_pemonev;
    // $tanggal_monev = (explode(" ", $tanggal_pemonev));

    $rekom = $this->pemonev->get_where('masukan_pemonev', ['id_kerjaan_monev' => $id])->row();

    $this->load->library('pdf');
    $html = '
    <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
      </head>
      <body>
        <!-- KOP Surat -->
        <div>
          <img width="18%" style="float: left;" src="https://i.ibb.co/M64tbjb/Logo-POLIJE-Hitam-Putih.png">
          <div style="text-align: center; border-bottom: 1px solid #000; margin: 0;">
            <h1 style="font-size: 20px; margin: 0; padding: 0;">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN,<br>RISET DAN TEKNOLOGI<br>POLITEKNIK NEGERI JEMBER</h1>
            <h2 style="font-size: 15px; margin: 0; padding: 0;">PUSAT PENELITIAN DAN PENGABDIAN MASYARAKAT</h2>
            <p style="font-size: 14px;">Jl. Mastrip Kotak Pos 164 Jember – 68101 Telp. (0331) 333532-333534 Fax. (0331) 333531<br>e-mail: politeknik@polije.ac.id laman: www.polije.ac.id</p>
          </div>
          <div style="clear:both"></div>
          <hr style="height: 5px; background-color: #000; margin-top: 2px; pading: 0;">
        </div>

        <div style="width: 100%;">
          <h1 style="font-size: 18px; text-align: center;">Borang Monitoring dan Evaluasi '. $namakelompok .'</h1>
        <table style="width: 100%;">
          <tr>
            <td style="width: 30%">Judul Pengabdian</td>
            <td>: '. $dt_proposal->judul .'</td>
          </tr>
          <tr>
            <td>Ketua Tim Pelaksana</td>
            <td>: '. $dt_proposal->nama_ketua .'</td>
          </tr>
          <tr>
            <td>NIDN</td>
            <td>: '. $dt_proposal->nidn_ketua .'</td>
          </tr>
          <tr>
            <td>Skema</td>
            <td>: '. $namakelompok .'</td>
          </tr>
          <tr>
            <td>Jangka Waktu Pelaksanaan</td>
            <td>: '. $dt_proposal->mulai .' S.d. '. $dt_proposal->akhir .'</td>
          </tr>
          <tr>
            <td>Biaya</td>
            <td>: '. rupiah($dt_proposal->biaya_usulan) .'</td>
          </tr>
        </table>

        <table style="width: 100%; border-collapse: collapse; text-align: center;">
          <tr>
            <th style="border: 1px solid #000; padding: 5px;">No</th>
            <th style="border: 1px solid #000; width: 40%;">Komponen Penilaian</th>
            <th style="border: 1px solid #000;">Keterangan</th>
            <th style="border: 1px solid #000;">Bobot</th>
            <th style="border: 1px solid #000;">Skor</th>
            <th style="border: 1px solid #000;">Nilai</th>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Luaran Wajib</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000; border-right: 1px solid #000;"></th>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">1</td>
            <td style="border: 1px solid #000; padding: 10px;">Satu artikel ilmiah berupa prosiding dari Seminar Internasional Polije (ICoFA atau ICoSHIP) yang diregistrasi di publisher bereputasi baik Institute of Physics (IOP) atau Atlantis Press (AP), atau publisher bereputasi lainnya, atau seminar internasional yang lain bila tidak lolos seleksi pada publisher prosiding ICoFA atau ICoSHIP</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai1 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">2</td>
            <td style="border: 1px solid #000; padding: 10px;">Satu produk paten sederhana atau paten dengan status terdaftar
</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai2 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">3</td>
            <td style="border: 1px solid #000; padding: 10px;">Satu dokumen kerjasama dengan industri yang menerangkan bahwa teknologi, metode atau ipteks yang diterapkembangkan digunakan oleh industri dalam jangka waktu minimal 1 tahun</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai3 .'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Luaran Tambahan</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000; border-right: 1px solid #000;"></th>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">1</td>
            <td style="border: 1px solid #000; padding: 10px;">Jurnal Nasional Terakreditasi /Jurnal Internasional / Jurnal Internasional Bereputasi</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan1 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">2</td>
            <td style="border: 1px solid #000; padding: 10px;">HKI berupa Paten, Paten Sederhana, Hak Cipta, Perlindungan Varietas Tanaman, Desain Tata Letak Sirkuit Terpadu, Naskah kebijakan dengan status Terdaftar</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan2 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">3</td>
            <td style="border: 1px solid #000; padding: 10px;">Draft Buku hasil penelitian atau bahan ajar</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan3 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">4</td>
            <td style="border: 1px solid #000; padding: 10px;">Book chapter yang diterbitkan oleh penerbit bereputasi dan ber-ISBN</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan4 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">5</td>
            <td style="border: 1px solid #000; padding: 10px;">Keynote speaker dalam temu ilmiah (internasional, nasional dan lokal)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan5 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">6</td>
            <td style="border: 1px solid #000; padding: 10px;">Pembicara kunci/visiting lecturer (internasional)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan6 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan6 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan6 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan6 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">7</td>
            <td style="border: 1px solid #000; padding: 10px;">Dokumen feasibility study, business plan</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan7 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan7 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan7 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan7 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">8</td>
            <td style="border: 1px solid #000; padding: 10px;">Naskah akademik (policy brief, rekomendasi kebijakan atau model kebijakan strategis)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan8 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan8 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan8 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan8 .'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Jumlah Luaran Wajib</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border: 1px solid #000;">'. $laporan_monev->total_nilai_wajib .'</th>
          </tr>
        </table>
        <div style="text-align: left;">
          <h3 style="margin: 0; padding: 0; margin-top: 30px;">Komentar Penilai :</h3>
          <p style="margin: 0; padding: 0; margin-top: 5px; margin-bottom: 10px; white-space: normal; word-wrap: break-word;word">' . $rekom->masukan_pemonev . '</p>
        </div>

        <div style="float: right; font-size: 14pt;">
          <p>Jember, '. $laporan_monev->updated_at .'</p>
          <p style="margin-bottom: 100px;">Penilai,</p>
          <p style="margin: 0; padding: 0;">'. $nama_pemonev .'</p>
        </div>
        </div>

      </body>
    </html>

    ';
    $this->pdf->createPDF($html, $dt_proposal->nama_ketua . ' - ' . $dt_proposal->judul, false);
    // var_dump($rekom->masukan_pemonev);
    // print_r($nama_pemonev);
  }

  public function pengabdian($id, $event)
  {
    $data['idproposal'] = $id;
    $data['idevents'] = $event;
    $id_proposal = $this->pemonev->get_id_proposal($id);
    $kelompok_pengajuan = $this->pemonev->get_kelompok_pengajuan($id_proposal->id_pengajuan_detail);
    $namakelompok = $kelompok_pengajuan->nama_kelompok;
    $laporan_monev = $this->pemonev->get_laporanPemonev($id);
    $dt_proposal = $this->reviewer->get_proposalnya($id_proposal->id_pengajuan_detail);
    $pemonev = $this->pemonev->get_nama_pemonev($id);
    $nama_pemonev = $pemonev->nama;
    // $get_tanggal_pemonev = $this->pemonev->get_tanggal_update_pemonev($id, $dt_proposal->id_pengajuan_detail);
    // $tanggal_pemonev = $get_tanggal_pemonev;
    // $tanggal_monev = (explode(" ", $tanggal_pemonev));

    $rekom = $this->pemonev->get_where('masukan_pemonev', ['id_kerjaan_monev' => $id])->row();

    $this->load->library('pdf');
    $html = '
    <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
      </head>
      <body>
        <!-- KOP Surat -->
        <div>
          <img width="18%" style="float: left;" src="https://i.ibb.co/M64tbjb/Logo-POLIJE-Hitam-Putih.png">
          <div style="text-align: center; border-bottom: 1px solid #000; margin: 0;">
            <h1 style="font-size: 20px; margin: 0; padding: 0;">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN,<br>RISET DAN TEKNOLOGI<br>POLITEKNIK NEGERI JEMBER</h1>
            <h2 style="font-size: 15px; margin: 0; padding: 0;">PUSAT PENELITIAN DAN PENGABDIAN MASYARAKAT</h2>
            <p style="font-size: 14px;">Jl. Mastrip Kotak Pos 164 Jember – 68101 Telp. (0331) 333532-333534 Fax. (0331) 333531<br>e-mail: politeknik@polije.ac.id laman: www.polije.ac.id</p>
          </div>
          <div style="clear:both"></div>
          <hr style="height: 5px; background-color: #000; margin-top: 2px; pading: 0;">
        </div>

        <div style="width: 100%;">
          <h1 style="font-size: 18px; text-align: center;">Borang Monitoring dan Evaluasi '. $namakelompok .'</h1>
        <table style="width: 100%;">
          <tr>
            <td style="width: 30%">Judul Pengabdian</td>
            <td>: '. $dt_proposal->judul .'</td>
          </tr>
          <tr>
            <td>Ketua Tim Pelaksana</td>
            <td>: '. $dt_proposal->nama_ketua .'</td>
          </tr>
          <tr>
            <td>NIDN</td>
            <td>: '. $dt_proposal->nidn_ketua .'</td>
          </tr>
          <tr>
            <td>Skema</td>
            <td>: '. $namakelompok .'</td>
          </tr>
          <tr>
            <td>Jangka Waktu Pelaksanaan</td>
            <td>: '. $dt_proposal->mulai .' S.d. '. $dt_proposal->akhir .'</td>
          </tr>
          <tr>
            <td>Biaya</td>
            <td>: '. rupiah($dt_proposal->biaya_usulan) .'</td>
          </tr>
        </table>

        <table style="width: 100%; border-collapse: collapse; text-align: center;">
          <tr>
            <th style="border: 1px solid #000; padding: 5px;">No</th>
            <th style="border: 1px solid #000; width: 40%;">Komponen Penilaian</th>
            <th style="border: 1px solid #000;">Keterangan</th>
            <th style="border: 1px solid #000;">Bobot</th>
            <th style="border: 1px solid #000;">Skor</th>
            <th style="border: 1px solid #000;">Nilai</th>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Luaran Wajib</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000; border-right: 1px solid #000;"></th>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">1</td>
            <td style="border: 1px solid #000; padding: 10px;">Artikel prosiding ber-ISBN</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai1 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">2</td>
            <td style="border: 1px solid #000; padding: 10px;">Artikel pada media massa cetak/elektronik
</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai2 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">3</td>
            <td style="border: 1px solid #000; padding: 10px;">Video kegiatan</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor3 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai3 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">4</td>
            <td style="border: 1px solid #000; padding: 10px;">HKI (Hak Cipta)</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan4 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot4 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor4 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai4 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">5</td>
            <td style="border: 1px solid #000; padding: 10px;">Peningkatan Level Keberdayaan Mitra</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan5 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot5 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor5 .'</td>
        <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai5 .'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Luaran Tambahan</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000; border-right: 1px solid #000;"></th>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">1</td>
            <td style="border: 1px solid #000; padding: 10px;">Artikel jurnal pengabdian masyarakat</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan1 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan1 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">2</td>
            <td style="border: 1px solid #000; padding: 10px;">Buku ber ISBN</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan2 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan2 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">3</td>
            <td style="border: 1px solid #000; padding: 10px;">Bahan ajar</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan3 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan3 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">4</td>
            <td style="border: 1px solid #000; padding: 10px;">Metode atau sistem; Produk (Barang atau Jasa)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan4 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan4 .'</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000;">5</td>
            <td style="border: 1px solid #000; padding: 10px;">Perbaikan tata nilai masyarakat (seni budaya, sosial, politik, keamanan, ketenteraman, pendidikan, kesehatan)</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_keterangan_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_bobot_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_skor_tambahan5 .'</td>
            <td style="border: 1px solid #000;">'. $laporan_monev->komponen_nilai_tambahan5 .'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #000;"></th>
            <th style="border: 1px solid #000; border-right: 0; padding: 5px;">Jumlah Luaran Wajib</th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border-bottom: 1px solid #000;"></th>
            <th style="border: 1px solid #000;">'. $laporan_monev->total_nilai_wajib .'</th>
          </tr>
        </table>
        <div style="text-align: left;">
          <h3 style="margin: 0; padding: 0; margin-top: 30px;">Komentar Penilai :</h3>
          <p style="margin: 0; padding: 0; margin-top: 5px; margin-bottom: 10px; white-space: normal; word-wrap: break-word;word">' . $rekom->masukan_pemonev . '</p>
        </div>

        <div style="float: right; font-size: 14pt;">
          <p>Jember, '. $laporan_monev->updated_at .'</p>
          <p style="margin-bottom: 100px;">Penilai,</p>
          <p style="margin: 0; padding: 0;">'. $nama_pemonev .'</p>
        </div>
        </div>

      </body>
    </html>

    ';
    $this->pdf->createPDF($html, $dt_proposal->nama_ketua . ' - ' . $dt_proposal->judul, false);
    // var_dump($rekom->masukan_pemonev);
    // print_r($nama_pemonev);
  }
}
?>
