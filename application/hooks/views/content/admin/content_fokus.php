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
                            <a href="#" class="btn btn-primary tambah-fokus" data-toggle="modal" data-target="#modal-fokus"><i class="fa fa-plus"></i> Tambah Fokus</a>
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
                                            <th width="10%">No</th>
                                            <th width="50%">Bidang Fokus</th>
                                            <th width="20%">Event</th>
                                            <th width="15%">Status</th>
                                            <th width="10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bodynya">
                                        <?php $no = 1;
                                        foreach ($fokus as $key) : ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $key->bidang_fokus; ?></td>
                                                <td><?= $key->nm_event; ?></td>
                                                <td><?php if ($key->status == 1) : ?>
                                                        <button class="btn btn-success">Aktif</button>
                                                    <?php else : ?>
                                                        <button class="btn btn-danger">Non-Aktif</button>
                                                    <?php endif; ?>
                                                </td>
                                                <td><a href="" class="btn btn-primary editfokus" id="<?= $key->id_fokus; ?>" data-toggle="modal" data-target="#modal-editfokus"><i class="fa fa-edit"></i></a></td>
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


<div class="modal fade" id="modal-fokus">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="">

                <div class="modal-header">
                    <h4 class="modal-title">Tambah Bidang Fokus Penelitian</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" id="hide">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="fokus">Judul Fokus</label>
                                <input type="text" class="form-control" id="fokus" placeholder="Fokus Penelitian" name="fokus">
                            </div>
                            <div class="error-fokus" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                           <div class="col-sm-10">
                                <div class="form-group">
                                    <label for="event">Pilih Event</label>
                                    <select class="form-control" name="event" id="event">
                                        <option value="">-Pilih Event-</option>
                                        <?php foreach ($event as $key) : ?>
                                            <option value="<?= $key->id_event; ?>"><?= $key->nm_event; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="error-event" style="display:none;">
                                    <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" id="simpan-fokus" class="btn btn-primary" value="Simpan" style="display: none;">
                    <input type="submit" id="simpan-fokusdtl" class="btn btn-primary" value="Simpan" style="display: none;">
                </div>

            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-editfokus">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="">

                <div class="modal-header">
                    <h4 class="modal-title">Edit Bidang Fokus Penelitian</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" id="hide">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="fokus">Judul Fokus</label>
                                <input type="text" class="form-control" id="fokus" placeholder="Fokus Penelitian" name="fokus" required="" value="asdasdasd">
                            </div>
                            <div class="error-fokus" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="radio" id="aktif" name="status" value="1" required="">
                                <label for="aktif">Aktif</label><br>
                                <input type="radio" id="nAktif" name="status" value="0" required="">
                                <label for="nAktif">Non-Aktif</label><br>
                            </div>
                            <div class="err-nim" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                                <input type="hidden" class="form-control" id="fokusId" name="fokusId"></input>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" id="simpan-fokus" class="btn btn-primary" value="Simpan" style="display: none;">
                    <input type="submit" class="btn btn-warning" id="update-fokus" value="Edit" style="display: none;">
                </div>

            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script type="text/javascript" src="<?= base_url() . JS_UMUM . 'form_fokus.js?' . 'random=' . uniqid() ?> "></script>

<script>
    $('.table-bordered').DataTable();
    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>