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
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive">
                                <table id="tabelevent" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-center" width="20%">NIP</th>
                                            <th class="text-center" width="20%">Nama Dosen</th>
                                            <th class="text-center" width="20%">Pekerjaan</th>
                                            <th class="text-center" width="20%">Jenis Unit</th>
                                            <th class="text-center" width="10%">Unit</th>
                                            <th class="text-center" width="20%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bodynya">
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
</div>
</section>
<!-- /.content -->
</div>
<script type="text/javascript" src="<?= base_url() . JS_UMUM . 'master_data.js?' . 'random=' . uniqid() ?> "></script>

<script>
    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>