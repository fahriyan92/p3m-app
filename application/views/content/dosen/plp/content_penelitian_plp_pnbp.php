<script src="<?php echo base_url('assets'); ?>/plugins/select2/js/select2.full.min.js"></script>
<link rel="stylesheet" href="<?= base_url() . CSS_CUSTOM; ?>form_wizard.css?random=<?= uniqid(); ?>">
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

<!-- Content Wrapper. Contains page content -->
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
    <section class="content pb-3">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div style="text-align:center;">
                    <ul class="nav nav-tabs nav-justified">
                        <li class="nav-item step"><a class="nav-link" href="#tab_1" data-toggle="tab">Identitas Usulan</a></li>
                        <li class="nav-item step"><a class="nav-link" href="#tab_2" data-toggle="tab">Data Anggota</a></li>
                        <li class="nav-item step"><a class="nav-link" href="#tab_6" data-toggle="tab">File</a></li>
                    </ul>
                </div>

                <div class="card-body">
                    <form id="formnya" method="post" enctype="multipart/form-data">
                        <div class="tab">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputJudul">1. Jenis Penelitian</label><br>
                                        <div class="err-jns-penelitian" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <input type="radio" name="jenis_penelitian" value="2" <?= $_SESSION['job'] === 'plp' ? 'checked' : 'disabled' ?>>
                                        <span class="text-capitalize" for="fokus">Penelitian PLP</span><br>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="jnsproposal">2. Jenis Pengajuan Proposal</label><br>
                                        <div class="err-jnsproposal" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <?php foreach ($kelompok as $key) { ?>
                                            <?php if ($key->status == 1) : ?>
                                                <input type="radio" name="jnsproposal" <?= (empty($dt_proposal) !== true ? $key->id_kelompok_pengajuan == $dt_proposal->id_kelompok_pengajuan ? 'checked' : '' : '') ?> value="<?= $key->id_kelompok_pengajuan ?>">
                                                <span class="text-capitalize" for="jnsproposal"><?= $key->nama_kelompok ?></span><br>
                                            <?php endif; ?>
                                        <?php } ?>

                                    </div>
                                </div>

                                <?php
                                if (isset($lanjut_dosen['ketua'])) : ?>
                                    <input type="hidden" name="cv_lama_ketua" value="<?= $lanjut_dosen['ketua'][0]->nidn ?>?<?= $lanjut_dosen['ketua'][0]->file_cv ?>">

                                    <?php if (isset($lanjut_dosen['anggota'][0])) : ?>
                                        <input type="hidden" name="cv_lama_anggota1" value="<?= $lanjut_dosen['anggota'][0]->nidn ?>?<?= $lanjut_dosen['anggota'][0]->file_cv ?>">
                                    <?php endif; ?>

                                    <?php if (isset($lanjut_dosen['anggota'][1])) : ?>
                                        <input type="hidden" name="cv_lama_anggota2" value="<?= $lanjut_dosen['anggota'][1]->nidn ?>?<?= $lanjut_dosen['anggota'][1]->file_cv ?>">
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if (empty($dt_proposal) == false) : ?>
                                    <input type="hidden" name="id_pengajuan_detail" value="<?= $dt_proposal->id_pengajuan_detail ?>">
                                <?php endif; ?>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputJudul">3. Tema Penelitian</label><br>
                                        <div class="err-tema" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <?php foreach ($temas as $tm) { ?>
                                            <input type="radio" name="tema_penelitian" <?= (empty($dt_proposal) !== true ? strtoupper($tm->nama_tema) == strtoupper($dt_proposal->tema) ? 'checked' : '' : '') ?> value="<?= $tm->nama_tema ?>">
                                            <span class="text-capitalize" for="tema_penelitian"><?= $tm->nama_tema ?></span><br>
                                        <?php } ?>

                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputJudul">4. Sasaran Mitra (Jika Ada)</label>
                                        <input type="text" autocomplete="off" value="<?= empty($dt_proposal) !== true ? $dt_proposal->sasaran !== "null" ? $dt_proposal->sasaran : '' : '' ?>" class="form-control" id="inputSasaran" placeholder="Sasaran Penelitian" name="sasaran_penelitian">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputJudul">5. Judul Penelitian</label>
                                        <div class="err-judul" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <input type="text" autocomplete="off" value="<?= empty($dt_proposal) !== true ? $dt_proposal->judul : '' ?>" class="form-control" placeholder="Judul Penelitian" name="judul_penelitian">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tahunPenelitianDosenPNBP">7. Tahun Usulan</label>
                                        <div class="err-thn-usulan" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <input type="number" value="<?= empty($dt_proposal) !== true ? $dt_proposal->tahun_usulan : date('Y') ?>" class="form-control" min="2020" max="2099" step="1" name="tahun_penelitian" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tglmulai">8. Lama Penelitian (mulai)</label>
                                        <div class="err-mulai" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <input type="date" value="<?= empty($dt_proposal) !== true ? $dt_proposal->mulai : '22/07/2020' ?>" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" placeholder="mulai" name="tgl_mulai">
                                    </div>
                                </div>
                                <div class="col-sm-1" style="text-align: center; margin-top:36px">
                                    <span> - </span>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tglakhir">(akhir)</label>
                                        <div class="err-akhir" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <input type="date" value="<?= empty($dt_proposal) !== true ? $dt_proposal->akhir : '22/10/2020' ?>" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" placeholder="akhir" name="tgl_akhir">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="biaya_usulan">9. Biaya Usulan</label>
                                        <div class="err-biaya" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <input type="text" value="<?= empty($dt_proposal) !== true ? $dt_proposal->biaya : '' ?>" class="form-control" id="biayadiusulkan" placeholder="1000000" name="biaya_diusulkan" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="identitas_tkt">10. TKT</label>
                                        <div class="err-tkt" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <input type="number" autocomplete="off" value="<?= empty($dt_proposal) !== true ? $dt_proposal->identitas_tkt : '' ?>" min="0" max="9" class="form-control" id="identitas_tkt" placeholder="1 - 9" name="identitas_tkt">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="target">11. Target Luaran</label><br>
                                        <div class="err-luaran" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <div id="skema-luaran">
                                            <?php foreach ($luaran as $lr) { ?>
                                                <?php if ($lr->jenis_luaran == 2) : ?>
                                                    <input type="checkbox" id="luaran1" name="luaran[]" <?= (empty($dt_proposal) !== true ? (in_array($lr->id_luaran, $luaran_checked) ? 'checked' : '') : '') ?> value="<?= $lr->id_luaran ?>">
                                                    <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>
                                                <?php endif; ?>
                                            <?php } ?>

                                        </div>

                                        <?php if (isset($luaran_tambahan)) { ?>
                                            <div class="row" style="padding-left: 8px; padding-top: 8px;">
                                                <input type="checkbox" id="luaran12" name="luaran_tambahan" checked value="">
                                                <span style="padding-top: 5px; padding-left:3px;" for="luaran11"> Lainnya</span><br>
                                                <div class="col-sm-6 tambahan_luaran">
                                                    <input type="text" class="form-control" id="luaran12" value="<?= $luaran_tambahan->judul ?>" disabled name="tambahan_luaran">
                                                </div>
                                            </div>

                                        <?php } else { ?>
                                            <div class="row" style="padding-left: 8px; padding-top: 4px;">
                                                <input type="checkbox" id="luaran12" name="luaran_tambahan" value="">
                                                <span style="padding-left:3px;" for="luaran11"> Lainnya</span><br>
                                                <div class="col-sm-6 tambahan_luaran">

                                                </div>
                                            </div>

                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <label for="statusTKT">12. Ringkasan Usulan (max. 500 kata)</label>
                                        <div class="err-ringkasan" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <textarea value="qweqweqwe" class="form-control" id="ringkasan" name="ringkasan" rows="4"><?= empty($dt_proposal) !== true ? $dt_proposal->ringkasan : '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <label for="statusTKT">13. Tinjauan Pustaka (max. 1000 kata)</label>
                                        <div class="err-tinjauan" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <textarea value="qweqweqwe" class="form-control" id="tinjauan" name="tinjauan" rows="4"><?= empty($dt_proposal) !== true ? $dt_proposal->tinjauan : '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <label for="statusTKT">14. Metode (max. 2000 kata)</label>
                                        <div class="err-metode" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <textarea value="qweqweqweqwe" class="form-control" id="ringkasan" name="metode" rows="4"><?= empty($dt_proposal) !== true ? $dt_proposal->metode : '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="text-left">Data Ketua</h3>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="ketua">1. NIP </label>
                                            <input type="text" class="form-control" name="nidn" disabled id="nidn_ketua" value="<?= ($lanjut_dosen == null)  ? $dosen['ketua'][0]->nidn : $lanjut_dosen['ketua'][0]->nidn ?>">

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nidn">2. NAMA PLP</label>
                                            <div class="custom-file">
                                                <input type="text" class="form-control" name="nama_dosen" value="<?= ($lanjut_dosen == null)  ? $dosen['ketua'][0]->nama :  $lanjut_dosen['ketua'][0]->nama ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="jurusan">3. Jurusan</label>
                                            <div class="custom-file">
                                                <input type="text" class="form-control" name="jurusan" value="<?= ($lanjut_dosen == null)  ? $dosen['ketua'][0]->unit :  $lanjut_dosen['ketua'][0]->unit ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="pangkat">4. Pangkat / Jabatan Fungsional</label>
                                            <div class="custom-file">
                                                <input type="text" class="form-control" id="pangkat" name="pangkat[]" value="<?= ($lanjut_dosen == null)  ? $dosen['ketua'][0]->jenis_job :  $lanjut_dosen['ketua'][0]->jenis_job ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="id_sinta">5. ID-Sinta</label>
                                            <div class="custom-file">
                                                <input type="number" class="form-control" value="<?= ($lanjut_dosen == null)  ? $dosen['ketua'][0]->sinta :  $lanjut_dosen['ketua'][0]->sinta ?>" id="id_sinta1" onkeydown="return event.keyCode !== 129" name="id_sinta" readonly>
                                            </div>
                                            <div class="err-sinta1" style="display:none;">
                                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="scopus">6. ID-Scopus</label>
                                            <div class="custom-file">
                                                <input type="number" class="form-control" value="<?= ($lanjut_dosen == null)  ? $dosen['ketua'][0]->scopus : $lanjut_dosen['ketua'][0]->scopus ?>" id="scopus1" onkeydown="return event.keyCode !== 69" name="scopus" readonly>
                                            </div>
                                            <div class="err-sinta1" style="display:none;">
                                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if (isset($lanjut_dosen) && isset($lanjut_dosen['ketua'])) : ?>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="id_sinta">File CV Ketua</label>
                                                <h5 class="text-left"><a href="<?= base_url('assets/berkas/file_cv/') . $lanjut_dosen['ketua'][0]->file_cv ?>" target="_blank"><?= $lanjut_dosen['ketua'][0]->file_cv  ?></a></h5>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <h3 class="text-left">Data Anggota</h3>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="anggota1">1. NIP Anggota 1</label>
                                            <select class="form-control select2 nm_dosen" style="width: 100%;" id="anggota1" name="nidn">
                                                <option value="">-- Cari NIP Dosen --</option>
                                                <?php if (isset($lanjut_dosen['anggota'][0])) : ?>
                                                    <option value="<?= $lanjut_dosen['anggota'][0]->nidn ?>" selected><?= $lanjut_dosen['anggota'][0]->nidn ?> - <?= $lanjut_dosen['anggota'][0]->nama ?></option>
                                                <?php endif; ?>
                                                <?php foreach ($dosen['dosen'] as $dsn) { ?>
                                                    <option value="<?= $dsn->nidn ?>"><?= $dsn->nidn ?> - <?= $dsn->nama ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="err-anggota1" style="display:none;">
                                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nidn">2. NAMA PLP</label>
                                            <div class="">
                                                <input type="text" disabled class="form-control" id="dsn_nama1" name="nama_dosen" value="<?= ($lanjut_dosen == null)  ? '' :  $lanjut_dosen['anggota'][0]->nama ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nidn">3. Jurusan</label>
                                            <div class="">
                                                <input type="text" disabled class="form-control" id="dsn_jurusan1" name="jurusan_anggota1" value="<?= ($lanjut_dosen == null)  ? '' : $lanjut_dosen['anggota'][0]->unit ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="pangkat">4. Pangkat / Jabatan Fungsional</label>
                                            <div class="custom-file">
                                                <input type="text" disabled class="form-control" id="dsn_pangkat1" name="pangkat[]" value="<?= ($lanjut_dosen == null)  ? '' : $lanjut_dosen['anggota'][0]->jenis_job ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="id_sinta">5. ID-Sinta</label>
                                            <div class="custom-file">
                                                <input type="number" class="form-control" id="id_sinta2" value="<?= isset($lanjut_dosen) && count($lanjut_dosen['anggota']) > 0 ? $lanjut_dosen['anggota'][0]->id_sinta : '' ?>" name="id_sinta" readonly>
                                            </div>
                                            <div class="err-sinta2" style="display:none;">
                                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="scopus">6. ID-Scopus</label>
                                            <div class="custom-file">
                                                <input type="number" class="form-control" id="scopus2" value="<?= isset($lanjut_dosen) && count($lanjut_dosen['anggota']) > 0 ? $lanjut_dosen['anggota'][0]->scopus : '' ?>" name="scopus" readonly>
                                            </div>
                                            <div class="err-sinta2" style="display:none;">
                                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if (isset($lanjut_dosen) && count($lanjut_dosen['anggota']) > 0) : ?>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="id_sinta">File CV Anggota 1</label>
                                                <h5 class="text-left"><a href="<?= base_url('assets/berkas/file_cv/') . $lanjut_dosen['anggota'][0]->file_cv ?>" target="_blank"><?= $lanjut_dosen['anggota'][0]->file_cv ?></a></h5>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label for="pakegak">
                                                    <?php if (isset($lanjut_dosen) && count($lanjut_dosen['anggota']) > 0) : ?>

                                                        <span style="color:red;">Jika Ingin Menambahkan Anggota ke - 2 Selesaikan Pengajuan Terlebih Dahulu </span>
                                                        <input style="margin-left:5px;" disabled type="checkbox" <?= (count($lanjut_dosen['anggota']) == 2) ? "checked" : "" ?> <?= isset($lanjut_dosen['anggota']) ? count($lanjut_dosen['anggota']) === 1 && $lanjut_dosen['anggota'][0]->status_notifikasi == 1 ? 'disabled' : '' : '' ?> name="pakegak">
                                                        <?php else : ?> 
                                                        <span style="color:red;">Centang Jika Ingin Menambahkan Anggota ke - 2 </span>
                                                        <input style="margin-left:5px;" type="checkbox" <?= isset($lanjut_dosen['anggota']) ? count($lanjut_dosen['anggota']) === 1 && $lanjut_dosen['anggota'][0]->status_notifikasi == 1 ? 'disabled' : '' : '' ?> name="pakegak">
                                                    <?php endif; ?>
                                                </label>
                                            </div>
                                        </div>


                                        <div class="form-anggota2" style="<?= ($lanjut_dosen == null) ? 'display: none;' : ((isset($lanjut_dosen['anggota'][1]) && $lanjut_dosen['anggota'][1] != null) ? '' :  'display: none;') ?>">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="anggota2">1. NIP Anggota 2</label>
                                                    <select class="form-control select2 nm_dosen" style="width: 100%;" id="anggota2" name="nidn">
                                                        <option value="">-- Cari NIP Dosen --</option>
                                                        <?php if (isset($lanjut_dosen['anggota'][1])) : ?>
                                                            <option value="<?= $lanjut_dosen['anggota'][1]->nidn ?>" selected><?= $lanjut_dosen['anggota'][1]->nidn ?> - <?= $lanjut_dosen['anggota'][1]->nama ?></option>
                                                        <?php endif; ?>
                                                        <?php foreach ($dosen['dosen'] as $dsn) { ?>
                                                            <option value="<?= $dsn->nidn ?>"><?= $dsn->nidn ?> - <?= $dsn->nama ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="err-anggota2" style="display:none;">
                                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="nidn">2. NAMA DOSEN</label>
                                                    <div class="">
                                                        <input type="text" disabled class="form-control" id="dsn_nama2" name="dsn_nama2" value="<?= ($lanjut_dosen == null)  ? '' : ((isset($lanjut_dosen['anggota'][1]))  ? $lanjut_dosen['anggota'][1]->nama : '' )?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="nidn">3. Jurusan</label>
                                                    <div class="">
                                                        <input type="text" disabled class="form-control" id="dsn_jurusan2" name="dsn_jurusan2" value="<?= ($lanjut_dosen == null)  ? '' : ((isset($lanjut_dosen['anggota'][1]))  ? $lanjut_dosen['anggota'][1]->unit : '') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="pangkat">4. Pangkat / Jabatan Fungsional</label>
                                                    <div class="custom-file">
                                                        <input type="text" disabled class="form-control ag2" id="dsn_pangkat2" name="dsn_pangkat2" value="<?= ($lanjut_dosen == null)  ? '' : ((isset($lanjut_dosen['anggota'][1]))  ? $lanjut_dosen['anggota'][1]->jenis_job : '' ) ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="id_sinta">5. ID-Sinta</label>
                                                    <div class="custom-file">
                                                        <input type="number" class="form-control ag2" id="id_sinta3" value="<?= isset($lanjut_dosen) && count($lanjut_dosen['anggota']) > 1 ? $lanjut_dosen['anggota'][1]->id_sinta : '' ?>" name="id_sinta" readonly>
                                                    </div>
                                                    <div class="err-sinta3" style="display:none;">
                                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="scopus">6. ID-Scopus</label>
                                                    <div class="custom-file">
                                                        <input type="number" class="form-control ag2" id="scopus3" value="<?= isset($lanjut_dosen) && count($lanjut_dosen['anggota']) > 1 ? $lanjut_dosen['anggota'][1]->scopus : '' ?>" name="scopus" readonly>
                                                    </div>
                                                    <div class="err-sinta3" style="display:none;">
                                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if (isset($lanjut_dosen) && count($lanjut_dosen['anggota']) > 1) : ?>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="id_sinta">File CV Anggota 2</label>
                                                        <h5 class="text-left"><a href="<?= base_url('assets/berkas/file_cv/') . $lanjut_dosen['anggota'][1]->file_cv ?>" target="_blank"><?= $lanjut_dosen['anggota'][1]->file_cv ?></a></h5>
                                                    </div>
                                                </div>
                                                <?php endif; ?>

                                            <!-- anggota3 -->
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label for="pakegak">
                                                        <?php if (isset($lanjut_dosen) && count($lanjut_dosen['anggota']) > 2) : ?>
                                                            <span style="color:red;">Jika Ingin Menambahkan Anggota ke - 3 Selesaikan Pengajuan Terlebih Dahulu </span>
                                                            <input style="margin-left:5px;" disabled type="checkbox" <?= (count($lanjut_dosen['anggota']) >  2) ? "checked" : "" ?> <?= isset($lanjut_dosen['anggota']) ? count($lanjut_dosen['anggota']) > 2 && $lanjut_dosen['anggota'][2]->status_notifikasi == 1 ? 'disabled' : '' : '' ?> name="pakegak3">
                                                        <?php else: ?>
                                                            <div id="checklist_anggota3" class="<?= isset($lanjut_dosen['anggota'][2]) ? '' : 'd-none'?>" >
                                                                <span style="color:red;">Centang Jika Ingin Menambahkan Anggota ke - 3 </span>
                                                                <input style="margin-left:5px;" type="checkbox" <?= isset($lanjut_dosen['anggota']) ? count($lanjut_dosen['anggota']) === 2 && $lanjut_dosen['anggota'][1]->status_notifikasi == 2 ? 'disabled' : '' : '' ?> name="pakegak3">
                                                            </div>
                                                            <?php endif; ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-anggota3" style="<?= ($lanjut_dosen == null) ? 'display: none;' : ((isset($lanjut_dosen['anggota'][2]) && $lanjut_dosen['anggota'][2] != null) ? '' : 'display: none;') ?>">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="anggota3">1. NIP Anggota 3</label>
                                                    <select class="form-control select2 nm_dosen" style="width: 100%;" id="anggota3" name="nidn">
                                                        <option value="">-- Cari NIP Dosen --</option>
                                                        <?php if (isset($lanjut_dosen['anggota'][2])) : ?>
                                                            <option value="<?= $lanjut_dosen['anggota'][2]->nidn ?>" selected><?= $lanjut_dosen['anggota'][2]->nidn ?> - <?= $lanjut_dosen['anggota'][2]->nama ?></option>
                                                        <?php endif; ?>
                                                        <?php foreach ($dosen['dosen'] as $dsn) { ?>
                                                            <option value="<?= $dsn->nidn ?>"><?= $dsn->nidn ?> - <?= $dsn->nama ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="err-anggota3" style="display:none;">
                                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="nidn">2. NAMA DOSEN</label>
                                                    <div class="">
                                                        <input type="text" disabled class="form-control" id="dsn_nama3" name="dsn_nama3" value="<?= ($lanjut_dosen == null)  ? '' : ((isset($lanjut_dosen['anggota'][2]))  ? $lanjut_dosen['anggota'][2]->nama : '') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="nidn">3. Jurusan</label>
                                                    <div class="">
                                                        <input type="text" disabled class="form-control" id="dsn_jurusan3" name="dsn_jurusan3" value="<?= ($lanjut_dosen == null)  ? '' : ((isset($lanjut_dosen['anggota'][2]))  ? $lanjut_dosen['anggota'][2]->unit : '') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="pangkat">4. Pangkat / Jabatan Fungsional</label>
                                                    <div class="custom-file">
                                                        <input type="text" disabled class="form-control ag3" id="dsn_pangkat3" name="dsn_pangkat3" value="<?= ($lanjut_dosen == null)  ? '' : ((isset($lanjut_dosen['anggota'][2]))  ? $lanjut_dosen['anggota'][2]->jenis_job : '') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="id_sinta">5. ID-Sinta</label>
                                                    <div class="custom-file">
                                                        <input type="number" class="form-control ag2" id="id_sinta4" value="<?= isset($lanjut_dosen) && count($lanjut_dosen['anggota']) > 2 ? $lanjut_dosen['anggota'][2]->id_sinta : '' ?>" name="id_sinta" readonly>
                                                    </div>
                                                    <div class="err-sinta4" style="display:none;">
                                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="scopus">6. ID-Scopus</label>
                                                    <div class="custom-file">
                                                        <input type="number" class="form-control ag3" id="scopus4" value="<?= isset($lanjut_dosen) && count($lanjut_dosen['anggota']) > 1 ? $lanjut_dosen['anggota'][2]->scopus : '' ?>" name="scopus" readonly>
                                                    </div>
                                                    <div class="err-sinta4" style="display:none;">
                                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if (isset($lanjut_dosen) && count($lanjut_dosen['anggota']) > 2) : ?>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="id_sinta">File CV Anggota 3</label>
                                                        <h5 class="text-left"><a href="<?= base_url('assets/berkas/file_cv/') . $lanjut_dosen['anggota'][2]->file_cv ?>" target="_blank"><?= $lanjut_dosen['anggota'][2]->file_cv ?></a></h5>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <!-- anggota4 -->
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label for="pakegak">
                                                        
                                                        <?php 
                                                        if (isset($lanjut_dosen) && count($lanjut_dosen['anggota']) > 3) : ?>
                                                            <span style="color:red;">Jika Ingin Menambahkan Anggota ke - 4 Selesaikan Pengajuan Terlebih Dahulu </span>
                                                            <input style="margin-left:5px;" disabled type="checkbox" <?= (count($lanjut_dosen['anggota']) == 4) ? "checked" : "" ?> <?= isset($lanjut_dosen['anggota']) ? count($lanjut_dosen['anggota']) > 3 && $lanjut_dosen['anggota'][3]->status_notifikasi == 1 ? 'disabled' : '' : '' ?> name="pakegak4">
                                                        <?php else: ?>
                                                            <div id="checklist_anggota4" class="<?= isset($lanjut_dosen['anggota'][3]) ? '' : 'd-none'?>" >
                                                            <span style="color:red;">Centang Jika Ingin Menambahkan Anggota ke - 4 </span>
                                                            <input style="margin-left:5px;" type="checkbox" <?= isset($lanjut_dosen['anggota']) ? count($lanjut_dosen['anggota']) > 3 && $lanjut_dosen['anggota'][3]->status_notifikasi == 1 ? 'disabled' : '' : '' ?> name="pakegak4">
                                                        </div>
                                                            <?php endif; ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-anggota4" style="<?= ($lanjut_dosen == null) ? 'display: none;' : ((isset($lanjut_dosen['anggota'][3]) && $lanjut_dosen['anggota'][3] != null) ? '' : 'display: none;') ?>">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="anggota4">1. NIP Anggota 4</label>
                                                    <select class="form-control select2 nm_dosen" style="width: 100%;" id="anggota4" name="nidn">
                                                        <option value="">-- Cari NIP Dosen --</option>
                                                        <?php if (isset($lanjut_dosen['anggota'][3])) : ?>
                                                            <option value="<?= $lanjut_dosen['anggota'][3]->nidn ?>" selected><?= $lanjut_dosen['anggota'][3]->nidn ?> - <?= $lanjut_dosen['anggota'][3]->nama ?></option>
                                                        <?php endif; ?>
                                                        <?php foreach ($dosen['dosen'] as $dsn) { ?>
                                                            <option value="<?= $dsn->nidn ?>"><?= $dsn->nidn ?> - <?= $dsn->nama ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="err-anggota4" style="display:none;">
                                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="nidn">2. NAMA DOSEN</label>
                                                    <div class="">
                                                        <input type="text" disabled class="form-control" id="dsn_nama4" name="dsn_nama2" value="<?= ($lanjut_dosen == null)  ? '' : ((isset($lanjut_dosen['anggota'][3]))  ? $lanjut_dosen['anggota'][3]->nama : '') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="nidn">3. Jurusan</label>
                                                    <div class="">
                                                        <input type="text" disabled class="form-control" id="dsn_jurusan4" name="dsn_jurusan2" value="<?= ($lanjut_dosen == null)  ? '' :((isset($lanjut_dosen['anggota'][3]))  ? $lanjut_dosen['anggota'][3]->unit : '')  ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="pangkat">4. Pangkat / Jabatan Fungsional</label>
                                                    <div class="custom-file">
                                                        <input type="text" disabled class="form-control ag2" id="dsn_pangkat4" name="dsn_pangkat2" value="<?= ($lanjut_dosen == null)  ? '' : ((isset($lanjut_dosen['anggota'][3]))  ? $lanjut_dosen['anggota'][3]->jenis_job : '')  ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="id_sinta">5. ID-Sinta</label>
                                                    <div class="custom-file">
                                                        <input type="number" class="form-control ag2" id="id_sinta5" value="<?= isset($lanjut_dosen) && count($lanjut_dosen['anggota']) > 3 ? $lanjut_dosen['anggota'][3]->id_sinta : '' ?>" name="id_sinta" readonly>
                                                    </div>
                                                    <div class="err-sinta3" style="display:none;">
                                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="scopus">6. ID-Scopus</label>
                                                    <div class="custom-file">
                                                        <input type="number" class="form-control ag2" id="scopus3" value="<?= isset($lanjut_dosen) && count($lanjut_dosen['anggota']) > 3 ? $lanjut_dosen['anggota'][3]->scopus : '' ?>" name="scopus" readonly>
                                                    </div>
                                                    <div class="err-sinta3" style="display:none;">
                                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if (isset($lanjut_dosen) && count($lanjut_dosen['anggota']) > 3) : ?>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="id_sinta">File CV Anggota 4</label>
                                                        <h5 class="text-left"><a href="<?= base_url('assets/berkas/file_cv/') . $lanjut_dosen['anggota'][3]->file_cv ?>" target="_blank"><?= $lanjut_dosen['anggota'][3]->file_cv ?></a></h5>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                    </div>

                                </div>
                            </div>
                            <h6 id="alert_permintaan" style="color:red;display: none;">"Menunggu Respon Anggota Untuk Lanjut Pada Tahap Selanjutnya"</h6>
                        </div>

                        <div class="tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Unggah File Proposal Lengkap</label>
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="proposal" name="proposal" onchange="checkextensionProposal()">
                                                <label class="custom-file-label" for="proposal" id="labelproposal">Pilih file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Unggah File RAB</label>
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="rab" name="rab" onchange="checkextensionRab()">
                                                <label class="custom-file-label" for="rab" id="labelrab">Pilih file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <h5 class="text-left" style="font-size:13px; color:red;">[#]File Maximal 3 MB</h5>
                                    <h5 class="text-left" style="font-size:13px; color:red;">[#]Format Proposal: pdf,doc,docx</h5>
                                    <h5 class="text-left" style="font-size:13px; color:red;">[#]Format RAB: xlsx</h5>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div style="overflow:auto;">
                        <div style="float: left;">
                            <button type="button" class="btn btn-danger" id="prevBtn" onclick="nextPrev(-1)">Sebelumnya</button>

                        </div>
                        <div style="float:right;">

                            <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Selanjutnya</button>
                            <input type="button" class="btn btn-success" id="b_test" value="Kirim">
                            <input type="button" class="btn btn-success" id="b_test2" value="Simpan">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>



<script>
    const dosen = <?= json_encode($dosen['dosen']); ?>;
    const mahasiswa = <?= json_encode($mahasiswa); ?>;
    const semua_dosen = <?= json_encode($dosen['all']); ?>;
</script>
<script src="<?= base_url() . JS_DOSEN; ?>pengajuan_pnbp_plp.js?random=<?= uniqid(); ?>"></script>




<script type="text/javascript">
    $(document).ready(function() {

        const regex = /[\/\\]([\w\d\s\.\-\(\)]+)$/;

        $('#cvKetua').on('change', function() {
            const fileName = $(this).val();
            $('#labelcvKetua').text(fileName.match(regex)[1]);
        });

        $('#cvAnggota1').on('change', function() {
            const fileName2 = $(this).val();
            $('#labelAnggota1').text(fileName2.match(regex)[1]);
        });

        $('#cvAnggota2').on('change', function() {
            const fileName3 = $(this).val();
            $('#labelAnggota2').text(fileName3.match(regex)[1]);
        });

        $('#proposal').on('change', function() {
            const fileName4 = $(this).val();
            $('#labelproposal').text(fileName4.match(regex)[1]);
        });

        $('#rab').on('change', function() {
            const fileName5 = $(this).val();
            $('#labelrab').text(fileName5.match(regex)[1]);
        });


        var counter = 2;

        $("#addButton").click(function() {


            var newSelectDiv = $(document.createElement('div'))
                .attr("id", 'append' + counter);

            newSelectDiv.after().html(`<hr>
                             <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="nimmahasiswa1">Nomor Induk Mahasiswa ${counter +1}</label>
                                        <input type="text" class="form-control nim_mhs" id="nim${counter+1}" placeholder="NIM MAHASISWA" name="nimmahasiswa" >

                                    </div>
                                    <div class="err-nim" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Field Ada Yang Kosong</h5>
                                    </div> 
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="jurusan_mhs1">Jurusan Mahasiswa ${counter +1}</label>
                                        <input type="text" class="form-control nim_mhs" id="jurusan_mhs${counter +1}" placeholder="Jurusan Mahasiswa" name="jurusan_mhs" >


                                    </div>
                                    <div class="err-jurusan" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>
                            </div>

                                <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="mahasiswa1">Nama Mahasiswa ${counter +1}</label>
                                        <input type="text" class="form-control" id="nm_mhs${counter +1}" placeholder="Nama Lengkap" name="nm_mhs" >
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="angkatan1">Angkatan Mahasiswa ${counter +1}</label>
                                        <input type="text" class="form-control" id="angkatan${counter +1}" placeholder="Angkatan Mahasiswa" name="angkatan" >
                                    </div>
                                    <div class="err-angkatan_mhs" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>
                            </div>`);

            newSelectDiv.appendTo(".append-group");
            $('.select2').select2();
            const find_masiswa = (nim) => {
                const data = mahasiswa.find(el => el.nim === nim);
                return data;
            }

            // $('#nim2').on('change', function() {
            //     const nim = $(this).val();
            //     if (nim !== '') {
            //         const data = find_masiswa(nim);
            //         $('#nm_mhs2').val(data.nama);
            //         $('#prodi2').val(`${data.prodi}- ${data.jurusan}, ${data.angkatan}`);
            //     } else {
            //         $('#nm_mhs2').val("");
            //         $('#prodi2').val("");
            //     }
            // });

            counter++;
        });

        $("#removeButton").click(function() {
            if (counter <= 2) {
                alert("Minimal 2 Mahasiswa");
                return false;
            }

            counter--;

            $("#append" + counter).remove();

        });

    });
</script>

<script>
    function checkextensionProposal() {
        var input = document.getElementById('proposal');
        var label = document.getElementById('labelproposal');
        var fileName = input.files[0].name;
        label.innerHTML = fileName;
    }

    function checkextensionRab() {
        var input = document.getElementById('rab');
        var label = document.getElementById('labelrab');
        var fileName = input.files[0].name;
        label.innerHTML = fileName;
    }
</script>

<script>
    $('.select2').select2();
    $(window).on('load', function() {
        $('#overlay').fadeOut(400);
    });
</script>

<?php if (isset($lanjut_dosen)) : ?>
    <script>
        let status_pengajuan = 'lanjut';
        const ketua = <?= json_encode($lanjut_dosen['ketua']) ?>;
        const anggota = <?= json_encode($lanjut_dosen['anggota']) ?>;
        $('#id_sinta1').prop('disabled', true);

        if (anggota.length === 1) {
            $('#anggota1').val(anggota[0].nidn).trigger('change');
            if (anggota[0].status_notifikasi == 1) {
                $('#anggota1').prop('disabled', true);
                $('#id_sinta2').prop('disabled', true);
            } else {
                $('#anggota1').prop('disabled', false);
                $('#id_sinta2').prop('disabled', false);
            }
        }

        if (anggota.length === 2) {
            $('input[name="pakegak"]').trigger('click');
            $('#anggota1').val(anggota[0].nidn).trigger('change');
            if (anggota[0].status_notifikasi == 1) {
                $('#anggota1').prop('disabled', true);
                $('#id_sinta2').prop('disabled', true);
            } else {
                $('#anggota1').prop('disabled', false);
                $('#id_sinta2').prop('disabled', false);

            }
            $('#anggota2').val(anggota[1].nidn).trigger('change');
            if (anggota[1].status_notifikasi == 1) {
                $('#anggota2').prop('disabled', true);
                $('#id_sinta3').prop('disabled', true);
            } else {
                $('#anggota2').prop('disabled', false);
                $('#id_sinta3').prop('disabled', false);
            }
        }


        if (anggota.length === 3) {
            $('input[name="pakegak3"]').trigger('click');
            $('#anggota2').val(anggota[1].nidn).trigger('change');
            if (anggota[1].status_notifikasi == 1) {
                $('#anggota2').prop('disabled', true);
                $('#id_sinta3').prop('disabled', true);
            } else {
                $('#anggota2').prop('disabled', false);
                $('#id_sinta3').prop('disabled', false);

            }
            $('#anggota3').val(anggota[2].nidn).trigger('change');
            if (anggota[2].status_notifikasi == 1) {
                $('#anggota3').prop('disabled', true);
                $('#id_sinta4').prop('disabled', true);
            } else {
                $('#anggota3').prop('disabled', false);
                $('#id_sinta4').prop('disabled', false);
            }
        }


        if (anggota.length === 4) {
            $('input[name="pakegak4"]').trigger('click');
            $('#anggota3').val(anggota[2].nidn).trigger('change');
            if (anggota[2].status_notifikasi == 1) {
                $('#anggota3').prop('disabled', true);
                $('#id_sinta4').prop('disabled', true);
            } else {
                $('#anggota3').prop('disabled', false);
                $('#id_sinta4').prop('disabled', false);

            }
            $('#anggota4').val(anggota[3].nidn).trigger('change');
            if (anggota[3].status_notifikasi == 1) {
                $('#anggota4').prop('disabled', true);
                $('#id_sinta5').prop('disabled', true);
            } else {
                $('#anggota4').prop('disabled', false);
                $('#id_sinta5').prop('disabled', false);
            }
        }
    </script>

<?php else : ?>
    <script>
        let status_pengajuan = 'tambah';
    </script>
<?php endif; ?>