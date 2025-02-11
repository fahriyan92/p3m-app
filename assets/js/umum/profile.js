(function(){
	const url = `${BASE_URL}C_settings_user/`;

	const error = {
		lama: $('.error-pass-lama'),
		baru: $('.error-pass-baru'),
		konfirmasi: $('.error-pass-konfirmasi')
	};	

	const ganti_model = function(password){
		return new Promise((resolve,reject) => {
			$.ajax({
				url: `${url}edit_password`,
				type: 'post',
				data: {password_lama: password.lama, password_baru: password.baru, password_baru_re: password.konfirmasi},
				dataType: 'json',
				success: res => resolve(res)
			});
		});
	};

	function swal_alert(data) {
		Swal.fire({
			title: 'Berhasil!',
			text: data,
			type: 'success'
		});
	};


	const kosong = "Tidak Boleh Kosong! Harus Diisi";

	const validasi = function(){
		const password_lama = $('#password-lama').val();
		const password_baru = $('#password-baru').val();
		const konfirmasi_password = $('#re-password').val();


		if(password_lama === ''){
			error.lama.prev().find('input').css('border-color','red');
			error.lama.find('h5').text(kosong);
			error.lama.show();
		}else{
			error.lama.prev().find('input').css('border-color','#ced4da');
			error.lama.hide();			
		}
		if(password_baru === ''){
			error.baru.prev().find('input').css('border-color','red');
			error.baru.find('h5').text(kosong);
			error.baru.show();
		} else{
			error.baru.prev().find('input').css('border-color','#ced4da');
			error.baru.hide();
		}		
		if(konfirmasi_password === ''){
			error.konfirmasi.prev().find('input').css('border-color','red');
			error.konfirmasi.find('h5').text(kosong);
			error.konfirmasi.show();
		}else{
			error.konfirmasi.prev().find('input').css('border-color','#ced4da');
			error.konfirmasi.hide();
		}			


		if(password_lama === '' || password_baru === '' || konfirmasi_password === ''){
			return false;
		}


		return true;
	};


	const kosongkan = function(){
		$('#password-lama').val("");
		$('#password-baru').val("");
		$('#re-password').val("");
	};

	const edit_password = function(){
		const password = {
			lama: $('#password-lama').val(),
			baru: $('#password-baru').val(),
			konfirmasi: $('#re-password').val()
		};


		ganti_model(password).then(res => {
			if(res.code === 1){
				error.lama.prev().find('input').css('border-color','red');
				error.lama.find('h5').text("Password Yang Masukan Anda Salah!");	
				error.lama.show();
				error.konfirmasi.prev().find('input').css('border-color','red');
				error.konfirmasi.find('h5').text("konfirmasi Password Tidak Sama!");		
				error.konfirmasi.show();	
			}

			if(res.code === 2){
				error.konfirmasi.prev().find('input').css('border-color','red');
				error.konfirmasi.find('h5').text("Password Yang Masukan Anda Salah!");		
				error.konfirmasi.show();			
			}			

			if(res.code === 3){
				error.lama.prev().find('input').css('border-color','red');
				error.lama.find('h5').text("Password Yang Masukan Anda Salah!");		
				error.lama.show();			
			}

			if(res.code === 4){
				kosongkan();
				swal_alert('Password Berhasil Diganti');		
			}			


		});
		// ganti_model
	};


	$('.ganti').on('click', function(e){
		e.preventDefault();
		if(validasi()){
			edit_password();
		}

	});



})();