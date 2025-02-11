  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
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
          <div class="div col-12">
            <?php if ($this->session->flashdata('key')) : ?>
              <div class="alert alert-<?= $this->session->flashdata('key') ?> alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata($this->session->flashdata('key')); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <a href="<?= base_url("pengajuan_mandiri_pengabdian/identitas_usulan") ?>">
              <div class="info-box" style="position:relative;">
                <?php if ($status > 0 && $status < 8) : ?>
                  <div class="" style="position: absolute;bottom: 0px;right: 5px;">
                    <span style="font-size:30px;"><i class="fa fa-check-circle"></i></span>
                  </div>
                <?php endif; ?>
                <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-book"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text text-dark">1. Identitas Usulan</span>
                  <span class="info-box-number text-dark"><?= $status > 0 && $status < 8 ? "Edit Identitas Usulan" : "Tambahkan Identitas Usulan" ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.info-box -->
          </div>

          <!-- /.col -->
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <?php
            $anggota = '#';
            if ($status > 0) {
              $anggota = site_url('pengajuan_mandiri_pengabdian/anggota_dosen_revisi');
            }
            ?>
            <a <?= $status > 0 ? "href='" . $anggota . "'" : "" ?>>
              <div class="info-box" style="position:relative;">
                  <?php if ($status > 1 && !isset($stat_anggota) ) : ?>
                    <div class="" style="position: absolute;bottom: 0px;right: 5px;">
                      <span style="font-size:30px;"><i class="fa fa-hourglass-half"></i></span>
                    </div>
                  <?php endif; ?>
                <?php if ($status > 2 && isset($stat_anggota)) : ?>
                  <div class="" style="position: absolute;bottom: 0px;right: 5px;">
                    <span style="font-size:30px;"><i class="fa fa-check-circle"></i></span>
                  </div>
                <?php endif; ?>
                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-user-plus"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text text-dark">2. Anggota Dosen</span>
                  <span class="info-box-number text-dark"><?= $status >= 1 && $status < 8 ? $status >= 2 && $status < 8 ? "Edit Dosen" : "Tambahkan Dosen" : "" ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.info-box -->
          </div>

          <!-- /.col -->
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <?php $mhs = site_url('pengajuan_mandiri_pengabdian/anggota_mahasiswa'); ?>
            <a <?= $status > 2 && $status < 8 ? "href='" . $mhs . "'" : "" ?>>
              <div class="info-box" style="position:relative;">
                <?php if ($status > 5 && $status < 8) : ?>
                  <div class="" style="position: absolute;bottom: 0px;right: 5px;">
                    <span style="font-size:30px;"><i class="fa fa-check-circle"></i></span>
                  </div>
                <?php endif; ?>
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text text-dark">3. Anggota Mahasiswa</span>
                  <span class="info-box-number text-dark"><?= $status > 2 && $status < 8 ? $status > 5 && $status < 8 ? "Edit Mahasiswa" : "Tambahkan Mahasiswa" : "" ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.info-box -->
          </div>


          <!-- /.col -->
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <?php $unggah = site_url('pengajuan_mandiri_pengabdian/unggah_berkas'); ?>
            <a <?= $status > 5 && $status < 8 ? "href='" . $unggah . "'" : "" ?>>
              <div class="info-box" style="position:relative;">
                <?php if ($status > 6) : ?>
                  <div class="" style="position: absolute;bottom: 0px;right: 5px;">
                    <span style="font-size:30px;"><i class="fa fa-check-circle"></i></span>
                  </div>
                <?php endif; ?>
                <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-file"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text text-dark">4. Unggah Berkas</span>
                  <span class="info-box-number text-dark"><?= $status > 5 && $status < 8 ? $status > 6 && $status < 8 ? "Edit Berkas" : "Tambahkan Berkas" : "" ?></span>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
      <!-- /.col -->

      <?php if (isset($status)) : ?>
        <?php if ($status == 7 && isset($stat_anggota)) : ?>
          <div class="col-lg-12">
            <div class="card card-default">
              <div class="card-body">
                <form action="<?= site_url('C_pengabdian_dsn_mandiri/finalkan') ?>" method="post">
                  <div style="text-align: center; width: 70%; margin: 0 auto;">
                    <button type="submit" style="width: inherit;" class="btn btn-danger">Finalkan Pengusulan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        <?php endif; ?>
      <?php endif; ?>

      <?php if($komentar !== null): ?>
      <div class="col-lg-12">
            <div class="card card-default">
              <div class="card-body">
                  <h3>Komentar Staff</h3>
                  <div class="form-group">
                   <textarea class="form-control" name="feow" readonly  cols="30" rows="10"><?= $komentar; ?></textarea>
                  </div>
              </div>
            </div>
        </div>
     <?php endif; ?>      


      <div class="col-lg-12">
        <div class="card card-default">
          <div class="card-header">
            <h4>Petunjuk Pengusulan Pengabdian Mandiri</h4>
          </div>
          <div class="card-body">
            <ol style="font-size: 14pt;">
              <li>Saat pertama kali mengusulkan penelitian <b>Mandiri</b> silahkan pilih menu nomor satu (1. Identitas Usulan) untuk melengkapi identitas pengusulan penelitian <b>Mandiri</b>.</li>
              <li>Setelah anda klik tombol simpan dan sistem berhasil menyimpan identitas pengusulan penelitian <b>Mandiri</b> maka pada menu akan muncul ikon centang <a href=""><span><i class="fa fa-check-circle"></i></span></a> yang memiliki arti data identitas usulan telah disimpan dan data dapat diedit hingga penelitian <b>Mandiri</b> difinalkan.</li>
              <li>Tahap selanjutnya silahkan pilih menu nomor dua (2. Anggota Dosen) untuk menambahkan anggota dosen beserta cv masing-masing dosen.</li>
              <li>Setelah anda klik tombol simpan maka identitas anggota dosen berhasil disimpan. Jika:</li>
              <ol type="a">
                <li>Ikon pada menu nomor dua merupakan jam pasir <a href=""><span><i class="fa fa-hourglass-half"></i></span></a> maka anggota dosen belum menerima sebagai anggota penelitian anda. Silahkan hubungi dosen bersangkutan untuk mempercepat proses pengusulan penelitian <b>Mandiri</b>.</li>
                <li>Ikon pada menu nomor dua metupakan centang <a href=""><span><i class="fa fa-check-circle"></i></span></a> maka anggota dosen telah menerima sebagai anggota penelitian anda.</li>
              </ol>
              <li>Langkah selanjutnya anda dapat melanjutkan ke menu nomor tiga (3. Anggota Mahasiswa). Pilih anggota mahasiswa dan klik menu simpan. jika ikon pada menu nomor tiga centang <a href=""><span><i class="fa fa-check-circle"></i></span></a> maka data anggota mahasiswa telah disimpan dan dapat diedit hingga prengusulan penelitian <b>Mandiri</b> difinalkan.</li>
              <li>Setelah melengkapi form pada menu tiga anda dapat melengkapi form berikutnya pada menu empat (4. Unggah Berkas).</li>
              <li>Jika anda yakin seluruh data pengusulan penelitian <b>Mandiri</b> benar, anda dapat klik tombol <span style="color: red;">Finalkan Pengusulan</span>.</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
  </div>

  <script>
    $(window).on("load", function() {
      $('#overlay').fadeOut(400);
    });
  </script>