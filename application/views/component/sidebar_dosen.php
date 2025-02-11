 <script src="<?= base_url() . JS_UMUM; ?>dosen.js?random=<?= uniqid() ?>"></script>
 <?php $url = $this->uri->segment(1); ?>
 <?php $url3 = $this->uri->segment(3); ?>
 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
 	<!-- Brand Logo -->
 	<a href="<?= base_url('C_dashboard') ?>" class="brand-link">
 		<img src="<?php echo base_url('assets'); ?>/dist/img/logo_polije.png" alt="Logo polije"
 			class="brand-image img-circle elevation-3" style="opacity: .8">
 		<span class="brand-text font-weight-light"><b>P3M</b>POLIJE</span>
 	</a>

 	<!-- Sidebar -->
 	<div class="sidebar">
 		<!-- Sidebar user panel (optional) -->
 		<div class="user-panel d-flex" style="margin-top: 5%;">
 			<div class="pull-left image" style="margin-top: 4%;">
 				<img src="<?php echo base_url('assets'); ?>/dist/img/default-avatar.png" class="img-circle elevation-2"
 					alt="User Image">
 			</div>
 			<div class="pull-left info">
 				<a href="#" class="d-block" style="color: #fff;"><?php echo $this->session->userdata('nama'); ?></a>
 				<p style="color: #fff; font-size: 9pt;">
 					<i class="fa fa-circle text-success"></i>
 					<?php
                     $reviewer_event = check_reviewer();
                     $pemonev_event = check_pemonev();
                        if (count($reviewer_event)  > 0) :
                            echo "Reviewer";
                        elseif (count($pemonev_event)  > 0) :
                            echo "Pemonev";
                        else :
                            $this->session->userdata('job');
                        endif;
                        ?>
 				</p>
 			</div>
 		</div>
 		<!-- Sidebar Menu -->
 		<nav class="mt-2">
 			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
 				data-accordion="false">
 				<!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
 				<li class="nav-item">
 					<a href="<?= base_url("C_settings_user") ?>"
 						class="nav-link <?= $url === 'C_settings_user' ? 'active' : '' ?>">
 						<i class="nav-icon fas fa-user"></i>
 						<p>
 							Profil
 						</p>
 					</a>
 				</li>
 				<?php $idlogin = $this->session->userdata('id');
                    if ($idlogin != 99) :
                    ?>
 				<li class="nav-item">
 					<a href="<?= base_url("C_dashboard") ?>"
 						class="nav-link <?= $url === 'C_dashboard' ? 'active' : '' ?>">
 						<i class="nav-icon fas fa-tachometer-alt"></i>
 						<p>
 							Beranda
 						</p>
 					</a>
 				</li>
 				<li
 					class="nav-item has-treeview <?= $url === 'C_penelitian_dsn_pnbp' || $url ===  'C_pengabdian_dsn_pnbp' ||  $url === "C_penelitian_plp_pnbp" ? 'menu-open' : '' ?> ">
 					<a href="#" class="nav-link">
 						<i class="nav-icon fas fa-copy"></i>
 						<p>
 							PNBP
 							<i class="right fas fa-angle-left"></i>
 						</p>
 					</a>
 					<ul class="nav nav-treeview">
 						<?php if ($this->session->userdata('job') == 'plp') : ?>
 						<li class="nav-item">
 							<a href="<?= base_url("C_penelitian_plp_pnbp") ?>"
 								class="nav-link  <?= $url === 'C_penelitian_plp_pnbp' ? 'active' : '' ?>">
 								<i class="far fa-circle nav-icon"></i>
 								<p>Penelitian PLP</p>
 							</a>
 						</li>

 						<?php endif; ?>
 						<?php if ($this->session->userdata('job') != 'plp') : ?>
 						<li class="nav-item">
 							<a href="<?= base_url("C_penelitian_dsn_pnbp") ?>"
 								class="nav-link  <?= $url === 'C_penelitian_dsn_pnbp' ? 'active' : '' ?>">
 								<i class="far fa-circle nav-icon"></i>
 								<p>Penelitian</p>
 							</a>
 						</li>
 						<li class="nav-item">
 							<a href="<?= base_url("C_pengabdian_dsn_pnbp") ?>"
 								class="nav-link <?= $url === 'C_pengabdian_dsn_pnbp' ? 'active' : '' ?>">
 								<i class="far fa-circle nav-icon"></i>
 								<p>Pengabdian</p>
 							</a>
 						</li>

 						<?php endif; ?>
 					</ul>
 				</li>
 				<?php if ($this->session->userdata('job') != 'plp') : ?>
 				<li
 					class="nav-item has-treeview <?= $url === 'C_penelitian_dsn_mandiri' || $url === 'pengajuan_mandiri' || $url === 'pengajuan_mandiri_pengabdian' || $url === 'C_pengabdian_dsn_mandiri' ? 'menu-open' : '' ?>">
 					<a href="#" class="nav-link">
 						<i class="nav-icon fas fa-copy"></i>
 						<p>
 							MANDIRI
 							<i class="right fas fa-angle-left"></i>
 						</p>
 					</a>
 					<ul class="nav nav-treeview">
 						<li class="nav-item">
 							<a href="<?= base_url("C_penelitian_dsn_mandiri") ?>"
 								class="nav-link <?= $url === 'C_penelitian_dsn_mandiri' || $url === 'pengajuan_mandiri' ? 'active' : '' ?>">
 								<i class="far fa-circle nav-icon"></i>
 								<p>Penelitian</p>
 							</a>
 						</li>
 						<li class="nav-item">
 							<a href="<?= base_url("C_pengabdian_dsn_mandiri") ?>"
 								class="nav-link <?= $url === 'C_pengabdian_dsn_mandiri' || $url === 'pengajuan_mandiri_pengabdian' ? 'active' : '' ?>">
 								<i class="far fa-circle nav-icon"></i>
 								<p>Pengabdian</p>
 							</a>
 						</li>
 						<?php endif; ?>
 					</ul>
 				</li>
 				<?php $reviewer_event = check_reviewer();
                            if (count($reviewer_event)  > 0) : $event = ['', 'Penelitian Dosen', 'Pengabdian Dosen', '', '', 'Penelitian PLP'];
                                $url_reviewer = ["", "C_reviewer/reviewer/Penelitian_dosen", "C_reviewer/reviewer/Pengabdian_dosen", "", "", "C_reviewer/reviewer/Penelitian_plp"];
                                $url_reviewer3 = ["", "Penelitian_dosen", "Pengabdian_dosen", "", "", "Penelitian_plp"]; ?>
 				<li
 					class="nav-item has-treeview <?= $url === 'C_reviewer' || $url === 'C_detail_review' ? 'menu-open' : '' ?>">
 					<a href="#" class="nav-link">
 						<i class="nav-icon fas fa-copy"></i>
 						<p>
 							MENU REVIEWER
 							<i class="right fas fa-angle-left"></i>
 						</p>
 					</a>
 					<ul class="nav nav-treeview">
 						<?php foreach ($reviewer_event as $rw) : ?>
 						<li class="nav-item">
 							<a href="<?= base_url($url_reviewer[$rw]) ?>"
 								class="nav-link <?= $url3 === $url_reviewer3[$rw] ? 'active' : '' ?>">
 								<i class="far fa-circle nav-icon"></i>
 								<p><?= ucfirst($event[$rw]) ?></p>
 							</a>
 						</li>
 						<?php endforeach; ?>
 					</ul>
 				</li>
 				<?php endif; ?>
 				<?php endif; ?>

 				<?php
                        //<li class="nav-item has-treeview">
                        //  <a href="<?= base_url("C_pengabdian_dsn") " class="nav-link">
                        //<i class="nav-icon fas fa-users"></i>
                        //<p>
                        //  Pengabdian Dosen
                        // </p>
                        // </a>
                        // </li>
                        //<li class="nav-item has-treeview">
                        //<a href="<?= base_url("C_penelitian_tkns")" class="nav-link">
                        //   <i class="nav-icon fas fa-users"></i>
                        // <p>
                        //   Penelitian Teknisi
                        // </p>
                        //</a>
                        // </li>
                        ?>
 				<!-- awal menu monev -->
 				<?php $pemonev_event = check_pemonev();
                        if (count($pemonev_event)  > 0) : $event = ['', 'Penelitian Dosen', 'Pengabdian Dosen', '', '', 'Penelitian PLP'];
                            $url_pemonev = ["", "C_pemonev/pemonev/Penelitian_dosen", "C_pemonev/pemonev/Pengabdian_dosen", "", "", "C_pemonev/pemonev/Penelitian_plp"];
                            $url_pemonev3 = ["", "Penelitian_dosen", "Pengabdian_dosen", "", "", "Penelitian_plp"]; ?>
 				<li
 					class="nav-item has-treeview <?= $url === 'C_pemonev' || $url === 'C_detail_pemonev' ? 'menu-open' : '' ?>">
 					<a href="#" class="nav-link">
 						<i class="nav-icon fas fa-copy"></i>
 						<p>
 							MENU PEMONEV
 							<i class="right fas fa-angle-left"></i>
 						</p>
 					</a>
 					<ul class="nav nav-treeview">
 						<?php foreach ($pemonev_event as $rw) : ?>
 						<li class="nav-item">
 							<a href="<?= base_url($url_pemonev[$rw]) ?>"
 								class="nav-link <?= $url3 === $url_pemonev3[$rw] ? 'active' : '' ?>">
 								<i class="far fa-circle nav-icon"></i>
 								<p><?= ucfirst($event[$rw]) ?></p>
 							</a>
 						</li>
 						<?php endforeach; ?>
 					</ul>
 				</li>
 				<?php endif; ?>
                 <?php $pemonev_event = check_pemonev();
                        if (count($pemonev_event)  > 0) : $event = ['', 'Penelitian Dosen', 'Pengabdian Dosen', '', '', 'Penelitian PLP'];
                            $url_pemonev = ["", "C_evaluasi/subjekEvaluasi/Penelitian_dosen", "C_evaluasi/subjekEvaluasi/Pengabdian_dosen", "", "", "C_evaluasi/subjekEvaluasi/Penelitian_plp"];
                            $url_pemonev3 = ["", "Penelitian_dosen", "Pengabdian_dosen", "", "", "Penelitian_plp"]; ?>
 				<li
 					class="nav-item has-treeview <?= $url === 'C_evaluasi' || $url === 'C_detail_evaluasi' ? 'menu-open' : '' ?>">
 					<a href="#" class="nav-link">
 						<i class="nav-icon fas fa-copy"></i>
 						<p>
 							MENU EVALUASI
 							<i class="right fas fa-angle-left"></i>
 						</p>
 					</a>
 					<ul class="nav nav-treeview">
 						<?php foreach ($pemonev_event as $rw) : ?>
 						<li class="nav-item">
 							<a href="<?= base_url($url_pemonev[$rw]) ?>"
 								class="nav-link <?= $url3 === $url_pemonev3[$rw] ? 'active' : '' ?>">
 								<i class="far fa-circle nav-icon"></i>
 								<p><?= ucfirst($event[$rw]) ?></p>
 							</a>
 						</li>
 						<?php endforeach; ?>
 					</ul>
 				</li>
 				<?php endif; ?>
 			</ul>
 			</li>
 			<!-- awal menu monev -->
 			</ul>
 		</nav>
 		<!-- /.sidebar-menu -->
 	</div>
 	<!-- /.sidebar -->
 </aside>
