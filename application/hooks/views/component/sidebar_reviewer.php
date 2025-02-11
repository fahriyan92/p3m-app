<?php $url = $this->uri->segment(1); ?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?= base_url() ?>" class="brand-link">
    <img src="<?php echo base_url('assets'); ?>/dist/img/logo_polije.png" alt="Logo polije" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light"><b>P3M</b>POLIJE</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel d-flex" style="margin-top: 5%;">
      <div class="pull-left image" style="margin-top: 4%;">
        <img src="<?php echo base_url('assets'); ?>/dist/img/default-avatar.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="pull-left info">
        <a href="#" class="d-block" style="color: #fff;"><?php echo $this->session->userdata('nama'); ?></a>
        <p style="color: #fff; font-size: 9pt;">
          <i class="fa fa-circle text-success"></i>
          <?php
          $level = $this->session->userdata('level');
          if ($level === "4") {
            echo "SUPER ADMIN";
          }

          if ($level === "1") {
            echo "ADMIN";
          }
          if ($level === "2") {
            echo "DOSEN";
          }
          if ($level === "3") {
            echo "REVIEWER";
          }
          ?>
        </p>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="<?= base_url("C_dashboard") ?>" class="nav-link <?= $this->uri->segment(1) === 'C_dashboard' || $this->uri->segment(1) === 'C_detail_review' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Beranda
            </p>
          </a>
        </li>
        <?php if ($this->session->userdata('job') != 'plp') : ?>
          <li class="nav-item has-treeview <?= $url === 'C_penelitian_dsn_mandiri' || $url === 'pengajuan_mandiri' || $url === 'pengajuan_mandiri_pengabdian' || $url === 'C_pengabdian_dsn_mandiri' ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                MANDIRI
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url("C_penelitian_dsn_mandiri") ?>" class="nav-link <?= $url === 'C_penelitian_dsn_mandiri' || $url === 'pengajuan_mandiri' ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penelitian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url("C_pengabdian_dsn_mandiri") ?>" class="nav-link <?= $url === 'C_pengabdian_dsn_mandiri' || $url === 'pengajuan_mandiri_pengabdian' ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengabdian</p>
                </a>
              </li>
            <?php endif; ?>
            </ul>
          </li>
      </ul>

    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>