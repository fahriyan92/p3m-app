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