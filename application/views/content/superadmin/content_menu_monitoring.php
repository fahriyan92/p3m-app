<link rel="stylesheet" href="<?= base_url("assets") ?>/plugins/fullcalendar/main.min.css">
<link rel="stylesheet" href="<?= base_url("assets") ?>/plugins/fullcalendar-daygrid/main.min.css">
<link rel="stylesheet" href="<?= base_url("assets") ?>/plugins/fullcalendar-timegrid/main.min.css">
<link rel="stylesheet" href="<?= base_url("assets") ?>/plugins/fullcalendar-bootstrap/main.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">P3M POLIJE</h1>
                    <h1 class="m-0 text-dark">Login Sebagai <?= $role ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Monitoring</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <!-- /.col -->
                <?php if ($this->session->userdata('job') == "dosen") : ?>

                <?php else : ?>

                <?php endif; ?>
                <!-- /.col -->
                <?php if ($this->session->userdata('job') == "dosen") : ?>

                <?php endif; ?>


                <!-- /.col -->

                <!-- /.col -->
                <?php
                /*
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <a href="#">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-edit"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text text-dark">Penelitian Teknisi</span>
                </div>
              </div>
            </a>
          </div>
          */
                ?>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="container-fluid notif-permintaan" style="display: none;">
                <!-- /.card -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Permintaan sebagai anggota PNBP</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="45%">Judul Proposal</th>
                                                <th width="45%">Lihat Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody class="isi-permintaan">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <!-- /.card -->
            <?php if ($mandiri != 0) : ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Permintaan Sebagai Anggota Mandiri</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="45%">Judul Proposal</th>
                                                <th width="45%">Lihat Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($mandiri as $val) : $no = 1; ?>
                                                <tr>
                                                    <td><?= $no; ?>.</td>
                                                    <td class="text-capitalize"><?= $val->judul ?></td>
                                                    <td>
                                                        <a href="<?= site_url('C_dashboard/proposal_mandiri/' . $val->id_proposal) ?>" class="btn btn-xs btn-primary"> <i class="fa fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Informasi Kegiatan</h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="row">

                        <?php if ($this->session->userdata('job') == "plp") : ?>

                        <?php endif; ?>
                        <!--akhir penelitian dosen-->
                        <?php if ($this->session->userdata('job') == "dosen") : ?>
                            <div class="col-md-6 col-sm-12">
                                <h5>Penelitian Dosen</h5>
                                <?php if ($list_event['p_penelitian'] !== null && $this->session->userdata('job') == "dosen") { ?>
                                    <div class="table-responsive">
                                        <table id="example12" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="3%">No</th>
                                                    <th width="40%">Waktu</th>
                                                    <th width="40%">Tahapan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($i = 0; count($list_event['p_penelitian']) - 1 >= $i; $i++) { ?>
                                                    <tr>
                                                        <td><?= $i + 1 ?>.</td>
                                                        <td><?= $list_event['p_penelitian'][$i]->akhir === null ? tanggal_indo($list_event['p_penelitian'][$i]->mulai) : tanggal_indo($list_event['p_penelitian'][$i]->mulai) . ' - ' . tanggal_indo($list_event['p_penelitian'][$i]->akhir) ?></td>
                                                        <td><?= $list_event['p_penelitian'][$i]->tahapan ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="table-responsive">
                                        <div class="callout callout-info">
                                            <h5>Belum ada event</h5>
                                            <p>Belum ada event pnbp penelitian</p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <!--akhir penelitian dosen-->

                            <!--awal pengabdian dosen-->



                            <!--akhir pengabdian dosen-->

                            <!--awal laporan keuangan-->
                            <div class="col-md-6 col-sm-12">
                                <h5>Laporan Biaya Yang Diusulkan</h5>
                                <?php if ($list_event['p_penelitian'] !== null && $this->session->userdata('job') == "dosen") { ?>
                                    <div class="table-responsive">
                                        <table id="example12" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>


                                                    <th width="40%">Tahapan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($i = 0; count($list_event['p_penelitian']) - 1 >= $i; $i++) { ?>
                                                    <tr>


                                                        <td><?= $list_event['p_penelitian'][$i]->tahapan ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="table-responsive">
                                        <div class="callout callout-info">
                                            <h5>Belum ada event</h5>
                                            <p>Belum ada event pnbp penelitian</p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <!--akhir laporan keuangan-->
                        <?php endif; ?>
                    </div>
                </div><!-- /.card-body -->
            </div>
            <!-- ./card -->
        </div>
        <!-- /.col -->
    </section>

    <script>
        $(window).on("load", function() {
            $('#overlay').fadeOut(400);
        });
    </script>