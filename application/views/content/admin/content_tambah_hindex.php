<script src="<?php echo base_url('assets'); ?>/plugins/select2/js/select2.full.min.js"></script>
<style>
    .table-condensed>thead>tr>th,
    .table-condensed>tbody>tr>th,
    .table-condensed>tfoot>tr>th,
    .table-condensed>thead>tr>td,
    .table-condensed>tbody>tr>td,
    .table-condensed>tfoot>tr>td {
        padding: 1px;
    }

    .table_morecondensed>thead>tr>th,
    .table_morecondensed>tbody>tr>th,
    .table_morecondensed>tfoot>tr>th,
    .table_morecondensed>thead>tr>td,
    .table_morecondensed>tbody>tr>td,
    .table_morecondensed>tfoot>tr>td {
        padding: 1px;
    }
</style>
<style>
    .select2-selection__rendered {
        line-height: 31px !important;
    }

    .select2-container .select2-selection--single {
        height: 35px !important;
    }

    .select2-selection__arrow {
        height: 34px !important;
    }

    #prevBtn {
        background-color: #dc3545;
    }
</style>
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
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title title_form">Tambah Limit Dosen</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- /.form-group -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="InputNIDN">NIP</label><br>
                                    <select class="form-control select2 nm_dosen" style="width: 100%;" id="cari_dosen" name="nidn">
                                        <option value="">-- Cari NIP Dosen --</option>
                                        <?php print_r($dosen); ?>
                                        <?php foreach ($dosen as $dsn) { ?>
                                            <option value="<?= $dsn->nidn ?>"><?= $dsn->nidn ?>- <?= $dsn->nama ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="error-nidn col-sm-10 mt-2" style="display: none;">
                                        <h5 style="font-size: 16px; color: red;">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="InputNama">Nama Dosen</label><br>
                                    <input type="text" class="form-control" id="nama_dsn" name="dsn_nama2" readonly>
                                    <div class="error-nama col-sm-10 mt-2" style="display: none;">
                                        <h5 style="font-size: 16px; color: red;">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputStart1">H-Index Scopus</label>
                                    <input type="number" class="form-control" id="inputStart1" name="index_scopus" placeholder="H-Index">
                                    <div class="error-index_scopus col-sm-10 mt-2" style="display: none;">
                                        <h5 style="font-size: 16px; color: red;">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputStart1">H-Index Schoolar</label>
                                    <input type="number" class="form-control" id="inputStart1" name="index_schoolar" placeholder="H-Index">
                                    <div class="error-index_schoolar col-sm-10 mt-2" style="display: none;">
                                        <h5 style="font-size: 16px; color: red;">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!--                             <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="roleHindex">Sebagai</label>
                                    <select class="form-control select" style="width: 100%;" name="roleHindex" id="roleHindex">
                                        <option value="">Pilih Role H-Index</option>
                                        <option value="1">Ketua</option>
                                        <option value="2">Anggota</option>
                                    </select>
                                    <div class="error-roleHindex col-sm-10 mt-2" style="display: none;">
                                        <h5 style="font-size: 16px; color: red;">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputJenis">Jumlah Maks. Pengajuan Proposal (PENELITIAN)</label><br>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input class="form-control" type="number" id="max_penelitian" name="max_penelitian" placeholder="Jumlah Pengajuan" />
                                            <div class="error-max_penelitian col-sm-10 mt-2" style="display: none;">
                                                <h5 style="font-size: 16px; color: red;">Tidak Boleh Kosong</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputJenis">Jumlah Maks. Pengajuan Proposal (PENGABDIAN)</label><br>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input class="form-control" type="number" id="max_pengabdian" name="max_pengabdian" placeholder="Jumlah Pengajuan " />
                                            <div class="error-max_pengabdian col-sm-10 mt-2" style="display: none;">
                                                <h5 style="font-size: 16px; color: red;">Tidak Boleh Kosong</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <button type="submit" id="simpan-btn" class="btn btn-block btn-primary">Simpan</button>
                    </div>
                    <!-- /.card-body -->
                    <!-- /.row -->

                </div>

                <!-- /.card -->
            </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<script type="text/javascript" src="<?= base_url() . JS_UMUM . 'tambah_hindex.js?' . 'random=' . uniqid() ?> "></script>
<script>
    // data dosen
    const dosen = <?= json_encode($dosen); ?>;

    $('.select2').select2();

    $('.table-bordered').DataTable();
    $(window).on("load", function() {

        $('#overlay').fadeOut(400);
    });
</script>