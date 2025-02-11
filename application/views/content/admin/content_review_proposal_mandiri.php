  <!-- Content Wrapper. Contains page content -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3 class="m-0 text-dark">Review Pengajuan Proposal Mandiri</h3>
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
          <div class="card">
            <div class="card-header d-flex p-0">
              <h3 class="card-title p-3">List Pengajuan Proposal <span class="titelnya"></span></h3>
              <ul class="nav nav-pills ml-auto p-2">
                <li class="nav-item mr-2" style="width: 130px;" ><input id="select_tahun"  type="text" class="form-control"></li>
                <li class="nav-item"><a class="nav-link active jenisnya" href="#tab_1" data-list="1" data-toggle="tab">Penelitian</a></li>
                <li class="nav-item "><a class="nav-link jenisnya" href="#tab_2" data-list="2">Pengabdian</a></li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle status" data-toggle="dropdown" data-status="0" href="#">
                    Belum Direview <span class="caret"></span>
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item belum" tabindex="-1" href="#" data-status="0">Belum Direview</a>
                    <a class="dropdown-item sudah" tabindex="-1" href="#" data-status="1">Sudah Direview</a>
                  </div>
                </li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive text-nowrap">
                <table id="tabelevent" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th class="text-center"width="3%">No</th>
                      <th class="text-center"width="30%">Judul Proposal</th>
                      <th class="text-center"width="10%">Tahun</th>
                      <th class="text-center"width="30%">Ketua-NIP</th>
                      <th class="text-center"width="10%">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="bodynya">
                  </tbody>
                </table>
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- ./card -->
        </div>
        <!-- /.col -->
      </div>
    </section>
  </div>
  <!-- /.content -->



  <script src="<?= base_url() . JS_ADMIN; ?>list_review_pengajuan_mandiri.js?random=<?= uniqid(); ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
  <script>
    $('.table-bordered').DataTable();
    $("#select_tahun").datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
    }).datepicker('setDate',"<?= date('Y'); ?>");

    $(window).on("load", function() {
      $('#overlay').fadeOut(400);
    });
  </script>