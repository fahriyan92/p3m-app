<?php $idEvent = $this->uri->segment(4); ?>
<style>
	.white-space {
		white-space: pre-wrap;
	}
	.table {
  display: table;
  border-collapse: collapse;
}
.table .tr {
  display: table-row;
  border: 1px solid #ddd;
}
.table .tr:first-child {
  font-weight: bold;
  border-bottom: 2px solid #ddd;
}
.table .tr:nth-child(even) {
  background-color: #F9F9F9;
}
.table .tr .td {
  display: table-cell;
  padding: 8px;
  border-left: 1px solid #ddd;
}
.table .tr .td:first-child {
  border-left: 0;
}

/* Not necessary for table styling */
.div-table, .table-tag {
  float: left;
  margin: 2em;
}
.div-table .title, .table-tag .title {
  text-align: center;
  padding-bottom: 0.5em;
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

	<section class="content">
    <div class="container-fluid">
			<!-- SELECT2 EXAMPLE -->
			<div class="card card-default">
        <div class="card-header">
					<div class="row">
						<div class="col-md-6">
							<h5><?= $namakelompok; ?></h5>
						</div>
					</div>
				</div>
        <div class="card-body">
          <?php if (!empty($dt_proposal)) : ?>
          <div class="row">
              <div class="col-sm-12">
                  <div class="form-group">
                      <label for="inputJudul">Judul</label>
                      <input type="text" class="form-control" id="inputJudul" placeholder="Judul Penelitian" value="<?= $dt_proposal->judul; ?>" name="judulPenelitianDosenPNBP" disabled>
                  </div>
              </div>
          </div>
          <?php endif; ?>
          <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                      <div class="form-group">
                          <label for="">Nama Ketua</label>
                          <input readonly class="form-control text-capitalize" type="text" value="<?= $dt_proposal->nama_ketua ?> - <?= $dt_proposal->nidn_ketua ?>">
                      </div>
                  </div>
              </div>
              <div class="col-sm-6">
                  <div class="form-group">
                      <label for="biayadiusulkan">Biaya yang diusulkan</label>
                      <input type="text" class="form-control" id="biayadiusulkan" value="<?= rupiah($dt_proposal->biaya_usulan); ?>" placeholder="Rp.8.500.000,-" name="biayadiusulkan" disabled>
                  </div>
              </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                  <div class="form-group">
                      <label for="tglmulai">Lama Penelitian (mulai)</label>
                      <input type="date" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" id="tglmulai" placeholder="mulai" name="tglmulai" value="<?= $dt_proposal->mulai; ?>" disabled>
                  </div>
                </div>
                <div class="col-sm-1" style="text-align: center; margin-top:36px">
                    <span> - </span>
                </div>
                <div class="col-sm-5">
                  <div class="form-group">
                      <label for="tglakhir">(akhir)</label>
                      <input type="date" class="form-control" id="tglakhir" data-inputmask-inputformat="dd/mm/yyyy" placeholder="akhir" name="tglakhir" value="<?= $dt_proposal->akhir; ?>" disabled>
                  </div>
                </div>
              </div>
<form id="pkln" name="pkln" method="post" action="<?= $status->status == 0 ? base_url("C_monitoring/simpan_monev_pkk/") : base_url("C_monitoring/edit_monev_pkk/") ?>">
	<div class="row">
			<div class="div-table w-100">
			  <div class="table">
			    <div class="tr">
			      <div class="td">No</div>
			      <div class="td" style="width: 30%;">Komponen Penilaian</div>
			      <div class="td">Keterangan</div>
						<div class="td">Bobot<br>(1 - 100)</div>
						<div class="td">Skor<br>(1 - 7)</div>
						<div class="td">Nilai<br>(Bobot x Skor)</div>
			    </div>
					 <div class="tr">
						 <div class="td"></div>
						 <div class="td font-weight-bold">Luaran Wajib</div>
					 </div>
			    <div class="tr">
			      <div class="td">1</div>
			      <div class="td">
			      	Satu artikel ilmiah berupa prosiding dari Seminar Internasional Polije (ICoFA atau ICoSHIP) yang diregistrasi di publisher bereputasi baik Institute of Physics (IOP) atau Atlantis Press (AP), atau publisher bereputasi lainnya, atau seminar internasional yang lain bila tidak lolos seleksi pada publisher prosiding ICoFA atau ICoSHIP
			      </div>
			      <div class="td">
							<?php if($status->status == 1) : ?>
							<select name="keterangan1" class="form-control form-control-sm" aria-label="keterangan1" id="keterangan1">
							<option readonly selected value="<?= $laporan_monev->komponen_keterangan1 ?>"><?php if (!empty($laporan_monev->komponen_keterangan1)) : ?>Pilihan Awal: <?= $laporan_monev->komponen_keterangan1; ?><?php endif ?></option>
							<option value="Tidak ada">Tidak ada</option>
							<option value="Draf">Draf</option>
							<option value="Submitted / Review">Submitted / Review</option>
							<option value="Accepted">Accepted</option>
							<option value="Terbit">Terbit</option>
							</select>
						<?php else : ?>
							<select name="keterangan1" class="form-control form-control-sm" aria-label="keterangan1" id="keterangan1">
	  						<option value="Tidak ada">Tidak ada</option>
	  						<option value="Draf">Draf</option>
	  						<option value="Submitted / Review">Submitted / Review</option>
	  						<option value="Accepted">Accepted</option>
								<option value="Terbit">Terbit</option>
							</select>
							<?php endif; ?>
			      </div>
						<div class="td">
								<input readonly name="ket1_bobot" type="number" name="ket1_bobot" onkeyup="penjumlahan" class="form-control form-control-sm" id="ket1_bobot" min="40" max="40" value="40">
			      </div>
						<div class="td">
							<input type="number" name="ket1_skor" onkeyup="penjumlahan" class="form-control form-control-sm" id="ket1_skor" min="0" max="7" value="<?php if (!empty($laporan_monev->komponen_skor1)) : ?><?= $laporan_monev->komponen_skor1; ?><?php endif ?>">
			      </div>
						<div class="td">
	    					<input type="text" name="ket1_nilai" class="form-control form-control-sm" id="ket1_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai1)) : ?><?= $laporan_monev->komponen_nilai1; ?><?php endif ?>" readonly>
			      </div>
			    </div>
			    <div class="tr">
			      <div class="td">2</div>
			      <div class="td">
							Satu produk paten sederhana atau paten dengan status terdaftar
			      </div>
			      <div class="td">
							<div class="td">
								<?php if($status->status == 1) : ?>
								<select name="keterangan2" class="form-control form-control-sm" aria-label="keterangan2" id="keterangan2">
								<option readonly selected value="<?= $laporan_monev->komponen_keterangan2 ?>"><?php if (!empty($laporan_monev->komponen_keterangan2)) : ?>Pilihan Awal: <?= $laporan_monev->komponen_keterangan2; ?><?php endif ?></option>
								<option value="Tidak Ada">Tidak ada</option>
								<option value="Draf">Draf</option>
								<option value="Editing">Editing</option>
								<option value="Terbit">Terbit</option>
								</select>
							<?php else : ?>
								<select name="keterangan2" class="form-control form-control-sm" aria-label="keterangan2">
		  						<option value="Tidak Ada">Tidak ada</option>
		  						<option value="Draf">Draf</option>
		  						<option value="Editing">Editing</option>
		  						<option value="Terbit">Terbit</option>
								</select>
								<?php endif; ?>
				      </div>
			      </div>
						<div class="td text-center">
							<input readonly name="ket2_bobot" type="number" class="form-control form-control-sm" id="ket2_bobot" min="0" max="100" value="30">
			      </div>
						<div class="td">
	    					<input name="ket2_skor" type="number" class="form-control form-control-sm" id="ket2_skor" min="0" max="7" value="<?php if (!empty($laporan_monev->komponen_skor2)) : ?><?= $laporan_monev->komponen_skor2; ?><?php endif ?>">
			      </div>
						<div class="td">
	    					<input name="ket2_nilai" type="text" class="form-control form-control-sm" id="ket2_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai2)) : ?><?= $laporan_monev->komponen_nilai2; ?><?php endif ?>" readonly>
			      </div>
						</div>
						<div class="tr">
				      <div class="td">3</div>
				      <div class="td">
								Satu dokumen kerjasama dengan industri yang menerangkan bahwa teknologi, metode atau ipteks yang diterapkembangkan digunakan oleh industri dalam jangka waktu minimal 1 tahun
				      </div>
				      <div class="td">
								<?php if($status->status == 1) : ?>
								<select name="keterangan3" class="form-control form-control-sm" aria-label="keterangan3" id="keterangan3">
								<option readonly selected value="<?= $laporan_monev->komponen_keterangan3 ?>"><?php if (!empty($laporan_monev->komponen_keterangan3)) : ?>Pilihan Awal: <?= $laporan_monev->komponen_keterangan3; ?><?php endif ?></option>
								<option value="Tidak ada">Tidak ada</option>
								<option value="Draft">Draft</option>
								<option value="Submitted ">Submitted</option>
								<option value="Accepted">Accepted</option>
								<option value="Terbit">Terbit</option>
								</select>
							<?php else : ?>
								<select name="keterangan3" class="form-control form-control-sm" aria-label="keterangan3">
									<option value="Tidak ada">Tidak ada</option>
		  						<option value="Draft">Draft</option>
		  						<option value="Submitted ">Submitted</option>
		  						<option value="Accepted">Accepted</option>
									<option value="Terbit">Terbit</option>
								</select>
								<?php endif; ?>
				      </div>
							<div class="td text-center">
								<input readonly name="ket3_bobot" type="number" class="form-control form-control-sm" id="ket3_bobot" min="0" max="100" value="30">
				      </div>
							<div class="td">
		    					<input name="ket3_skor" type="number" class="form-control form-control-sm" id="ket3_skor" min="0" max="7" value="<?php if (!empty($laporan_monev->komponen_skor3)) : ?><?= $laporan_monev->komponen_skor3; ?><?php endif ?>">
				      </div>
							<div class="td">
		    					<input name="ket3_nilai" type="text" class="form-control form-control-sm" id="ket3_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai3)) : ?><?= $laporan_monev->komponen_nilai3; ?><?php endif ?>" readonly>
				      </div>
							</div>
								<div class="tr">
			 					 <div class="td"></div>
			 					 <div class="td font-weight-bold">Luaran Tambahan</div>
			 				 </div>
							 <div class="tr">
			 		      <div class="td">1</div>
			 		      <div class="td">
			 		      	Jurnal Nasional Terakreditasi /Jurnal Internasional / Jurnal Internasional Bereputasi
			 		      </div>
			 		      <div class="td">
									<?php if($status->status == 1) : ?>
									<select name="tambahan1" class="form-control form-control-sm" aria-label="tambahan1" id="tambahan1">
									<option readonly selected value="<?= $laporan_monev->komponen_keterangan_tambahan1 ?>"><?php if (!empty($laporan_monev->komponen_keterangan_tambahan1)) : ?>Pilihan Awal: <?= $laporan_monev->komponen_keterangan_tambahan1; ?><?php endif ?></option>
									<option value="Tidak ada">Tidak ada</option>
									<option value="Draft">Draft</option>
									<option value="Submitted">Submitted</option>
									<option value="Accepted">Accepted</option>
									<option value="Terbit">Terbit</option>
									</select>
									<?php else : ?>
			 						<select name="tambahan1" class="form-control form-control-sm" aria-label="tambahan1">
			   						<option value="Tidak ada">Tidak ada</option>
			   						<option value="Draft">Draft</option>
			   						<option value="Submitted">Submitted</option>
			   						<option value="Accepted">Accepted</option>
			 							<option value="Terbit">Terbit</option>
			 						</select>
									<?php endif; ?>
			 		      </div>
			 					<div class="td">
			 							<input name="tambahan1_bobot" type="number" class="form-control form-control-sm" id="tambahan1_bobot" min="0" max="100" value="<?php if (!empty($laporan_monev->komponen_bobot_tambahan1)) : ?><?= $laporan_monev->komponen_bobot_tambahan1; ?><?php endif ?>">
			 		      </div>
			 					<div class="td">
			 						<input name="tambahan1_skor" type="number" class="form-control form-control-sm" id="tambahan1_skor" min="0" max="7" value="<?php if (!empty($laporan_monev->komponen_skor_tambahan1)) : ?><?= $laporan_monev->komponen_skor_tambahan1; ?><?php endif ?>">
			 		      </div>
			 					<div class="td">
			     					<input name="tambahan1_nilai" type="text" class="form-control form-control-sm" id="tambahan1_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai_tambahan1)) : ?><?= $laporan_monev->komponen_nilai_tambahan1; ?><?php endif ?>" readonly>
			 		      </div>
			 		    </div>
							<div class="tr">
							 <div class="td">2</div>
							 <div class="td">
							 	HKI berupa Paten, Paten Sederhana, Hak Cipta, Perlindungan Varietas Tanaman, Desain Tata Letak Sirkuit Terpadu, Naskah kebijakan dengan status Terdaftar
							 </div>
							 <div class="td">
								 <?php if($status->status == 1) : ?>
								 <select name="tambahan2" class="form-control form-control-sm" aria-label="tambahan2" id="tambahan2">
								 <option readonly selected value="<?= $laporan_monev->komponen_keterangan_tambahan2 ?>"><?php if (!empty($laporan_monev->komponen_keterangan_tambahan2)) : ?>Pilihan Awal: <?= $laporan_monev->komponen_keterangan_tambahan2; ?><?php endif ?></option>
								 <option value="Tidak ada">Tidak ada</option>
								 <option value="Draft">Draft</option>
								 <option value="Terdaftar">Terdaftar</option>
								 <option value="Granted">Granted</option>
								 </select>
								 <?php else : ?>
								 <select name="tambahan2" class="form-control form-control-sm" aria-label="tambahan2">
									 <option value="Tidak ada">Tidak ada</option>
									 <option value="Draft">Draft</option>
									 <option value="Terdaftar">Terdaftar</option>
									 <option value="Granted">Granted</option>
								 </select>
								 <?php endif; ?>
							 </div>
							 <div class="td">
									 <input name="tambahan2_bobot" type="number" class="form-control form-control-sm" id="tambahan2_bobot" min="0" max="100" value="<?php if (!empty($laporan_monev->komponen_bobot_tambahan2)) : ?><?= $laporan_monev->komponen_bobot_tambahan2; ?><?php endif ?>">
							 </div>
							 <div class="td">
								 <input name="tambahan2_skor" type="number" class="form-control form-control-sm" id="tambahan2_skor" min="0" max="7" value="<?php if (!empty($laporan_monev->komponen_skor_tambahan2)) : ?><?= $laporan_monev->komponen_skor_tambahan2; ?><?php endif ?>">
							 </div>
							 <div class="td">
									 <input name="tambahan2_nilai" type="text" class="form-control form-control-sm" id="tambahan2_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai_tambahan2)) : ?><?= $laporan_monev->komponen_nilai_tambahan2; ?><?php endif ?>" readonly>
							 </div>
						 </div>
						 <div class="tr">
							<div class="td">3</div>
							<div class="td">
								Draft Buku hasil penelitian atau bahan ajar
							</div>
							<div class="td">
								<?php if($status->status == 1) : ?>
								<select name="tambahan3" class="form-control form-control-sm" aria-label="tambahan3" id="tambahan3">
								<option readonly selected value="<?= $laporan_monev->komponen_keterangan_tambahan3 ?>"><?php if (!empty($laporan_monev->komponen_keterangan_tambahan3)) : ?>Pilihan Awal: <?= $laporan_monev->komponen_keterangan_tambahan3; ?><?php endif ?></option>
								<option value="Tidak ada">Tidak ada</option>
								<option value="Draf">Draf</option>
								<option value="Editing">Editing</option>
								<option value="Sudah Terbit">Sudah Terbit</option>
								</select>
								<?php else : ?>
								<select name="tambahan3" class="form-control form-control-sm" aria-label="tambahan3">
									<option value="Tidak ada">Tidak ada</option>
									<option value="Draf">Draf</option>
									<option value="Editing">Editing</option>
									<option value="Sudah Terbit">Sudah Terbit</option>
								</select>
								<?php endif; ?>
							</div>
							<div class="td">
									<input name="tambahan3_bobot" type="number" class="form-control form-control-sm" id="tambahan3_bobot" min="0" max="100" value="<?php if (!empty($laporan_monev->komponen_bobot_tambahan3)) : ?><?= $laporan_monev->komponen_bobot_tambahan3; ?><?php endif ?>">
							</div>
							<div class="td">
								<input name="tambahan3_skor" type="number" class="form-control form-control-sm" id="tambahan3_skor" min="0" max="7" value="<?php if (!empty($laporan_monev->komponen_skor_tambahan3)) : ?><?= $laporan_monev->komponen_skor_tambahan3; ?><?php endif ?>">
							</div>
							<div class="td">
									<input name="tambahan3_nilai" type="text" class="form-control form-control-sm" id="tambahan3_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai_tambahan3)) : ?><?= $laporan_monev->komponen_nilai_tambahan3; ?><?php endif ?>" readonly>
							</div>
						</div>
						<div class="tr">
						 <div class="td">4</div>
						 <div class="td">
						 	Book chapter yang diterbitkan oleh penerbit bereputasi dan ber-ISBN
						 </div>
						 <div class="td">
							 <?php if($status->status == 1) : ?>
							 <select name="tambahan4" class="form-control form-control-sm" aria-label="tambahan4" id="tambahan4">
							 <option readonly selected value="<?= $laporan_monev->komponen_keterangan_tambahan4 ?>"><?php if (!empty($laporan_monev->komponen_keterangan_tambahan4)) : ?>Pilihan Awal: <?= $laporan_monev->komponen_keterangan_tambahan4; ?><?php endif ?></option>
							 <option value="Tidak ada">Tidak ada</option>
							 <option value="Draf">Draf</option>
							 <option value="Produk">Produk</option>
							 <option value="Penerapan">Penerapan</option>
							 </select>
							 <?php else : ?>
							 <select name="tambahan4" class="form-control form-control-sm" aria-label="tambahan4">
								 <option value="Tidak ada">Tidak ada</option>
								 <option value="Draf">Draf</option>
								 <option value="Produk">Produk</option>
								 <option value="Penerapan">Penerapan</option>
							 </select>
							 <?php endif; ?>
						 </div>
						 <div class="td">
								 <input name="tambahan4_bobot" type="number" class="form-control form-control-sm" id="tambahan4_bobot" min="0" max="100" value="<?php if (!empty($laporan_monev->komponen_bobot_tambahan4)) : ?><?= $laporan_monev->komponen_bobot_tambahan4; ?><?php endif ?>">
						 </div>
						 <div class="td">
							 <input name="tambahan4_skor" type="number" class="form-control form-control-sm" id="tambahan4_skor" min="0" max="7" value="<?php if (!empty($laporan_monev->komponen_skor_tambahan4)) : ?><?= $laporan_monev->komponen_skor_tambahan4; ?><?php endif ?>">
						 </div>
						 <div class="td">
								 <input name="tambahan4_nilai" type="text" class="form-control form-control-sm" id="tambahan4_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai_tambahan4)) : ?><?= $laporan_monev->komponen_bobot_tambahan4; ?><?php endif ?>" readonly>
						 </div>
					 </div>
					 <div class="tr">
						<div class="td">5</div>
						<div class="td">
							Keynote speaker dalam temu ilmiah (internasional, nasional dan lokal)
						</div>
						<div class="td">
							<?php if($status->status == 1) : ?>
							<select name="tambahan5" class="form-control form-control-sm" aria-label="tambahan5" id="tambahan5">
							<option readonly selected value="<?= $laporan_monev->komponen_keterangan_tambahan5 ?>"><?php if (!empty($laporan_monev->komponen_keterangan_tambahan5)) : ?>Pilihan Awal: <?= $laporan_monev->komponen_keterangan_tambahan5; ?><?php endif ?></option>
							<option value="Tidak ada">Tidak ada</option>
							<option value="Draft">Draft</option>
							<option value="Submitted ">Submitted</option>
							<option value="Accepted">Accepted</option>
							<option value="Terbit">Terbit</option>
							</select>
							<?php else : ?>
							<select name="tambahan5" class="form-control form-control-sm" aria-label="tambahan5">
								<option value="Tidak ada">Tidak ada</option>
								<option value="Draft">Draft</option>
								<option value="Submitted ">Submitted</option>
								<option value="Accepted">Accepted</option>
								<option value="Terbit">Terbit</option>
							</select>
							<?php endif; ?>
						</div>
						<div class="td">
								<input name="tambahan5_bobot" type="number" class="form-control form-control-sm" id="tambahan5_bobot" min="0" max="100" value="<?php if (!empty($laporan_monev->komponen_bobot_tambahan5)) : ?><?= $laporan_monev->komponen_bobot_tambahan5; ?><?php endif ?>">
						</div>
						<div class="td">
							<input name="tambahan5_skor" type="number" class="form-control form-control-sm" id="tambahan5_skor" min="0" max="7" value="<?php if (!empty($laporan_monev->komponen_skor_tambahan5)) : ?><?= $laporan_monev->komponen_skor_tambahan5; ?><?php endif ?>">
						</div>
						<div class="td">
								<input name="tambahan5_nilai" type="text" class="form-control form-control-sm" id="tambahan5_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai_tambahan5)) : ?><?= $laporan_monev->komponen_nilai_tambahan5; ?><?php endif ?>" readonly>
						</div>
					</div>
					<div class="tr">
					 <div class="td">6</div>
					 <div class="td">
						 Pembicara kunci/visiting lecturer (internasional)
					 </div>
					 <div class="td">
						 <?php if($status->status == 1) : ?>
						 <select name="tambahan6" class="form-control form-control-sm" aria-label="tambahan6" id="tambahan6">
						 <option readonly selected value="<?= $laporan_monev->komponen_keterangan_tambahan6 ?>"><?php if (!empty($laporan_monev->komponen_keterangan_tambahan6)) : ?>Pilihan Awal: <?= $laporan_monev->komponen_keterangan_tambahan6; ?><?php endif ?></option>
						 <option value="Tidak ada">Tidak ada</option>
						 <option value="Draft">Draft</option>
						 <option value="Submitted ">Submitted</option>
						 <option value="Accepted">Accepted</option>
						 <option value="Terbit">Terbit</option>
						 </select>
						 <?php else : ?>
						 <select name="tambahan6" class="form-control form-control-sm" aria-label="tambahan5">
							 <option value="Tidak ada">Tidak ada</option>
							 <option value="Draft">Draft</option>
							 <option value="Submitted ">Submitted</option>
							 <option value="Accepted">Accepted</option>
							 <option value="Terbit">Terbit</option>
						 </select>
						 <?php endif; ?>
					 </div>
					 <div class="td">
							 <input name="tambahan6_bobot" type="number" class="form-control form-control-sm" id="tambahan6_bobot" min="0" max="100" value="<?php if (!empty($laporan_monev->komponen_bobot_tambahan6)) : ?><?= $laporan_monev->komponen_bobot_tambahan6; ?><?php endif ?>">
					 </div>
					 <div class="td">
						 <input name="tambahan6_skor" type="number" class="form-control form-control-sm" id="tambahan6_skor" min="0" max="7" value="<?php if (!empty($laporan_monev->komponen_skor_tambahan6)) : ?><?= $laporan_monev->komponen_skor_tambahan6; ?><?php endif ?>">
					 </div>
					 <div class="td">
							 <input name="tambahan6_nilai" type="text" class="form-control form-control-sm" id="tambahan6_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai_tambahan6)) : ?><?= $laporan_monev->komponen_nilai_tambahan6; ?><?php endif ?>" readonly>
					 </div>
				 </div>
				 <div class="tr">
					<div class="td">7</div>
					<div class="td">
						Dokumen feasibility study, business plan
					</div>
					<div class="td">
						<?php if($status->status == 1) : ?>
						<select name="tambahan7" class="form-control form-control-sm" aria-label="tambahan7" id="tambahan7">
						<option readonly selected value="<?= $laporan_monev->komponen_keterangan_tambahan7 ?>"><?php if (!empty($laporan_monev->komponen_keterangan_tambahan7)) : ?>Pilihan Awal: <?= $laporan_monev->komponen_keterangan_tambahan7; ?><?php endif ?></option>
						<option value="Tidak ada">Tidak ada</option>
						<option value="Draft">Draft</option>
						<option value="Submitted ">Submitted</option>
						<option value="Accepted">Accepted</option>
						<option value="Terbit">Terbit</option>
						</select>
						<?php else : ?>
						<select name="tambahan7" class="form-control form-control-sm" aria-label="tambahan7">
							<option value="Tidak ada">Tidak ada</option>
							<option value="Draft">Draft</option>
							<option value="Submitted ">Submitted</option>
							<option value="Accepted">Accepted</option>
							<option value="Terbit">Terbit</option>
						</select>
						<?php endif; ?>
					</div>
					<div class="td">
							<input name="tambahan7_bobot" type="number" class="form-control form-control-sm" id="tambahan7_bobot" min="0" max="100" value="<?php if (!empty($laporan_monev->komponen_bobot_tambahan7)) : ?><?= $laporan_monev->komponen_bobot_tambahan7; ?><?php endif ?>">
					</div>
					<div class="td">
						<input name="tambahan7_skor" type="number" class="form-control form-control-sm" id="tambahan7_skor" min="0" max="7" value="<?php if (!empty($laporan_monev->komponen_skor_tambahan7)) : ?><?= $laporan_monev->komponen_skor_tambahan7; ?><?php endif ?>">
					</div>
					<div class="td">
							<input name="tambahan7_nilai" type="text" class="form-control form-control-sm" id="tambahan7_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai_tambahan7)) : ?><?= $laporan_monev->komponen_nilai_tambahan7; ?><?php endif ?>" readonly>
					</div>
				</div>
				<div class="tr">
				 <div class="td">8</div>
				 <div class="td">
					 Naskah akademik (policy brief, rekomendasi kebijakan atau model kebijakan strategis)
				 </div>
				 <div class="td">
					 <?php if($status->status == 1) : ?>
					 <select name="tambahan8" class="form-control form-control-sm" aria-label="tambahan8" id="tambahan8">
					 <option readonly selected value="<?= $laporan_monev->komponen_keterangan_tambahan8 ?>"><?php if (!empty($laporan_monev->komponen_keterangan_tambahan8)) : ?>Pilihan Awal: <?= $laporan_monev->komponen_keterangan_tambahan8; ?><?php endif ?></option>
					 <option value="Tidak ada">Tidak ada</option>
					 <option value="Draft">Draft</option>
					 <option value="Submitted ">Submitted</option>
					 <option value="Accepted">Accepted</option>
					 <option value="Terbit">Terbit</option>
					 </select>
					 <?php else : ?>
					 <select name="tambahan8" class="form-control form-control-sm" aria-label="tambahan5">
						 <option value="Tidak ada">Tidak ada</option>
						 <option value="Draft">Draft</option>
						 <option value="Submitted ">Submitted</option>
						 <option value="Accepted">Accepted</option>
						 <option value="Terbit">Terbit</option>
					 </select>
					 <?php endif; ?>
				 </div>
				 <div class="td">
						 <input name="tambahan8_bobot" type="number" class="form-control form-control-sm" id="tambahan8_bobot" min="0" max="100" value="<?php if (!empty($laporan_monev->komponen_bobot_tambahan8)) : ?><?= $laporan_monev->komponen_bobot_tambahan8; ?><?php endif ?>">
				 </div>
				 <div class="td">
					 <input name="tambahan8_skor" type="number" class="form-control form-control-sm" id="tambahan8_skor" min="0" max="7" value="<?php if (!empty($laporan_monev->komponen_skor_tambahan8)) : ?><?= $laporan_monev->komponen_skor_tambahan8; ?><?php endif ?>">
				 </div>
				 <div class="td">
						 <input name="tambahan8_nilai" type="text" class="form-control form-control-sm" id="tambahan8_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai_tambahan8)) : ?><?= $laporan_monev->komponen_nilai_tambahan8; ?><?php endif ?>" readonly>
				 </div>
			 </div>
			 <div class="tr">
				<div class="td"></div>
				<div class="td font-weight-bold">Total Nilai Luaran Wajib</div>
				<div class="td"></div>
				<div class="td"></div>
				<div class="td"></div>
				<div class="td">
					<input name="total_nilai_luaran_wajib" type="text" class="form-control form-control-sm" id="total_nilai_luaran_wajib" value="<?php if (!empty($laporan_monev->total_nilai_wajib)) : ?><?= $laporan_monev->total_nilai_wajib; ?><?php endif ?>" readonly>
				</div>
			</div>
			    </div>
					<button id="btnHitungJumlahNilai" type="button" class="btn btn-danger">Hitung Jumlah Nilai Luaran Wajib</button>
			  </div>
			</div>
			<div style="font-size: 14px">
				<p style="margin: 0; padding: 0;">Keterangan:</p>
				<p style="margin: 0; padding: 0;">Skor: 1, 2, 3, 5, 6, 7 (1 = buruk, 2 = sangat kurang, 3 = kurang, 5 = cukup, 6 = baik, 7 = sangat baik) Nilai : bobot × skor</p>
				<p style="margin: 0; padding: 0;">Skor: 1, 2, 3, 5, 6, 7 (1: tidak ada draft; 3: draft; 5: Submitted/reviewed/editing; 6: Accepted; 7: Terbit)</p>
				<p style="margin: 0; padding: 0;">Luaran tambahan dinilai lebih lanjut. Kolom diisi sesuai dengan capaian</p>
			</div>
		<div class="form-group mt-5">
			<textarea value="" class="form-control" id="masukan" name="masukan" rows="4" placeholder="Ketik Masukan Disini"><?php if (!empty($masukan)) : ?><?= $masukan; ?><?php endif ?></textarea>
		</div>

		<?php if ($status->status == 0 || $status->status == 1) { ?>
			<input type="hidden" name="id_kerjaan_monev" value="<?= $status->id_kerjaan_monev ?>">
		<?php } ?>
		<input type="hidden" name="jenis_proposal" value="<?= $namakelompok ?>">

		<input type="hidden" name="nama_ketua" value="<?= $dt_proposal->nama_ketua ?>">

		<?php if ($status->status == 0) { ?>
			<div class="col-md-6">
				<button type="submit" style="margin: auto; width:auto; float:right;" class="btn btn-success"><i class="fa fa-paste"></i> Kirim Penilaian</button>
			<?php } elseif ($status->status == 1) { ?>
				<button type="submit" style="margin: auto; width:auto; float:right;" class="btn btn-warning"><i class="fa fa-paste"></i> Edit Penilaian</button>
			<?php } ?>
			</div>
	</form>
	</div>
        </div>
      </div>
  </section>
	<script type="text/javascript" src="<?= base_url() . JS_UMUM . 'content_penelitian_pemonev.js?' . 'random=' . uniqid() ?> "></script>
	<script type="text/javascript" src="<?= base_url() . JS_UMUM . 'jumlah_total_content_penelitian_PKK.js?' . 'random=' . uniqid() ?> "></script>
