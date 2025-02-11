<!-- Content Wrapper. Contains page content -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
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
            <div class="row notif">

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header d-flex">
                            <h3 class="card-title p-3">PNBP</h3>
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">PENELITIAN DOSEN</a></li>
                                <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">PENELITIAN PLP</a></li>
                                <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">PENGABDIAN</a></li>
                                <li class="nav-item ml-2" style="width: 130px;" ><input id="select_tahun"  type="text" class="form-control"></li>
                            </ul>
                        </div>


                        <div class="card-body">
                            <a href="<?= base_url('c_event_new/index_tambah'); ?>" class="btn btn-success">Tambah Event</a>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="table-responsive mb-5 text-nowrap">
                                        <h3 class="card-title text-center">PNBP PENELITIAN DOSEN <span class="titel-thn"></span></h3>

                                        <table id="tabelevent" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="5%">No.</th>
                                                    <th class="text-center" width="20%">Tahapan</th>
                                                    <th class="text-center" width="20%">Event dimulai</th>
                                                    <th class="text-center" width="20%">Event ditutup</th>
                                                    <th class="text-center" width="20%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bodynya">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_2">

                                    <div class="table-responsive mt-5 text-nowrap">
                                        <h3 class="card-title text-center">PNBP PENELITIAN PLP <span class="titel-thn"></span></h3>

                                        <table id="tabelevent-penelitianplp" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="5%">No.</th>
                                                    <th class="text-center" width="20%">Tahapan</th>
                                                    <th class="text-center" width="20%">Event dimulai</th>
                                                    <th class="text-center" width="20%">Event ditutup</th>
                                                    <th class="text-center" width="20%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bodynya-penelitianplp">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_3">

                                    <div class="table-responsive mt-5 text-nowrap">
                                        <h3 class="card-title text-center">PNBP PENGABDIAN <span class="titel-thn"></span></h3>

                                        <table id="tabelevent-pengabdian" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="5%">No.</th>
                                                    <th class="text-center" width="20%">Tahapan</th>
                                                    <th class="text-center" width="20%">Event dimulai</th>
                                                    <th class="text-center" width="20%">Event ditutup</th>
                                                    <th class="text-center" width="20%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bodynya-pengabdian">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>                                

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<script type="text/javascript" src="<?= base_url() . JS_UMUM . 'event_tambah.js?' . 'random=' . uniqid() ?> "></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script>
    //$('.table-bordered').DataTable();

    $("#select_tahun").datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
    }).datepicker('setDate',"<?= date('Y'); ?>");

    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>
