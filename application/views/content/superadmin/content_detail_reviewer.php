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
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Judul Proposal</th>
                                    <th>Jenis Event</th>
                                    <th>NIDN Ketua</th>
                                </tr>
                            </thead>
                            <tbody><?php if (!empty($proposal)) : ?>
                                    <?php foreach ($proposal->result_array() as $re) : ?>
                                        <tr>
                                            <td><?= $re['judul'] ?></td>
                                            <td><?= $re['nm_event'] . ' ' . $re['nm_pendanaan'] ?></td>
                                            <td><?= $re['nidn_ketua'] ?></td>

                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" style="text-align: center;">Data Masih Kosong</td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Judul Proposal</th>
                                    <th>Jenis Event</th>
                                    <th>NIDN Ketua</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <br>
        </div><!-- /.container-fluid -->
    </section>
</div>
<!-- /.content -->