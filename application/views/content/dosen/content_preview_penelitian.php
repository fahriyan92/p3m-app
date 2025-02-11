<script src="<?= base_url() . JS_UMUM; ?>staff_tambah_reviewer.js?random=<?= uniqid(); ?>"></script>

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
                    <h5></h5>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- text input -->
                    <?php if (!empty($dt_proposal)) : ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Nama Ketua</label>
                                    <input class="form-control text-capitalize" type="text" value="<?= $dt_proposal->nama_ketua ?>" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">NIDN</label>
                                    <input class="form-control" type="text" value="<?= $dt_proposal->nidn_ketua ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputJudul">Judul</label>
                                    <input type="text" class="form-control" id="inputJudul" placeholder="Judul Penelitian" value="<?= $dt_proposal->judul; ?>" name="judulPenelitianDosenPNBP" disabled>
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
                        <!-- Data Luaran -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <h4> <strong>Daftar Target Luaran</strong> </h4>
                                    <label for="target">A. Wajib</label><br>

                                    <div class="table-responsive">
                                        <table class="table table-striped tabel-bordered table-hover" id="luaran">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">Target Luaran</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($luaran as $lr) { ?>
                                                    <?php if ($lr->jenis_luaran == 1) : ?>

                                                        <tr>
                                                            <td align="center"><?= $lr->judul_luaran ?></td>
                                                        </tr>

                                                    <?php endif; ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>

                                        <br>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="target">B. Tambahan</label><br>

                                                    <div class="table-responsive">
                                                        <table class="table table-striped tabel-bordered table-hover" id="luaran">
                                                            <thead>
                                                                <tr>
                                                                    <th style="text-align: center;">Target Luaran</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($luaran as $lr) { ?>
                                                                    <?php if ($lr->jenis_luaran == 2) : ?>

                                                                        <tr>
                                                                            <td align="center"><?= $lr->judul_luaran ?></td>
                                                                        </tr>

                                                                    <?php endif; ?>

                                                                <?php } ?>

                                                            </tbody>
                                                        </table>

                                                        <!-- Data Luaran -->

                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <h4> <strong>Laporkan Progress Luaran</strong> </h4> <br>
                                                                    <div class="form-group">
                                                                        <div class="col-md-6">
                                                                            <!-- Button trigger modal -->
                                                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#laporan">
                                                                                Laporkan Progress
                                                                            </button>

                                                                            <!-- Modal -->
                                                                            <div class="modal fade" id="laporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog" role="document">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="exampleModalLabel"><strong> Laporan Progress</strong></h5>
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span>
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <form>
                                                                                                <div class="form-group">

                                                                                                    <h5 class="modal-title" id="exampleModalLabel">Masukkan Prosentase Laporan : </h5>
                                                                                                    <select class="form-control select2 nm_dosen" style="width: 100%;" id="cari_dosen" name="nidn">

                                                                                                        <option value="">-- Pilih Target Luaran --</option>
                                                                                                        <?php foreach ($luaran as $lrnd) { ?>
                                                                                                            <?php if ($lrnd->jenis_luaran == 1) : ?>
                                                                                                                <option value="<?= $lrnd->judul_luaran ?>"><?= $lrnd->judul_luaran ?> - (Wajib)</option>
                                                                                                            <?php endif; ?>
                                                                                                        <?php } ?>
                                                                                                        <?php foreach ($luaran as $lrnd) { ?>
                                                                                                            <?php if ($lrnd->jenis_luaran == 2) : ?>
                                                                                                                <option value="<?= $lrnd->judul_luaran ?>"><?= $lrnd->judul_luaran ?> - (Tambahan)</option>
                                                                                                            <?php endif; ?>
                                                                                                        <?php } ?>
                                                                                                    </select>
                                                                                                </div>
                                                                                                <div class="form-group">
                                                                                                    <h5 class="modal-title" id="exampleModalLabel">Masukkan Prosentase Laporan : </h5>
                                                                                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Prosentase">
                                                                                                </div>
                                                                                                <div class="form-group">
                                                                                                    <h5 class="modal-title" id="exampleModalLabel">Nilai Reviewer : </h5>
                                                                                                    <input class="form-control" type="text" placeholder="50%" readonly>
                                                                                                    <small id="emailHelp" class="form-text text-muted">*Hanya reviewer yang bisa menilai</small>
                                                                                                    <div class="invalid-feedback">Example invalid custom select feedback</div>
                                                                                                </div>
                                                                                                <div class="form-group">
                                                                                                    <h5 class="modal-title" id="exampleModalLabel">Masukkan File Laporan : </h5>
                                                                                                    <input id="input-b2" name="input-b2" type="file" class="file" data-show-preview="false">
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                            <button id="tombolSimpan" type="button" class="btn btn-success">Simpan</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Button trigger modal -->
                                                                            <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#exampleModal">
                                                                                Lihat Laporan Luaran
                                                                            </button>

                                                                            <!-- Modal -->
                                                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog modal-xl" role="document">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="exampleModalLabel"> <strong>Laporan Luaran </strong></h5>
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span>
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <table class="table table-striped tabel-bordered table-hover" id="luaran">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th style="text-align: center;">No.</th>
                                                                                                        <th style="text-align: center;">Judul Luaran</th>
                                                                                                        <th style="text-align: center;">Prosentase Nilai</th>
                                                                                                        <th style="text-align: center;">Nilai Pemonev</th>
                                                                                                        <th style="text-align: center;">File Laporan</th>
                                                                                                        <th style="text-align: center;">Aksi</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    <?php foreach ($laporan as $lpr) { ?>


                                                                                                        <tr>
                                                                                                            <td></td>
                                                                                                            <td align="center"><?= $lpr->judul_luaran ?></td>
                                                                                                            <td align="center"><?= $lpr->prosentase ?></td>
                                                                                                            <td align="center"><?= $lpr->nilai ?></td>
                                                                                                            <td align="center"><?= $lpr->file ?></td>
                                                                                                            <td></td>
                                                                                                        </tr>

                                                                                                    <?php } ?>

                                                                                                </tbody>
                                                                                            </table>

                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>



                                                                <!-- Trigger the modal with a button -->
                                                                <!-- /.content 


                                                                            
        <label for="target">A. Wajib</label><br>

        <?php foreach ($luaran as $lr) { ?>
            <?php if ($lr->jenis_luaran == 1) : ?>

                <input type="checkbox" id="luaran1" name="luaran[]" <?= ((in_array($lr->id_luaran, $luaran_checked) ? 'checked' : 'disabled')) ?> value="<?= $lr->id_luaran ?>">
                <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>
            <?php endif; ?>

        <?php } ?>
        <label for="target">B. Tambahan</label><br>
        <?php foreach ($luaran as $lr) { ?>
            <?php if ($lr->jenis_luaran == 2) : ?>

                <input type="checkbox" id="luaran1" name="luaran[]" <?= ((in_array($lr->id_luaran, $luaran_checked) ? 'checked' : 'disabled')) ?> value="<?= $lr->id_luaran ?>">
                <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>
            <?php endif; ?>

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
        <?php if ($dt_proposal->proposal != null && $dt_proposal->proposal != "" && $dt_proposal->rab != null && $dt_proposal->rab != "") : ?>
            <div class="col-md-12 mb-3">
                <label>File Lampiran</label>
                <br>
                <a href="<?= base_url('assets/berkas/file_proposal/') . $dt_proposal->proposal ?>" target="_blank">File Proposal</a> |
                <a href="<?= base_url('assets/berkas/file_rab/') . $dt_proposal->rab ?>" target="_blank">File RAB</a>
            </div>
        <?php endif; ?>
-->




                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <h4> <strong>Data Anggota </strong> </h4>

                                                                            <div class="col-md-12">
                                                                                <div class="row">
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-6">
                                                                                            <input type="button" class="btn btn-primary btn-dosen" value="Lihat Dosen Terdaftar">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-6">
                                                                                            <input type="button" class="btn btn-primary btn-mhs" value="Lihat Mahasiswa Terdaftar">
                                                                                        </div>
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
                                                                                                            <th class="text-center" width="20%">NIP</th>
                                                                                                            <th class="text-center" width="20%">Nama</th>
                                                                                                            <th class="text-center" width="20%">File CV</th>
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
                                                                            <div class="col-md-12">
                                                                                <?php
                                                                                $pengajuan =  base_url($pengajuan_url);
                                                                                $edit =  base_url($edit_pengajuan_url);
                                                                                if ($dt_proposal->nidn_ketua == $_SESSION['nidn']) {
                                                                                    if ($cek_event != null) {
                                                                                        if ($cek_edit == 0) {
                                                                                            echo ('<a href="' . $pengajuan . '" class="btn btn-success" style="width:inherit;">Lanjutkan Pengajuan</a>');
                                                                                        } else {
                                                                                            echo ('<a href="' . $edit . '" class="btn btn-warning" style="width:inherit;">Edit Pengajuan</a>');
                                                                                        }
                                                                                    } else {
                                                                                        echo ('<a href="javascript:void(0)" class="btn btn-danger" style="width:inherit;">Event Telah Di Tutup, Tidak dapat melakukan Edit / Lanjut mengisi Pengajuan !</a>');
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        <?php endif ?>
                                                                        </div>
                                                                        <!-- /.row -->
                                                                    </div>
                                                                    <br>
                                                                </div><!-- /.container-fluid -->
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<script>
    $('#tombolSimpan').on('click', function() {
        alert('Sukses Menyimpan ');
    });
</script>

<script>
    $('.table-bordered').DataTable();

    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>

<!-- /.content -->