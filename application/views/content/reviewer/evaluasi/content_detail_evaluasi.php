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
                    <?php if (!empty($dt_proposal)) : ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputJudul">Judul</label>
                                    <input type="text" class="form-control" id="inputJudul" placeholder="Judul Penelitian" value="<?= $dt_proposal->judul; ?>" name="judulPenelitianDosenPNBP" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="jnsproposal">Jenis Pengajuan Proposal</label><br>
                                    <div class="err-fokus" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div>
                                    <?php foreach ($kelompok as $key) { ?>
                                        <input disabled type="radio" name="jnsproposal" <?= (empty($dt_proposal) !== true ? $key->id_kelompok_pengajuan == $dt_proposal->id_kelompok_pengajuan ? 'checked' : '' : '') ?> value="<?= $key->id_kelompok_pengajuan ?>">
                                        <span class="text-capitalize" for="jnsproposal"><?= $key->nama_kelompok ?></span><br>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="tahunPenelitianDosenPNBP">Tahun Usulan</label>
                                    <input type="number" class="form-control" min="1900" max="2099" step="1" value="<?= $dt_proposal->tahun_usulan; ?>" id="tahunPenelitianDosenPNBP" name="tahunPenelitianDosenPNBP" disabled>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="tglmulai">Lama Penelitian (mulai)</label>
                                    <input type="date" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" id="tglmulai" placeholder="mulai" name="tglmulai" value="<?= $dt_proposal->mulai; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-sm-1" style="text-align: center; margin-top:36px">
                                <span> - </span>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="tglakhir">(akhir)</label>
                                    <input type="date" class="form-control" id="tglakhir" data-inputmask-inputformat="dd/mm/yyyy" placeholder="akhir" name="tglakhir" value="<?= $dt_proposal->akhir; ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputJudul">Tema Penelitian</label>
                                    <input type="text" class="form-control" placeholder="Tema Penelitian" name="tema_penelitian" value="<?= $dt_proposal->tema; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputJudul">Sasaran Mitra</label>
                                    <input type="text" value="<?= $dt_proposal->sasaran; ?>" class="form-control" id="inputSasaran" placeholder="Sasaran Penelitian" name="sasaran_penelitian" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="biayadiusulkan">Biaya yang diusulkan</label>
                                    <input type="text" class="form-control" id="biayadiusulkan" value="<?= rupiah($dt_proposal->biaya_usulan); ?>" placeholder="Rp.8.500.000,-" name="biayadiusulkan" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="target">10. Target Luaran</label><br>
                                    <div class="err-luaran" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div>
                                    <label for="target">A. Wajib</label><br>
                                    <?php foreach ($luaran as $lr) { ?>
                                        <?php if ($lr->jenis_luaran == 1) : ?>
                                            <input disabled type="checkbox" id="luaran1" name="luaran[]" <?= (empty($dt_proposal) !== true ? (in_array($lr->id_luaran, $luaran_checked) ? 'checked' : '') : '') ?> value="<?= $lr->id_luaran ?>">
                                            <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>
                                        <?php endif; ?>
                                    <?php } ?>

                                    <label for="target">B. Tambahan</label><br>
                                    <?php foreach ($luaran as $lr) { ?>
                                        <?php if ($lr->jenis_luaran == 2) : ?>
                                            <input disabled type="checkbox" id="luaran1" name="luaran[]" <?= (empty($dt_proposal) !== true ? (in_array($lr->id_luaran, $luaran_checked) ? 'checked' : '') : '') ?> value="<?= $lr->id_luaran ?>">
                                            <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>
                                        <?php endif; ?>
                                    <?php } ?>
                                    <?php if ($luaran_tambahan !== null) { ?>
                                        <div class="row" style="padding-left: 8px; padding-top: 8px;">
                                            <input disabled type="checkbox" id="luaran12" name="luaran_tambahan" checked value="">
                                            <span style="padding-top: 5px; padding-left:3px;" for="luaran11"> Lainnya</span><br>
                                            <div class="col-sm-6 tambahan_luaran">
                                                <input disabled type="text" class="form-control" id="luaran12" value="<?= $luaran_tambahan->judul ?>" disabled name="tambahan_luaran">
                                            </div>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <input type="button" class="btn btn-primary btn-dosen" value="Lihat <?= $dt_proposal->id_event == 3 ? "PLP" : "Dosen" ?> Terdaftar">
                                    </div>
                                </div>
                                <?php if($dt_proposal->id_event != 3 ): ?>
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <input type="button" class="btn btn-primary btn-mhs" value="Lihat Mahasiswa Terdaftar">
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        <div class="row">
                                <div class="col-md-6 anggota-dosen" style="display: none;">
                                    <div class="card card-default">
                                        <div class="card-header">
                                            <h3 class="card-title">List Anggota <?= $dt_proposal->id_event == 3 ? "PLP" : "Dosen" ?> </h3>
                                        </div>

                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="tabelevent" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" width="20%">NIP</th>
                                                            <th class="text-center" width="20%">Nama</th>
                                                            <th class="text-center" width="20%">CV</th>
                                                            <th class="text-center" width="20%">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="isi-dosen">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 anggota-mhs " style="display: none;">
                                    <div class="card card-default">
                                        <div class="card-header">
                                            <h3 class="card-title">List Anggota Mahasiswa </h3>
                                        </div>

                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="tabelevent" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" width="20%">NIM</th>
                                                            <th class="text-center" width="20%">Nama Mahasiswa</th>
                                                            <th class="text-center" width="20%">Prodi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="isi-mhs">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        <hr>
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
                                    <label for="">NIDN</label>
                                    <input readonly class="form-control" type="text" value="<?= $dt_proposal->nidn_ketua ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                        <div class="col-md-6">
								<label>File Lampiran</label>
								<br>
								<a href="<?= base_url('assets/berkas/file_proposal/') . $dt_proposal->proposal ?>" target="_blank">File Proposal</a> |
								<a href="<?= base_url('assets/berkas/file_rab/') . $dt_proposal->rab ?>" target="_blank">File RAB</a>
							</div>
                            <div class="col-md-6">
                                <a href="<?= base_url("C_evaluasi/evaluasi_proposal/") ?><?= $status->id_kerjaan_evaluasi ?>/<?= $dt_proposal->id_event ?>" class="btn btn-primary" style="float:right;"> <i class="fa fa-paste"></i> <?= $status->status == 0  ? 'Evaluasi Proposal' : 'Lihat Evaluasi' ?></a>
                            </div>
                            
                        </div>
                    <?php endif ?>
                </div>
                <!-- /.row -->
            </div>
            <br>
        </div><!-- /.container-fluid -->
    </section>
</div>
<script>
    $('.table-bordered').DataTable();

    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
    $(`.btn-dosen`).click(function (e) {
    const segment = $(location).attr(`href`).split(`/`);
    const id_proposal = segment[segment.length - 1];
    // console.log(segment);

    $.ajax({
      url: `${BASE_URL}C_reviewer/get_anggota_dosen`,
      method: `POST`,
      data: { id_proposal: id_proposal },
      dataType: `json`,
      success: function (res) {
        if (res.code == 1) {
          $(`.isi-dosen`).html(res.datany);
        } else {
          $(`.isi-dosen`).html(`ada yang error`);
        }
      },
    });
    $(`.anggota-dosen`).toggle();
  });

  $(`.btn-mhs`).click(function (e) {
    const segment = $(location).attr(`href`).split(`/`);
    const id_proposal = segment[segment.length - 1];
    // console.log(segment);

    $.ajax({
      url: `${BASE_URL}C_reviewer/get_anggota_mhs`,
      method: `POST`,
      data: { id_proposal: id_proposal },
      dataType: `json`,
      success: function (res) {
        if (res.code == 1) {
          $(`.isi-mhs`).html(res.datany);
        } else {
          $(`.isi-mhs`).html(`ada yang error`);
        }
      },
    });
    $(`.anggota-mhs`).toggle();
  });
</script>
<!-- /.content -->