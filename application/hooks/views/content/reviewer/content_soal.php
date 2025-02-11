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
					<h5>Penelitian Dosen</h5>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					<!-- text input -->
					<div class="col-md-12">
						<div class="form-group">
							<label>Nilai Portofolio Peneliti (Nilai 20%)</label>
						</div>
					</div>
					<form id="form1" name="form1" method="post" action="<?= base_url("C_detail_review/simpan_review/") . $idproposal;  ?>">
						<ol start="1" type="1">
							<li>Publikasi berupa artikel di jurnal internasional bereputasi sebagai penulis pertama atau corresponding author*). </li>
							<br>
							<ol start="1" type="I">
								<li>Reputasi pengindeks Tinggi : Thompson Reuters/Web of Science, Scopus, atau yang setara</li>
								<li>Reputasi pengindeks Sedang : Ebsco, Proquest, Gale, DOAJ, Inspec, atau yang setara</li>
								<li>Ruptasi pengindeks Rendah : Google Scholar, Garuda, ISJD, WorldCat, Moraref, Sherpa, atau yang setara</li>

							</ol>
							<br>
							<ol start="1" type="a">
								<i>
									<li><input type="radio" name="1" value="0-1a-0" required>0 artikel (Skor = 0)</li>
									<li><input type="radio" name="1" value="0-1b-5">1-2 artikel (Skor = 5)</li>
									<li><input type="radio" name="1" value="0-1c-10">3-5 artikel (Skor = 10)</li>
									<li><input type="radio" name="1" value="0-1d-15">6-10 artikel (Skor = 15)</li>
									<li><input type="radio" name="1" value="0-1e-20">> 10 artikel (Skor = 20)</li>
								</i>
							</ol>
							<br>
							<li>Publikasi jurnal internasional yang diakui Kemenristekdikti, dan/atau jurnal nasional terakreditasi (Sinta 1 dan 2) dan/atau prosiding internasional terindeks*) sebagai penulis utama atau corresponding author</li>
							<br>
							<ol start="1" type="a">
								<i>
									<li><input type="radio" name="2" value="0-2a-0" required>0 artikel (Skor = 0)</li>
									<li><input type="radio" name="2" value="0-2b-5">1-2 artikel (Skor = 5)</li>
									<li><input type="radio" name="2" value="0-2c-10">3-5 artikel (Skor = 10)</li>
									<li><input type="radio" name="2" value="0-2d-15">6-10 artikel (Skor = 15)</li>
									<li><input type="radio" name="2" value="0-2e-20">> 10 artikel (Skor = 20)</li>
								</i>
							</ol>
							<br>
							<li>Buku ber-ISBN dan/atau chapter dalam buku ber ISBN (1 buku setara dengan 3 chapter) </li>
							<br>
							<ol start="1" type="a">
								<i>
									<li><input type="radio" name="3" value="0-3a-0" required>0 buku (Skor = 0)</li>
									<li><input type="radio" name="3" value="0-3b-10">1 buku (Skor = 5)</li>
									<li><input type="radio" name="3" value="0-3c-15">2 buku (Skor = 10)</li>
									<li><input type="radio" name="3" value="0-3d-20">3 buku (Skor = 15)</li>
									<li><input type="radio" name="3" value="0-3e-25">> 3 buku (Skor = 20)</li>
								</i>
							</ol>
							<br>
							<li>Perolehan Kekayaan Intelektual </li>
							<br>
							<ol start="1" type="a">
								<i>
									<li><input type="radio" name="4" value="0-4a-0" required>Tidak ada (Skor = 0)</li>
									<li><input type="radio" name="4" value="0-4b-5">Ada 1 terdaftar (Skor = 5)</li>
									<li><input type="radio" name="4" value="0-4c-10">Ada 1 granted (Skor = 10)</li>
									<li><input type="radio" name="4" value="0-4d-15">Ada 2 granted (Skor = 15)</li>
									<li><input type="radio" name="4" value="0-4e-20">> 2 Granted (Skor = 20)</li>
								</i>
							</ol>
							<br>
							<li>Penulis mempunyai h-Index Scopus</li>
							<br>
							<ol start="1" type="a">
								<i>
									<li><input type="radio" name="5" value="0-5a-0" required>Tidak ada (Skor = 0)</li>
									<li><input type="radio" name="5" value="0-5b-5">H-Indeks Scopus 1 (Skor = 5)</li>
									<li><input type="radio" name="5" value="0-5c-10">H-Indeks Scopus 2 (Skor = 10)</li>
									<li><input type="radio" name="5" value="0-5d-15">H-Indeks Scopus 3 (Skor = 15)</li>
									<li><input type="radio" name="5" value="0-5e-20">H-Indeks Scopus >3 (Skor = 20)</li>
								</i>
							</ol>
							<br>
						</ol>
						<br>

						<div class="col-md-12">
							<div class="form-group">
								<label>Nilai Substansi Proposal (Nilai 80%)</label>
							</div>
						</div>
						<ol start="1" type="1">
							<li>Relevansi usulan penelitian dengan roadmap penelitian yang dibangun</li>
							<br>


							<ol start="1" type="a">
								<i>
									<li><input type="radio" name="6" value="1-1a-0" required>Tidak relevan/topik lainnya (Skor = 0)</li>
									<li><input type="radio" name="6" value="1-1b-10">Relevan (Skor = 10)</li>

								</i>
							</ol>
							<br>
							<li>Kualitas dan relevansi tujuan, permasalahan, state of the art, metode dan kebaruan penelitian</li>
							<br>
							<ol start="1" type="a">
								<i>
									<li><input type="radio" name="7" value="1-2a-0" required>Tidak ada kebaruan (Skor = 0)</li>
									<li><input type="radio" name="7" value="1-2b-3">Kebaruan kurang signifikan (Skor = 3)</li>
									<li><input type="radio" name="7" value="1-2c-7">Kebaruan cukup signifikan (Skor = 7)</li>
									<li><input type="radio" name="7" value="1-2d-10">Kebaruan sangat signifikan (Skor = 10)</li>
								</i>
							</ol>
							<br>
							<li>Kesesuaian kompetensi tim dan pembagian tugas</li>
							<br>
							<ol start="1" type="a">
								<i>
									<li><input type="radio" name="8" value="1-3a-0" required>Kompetensi tidak sesuai dan pembagian tugas tidak jelas ( Skor = 0)</li>
									<li><input type="radio" name="8" value="1-3b-3">Kompetensi cukup sesuai dan pembagian tugas cukup jelas (Skor = 3)</li>
									<li><input type="radio" name="8" value="1-3c-5">ompetensi sangat sesuai dan pembagian tugas sangat jelas (Skor = 5)</li>

								</i>
							</ol>
							<br>
							<li>Kesesuaian luaran wajib yang dijanjikan : berbentuk publikasi prosiding di seminar internasional</li>
							<br>
							<ol start="1" type="a">
								<i>
									<li><input type="radio" name="9" value="1-4a-0" required>Prosiding seminar nasional (Skor = 0)</li>
									<li><input type="radio" name="9" value="1-4b-20">Prosiding seminar internasional Politeknik Negeri Jember (Skor = 20)</li>

								</i>
							</ol>
							<br>
							<li>Keseuaian luaran tambahan yang dijanjikan berbentuk Publikasi berbentuk artikel di Jurnal atau artikel prosiding di seminar internasional</li>
							<br>
							<ol start="1" type="a">
								<i>
									<li><input type="radio" name="10" value="1-5a-0" required>Jurnal nasional tidak terakreditasi (Skor = 0)</li>
									<li><input type="radio" name="10" value="1-5b-0">Tidak termasuk jurnal internasional (Skor = 0)</li>
									<li><input type="radio" name="10" value="1-5c-0">Tidak termasuk prosiding internasional (Skor = 0)</li>
									<li><input type="radio" name="10" value="1-5d-5">Jurnal yang dituju peringkat Sinta 5 dan 6 (Skor = 5)</li>
									<li><input type="radio" name="10" value="1-5e-10">Jurnal yang dituju peringkat Sinta 3 dan 4 (Skor = 10)</li>
									<li><input type="radio" name="10" value="1-5f-15">Jurnal yang dituju peringkat Sinta 1 dan 2 (Skor = 15)</li>
									<li><input type="radio" name="10" value="1-5g-15">Jurnal internasional Q3 dan Q4 (Skor = 15)</li>
									<li><input type="radio" name="10" value="1-5h-20">Jurnal internasional Q1 dan Q2 (Skor = 20)</li>

								</i>
							</ol>
							<br>
							<li>Kewajaran metode tahapan target capaian luaran wajib penelitian</li>
							<br>
							<ol start="1" type="a">
								<i>
									<li><input type="radio" name="11" value="1-6a-3" required>Metode tahapan capaian kurang menggambarkan tahapan penyelidikan ilmiah (Skor = 3)</li>
									<li><input type="radio" name="11" value="1-6b-5">Metode tahapan capaian cukup menggambarkan tahapan penyelidikan ilmiah (Skor = 5)</li>
									<li><input type="radio" name="11" value="1-6c-10">Metode tahapan capaian menggambarkan tahapan penyelidikan ilmiah (Skor = 10)</li>

								</i>
							</ol>
							<br>
							<li>Kesesuaian target TKT</li>
							<br>
							<ol start="1" type="a">
								<i>
									<li><input type="radio" name="12" value="1-7a-0" required>Target TKT tidak sesuai (Skor = 0)</li>
									<li><input type="radio" name="12" value="1-7b-5">Target TKT sesuai (Skor = 5)</li>
								</i>
							</ol>
							<br>
							<li>Kesesuaian jadwal penelitian</li>
							<br>
							<ol start="1" type="a">
								<i>
									<li><input type="radio" name="13" value="1-8a-0" required>Jadwal tidak ada (Skor = 0)</li>
									<li><input type="radio" name="13" value="1-8b-3">Jadwal cukup sesuai dengan tahapan penelitian (Skor = 3)</li>
									<li><input type="radio" name="13" value="1-8c-5">Jadwal cukup sesuai dengan tahapan penelitian (Skor = 5)</li>

								</i>
							</ol>
							<br>
							<li>Kekinian dan sumber primer pengacuan pustaka (minimal 10 buah)</li>
							<br>
							<ol start="1" type="a">
								<i>
									<li><input type="radio" name="14" value="1-9a-0" required>Tidak ada pustaka primer (Skor = 0)</li>
									<li><input type="radio" name="14" value="1-9b-5">Pustaka tergolong primer dan mutakhir sebesar di atas 50% (Skor = 5)</li>
									<li><input type="radio" name="14" value="1-9c-10">Pustaka tergolong primer dan mutakhir sebesar di atas 50% dengan 1-2 acuan sumber primer dari tim peneliti (Skor = 10)</li>
									<li><input type="radio" name="14" value="1-9d-15">Pustaka tergolong primer dan mutakhir sebesar di atas 50% dengan di atas 3 acuan sumber primer dari tim peneliti (Skor = 15)</li>
								</i>
							</ol>
							<br>
						</ol>
						<br>

						<div class="col-md-6">
							<label>File Lampiran</label>
							<br>
							<a href="<?= base_url('file/dummy.pdf') ?>" target="_blank">File Proposal</a> |
							<a href="<?= base_url('file/dummy.pdf') ?>" target="_blank">File RAB</a>
						</div>
						<br>
						<div class="row">
							<div class="col-md-6">

							</div>
							<div class="col-md-6">
								<button type="submit" style="margin: auto; width:auto; float:right;" class="btn btn-success"><i class="fa fa-paste"></i> Submit Review</button>
							</div>
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