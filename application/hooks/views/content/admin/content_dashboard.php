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
              <li class="breadcrumb-item"><?= $brdcrmb; ?></li>
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
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <a href="<?= base_url("C_event") ?>">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-copy"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text text-dark">Event</span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <a href="<?= base_url("C_reviewer") ?>">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text text-dark">Reviewer</span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.info-box -->
          </div>

          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <a href="#">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text text-dark">Soal Penilaian</span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <a href="#">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-cog"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text text-dark">Pengaturan</span>
                  <span class="info-box-number text-dark">Profil Pengguna</span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->

    <script>
      $(window).on("load", function() {
        $('#overlay').fadeOut(400);
      });
    </script>