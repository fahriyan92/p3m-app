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
                          <input readonly class="form-control text-capitalize" type="text" value="<?= $dt_proposal->nama_ketua ?>">
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
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Komponen Penilaian</th>
                <th scope="col">Aksi</th>
              </tr>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Luaran Wajib</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Berupa naskah akademik yang dapat berupa policy brief, rekomendasi kebijakan, atau model kebijakan strategis terhadap suatu permasalahan di unit institusi atau instansi lain.</td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#luaranwajib1">
                    <i class="fa fa-paste"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Artikel di jurnal internasional yang terindeks pada database minimal Q3 dengan status minimal submitted.</td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#luaranwajib2">
                    <i class="fa fa-paste"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>MoU (signed atau rintisan) kerjasama penelitian dengan mitra Luar Negeri</td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#luaranwajib3">
                    <i class="fa fa-paste"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Luaran Tambahan</th>
                <th scope="col">Aksi</th>
              </tr>
              <tr>
                <th scope="row">1</th>
                <td>Jurnal Nasional Terakreditasi /Jurnal Internasional / Jurnal Internasional Bereputasi</td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#luarantambahan1">
                    <i class="fa fa-paste"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>HKI berupa Paten, Paten Sederhana, Hak Cipta, Perlindungan Varietas Tanaman, Desain Tata Letak Sirkuit Terpadu, Naskah kebijakan dengan status Terdaftar</td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#luarantambahan2">
                    <i class="fa fa-paste"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>Draft Buku hasil penelitian atau bahan ajar.</td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#luarantambahan3">
                    <i class="fa fa-paste"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <th scope="row">4</th>
                <td>Book chapter yang diterbitkan oleh penerbit bereputasi dan ber-ISBN.</td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#luarantambahan4">
                    <i class="fa fa-paste"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <th scope="row">5</th>
                <td>Keynote speaker dalam temu ilmiah (internasional, nasional dan lokal).</td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#luarantambahan5">
                    <i class="fa fa-paste"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <th scope="row">6</th>
                <td>Pembicara kunci/visiting lecturer (internasional).</td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#luarantambahan6">
                    <i class="fa fa-paste"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <th scope="row">7</th>
                <td>Dokumen feasibility study, business plan.</td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#luarantambahan7">
                    <i class="fa fa-paste"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <th scope="row">8</th>
                <td>Naskah akademik (policy brief, rekomendasi kebijakan atau model kebijakan strategis).</td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#luarantambahan8">
                    <i class="fa fa-paste"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- MODAL LUARAN WAJIB #1 -->
          <div class="modal fade" id="luaranwajib1" tabindex="-1" role="dialog" aria-labelledby="luaranwajib1" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="luaranwajib1Judul">Luaran Wajib #1</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Bobot (%)</th>
                        <th scope="col">Skor</th>
                        <th scope="col">Nilai</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <table>
                            <tr>
                              <td>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="luaranwajibket1-1" id="luaranwajibket1-1" value="Ada" checked>
                                  <label class="form-check-label" for="luaranwajibket1-1">
                                    Ada
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="luaranwajibket1-1" id="luaranwajibket1-1" value="Tidak Ada">
                                  <label class="form-check-label" for="luaranwajibket1-1">
                                    Tidak ada
                                  </label>
                                </div>
                              </td>
                              <td>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="luaranwajibket1-3" id="luaranwajibket1-3" value="Submitted" checked>
                                  <label class="form-check-label" for="luaranwajibket1-3">
                                    Submitted
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="luaranwajibket1-3" id="luaranwajibket1-3" value="Reviewed">
                                  <label class="form-check-label" for="luaranwajibket1-3">
                                    Reviewed
                                  </label>
                                </div>
                              </td>
                              <td>
                                <input class="form-control form-control-sm w-100" type="text" placeholder="<?= $terbit; ?>" readonly>
                              </td>
                            </tr>
                          </table>
                        </td>
                        <td> - </td>
                        <td> - </td>
                        <td> - </td>
                      </tr>
                    </tbody>
                  </table>
                  <textarea class="form-control" id="luaranwajib1Draf" placeholder="Draf"></textarea>
                  <textarea class="form-control mt-4" id="luaranwajib1Accepted" placeholder="Accepted"></textarea>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
          <!-- END MODAL -->

          <!-- MODAL LUARAN WAJIB #2 -->
          <div class="modal fade" id="luaranwajib2" tabindex="-1" role="dialog" aria-labelledby="luaranwajib2" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="luaranwajib2Judul">Luaran Wajib #2</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Bobot (%)</th>
                        <th scope="col">Skor</th>
                        <th scope="col">Nilai</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <table>
                            <tr>
                              <td>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="luaranwajibket2-1" id="luaranwajibket2-1" value="Ada" checked>
                                  <label class="form-check-label" for="luaranwajibket2-1">
                                    Ada
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="luaranwajibket2-1" id="luaranwajibket2-1" value="Tidak Ada">
                                  <label class="form-check-label" for="luaranwajibket2-1">
                                    Tidak ada
                                  </label>
                                </div>
                              </td>
                              <td>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="luaranwajibket2-3" id="luaranwajibket2-3" value="Submitted" checked>
                                  <label class="form-check-label" for="luaranwajibket2-3">
                                    Submitted
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="luaranwajibket2-3" id="luaranwajibket2-3" value="Reviewed">
                                  <label class="form-check-label" for="luaranwajibket2-3">
                                    Reviewed
                                  </label>
                                </div>
                              </td>
                              <td>
                                <input class="form-control form-control-sm w-100" type="text" placeholder="<?= $terbit; ?>" readonly>
                              </td>
                            </tr>
                          </table>
                        </td>
                        <td> - </td>
                        <td> - </td>
                        <td> - </td>
                      </tr>
                    </tbody>
                  </table>
                  <textarea class="form-control" id="luaranwajib2Draf" placeholder="Draf"></textarea>
                  <textarea class="form-control mt-4" id="luaranwajib2Accepted" placeholder="Accepted"></textarea>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
          <!-- END MODAL -->

          <!-- MODAL LUARAN WAJIB #2 -->
          <div class="modal fade" id="luaranwajib3" tabindex="-1" role="dialog" aria-labelledby="luaranwajib3" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="luaranwajib3Judul">Luaran Wajib #3</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Bobot (%)</th>
                        <th scope="col">Skor</th>
                        <th scope="col">Nilai</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <table>
                            <tr>
                              <td>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="luaranwajibket3-1" id="luaranwajibket3-1" value="Ada" checked>
                                  <label class="form-check-label" for="luaranwajibket3-1">
                                    Ada
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="luaranwajibket3-1" id="luaranwajibket3-1" value="Tidak Ada">
                                  <label class="form-check-label" for="luaranwajibket3-1">
                                    Tidak ada
                                  </label>
                                </div>
                              </td>
                              <td>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="luaranwajibket3-3" id="luaranwajibket3-3" value="Submitted" checked>
                                  <label class="form-check-label" for="luaranwajibket3-3">
                                    Submitted
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="luaranwajibket3-3" id="luaranwajibket3-3" value="Reviewed">
                                  <label class="form-check-label" for="luaranwajibket3-3">
                                    Reviewed
                                  </label>
                                </div>
                              </td>
                              <td>
                                <input class="form-control form-control-sm w-100" type="text" placeholder="<?= $terbit; ?>" readonly>
                              </td>
                            </tr>
                          </table>
                        </td>
                        <td> - </td>
                        <td> - </td>
                        <td> - </td>
                      </tr>
                    </tbody>
                  </table>
                  <textarea class="form-control" id="luaranwajib3Draf" placeholder="Draf"></textarea>
                  <textarea class="form-control mt-4" id="luaranwajib3Accepted" placeholder="Accepted"></textarea>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
          <!-- END MODAL -->

        </div>
      </div>
  </section>
