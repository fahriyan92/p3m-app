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
            <div id="tabs">
                <ul class="nav nav-pills" style="text-align:center;">
                    <li class="nav-item" style="width: 33%;"><a href="#tabs-1" class="nav-link active" data-toggle="tab" style="border-color:lightgrey; width:100%;">Penelitian</a></li>
                    <li class="nav-item" style="width: 33%;"><a href="#tabs-2" class="nav-link" data-toggle="tab" style="border-color:lightgrey; width:100%;">Pengabdian</a></li>
                    <li class="nav-item" style="width: 33%;"><a href="#tabs-3" class="nav-link" data-toggle="tab" style="border-color:lightgrey; width:100%;">Penelitian-PLP</a></li>
                </ul>
                <div class="tab-pane active" id="tabs-1">
                    <div class="card-header p-2">
                        <div class="row">
                            <div class="col-lg-9 col-md-8 col-sm-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Data Kriteria</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#jangket" data-toggle="tab">Jenis Kriteria</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-1" style="text-align: right;">
                                <ul class="navbar-nav ml-auto">
                                    <!-- Notifications Dropdown Menu -->
                                    <li class="nav-item dropdown ">
                                        <a href="" class="btn btn-primary" data-toggle="dropdown" style="color: white;"> Tambah</a>
                                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                            <div class="dropdown-notif">
                                                <a href="#" class="dropdown-item dropdown-footer" data-toggle="modal" data-target="#modal-tambah-soal"><i class="fa fa-plus"></i> Data Kriteria</a>
                                                <a href="#" class="dropdown-item dropdown-footer" data-toggle="modal" data-target="#modal-tambah-jnsSoal"><i class="fa fa-plus"></i> Data Jenis Kriteria</a>
                                            </div>

                                            <div class="dropdown-divider"></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- /.card-header -->
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="table-responsive">
                                    <table id="tabelevent" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="10%">No</th>
                                                <th width="65%">Isi Kriteria</th>
                                                <th width="15%">Jenis</th>
                                                <th width="10%">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bodynya">
                                            <?php $no = 1;
                                            if ($soal != null) :
                                                foreach ($soal as $key) : ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td>
                                                            <?= $key->soal; ?> <a href="<?= base_url('C_penilai/editSoal/') . $key->id_soal; ?>" id="editSoal" class="btn btn-alert"><i class="fas fa-fw fa-edit"></i></a>
                                                        </td>
                                                        <td><?= $key->nm_jenis_soal; ?></td>
                                                        <td><a href="<?= base_url('C_penilai/dtlSoal/') . $key->id_soal; ?>" id="dtlSoal" class="btn btn-primary"><i class="fas fa-fw fa-eye"></i></a></td>
                                                    </tr>
                                                <?php $no++;
                                                endforeach;
                                            else : ?>
                                                <tr>
                                                    <td colspan="4" style="text-align:center;">Data Kosong</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="jangket">
                                <div class="table-responsive">
                                    <table id="tabelevent1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="10%">No</th>
                                                <th width="70%">Jenis Angket</th>
                                                <th width="5%">Bobot</th>
                                                <!-- <th width="5%">Status</th> -->
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bodynya1">
                                            <?php $no = 1;
                                            if ($jns != null) :
                                                foreach ($jns as $key) : ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $key->nm_jenis_soal; ?></td>
                                                        <td><?= $key->bobot; ?></td>
                                                        <!-- <td><button class="btn btn-success">Aktif</button></td> -->
                                                        <td><a href="<?= base_url('C_penilai/editJnsSoal/') . $key->id_jenis_soal; ?>" id="editJnsSoal" class="btn btn-primary"><i class="fas fa-fw fa-edit"></i></a></td>
                                                    </tr>
                                                <?php $no++;
                                                endforeach;
                                            else : ?>
                                                <tr>
                                                    <td colspan="4" style="text-align:center;">Data Kosong</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tabs-2">
                    <div class="card-header p-2">
                        <div class="row">
                            <div class="col-lg-9 col-md-8 col-sm-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#tab_3" data-toggle="tab">Data Kriteria</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#jangket2" data-toggle="tab">Jenis Kriteria</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-1" style="text-align: right;">
                                <ul class="navbar-nav ml-auto">
                                    <!-- Notifications Dropdown Menu -->
                                    <li class="nav-item dropdown ">
                                        <a href="" class="btn btn-primary" data-toggle="dropdown" style="color: white;"> Tambah</a>
                                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                            <div class="dropdown-notif dropdown-pengabdian">
                                                <a href="#" class="dropdown-item dropdown-footer" data-toggle="modal" data-target="#modal-tambah-soal2"><i class="fa fa-plus"></i> Data Kriteria</a>
                                                <a href="#" class="dropdown-item dropdown-footer" data-toggle="modal" data-target="#modal-tambah-jnsSoal2"><i class="fa fa-plus"></i> Data Jenis Kriteria</a>
                                            </div>
                                            <div class="dropdown-divider"></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- /.card-header -->
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_3">
                                <div class="table-responsive">
                                    <table id="tabelevent2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="10%">No</th>
                                                <th width="65%">Isi Kriteria</th>
                                                <th width="15%">Jenis</th>
                                                <th width="10%">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bodynya">
                                            <?php $no = 1;
                                            if ($soal2 != null) :
                                                foreach ($soal2 as $key) : ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td>
                                                            <?= $key->soal; ?> <a href="<?= base_url('C_penilai/editSoal/') . $key->id_soal; ?>" id="editSoal" class="btn btn-alert"><i class="fas fa-fw fa-edit"></i></a>
                                                        </td>
                                                        <td><?= $key->nm_jenis_soal; ?></td>
                                                        <td><a href="<?= base_url('C_penilai/dtlSoal/') . $key->id_soal; ?>" id="dtlSoal" class="btn btn-primary"><i class="fas fa-fw fa-eye"></i></a></td>
                                                    </tr>
                                                <?php
                                                endforeach;
                                            else : ?>
                                                <tr>
                                                    <td colspan="4" style="text-align:center;">Data Kosong</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="jangket2">
                                <div class="table-responsive">
                                    <table id="tabelevent3" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="10%">No</th>
                                                <th width="70%">Jenis Kriteria</th>
                                                <th width="5%">Bobot</th>
                                                <!-- <th width="5%">Status</th> -->
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bodynya1">
                                            <?php $no = 1;
                                            if ($jns2 != null) :
                                                foreach ($jns2 as $key) : ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= $key->nm_jenis_soal; ?></td>
                                                        <td><?= $key->bobot; ?></td>
                                                        <!-- <td><button class="btn btn-success">Aktif</button></td> -->
                                                        <td><a href="<?= base_url('C_penilai/editJnsSoal/') . $key->id_jenis_soal; ?>" id="editJnsSoal" class="btn btn-primary"><i class="fas fa-fw fa-edit"></i></a></td>
                                                    </tr>
                                                <?php
                                                endforeach;
                                            else : ?>
                                                <tr>
                                                    <td colspan="4" style="text-align:center;">Data Kosong</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane active" id="tabs-3">
                    <div class="card-header p-2">
                        <div class="row">
                            <div class="col-lg-9 col-md-8 col-sm-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#tab_5" data-toggle="tab">Data Kriteria</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#jangket3" data-toggle="tab">Jenis Kriteria</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-1" style="text-align: right;">
                                <ul class="navbar-nav ml-auto">
                                    <!-- Notifications Dropdown Menu -->
                                    <li class="nav-item dropdown ">
                                        <a href="" class="btn btn-primary" data-toggle="dropdown" style="color: white;"> Tambah</a>
                                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                            <div class="dropdown-notif">
                                                <a href="#" class="dropdown-item dropdown-footer" data-toggle="modal" data-target="#modal-tambah-soal3"><i class="fa fa-plus"></i> Data Kriteria</a>
                                                <a href="#" class="dropdown-item dropdown-footer" data-toggle="modal" data-target="#modal-tambah-jnsSoal3"><i class="fa fa-plus"></i> Data Jenis Kriteria</a>
                                            </div>

                                            <div class="dropdown-divider"></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- /.card-header -->
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_5">
                                <div class="table-responsive">
                                    <table id="tabelevent" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="10%">No</th>
                                                <th width="65%">Isi Kriteria</th>
                                                <th width="15%">Jenis</th>
                                                <th width="10%">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bodynya">
                                            <?php $no = 1;
                                            if ($soal3 != null) :
                                                foreach ($soal3 as $key) : ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td>
                                                            <?= $key->soal; ?> <a href="<?= base_url('C_penilai/editSoal/') . $key->id_soal; ?>" id="editSoal" class="btn btn-alert"><i class="fas fa-fw fa-edit"></i></a>
                                                        </td>
                                                        <td><?= $key->nm_jenis_soal; ?></td>
                                                        <td><a href="<?= base_url('C_penilai/dtlSoal/') . $key->id_soal; ?>" id="dtlSoal" class="btn btn-primary"><i class="fas fa-fw fa-eye"></i></a></td>
                                                    </tr>
                                                <?php $no++;
                                                endforeach;
                                            else : ?>
                                                <tr>
                                                    <td colspan="4" style="text-align:center;">Data Kosong</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="jangket3">
                                <div class="table-responsive">
                                    <table id="tabelevent1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="10%">No</th>
                                                <th width="70%">Jenis Angket</th>
                                                <th width="5%">Bobot</th>
                                                <!-- <th width="5%">Status</th> -->
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bodynya1">
                                            <?php $no = 1;
                                            if ($jns3 != null) :
                                                foreach ($jns3 as $key) : ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $key->nm_jenis_soal; ?></td>
                                                        <td><?= $key->bobot; ?></td>
                                                        <!-- <td><button class="btn btn-success">Aktif</button></td> -->
                                                        <td><a href="<?= base_url('C_penilai/editJnsSoal/') . $key->id_jenis_soal; ?>" id="editJnsSoal" class="btn btn-primary"><i class="fas fa-fw fa-edit"></i></a></td>
                                                    </tr>
                                                <?php $no++;
                                                endforeach;
                                            else : ?>
                                                <tr>
                                                    <td colspan="4" style="text-align:center;">Data Kosong</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>


<div class="modal fade" id="modal-tambah-soal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="">

                <div class="modal-header">
                    <h4 class="modal-title">Tambah Soal Kriteria Penelitian</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="soalangket">Jenis Soal Kriteria</label>
                                <select class="form-control select2" style="width: 100%;" name="jnsSoal" id="jnsSoal" required>
                                    <option value="">-Pilih Jenis-</option>
                                    <?php foreach ($jns as $key) {
                                        echo "<option value='" . $key->id_jenis_soal . "'>" . $key->nm_jenis_soal . "</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="err-jnskrt" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="soalangket">Soal Kriteria</label>
                                <textarea class="form-control" id="soal" name="soal" value="" required></textarea>
                            </div>
                            <div class="err-kriteria" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pilihanpne1">Pilihan Ganda 1</label>
                                <input type="text" class="form-control" id="pilihanpne1" placeholder="Pilihan Ganda" name="pilihanpne[]" value="" required>
                            </div>
                            <div class="err-pilihan" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="bobotpne1">Bobot 1</label>
                                <input type="number" class="form-control" id="bobotpne1" placeholder="Bobot" name="bobotpne[]" value="" required>
                            </div>
                            <div class="err-pilihan" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-2" style="margin-top: 31px;">
                            <input type="button" id="addpilihan1" class="btn btn-success" value="+">
                            <input type="button" id="removepilihan1" class="btn btn-danger" value="x">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pilihanpne2">Pilihan Ganda 2</label>
                                <input type="text" class="form-control" id="pilihanpne2" placeholder="Pilihan Ganda" name="pilihanpne[]" value="" required>
                            </div>
                            <div class="err-pilgan2" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="bobotpne2">Bobot 2</label>
                                <input type="number" class="form-control" id="bobotpne2" placeholder="Bobot" name="bobotpne[]" value="" required>
                            </div>
                            <div class="err-pilihan" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                    <div class="append-group1"></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a type="button" href="#" id="simpan-soal" class="btn btn-primary">Simpan</a>
                </div>

            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade" id="modal-tambah-jnsSoal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="">

                <div class="modal-header">
                    <h4 class="modal-title">Tambah Jenis Soal Kriteria Penelitian</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="soalangket">Jenis Soal Kriteria</label>
                                <input type="text" class="form-control" id="jns" placeholder="Jenis Soal Kriteria" name="jns" value="" required>
                            </div>
                            <div class="err-jnskrtS" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="bobotjns">Bobot</label>
                                <input type="number" class="form-control" id="bobotjns" name="bobotjns" value="" required></input>
                            </div>
                            <div class="err-bobotjns" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" id="simpan-jns-kriteria" class="btn btn-primary" value="Simpan">
                </div>

            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-tambah-jnsSoal3">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="">

                <div class="modal-header">
                    <h4 class="modal-title">Tambah Jenis Soal Kriteria Penelitian PLP</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="soalangket">Jenis Soal Kriteria</label>
                                <input type="text" class="form-control" id="jnsplp" placeholder="Jenis Soal Kriteria" name="jnsplp" value="" required>
                            </div>
                            <div class="err-jnskrtS" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="bobotjnsplp">Bobot</label>
                                <input type="number" class="form-control" id="bobotjnsplp" name="bobotjnsplp" value="" required></input>
                            </div>
                            <div class="err-bobotjnsplp" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" id="simpan-jenis-kriteriaplp" class="btn btn-primary" value="Simpan">
                </div>

            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="modal-tambah-soal2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="">

                <div class="modal-header">
                    <h4 class="modal-title">Tambah Soal Kriteria Pengabdian</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="soalangket">Jenis Soal Kriteria</label>
                                <select class="form-control select2" style="width: 100%;" name="jnsSoal" id="jnsSoalpge" required>
                                    <option value="">-Pilih Jenis-</option>
                                    <?php foreach ($jns2 as $key) {
                                        echo "<option value='" . $key->id_jenis_soal . "'>" . $key->nm_jenis_soal . "</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="err-jnskrt" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="soalangket">Soal Kriteria</label>
                                <textarea class="form-control" id="soalpge" name="soal" value="" required></textarea>
                            </div>
                            <div class="err-kriteria" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pilihan1">Pilihan Ganda 1</label>
                                <input type="text" class="form-control" id="pilihan1" placeholder="Pilihan Ganda" name="pilihanpge[]" value="" required>
                            </div>
                            <div class="err-pilgan1" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="bobot1">Bobot 1</label>
                                <input type="number" class="form-control" id="bobot1" placeholder="Bobot" name="bobotpge[]" value="" required>
                            </div>
                            <div class="err-pilihanpge" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="prosentase1">Prosentase 1</label>
                                <input type="number" class="form-control" id="prosentase1" placeholder="Prosentase(%)" name="prosentase[]" value="">
                            </div>
                        </div>
                        <div class="col-sm-2" style="margin-top: 31px;">
                            <input type="button" id="addpilihan" class="btn btn-success" value="+">
                            <input type="button" id="removepilihan" class="btn btn-danger" value="x">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pilihan2">Pilihan Ganda 2</label>
                                <input type="text" class="form-control" id="pilihan2" placeholder="Pilihan Ganda" name="pilihanpge[]" value="" required>
                            </div>
                            <div class="err-pilgan2" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="bobot2">Bobot 2</label>
                                <input type="number" class="form-control" id="bobot2" placeholder="Bobot" name="bobotpge[]" value="" required>
                            </div>
                            <div class="err-pilihanpge" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="prosentase2">Prosentase 2</label>
                                <input type="number" class="form-control" id="prosentase2" placeholder="Prosentase(%)" name="prosentase[]" value="">
                            </div>
                        </div>
                    </div>
                    <div class="append-group2"></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" id="simpan-soalpge" value="Simpan">
                </div>

            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-tambah-soal3">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="">

                <div class="modal-header">
                    <h4 class="modal-title">Tambah Soal Kriteria Penelitian PLP</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="soalangket">Jenis Soal Kriteria</label>
                                <select class="form-control select2" style="width: 100%;" name="jnsSoal" id="jnsSoalplp" required>
                                    <option value="">-Pilih Jenis-</option>
                                    <?php foreach ($jns3 as $key) {
                                        echo "<option value='" . $key->id_jenis_soal . "'>" . $key->nm_jenis_soal . "</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="err-jnskrt" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="soalangket">Soal Kriteria</label>
                                <textarea class="form-control" id="soalplp" name="soal" value="" required></textarea>
                            </div>
                            <div class="err-kriteria" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pilihan1">Pilihan Ganda 1</label>
                                <input type="text" class="form-control" id="pilihanplp1" placeholder="Pilihan Ganda" name="pilihanplp[]" value="" required>
                            </div>
                            <div class="err-pilgan1" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="bobot1">Bobot 1</label>
                                <input type="number" class="form-control" id="bobotplp1" placeholder="Bobot" name="bobotplp[]" value="" required>
                            </div>
                            <div class="err-pilihanplp" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="prosentase1">Prosentase 1</label>
                                <input type="number" class="form-control" id="prosentaseplp1" placeholder="Prosentase(%)" name="prosentaseplp[]" value="">
                            </div>
                        </div>
                        <div class="col-sm-2" style="margin-top: 31px;">
                            <input type="button" id="addpilihanplp" class="btn btn-success" value="+">
                            <input type="button" id="removepilihanplp" class="btn btn-danger" value="x">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pilihanplp2">Pilihan Ganda 2</label>
                                <input type="text" class="form-control" id="pilihanplp2" placeholder="Pilihan Ganda" name="pilihanplp[]" value="" required>
                            </div>
                            <div class="err-pilgan2" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="bobot2">Bobot 2</label>
                                <input type="number" class="form-control" id="bobotplp2" placeholder="Bobot" name="bobotplp[]" value="" required>
                            </div>
                            <div class="err-pilihanplp" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="prosentase2">Prosentase 2</label>
                                <input type="number" class="form-control" id="prosentaseplp2" placeholder="Prosentase(%)" name="prosentaseplp[]" value="">
                            </div>
                        </div>
                    </div>
                    <div class="append-group3"></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" id="simpan-soalplp" value="Simpan">
                </div>

            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade" id="modal-tambah-jnsSoal2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="">

                <div class="modal-header">
                    <h4 class="modal-title">Tambah Jenis Soal Kriteria Pengabdian</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="soalangket">Jenis Soal Kriteria Pengabdian</label>
                                <input type="text" class="form-control" id="jnspge" placeholder="Pilihan Ganda" name="jns" value="" required>
                            </div>
                            <div class="err-jnskriteriaS" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="bobotjns">Bobot</label>
                                <input class="form-control" id="bobotjnspge" name="bobotjns" value="" required></input>
                            </div>
                            <div class="err-bobotjnspge" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" id="simpan-jenis-kriteriapge" value="Simpan">
                </div>

            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script type="text/javascript" src="<?= base_url() . JS_UMUM . 'form_soal.js?' . 'random=' . uniqid() ?> "></script>

<script>
    $('#tabelevent1').DataTable();
    $('#tabelevent2').DataTable();
    $('#tabelevent3').DataTable();
    $('#tabelevent').DataTable();
    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>