<!-- Content Wrapper. Contains page content -->
<link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/select2/css/select2.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet" />
<script src="<?php echo base_url('assets'); ?>/plugins/select2/js/select2.full.min.js"></script>
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
                <!-- <div class="col-12 alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                sukses ya
            </div> -->
            </div>
            <!-- SELECT2 EXAMPLE -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title title_form"><span class="mode-form">Tambah</span> Reviewer</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- /.form-group -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="reviewerMaster">Nama Reviewer</label>
                                                    <div id="add">
                                                        <select class="form-control" name="reviewer" id="reviewer">
                                                            <option value="">--Pilih Dosen--</option>
                                                            <?php foreach ($dosen as $key) { ?>
                                                                <option value="<?= $key->nidn ?>"><?= $key->nidn ?> - <?= $key->nama ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div id="edit" style="display: none;">
                                                        <select class="form-control" name="reviewer2" id="reviewer2">
                                                            <option value="">--Pilih Dosen--</option>
                                                            <?php foreach ($dosen2 as $key2) { ?>
                                                                <option value="<?= $key2->nidn ?>"><?= $key2->nidn ?> - <?= $key2->nama ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="error-tahapan col-sm-10 mt-2" style="display: none;">
                                                        <h5 style="font-size: 16px; color: red;">Tidak Boleh Kosong</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="event">Pilih Event</label>
                                                    <?php foreach ($event as $key) { ?>
                                                        <div class="form-check">
                                                            <input class="form-check-input checkboxes" name="eventids[]" type="checkbox" value="<?= $key->id_jenis_event ?>">
                                                            <label class="form-check-label"><?= $key->nm_event ?></label>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="error-tahapan col-sm-10 mt-2" style="display: none;">
                                                        <h5 style="font-size: 16px; color: red;">Tidak Boleh Kosong</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="append-group"></div>
                                        <br>
                                        <input type="hidden" id="id_reviewer">
                                        <button type="submit" id="simpan-btn" class="btn btn-block btn-primary">Simpan</button>
                                        <div class="row tempat-edit" style="display:none;">
                                            <div class="col-sm-6">
                                                <button type="submit" id="edit-btn" class="btn btn-block btn-warning">Edit</button>
                                            </div>
                                            <div class="col-sm-6">
                                                <button type="submit" id="batal-btn" style="background-color:#b5bbc8;" class="btn btn-block">Batal</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                </div>

                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-default">
                        <div class="card-body">
                            <div class="table-responsive mb-5 text-nowrap">
                                <h3 class="card-title text-center">Master Reviewer<span class="titel-thn"></span></h3>

                                <table id="tabelmasterrvw" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="5%">No.</th>
                                            <th class="text-center" width="40%">Nama Reviewer</th>
                                            <th class="text-center" width="20%">Event</th>
                                            <th class="text-center" width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="body">
                                    </tbody>
                                </table>
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
<script type="text/javascript" src="<?= base_url() . JS_UMUM . 'master_reviewer.js?' . 'random=' . uniqid() ?> "></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script>
    //$('.table-bordered').DataTable();

    $("#select_tahun").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    }).datepicker('setDate', "<?= date('Y'); ?>");

    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>