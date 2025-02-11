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

                            <h3 class="profile-username text-center"><?php echo $this->session->userdata('nama'); ?> </h3>

                            <p class="text-muted text-center"><?php echo $dosen[0]->jenis_job;  ?></p>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <h3 class="card-title">Data Diri</h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="settings">
                                <form action="<?= site_url('C_master_data/update_profile') ?>" method="post">
                                <input type="hidden" name="form_bagian" value="bagian_dosen">
                                 <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="NIP" class=" control-label">NIP Dosen</label>
                                        <div class="col-sm-12">
                                            <input type="NIP" class="form-control" id="NIP-dosen" placeholder="NIP Dosen" value="<?= $dosen[0]->nidn; ?>" readonly>
                                        </div>
                                    </div>
                                    </div>
                                    <!-- <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="Sinta" class=" control-label">ID Sinta Dosen</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="Sinta-dosen" name="sinta" placeholder="ID Sinta Dosen">
                                        </div>
                                    </div>
                                    </div> -->
                                    </div>

                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                      <label for="unit" class="control-label">Jenis Unit</label>
                                        <div class="col-sm-12">
                                        <input type="unit" class="form-control" id="unit-dosen" placeholder="Unit Dosen" value="<?= $dosen[0]->jenis_unit ?>" readonly>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <label for="unit" class="control-label">Unit</label>
                                        <div class="col-sm-12">
                                        <input type="unit" class="form-control" id="unit-dosen" placeholder="Unit Dosen" value="<?= $dosen[0]->unit ?>" readonly>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="nik" class=" control-label">No. KTP</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="nik-dosen" name="nik" placeholder="No KTP Dosen" value="<?= $dosen[0]->nik ?>">

                                        </div>
                                       
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="no_hp" class=" control-label">No. HP</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="no_hp-dosen" name="no_hp" placeholder="Nomer HP Dosen" value="<?= $dosen[0]->telepon ?>">

                                        </div>
                                       
                                    </div>
                                    </div>

                                    </div>
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="pangkat" class=" control-label">Pangkat</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="pangkat-dosen" name="pangkat" placeholder="Pangkat Dosen" value="<?= $dosen[0]->pangkat ?>">

                                        </div>
                                       
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="golongan" class=" control-label">Golongan</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="golongan-dosen" name="golongan" placeholder="Golongan Dosen" value="<?= $dosen[0]->golongan ?>">
 
                                        </div>
                                       
                                    </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="tanggal_masuk" class=" control-label">Tanggal Masuk</label>
                                        <div class="col-sm-12">
                                            <input type="date" class="form-control" id="tanggal_masuk-dosen" name="tanggal_masuk" placeholder="Tanggal Masuk Dosen" value="<?= $dosen[0]->tanggal_masuk ?>">

                                        </div>
                                       
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="gender" class=" control-label">Jenis Kelamin</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="gender-dosen" name="gender" placeholder="Jenis Kelamin" value="<?= $dosen[0]->jenis_kelamin ?>">

                                        </div>
                                       
                                    </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email" class=" control-label">Email</label>
                                        <div class="col-sm-12">
                                            <input type="email" class="form-control" id="email-dosen" name="email" placeholder="Email Dosen" value="<?= $dosen[0]->email ?>">
                                            <input type="hidden" name="nip" value="<?= $dosen[0]->nip ?>">
                                            <?php if($this->session->flashdata('email-error')): ?> 
                                            <p style="color:red; "><?= $this->session->flashdata('email-error') ?></p>
                                            <?php endif; ?>
                                        </div>
                                       
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="alamat" class=" control-label">Alamat</label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" id="alamat-dosen" name="alamat" placeholder="Alamat Dosen"><?= $dosen[0]->alamat ?></textarea>

                                        </div>
                                       
                                    </div>
                                    </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button type="submit" class="btn btn-success ganti">Simpan Data</button>
                                        </div>
                                    </div>
                                    </form>
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


<!-- <script type="text/javascript" src="<?= base_url() . JS_UMUM . 'profile.js?' . 'random=' . uniqid() ?>"></script> -->
<script>
    $('.table-bordered').DataTable();
    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>