<style>
	.white-space{
		white-space:pre-wrap;
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
					<h5>Hasil Review Proposal </h5>

        <!-- /.row -->
				</div>
				<!-- /.card-header -->
				<div class="card-body">
				<!-- <?php var_dump($soalnya)?> -->
					<!-- text input -->
					<form id="form1" name="form1" method="post" action="<?= base_url("C_detail_review/simpan_review/") . $idproposal;  ?>">
			<?php if (!empty($soalnya)): ?>
					<?php  $abjad = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n']; $x=0; $no_soal = 0;
					for ($i = 0 ; count($soalnya) -1 >= $i ; $i++) { ?>
						<?php 

						$bobot = $soalnya[$i]['bobot'];
						$scoreny = $soalnya[$i]['total_score'];
						if($idevents==2){
							$tot_nilai = $scoreny;
							if($tot_nilai == null){
								$tot_nilai = 0;
							}
						}else{
							$tot_nilai = $scoreny*$bobot/100;
						}

						$x += $tot_nilai

						?>
							<div class="col-md-12 mt-2">
									<label><?= $soalnya[$i]['jenis_soal'] ?> - (<?= $bobot ?>%) KALKULASI NILAI : <?= round($tot_nilai, 2) ?></label>
							</div>
							<?php for($j=0; count($soalnya[$i]['soal_pilihan']) -1 >= $j ; $j++){ ?>
							<br>
									<div class="white-space"> <?= $soalnya[$i]['soal_pilihan'][$j]['nomer'] . " ." . $soalnya[$i]['soal_pilihan'][$j]['soal'] ?>
									</div>
									<?php for ($k = 0; count($soalnya[$i]['soal_pilihan'][$j]['pilihan']) - 1 >= $k; $k++) { ?>
										<ul class="list-group">
											<li class="white-space" style="list-style-type: none; margin-left: 20px;"><?= $abjad[$k]; ?>.<input type="radio" disabled name="<?= "jawaban" ?><?= isset($id_penilaian) ? '-' . $id_penilaian[$no_soal] : $no_soal ?>" <?php if (isset($pilihan)) { ?><?= in_array($soalnya[$i]['soal_pilihan'][$j]['pilihan'][$k]->id_pilihan, $pilihan) ? 'checked' : '' ?> <?php } ?> value="<?= $soalnya[$i]['soal_pilihan'][$j]['pilihan'][$k]->id_pilihan ?>" required> <?= $soalnya[$i]['soal_pilihan'][$j]['pilihan'][$k]->deskripsi_pilihan ?> (Skor = <?= $soalnya[$i]['soal_pilihan'][$j]['pilihan'][$k]->score ?>)</li>
										</ul>
									<?php } ?>
							<?php $no_soal++;  } ?>
					<?php }?>
<!-- 					<div class="col-md-12 mt-5">
									<label>Rekomendasi Reviewer</label>
					<div class="white-space">Pilih Rekomendasi untuk Proposal Ini</div>					
					<ul class="list-group"><li class="white-space" style="list-style-type: none; margin-left: 20px;">a.<input type="radio" name="rekomendasi" value="0" required>  Merekomendasikan Untuk Ditolak</li></ul>
					<ul class="list-group"><li class="white-space" style="list-style-type: none; margin-left: 20px;">b.<input type="radio" name="rekomendasi" value="1" required>  Merekomendasikan Untuk Diterima Dengan Revisi</li></ul>
					<ul class="list-group"><li class="white-space" style="list-style-type: none; margin-left: 20px;">c.<input type="radio" name="rekomendasi" value="2" required>  Merekomendasikan Untuk Diterima</li></ul>
					</div> -->
				

			<?php else: ?>
							<h1 style="text-align: center;"> Proposal Masih Belum  Di review</h1>
		<?php endif ?>
				

						<br>
<?php if (!empty($soalnya)): ?>
				        <div class="row">
			          <div class="col-md-3 col-sm-6 col-12">
			            <div class="info-box bg-info" style="padding: 35px;">
			              <span class="info-box-icon"><i class="far fa-bookmark"></i></span>

			              <div class="info-box-content">
			                <span class="info-box-number">Total Score : </span>
			<h3><?php echo round($x, 2); ?></h4>
			              </div>
			              <!-- /.info-box-content -->
			            </div>
			            <!-- /.info-box -->
			          </div>
			          <!-- /.col -->

					<div class="col-md-9 ">
							<div class="form-group">
									<label for="statusTKT">Masukan Untuk Proposal ini</label>
									<textarea value="" readonly class="form-control" id="masukan" name="masukan" rows="4" placeholder="Ketik Masukan Disini"><?php if (!empty($rekom->masukan_reviewer)): ?><?= $rekom->masukan_reviewer; ?><?php endif ?></textarea>
							</div>
					</div>
<?php endif ?>
        </div>
					</form>
				</div>
				<!-- /.row -->
			</div>
			<br>
		</div><!-- /.container-fluid -->
	</section>
</div>
	


<script>
    $(window).on('load', function(){
        $('#overlay').fadeOut(400);
    });
</script>
<!-- /.content -->