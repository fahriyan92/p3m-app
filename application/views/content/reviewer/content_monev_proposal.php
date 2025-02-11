<?php $idEvent = $this->uri->segment(4); ?>
<style>
	.white-space {
		white-space: pre-wrap;
	}
</style>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1><?= $judul; ?></h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><?= $brdcrmb; ?></li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>



	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- SELECT2 EXAMPLE -->
			<div class="card card-default">
				<div class="card-header">
					<div class="row">
						<div class="col-md-6">
							<?php if ($idEvent == 1) : ?>
								<h5>Penelitian Dosen</h5>
							<?php else : ?>
								<h5>Pengabdian Dosen</h5>
							<?php endif; ?>
						</div>
						<div class=" col-md-6">
							<?php if (!empty($soalnya)) : ?>
								<div style="float: right;">
									<a href="#" class="btn" data-toggle="modal" data-target="#modal-default" style="color:white;background-color:#605ca8">Lihat Ringkasan Laporan</a>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>


				<!-- /.card-header -->
				<div class="card-body">
					<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#test1" aria-expanded="false" aria-controls="test1">
    				Test1
  				</button>
					<div class="collapse mt-2" id="test1">
  				<div class="card card-body">
    				Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
  				</div>
					</div>

					<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#test2" aria-expanded="false" aria-controls="test2">
    				Test2
  				</button>
					<div class="collapse mt-2" id="test2">
  				<div class="card card-body">
    				Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
  				</div>
					</div>

				</div>

<?php if (!empty($dt_proposal)) { ?>
	<div class="modal fade" id="modal-default">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Ringkasan Proposal</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<h5 class="text-capitalize"><?= $dt_proposal->judul ?></h5>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label for="statusTKT">Ringkasan Usulan</label>
								<textarea value="" class="form-control" id="ringkasan" name="ringkasan" rows="4"><?= $dt_proposal->ringkasan ?></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="statusTKT">Metode</label>
								<textarea value="" class="form-control" id="ringkasan" name="ringkasan" rows="4"><?= $dt_proposal->metode ?></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="statusTKT">Tinjauan Pustaka</label>
								<div class="err-ringkasan" style="display:none;">
									<h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
								</div>
								<textarea value="" class="form-control" id="ringkasan" name="ringkasan" rows="4"><?= $dt_proposal->tinjauan ?></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>
<?php } ?>


<script>
	$(window).on('load', function() {
		$('#overlay').fadeOut(400);
	});
</script>
<!-- /.content -->
