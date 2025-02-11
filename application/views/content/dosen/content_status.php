<link rel="stylesheet" href="<?= base_url() . CSS_CUSTOM; ?>form_wizard.css?random=<?= uniqid(); ?>">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"
    rel="stylesheet" />

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <?= $judul; ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <?= $brdcrmb; ?>
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <?php  $profile_link = base_url('c_settings_user'); ?>
    <section class="content pb-3">
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
                                    <h3 class="card-title float-sm-right">Kuota Pengajuan di penelitian : <?=
                                            empty($hindex->limit_penelitian) ? '-' : $hindex->limit_penelitian . 'x'; ?>
                                    </h3>
                                </div>
                                <div class="col-md-3">
                                    <h3 class="card-title float-sm-right">H-Index Scopus :
                                        <?= empty($hindex->h_index_scopus) ? '-' : $hindex->h_index_scopus; ?>
                                    </h3>
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
                                            <td>
                                                <?= $status ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Status Review</td>
                                            <td>Belum dinilai.</td>
                                        </tr>
                                        <tr>
                                            <td>Batas Tanggal Terakhir</td>
                                            <td>
                                                <?= tanggal_indo($akhir) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Waktu Yang Tersisa</td>
                                            <td style="color:red;">
                                                <?php
                                                if($sisa == 0 ){
                                                    echo "Hari ini Terakhir";
                                                }else{
                                                    echo $sisa. " Hari Lagi ";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php /*
                                            <tr>
                                                <td>Terakhir Diubah</td>
                                                <td><?= $created ?></td>
                                            </tr>
                                            */?>
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
                                                if($kelengkapan == "lengkap"){
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
                                                } else {
                                                    $profile_link = base_url('c_settings_user');
                                                    echo('<a href="' . $profile_link . '" class="btn btn-warning" >Data Anda Belum Lengkap, Klik Disini Untuk Melengkapi Data</a>');
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
        <?php if ($cek_tutup_evaluasi != null && $cek_event_evaluasi != null) : ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Event Evaluasi</h3>
                        </div>
                        <div class="card-body">
                            <h4 class="text-center mb-4">Hanya Ketua Tim yang Dapat Mengisi Formulir Evaluasi</h4>
                            <table id="example1" align="right" class="table table-bordered table-striped center">
                                <thead>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Batas Tanggal Terakhir</td>
                                        <td>
                                            <?= tanggal_indo($akhir_evaluasi) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Waktu Yang Tersisa</td>
                                        <td style="color:red;">
                                            <?php
                                                if($sisa_evaluasi == 0 ){
                                                    echo "Hari ini Terakhir";
                                                }else{
                                                    echo $sisa_evaluasi. " Hari Lagi ";
                                                }
                                                ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <a href="<?= base_url() ?>assets/berkas/Panduan-Evaluasi.pptx" target="_blank"" target="_blank"><button style="width: 100%; margin-bottom: 1rem; margin-top: -1rem;" class="btn btn-primary">Unduh Panduan Mengisi Form Evaluasi</button></a>
                </div>
            </div>
        </div>
        <?php endif; ?>
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

                                        <?php 
                                        // echo '<pre>';
                                        // print_r($get_proposal);
                                        // echo '</pre>';

                                        if (!empty($get_proposal)) : ?>
                                        <?php 
                                                $tahunnya = "";
                                                $no = 1;
                                                foreach ($get_proposal as $key) : ?>
                                        <tr>
                                            <?php if($tahunnya != $key->tahun_usulan) {$tahunnya =  $key->tahun_usulan;$no = 1;}  ?>
                                            <td>
                                                <?= $no; ?>.
                                            </td>
                                            <td>
                                                <?= $key->judul ?>
                                            </td>
                                            <td>
                                                <?= $key->tahun_usulan ?>
                                            </td>
                                            <td>
                                                <?= $key->created_at ?>
                                            </td>
                                            <td>
                                                <?php if ($key->updated_at != null ) : ?>
                                                <?= $key->updated_at ?>
                                                    <?php else :?>
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

                                                <?php elseif ($key->status_keputusan == 5) : ?>
                                                Tidak Lolos Review

                                                <?php elseif ($key->status_keputusan == 6) : ?>
                                                Lanjut ke Tahap Monev

                                                <?php elseif ($key->status_keputusan == 7) : ?>
                                                Lolos Monev

                                                <?php elseif ($key->status_keputusan == 8) : ?>
                                                Tidak Lolos Monev

                                                <?php endif ?>
                                                <?php else :?>
                                                Seleksi Administrasi
                                                <?php endif ?>
                                                <?php else :?>
                                                Pengajuan Belum selesai
                                                <?php endif ?>

                                            </td>
                                            <td><a href="C_penelitian_dsn_pnbp/preview/<?= $key->id_pengajuan_detail ?>"
                                                    class="btn btn-xs btn-warning"><i class="fa fa-fw fa-book"></i></a>
                                            </td>
                                        </tr>
                                        <?php $no++; endforeach; ?>
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
    $('#select_tahun').on('change', function () {
        datatable.columns(2).search(this.value).draw();
    });
    $(window).on("load", function () {
        let filter_tahun = $('#select_tahun').val();
        datatable.columns(2).search(filter_tahun).draw();
        $('#overlay').fadeOut(400);
    });
</script>