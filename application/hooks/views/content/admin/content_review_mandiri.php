<script src="<?php echo base_url('assets'); ?>/plugins/select2/js/select2.full.min.js"></script>
<script src="<?= base_url() . JS_UMUM; ?>staff_tambah_reviewer.js?random=<?= uniqid(); ?>"></script>

<style>
    .select2-selection__rendered {
        line-height: 31px !important;
    }

    .select2-container .select2-selection--single {
        height: 35px !important;
    }

    .select2-selection__arrow {
        height: 34px !important;
    }

    #prevBtn {
        background-color: #dc3545;
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
                    <h5>Penelitian Dosen</h5>
                    <div class="card-body">
                        <!-- text input -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputJudul">Judul</label>
                                    <input type="text" class="form-control" id="inputJudul" placeholder="Judul Penelitian" value="<?= $jdl ?>" name="judulPenelitianDosenPNBP" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="tahunPenelitianDosenPNBP">Tahun Usulan</label>
                                    <input type="number" class="form-control" min="1900" max="2099" step="1" value="<?= $thn ?>" id="tahunPenelitianDosenPNBP" name="tahunPenelitianDosenPNBP" disabled>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="tglmulai">Lama Penelitian (mulai)</label>
                                    <input type="date" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" id="tglmulai" placeholder="mulai" name="tglmulai" value="<?= $mulai ?>" disabled>
                                </div>
                            </div>
                            <div class="col-sm-1" style="text-align: center; margin-top:36px">
                                <span> - </span>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="tglakhir">(akhir)</label>
                                    <input type="date" class="form-control" id="tglakhir" data-inputmask-inputformat="dd/mm/yyyy" placeholder="akhir" name="tglakhir" value="<?= $akhir; ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputJudul">Tema Penelitian</label>
                                    <input type="text" class="form-control" placeholder="Tema Penelitian" name="tema_penelitian" value="<?= $tema; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputJudul">Sasaran Mitra</label>
                                    <input type="text" value="<?= $sasaran; ?>" class="form-control" id="inputSasaran" placeholder="Sasaran Penelitian" name="sasaran_penelitian" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="biayadiusulkan">Biaya yang diusulkan</label>
                                    <input type="text" class="form-control" id="biayadiusulkan" value="<?= $biaya; ?>" placeholder="Rp.8.500.000,-" name="biayadiusulkan" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="target">Target Luaran</label><br>
                                    <?php foreach ($luaran as $lr) { ?>
                                        <input type="checkbox" id="luaran1" name="luaran[]" value="<?= $lr->id_luaran ?>">
                                        <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>
                                    <?php } ?>
                                    <?php if ($luaran_tambahan !== null) { ?>
                                        <div class="row" style="padding-left: 8px; padding-top: 8px;">
                                            <input type="checkbox" id="luaran12" name="luaran_tambahan" checked value="">
                                            <span style="padding-top: 5px; padding-left:3px;" for="luaran11"> Lainnya</span><br>
                                            <div class="col-sm-6 tambahan_luaran">
                                                <input type="text" class="form-control" id="luaran12" value="<?= $luaran_tambahan->judul ?>" disabled name="tambahan_luaran">
                                            </div>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <input type="button" class="btn btn-primary btn-dosen" value="Lihat Dosen Terdaftar">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <input type="button" class="btn btn-primary btn-mhs" value="Lihat Mahasiswa Terdaftar">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 anggota-dosen" style="display: none;">
                                <div class="card card-default">
                                    <div class="card-header">
                                        <h3 class="card-title">List Anggota Dosen </h3>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tabelevent" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="20%">NIP</th>
                                                        <th width="20%">id sinta</th>
                                                        <th width="20%">Status</th>
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
                                                        <th width="20%">NIM</th>
                                                        <th width="20%">Nama Mahasiswa</th>
                                                        <th width="20%">Prodi</th>
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
                        <div class="row">
                            <div class="col-md-6">
                                <label>File Lampiran</label>
                                <br>
                                <a href="<?= base_url('assets/berkas/file_proposal/') ?>" target="_blank">File Proposal</a> |
                                <a href="<?= base_url('assets/berkas/file_rab/') ?> ?>" target="_blank">File RAB</a>
                            </div>

                        </div>
                        <hr style="color: darkgrey;">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="" class="btn btn-danger" style="float: left;">Ditolak</a>
                            </div>
                            <div class="col-md-6">
                                <a href="" class="btn btn-success" style="float: right;">Diterima</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div><!-- /.container-fluid -->
    </section>
</div>
<!-- /.content -->

<script>
    $('.select2').select2();

    $('.table-bordered').DataTable();
    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>