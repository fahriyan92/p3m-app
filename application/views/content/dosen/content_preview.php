<script src="<?= base_url() . JS_UMUM; ?>staff_tambah_reviewer.js?random=<?= uniqid(); ?>"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <?= $judul; ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <?= $brdcrmb; ?>
                        </li>
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
                                    <textarea class="form-control" id="inputJudul" rows="2" name="judulPenelitianDosenPNBP" disabled><?= $dt_proposal->judul; ?></textarea>
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


                                    <!-- Trigger the modal with a button -->






                                    <label for="target">A. Wajib</label><br>

                                    <?php foreach ($luaran as $lr) { ?>
                                        <?php if ($lr->jenis_luaran == 1) : ?>

                                            <input type="checkbox" id="luaran1" name="luaran[]" <?= ((in_array(
                                                                                                    $lr->id_luaran,
                                                                                                    $luaran_checked
                                                                                                ) ? 'checked' : 'disabled')) ?> value="<?= $lr->id_luaran ?>">
                                            <span for="luaran1">
                                                <?= $lr->judul_luaran ?>
                                            </span><br>
                                        <?php endif; ?>

                                    <?php } ?>
                                    <label for="target">B. Tambahan</label><br>
                                    <?php foreach ($luaran as $lr) { ?>
                                        <?php if ($lr->jenis_luaran == 2) : ?>

                                            <input type="checkbox" id="luaran1" name="luaran[]" <?= ((in_array(
                                                                                                    $lr->id_luaran,
                                                                                                    $luaran_checked
                                                                                                ) ? 'checked' : 'disabled')) ?> value="<?= $lr->id_luaran ?>">
                                            <span for="luaran1">
                                                <?= $lr->judul_luaran ?>
                                            </span><br>
                                        <?php endif; ?>

                                    <?php } ?>
                                    <?php if ($luaran_tambahan !== null) { ?>
                                        <div class="row" style="padding-left: 8px; padding-top: 8px;">
                                            <input type="checkbox" id="luaran12" name="luaran_tambahan" checked value="">
                                            <span style="padding-top: 5px; padding-left:3px;" for="luaran11">
                                                Lainnya</span><br>
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
                                <a href="<?= base_url('assets/berkas/file_proposal/') . $dt_proposal->proposal ?>" target="_blank" class="btn btn-success"><i style="font-size:35px;" class="icon fas fa-download"></i> Unduh File Proposal</a> |
                                <a href="<?= base_url('assets/berkas/file_rab/') . $dt_proposal->rab ?>" target="_blank" class="btn btn-success"><i style="font-size:35px;" class="icon fas fa-download"></i> Unduh File
                                    RAB</a>
                            </div>
                        <?php endif; ?>





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
                            $pengajuan = base_url($pengajuan_url);
                            $edit = base_url($edit_pengajuan_url);
                            $pengajuan_evaluasi = base_url($pengajuan_evaluasi_url);
                            if ($dt_proposal->nidn_ketua == $_SESSION['nidn']) {
                                if ($cek_event != null) {
                                    if ($cek_edit == 0) {
                                        echo ('<a href="' . $pengajuan . '" class="btn btn-success" style="width:inherit;">Lanjutkan Pengajuan</a>');
                                    } else {
                                        echo ('<a href="' . $edit . '" class="btn btn-warning" style="width:inherit;">Edit Pengajuan</a>');
                                    }
                                } elseif ($cek_event_evaluasi != null) {
                                    if ($dt_proposal->status_keputusan == 6 || $dt_proposal->status_keputusan == 7) {
                                        echo '<a href="' . $pengajuan_evaluasi . '" class="btn btn-success" style="width:inherit;">Isi atau Edit Laporan Akhir</a>';
                                    } elseif ($dt_proposal->status_keputusan == 2 || $dt_proposal->status_keputusan == 4 || $dt_proposal->status_keputusan == 5) {
                                        echo '<a href="javascript:void(0)" class="btn btn-danger" style="width:inherit;">Proposal Tidak Memenuhi Syarat Untuk Melanjutkan Event Evaluasi</a>';
                                    } else {
                                        echo 'Hanya Ketua Tim';
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
<script>
    $('.table-bordered').DataTable();

    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>

<!-- /.content -->