<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Template Mo">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" rel="stylesheet">

    <title>Layanan &#8211; P3M POLIJE</title>
    <!--

ART FACTORY

https://templatemo.com/tm-537-art-factory

-->
    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/landing'); ?>/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/landing'); ?>/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/landing'); ?>/css/templatemo-art-factory.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/landing'); ?>/css/owl-carousel.css">

</head>

<body class="body">

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->


    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="#" class="logo">
                            <img alt="P3M POLIJE" src="<?php echo base_url('assets/landing/images'); ?>/logo_polije.png" style="width: 60px;">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="#welcome" class="active">Home</a></li>
                            <li class="scroll-to-section"><a href="#about2">Jadwal Pengusulan</a></li>
                            <li class="scroll-to-section"><a href="#about">Panduan</a></li>
                            <li class="scroll-to-section"><a href="#call">Kontak</a></li>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->


    <!-- ***** Welcome Area Start ***** -->
    <div class="welcome-area" id="welcome">

        <!-- ***** Header Text Start ***** -->
        <div class="header-text">
            <div class="container">
                <div class="row">
                    <div class="left-text col-lg-6 col-md-6 col-sm-12 col-xs-12" data-scroll-reveal="enter left move 30px over 0.6s after 0.4s">
                        <h1>Layanan &#8211; P3M <strong>POLIJE</strong></h1>
                        <p>Pusat Penelitian dan Pengabdian Kepada Masyarakat Politeknik Negeri Jember.</p>
                        <a href="<?= site_url('C_auth/redirect_google'); ?>" class="main-button-slider">Login dengan <i class="fab fa-google"></i><b>-SSO POLIJE</b></a><br>
                        <a class="registrasi" href="<?= site_url('C_auth/auth_dosen') ?>">Registrasi</a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" data-scroll-reveal="enter right move 30px over 0.6s after 0.4s">
                        <img src="<?php echo base_url('assets/landing'); ?>/images/slider-icon.png" class="rounded img-fluid d-block mx-auto" alt="First Vector Graphic">
                    </div>
                </div>
            </div>
        </div>
        <!-- ***** Header Text End ***** -->
    </div>
    <!-- ***** Welcome Area End ***** -->

    <!-- ***** Features Big Item Start ***** -->
    <section class="section" id="about2">
        <div class="container">
            <div class="row">
                <div class="left-text col-lg-5 col-md-12 col-sm-12 mobile-bottom-fix">
                    <div class="left-heading">
                        <h5>Jadwal Pengusulan Proposal</h5>
                    </div>
                    <div class="owl-carousel owl-theme">
                        <div class="item service-item">
                            <div class="row" style="display: table;">
                                <img src="<?php echo base_url('assets/landing'); ?>/images/about-icon-01.png" alt="" style="width: 50px; height: 50px; vertical-align: middle; display: table-cell;">
                                <h6 class="service-title" style="vertical-align: middle; display: table-cell; padding-left:10px;">Penelitian Dosen PNBP</h6>
                            </div>
                            <div class="desc" style="text-align: left;">
                                <?php
                                for ($i = 0; $i <= count($list) - 1; $i++) {
                                    if ($list[$i]->id_event == 1) {
                                        $akhir = $list[$i]->akhir === null ? '-' : tanggal_indo($list[$i]->akhir);
                                ?>
                                        <p style="font-weight:bold; margin:0; padding-top:5px; color: #4a4a4a;">+ <?= ucwords($list[$i]->tahapan) ; ?></p>
                                        <div style="color:grey;padding-top:2px;">Mulai : <strong><?= tanggal_indo($list[$i]->mulai); ?></strong></div>
                                        <div style="color:grey;padding-top:2px;">Berakhir : <strong><?= $akhir; ?></strong></div>
                                <?php
                                    }
                                } ?>
                            </div>
                        </div>

                        <div class="item service-item">
                            <div class="row" style="display: table;">
                                <img src="<?php echo base_url('assets/landing'); ?>/images/about-icon-01.png" alt="" style="width: 50px; height: 50px; vertical-align: middle; display: table-cell;">
                                <h6 class="service-title" style="vertical-align: middle; display: table-cell; padding-left:10px;">Pengabdian PNBP</h6>
                            </div>
                            <!-- <h6 class="service-title">Pengabdian PNBP</h6> -->
                            <div class="desc" style="text-align: left;">
                                <?php
                                for ($i = 0; $i <= count($list) - 1; $i++) {
                                    if ($list[$i]->id_event == 2) {
                                        $akhir = $list[$i]->akhir === null ? '-' : tanggal_indo($list[$i]->akhir);
                                ?>
                                        <p style="font-weight:bold; margin:0; padding-top:5px; color: #4a4a4a;">+ <?= ucwords($list[$i]->tahapan) ; ?></p>
                                        <div style="color:grey;padding-top:2px;">Mulai : <strong><?= tanggal_indo($list[$i]->mulai); ?></strong></div>
                                        <div style="color:grey;padding-top:2px;">Berakhir : <strong><?= $akhir; ?></strong></div>
                                <?php
                                    }
                                } ?>
                            </div>
                        </div>

                        <div class="item service-item">
                            <div class="row" style="display: table;">
                                <img src="<?php echo base_url('assets/landing'); ?>/images/about-icon-01.png" alt="" style="width: 50px; height: 50px; vertical-align: middle; display: table-cell;">
                                <h6 class="service-title" style="vertical-align: middle; display: table-cell; padding-left:10px;">Penelitian PLP PNBP</h6>
                            </div>
                            <!-- <h6 class="service-title">Penelitian PLP PNBP</h6> -->
                            <div class="desc" style="text-align: left;">
                                <?php
                                for ($i = 0; $i <= count($list) - 1; $i++) {
                                    if ($list[$i]->id_event == 3) {
                                        $akhir = $list[$i]->akhir === null ? '-' : tanggal_indo($list[$i]->akhir);
                                ?>
                                        <p style="font-weight:bold; margin:0; padding-top:5px; color: #4a4a4a;">+ <?= ucwords($list[$i]->tahapan) ; ?></p>
                                        <div style="color:grey;padding-top:2px;">Mulai : <strong><?= tanggal_indo($list[$i]->mulai); ?></strong></div>
                                        <div style="color:grey;padding-top:2px;">Berakhir : <strong><?= $akhir; ?></strong></div>
                                <?php
                                    }
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </div>
                </div> -->
                <div class="right-image col-lg-7 col-md-12 col-sm-12 mobile-bottom-fix-big" data-scroll-reveal="enter right move 30px over 0.6s after 0.4s">
                    <img src="<?php echo base_url('assets/landing'); ?>/images/right-image.png" class="rounded img-fluid d-block mx-auto" alt="App">
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Features Big Item End ***** -->


    <!-- ***** Features Big Item Start ***** -->
    <section class="section" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 col-sm-12" data-scroll-reveal="enter left move 30px over 0.6s after 0.4s">
                    <img src="<?php echo base_url('assets/landing'); ?>/images/left-image.png" class="rounded img-fluid d-block mx-auto" alt="App">
                </div>
                <div class="right-text col-lg-5 col-md-12 col-sm-12 mobile-top-fix">
                    <div class="left-heading">
                        <h5>Panduan Menggunakan Aplikasi (Penelitian & Pengabdian)</h5>
                    </div>
                    <div class="left-text">
                        <p>Penelitian dengan sumber pendanaan PNBP Politeknik Negeri Jember
                            dimaksudkan sebagai kegiatan dalam rangka membina dan mengarahkan peneliti untuk
                            meningkatkan kemampuan dalam melaksanakan penelitian dan mempublikasikan hasil
                            penelitian secara nasional maupun internasional yang didasarkan pada bidang unggulan
                            yang termuat dalam Rencana Strategis Penelitian Politeknik Negeri Jember.</p>
                        <a href="<?= base_url() ?>assets/berkas/Panduan-Penelitian-PNBP.pdf" target="_blank" class="main-button">Download Panduan</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="hr"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Features Big Item End ***** -->

    <!-- ***** Features Big Item Start ***** -->
    <section class="section" id="about">
        <div class="container">
            <div class="row">
                <div class="right-text col-lg-5 col-md-12 col-sm-12 mobile-top-fix">
                    <div class="left-heading">
                        <h5>Panduan Mengisi Form Evaluasi (Penelitian & Pengabdian)</h5>
                    </div>
                    <div class="left-text">
                        <p>Penelitian dengan sumber pendanaan PNBP Politeknik Negeri Jember
                            dimaksudkan sebagai kegiatan dalam rangka membina dan mengarahkan peneliti untuk
                            meningkatkan kemampuan dalam melaksanakan penelitian dan mempublikasikan hasil
                            penelitian secara nasional maupun internasional yang didasarkan pada bidang unggulan
                            yang termuat dalam Rencana Strategis Penelitian Politeknik Negeri Jember.</p>
                        <a href="<?= base_url() ?>assets/berkas/Panduan-Evaluasi.pptx" target="_blank" class="main-button">Download Panduan Mengisi Evaluasi</a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12" data-scroll-reveal="enter left move 30px over 0.6s after 0.4s">
                    <img src="<?php echo base_url('assets/landing'); ?>/images/left-image.png" class="rounded img-fluid d-block mx-auto" alt="App">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="hr"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Features Big Item End ***** -->

    <!-- ***** Footer Start ***** -->
    <footer id="call">
        <div class="container">
            <div class="row link" style="padding-bottom: 20vh;">
                <div class="col-xl-4 col-sm-4 mb-4 mb-xl-0 single-footer-widget">
                    <h4>P3M POLIJE</h4>
                    <ul>
                        <li><a href="https://p3m.polije.ac.id/about-us/">Tentang</a></li>
                        <li><a href="https://p3m.polije.ac.id/panduan/">Panduan</a></li>
                        <li><a href="https://p3m.polije.ac.id/agenda/">Agenda</a></li>
                        <li><a href="https://p3m.polije.ac.id/galeri-kegiatan-p3m/">Galeri Kegiatan</a></li>
                        <li><a href="https://p3m.polije.ac.id/komisi-etik/">Komite Etik</a></li>
                    </ul>
                </div>
                <div class="col-xl-4 col-sm-4 mb-4 mb-xl-0 single-footer-widget">
                    <h4>Tautan Penting</h4>
                    <ul>
                        <li><a href="http://www.polije.ac.id/">POLITEKNIK NEGERI JEMBER</a></li>
                        <li><a href="https://ristekdikti.go.id/">RISTEKDIKTI</a></li>
                        <li><a href="http://simlitabmas.ristekdikti.go.id/">SIMLITABMAS</a></li>
                        <li><a href="https://sinta.ristekbrin.go.id/">SINTA</a></li>
                        <li><a href="http://arjuna.ristekdikti.go.id/">ARJUNA</a></li>
                    </ul>
                </div>
                <div class="col-xl-4 col-sm-4 mb-4 mb-xl-0 text-center">
                    <a href="https://wa.me/6282245328590?text=Saya%20ingin%20menanyakan%20cara%20menggunakan%20aplikasi%20Layanan-P3M" class="main-button">Kontak kami</a>
                    <p style="font-size: medium; font-weight:700; padding-top:20px" class="text-center">Irul.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <p class="copyright">Copyright &copy; 2020 Polije</p>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <ul class="social">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-rss"></i></a></li>
                        <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="<?php echo base_url('assets/landing'); ?>/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="<?php echo base_url('assets/landing'); ?>/js/popper.js"></script>
    <script src="<?php echo base_url('assets/landing'); ?>/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="<?php echo base_url('assets/landing'); ?>/js/owl-carousel.js"></script>
    <script src="<?php echo base_url('assets/landing'); ?>/js/scrollreveal.min.js"></script>
    <script src="<?php echo base_url('assets/landing'); ?>/js/imgfix.min.js"></script>

    <!-- Global Init -->
    <script src="<?php echo base_url('assets/landing'); ?>/js/custom.js"></script>

</body>

</html>
