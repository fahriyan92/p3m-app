<link rel="stylesheet" href="<?= base_url() . CSS_CUSTOM; ?>form_wizard.css?random=<?= uniqid(); ?>">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>

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
        <?php if ($cek_event === null) : ?>
            <div class="container-fluid">
                <!-- /.card -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Event</h3>
                            </div>
                            <?php if ($cek_tutup === null) : ?>
                                <div class="card-body">
                                    Mohon maaf, event pengusulan ini belum di buka.
                                </div>
                            <?php else : ?>
                                <div class="card-body">
                                    Mohon maaf, event pengusulan sudah di tutup.

                                </div>
                            <?php endif ?>

                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        <?php endif ?>
        <?php if ($cek_tutup != null && $cek_event != null) : ?>

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
                                    <div class="col-md-3">
                                        <h3 class="card-title float-sm-right">Max Pengajuan : <?= empty($hindex->limit_penelitian) ? '-' : $hindex->limit_penelitian . 'x'; ?></h3>
                                    </div>
                                    <div class="col-md-3">
                                        <h3 class="card-title float-sm-right">H-Index scopus :
                                            <?= empty($hindex->h_index_scopus) ? '-' : $hindex->h_index_scopus; ?></h3>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <table id="example1" align="right" class="table table-bordered table-striped center">
                                        <thead>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Status Pengusulan</td>
                                                <td><?= $status ?></td>
                                            </tr>
                                            <tr>
                                                <td>Status Review</td>
                                                <td>Belum dinilai.</td>
                                            </tr>
                                            <tr>
                                                <td>Batas Tanggal Terakhir</td>
                                                <td><?= tanggal_indo($akhir) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Waktu Yang Tersisa</td>
                                                <td><?= $sisa ?> hari lagi</td>
                                            </tr>
                                            <tr>
                                                <td>Terakhir Diubah</td>
                                                <td><?= $created ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="">

                                            <?php
                                                $pengajuan =  base_url($pengajuan_url);
                                                $edit =  base_url($edit_pengajuan_url);


                                                        // if ($tombol == 0) {
                                                        //     echo ('<a href="' . $pengajuan . '" class="btn btn-primary" >Tambahkan Pengajuan</a>');
                                                        // } else if ($cek_edit == 0) {
                                                        //     echo ('<a href="' . $pengajuan . '" class="btn btn-primary" >Lanjutkan Pengajuan</a>');
                                                        // } else {
                                                        //     if ($sisa > 0) {
                                                        //         echo ('<a href="' . $edit . '" class="btn btn-primary" >Edit Pengajuan</a>');
                                                        //     }
                                                        // }

                                                if ($dah_max_blum != false) {
                                                    if ($cek_event <> null) {
                                                        if ($cek_pengajuan_selesai == 0) {
                                                         echo ('<a href="' . $pengajuan . '" class="btn btn-primary" >Tambahkan Pengajuan</a>');
                                                        }else{
                                                          echo ('<h5 style="color:green">"Silahkan Selesaikan Pengajuan Sebelumnya untuk mengajukan lagi"</h5>');  
                                                        }

 
                                                    }
                                                } else {
                                                    echo ('<h5 style="color:red">"Jumlah Pengajuan Sudah Batas Maksimum"</h5>');
                                                }
                                                ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        <?php endif ?>
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Proposal Anda </h3>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive">
                                <table id="tabelproposal" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Judul</th>
                                            <th>Tahun Usulan</th>
                                            <th>aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bodynya">

                                        <?php if (!empty($get_proposal)) : ?>
                                            <?php 
                                                $no = 1;
                                                foreach ($get_proposal as $key) : ?>
                                                <tr>
                                                    <td><?= $no++ ?>.</td>
                                                    <td><?= $key->judul ?></td>
                                                    <td><?= $key->tahun_usulan ?></td>
                                                    <td><a href="C_penelitian_dsn_pnbp/preview/<?= $key->id_pengajuan_detail ?>" class="btn btn-xs btn-warning"><i class="fa fa-fw fa-book"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php endif ?>

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
    const datatable  = $('#tabelproposal').DataTable({
        "language": {
            "emptyTable": "Tidak Ada Data",
            "infoEmpty": "Tidak Ada Data",
            "zeroRecords": "Tidak Ada Data"
        }
    });
    $("#tabelproposal_filter").append(
          '<label style="padding-left:10px;">Tahun:<input type="text" name="filterTahun" id="select_tahun" class="form-control form-control-sm" placeholder="" aria-controls="tabelevent"></label>'
        );
    $("#select_tahun").datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
    }).datepicker('setDate',"<?= date('Y'); ?>");
    $('#select_tahun').on('change', function () {
            datatable.columns(2).search( this.value ).draw();
        } );
    $(window).on("load", function() {
        let filter_tahun  = $('#select_tahun').val();
        datatable.columns(2).search(filter_tahun).draw();
        $('#overlay').fadeOut(400);
    });
</script>