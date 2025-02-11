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
                            <a href="<?= base_url('C_hindex/tambah_Hindex'); ?>" class="btn btn-primary"> <i class="fa fa-plus"></i> Tambah Kuota Pengajuan</a>
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
                                            <th class="text-center" width="5%">NIP</th>
                                            <th class="text-center" width="25%">Nama Dosen</th>
                                            <th class="text-center" width="10%">H-Index Scopus</th>
                                            <th class="text-center" width="10%">H-Index Schoolar</th>
                                            <th class="text-center" width="10%">Kuota Pengajuan Penelitian</th>
                                            <th class="text-center" width="10%">Kuota Pengajuan Pengabdian</th>
                                            <th class="text-center" width="10%">Jenis Job</th>
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
<script type="text/javascript" src="<?= base_url() . JS_UMUM . 'tambah_hindex.js?' . 'random=' . uniqid() ?> "></script>

<script>
    $('.table-bordered').DataTable();
    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>