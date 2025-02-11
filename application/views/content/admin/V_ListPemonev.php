<link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/select2/css/select2.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url() . CSS_CUSTOM; ?>cssloader.css?random=<?= uniqid(); ?>">
<script src="<?php echo base_url('assets'); ?>/plugins/select2/js/select2.full.min.js"></script>

<style>
    .d-none {
        display: none;
    }
    .select2-selection__rendered {
        line-height: 31px !important;
    }

    .select2-container .select2-selection--single {
        height: 35px !important;
    }

    .select2-selection__arrow {
        height: 34px !important;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pemonev</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?= $brdcrmb; ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">

            <div class="nav-tabs-custom">
                <ul class="nav nav-pills p-2">
                    <?php foreach ($list_event->result() as $event) : ?>
                        <li class="nav-item">
                            <a class="nav-link jenis-event" href="#" aria-expanded="false" data-toggle="tab" data-list="<?= $event->id_jenis_event ?>"><?= $event->nm_event ?>-<?= $event->nm_pendanaan ?></a>
                        </li>
                    <?php endforeach ?>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item"><a class="nav-link active jenis_proses" href="#tab_1" data-list="proses" data-toggle="tab">Proses seleksi dan pembagian reviewer</a></li>
                        <li class="nav-item "><a class="nav-link jenis_proses" href="#tab_2" data-list="tidaklolos">Tidak lolos administrasi</a></li>
                    </ul>
                </ul>
               
               
               
                <div class="card-header header-ny">
                    <div class="row">
                        <div class="col-lg-12 col-md-18 col-sm-12" style="text-align: center;">
                            <h4>Pilih Data Untuk Dilihat Terlebih Dahulu</h3>
                        </div>

                    </div>
                </div>
                <!-- /.card-header -->
                <div class="container-fluid table-nya" style="display: none;">
                    <!-- /.card -->
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="row">
                                <h3 class="card-title" style="padding-top: 10px;padding-bottom:10px;">Filter List Proposal </h3>
                                <ul class="nav nav-pills ml-auto p-2">
                                    <li class="nav-item dropdown show">
                                        <!-- <a class="nav-link dropdown-toggle" id="toggle_show" href="#">
                                            Filter <span class="caret"></span>
                                        </a> -->
                                    </li>
                                </ul>
                            </div>
                            <div class="row" id="filter" style="display: line-block;">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Filter Skema</label>
                                        <select class="form-control select2" name="skema_select" id="skema_select" style="width: 100% !important; height:25px !important;">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Filter Fokus</label>
                                        <select class="form-control select2" name="fokus_select" id="fokus_select" style="width: 100%; height:25px;">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Filter Tahun</label>
                                    <input id="filterTahun" type="text" value="<?= date('Y') ?>" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <h3 class="card-title" style="padding-top: 10px;padding-bottom:10px;">List Proposal </h3>
                            <a href="#" class="btn btn-success mb-2" id="dl_excel">Export Excel</a>
                            <div class="table-responsive text-nowrap">
                                <table id="tabelevent" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="3%">Aksi</th>
                                            <th class="text-center" width="3%">No.</th>
                                            <th class="text-center" width="20%">Ketua - NIP</th>
                                            <th class="text-center" width="30%">Judul Proposal</th>
                                            <th class="text-center" width="3%">Tahun</th>
                                            <th class="text-center" width="20%">Skema</th>
                                            <th class="text-center" width="20%">Tanggal Unggah</th>
                                            <th class="text-center" width="20%">Terakhir Diupdate</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bodynya">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->

            </div>

            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" style="overflow:hidden;">
    <div class="modal-dialog">
        <!-- /.Loader -->
        <span id="loading"></span>

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pilih Reviewer</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Judul Proposal</label>
                    <input type="text" class="form-control" id="judul" disabled>
                </div>

                <div class="form-group">
                    <label>NIP Ketua</label>
                    <input type="text" class="form-control" id="ketua" disabled>
                    <input type="hidden" class="form-control" id="id_proposal" disabled>

                </div>
                <hr>
                <br>
                <div class="form-group">
                    <label for="reviewer1">Reviewer 1</label>
                    <select class="form-control select2" style="width: 100%;" id="reviewer1" name="reviewer">
                        <option value="">-- Cari Reviewer --</option>


                        <?php foreach ($dosen->result() as $d) { ?>
                            <option value="<?= $d->NIDSN ?>"><?= $d->nama_dosen ?></option>

                        <?php } ?>
                    </select>
                </div>
                <div class="form-group2">
                    <label for="reviewer2">Reviewer 2</label>
                    <select class="form-control select2" style="width: 100%;" id="reviewer2" name="reviewer">
                        <option value="">-- Cari Reviewer --</option>


                        <?php foreach ($dosen->result() as $d) { ?>
                            <option value="<?= $d->NIDSN ?>"><?= $d->nama_dosen ?></option>

                        <?php } ?>
                    </select>
                </div>
                <div class="append-group"></div>
                <div class="row" style="margin: 20px;">
                    <div class="col-md-6">
                        <input type="button" id="addButton" class="btn btn-success" value="Tambah Reviewer">
                    </div>
                    <div class="col-md-6">
                        <input type="button" id="removeButton" class="btn btn-danger" value="Hapus Reviewer">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-success" id="clicker" value="Submit">
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="<?= base_url() . JS_UMUM . 'dummy_pemonev.js?' . 'random=' . uniqid() ?> "></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#skema_select").select2();
        $("#fokus_select").select2();

        var counter = 3;

        $("#addButton").click(function() {

            if (counter > 99) {
                alert("Batas maksimal tercapai!");
                return false;
            }

            var newSelectDiv = $(document.createElement('div'))
                .attr("class", 'form-group' + counter);

            newSelectDiv.after().html('<label>Reviewer ' + counter + '</label>' +
                '<select class="form-control select2" style="width: 100%;" name="review' + counter +
                '" id="mySelect' + counter + '"><option selected="selected">Dosen A</option>' +
                '<option>Dosen B</option>' +
                '<option>Dosen C</option>' +
                '<option>Dosen D</option>' +
                '<option>Dosen E</option>' +
                '</select>');

            newSelectDiv.appendTo(".append-group");


            counter++;
        });

        $("#removeButton").click(function() {
            if (counter == 3) {
                alert("Batas minimum jumlah reviewer tercapai!");
                return false;
            }

            counter--;

            $(".form-group" + counter).remove();

        });


    });

    $('.modal').css('overflow-y', 'auto');
</script>
<script>
    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>