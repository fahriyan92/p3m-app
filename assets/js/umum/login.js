	function swal_alert(data) {

		Swal.fire({
			title: 'Data',
			text: 'Gagal, ' + data,
			type: 'error'
		});
	}

	$(document).ready(function() {
		$("form").submit(function(e) {
			e.preventDefault(e);
		});

		$('#submit').click(function() {
			var username = $('#username').val();
			var password = $('#password').val();

			if (username === '' || password === '') {
				swal_alert('Username atau password tidak boleh kosong !');

			} else {
				// console.log(password);
				$.ajax({
					type: "POST",
					dataType: "json",
					url: `${BASE_URL}C_auth/aksi_login`,
					data: {
						username: username,
						password: password
					},
					success: function(data) {

						if (data.code === "1") {
							window.location.replace(`${BASE_URL}C_dashboard`);
						} else {
							swal_alert(data.pesan);
						}

					}
				});
			}

		})
	});
