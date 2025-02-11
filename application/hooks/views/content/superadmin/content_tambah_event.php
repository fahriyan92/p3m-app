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
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Event</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- /.form-group -->
                            <form id="form_login" method="post">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="inputJudul">Judul Event</label>
                                           <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputJudul" placeholder="Judul Event" name="judulPenelitianPNBP">
                                            </div>
                                                <div class="error-judul col-sm-10 mt-2" style="display: none;">
                                                    <h5 style="font-size: 16px; color: red;">Tidak Boleh Kosong</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputStart">Start date</label>
                                           <div class="col-sm-10">
                                                <input type="date" class="form-control" id="inputStart" name="inputStart">
                                            </div>
                                                <div class="error-start col-sm-10 mt-2" style="display: none;">
                                                    <h5 style="font-size: 16px; color: red;">Tidak Boleh Kosong</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputEnd">End date</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="inputEnd" name="inputEnd">
                                            </div>
                                                <div class="error-end col-sm-10 mt-2" style="display: none;">
                                                    <h5 style="font-size: 16px; color: red;">Tidak Boleh Kosong</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="jenisEvent">Jenis Event</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="inpJenis" name="jenisEvent">
                                                    <option value="">--Pilih Jenis Event--</option>
                                                    <option value="Penelitian Dosen PNBP">Penelitian Dosen PNBP</option>
                                                    <option value="Penelitian Dosen Mandiri">Penelitian Dosen Mandiri</option>
                                                    <option value="Pengabdian Dosen">Pengabdian Dosen</option>
                                                    <option value="Penelitian Teknisi">Penelitian Teknisi</option>
                                                </select>
                                            </div>
                                                <div class="error-jenis col-sm-10 mt-2" style="display: none;">
                                                    <h5 style="font-size: 16px; color: red;">Tidak Boleh Kosong</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<script type="text/javascript" src="<?= base_url() . JS_UMUM . 'event_tambah.js?' . 'random=' . uniqid() ?> "></script>