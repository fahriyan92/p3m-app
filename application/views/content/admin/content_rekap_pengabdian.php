<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
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
            <div class="card card-default">
                <div class="card-header">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link jenis-event active" href="#" data-list="0">Belum diproses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link jenis-event" href="#" data-list="1" style="margin-left: 5px;">Lolos Pendanaan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link jenis-event " href="#" data-list="2" style="margin-left: 5px;">Tidak Lolos Pendanaan</a>
                        </li>
                        <div class="ml-auto"><a href="#" id="download-excel" class="btn btn-success">Download Laporan Excel</a></div>                        
                    </ul>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row mb-5">
                                <div class="col-6 text-left">
                                    <label for="pilih-tahun">Pilih Tahun</label>
                                    <div class="clear-fix"></div>
                                    <input type="text" placeholder="tahun" id="tahun" name="tahun" class="form-control pull-right" style="width:250px">
                                    <div class="clear-fix"></div>
                                </div>
                                <div class="col-6 text-right">
                                </div>
                            </div>
                            <div class="table-responsive text-nowrap">
                                <table id="tabelnya" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="widht:10px;">#</th>
                                            <th class="text-center">Judul</th>
                                            <th class="text-center">Pengaju</th>
                                            <th class="text-center">Nilai</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bodynya">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-score" role="dialog" style="overflow:hidden;">
    <div class="modal-dialog modal-xl">
        <!-- /.Loader -->
        <span id="loading"></span>

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">List Nilai Proposal</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive text-nowrap">
                    <table id="score-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width:10px">#</th>
                                <th>Nama Reviewer</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody class="bodyscore">
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" style="background-color:#E5DF88">Rata-rata</td>
                                <td style="background-color:#E5DF88;font-weight:bold;" class="rata">32</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id-update">
                    <div class="button-action">
                    <input type="button" class="btn btn-danger update" data-status="2" value="Tolak">
                    <input type="button" class="btn btn-success update" data-status="1" value="Terima">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const TAHUN_NOW = "<?= date('Y'); ?>";
</script>
<script src="<?= base_url() . JS_UMUM; ?>staff_rekap_pengabdian.js?random=<?= uniqid(); ?>"></script>