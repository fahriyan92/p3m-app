const get_data_all = () => new Promise((resolve,reject) => {

	const tahun = $("#select_tahun").val();
	$(".titel-thn").text(tahun);
	$.ajax({
		url:  `${BASE_URL}C_event/get_list_event/${tahun}`,
		type : 'get',
		dataType: 'json',
		success: res => resolve(res)
	})
});


const get_by_id = id => new Promise((resolve,reject) => {
	$.ajax({
		url: `${BASE_URL}C_event/get_list_event_by_id`,
		type: 'POST',
		data: id,
		dataType:'json',
		success: res => resolve(res)
	})
});

$(document).ready(function() {
		let make_akhir = false;
		$("#select_tahun").on('change',function(){
			get_data();
		});

		const obj = {
				//processing: true,
				language: {
					search : 'Cari',
					lengthMenu: 'Menampilkan _MENU_ data',
					info: 'Menampilkan _PAGE_ sampai _PAGES_ dari _MAX_ data',
					infoFiltered: '(difilter dari _MAX_ data)',
					paginate: {
						previous: 'Sebelumnya',
						next: 'Selanjutnya'
					},
          emptyTable: "Tidak Ada Data"
				},
				lengthMenu: [[10,15,20],[10,15,20]]      
		};

		let datatable; 

		const get_data = async () => {
			if ($.fn.DataTable.isDataTable(datatable)) {
				datatable.clear().destroy();
			}

			const data = await get_data_all();
			$('.bodynya').html(data[0]);
			$('.bodynya-pengabdian').html(data[1]);
			datatable =  $('#tabelevent,#tabelevent-pengabdian').DataTable(obj);
		};

		$('#tabelevent,#tabelevent-pengabdian').on('click','.btn-edit',function(e){
			e.preventDefault();
			get_by_id({id: this.id}).then(res => {
				siapkanEdit(res);
			})
		});

		$('#tabelevent,#tabelevent-pengabdian').on('click','.btn-delete',function(e){
			e.preventDefault();
			$.ajax({
				url: `${BASE_URL}C_event/delete`,
				type: 'POST',
				data: {id: this.id},
				dataType: 'json',
				success: function(res){
					let title = 'Berhasil!';
					let status = 'success';
					if(res.code != 1){
						title = 'Gagal!';
						status = 'error';
					}  else {
						get_data();
					}
					swal_alert(title,res.pesan,status);
					$('#overlay').fadeOut(400);
				}
			})
		});			

		const empty_form = function(){
			$(`#inputJenis:checked`).prop('checked',false);
			$('select[name="tahapan"]').val("").trigger('change');
			$('input[name="mulai"]').val("");
			$('input[name="pakegak"]').prop('checked',false).trigger('change');
			$('input[name="akhir"]').val('');
		};

		const siapkanEdit = function(data){
			$('#simpan-btn').hide();
			$('.tempat-edit').show();
			$(`#inputJenis[value="${data.id_jenis}"]`).trigger('click');
			$('select[name="tahapan"]').val(data.id_tahapan).trigger('change');
			$('input[name="mulai"]').val(data.mulai);
			$('#id_list').val(data.id);
			$(".mode-form").text("Edit");
			$("select[name='tahapan']").attr('disabled',true);

			if(data.akhir !== null){
				$('input[name="pakegak"]').prop('checked',true).trigger('change');
				$('input[name="akhir"]').val(data.akhir);
			} else{ 
				$('input[name="pakegak"]').prop('checked',false).trigger('change');
				$('input[name="akhir"]').val('');
			}
		};

		$('#batal-btn').on('click', function(e){
			e.preventDefault();
			$('#simpan-btn').show();
			$('.tempat-edit').hide();
			$(".mode-form").text("Tambah");
			$("select[name='tahapan']").attr('disabled',false);

			empty_form();
		});

		$('#edit-btn').on('click', function(e){
			e.preventDefault();
			
			if(validasi() === false){
				return;
			}

			$('#overlay').fadeIn(100);
			$.ajax({
				url: `${BASE_URL}C_event/update`,
				type: 'post', 
				data: {
					id: $('#id_list').val(),
					id_jenis : $(element.jns).val(),
					id_tahapan: $(element.thp).val(),
					mulai: $(element.mulai).val(),
					akhir: make_akhir === true ?  $(element.akhir).val() : null
				},
				dataType: 'json',
				success: function(res){
					let title = 'Berhasil!';
					let status = 'success';
					console.log(res);
					if(res.code != 1){
						title = 'Gagal!';
						status = 'error';
					} 
					kosongkan();
					$('#simpan-btn').show();
					$('.tempat-edit').hide();
					$('input[name="pakegak"]').prop('checked',false).trigger('change');
					$('input[name="akhir"]').val('');
					$("select[name='tahapan']").attr('disabled',false);
					$(".mode-form").text("Tambah");
					swal_alert(title,res.pesan,status);
					get_data();
					$('#overlay').fadeOut(400);
				}
			});			
		});

		$('input[name="pakegak"]').on('change', () => {
			if($('input[name="pakegak"]').is(':checked')){
				$('.pake-akhir').html(`<div class="form-group">
				<label for="inputEnd1">Tanggal Akhir</label>
				<div class="col-sm-12">
						<input type="date" class="form-control" id="inputEnd1" name="akhir">
				</div>
				<div class="error-akhir col-sm-10 mt-2" style="display: none;">
						<h5 style="font-size: 16px; color: red;">Tidak Boleh Kosong</h5>
				</div>
				</div>`);
				make_akhir = true;
			} else{ 
				$('.pake-akhir').html('');
				make_akhir = false;
			}
		});  
		
		get_data();
		

		const element = {
			jns: 'input[name="jenis_event"]:checked',
			thp: 'select[name="tahapan"]',
			mulai: 'input[name="mulai"]',
			akhir: 'input[name="akhir"]'
		};

		const kosongkan = function(){
			$(element.thp).val("").trigger('change');
			$(element.mulai).val("");
			$(element.akhir).val("");
			$('input[name="jenis_event"]').each(function(){
				$(this).prop('checked',false);
			});
			$('input[name="jenis_pendanaan"]').each(function(){
				$(this).prop('checked',false);
			});
	};

		function swal_alert(title,data,type) {
			Swal.fire({
				title: title,
				text: data,
				type: type
			});
		}
		
		const error = {
			jenis: $('.error-jns'),
			mulai: $('.error-mulai'),
			akhir: $('.error-akhir'),
			thp: $('.error-tahapan'),
		};	

		const validasi = () => {
			state = {
				jns : false,
				thp: false,
				mulai: false,
				akhir: false
			}

			function cek_akhir(){
				if(make_akhir === true){
					if($('input[name="akhir"]').val() === ''){
						$('.error-akhir').show();
						return false;
					} else{
						return true;
					}
				} else{ 
					return true;
				}
			}

			if($(element.jns).val() === undefined){
				error.jenis.show();
				state.jns = false;
			} else{
				error.jenis.hide();
				state.jns = true;
			}
			if($(element.thp).val() === ''){
				error.thp.show();
				state.thp = false;
			} else{
				error.thp.hide();
				state.thp = true;
			}
			if($(element.mulai).val() === ''){
				error.mulai.show();
				state.mulai = false;
			} else{
				error.mulai.hide();
				state.mulai = true;
			}
			if($(element.akhir).val() === ''){
				error.akhir.show();
				state.akhir = false;
			} else{
				error.akhir.hide();
				state.akhir = true;
			}

			if(state.jns === true && state.thp === true && state.mulai === true && state.akhir === true){
				
				if(cek_akhir()){
					return true;
				} else { 
					return false;
				}
			}

			return false;
		};



		$('#simpan-btn').on('click', function(e){
			if(validasi() === false){
				return;
			}
			$('#overlay').fadeIn(100);
			$.ajax({
				url: `${BASE_URL}C_event/action_store`,
				type: 'post', 
				data: {
					event : $(element.jns).val(),
					tahapan: $(element.thp).val(),
					mulai: $(element.mulai).val(),
					akhir: make_akhir === true ?  $(element.akhir).val() : null
				},
				dataType: 'json',
				success: function(res){
					let title = 'Berhasil!';
					let status = 'success';
					console.log(res);
					if(res.code != 1){
						title = 'Gagal!';
						status = 'error';
					}
					if(res.code == 1) {
						kosongkan();
					}
					swal_alert(title,res.pesan,status);
					get_data();
					$('#overlay').fadeOut(400);
				}
			});
		});
});

$(window).on("load", function() {
	$('#overlay').fadeOut(400);
});