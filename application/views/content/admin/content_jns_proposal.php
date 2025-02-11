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
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-9 col-md-8 col-sm-2">
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-1" style="text-align: right;">
                            <a href="#" class="btn btn-primary tambah-jnsproposal" data-toggle="modal" data-target="#modal-jnsproposal"><i class="fa fa-plus"></i> Tambah Data</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive">
                                <table id="jenisproposal" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="55%">Skema</th>
                                            <th width="15%">Biaya</th>
                                            <th width="20%">Status</th>
                                            <th width="10%">aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bodynya">
                                        <?php $no = 1;
                                        foreach ($kelompok as $key) : ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $key->nama_kelompok; ?></td>
                                                <td><?= $key->biaya_proposal; ?></td>
                                                <td><?php if ($key->status == 1) : ?>
                                                        <button class="btn btn-success">Aktif</button>
                                                    <?php else : ?>
                                                        <button class="btn btn-danger">Non-Aktif</button>
                                                    <?php endif; ?>
                                                </td>
                                                <td><a href="" class="btn btn-primary editKelompok" data-id="<?= $key->id_kelompok_pengajuan; ?>" id="<?= $key->id_kelompok_pengajuan; ?>"><i class="fa fa-edit"></i></a></td>
                                            </tr>
                                        <?php $no++;
                                        endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="modal-jnsproposal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="">

                <div class="modal-header">
                    <h4 class="modal-title">Tambah Skema</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="jnsproposal">Skema</label>
                                <input type="text" class="form-control" id="jnsproposal" name="jnsproposal" style="height: max-content;"></input>
                                <input type="hidden" class="form-control" id="jnsproposalid" name="jnsproposalid" style="height: max-content;"></input>
                            </div>
                            <div class="err-jnsproposal" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="biayaproposal">Biaya</label>
                                <input type="number" class="form-control" id="biayaproposal" name="biayaproposal" style="height: max-content;"></input>
                            </div>
                            <div class="err-biayaproposal" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-2" id="status-jnsproposal" style="display: none;">
                            <div class="form-group">
                                <label></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="aktif" name="status" value="1">
                                    <label class="form-check-label" for="aktif">Aktif</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="nAktif" name="status" value="0">
                                    <label class="form-check-label" for="nAktif">Non-Aktif</label>
                                </div>
                            </div>
                            <div class="err-statusjnsproposal" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="jnsproposal">Pilih Luaran</label>
                                <div class="table-responsive">
                                    <table id="luarantabel" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Luaran Proposal</th>
                                                <th>Jenis</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bodynya">
                                            <?php foreach ($luaran as $key) : ?>
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="luaran_pilih[]" type="checkbox" value="<?= $key->id_luaran; ?>">
                                                            <label class="form-check-label"><?= $key->judul_luaran; ?></label>
                                                        </div>
                                                    </td>
                                                    <td><?php if ($key->jenis_luaran == 1) {
                                                            echo "Wajib";
                                                        } else {
                                                            echo "Tambahan";
                                                        } ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" id="simpan-jnsproposal" value="Simpan">
                    <input type="submit" class="btn btn-warning" id="update-jnsproposal" value="Edit" style="display: none;">
                </div>

            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script type="text/javascript" src="<?= base_url() . JS_UMUM . 'form_jnsproposal.js?' . 'random=' . uniqid() ?> "></script>

<script>
    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>