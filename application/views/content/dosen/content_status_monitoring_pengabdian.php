<link rel="stylesheet" href="<?= base_url() . CSS_CUSTOM; ?>form_wizard.css?random=<?= uniqid(); ?>">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet" />
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Monitoring Pengabdian</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Beranda / Monitoring-Pengabdian / MENU MONEV</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <?php $profile_link = base_url('c_settings_user'); ?>
    <section class="content pb-3">
        <?php if ($cek_event === null) : ?>
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Event</h3>
                            </div>
                            <?php if ($cek_tutup === null) : ?>
                                <div class="card-body">
                                    <h5 class="text-left">Mohon maaf, event pengusulan ini belum di buka.</h5>

                                    <?php if ($kelengkapan != "lengkap") : ?>
                                        <div class="mt-3">
                                            <a href="<?= $profile_link ?>" class="btn btn-warning">Data Anda Belum Lengkap, Klik Disini Untuk Melengkapi Data</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else : ?>
                                <div class="card-body">
                                    <h5 class="text-left">Mohon maaf, event pengusulan sudah di tutup.</h5>
                                    <?php if ($kelengkapan != "lengkap") : ?>
                                        <div class="mt-3">
                                            <a href="<?= $profile_link ?>" class="btn btn-warning">Data Anda Belum Lengkap, Klik Disini Untuk Melengkapi Data</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif ?>


                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <?php if ($cek_tutup != null && $cek_event != null) : ?>


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
                                            <th>Diajukan pada</th>
                                            <th>Terakhir Diubah</th>
                                            <th>Status</th>
                                            <th>aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bodynya">
                                        <?php if (!empty($get_proposal)) : ?>
                                            <?php
                                            $tahunnya = "";
                                            $no = 1;
                                            foreach ($get_proposal as $key) : ?>
                                                <tr>
                                                    <?php if ($tahunnya != $key->tahun_usulan) {
                                                        $tahunnya =  $key->tahun_usulan;
                                                        $no = 1;
                                                    }  ?>
                                                    <td><?= $no++ ?>.</td>
                                                    <td><?= $key->judul ?></td>
                                                    <td><?= $key->tahun_usulan ?></td>
                                                    <td><?= $key->created_at ?></td>
                                                    <td>
                                                        <?php if ($key->updated_at != null) : ?>
                                                            <?= $key->updated_at ?>
                                                        <?php else : ?>
                                                            -
                                                        <?php endif ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($key->file_proposal != null && $key->file_proposal != null) : ?>
                                                            <?php if ($key->status_keputusan != null) : ?>
                                                                <?php if ($key->status_keputusan == 3) : ?>

                                                                    Lanjut Ke Tahap Review
                                                                <?php elseif ($key->status_keputusan == 4) : ?>
                                                                    Tidak Lolos Administrasi

                                                                <?php elseif ($key->status_keputusan == 1) : ?>
                                                                    Lolos Pendanaan

                                                                <?php elseif ($key->status_keputusan == 2) : ?>
                                                                    Tidak Lolos Pendanaan

                                                                <?php endif ?>
                                                            <?php else : ?>
                                                                Seleksi Administrasi
                                                            <?php endif ?>
                                                        <?php else : ?>
                                                            Pengajuan Belum selesai
                                                        <?php endif ?>

                                                    </td>
                                                    <td><a href="C_monitoring_pengabdian_dosen/preview/<?= $key->id_pengajuan_detail ?>" class="btn btn-xs btn-warning"><i class="fa fa-fw fa-book"></i></a>
                                                    </td>
                                                </tr>
                                            <?php $no++;
                                            endforeach; ?>
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
    const datatable = $('#tabelproposal').DataTable({
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
    }).datepicker('setDate', "<?= date('Y'); ?>");
    $('#select_tahun').on('change', function() {
        datatable.columns(2).search(this.value).draw();
    });
</script>
<script>
    $(window).on("load", function() {
        let filter_tahun = $('#select_tahun').val();
        datatable.columns(2).search(filter_tahun).draw();
        $('#overlay').fadeOut(400);
    });
</script>