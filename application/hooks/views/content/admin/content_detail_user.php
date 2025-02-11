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

                            <h3 class="profile-username text-center text-uppercase"><?php echo $dosen->nama;  ?> </h3>

                            <p class="text-muted text-center text-uppercase"><?php echo $dosen->jenis_job;  ?></p>

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
                                <li class="nav-item"><a class="nav-link active" href="#Ddosen" data-toggle="tab">Data Dosen</a></li>
                                <li class="nav-item"><a class="nav-link" href="#hindex" data-toggle="tab">H-Index Dosen</a></li>
                                <li class="nav-item"><a class="nav-link" href="#histori" data-toggle="tab">Riwayat Pengajuan</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="Ddosen">
                                <form action="<?= site_url('C_master_data/update_profile') ?>" method="post">

                                 <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="NIP" class=" control-label">NIP Dosen</label>
                                        <div class="col-sm-12">
                                            <input type="NIP" class="form-control" id="NIP-dosen" placeholder="NIP Dosen" value="<?= $dosen->nidn; ?>" readonly>
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
                                        <input type="unit" class="form-control" id="unit-dosen" placeholder="Unit Dosen" value="<?= $dosen->jenis_unit ?>" readonly>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <label for="unit" class="control-label">Unit</label>
                                        <div class="col-sm-12">
                                        <input type="unit" class="form-control" id="unit-dosen" placeholder="Unit Dosen" value="<?= $dosen->unit ?>" readonly>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="nik" class=" control-label">No. KTP</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="nik-dosen" name="nik" placeholder="No KTP Dosen" value="<?= $dosen->nik ?>">

                                        </div>
                                       
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="no_hp" class=" control-label">No. HP</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="no_hp-dosen" name="no_hp" placeholder="Nomer HP Dosen" value="<?= $dosen->telepon ?>">

                                        </div>
                                       
                                    </div>
                                    </div>

                                    </div>
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="pangkat" class=" control-label">Pangkat</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="pangkat-dosen" name="pangkat" placeholder="Pangkat Dosen" value="<?= $dosen->pangkat ?>">

                                        </div>
                                       
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="golongan" class=" control-label">Golongan</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="golongan-dosen" name="golongan" placeholder="Golongan Dosen" value="<?= $dosen->golongan ?>">
 
                                        </div>
                                       
                                    </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="tanggal_masuk" class=" control-label">Tanggal Masuk</label>
                                        <div class="col-sm-12">
                                            <input type="date" class="form-control" id="tanggal_masuk-dosen" name="tanggal_masuk" placeholder="Tanggal Masuk Dosen" value="<?= $dosen->tanggal_masuk ?>">

                                        </div>
                                       
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="gender" class=" control-label">Jenis Kelamin</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="gender-dosen" name="gender" placeholder="Jenis Kelamin" value="<?= $dosen->jenis_kelamin ?>">

                                        </div>
                                       
                                    </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email" class=" control-label">Email</label>
                                        <div class="col-sm-12">
                                            <input type="email" class="form-control" id="email-dosen" name="email" placeholder="Email Dosen" value="<?= $dosen->email ?>">
                                            <input type="hidden" name="nip" value="<?= $dosen->nip ?>">
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
                                            <textarea class="form-control" id="alamat-dosen" name="alamat" placeholder="Alamat Dosen"><?= $dosen->alamat ?></textarea>

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
                                <div class="tab-pane" id="hindex">
                                    <?php if ($hindex_ketua != null) : ?>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label for="NIP" class="control-label">Hindex Scopus</label>
                                                    <input type="NIP" class="form-control" id="NIP-dosen" placeholder="NIP Dosen" value="<?= $hindex_ketua[0]->h_index_scopus; ?>" readonly>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="NIP" class="control-label">Hindex Schoolar</label>
                                                    <input type="NIP" class="form-control" id="NIP-dosen" placeholder="NIP Dosen" value="<?= $hindex_ketua[0]->h_index_schoolar; ?>" readonly>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
 
                                                <div class="col-sm-5">
                                                    <label for="NIDN" class="control-label">Maks. Pengajuan Sebagai Penelitian</label>
                                                    <input type="NIDN" class="form-control" id="NIDN-dosen" placeholder="NIDN Dosen" value="<?= $hindex_ketua[0]->limit_penelitian; ?> Kali" readonly>
                                                </div>
                                                <div class="col-sm-5">
                                                    <label for="NIDN" class="control-label">Maks. Pengajuan Sebagai Pengabdian</label>
                                                    <input type="NIDN" class="form-control" id="NIDN-dosen" placeholder="NIDN Dosen" value="<?= $hindex_ketua[0]->limit_pengabdian; ?> Kali" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div>
                                            <h5 style="color: red;">Dosen Belum diberi Limit</h5>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="tab-pane" id="histori">
                                    <div class="col-12 mb-3">
                                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item"><a class="nav-link tablur active" data-status="0" href="#">PNBP</a></li>
                                                <li class="nav-item"><a class="nav-link tablur" data-status="1" href="#">Mandiri</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <input type="hidden" name="nip" value="<?= $id; ?>">
                                    <h5 class="text-center">Riwayat Pengajuan PNBP</h5>
                                    <div class="table-responsive text-nowrap">
                                        <table id="historitb" class="table table-bordered table-striped" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="col-auto">Dibuat</th>
                                                    <th scope="col" class="col-md-auto">Judul</th>
                                                    <th scope="col" class="col-md-auto">Tema</th>
                                                    <th scope="col" class="col-auto">Tahun Pengajuan</th>
                                                    <th scope="col" class="col-md-auto">Jenis</th>
                                                    <th scope="col" class="col-md-auto">Status</th>
                                                    <th scope="col" class="col-md-auto">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="isi_histori">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script type="text/javascript" src="<?= base_url() . JS_UMUM . 'master_detail_user.js?' . 'random=' . uniqid() ?>"></script>
<script>
    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>