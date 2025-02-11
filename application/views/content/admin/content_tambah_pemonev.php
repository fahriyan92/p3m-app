<script src="<?php echo base_url('assets'); ?>/plugins/select2/js/select2.full.min.js"></script>
<script src="<?= base_url() . JS_UMUM; ?>staff_tambah_pemonev.js?random=<?= uniqid(); ?>"></script>

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
                        <?php if (!empty($dtl_proposal)) : ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputJudul">Judul</label>
                                        <textarea class="form-control" id="inputJudul" rows="2"
                                            name="judulPenelitianDosenPNBP" disabled><?= $dt_proposal->judul; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="jnsproposal">Jenis Pengajuan Proposal</label><br>
                                        <div class="err-fokus" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong
                                            </h5>
                                        </div>
                                        <?php foreach ($kelompok as $key) { ?>
                                            <input type="radio" name="jnsproposal" disabled
                                                <?= (empty($dt_proposal) !== true ? $key->id_kelompok_pengajuan == $dt_proposal->id_kelompok_pengajuan ? 'checked' : '' : '') ?>
                                                value="<?= $key->id_kelompok_pengajuan ?>">
                                            <span class="text-capitalize"
                                                for="jnsproposal"><?= $key->nama_kelompok ?></span><br>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tahunPenelitianDosenPNBP">Tahun Usulan</label>
                                        <input type="number" class="form-control" min="1900" max="2099" step="1"
                                            value="<?= $dtl_proposal->tahun_usulan; ?>" id="tahunPenelitianDosenPNBP"
                                            name="tahunPenelitianDosenPNBP" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tglmulai">Lama Penelitian (mulai)</label>
                                        <input type="date" class="form-control" data-inputmask-inputformat="dd/mm/yyyy"
                                            id="tglmulai" placeholder="mulai" name="tglmulai"
                                            value="<?= $dtl_proposal->mulai; ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-1" style="text-align: center; margin-top:36px">
                                    <span> - </span>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tglakhir">(akhir)</label>
                                        <input type="date" class="form-control" id="tglakhir"
                                            data-inputmask-inputformat="dd/mm/yyyy" placeholder="akhir" name="tglakhir"
                                            value="<?= $dtl_proposal->akhir; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputJudul">Tema Penelitian</label>
                                        <input type="text" class="form-control" placeholder="Tema Penelitian"
                                            name="tema_penelitian" value="<?= $dtl_proposal->tema; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputJudul">Sasaran Mitra</label>
                                        <input type="text" value="<?= $dtl_proposal->sasaran; ?>" class="form-control"
                                            id="inputSasaran" placeholder="Sasaran Penelitian" name="sasaran_penelitian"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="biayadiusulkan">Biaya yang diusulkan</label>
                                        <input type="text" class="form-control" id="biayadiusulkan"
                                            value="<?= rupiah($dtl_proposal->biaya_usulan); ?>" placeholder="Rp.8.500.000,-"
                                            name="biayadiusulkan" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="target">10. Target Luaran</label><br>
                                        <div class="err-luaran" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong
                                            </h5>
                                        </div>
                                        <?php if ($dt_proposal->id_event == 3) : ?>
                                            <?php foreach ($luaran as $lr) { ?>
                                                <input type="checkbox" id="luaran1" name="luaran[]" disabled
                                                    <?= (empty($dt_proposal) !== true ? (in_array($lr->id_luaran, $luaran_checked) ? 'checked' : '') : '') ?>
                                                    value="<?= $lr->id_luaran ?>">
                                                <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>
                                            <?php } ?>
                                        <?php else : ?>
                                            <label for="target">A. Wajib</label><br>
                                            <?php foreach ($luaran as $lr) { ?>
                                                <?php if ($lr->jenis_luaran == 1) : ?>
                                                    <input type="checkbox" id="luaran1" name="luaran[]" disabled
                                                        <?= (empty($dt_proposal) !== true ? (in_array($lr->id_luaran, $luaran_checked) ? 'checked' : '') : '') ?>
                                                        value="<?= $lr->id_luaran ?>">
                                                    <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>
                                                <?php endif; ?>
                                            <?php } ?>

                                            <label for="target">B. Tambahan</label><br>
                                            <?php foreach ($luaran as $lr) { ?>
                                                <?php if ($lr->jenis_luaran == 2) : ?>
                                                    <input type="checkbox" id="luaran1" name="luaran[]" disabled
                                                        <?= (empty($dt_proposal) !== true ? (in_array($lr->id_luaran, $luaran_checked) ? 'checked' : '') : '') ?>
                                                        value="<?= $lr->id_luaran ?>">
                                                    <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>
                                                <?php endif; ?>
                                            <?php } ?>
                                        <?php endif; ?>

                                        <?php if ($luaran_tambahan !== null) { ?>
                                            <div class="row" style="padding-left: 8px; padding-top: 8px;">
                                                <input type="checkbox" id="luaran12" name="luaran_tambahan" checked value=""
                                                    disabled>
                                                <span style="padding-top: 5px; padding-left:3px;" for="luaran11">
                                                    Lainnya</span><br>
                                                <div class="col-sm-6 tambahan_luaran">
                                                    <input type="text" class="form-control" id="luaran12"
                                                        value="<?= $luaran_tambahan->judul ?>" disabled name="tambahan_luaran">
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
                                        <input type="button" class="btn btn-primary btn-dosen"
                                            value="Lihat <?= $dt_proposal->id_event == 3 ? "PLP" : "Dosen" ?> Terdaftar">
                                    </div>
                                </div>
                                <?php if ($dt_proposal->id_event != 3) : ?>
                                    <div class="form-group">
                                        <div class="col-sm-3">
                                            <input type="button" class="btn btn-primary btn-mhs"
                                                value="Lihat Mahasiswa Terdaftar">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <div class="col-md-6 anggota-dosen" style="display: none;">
                                    <div class="card card-default">
                                        <div class="card-header">
                                            <h3 class="card-title">List Anggota
                                                <?= $dt_proposal->id_event == 3 ? "PLP" : "Dosen" ?> </h3>
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
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>File Lampiran</label>
                                    <br>
                                    <a href="<?= base_url('assets/berkas/file_proposal/') . $dtl_proposal->proposal ?>"
                                        target="_blank">File Proposal</a> |
                                    <a href="<?= base_url('assets/berkas/file_rab/') . $dtl_proposal->rab ?>"
                                        target="_blank">File RAB</a>
                                </div>

                            </div>
                            <hr style="border: 1.5px solid grey; ">
                            <?php if ($dtl_proposal->status_keputusan == null) : ?>
                                <h6 style="font-weight: bold; font-size:20px;">Status :
                                    <span class="badge badge-info">Seleksi Administrasi</span>
                                </h6>
                            <?php elseif ($dtl_proposal->status_keputusan == 1) : ?>
                                <h6 style="font-weight: bold; font-size:20px;">Status :

                                    <span class="badge badge-info">Lolos Pendanaan</span>

                                </h6>
                            <?php elseif ($dtl_proposal->status_keputusan == 2) : ?>
                                <h6 style="font-weight: bold; font-size:20px;">Status :

                                    <span class="badge badge-info">Tidak Lolos Pendanaan</span>

                                </h6>

                            <?php elseif ($dtl_proposal->status_keputusan == 3) : ?>
                                <h6 style="font-weight: bold; font-size:20px;">Status :
                                    <span class="badge badge-info ">Lanjut Ke Tahap Review</span>
                                </h6>

                            <?php elseif ($dtl_proposal->status_keputusan == 4) : ?>
                                <h6 style="font-weight: bold; font-size:20px;">Status :

                                    <span class="badge badge-info">Tidak Lolos Administrasi</span>

                                </h6>

                            <?php elseif ($dtl_proposal->status_keputusan == 5) : ?>
                                <h6 style="font-weight: bold; font-size:20px;">Status :

                                    <span class="badge badge-info">Tidak Lolos Review</span>

                                </h6>

                            <?php elseif ($dtl_proposal->status_keputusan == 6) : ?>
                                <h6 style="font-weight: bold; font-size:20px;">Status :

                                    <span class="badge badge-info">Lanjut Ke Tahap Monev</span>

                                </h6>

                            <?php elseif ($dtl_proposal->status_keputusan == 7) : ?>
                                <h6 style="font-weight: bold; font-size:20px;">Status :

                                    <span class="badge badge-info">Lolos Monev</span>

                                </h6>

                            <?php elseif ($dtl_proposal->status_keputusan == 8) : ?>
                                <h6 style="font-weight: bold; font-size:20px;">Status :

                                    <span class="badge badge-info">Tidak Lolos Monev</span>

                                </h6>
                            <?php elseif ($dtl_proposal->status_keputusan == 9) : ?>
                                <h6 style="font-weight: bold; font-size:20px;">Status :

                                    <span class="badge badge-info">Tahap Evaluasi</span>

                                </h6>
                            <?php elseif ($dtl_proposal->status_keputusan == 10) : ?>
                                <h6 style="font-weight: bold; font-size:20px;">Status :

                                    <span class="badge badge-info">Lolos Evaluasi</span>

                                </h6>
                            <?php elseif ($dtl_proposal->status_keputusan == 11) : ?>
                                <h6 style="font-weight: bold; font-size:20px;">Status :

                                    <span class="badge badge-info">Tidak Lolos Evaluasi</span>

                                </h6>
                            <?php endif ?>
                            <br>
                            <?php if ($rekap != true) : ?>
                                <?php if ($this->session->userdata('level') != 4) : ?>

                                    <?php if ($dtl_proposal->status_keputusan != null && $dtl_proposal->status_keputusan == 6 || $dtl_proposal->status_keputusan == 7) : ?>

                                        <!-- /.row -->
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h6 style="font-weight: bold;">Pemonev Yang Ditunjuk</h6>
                                            </div>
                                            <div class="col-md-4">
                                                <?php if ($check_event_review != null) : ?>

                                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal"
                                                        style="float: right;">Tambah Pemonev</a>
                                                <?php else : ?>
                                                    <a href="javascript:void(0)" class="btn btn-danger" style="float: right;">Event Monev
                                                        Masih Di Tutup</a>
                                                <?php endif; ?>

                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table id="table-reviewe-list" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th width="3%">No</th>
                                                                <th>Nama Pemonev</th>
                                                                <th>NIP</th>
                                                                <th>Jurusan</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody><?php if (!empty($reviewer)) : $no = 1; ?>
                                                                <?php foreach ($reviewer->result_array() as $re) : ?>
                                                                    <tr>
                                                                        <td><?= $no; ?>.</td>
                                                                        <td><?= $re['nama'] ?></td>
                                                                        <td><?= $re['nip'] ?></td>
                                                                        <td><?= $re['unit'] ?></td>
                                                                        <td>
                                                                            <?php if ($re['nilai_fix'] == "Belum Dimonev") : ?>
                                                                                <a href="<?= base_url("C_pemonev/hapusPemonev/") . $re['id_kerjaan_monev']; ?>"
                                                                                    class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                                            <?php endif ?>

                                                                            <a href="<?= base_url("C_pemonev/hasil_kerjaan_pemonev/") . $re['id_kerjaan_monev']; ?>/<?= $dtl_proposal->id_event ?>"
                                                                                class="btn btn-sm btn-primary">Lihat Monev</a>
                                                                        </td>

                                                                    </tr>
                                                                    <?php $no++; ?>
                                                                <?php endforeach; ?>
                                                            <?php else : ?>
                                                                <tr>
                                                                    <td colspan="5" style="text-align: center;">Data Masih Kosong</td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama Pemonev</th>
                                                                <th>NIP</th>
                                                                <th>Jurusan</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    <?php elseif ($dtl_proposal->status_keputusan == 0) : ?>
                                        <h1 class="text-center"> SELEKSI ADMINISTRASI</h1>

                                    <?php elseif ($dtl_proposal->status_keputusan == 1) : ?>
                                        <h1 class="text-center"> LOLOS PENDANAAN</h1>

                                    <?php elseif ($dtl_proposal->status_keputusan == 3) : ?>
                                        <h1 class="text-center"> TAHAP REVIEW</h1>

                                    <?php elseif ($dtl_proposal->status_keputusan == 5) : ?>
                                        <h1 class="text-center"> TIDAK LOLOS REVIEW</h1>

                                    <?php elseif ($dtl_proposal->status_keputusan == 4) : ?>
                                        <h1 class="text-center"> TIDAK LOLOS ADMINISTRASI</h1>

                                    <?php elseif ($dtl_proposal->status_keputusan == 8) : ?>
                                        <h1 class="text-center"> TIDAK LOLOS MONEV</h1>

                                    <?php else : ?>
                                        <div class="col-md-12">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <a href="#" class="btn btn-success tombol-terima" data-tmbl="lanjut_review"
                                                        style="float: left; width:inherit;">Lanjut Ke Tahap Review</a>
                                                </div>
                                                <div class="col-md-6">
                                                    <a href="#" class="btn btn-danger tombol-tolak" data-tmbl="tolak_administrasi"
                                                        style="float: right; width:inherit;">Tidak Lolos Administrasi</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>

                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </section>
</div>

<div class="modal fade" id="myModal" role="dialog" style="overflow:hidden;">
    <div class="modal-dialog">
        <!-- /.Loader -->
        <span id="loading"></span>

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pilih Pemonev</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <?php $idproposal = $this->uri->segment('3'); ?>
            <div class="modal-body">
                <form action="<?= base_url("C_pemonev/prosesTambahPemonev/") . $idproposal; ?>" method="post">
                    <div class="form-group">
                        <select class="form-control select2" style="width: 100%;" id="NIDSN" name="NIDSN">
                            <option value="">-- Cari Pemonev --</option>
                            <?php foreach ($dosen->result() as $d) { ?>
                                <?php if ($d->status != 0) : ?>
                                    <?php if (!in_array($d->nidn, $reviewer_diproposal)) : ?>

                                        <option value="<?= $d->nidn ?>"><?= $d->nidn . '-' . $d->nama ?></option>
                                    <?php endif; ?>
                                <?php endif; ?>

                            <?php } ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="submit" class="btn btn-success" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('.select2').select2();

    $('#table-reviewe-list').DataTable();
    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>