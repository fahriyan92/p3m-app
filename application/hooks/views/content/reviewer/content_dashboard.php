  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3 class="m-0 text-dark">Review Proposal</h3>
            <h1 class="m-0 text-dark">Login Sebagai <?= $role ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><?= $brdcrmb; ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <!-- Custom Tabs -->

          <div id="tabs">
            <div class="card">
              <div class="tab-pane active" id="tabs-1">
                <div class="card-header d-flex p-0">
                  <h3 class="card-title p-3">Proposal PNBP</h3>
                  <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a class="nav-link active" href="#tab_1" value="1" data-toggle="tab">BELUM DINILAI</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tab_2" value="1" data-toggle="tab">SUDAH DINILAI</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                      <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>Judul Proposal</th>
                              <th>Event</th>
                              <th>Ketua</th>
                              <th>Lihat Detail</th>
                            </tr>
                          </thead>
                          <tbody><?php if ($review['belum'] !== null) : ?>
                              <?php foreach ($review['belum'] as $key) : ?>
                                <tr>
                                  <td><?= $key->judul ?></td>
                                  <td><?= $key->nm_event ?>-<?= $key->nm_pendanaan ?></td>
                                  <td><?= $key->nama ?></td>
                                  <td>
                                    <a href="<?= base_url("C_detail_review/detail/") . $key->id_pengajuan_detail ?>" class="btn btn-danger"> <i class="fa fa-paste"></i></a>
                                  </td>
                                </tr>
                              <?php endforeach ?>
                            <?php else : ?>
                              <tr>
                                <td colspan="4" style="text-align: center;">Data Masih Kosong</td>
                              </tr>
                            <?php endif ?>
                            </tr>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th>Judul Proposal</th>
                              <th>Tema</th>
                              <th>Ketua</th>
                              <th>Lihat Detail</th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                      <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>Judul Proposal</th>
                              <th>Event</th>
                              <th>Ketua</th>
                              <th>Lihat Detail</th>
                            </tr>
                          </thead>
                          <tbody><?php if ($review['sudah'] !== null) : ?>
                              <?php foreach ($review['sudah'] as $key) : ?>
                                <tr>
                                  <td><?= $key->judul ?></td>
                                  <td><?= $key->nm_event ?>-<?= $key->nm_pendanaan ?></td>
                                  <td><?= $key->nama ?></td>
                                  <td>
                                    <a href="<?= base_url("C_detail_review/detail/") . $key->id_pengajuan_detail ?>" class="btn btn-success"> <i class="fa fa-paste"></i></a>
                                  </td>
                                </tr>
                              <?php endforeach ?>
                            <?php else : ?>
                              <tr>
                                <td colspan="4" style="text-align: center;">Data Masih Kosong</td>
                              </tr>
                            <?php endif ?>
                            </tr>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th>Judul Proposal</th>
                              <th>Tema</th>
                              <th>Ketua</th>
                              <th>Lihat Detail</th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- ./card -->
          </div>
          <!-- /.col -->
        </div>

        <?php if ($mandiri != 0) : ?>
          </div>
          <div class="row mt-3">
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
                          <th>Judul Proposal</th>
                          <th>Lihat Detail</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($mandiri as $val) : ?>
                          <tr>
                            <td class="text-capitalize"><?= $val->judul ?></td>
                            <td>
                              <a href="<?= site_url('C_dashboard/proposal_mandiri/' . $val->id_proposal) ?>" class="btn btn-danger"> <i class="fa fa-paste"></i></a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>Judul Proposal</th>
                          <th>Lihat Detail</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>

                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
        <?php endif; ?>        
    </section>
  </div>
  <!-- /.content -->



  <script>
    $('.table-bordered').DataTable();
    $(window).on("load", function() {
      $('#overlay').fadeOut(400);
    });
  </script>