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
            <!-- <div class="card">
                <div class="card-header">
                    <h4>Filter</h4>
                </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-2">
                        <div class="form-group">
                            <label>Jarak waktu:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="reservationtime">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-2">
                        <div class="form-group">
                            <label>User:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <input type="text" class="form-control pull-right">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-2">
                        <div class="form-group">
                            <label>Event:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <input type="text" class="form-control pull-right">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-4 col-sm-1" style="margin-top: 30px;">
                        <a href="" class="btn btn-primary" style="float:right;">Proses</a>
                    </div>
                </div>
            </div>
        </div> -->
            <div class="card">
                <div class="card-header">
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive text-nowrap">
                                <table id="tabelevent" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="20%">Waktu</th>
                                            <th width="15%">User</th>
                                            <th width="10%">Role</th>
                                            <th width="10%">Event</th>
                                            <th width="45%">Aktivitas</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bodynya">
                                        <?php foreach ($log->result_array() as $l) : ?>
                                            <tr>
                                                <td><?= $l['created_at'] ?></td>
                                                <td><?= $l['nama_staff'] ?></td>
                                                <td><?= $l['nama_level_staff'] ?></td>
                                                <td><?= $l['event_staff'] ?></td>
                                                <td><?= $l['ket_aktivitas'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
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

<script>
    $('.table-bordered').DataTable();
    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>