<style>
.scrollme {
    overflow-x: auto;
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
                    <h5>Pengajuan Mandiri Dosen</h5>
                    <div class="pull-right">
                        <a href="#" class="btn" data-toggle="modal" data-target="#modal-default" style="color:white;background-color:#197163">Anggota Dosen</a>
                        <a href="#" class="btn" data-toggle="modal" data-target="#modal-default-mahasiswa" style="color:white;background-color:#3b5249">Anggota Mahasiswa</a>
                        <a href="#" class="btn" data-toggle="modal" data-target="#modal-default-komentar" style="color:white;background-color:#519872">Komentar Staff</a>
                    </div>
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
                                    <label for="target">Target Luaran</label><br>
                                    <?php foreach ($luaran as $lr) { ?>
                                        <input type="checkbox" id="luaran1" name="luaran[]" <?= ((in_array($lr->id_luaran, $luaran_checked) ? 'checked' : 'disabled')) ?> value="<?= $lr->id_luaran ?>">
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

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="statusTKT">9. Ringkasan Usulan</label>
                                    <textarea value="" class="form-control" id="ringkasan" name="ringkasan" rows="4"><?= $dt_proposal->ringkasan; ?></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="statusTKT">10. Tinjauan Pustaka</label>
                                    <textarea value="" class="form-control" id="tinjauan" name="tinjauan" rows="4"><?= $dt_proposal->tinjauan; ?></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="statusTKT">11. Metode</label>
                                    <textarea value="" class="form-control" name="metode" rows="4"><?= $dt_proposal->metode; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h5><a href="<?= base_url('assets/berkas/file_proposal/').$dt_proposal->proposal ?>" target="_blank">FILE PROPOSAL</a></h5>
                        <h5><a href="<?= base_url('assets/berkas/file_rab/').$dt_proposal->rab ?>" target="_blank">FILE RAB</a></h5>

                   
                    <?php endif ?>
                </div>
                <!-- /.row -->
            </div>
            <br>
        </div><!-- /.container-fluid -->
    </section>
</div>


<div class="modal fade" id="modal-default">
    <div class="modal-lg modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Daftar Anggota Dosen</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jenis Unit</th>
                                <th>Unit</th>
                                <th>File CV</th>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($dosen as $ds) : ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $ds->nip ?></td>
                                        <td class="text-capitalize"><?= $ds->nama ?></td>
                                        <td><?= $ds->jenis_unit ?></td>
                                        <td><?= $ds->unit ?></td>
                                        <td><a target="_blank" class="btn btn-success" href="<?= base_url('assets/berkas/file_cv/') . $ds->file_cv ?>">Lihat CV</a></td>
                                    </tr>
                                <?php $no++;
                                endforeach; ?>
                                <?php ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-default-komentar">
    <div class="modal-lg modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Komentar Staff terhadap Pengajuan ini</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                    <div class="form-group">
                        <label for="statusTKT">Komentar</label>
                        <textarea value="" class="form-control" id="komentar" name="komentar" rows="4"><?= $dt_proposal->komentar; ?></textarea>
                    </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-default-mahasiswa">
    <div class="modal-lg modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Daftar Anggota Mahasiswa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Angkatan</th>
                                <th>Jurusan</th>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($mahasiswa as $mhs) : ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td class="text-capitalize"><?= $mhs->nama ?></td>
                                        <td><?= $mhs->angkatan ?></td>
                                        <td class="text-capitalize"><?= $mhs->jurusan ?></td>
                                    </tr>
                                <?php $no++;
                                endforeach; ?>
                                <?php ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('.table-bordered').DataTable();

    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>

<!-- /.content -->