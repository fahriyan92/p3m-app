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
                      <input disabled type="text" class="form-control" id="inputJudul" placeholder="Judul Penelitian" value="<?= $dt_proposal->judul; ?>" name="judulPenelitianDosenPNBP" disabled>
                  </div>
              </div>
          </div>
          <?php endif; ?>
          <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                      <div class="form-group">
                          <label for="">Nama Ketua</label>
                          <input disabled readonly class="form-control text-capitalize" type="text" value="<?= $dt_proposal->nama_ketua ?> - <?= $dt_proposal->nidn_ketua ?>">
                      </div>
                  </div>
              </div>
              <div class="col-sm-6">
                  <div class="form-group">
                      <label for="biayadiusulkan">Biaya yang diusulkan</label>
                      <input disabled type="text" class="form-control" id="biayadiusulkan" value="<?= rupiah($dt_proposal->biaya_usulan); ?>" placeholder="Rp.8.500.000,-" name="biayadiusulkan" disabled>
                  </div>
              </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                  <div class="form-group">
                      <label for="tglmulai">Lama Penelitian (mulai)</label>
                      <input disabled type="date" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" id="tglmulai" placeholder="mulai" name="tglmulai" value="<?= $dt_proposal->mulai; ?>" disabled>
                  </div>
                </div>
                <div class="col-sm-1" style="text-align: center; margin-top:36px">
                    <span> - </span>
                </div>
                <div class="col-sm-5">
                  <div class="form-group">
                      <label for="tglakhir">(akhir)</label>
                      <input disabled type="date" class="form-control" id="tglakhir" data-inputmask-inputformat="dd/mm/yyyy" placeholder="akhir" name="tglakhir" value="<?= $dt_proposal->akhir; ?>" disabled>
                  </div>
                </div>
              </div>
<?php if($pemonev !== NULL) : ?>
	<div class="row">
			<div class="div-table w-100">
			  <div class="table">
			    <div class="tr">
			      <div class="td">No</div>
			      <div class="td" style="width: 30%">Komponen Penilaian</div>
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
			      	Artikel prosiding ber-ISBN
			      </div>
			      <div class="td">
							<select disabled disabled name="keterangan1" class="form-control form-control-sm" aria-label="keterangan1" id="keterangan1">
								<option disabled selected><?php if (!empty($laporan_monev->komponen_keterangan1)) : ?><?= $laporan_monev->komponen_keterangan1; ?><?php endif ?></option>
	  						<option value="Tidak ada">Tidak ada</option>
	  						<option value="Draf">Draf</option>
	  						<option value="Submitted / Review">Submitted / Review</option>
	  						<option value="Accepted">Accepted</option>
								<option value="Terbit">Terbit</option>
							</select>
			      </div>
						<div class="td">
								<input disabled disabled name="ket1_bobot" type="number" name="ket1_bobot" onkeyup="penjumlahan" class="form-control form-control-sm" id="ket1_bobot" min="1" max="100" value="<?php if (!empty($laporan_monev->komponen_bobot1)) : ?><?= $laporan_monev->komponen_bobot1; ?><?php endif ?>">
			      </div>
						<div class="td">
							<input disabled disabled type="number" name="ket1_skor" onkeyup="penjumlahan" class="form-control form-control-sm" id="ket1_skor" min="1" max="7" value="<?php if (!empty($laporan_monev->komponen_skor1)) : ?><?= $laporan_monev->komponen_skor1; ?><?php endif ?>">
			      </div>
						<div class="td">
	    					<input disabled disabled type="text" name="ket1_nilai" class="form-control form-control-sm" id="ket1_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai1)) : ?><?= $laporan_monev->komponen_nilai1; ?><?php endif ?>" readonly>
			      </div>
			    </div>
			    <div class="tr">
			      <div class="td">2</div>
			      <div class="td">
							Artikel pada media massa cetak/elektronik
			      </div>
			      <div class="td">
							<div class="td">
								<select disabled disabled name="keterangan2" class="form-control form-control-sm" aria-label="keterangan2">
									<option disabled selected><?php if (!empty($laporan_monev->komponen_keterangan2)) : ?><?= $laporan_monev->komponen_keterangan2; ?><?php endif ?></option>
		  						<option value="Tidak Ada">Tidak ada</option>
		  						<option value="Draf">Draf</option>
		  						<option value="Editing">Editing</option>
		  						<option value="Terbit">Terbit</option>
								</select>
				      </div>
			      </div>
						<div class="td text-center">
							<input disabled disabled name="ket2_bobot" type="number" class="form-control form-control-sm" id="ket2_bobot" min="1" max="100" value="<?php if (!empty($laporan_monev->komponen_bobot2)) : ?><?= $laporan_monev->komponen_bobot2; ?><?php endif ?>">
			      </div>
						<div class="td">
	    					<input disabled name="ket2_skor" type="number" class="form-control form-control-sm" id="ket2_skor" min="1" max="7" value="<?php if (!empty($laporan_monev->komponen_skor2)) : ?><?= $laporan_monev->komponen_skor2; ?><?php endif ?>">
			      </div>
						<div class="td">
	    					<input disabled disabled name="ket2_nilai" type="text" class="form-control form-control-sm" id="ket2_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai2)) : ?><?= $laporan_monev->komponen_nilai2; ?><?php endif ?>" readonly>
			      </div>
						</div>
						<div class="tr">
				      <div class="td">3</div>
				      <div class="td">
					  Peningkatan level keberdayaan mitra
				      </div>
				      <div class="td">
								<select disabled name="keterangan3" class="form-control form-control-sm" aria-label="keterangan3">
									<option disabled selected><?php if (!empty($laporan_monev->komponen_keterangan3)) : ?><?= $laporan_monev->komponen_keterangan3; ?><?php endif ?></option>
									<option value="Tidak ada">Tidak ada</option>
		  						<option value="Draf">Draf</option>
		  						<option value="Submitted / Review">Submitted / Review</option>
		  						<option value="Accepted">Accepted</option>
									<option value="Terbit">Terbit</option>
								</select>
				      </div>
							<div class="td text-center">
								<input disabled name="ket3_bobot" type="number" class="form-control form-control-sm" id="ket3_bobot" min="1" max="100" value="<?php if (!empty($laporan_monev->komponen_bobot3)) : ?><?= $laporan_monev->komponen_bobot3; ?><?php endif ?>">
				      </div>
							<div class="td">
		    					<input disabled name="ket3_skor" type="number" class="form-control form-control-sm" id="ket3_skor" min="1" max="7" value="<?php if (!empty($laporan_monev->komponen_skor3)) : ?><?= $laporan_monev->komponen_skor3; ?><?php endif ?>">
				      </div>
							<div class="td">
		    					<input disabled name="ket3_nilai" type="text" class="form-control form-control-sm" id="ket3_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai3)) : ?><?= $laporan_monev->komponen_nilai3; ?><?php endif ?>" readonly>
				      </div>
							</div>
							<div class="tr">
					      <div class="td">4</div>
					      <div class="td">
						  Video kegiatan yang diupload di youtube P3M
					      </div>
					      <div class="td">
									<select disabled name="keterangan4" class="form-control form-control-sm" aria-label="keterangan3">
										<option disabled selected><?php if (!empty($laporan_monev->komponen_keterangan4)) : ?><?= $laporan_monev->komponen_keterangan4; ?><?php endif ?></option>
										<option value="Tidak ada">Tidak ada</option>
			  						<option value="Draf">Draf</option>
			  						<option value="Submitted / Review">Submitted / Review</option>
			  						<option value="Accepted">Accepted</option>
										<option value="Terbit">Terbit</option>
									</select>
					      </div>
								<div class="td text-center">
									<input disabled name="ket4_bobot" type="number" class="form-control form-control-sm" id="ket4_bobot" min="1" max="100" value="<?php if (!empty($laporan_monev->komponen_bobot4)) : ?><?= $laporan_monev->komponen_bobot4; ?><?php endif ?>">
					      </div>
								<div class="td">
			    					<input disabled name="ket4_skor" type="number" class="form-control form-control-sm" id="ket4_skor" min="1" max="7" value="<?php if (!empty($laporan_monev->komponen_skor4)) : ?><?= $laporan_monev->komponen_skor4; ?><?php endif ?>">
					      </div>
								<div class="td">
			    					<input disabled name="ket4_nilai" type="text" class="form-control form-control-sm" id="ket4_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai4)) : ?><?= $laporan_monev->komponen_nilai4; ?><?php endif ?>" readonly>
					      </div>
								</div>
								<div class="tr">
						      <div class="td">5</div>
						      <div class="td">
							  KI (berupa Hak Cipta) atas nama Polije
						      </div>
						      <div class="td">
										<select disabled name="keterangan4" class="form-control form-control-sm" aria-label="keterangan3">
											<option disabled selected><?php if (!empty($laporan_monev->komponen_keterangan5)) : ?><?= $laporan_monev->komponen_keterangan5; ?><?php endif ?></option>
											<option value="Tidak ada">Tidak ada</option>
				  						<option value="Draf">Draf</option>
				  						<option value="Submitted / Review">Submitted / Review</option>
				  						<option value="Accepted">Accepted</option>
											<option value="Terbit">Terbit</option>
										</select>
						      </div>
									<div class="td text-center">
										<input disabled name="ket5_bobot" type="number" class="form-control form-control-sm" id="ket5_bobot" min="1" max="100" value="<?php if (!empty($laporan_monev->komponen_bobot4)) : ?><?= $laporan_monev->komponen_bobot4; ?><?php endif ?>">
						      </div>
									<div class="td">
				    					<input disabled name="ket5_skor" type="number" class="form-control form-control-sm" id="ket5_skor" min="1" max="7" value="<?php if (!empty($laporan_monev->komponen_skor4)) : ?><?= $laporan_monev->komponen_skor4; ?><?php endif ?>">
						      </div>
									<div class="td">
				    					<input disabled name="ket5_nilai" type="text" class="form-control form-control-sm" id="ket5_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai4)) : ?><?= $laporan_monev->komponen_nilai4; ?><?php endif ?>" readonly>
						      </div>
									</div>
								<div class="tr">
			 					 <div class="td"></div>
			 					 <div class="td font-weight-bold">Luaran Tambahan</div>
			 				 </div>
							 <div class="tr">
			 		      <div class="td">1</div>
			 		      <div class="td">
			 		      	Artikel jurnal pengabdian masyarakat
			 		      </div>
			 		      <div class="td">
			 						<select disabled name="tambahan1" class="form-control form-control-sm" aria-label="tambahan1">
										<option disabled selected><?php if (!empty($laporan_monev->komponen_keterangan_tambahan1)) : ?><?= $laporan_monev->komponen_keterangan_tambahan1; ?><?php endif ?></option>
			   						<option value="Tidak ada">Tidak ada</option>
			   						<option value="Draf">Draf</option>
			   						<option value="Submitted / Review">Submitted / Review</option>
			   						<option value="Accepted">Accepted</option>
			 							<option value="Terbit">Terbit</option>
			 						</select>
			 		      </div>
			 					<div class="td">
			 							<input disabled name="tambahan1_bobot" type="number" class="form-control form-control-sm" id="tambahan1_bobot" min="1" max="100" value="<?php if (!empty($laporan_monev->komponen_bobot_tambahan1)) : ?><?= $laporan_monev->komponen_bobot_tambahan1; ?><?php endif ?>">
			 		      </div>
			 					<div class="td">
			 						<input disabled name="tambahan1_skor" type="number" class="form-control form-control-sm" id="tambahan1_skor" min="1" max="7" value="<?php if (!empty($laporan_monev->komponen_skor_tambahan1)) : ?><?= $laporan_monev->komponen_skor_tambahan1; ?><?php endif ?>">
			 		      </div>
			 					<div class="td">
			     					<input disabled name="tambahan1_nilai" type="text" class="form-control form-control-sm" id="tambahan1_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai_tambahan1)) : ?><?= $laporan_monev->komponen_nilai_tambahan1; ?><?php endif ?>" readonly>
			 		      </div>
			 		    </div>
							<div class="tr">
							 <div class="td">2</div>
							 <div class="td">
							 Kekayaan Intelektual (KI)
							 </div>
							 <div class="td">
								 <select disabled name="tambahan2" class="form-control form-control-sm" aria-label="tambahan2">
									 <option disabled selected><?php if (!empty($laporan_monev->komponen_keterangan_tambahan2)) : ?><?= $laporan_monev->komponen_keterangan_tambahan2; ?><?php endif ?></option>
									 <option value="Tidak ada">Tidak ada</option>
									 <option value="Draf">Draf</option>
									 <option value="Editing">Editing</option>
									 <option value="Sudah Terbit">Sudah Terbit</option>
								 </select>
							 </div>
							 <div class="td">
									 <input disabled name="tambahan2_bobot" type="number" class="form-control form-control-sm" id="tambahan2_bobot" min="1" max="100" value="<?php if (!empty($laporan_monev->komponen_bobot_tambahan2)) : ?><?= $laporan_monev->komponen_bobot_tambahan2; ?><?php endif ?>">
							 </div>
							 <div class="td">
								 <input disabled name="tambahan2_skor" type="number" class="form-control form-control-sm" id="tambahan2_skor" min="1" max="7" value="<?php if (!empty($laporan_monev->komponen_skor_tambahan2)) : ?><?= $laporan_monev->komponen_skor_tambahan2; ?><?php endif ?>">
							 </div>
							 <div class="td">
									 <input disabled name="tambahan2_nilai" type="text" class="form-control form-control-sm" id="tambahan2_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai_tambahan2)) : ?><?= $laporan_monev->komponen_nilai_tambahan2; ?><?php endif ?>" readonly>
							 </div>
						 </div>
						 <div class="tr">
							<div class="td">3</div>
							<div class="td">
							buku ber ISBN
							</div>
							<div class="td">
								<select disabled name="tambahan3" class="form-control form-control-sm" aria-label="tambahan3">
									<option disabled selected><?php if (!empty($laporan_monev->komponen_keterangan_tambahan3)) : ?><?= $laporan_monev->komponen_keterangan_tambahan3; ?><?php endif ?></option>
									<option value="Tidak ada">Tidak ada</option>
									<option value="Draf">Draf</option>
									<option value="Editing">Editing</option>
									<option value="Sudah Terbit">Sudah Terbit</option>
								</select>
							</div>
							<div class="td">
									<input disabled name="tambahan3_bobot" type="number" class="form-control form-control-sm" id="tambahan3_bobot" min="1" max="100" value="<?php if (!empty($laporan_monev->komponen_bobot_tambahan3)) : ?><?= $laporan_monev->komponen_bobot_tambahan3; ?><?php endif ?>">
							</div>
							<div class="td">
								<input disabled name="tambahan3_skor" type="number" class="form-control form-control-sm" id="tambahan3_skor" min="1" max="7" value="<?php if (!empty($laporan_monev->komponen_skor_tambahan3)) : ?><?= $laporan_monev->komponen_skor_tambahan3; ?><?php endif ?>">
							</div>
							<div class="td">
									<input disabled name="tambahan3_nilai" type="text" class="form-control form-control-sm" id="tambahan3_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai_tambahan3)) : ?><?= $laporan_monev->komponen_nilai_tambahan3; ?><?php endif ?>" readonly>
							</div>
						</div>
						<div class="tr">
						 <div class="td">4</div>
						 <div class="td">
						 bahan ajar
						 </div>
						 <div class="td">
							 <select disabled name="tambahan4" class="form-control form-control-sm" aria-label="tambahan4">
								 <option disabled selected><?php if (!empty($laporan_monev->komponen_keterangan_tambahan4)) : ?><?= $laporan_monev->komponen_keterangan_tambahan4; ?><?php endif ?></option>
								 <option value="Tidak ada">Tidak ada</option>
								 <option value="Draf">Draf</option>
								 <option value="Produk">Produk</option>
								 <option value="Penerapan">Penerapan</option>
							 </select>
						 </div>
						 <div class="td">
								 <input disabled name="tambahan4_bobot" type="number" class="form-control form-control-sm" id="tambahan4_bobot" min="1" max="100" value="<?php if (!empty($laporan_monev->komponen_bobot_tambahan4)) : ?><?= $laporan_monev->komponen_bobot_tambahan4; ?><?php endif ?>">
						 </div>
						 <div class="td">
							 <input disabled name="tambahan4_skor" type="number" class="form-control form-control-sm" id="tambahan4_skor" min="1" max="7" value="<?php if (!empty($laporan_monev->komponen_skor_tambahan4)) : ?><?= $laporan_monev->komponen_skor_tambahan4; ?><?php endif ?>">
						 </div>
						 <div class="td">
								 <input disabled name="tambahan4_nilai" type="text" class="form-control form-control-sm" id="tambahan4_nilai" value="<?php if (!empty($laporan_monev->komponen_nilai_tambahan4)) : ?><?= $laporan_monev->komponen_bobot_tambahan4; ?><?php endif ?>" readonly>
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
			  </div>
			</div>
		<div class="form-group mt-5">
			<textarea disabled value="" class="form-control" id="masukan" name="masukan" rows="4" placeholder="Ketik Masukan Disini"><?php if (!empty($rekom->masukan_pemonev)) : ?><?= $rekom->masukan_pemonev; ?><?php endif ?></textarea>
		</div>
    <a target="_blank" href="<?= base_url("pdfexport/pengabdian/" . $idproposal . '/' . $idevents); ?>"><button type="button" class="btn btn-success">Export PDF</button></a>
	<?php else : ?>
		<h1 class="mt-5" style="text-align: center;"> Proposal Masih Belum Di Monev</h1>
	<?php endif ?>
	</div>
        </div>
      </div>
  </section>
