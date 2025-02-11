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
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="<?php echo base_url('assets'); ?>/dist/img/default-avatar.png" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">admin</h3>

                            <p class="text-muted text-center">ADMIN</p>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Pengaturan</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">

                                <div class="tab-pane active" id="settings">
                                    <div class="form-group">
                                        <label for="password" class="col-sm-2 control-label">Password Lama</label>

                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="password-lama" placeholder="Password Lama">
                                        </div>
                                        <div class="error-pass-lama col-sm-10 mt-2" style="display: none;">
                                            <h5 style="font-size: 16px; color: red;">Password Salah!</h5>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="col-sm-2 control-label">Password Baru</label>

                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="password-baru" placeholder="Password Baru">
                                        </div>
                                        <div class="error-pass-baru col-sm-10 mt-2" style="display: none;">
                                            <h5 style="font-size: 16px; color: red;">Tidak Boleh Kosong!</h5>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="re_password" class="col-sm-2 control-label">Konfirmasi</label>

                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="re-password" placeholder="Konfirmasi Password">
                                        </div>
                                        <div class="error-pass-konfirmasi col-sm-10 mt-2" style="display: none;">
                                            <h5 style="font-size: 16px; color: red;">Password Konfirmasi Tidak Sama!</h5>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-success ganti">Ganti Password</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>


<script type="text/javascript" src="<?= base_url() . JS_UMUM . 'profile.js?' . 'random=' . uniqid() ?>"></script>