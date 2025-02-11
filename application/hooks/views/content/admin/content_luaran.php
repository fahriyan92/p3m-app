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
                            <a href="#" class="btn btn-primary tambah-luaran" data-toggle="modal" data-target="#modal-luaran"><i class="fa fa-plus"></i> Tambah Luaran</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive">
                                <table id="tabelevent" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="60%">Luaran Penelitian</th>
                                            <th width="15%">Jenis</th>
                                            <th width="15%">Status</th>
                                            <th width="10%">aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bodynya">
                                        <?php $no = 1;
                                        foreach ($luaran as $key) : ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $key->judul_luaran; ?></td>
                                                <td><?php if ($key->jenis_luaran == 1) {
                                                        echo "Wajib";
                                                    } else {
                                                        echo "Tambahan";
                                                    } ?></td>
                                                <td><?php if ($key->status == 1) : ?>
                                                        <button class="btn btn-success">Aktif</button>
                                                    <?php else : ?>
                                                        <button class="btn btn-danger">Non-Aktif</button>
                                                    <?php endif; ?>
                                                </td>
                                                <td><a href="" class="btn btn-primary editLuaran" data-id="<?= $key->id_luaran; ?>" id="<?= $key->id_luaran; ?>"><i class="fa fa-edit"></i></a></td>
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

<div class="modal fade" id="modal-luaran">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="">

                <div class="modal-header">
                    <h4 class="modal-title">Tambah Luaran Penelitian</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="luaran">Nama Luaran</label>
                                <textarea type="text" class="form-control" id="luaran" name="luaran" style="height: max-content;"></textarea>
                                <input type="hidden" class="form-control" id="luaranid" name="luaranid" style="height: max-content;"></input>
                            </div>
                            <div class="err-luaran" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="jnsluaran">Jenis Luaran</label>
                                <select name="jnsluaran" id="jnsluaran" class="form-control">
                                    <option value="">- Jenis Luaran -</option>
                                    <option value="1">Wajib</option>
                                    <option value="2">Tambahan</option>
                                </select>
                            </div>
                            <div class="err-luaran" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-2" id="status-luaran" style="display: none;">
                            <div class="form-group">
                                <input type="radio" id="aktif" name="status" value="1">
                                <label for="aktif">Aktif</label><br>
                                <input type="radio" id="nAktif" name="status" value="0">
                                <label for="nAktif">Non-Aktif</label><br>
                            </div>
                            <div class="err-luaran" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" id="simpan-luaran" value="Simpan">
                    <input type="submit" class="btn btn-warning" id="update-luaran" value="Edit" style="display: none;">
                </div>

            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script type="text/javascript" src="<?= base_url() . JS_UMUM . 'form_luaran.js?' . 'random=' . uniqid() ?> "></script>

<script>
    $('.table-bordered').DataTable();
    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>