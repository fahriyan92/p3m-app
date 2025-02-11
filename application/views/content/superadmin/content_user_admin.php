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
                        <div class="col-lg-10 col-md-8 col-sm-2">
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-1">
                            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah-admin"> <i class="fa fa-plus"></i> Tambah Admin</a>
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
                                                <th width="20%">NO</th>
                                                <th width="20%">Nama User</th>
                                                <th width="20%">Username</th>
                                                <!-- <th width="20%">aksi</th> -->
                                            </tr>
                                        </thead>
                                        <tbody class="bodynya">
                                            <?php $no = 1;
                                            foreach ($admin as $key) : ?>
                                                <tr>
                                                    <td><?= $no ?></td>
                                                    <td><?= $key->nama_staff; ?></td>
                                                    <td><?= $key->username_staff; ?></td>
                                                    <!-- <td><a href="" data-toggle="modal" data-target="#modal-tambah-admin" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i></a></td> -->
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


<div class="modal fade" id="modal-tambah-admin">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="">

                <div class="modal-header">
                    <h4 class="modal-title">Tambah Admin</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="namaAdmin">Nama Admin</label>
                                <input type="text" class="form-control" id="namaAdmin" placeholder="Nama Admin" name="namaAdmin" value="">
                            </div>
                            <div class="err-nim" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="UsernameAdmin">Username</label>
                                <input type="text" class="form-control" placeholder="Username" id="UsernameAdmin" name="UsernameAdmin" value=""></input>
                            </div>
                            <div class="err-nim" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="passAdmin">Password</label>
                                <input type="password" class="form-control" placeholder="Password" id="passAdmin" name="passAdmin" value=""></input>
                            </div>
                            <div class="err-nim" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Simpan">
                </div>

            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script>
    $('.table-bordered').DataTable();
    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>