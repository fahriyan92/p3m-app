<?php

function tanggal_indo($tgl)
{
  $bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	if($tgl === '-' || $tgl == null || $tgl == "null"){
		return '-';
	}

  $pecahkan = explode('-', $tgl);
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function tp_indo($tgl)
{

  $bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	if($tgl === '-' || $tgl == null || $tgl == "null"){
		return '-';
	}

	$gege = explode(' ', $tgl);


	$pecahkan = explode('-', $gege[0]);
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function rupiah($angka){
	return  "Rp. ". number_format($angka, 0, ".", ".");
}


function check_reviewer(){
	$ci=& get_instance();
	$ci->load->database();
	$nip = $ci->session->userdata("nidn"); //ini adalah nip

	$reviewer_event = $ci->db->query("select id_event from tb_reviewer where nidn = '".$nip."' and status = 1")->row();
	$id_event = [];

	if($reviewer_event != null){
		$ex = explode(',',$reviewer_event->id_event);
		if(count($ex) > 1){
			//jika ada lebih dari satu event, maka ambil dan pisahkan menggukanan karakter koma
			$id_event = $ex;
		} else{
			//jika hanya ada satu event, maka taruh tidak perlu di pecah, langsung di push dke id_event
			array_push($id_event,$reviewer_event->id_event);
		}
  }
	return $id_event;
}

function check_pemonev(){
	$ci=& get_instance();
	$ci->load->database();
	$nip = $ci->session->userdata("nidn"); //ini adalah nip

	$pemonev_event = $ci->db->query("select id_event from tb_pemonev where nidn = '".$nip."' and status = 1")->row();
	$id_event = [];

	if($pemonev_event != null){
		$ex = explode(',',$pemonev_event->id_event);
		if(count($ex) > 1){
			//jika ada lebih dari satu event, maka ambil dan pisahkan menggukanan karakter koma
			$id_event = $ex;
		} else{
			//jika hanya ada satu event, maka taruh tidak perlu di pecah, langsung di push dke id_event
			array_push($id_event,$pemonev_event->id_event);
		}
  }
	return $id_event;
}
