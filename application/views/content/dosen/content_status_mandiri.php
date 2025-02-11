<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url() . CSS_CUSTOM; ?>form_wizard.css?random=<?= uniqid(); ?>">
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
    <section class="content pb-3">
        <div class="container-fluid">
            <!-- /.card -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">

                                    <h3 class="card-title">Status Pengusulan</h3>
                                </div>


                            </div>
                        </div>
                        <div class="card-body">

                            <?php if ($informasi['status'] == 8) : ?>
                                <?php if ($informasi['status_koreksi'] == 0 || $informasi['status_koreksi'] == 2) : ?>
                                    <div class="row">
                                        <table id="example1" align="right" class="table table-bordered center">
                                            <thead>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Status Pengusulan</td>
                                                    <td><b>Menunggu Respon Admin</b></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="">
                                                <!-- <a href="#" class="btn btn-danger">Batalkan Pengajuan</a> -->
                                            </div>
                                        </div>
                                    </div>

                                <?php endif; ?>

                                <?php if ($informasi['status_koreksi'] == 2) : ?>



                                <?php endif; ?>


                            <?php else : ?>
                                <?php if ($informasi['status'] == 7 && $informasi['status_koreksi'] == 2) : ?>

                                    <div class="row">
                                        <table id="example1" align="right" class="table table-bordered center">
                                            <thead>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Status Pengusulan</td>
                                                    <td><b>Pengajuan Anda Mendapat Revisi</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="">
                                                <a href="<?= site_url('C_penelitian_dsn_mandiri/mandiri_pengajuan_penelitian') ?>" class="btn btn-warning">Revisi Pengajuan</a>
                                            </div>
                                        </div>
                                    </div>


                                <?php else :  ?>
                                    <div class="row">
                                        <table id="example1" align="right" class="table table-bordered center">
                                            <thead>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Status Pengusulan</td>
                                                    <td>
                                                        <?= $informasi['status_pengusulan'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Buat</td>
                                                    <td>
                                                        <?= $informasi['create'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Terakhir Diubah</td>
                                                    <td>
                                                        <?= $informasi['update'] ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="">
                                                <a href="<?= site_url('C_penelitian_dsn_mandiri/mandiri_pengajuan_penelitian') ?>" class="btn btn-primary"><?= $informasi['tombol'] == 0 ? 'Tambahkan Pengajuan' : 'Edit/Finalinasi Pengajuan' ?></a>
                                            </div>
                                        </div>
                                    </div>

                                <?php endif; ?>



                            <?php endif; ?>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">Proposal Anda</h3>
                        </div>
                        <div class="col-md-6">
                            <input style="width:150px; float:right; padding-top:5px;" id="filterTahun" type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive">
                                <table id="tabelproposal" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="20%">Judul</th>
                                            <th width="20%">Tahun Usulan</th>
                                            <th width="20%">Status</th>
                                            <th width="20%">Lihat</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bodynya">
                                        <?php if ($get_proposal == null) : ?>
                                            <tr>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                            </tr>

                                        <?php else :  ?>
                                            <?php foreach ($get_proposal as $pro) : $no=1; ?>
                                                <tr>
                                                    <td><?= $no; ?>.</td>
                                                    <td><?= $pro->judul ?></td>
                                                    <td><?= $pro->tahun ?></td>
                                                    <td><?= $pro->status_koreksi == 0 ? 'Belum Direspon'  : 'Pengajuan Diterima' ?></td>

                                                    <td>
                                                        <a href="<?= site_url('C_penelitian_dsn_mandiri/view_pengajuan/') . $pro->id_detail ?>" class="btn btn-xs btn-danger"> <i class="fa fa-paste"></i></a>
                                                    </td>
                                                </tr>
                                                <?php $no++; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>


                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

<script>
    const datatable = $('#tabelproposal').DataTable({
        "language": {
            "emptyTable": "Belum Ada Data Proposal",
            "infoEmpty": "Belum Ada Data Proposal",
            "zeroRecords": "Belum Ada Data Proposal"
        }
    });

    $("#filterTahun").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
    }).datepicker("setDate", "<?= date('Y'); ?>");

    $('#filterTahun').on('change', function() {
        datatable.columns(2).search(this.value).draw();
    });

    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
        let filter_tahun = $('#filterTahun').val();
        datatable.columns(2).search(filter_tahun).draw();
    });
</script>