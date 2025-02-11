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
                                        <input type="radio" name="jenis_penelitian" value="1" checked>
                                        <span class="text-capitalize" for="fokus">Penelitian Dosen</span><br>
                                        <input type="radio" name="jenis_penelitian" value="2">
                                        <span class="text-capitalize" for="fokus">Penelitian PLP</span><br>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputJudul">2. Bidang Fokus Penelitian</label><br>
                                        <div class="err-fokus" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <?php foreach ($fokus as $fks) { ?>
                                            <input type="radio" name="fokus_penelitian" <?= ($fks->id_detail_fokus == 1 ? 'checked' : '') ?> value="<?= $fks->id_detail_fokus ?>">
                                            <span class="text-capitalize" for="fokus_penelitian"><?= $fks->bidang_fokus ?></span><br>
                                        <?php } ?>

                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputJudul">3. Tema Penelitian</label>
                                        <div class="err-tema" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <input type="text" value="menanam emas" class="form-control" placeholder="Tema Penelitian" name="tema_penelitian">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputJudul">4. Sasaran Mitra (Jika Ada)</label>
                                        <input type="text" value="" class="form-control" id="inputSasaran" placeholder="Sasaran Penelitian" name="sasaran_penelitian">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputJudul">5. Judul Penelitian</label>
                                        <div class="err-judul" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <input type="text" value="menumbuhkan emas dari semangka" class="form-control" placeholder="Judul Penelitian" name="judul_penelitian">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tahunPenelitianDosenPNBP">6. Tahun Usulan</label>
                                        <div class="err-thn-usulan" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <input type="number" value="2020" class="form-control" min="2020" max="2099" step="1" name="tahun_penelitian">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tglmulai">7. Lama Penelitian (mulai)</label>
                                        <div class="err-mulai" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <input type="date" value="2020-04-27" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" placeholder="mulai" name="tgl_mulai">
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
                                        <input type="date" value="2020-04-27" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" placeholder="akhir" name="tgl_akhir">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="biaya_usulan">8. Biaya Usulan</label>
                                        <div class="err-biaya" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <input type="text" value="25000000" class="form-control" id="biayadiusulkan" placeholder="xxx.xxx.xxx" name="biaya_diusulkan">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="target">9. Target Luaran</label><br>
                                        <div class="err-luaran" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <?php foreach ($luaran as $lr) { ?>
                                            <input type="checkbox" id="luaran1" name="luaran[]" <?= (($lr->id_luaran == 1 || $lr->id_luaran == 3 || $lr->id_luaran == 5) ? 'checked' : '') ?> value="<?= $lr->id_luaran ?>">
                                            <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>
                                        <?php } ?>
                                        <div class="row" style="padding-left: 8px; padding-top: 4px;">
                                            <input type="checkbox" id="luaran12" name="luaran_tambahan" value="">
                                            <span style="padding-left:3px;" for="luaran11"> Lainnya</span><br>
                                            <div class="col-sm-6 tambahan_luaran">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <label for="statusTKT">10. Ringkasan Usulan (max. 500 kata)</label>
                                        <div class="err-ringkasan" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <textarea value="" class="form-control" id="ringkasan" name="ringkasan" rows="4">emas adalah emas</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <label for="statusTKT">11. Tinjauan Pustaka (max. 1000 kata)</label>
                                        <div class="err-tinjauan" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <textarea value="" class="form-control" id="tinjauan" name="tinjauan" rows="4">semangka adalah semangaka</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <label for="statusTKT">12. Metode (max. 600 kata)</label>
                                        <div class="err-metode" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <textarea value="" class="form-control" id="ringkasan" name="metode" rows="4">emas dan semangka berteman baik</textarea>
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
                                            <label for="ketua">1. NIDN / NIDK</label>
                                            <input type="text" class="form-control" name="nidn" disabled id="nidn_ketua" value="<?= $dosen['ketua'][0]->nidn ?>">

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nidn">2. NAMA DOSEN</label>
                                            <div class="custom-file">
                                                <input type="text" class="form-control" name="nama_dosen" value="<?= $dosen['ketua'][0]->nama ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="jurusan">3. Jurusan</label>
                                            <div class="custom-file">
                                                <input type="text" class="form-control" name="jurusan" value="<?= $dosen['ketua'][0]->jurusan ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="pangkat">4. Pangkat / Jabatan Fungsional</label>
                                            <div class="custom-file">
                                                <input type="text" class="form-control" id="pangkat" name="pangkat[]" value="<?= $dosen['ketua'][0]->jabatan ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="id_sinta">5. ID-Sinta</label>
                                        <div class="custom-file">
                                            <input type="number" class="form-control" id="id_sinta1" onkeydown="return event.keyCode !== 69" name="id_sinta">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="cvKetua">6. Unggah CV Ketua</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="cvKetua" name="filecv" hidden="hidden">
                                                <label class="custom-file-label" for="cvKetua" id="labelcvKetua">Pilih file</label>
                                            </div>
                                            <div class="err-cv-ketua" style="display:none;">
                                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h3 class="text-left">Data Anggota</h3>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="anggota1">1. NIDN Anggota 1</label>
                                            <select class="form-control select2 nm_dosen" style="width: 100%;" id="anggota1" name="nidn">
                                                <option value="">-- Cari NIDN Dosen --</option>
                                                <?php foreach ($dosen['dosen'] as $dsn) { ?>
                                                    <option value="<?= $dsn->nidn ?>"><?= $dsn->nidn ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="err-anggota1" style="display:none;">
                                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nidn">2. NAMA DOSEN</label>
                                            <div class="">
                                                <input type="text" disabled class="form-control" id="dsn_nama1" name="nama_dosen">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nidn">3. Jurusan</label>
                                            <div class="">
                                                <input type="text" disabled class="form-control" id="dsn_jurusan1" name="jurusan_anggota1">
                                            </div>
                                        </div>
                                    </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="id_sinta">5. ID-Sinta</label>
                                        <div class="custom-file">
                                            <input type="number" class="form-control" id="id_sinta2" name="id_sinta">
                                        </div>
                                        <div class="err-sinta2" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>  
                                    </div>
                                </div> 

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="cvKetua">6. Unggah CV Anggota 1</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="cvAnggota1" name="filecv" hidden="hidden">
                                            <label class="custom-file-label" for="cvAnggota1" id="labelAnggota1">Pilih file</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="id_sinta">5. ID-Sinta</label>
                                            <div class="custom-file">
                                                <input type="number" class="form-control" id="id_sinta2" name="id_sinta">
                                            </div>
                                            <div class="err-sinta2" style="display:none;">
                                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="id_sinta">5. ID-Sinta</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="cvAnggota1" name="filecv" hidden="hidden">
                                                <label class="custom-file-label" for="cvAnggota1" id="labelAnggota1">Pilih file</label>
                                            </div>
                                            <div class="err-cv-anggota1" style="display:none;">
                                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label for="pakegak">
                                                    Apakah Ingin Menambahkan Anggota 2?
                                                    <input style="margin-left:5px;" type="checkbox" name="pakegak">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-anggota2" style="display: none;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="anggota2">1. NIDN Anggota 2</label>
                                                    <select class="form-control select2 nm_dosen" style="width: 100%;" id="anggota2" name="nidn">
                                                        <option value="">-- Cari NIDN Dosen --</option>
                                                        <?php foreach ($dosen['dosen'] as $dsn) { ?>
                                                            <option value="<?= $dsn->nidn ?>"><?= $dsn->nidn ?></option>
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
                                                        <input type="number" class="form-control ag2" id="id_sinta3" name="id_sinta">
                                                    </div>
                                                    <div class="err-sinta3" style="display:none;">
                                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="cvKetua">6. Unggah CV Anggota 2</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="cvAnggota2" name="filecv" hidden="hidden">
                                                        <label class="custom-file-label" for="cvAnggota2" id="labelAnggota2">Pilih file</label>
                                                    </div>
                                                    <div class="err-cv-anggota2" style="display:none;">
                                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="tab">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="nimmahasiswa1">Nomor Induk Mahasiswa 1</label>
                                        <select class="form-control select2 nim_mhs" style="width: 100%;" id="nim1" name="nimmahasiswa">
                                            <option value="">-- Cari NIM Mahasiswa --</option>
                                            <?php foreach ($mahasiswa as $mhs) { ?>
                                                <option value="<?= $mhs->nim ?>"><?= $mhs->nim ?></option>
                                            <?php  } ?>
                                        </select>

                                    </div>
                                    <div class="err-nim" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="mahasiswa1">Nama Mahasiswa 1</label>
                                        <input type="text" class="form-control" id="nm_mhs1" placeholder="Nama Lengkap" name="nm_mhs1" disabled value="">
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="prodi1">Program Studi</label>
                                        <input type="text" class="form-control" id="prodi1" placeholder="Program Studi" name="prodi1" disabled value="">
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
                                                <input type="file" class="custom-file-input" id="proposal" name="proposal">
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
                                                <input type="file" class="custom-file-input" id="rab" name="rab">
                                                <label class="custom-file-label" for="rab" id="labelrab">Pilih file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div style="overflow:auto;">
                        <div style="float:right;">
                            <button type="button" class="btn btn-danger" id="prevBtn" onclick="nextPrev(-1)">Sebelumnya</button>
                            <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Selanjutnya</button>
                            <input type="button" class="btn btn-success" id="b_test" value="Kirim">
                            <input type="button" class="btn btn-success" id="b_test2" value="Kirim">
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
</script>
<script src="<?= base_url() . JS_DOSEN; ?>pengajuan_pnbp.js?random=<?= uniqid(); ?>"></script>

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


        var counter = 1;

        $("#addButton").click(function() {

            if (counter > 1) {
                alert("Cuma Boleh 2 Mahasiswa");
                return false;
            }

            var newSelectDiv = $(document.createElement('div'))
                .attr("id", 'append' + counter);

            newSelectDiv.after().html(`<hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="nimmahasiswa1">Nomor Induk Mahasiswa ${counter +1}</label>
                                        <select class="form-control select2 nim_mhs" style="width: 100%;" id="nim${counter+1}" name="nimmahasiswa">
                                            <option value="">-- Cari NIM Mahasiswa --</option>
                                            <?php foreach ($mahasiswa as $mhs) { ?>
                                                <option value="<?= $mhs->nim ?>"><?= $mhs->nim ?></option>
                                            <?php  } ?>
                                        </select>
                                    </div>
                                    <div class="err-nim" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div> 
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="mahasiswa1">Nama Mahasiswa ${counter +1}</label>
                                        <input type="text" class="form-control" id="nm_mhs${counter +1}" placeholder="Nama Lengkap" name="nm_mhs${counter +1}" disabled value="">
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="prodi1">Program Studi</label>
                                        <input type="text" class="form-control" id="prodi${counter +1}" placeholder="Program Studi" name="prodi${counter +1}" disabled value="">
                                    </div>
                                </div>
                            </div>`);

            newSelectDiv.appendTo(".append-group");
            $('.select2').select2();
            const find_masiswa = (nim) => {
                const data = mahasiswa.find(el => el.nim === nim);
                return data;
            }

            $('#nim2').on('change', function() {
                const nim = $(this).val();
                if (nim !== '') {
                    const data = find_masiswa(nim);
                    $('#nm_mhs2').val(data.nama);
                    $('#prodi2').val(`${data.prodi}- ${data.jurusan}, ${data.angkatan}`);
                } else {
                    $('#nm_mhs2').val("");
                    $('#prodi2').val("");
                }
            });

            counter++;
        });

        $("#removeButton").click(function() {
            if (counter == 1) {
                alert("Minimal 1 Mahasiswa");
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