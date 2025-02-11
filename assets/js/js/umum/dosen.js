

$(document).ready(function(){


	function swal_alert(data) {

		Swal.fire({
			title: 'Data',
			text:  data,
			type: 'success'
		});
	}

 function notif_belumliat(liat = ''){
	$.ajax({
		url:`${BASE_URL}C_dashboard/notifikasi`,
		method:"POST",
		data:{lihat:liat},
		dataType:"json",
		success:function(data){

			// console.log(data);

			if (data.hitung_notif > 0) {
			$('.isi-permintaan').html(data.notif);
			console.log(data.hitung_notif);
				$('.notif-permintaan').show();
			}

		}
	});
 }

 notif_belumliat();

 // $(document).on('click', '.notifnya' , function(){
 // 	$('.hitung-notif').html('');

 // 	notif_belumliat('liat');
 // });

 setInterval(function(){
	notif_belumliat();;

 }, 10000);


 $('.tombol_terima').on('click', function (e) {
	$('#overlay').fadeIn(300);
          e.preventDefault();


 	const idnya = $('.tombol_terima').data('id-proposal');
 	const status = $('.tombol_terima').data('tmbl');
			// console.log(status);
	const id_peng = $('input[name="id_pengajuan"]').val();

  	$.ajax({
		url:`${BASE_URL}C_dashboard/tombol_permintaan`,
		method:"POST",
		data:{id_proposal:idnya, status:status, id_pengajuan:id_peng},
		dataType:"json",
		success:function(data){

			console.log(data);

			if (data[1].code === 1) {
			$('#overlay').fadeOut(400);

				swal_alert(data[1].pesan);
				window.location.replace(`${BASE_URL}C_dashboard`);

			} else {
			$('#overlay').fadeOut(400);

				swal_alert(data[1].pesan);
			}


		}
	});

 });

 $('.tombol_tolak').on('click', function (e) {
	$('#overlay').fadeIn(300);
          e.preventDefault();

 	const idnya = $('.tombol_tolak').data('id-proposal');
 	const status = $('.tombol_tolak').data('tmbl');
			// console.log(status);

  	$.ajax({
		url:`${BASE_URL}C_dashboard/tombol_permintaan`,
		method:"POST",
		data:{id_proposal:idnya, status:status},
		dataType:"json",
		success:function(data){
			$('#overlay').fadeOut(400);
			console.log(data);

			if (data[1].code === 1) {
				$('#overlay').fadeOut(400);
				swal_alert(data[1].pesan);
				window.location.replace(`${BASE_URL}C_dashboard`);
			} else {
				$('#overlay').fadeOut(400);
				swal_alert(data[1].pesan);
			}

		}
	});

 });

});




