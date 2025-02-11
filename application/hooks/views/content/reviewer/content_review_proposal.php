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
					<!-- text input -->
					<form id="form1" name="form1" method="post" action="<?= $status->status == 0 ? base_url("C_detail_review/simpan_review/") : base_url("C_detail_review/edit_penilaian/") ?>">
						<?php if (!empty($soalnya)) : ?>
							<?php $abjad = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n'];
							$no_soal = 0;
							for ($i = 0; count($soalnya) - 1 >= $i; $i++) { ?>
								<div class="col-md-12 mt-2">
									<label><?= $soalnya[$i]['jenis_soal'] ?></label>
								</div>
								<?php for ($j = 0; count($soalnya[$i]['soal_pilihan']) - 1 >= $j; $j++) { ?>
									<br>
									<div class="white-space"> <?= $soalnya[$i]['soal_pilihan'][$j]['nomer'] . " ." . $soalnya[$i]['soal_pilihan'][$j]['soal'] ?>
									</div>
									<?php for ($k = 0; count($soalnya[$i]['soal_pilihan'][$j]['pilihan']) - 1 >= $k; $k++) { ?>
										<ul class="list-group">
											<li class="white-space" style="list-style-type: none; margin-left: 20px;"><?= $abjad[$k]; ?>.<input type="radio" name="<?= "jawaban" ?><?= isset($id_penilaian) ? '-' . $id_penilaian[$no_soal] : $no_soal ?>" <?php if (isset($pilihan)) { ?><?= in_array($soalnya[$i]['soal_pilihan'][$j]['pilihan'][$k]->id_pilihan, $pilihan) ? 'checked' : '' ?> <?php } ?> value="<?= $soalnya[$i]['soal_pilihan'][$j]['pilihan'][$k]->id_pilihan ?>" required> <?= $soalnya[$i]['soal_pilihan'][$j]['pilihan'][$k]->deskripsi_pilihan ?> (Skor = <?= $soalnya[$i]['soal_pilihan'][$j]['pilihan'][$k]->score ?>)</li>
										</ul>
									<?php } ?>
								<?php $no_soal++;
								} ?>
							<?php } ?>
							<div class="row">
								<!-- <div class="col-md-5 mt-5"> -->
								<!-- 						<label>Rekomendasi Reviewer</label>
						<div class="white-space">Pilih Rekomendasi untuk Proposal Ini</div>					
							<ul class="list-group"><li class="white-space"  style="list-style-type: none; margin-left: 20px;">a.<input type="radio" name="rekomendasi" <?php if (isset($rekomendasi)) { ?>  <?= $rekomendasi == "0" ? 'checked' : 'disabled' ?>  <?php } ?><?php if (isset($rekomendasi)) { ?>  <?= $rekomendasi == "0" ? 'checked' : 'disabled' ?>  <?php } ?> value="0" required>  Merekomendasikan Untuk Ditolak</li></ul>
							<ul class="list-group"><li class="white-space"  style="list-style-type: none; margin-left: 20px;">b.<input type="radio" name="rekomendasi" <?php if (isset($rekomendasi)) { ?>  <?= $rekomendasi == "1" ? 'checked' : 'disabled' ?>  <?php } ?><?php if (isset($rekomendasi)) { ?>  <?= $rekomendasi == "1" ? 'checked' : 'disabled' ?>  <?php } ?> value="1" required>  Merekomendasikan Untuk Diterima Dengan Revisi</li></ul>
							<ul class="list-group"><li class="white-space"  style="list-style-type: none; margin-left: 20px;">c.<input type="radio" name="rekomendasi" <?php if (isset($rekomendasi)) { ?>  <?= $rekomendasi == "2" ? 'checked' : 'disabled' ?>  <?php } ?><?php if (isset($rekomendasi)) { ?>  <?= $rekomendasi == "2" ? 'checked' : 'disabled' ?>  <?php } ?> value="2" required>  Merekomendasikan Untuk Diterima</li></ul> -->
								<!-- </div> -->
								<div class="col-md-7 mt-5">
									<div class="form-group">
										<label for="statusTKT">Masukan Untuk Proposal ini</label>
										<textarea value="" class="form-control" id="masukan" name="masukan" rows="4" placeholder="Ketik Masukan Disini"><?php if (!empty($masukan)) : ?><?= $masukan; ?><?php endif ?></textarea>
									</div>
								</div>

							</div>
							<?php if ($status->status == 0 || $status->status == 1) { ?>
								<input type="hidden" name="id_kerjaan" value="<?= $status->id_kerjaan ?>">
							<?php } ?>


						<?php else : ?>
							<h1>Point - Point Penilaian Masih Belum Tersedia</h1>
						<?php endif ?>

						<br>
						<div class="row">
							<div class="col-md-6">
								<label>File Lampiran</label>
								<br>
								<a href="<?= base_url('assets/berkas/file_proposal/') . $dt_proposal->proposal ?>" target="_blank">File Proposal</a> |
								<a href="<?= base_url('assets/berkas/file_rab/') . $dt_proposal->rab ?>" target="_blank">File RAB</a>
							</div>
							<?php if ($status->status == 0) { ?>
								<div class="col-md-6">
									<button type="submit" style="margin: auto; width:auto; float:right;" class="btn btn-success" <?php if (empty($soalnya)) : ?> disabled <?php endif ?>><i class="fa fa-paste"></i> Kirim Penilaian</button>
								<?php } elseif ($status->status == 1) { ?>
									<button type="submit" style="margin: auto; width:auto; float:right;" class="btn btn-warning"><i class="fa fa-paste"></i> Edit Penilaian</button>
								<?php } ?>
								</div>

						</div>
						<input type="hidden" name="id_eventny" value="<?= $idEvent ?>">
					</form>
				</div>
				<!-- /.row -->
			</div>
			<br>
		</div><!-- /.container-fluid -->
	</section>
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