  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('C_dashboard') ?>" class="brand-link">
      <img src="<?php echo base_url('assets'); ?>/dist/img/logo_polije.png" alt="Logo polije" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><b>P3M</b>POLIJE</span>
    </a>

    <?php
    $url = $this->uri->segment(1);
    $url2 = $this->uri->segment(2);
    ?>

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
            <a href="<?= base_url("C_dashboard") ?>" class="nav-link <?= $url === 'C_dashboard' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Beranda
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview <?= ($url === 'C_reviewer' || $url === 'C_review_proposal_mandiri' || $url === 'C_nilai_mandiri')  || $url2 ===  'dsnReviewer' ? 'menu-open' : '' ?>">
            <a href="" class="nav-link <?= ($url === 'C_reviewer' || $url === 'C_review_proposal_mandiri'  || $url === 'C_nilai_mandiri') || $url2 ===  'dsnReviewer' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Review
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url("C_reviewer") ?>" class="nav-link <?= $url === 'C_reviewer'  && $url2 !== "dsnReviewer" && $url2 !== "proposalReviewer" ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-file-invoice"></i>
                  <p>
                    Proposal PNBP
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url("C_review_proposal_mandiri") ?>" class="nav-link <?= ($url === 'C_review_proposal_mandiri' || $url === 'C_nilai_mandiri') && $url2 !== "dsnReviewer" && $url2 !== "proposalReviewer" ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-file-contract"></i>
                  <p>
                    Proposal Mandiri
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url("C_reviewer/dsnReviewer") ?>" class="nav-link <?= $url === 'C_reviewer' && $url2 === 'dsnReviewer' || $url2 ===  'proposalReviewer' ? 'active' : '' ?>">
                  <i class="nav-icon fa fa-paste"></i>
                  <p>Reviewer Dosen</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?= $url === 'C_rekap' ? 'menu-open' : '' ?>">
            <a href="" class="nav-link <?= $url === 'C_rekap' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-star-half-alt"></i>
              <p>
                Rekap Proposal PNBP
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url("C_rekap/Rekap_PNBP") ?>" class="nav-link <?= $url === 'C_rekap'  && $url2 === "Rekap_PNBP" ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-sticky-note"></i>
                  <p>
                    Proposal Penelitian
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url("C_rekap/Rekap_Pengabdian") ?>" class="nav-link <?= $url === 'C_rekap' && $url2 === "Rekap_Pengabdian" ? 'active' : '' ?>">
                  <i class="nav-icon far fa-sticky-note"></i>
                  <p>
                    Proposal Pengabdian
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?= base_url("C_event") ?>" class="nav-link <?= $url === 'C_event' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-calendar"></i>
              <p>
                Event
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url("C_hindex") ?>" class="nav-link <?= $url === 'C_hindex' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Limit
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview <?= $url === 'C_master_data' ? 'menu-open' : '' ?>">
            <a href="" class="nav-link <?= $url === 'C_master_data' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-folder"></i>
              <p>
                Master Data
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url("C_master_data") ?>" class="nav-link <?= $url === 'C_master_data' && $url2 !== "fokus" && $url2 !== "luaran" && $url2 !== 'jenis_proposal' ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-address-book"></i>
                  <p>
                    Data Users
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url("C_master_data/fokus") ?>" class="nav-link <?= $url2 === 'fokus' ? 'active' : '' ?>">
                  <i class="nav-icon fa fa-flag"></i>
                  <p>Fokus Proposal</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url("C_master_data/luaran") ?>" class="nav-link <?= $url2 === 'luaran' ? 'active' : '' ?>">
                  <i class="nav-icon fa fa-bullhorn"></i>
                  <p>Luaran Proposal</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url("C_master_data/jenis_proposal") ?>" class="nav-link <?= $url2 === 'jenis_proposal' ? 'active' : '' ?>">
                  <i class="nav-icon fa fa-pager"></i>
                  <p>Jenis Proposal</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="<?= base_url("C_penilai") ?>" class="nav-link <?= $url === 'C_penilai' ? 'active' : '' ?>">
              <i class="nav-icon fa fa-list"></i>
              <p>
                Data Kriteria Penilaian
              </p>
            </a>
          </li>
          <!-- <li class="nav-header">Pengaturan</li>

          <li class="nav-item has-treeview">
            <a href="<?= base_url("C_settings_user") ?>" class="nav-link">
              <i class="fas fa-user-cog nav-icon"></i>
              <p>Profil Pengguna</p>
            </a>
          </li> -->


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>