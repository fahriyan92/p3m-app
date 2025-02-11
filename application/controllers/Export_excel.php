<?php
defined('BASEPATH') or exit('No direct script access allowed');

// require('./excel/vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Export_excel extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    // if (!$this->session->userdata('login') == true) {
    //   redirect('');
    // }
  }

  public function export_pnbp()
  {
    $this->load->model('M_reviewer', 'reviewer');
    $get = $this->input->get();
    $event = ['PENELITIAN_DOSEN' => 1, 'PENGABDIAN_DOSEN' => 2, 'PENElITIAN_PLP' => 5];
    $get_id = $get['id_event'];
    $id = $event[$get_id];

    $judul = ['', 'PENELITIAN DOSEN', 'PENGABDIAN', '', '', 'PENELITIAN PLP'];
    $judul_atas = 'LAPORAN ' . $judul[$id] . ' DANA PNBP';

    $tahun = date('Y');
    $skema = "ALL";
    $fokus = "ALL";

    if (isset($get['skema'])) {
      if ($get['skema'] != "") {
        $skema = $get['skema'];
        $get_skema_name = $this->db->query("select nama_kelompok from tb_kelompok_pengajuan where id_kelompok_pengajuan = " . $get['skema'])->row();
        if ($get_skema_name != null) {
          $judul_atas = $judul_atas . " SKEMA " . strtoupper($get_skema_name->nama_kelompok);
        }
      }
    }
    if (isset($get['fokus'])) {
      if ($get['fokus'] != "") {
        $fokus = $get['fokus'];
        $get_fokus_name = $this->db->query("select bidang_fokus from tb_fokus where id_fokus = " . $get['fokus'])->row();
        if ($get_fokus_name != null) {
          $judul_atas =  $judul_atas . " ,BIDANG FOKUS " . strtoupper($get_fokus_name->bidang_fokus);
        }
      }
    }

    if (isset($get['tahun'])) {
      if ($get['tahun'] != "") {
        $tahun = $get['tahun'];
      }
    }

    $data = $this->reviewer->get_tahun_proposal($id, $tahun, $skema, $fokus)->result();
    if ($data == null) {
      echo "tidak ada data untuk di eksport";
      return;
    }

    //load templates
    $reader = new PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    $path = realpath(APPPATH . '../assets/berkas/');
    $filenya = $reader->load($path . '/template_laporan.xlsx');


    // $spreadsheet = new Spreadsheet($filenya);


    $filenya->setActiveSheetIndex(0)
      ->setCellValue('B6', $judul_atas)
      ->setCellValue('B7', 'TAHUN ' . $tahun);



    $nomer = 1;
    $a = 11;

    foreach ($data as $value) {
      $data_anggota = $this->db->query('select b.nama, b.pangkat, b.nip from tb_anggota_dosen a, dummy_dosen b  where a.nidn = b.nidn AND a.id_pengajuan_detail =' . $value->id_pengajuan_detail . ' AND a.nidn != "' . $value->nidn_ketua . '"')->result();
      $created = "-";
      $updated = "-";

      if ($value->created_at != "" || $value->created_at != null) {
        $created = date('j F Y H:i:s', strtotime($value->created_at));
      }

      if ($value->updated_at != "" || $value->updated_at != null) {
        $updated = date('j F Y H:i:s', strtotime($value->updated_at));
      }


      $count_anggota = count($data_anggota);
      $filenya->setActiveSheetIndex(0)->insertNewRowBefore($a + 1, $count_anggota);
      $filenya->setActiveSheetIndex(0)
        ->setCellValue('A' . $a, $nomer . '.')
        ->setCellValue('B' . $a, $value->nama . ' - ' . $value->nip)
        ->setCellValue('C' . $a, $value->pangkat)
        ->setCellValue('F' . $a, $value->judul)
        ->setCellValue('G' . $a, $value->nama_kelompok)
        ->setCellValue('H' . $a, $created)
        ->setCellValue('I' . $a, $updated);

      if ($count_anggota > 1) {
        $merge = ($a + $count_anggota) - 1;
        $filenya->setActiveSheetIndex(0)
          ->mergeCells('A' . $a . ':A' . $merge)
          ->mergeCells('B' . $a . ':B' . $merge)
          ->mergeCells('C' . $a . ':C' . $merge)
          ->mergeCells('F' . $a . ':F' . $merge)
          ->mergeCells('G' . $a . ':G' . $merge)
          ->mergeCells('H' . $a . ':H' . $merge)
          ->mergeCells('I' . $a . ':I' . $merge);
      }

      $row_anggota = $a;
      foreach ($data_anggota as $dt) {
        $filenya->setActiveSheetIndex(0)->setCellValue('D' . $row_anggota, $dt->nama  . ' - ' . $dt->nip)
                                        ->setCellValue('E' . $row_anggota, $dt->pangkat);
        $row_anggota++;
      }
      $nomer++;

      if ($count_anggota > 1 ) {
        $a += $count_anggota;
        continue;
      }
      $a++;
    }
    $filenya->getActiveSheet()->removeRow($a + 1);

    $nama_file = $judul[$id] . ' DANA PNBP ' . $tahun;

    $filenya->getProperties()->setCreator('P3M')
      ->setTitle($nama_file);

    $writer = new Xlsx($filenya);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $nama_file . '.xlsx"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    $writer->save('php://output');
    // header("Content-Disposition: attachment; filename=ngakak bang");
    // header("Content-Type: application/vnd.ms-excel;");
    // header("Cache-Control: max-age=0");
    // $filenya->save('php://output');


    //     $spreadsheet->getProperties()->setCreator('P3M')
    //     ->setLastModifiedBy('Andoyo - Java Web Medi')
    //     ->setTitle('Office 2007 XLSX Test Document')
    //     ->setSubject('Office 2007 XLSX Test Document')
    //     ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
    //     ->setKeywords('office 2007 openxml php')
    //     ->setCategory('Test result file');

    //     $spreadsheet->setActiveSheetIndex(0)
    //       ->setCellValue('A1', 'KETUA')
    //       ->setCellValue('B1', 'SKEMA')
    //       ->setCellValue('C1', 'JUDUL')
    // ;
  }

  public function export_pnbp_pemonev()
  {
    $this->load->model('M_reviewer', 'reviewer');
    $this->load->model('M_Pemonev', 'pemonev');
    $get = $this->input->get();
    $event = ['PENELITIAN_DOSEN' => 1, 'PENGABDIAN_DOSEN' => 2, 'PENElITIAN_PLP' => 5];
    $get_id = $get['id_event'];
    $id = $event[$get_id];

    $judul = ['', 'PENELITIAN DOSEN', 'PENGABDIAN', '', '', 'PENELITIAN PLP'];
    $judul_atas = 'LAPORAN ' . $judul[$id] . ' MONEV PNBP';

    $tahun = date('Y');
    $skema = "ALL";
    $fokus = "ALL";

    if (isset($get['skema'])) {
      if ($get['skema'] != "") {
        $skema = $get['skema'];
        $get_skema_name = $this->db->query("select nama_kelompok from tb_kelompok_pengajuan where id_kelompok_pengajuan = " . $get['skema'])->row();
        if ($get_skema_name != null) {
          $judul_atas = $judul_atas . " SKEMA " . strtoupper($get_skema_name->nama_kelompok);
        }
      }
    }
    if (isset($get['fokus'])) {
      if ($get['fokus'] != "") {
        $fokus = $get['fokus'];
        $get_fokus_name = $this->db->query("select bidang_fokus from tb_fokus where id_fokus = " . $get['fokus'])->row();
        if ($get_fokus_name != null) {
          $judul_atas =  $judul_atas . " ,BIDANG FOKUS " . strtoupper($get_fokus_name->bidang_fokus);
        }
      }
    }

    if (isset($get['tahun'])) {
      if ($get['tahun'] != "") {
        $tahun = $get['tahun'];
      }
    }

    $data = $this->pemonev->get_tahun_proposal($id, $tahun, $skema, $fokus)->result();
    if ($data == null) {
      echo "tidak ada data untuk di eksport";
      return;
    }



    //load templates
    $reader = new PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    $path = realpath(APPPATH . '../assets/berkas/');
    $filenya = $reader->load($path . '/template_laporan.xlsx');


    // $spreadsheet = new Spreadsheet($filenya);


    $filenya->setActiveSheetIndex(0)
      ->setCellValue('B6', $judul_atas)
      ->setCellValue('B7', 'TAHUN ' . $tahun);



    $nomer = 1;
    $a = 11;

    foreach ($data as $value) {
      $data_anggota = $this->db->query('select b.nama, b.pangkat, b.nip from tb_anggota_dosen a, dummy_dosen b  where a.nidn = b.nidn AND a.id_pengajuan_detail =' . $value->id_pengajuan_detail . ' AND a.nidn != "' . $value->nidn_ketua . '"')->result();
      $created = "-";
      $updated = "-";

      if ($value->created_at != "" || $value->created_at != null) {
        $created = date('j F Y H:i:s', strtotime($value->created_at));
      }

      if ($value->updated_at != "" || $value->updated_at != null) {
        $updated = date('j F Y H:i:s', strtotime($value->updated_at));
      }


      
      $count_anggota = count($data_anggota);
      $filenya->setActiveSheetIndex(0)->insertNewRowBefore($a + 1, $count_anggota);
      $filenya->setActiveSheetIndex(0)
        ->setCellValue('A' . $a, $nomer . '.')
        ->setCellValue('B' . $a, $value->nama . ' - ' . $value->nip)
        ->setCellValue('C' . $a, $value->pangkat)
        ->setCellValue('F' . $a, $value->judul)
        ->setCellValue('G' . $a, $value->nama_kelompok)
        ->setCellValue('H' . $a, $created)
        ->setCellValue('I' . $a, $updated);

      if ($count_anggota > 1) {
        $merge = ($a + $count_anggota) - 1;
        $filenya->setActiveSheetIndex(0)
          ->mergeCells('A' . $a . ':A' . $merge)
          ->mergeCells('B' . $a . ':B' . $merge)
          ->mergeCells('C' . $a . ':C' . $merge)
          ->mergeCells('F' . $a . ':F' . $merge)
          ->mergeCells('G' . $a . ':G' . $merge)
          ->mergeCells('H' . $a . ':H' . $merge)
          ->mergeCells('I' . $a . ':I' . $merge);
      }

      $row_anggota = $a;
      foreach ($data_anggota as $dt) {
        $filenya->setActiveSheetIndex(0)->setCellValue('D' . $row_anggota, $dt->nama . ' - ' . $dt->nip)
                                        ->setCellValue('E' . $row_anggota, $dt->pangkat);
        $row_anggota++;
      }

      // $count_anggota = count($data_anggota);
      // $filenya->setActiveSheetIndex(0)->insertNewRowBefore($a + 1, $count_anggota);
      // $filenya->setActiveSheetIndex(0)
      //   ->setCellValue('A' . $a, $nomer . '.')
      //   ->setCellValue('B' . $a, $value->nama)
      //   ->setCellValue('E' . $a, $value->judul)
      //   ->setCellValue('F' . $a, $value->nama_kelompok)
      //   ->setCellValue('G' . $a, $created)
      //   ->setCellValue('H' . $a, $updated);

      // if ($count_anggota > 1) {
      //   $merge = ($a + $count_anggota) - 1;
      //   $filenya->setActiveSheetIndex(0)
      //     ->mergeCells('A' . $a . ':A' . $merge)
      //     ->mergeCells('B' . $a . ':B' . $merge)
      //     ->mergeCells('D' . $a . ':D' . $merge)
      //     ->mergeCells('E' . $a . ':E' . $merge)
      //     ->mergeCells('F' . $a . ':F' . $merge)
      //     ->mergeCells('G' . $a . ':G' . $merge);
      // }

      // $row_anggota = $a;
      // foreach ($data_anggota as $dt) {
      //   $filenya->setActiveSheetIndex(0)->setCellValue('C' . $row_anggota, $dt->nama);
      //   $row_anggota++;
      // }

      $nomer++;
      if ($count_anggota > 1) {
        $a += $count_anggota;
        continue;
      }
      $a++;
    }
    $filenya->getActiveSheet()->removeRow($a + 1);

    $nama_file = $judul[$id] . ' MONEV PNBP ' . $tahun;

    $filenya->getProperties()->setCreator('P3M')
      ->setTitle($nama_file);

    $writer = new Xlsx($filenya);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $nama_file . '.xlsx"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    $writer->save('php://output');
    // header("Content-Disposition: attachment; filename=ngakak bang");
    // header("Content-Type: application/vnd.ms-excel;");
    // header("Cache-Control: max-age=0");
    // $filenya->save('php://output');


    //     $spreadsheet->getProperties()->setCreator('P3M')
    //     ->setLastModifiedBy('Andoyo - Java Web Medi')
    //     ->setTitle('Office 2007 XLSX Test Document')
    //     ->setSubject('Office 2007 XLSX Test Document')
    //     ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
    //     ->setKeywords('office 2007 openxml php')
    //     ->setCategory('Test result file');

    //     $spreadsheet->setActiveSheetIndex(0)
    //       ->setCellValue('A1', 'KETUA')
    //       ->setCellValue('B1', 'SKEMA')
    //       ->setCellValue('C1', 'JUDUL')
    // ;
  }

  public function export_rekap()
  {
    $this->load->model('M_reviewer', 'reviewer');
    $get = $this->input->get();
    $event = ['PENELITIAN_DOSEN' => 1, 'PENGABDIAN_DOSEN' => 2, 'PENElITIAN_PLP' => 5];
    $get_id = $get['id_event'];
    $id = $event[$get_id];

    $judul = ['', 'PENELITIAN DOSEN', 'PENGABDIAN', '', '', 'PENELITIAN PLP'];
    $judul_atas = 'REKAP ' . $judul[$id] . ' DANA PNBP';

    $tahun = date('Y');
    $skema = "ALL";
    $fokus = "ALL";

    if (isset($get['skema'])) {
      if ($get['skema'] != "") {
        $skema = $get['skema'];
        $get_skema_name = $this->db->query("select nama_kelompok from tb_kelompok_pengajuan where id_kelompok_pengajuan = " . $get['skema'])->row();
        if ($get_skema_name != null) {
          $judul_atas = $judul_atas . " SKEMA " . strtoupper($get_skema_name->nama_kelompok);
        }
      }
    }
    if (isset($get['fokus'])) {
      if ($get['fokus'] != "") {
        $fokus = $get['fokus'];
        $get_fokus_name = $this->db->query("select bidang_fokus from tb_fokus where id_fokus = " . $get['fokus'])->row();
        if ($get_fokus_name != null) {
          $judul_atas =  $judul_atas . " ,BIDANG FOKUS " . strtoupper($get_fokus_name->bidang_fokus);
        }
      }
    }

    if (isset($get['tahun'])) {
      if ($get['tahun'] != "") {
        $tahun = $get['tahun'];
      }
    }

    $data = $this->reviewer->get_tahun_proposal($id, $tahun, $skema, $fokus)->result();
    if ($data == null) {
      echo "tidak ada data untuk di eksport";
      return;
    }

    //load templates
    $reader = new PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    $path = realpath(APPPATH . '../assets/berkas/');
    $filenya = $reader->load($path . '/template_laporan.xlsx');


    // $spreadsheet = new Spreadsheet($filenya);


    $filenya->setActiveSheetIndex(0)
      ->setCellValue('B6', $judul_atas)
      ->setCellValue('B7', 'TAHUN ' . $tahun);



    $nomer = 1;
    $a = 11;

    foreach ($data as $value) {
      $data_anggota = $this->db->query('select b.nama, b.pangkat, b.nip from tb_anggota_dosen a, dummy_dosen b  where a.nidn = b.nidn AND a.id_pengajuan_detail =' . $value->id_pengajuan_detail . ' AND a.nidn != "' . $value->nidn_ketua . '"')->result();
      $created = "-";
      $updated = "-";

      if ($value->created_at != "" || $value->created_at != null) {
        $created = date('j F Y H:i:s', strtotime($value->created_at));
      }

      if ($value->updated_at != "" || $value->updated_at != null) {
        $updated = date('j F Y H:i:s', strtotime($value->updated_at));
      }

      
      $count_anggota = count($data_anggota);
      $filenya->setActiveSheetIndex(0)->insertNewRowBefore($a + 1, $count_anggota);
      $filenya->setActiveSheetIndex(0)
        ->setCellValue('A' . $a, $nomer . '.')
        ->setCellValue('B' . $a, $value->nama . ' - ' . $value->nama)
        ->setCellValue('C' . $a, $value->pangkat)
        ->setCellValue('F' . $a, $value->judul)
        ->setCellValue('G' . $a, $value->nama_kelompok)
        ->setCellValue('H' . $a, $created)
        ->setCellValue('I' . $a, $updated);

      if ($count_anggota > 1) {
        $merge = ($a + $count_anggota) - 1;
        $filenya->setActiveSheetIndex(0)
          ->mergeCells('A' . $a . ':A' . $merge)
          ->mergeCells('B' . $a . ':B' . $merge)
          ->mergeCells('C' . $a . ':C' . $merge)
          ->mergeCells('F' . $a . ':F' . $merge)
          ->mergeCells('G' . $a . ':G' . $merge)
          ->mergeCells('H' . $a . ':H' . $merge)
          ->mergeCells('I' . $a . ':I' . $merge);
      }

      $row_anggota = $a;
      foreach ($data_anggota as $dt) {
        $filenya->setActiveSheetIndex(0)->setCellValue('D' . $row_anggota, $dt->nama . ' - ' . $dt->nip)
                                        ->setCellValue('E' . $row_anggota, $dt->pangkat);
        $row_anggota++;
      }


      // $count_anggota = count($data_anggota);
      // $filenya->setActiveSheetIndex(0)->insertNewRowBefore($a + 1, $count_anggota);
      // $filenya->setActiveSheetIndex(0)
      //   ->setCellValue('A' . $a, $nomer . '.')
      //   ->setCellValue('B' . $a, $value->nama)
      //   ->setCellValue('D' . $a, $value->judul)
      //   ->setCellValue('E' . $a, $value->nama_kelompok)
      //   ->setCellValue('F' . $a, $created)
      //   ->setCellValue('G' . $a, $updated);

      // if ($count_anggota > 1) {
      //   $merge = ($a + $count_anggota) - 1;
      //   $filenya->setActiveSheetIndex(0)
      //     ->mergeCells('A' . $a . ':A' . $merge)
      //     ->mergeCells('B' . $a . ':B' . $merge)
      //     ->mergeCells('D' . $a . ':D' . $merge)
      //     ->mergeCells('E' . $a . ':E' . $merge)
      //     ->mergeCells('F' . $a . ':F' . $merge)
      //     ->mergeCells('G' . $a . ':G' . $merge);
      // }
      // $filenya->getActiveSheet()->removeRow($a);

      // $row_anggota = $a;
      // foreach ($data_anggota as $dt) {
      //   $filenya->setActiveSheetIndex(0)->setCellValue('C' . $row_anggota, $dt->nama);
      //   $row_anggota++;
      // }


      $nomer++;
      if ($count_anggota > 1) {
        $a += $count_anggota;
        continue;
      }
      $a++;
    }
    $filenya->getActiveSheet()->removeRow($a + 1);

    $nama_file = $judul[$id] . ' DANA PNBP ' . $tahun;

    $filenya->getProperties()->setCreator('P3M')
      ->setTitle($nama_file);

    $writer = new Xlsx($filenya);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $nama_file . '.xlsx"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    $writer->save('php://output');
  }


  // ini beda
  public function export_laporan_akhir()
  {
    $tahun = date('Y');
    $this->load->model('M_laporan', 'laporan');
    $get = $this->input->get();
    $event = ['PENELITIAN_DOSEN' => 1, 'PENGABDIAN_DOSEN' => 2, 'PENElITIAN_PLP' => 5];
    $get_id = $get['id_event'];
    $id = $event[$get_id];

    $judul = ['', 'PENELITIAN DOSEN', 'PENGABDIAN', '', '', 'PENELITIAN PLP'];


    // $status = ['BELUM_DIPROSES' => NULL, 'DIDANAI' => 1, 'TIDAK_DIDANAI' => 2 ,'TIDAK_LOLOS_ADMINISTRASI' => 4 ];

    $_status = ['LOLOS_PENDANAAN' => 1, 'TIDAK_LOLOS_PENDANAAN' => 2, 'TIDAK_LOLOS_ADMINISTRASI' => 4, 'BELUM_DIPROSES' => NULL];

    $skema = "ALL";

    if (isset($get['tahun'])) {
      if ($get['tahun'] !== NULL) {
        $tahun = $get['tahun'];
      }
    }

    $input_keys = array_keys($_status);

    //load templates
    $reader = new PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    $path = realpath(APPPATH . '../assets/berkas/');
    $filenya = $reader->load($path . '/template_laporan.xlsx');



    $ada_ga = [];
    $sheet = [];
    for ($i = 0; $i < count($input_keys); $i++) {
      $judul_atas = 'LAPORAN ' . $judul[$id] . ' DANA PNBP';
      $nama_sheet = str_replace("_", " ", $input_keys[$i]);
      $judul_atas .= " " . $nama_sheet;
      $sheet[$i]['status'] = $_status[$input_keys[$i]];
      if ($i == 0) {
        $filenya->setActiveSheetIndex($i)->setTitle($nama_sheet);
        $filenya->getActiveSheet()
          ->setCellValue('B6', $judul_atas)
          ->setCellValue('B7', 'TAHUN ' . $tahun);
        continue;
      }

      //clonse sheet
      $newFile = $filenya->getActiveSheet()->copy();
      $newFile->setTitle($nama_sheet);


      $newFile->setCellValue('B6', $judul_atas)
        ->setCellValue('B7', 'TAHUN ' . $tahun);

      $filenya->addSheet($newFile);
    }

    $data = [];

    for ($i = 0; $i < count($sheet); $i++) {
      $statusnya = $sheet[$i]['status'];
      $datanya = $this->laporan->get_all_akhir($tahun, $skema, $id, $statusnya)->result();
      $nomer = 1;
      $a = 11;

      if ($datanya == null) {
        $filenya->setActiveSheetIndex($i)->setCellValue('A11', "Tidak ada Data");
        $filenya->setActiveSheetIndex($i)
          ->mergeCells('A11:G11');
        continue;
      }

      foreach ($datanya as $value) {
        $data_anggota = $this->db->query('select b.nama, b.pangkat, b.nip from tb_anggota_dosen a, dummy_dosen b  where a.nidn = b.nidn AND a.id_pengajuan_detail =' . $value->id_pengajuan_detail . ' AND a.nidn != "' . $value->nidn_ketua . '"')->result();
        $created = "-";
        $updated = "-";

        if ($value->created_at != "" || $value->created_at != null) {
          $created = date('j F Y H:i:s', strtotime($value->created_at));
        }

        if ($value->updated_at != "" || $value->updated_at != null) {
          $updated = date('j F Y H:i:s', strtotime($value->updated_at));
        }


        $count_anggota = count($data_anggota);
        $filenya->setActiveSheetIndex(0)->insertNewRowBefore($a + 1, $count_anggota);
        $filenya->setActiveSheetIndex(0)
          ->setCellValue('A' . $a, $nomer . '.')
          ->setCellValue('B' . $a, $value->nama . ' - ' . $value->nip)
          ->setCellValue('C' . $a, $value->pangkat)
          ->setCellValue('F' . $a, $value->judul)
          ->setCellValue('G' . $a, $value->nama_kelompok)
          ->setCellValue('H' . $a, $created)
          ->setCellValue('I' . $a, $updated);
  
        if ($count_anggota > 1) {
          $merge = ($a + $count_anggota) - 1;
          $filenya->setActiveSheetIndex(0)
            ->mergeCells('A' . $a . ':A' . $merge)
            ->mergeCells('B' . $a . ':B' . $merge)
            ->mergeCells('C' . $a . ':C' . $merge)
            ->mergeCells('F' . $a . ':F' . $merge)
            ->mergeCells('G' . $a . ':G' . $merge)
            ->mergeCells('H' . $a . ':H' . $merge)
            ->mergeCells('I' . $a . ':I' . $merge);
        }
  
        $row_anggota = $a;
        foreach ($data_anggota as $dt) {
          $filenya->setActiveSheetIndex(0)->setCellValue('D' . $row_anggota, $dt->nama  . ' - ' . $dt->nip)
                                          ->setCellValue('E' . $row_anggota, $dt->pangkat);
          $row_anggota++;
        }
        $nomer++;
  
        if ($count_anggota > 1 ) {
          $a += $count_anggota;
          continue;
        }
        $a++;

        // start kodingan lama
        // $count_anggota = count($data_anggota);
        // $filenya->setActiveSheetIndex($i)->insertNewRowBefore($a + 1, $count_anggota);
        // $filenya->setActiveSheetIndex($i)
        //   ->setCellValue('A' . $a, $nomer . '.')
        //   ->setCellValue('B' . $a, $value->nama)
        //   ->setCellValue('E' . $a, $value->judul)
        //   ->setCellValue('F' . $a, $value->nama_kelompok)
        //   ->setCellValue('G' . $a, $created)
        //   ->setCellValue('H' . $a, $updated);

        // if($count_anggota > 1){
        //   $merge = ($a+$count_anggota) - 1;
        //   $filenya->setActiveSheetIndex($i)
        //   ->mergeCells('A'.$a.':A'.$merge)
        //   ->mergeCells('B'.$a.':B'.$merge)
        //   ->mergeCells('D'.$a.':D'.$merge)
        //   ->mergeCells('E'.$a.':E'.$merge)
        //   ->mergeCells('F'.$a.':F'.$merge)
        //   ->mergeCells('G'.$a.':G'.$merge);
        // }
        // $alphabet = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

        // $abjadke = 2;
        // foreach ($data_anggota as $dt) {
        //   $filenya->setActiveSheetIndex($i)->setCellValue($alphabet[$abjadke] . $a, $dt->nama);
        //   $abjadke++;
        // }
        // $nomer++;
        // if ($count_anggota > 1) {
        //   $a += $count_anggota;
        //   continue;
        // }
        // $a++;
        // end kodingan lama
      }
      $filenya->getActiveSheet()->removeRow($a);
    }
    $filenya->setActiveSheetIndex(0);
    $nama_file = "REPORT AKHIR " . $judul[$id] . ' DANA PNBP ' . $tahun;

    $filenya->getProperties()->setCreator('P3M')
      ->setTitle($nama_file);

    $writer = new Xlsx($filenya);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $nama_file . '.xlsx"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    $writer->save('php://output');
  }

  public function export_laporan_akhir_pemonev()
  {
    $tahun = date('Y');
    $this->load->model('M_laporan', 'laporan');
    $this->load->model('M_Pemonev', 'pemonev');
    $get = $this->input->get();
    $event = ['PENELITIAN_DOSEN' => 1, 'PENGABDIAN_DOSEN' => 2, 'PENElITIAN_PLP' => 5];
    $get_id = $get['id_event'];
    $id = $event[$get_id];

    $judul = ['', 'PENELITIAN DOSEN', 'PENGABDIAN', '', '', 'PENELITIAN PLP'];


    // $status = ['BELUM_DIPROSES' => NULL, 'DIDANAI' => 1, 'TIDAK_DIDANAI' => 2 ,'TIDAK_LOLOS_ADMINISTRASI' => 4 ];

    $_status = ['Sheet1' => 6];

    $skema = "ALL";

    if (isset($get['tahun'])) {
      if ($get['tahun'] !== NULL) {
        $tahun = $get['tahun'];
      }
    }

    $input_keys = array_keys($_status);

    //load templates
    $reader = new PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    $path = realpath(APPPATH . '../assets/berkas/');
    $filenya = $reader->load($path . '/template_laporan.xlsx');



    $ada_ga = [];
    $sheet = [];
    for ($i = 0; $i < count($input_keys); $i++) {
      $judul_atas = 'LAPORAN ' . $judul[$id] . ' MONEV DANA PNBP';
      $nama_sheet = str_replace("_", " ", $input_keys[$i]);
      $judul_atas .= " " . $nama_sheet;
      $sheet[$i]['status'] = $_status[$input_keys[$i]];
      if ($i == 0) {
        $filenya->setActiveSheetIndex($i)->setTitle($nama_sheet);
        $filenya->getActiveSheet()
          ->setCellValue('B6', $judul_atas)
          ->setCellValue('B7', 'TAHUN ' . $tahun);
        continue;
      }

      //clonse sheet
      $newFile = $filenya->getActiveSheet()->copy();
      $newFile->setTitle($nama_sheet);


      $newFile->setCellValue('B6', $judul_atas)
        ->setCellValue('B7', 'TAHUN ' . $tahun);

      $filenya->addSheet($newFile);
    }

    $data = [];

    for ($i = 0; $i < count($sheet); $i++) {
      $statusnya = $sheet[$i]['status'];
      $datanya = $this->pemonev->get_all_akhir($tahun, $skema, $id, $statusnya)->result();
      $nomer = 1;
      $a = 11;

      if ($datanya == null) {
        $filenya->setActiveSheetIndex($i)->setCellValue('A11', "Tidak ada Data");
        $filenya->setActiveSheetIndex($i)
          ->mergeCells('A11:G11');
        continue;
      }

      foreach ($datanya as $value) {
        $data_anggota = $this->db->query('select b.nama, b.pangkat, b.nip from tb_anggota_dosen a, dummy_dosen b  where a.nidn = b.nidn AND a.id_pengajuan_detail =' . $value->id_pengajuan_detail . ' AND a.nidn != "' . $value->nidn_ketua . '"')->result();
        $created = "-";
        $updated = "-";

        if ($value->created_at != "" || $value->created_at != null) {
          $created = date('j F Y H:i:s', strtotime($value->created_at));
        }

        if ($value->updated_at != "" || $value->updated_at != null) {
          $updated = date('j F Y H:i:s', strtotime($value->updated_at));
        }

        
      $count_anggota = count($data_anggota);
      $filenya->setActiveSheetIndex(0)->insertNewRowBefore($a + 1, $count_anggota);
      $filenya->setActiveSheetIndex(0)
        ->setCellValue('A' . $a, $nomer . '.')
        ->setCellValue('B' . $a, $value->nama . ' - ' . $value->nip)
        ->setCellValue('C' . $a, $value->pangkat)
        ->setCellValue('F' . $a, $value->judul)
        ->setCellValue('G' . $a, $value->nama_kelompok)
        ->setCellValue('H' . $a, $created)
        ->setCellValue('I' . $a, $updated);

      if ($count_anggota > 1) {
        $merge = ($a + $count_anggota) - 1;
        $filenya->setActiveSheetIndex(0)
          ->mergeCells('A' . $a . ':A' . $merge)
          ->mergeCells('B' . $a . ':B' . $merge)
          ->mergeCells('C' . $a . ':C' . $merge)
          ->mergeCells('F' . $a . ':F' . $merge)
          ->mergeCells('G' . $a . ':G' . $merge)
          ->mergeCells('H' . $a . ':H' . $merge)
          ->mergeCells('I' . $a . ':I' . $merge);
      }

      $row_anggota = $a;
      foreach ($data_anggota as $dt) {
        $filenya->setActiveSheetIndex(0)->setCellValue('D' . $row_anggota, $dt->nama  . ' - ' . $dt->nip)
                                        ->setCellValue('E' . $row_anggota, $dt->pangkat);
        $row_anggota++;
      }
      $nomer++;

      if ($count_anggota > 1 ) {
        $a += $count_anggota;
        continue;
      }
      $a++;

        // start kodingan lama
        // $count_anggota = count($data_anggota);
        // $filenya->setActiveSheetIndex($i)->insertNewRowBefore($a + 1, $count_anggota);
        // $filenya->setActiveSheetIndex($i)
        //   ->setCellValue('A' . $a, $nomer . '.')
        //   ->setCellValue('B' . $a, $value->nama)
        //   ->setCellValue('E' . $a, $value->judul)
        //   ->setCellValue('F' . $a, $value->nama_kelompok)
        //   ->setCellValue('G' . $a, $created)
        //   ->setCellValue('H' . $a, $updated);

        // if($count_anggota > 1){
        //   $merge = ($a+$count_anggota) - 1;
        //   $filenya->setActiveSheetIndex($i)
        //   ->mergeCells('A'.$a.':A'.$merge)
        //   ->mergeCells('B'.$a.':B'.$merge)
        //   ->mergeCells('D'.$a.':D'.$merge)
        //   ->mergeCells('E'.$a.':E'.$merge)
        //   ->mergeCells('F'.$a.':F'.$merge)
        //   ->mergeCells('G'.$a.':G'.$merge);
        // }
        // $alphabet = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

        // $abjadke = 2;
        // foreach ($data_anggota as $dt) {
        //   $filenya->setActiveSheetIndex($i)->setCellValue($alphabet[$abjadke] . $a, $dt->nama);
        //   $abjadke++;
        // }
        // $nomer++;
        // if ($count_anggota > 1) {
        //   $a += $count_anggota;
        //   continue;
        // }
        // $a++;
        //  end kodingan lama
      }
      $filenya->getActiveSheet()->removeRow($a);
    }
    $filenya->setActiveSheetIndex(0);
    $nama_file = "REPORT AKHIR " . $judul[$id] . ' MONEV DANA PNBP ' . $tahun;

    $filenya->getProperties()->setCreator('P3M')
      ->setTitle($nama_file);

    $writer = new Xlsx($filenya);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $nama_file . '.xlsx"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    $writer->save('php://output');
  }
}
