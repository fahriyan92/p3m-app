	function swal_alert(data) {

		Swal.fire({
			title: 'Error',
			text:  data,
			type: 'error'
		});
	}

	$(document).ready(function() {
		$("form").submit(function(e) {
			e.preventDefault(e);
		});

		$('#submit').click(function() {
			var nidn = $('#nidn').val();
			// var password = $('#password').val();

			if (nidn === '') {
				swal_alert('nip tidak boleh kosong !');

			} else {
				// console.log(password);
				$.ajax({
					type: "POST",
					dataType: "json",
					url: `${BASE_URL}C_auth/register_email`,
					data: {
						nidn: nidn,
					},
					success: function(data) {
						if(data.status === "success"){
							window.location.replace(`${BASE_URL}C_register/register_email`);
							return;
						}

						swal_alert(data.pesan);
						return;
						// if (data.code === "1") {
						// 	window.location.replace(`${BASE_URL}C_dashboard`);
						// } else {
						// 	swal_alert(data.pesan);
						// }

					}
				});
			}

		})
	});
