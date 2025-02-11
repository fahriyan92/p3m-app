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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


<!-- Content Wrapper. Contains page content -->
<input type="hidden" name="id_list_event" id="id_list_event" value="<?= $id_list_event ?>">
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
                        <li class="nav-item step"><a class="nav-link" href="#tab_2" data-toggle="tab">Data Dosen</a></li>
                        <li class="nav-item step"><a class="nav-link" href="#tab_5" data-toggle="tab">Mahasiswa</a></li>
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
                                        <input type="radio" name="jenis_penelitian" value="1" <?= $_SESSION['job'] === 'dosen' ? 'checked' : 'disabled' ?>>
                                        <span class="text-capitalize" for="fokus">Penelitian Dosen</span><br>
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
                                    <input type="hidden" name="id_pengajuan_detail" id="id_pengajuan_detail" value="<?= $dt_proposal->id_pengajuan_detail ?>">
                                <?php else:  ?>
                                    <input type="hidden" name="id_pengajuan_detail" id="id_pengajuan_detail" value="">
                                <?php endif; ?>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputJudul">3. Bidang Fokus Penelitian</label><br>
                                        <div class="err-fokus" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <?php foreach ($fokus as $fks) { ?>
                                            <input type="radio" name="fokus_penelitian" <?= (empty($dt_proposal) !== true ? $fks->id_fokus == $dt_proposal->id_fokus ? 'checked' : '' : '') ?> value="<?= $fks->id_fokus ?>">
                                            <span class="text-capitalize" for="fokus_penelitian"><?= $fks->bidang_fokus ?></span><br>
                                        <?php } ?>

                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputJudul">4. Tema Penelitian</label>
                                        <div class="err-tema" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <input type="text" autocomplete="off" value="<?= empty($dt_proposal) !== true ? $dt_proposal->tema : '' ?>" class="form-control" placeholder="Tema Penelitian" name="tema_penelitian">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputJudul">5. Sasaran Mitra (Jika Ada)</label>
                                        <input type="text" autocomplete="off" value="<?= empty($dt_proposal) !== true ? $dt_proposal->sasaran !== "null" ? $dt_proposal->sasaran : '' : '' ?>" class="form-control" id="inputSasaran" placeholder="Sasaran Penelitian" name="sasaran_penelitian">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputJudul">6. Judul Penelitian</label>
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
                                        <input type="date" value="<?= empty($dt_proposal) !== true ? $dt_proposal->mulai : '' ?>" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" placeholder="mulai" name="tgl_mulai">
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
                                        <input type="date" value="<?= empty($dt_proposal) !== true ? $dt_proposal->akhir : '' ?>" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" placeholder="akhir" name="tgl_akhir">
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
                                            <label for="target">A. Wajib</label><br>
                                            <?php foreach ($luaran as $lr) { ?>
                                                <?php if ($lr->jenis_luaran == 1) : ?>
                                                    <input type="checkbox" id="luaran1" name="luaran[]" <?= (empty($dt_proposal) !== true ? (in_array($lr->id_luaran, $luaran_checked) ? 'checked' : '') : '') ?> value="<?= $lr->id_luaran ?>">
                                                    <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>
                                                <?php endif; ?>
                                            <?php } ?>

                                            <label for="target">B. Tambahan</label><br>
                                            <?php foreach ($luaran as $lr) { ?>
                                                <?php if ($lr->jenis_luaran == 2) : ?>
                                                    <input type="checkbox" autocomplete="off" id="luaran1" name="luaran[]" <?= (empty($dt_proposal) !== true ? (in_array($lr->id_luaran, $luaran_checked) ? 'checked' : '') : '') ?> value="<?= $lr->id_luaran ?>">
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
                        <!-- ====================== TAB ANGGOTA ======================== -->
                        <div class="tab">

                            <div class="row ml-1">
                                <div>
                                    <label for="statusTKT">1. Anggota Dosen Polije</label>
                                </div>
                                <div class="ml-auto mr-3">
                                    <button type="button" class="btn btn-primary" id="addAnggotaPolije">Tambah Anggota</button>

                                </div>
                            </div>
                            <br>
                            <table id="table_list_anggota_dosen_polije" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <!-- b.nidn, b.nama,b.sinta,b.scopus,b.unit,b.jenis_unit,b.telepon -->
                                        <th>No.</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>ID-Sinta</th>
                                        <th>ID-Scopus</th>
                                        <th>Prodi</th>
                                        <th>Pangkat / Jabatan Fungsional</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="body_tbl_anggota_polije">

                                </tbody>
                            </table>
                            <hr>
                            <div id="container_anggota_luar">
                                <div class="row ml-1">
                                    <div>
                                        <label for="statusTKT">2. Anggota Luar</label>
                                    </div>
                                    <div class="ml-auto mr-3">
                                        <button type="button" class="btn btn-primary" id="addAnggotaLuar">Tambah Anggota</button>
                                    </div>
                                </div>
                                <br>
                                <table id="table_list_anggota_dosen_luar" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <!-- b.nidn, b.nama,b.sinta,b.scopus,b.unit,b.jenis_unit,b.telepon -->
                                            <th>No.</th>
                                            <th>No KTP</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>No hp</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_tbl_anggota_luar">

                                    </tbody>
                                </table>
                            </div>

                            <br>


                            <h6 id="alert_permintaan" style="color:red;display: none;">"Menunggu Respon Anggota Untuk Lanjut Pada Tahap Selanjutnya"</h6>
                        </div>
                        <!-- ====================== END TAB ANGGOTA ======================== -->

                        <div class="tab">
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="nimmahasiswa1">Nomor Induk Mahasiswa 1</label>
                                        <input type="text" autocomplete="off" class="form-control nim_mhs" id="nim1" placeholder="Nim Mahasiswa" name="nimmahasiswa">


                                    </div>
                                    <div class="err-nim" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Field Ada Yang Kosong</h5>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="jurusan_mhs1">Jurusan Mahasiswa 1</label>
                                        <input type="text" autocomplete="off" class="form-control nim_mhs" id="jurusan_mhs1" placeholder="Jurusan Mahasiswa" name="jurusan_mhs">


                                    </div>
                                    <div class="err-jurusan" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="mahasiswa1">Nama Mahasiswa 1</label>
                                        <input type="text" autocomplete="off" class="form-control" id="nm_mhs1" placeholder="Nama Lengkap" name="nm_mhs">
                                    </div>
                                    <div class="err-nama_mhs" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="angkatan1">Program Studi Mahasiswa 1</label>
                                        <input type="text" autocomplete="off" class="form-control" id="angkatan1" placeholder="Program Studi" name="angkatan">
                                    </div>
                                    <div class="err-angkatan_mhs" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="nimmahasiswa2">Nomor Induk Mahasiswa 2</label>
                                        <input type="text" autocomplete="off" class="form-control nim_mhs" id="nim2" placeholder="Nim Mahasiswa" name="nimmahasiswa">


                                    </div>
                                    <div class="err-nim" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Field Ada Yang Kosong</h5>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="jurusan_mhs2">Jurusan Mahasiswa 2</label>
                                        <input type="text" autocomplete="off" class="form-control nim_mhs" id="jurusan_mhs2" placeholder="Jurusan Mahasiswa" name="jurusan_mhs">


                                    </div>
                                    <div class="err-jurusan" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="mahasiswa2">Nama Mahasiswa 2</label>
                                        <input type="text" autocomplete="off" class="form-control" id="nm_mhs2" placeholder="Nama Lengkap" name="nm_mhs">
                                    </div>
                                    <div class="err-nama_mhs" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="angkatan2">Program Studi Mahasiswa 1</label>
                                        <input type="text" autocomplete="off" class="form-control" id="angkatan2" placeholder="Program Studi" name="angkatan">
                                    </div>
                                    <div class="err-angkatan_mhs" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>
                            </div>


                            <div class="append-group"></div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="button" id="addButton" class="btn btn-success" value="Tambah">
                                    <input type="button" id="removeButton" class="btn btn-danger" value="Hapus">
                                </div>
                            </div>
                            <br>
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

<!-- Modal -->
<div class="modal fade" id="ModaladdAnggotaPolije">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModaladdAnggotaPolijeLabel">Tambah Anggota Polije</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-anggota2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="anggota2">1. NIP Anggota </label>
                            <select class="form-control select2 nm_dosen" style="width: 100%;" id="anggota2" name="nidn">
                                <option value="">-- Cari NIP Dosen --</option>

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
                                <input type="text" disabled class="form-control" id="dsn_nama2" name="dsn_nama2">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nidn">3. Jurusan</label>
                            <div class="">
                                <input type="text" disabled class="form-control" id="dsn_jurusan2" name="dsn_jurusan2">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="pangkat">4. Pangkat / Jabatan Fungsional</label>
                            <div class="custom-file">
                                <input type="text" disabled class="form-control ag2" id="dsn_pangkat2" name="dsn_pangkat2">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="id_sinta">5. ID-Sinta</label>
                            <div class="custom-file">
                                <input type="number" class="form-control ag2" id="id_sinta3" value="" name="id_sinta" readonly>
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
                                <input type="number" class="form-control ag2" id="scopus3" value="" name="scopus" readonly>
                            </div>
                            <div class="err-sinta3" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSimpanAnggotaPolije">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ModaladdAnggotaLuar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModaladdAnggotaLuarLabel">Tambah Anggota Luar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-no_ktp_luar">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="no_ktp_luar">1. No KTP </label>
                            <input type="text" class="form-control" id="no_ktp_luar" name="no_ktp_luar">
                            <div class="err-no_ktp_luar" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nidn">2. NAMA DOSEN</label>
                            <div class="">
                                <input type="text" class="form-control" id="nama_luar" name="nama_luar">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nidn">3. Email</label>
                            <div class="">
                                <input type="text" class="form-control" id="email_luar" name="email_luar">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="pangkat">4. No. Hp</label>
                            <div class="custom-file">
                                <input type="text" class="form-control ag2" id="no_hp_luar" name="no_hp_luar">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="id_sinta">5. Alamat</label>
                            <div class="custom-file">
                                <input type="text" class="form-control ag2" id="alamat_luar" value="" name="alamat_luar">
                            </div>
                            <div class="err-alamat_luar" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="scopus">6. Gender</label>
                            <div class="custom-file">
                                <input type="text" class="form-control ag2" id="gender_luar" value="" name="gender_luar">
                            </div>
                            <div class="err-gender_luar" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSimpanAnggotaLuar">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    const dosen = <?= json_encode($dosen['dosen']); ?>;
    const mahasiswa = <?= json_encode($mahasiswa); ?>;
    const semua_dosen = <?= json_encode($dosen['all']); ?>;
</script>
<script src="<?= base_url() . JS_DOSEN; ?>pengajuan_pnbp.js?random=<?= uniqid(); ?>"></script>




<script type="text/javascript">
    $(document).ready(function() {

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        const obj = {
            //processing: true,
            language: {
                search: 'Cari',
                lengthMenu: 'Menampilkan _MENU_ data',
                info: 'Menampilkan _PAGE_ sampai _PAGES_ dari _MAX_ data',
                infoFiltered: '(difilter dari _MAX_ data)',
                paginate: {
                    previous: 'Sebelumnya',
                    next: 'Selanjutnya'
                },
                emptyTable: "Tidak Ada Data"
            },
            lengthMenu: [
                [10, 15, 20],
                [10, 15, 20]
            ]
        };

        let datatableDosenPolije;
        // $("#table_list_anggota_dosen_polije").DataTable(obj);




        const tb_list_anggota_polije = () => {
            if ($.fn.DataTable.isDataTable(datatableDosenPolije)) {
                datatableDosenPolije.clear().destroy();
            }

            const id_list_event = $('#id_list_event').val();
            const id_pengajuan_detail = $('#id_pengajuan_detail').val();

            console.log(id_list_event);
            console.log(id_pengajuan_detail);

            const url = `<?= base_url() ?>C_penelitian_dsn_pnbp/list_table_anggota_polije/`;
            const data = {
                id_list_event: id_list_event,
                id_pengajuan_detail: id_pengajuan_detail,
            };
            const tbl_anggota = $('#body_tbl_anggota_polije');

            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(res, textStatus, jqXHR) {
                const datanya = JSON.parse(res);
                tbl_anggota.html(datanya.html);

                datatableDosenPolije = $("#table_list_anggota_dosen_polije").DataTable(obj);
            });
        }
        tb_list_anggota_polije();

        const tb_list_anggota_luar = () => {
            const id_list_event = $('#id_list_event').val();
            const id_pengajuan_detail = $('#id_pengajuan_detail').val();

            console.log(id_list_event);
            console.log(id_pengajuan_detail);

            const url = `<?= base_url() ?>C_penelitian_dsn_pnbp/list_table_anggota_luar/`;
            const data = {
                id_list_event: id_list_event,
                id_pengajuan_detail: id_pengajuan_detail,
            };
            const tbl_anggota = $('#body_tbl_anggota_luar');

            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(res, textStatus, jqXHR) {
                const datanya = JSON.parse(res);
                tbl_anggota.html(datanya.html);

            });
        }
        tb_list_anggota_luar();

        $('#addAnggotaLuar').on('click', function() {
            $('#ModaladdAnggotaLuar').modal('show');
        })
        $('#deleteAnggotaLuar').on('click', function() {
            $('#ModalDeleteAnggotaLuar').modal('show');
        })

        $('#btnSimpanAnggotaLuar').on('click', function() {
            const id_list_event = $('#id_list_event').val();
            const id_pengajuan_detail = $('#id_pengajuan_detail').val();
            const no_ktp_luar = $("#no_ktp_luar");
            const nama_luar = $("#nama_luar");
            const email_luar = $("#email_luar");
            const no_hp_luar = $("#no_hp_luar");
            const alamat_luar = $("#alamat_luar");
            const gender_luar = $('#gender_luar');
            const skema = $('input[type=radio][name=jnsproposal]:checked').val()

            if (no_ktp_luar.val() == null || no_ktp_luar.val() == 0 || no_ktp_luar.val() == '') {
                toastr["error"]("Isi No KTP anggota terlebih dahulu !");
                return false;
            }
            if (nama_luar.val() == null || nama_luar.val() == 0 || nama_luar.val() == '') {
                toastr["error"]("Isi Nama anggota terlebih dahulu !");
                return false;
            }
            if (email_luar.val() == null || email_luar.val() == 0 || email_luar.val() == '') {
                toastr["error"]("Isi Email anggota terlebih dahulu !");
                return false;
            }

            const url = `<?= base_url() ?>C_penelitian_dsn_pnbp/insert_temp_anggota_luar/`;
            const data = {
                id_list_event: id_list_event,
                id_pengajuan_detail: id_pengajuan_detail,
                no_ktp_luar: no_ktp_luar.val(),
                nama_luar: nama_luar.val(),
                email_luar: email_luar.val(),
                no_hp_luar: no_hp_luar.val(),
                alamat_luar: alamat_luar.val(),
                gender_luar: gender_luar.val(),
                skema: skema,
            };

            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(res, textStatus, jqXHR) {
                const datanya = JSON.parse(res);
                if (datanya.status == 'error') {
                    toastr["error"](datanya.pesan);
                    return;
                } else {
                    tb_list_anggota_luar(); // reload table
                    $('#ModaladdAnggotaLuar').modal('hide');
                    toastr["success"]("Berhasil Tambah Anggota !");

                    no_ktp_luar.val('');
                    nama_luar.val('');
                    email_luar.val('');
                    no_hp_luar.val('');
                    alamat_luar.val('');
                    gender_luar.val('');

                    return;
                }


            });
        });

        $('#addAnggotaPolije').on('click', function() {
            $('#anggota2').val('').trigger('change');
            $('#ModaladdAnggotaPolije').modal('show');

        })
        // $('#deleteAnggotaPolije').on('click', function (){
        //     $('#ModalDeleteAnggotaPolije').modal('show');

        // })

        $(document).on('click', '.del_temp_polije', function() {
            const id_list_event = $(this).data('id_list_event');
            const nidn = $(this).data('nidn');

            const url = `<?= base_url() ?>C_penelitian_dsn_pnbp/delete_temp_polije/${nidn}/${id_list_event}`;

            $.ajax({
                url: url,
                method: 'GET',
            }).done(function(res, textStatus, jqXHR) {
                tb_list_anggota_polije(); // reload table
                toastr["success"]("Berhasil Delete Anggota Polije !");

            });

            console.log(`nidn : ${nidn} , id_list_event ${id_list_event}`);
        });

        $(document).on('click', '.del_not_temp_polije', function() {
            const id_pengajuan_detail = $(this).data('id_pengajuan_detail');
            const id_anggota_dsn = $(this).data('id_anggota_dsn');

            const url = `<?= base_url() ?>C_penelitian_dsn_pnbp/delete_not_temp_polije/${id_anggota_dsn}/${id_pengajuan_detail}`;

            $.ajax({
                url: url,
                method: 'GET',
            }).done(function(res, textStatus, jqXHR) {

                tb_list_anggota_polije(); // reload table
                toastr["success"]("Berhasil Delete Anggota Polije !");

            });

            console.log(`id_anggota_dsn : ${id_anggota_dsn} , id_pengajuan_detail ${id_pengajuan_detail}`);
        });

        $(document).on('click', '.del_temp_luar', function() {
            const id_list_event = $(this).data('id_list_event');
            const noktp = $(this).data('noktp');

            const url = `<?= base_url() ?>C_penelitian_dsn_pnbp/delete_temp_luar/${noktp}/${id_list_event}`;

            $.ajax({
                url: url,
                method: 'GET',
            }).done(function(res, textStatus, jqXHR) {
                tb_list_anggota_luar(); // reload table
                toastr["success"]("Berhasil Delete Anggota luar !");

            });

            console.log(`noktp : ${noktp} , id_list_event ${id_list_event}`);
        });

        $(document).on('click', '.del_not_temp_luar', function() {
            const id_pengajuan_detail = $(this).data('id_pengajuan_detail');
            const noktp = $(this).data('noktp');

            const url = `<?= base_url() ?>C_penelitian_dsn_pnbp/delete_not_temp_luar/${noktp}/${id_pengajuan_detail}`;

            $.ajax({
                url: url,
                method: 'GET',
            }).done(function(res, textStatus, jqXHR) {

                tb_list_anggota_luar(); // reload table
                toastr["success"]("Berhasil Delete Anggota luar !");

            });

            console.log(`noktp : ${noktp} , id_pengajuan_detail ${id_pengajuan_detail}`);
        });
        $('#btnSimpanAnggotaPolije').on('click', function() {
            const id_list_event = $('#id_list_event').val();
            const id_pengajuan_detail = $('#id_pengajuan_detail').val();
            const nama_dsn = $("#dsn_nama2").val();
            const jurusan_dsn = $("#dsn_jurusan2").val();
            const pangkat_dsn = $("#dsn_pangkat2").val();
            const sinta_dsn = $("#id_sinta3").val();
            const scopus_dsn = $("#scopus3").val();
            const nip_anggota = $('#anggota2').val();
            const skema = $('input[type=radio][name=jnsproposal]:checked').val()

            if (nip_anggota == null || nip_anggota == 0 || nip_anggota == '') {
                toastr["error"]("Pilih NIP anggota terlebih dahulu !");
                return false;
            }

            console.log(id_list_event);
            console.log(id_pengajuan_detail);

            const url = `<?= base_url() ?>C_penelitian_dsn_pnbp/insert_anggota_polije/`;
            const data = {
                id_list_event: id_list_event,
                id_pengajuan_detail: id_pengajuan_detail,
                nip_anggota: nip_anggota,
                skema: skema,

            };

            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(res, textStatus, jqXHR) {
                const datanya = JSON.parse(res);
                if (datanya.status == 'error') {
                    toastr["error"](datanya.pesan);
                    return;
                } else {
                    check_status_anggota();
                    tb_list_anggota_polije(); // reload table
                    $('#ModaladdAnggotaPolije').modal('hide');
                    toastr["success"]("Berhasil Tambah Anggota !");
                    return;
                }



            });
        });

        $('input[type=radio][name=jnsproposal]').on('change', function() {
            const id_list_event = $('#id_list_event').val();
            const skema = $(this).val();
            const url = `<?= base_url() ?>C_penelitian_dsn_pnbp/check_anggota_luar/${id_list_event}/${skema}`;

            if (skema == null || skema == 0 || skema == '') {
                return false;
            }

            $.ajax({
                url: url,
                method: 'GET',
            }).done(function(res, textStatus, jqXHR) {
                const datanya = JSON.parse(res);

                if (datanya.data.jml_agt_luar > 0) {
                    $('#container_anggota_luar').show();
                } else {
                    $('#container_anggota_luar').hide();
                }

                console.log(datanya.data.jml_agt_luar);

            });


        });

        //tambahan niko saat sudah ada id namun container table kelompok luar masih nongol meskipun bukan yang ada agt_luarnya
        if ($('#id_pengajuan_detail').val() != "") {
            <?php if (isset($dt_proposal)): ?>
                $('input[name="jnsproposal"][value="<?= $dt_proposal->id_kelompok_pengajuan ?>"]').prop('checked', true).trigger('change');
            <?php endif; ?>
        }
        //tambahan niko saat sudah ada id namun container table kelompok luar masih nongol meskipun bukan yang ada agt_luarnya


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
                                        <label for="angkatan1">Program Studi Mahasiswa 1 ${counter +1}</label>
                                        <input type="text" class="form-control" id="angkatan${counter +1}" placeholder="Program Studi" name="angkatan" >
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

<?php else : ?>
    <script>
        let status_pengajuan = 'tambah';
    </script>
<?php endif; ?>