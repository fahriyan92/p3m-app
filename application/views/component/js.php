<script>
	$(document).ready(function() {
		var max_fields = 20; //maximum input boxes allowed
		var wrapper = $(".input_fields_wrap"); //Fields wrapper
		var add_button = $("#add"); //Add button ID

		var x = 1; //initlal text box count
		$(add_button).click(function(e) { //on add input button click
			e.preventDefault();
			if (x < max_fields) { //max input box allowed
				x++; //text box increment
				$(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
			}
		});

		$(wrapper).on("click", ".remove_field", function(e) { //user click on remove text
			e.preventDefault();
			$(this).parent('div').remove();
			x--;
		})
	});
	$(function() {
		$("#tabs").tabs();
	});
</script>

<?php if ($this->session->flashdata('error_access')): ?>
<script>
  Swal.fire({
    title: 'Gagal',
    text: `<?= $this->session->flashdata('error_access') ?>`,
    type: 'error'
  });
</script>
<?php endif; ?>
<?php if ($this->session->flashdata('success')): ?>
<script>
  Swal.fire({
    title: 'Berhasil',
    text: `<?= $this->session->flashdata('success') ?>`,
    type: 'success'
  });
</script>
<?php endif; ?>