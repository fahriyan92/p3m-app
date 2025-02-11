
        const flash = $('.flash-data').data('flashdata');
        if (flash) {

		Swal.fire({
			title: 'Data',
			text: flash,
			type: 'success',
            showConfirmButton: false,
            timer: 1500
		});
        }



