<?php $idEvent = $this->uri->segment(4); ?>
<style>
    .white-space {
        white-space: pre-wrap;
    }

    .table {
        display: table;
        border-collapse: collapse;
    }

    .table .tr {
        display: table-row;
        border: 1px solid #ddd;
    }

    .table .tr:first-child {
        font-weight: bold;
        border-bottom: 2px solid #ddd;
    }

    .table .tr:nth-child(even) {
        background-color: #F9F9F9;
    }

    .table .tr .td {
        display: table-cell;
        padding: 8px;
        border-left: 1px solid #ddd;
    }

    .table .tr .td:first-child {
        border-left: 0;
    }

    /* Not necessary for table styling */
    .div-table,
    .table-tag {
        float: left;
        margin: 2em;
    }

    .div-table .title,
    .table-tag .title {
        text-align: center;
        padding-bottom: 0.5em;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $judul; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?= $brdcrmb; ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><?= $namakelompok; ?></h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($dt_proposal)) : ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputJudul">Judul</label>
                                    <input type="text" class="form-control" id="inputJudul" placeholder="Judul Penelitian" value="<?= $dt_proposal->judul; ?>" name="judulPenelitianDosenPNBP" disabled>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="">Nama Ketua</label>
                                    <input readonly class="form-control text-capitalize" type="text" value="<?= $dt_proposal->nama_ketua ?> - <?= $dt_proposal->nidn_ketua ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="biayadiusulkan">Biaya yang diusulkan</label>
                                <input type="text" class="form-control" id="biayadiusulkan" value="<?= rupiah($dt_proposal->biaya_usulan); ?>" placeholder="Rp.8.500.000,-" name="biayadiusulkan" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="tglmulai">Lama Penelitian (mulai)</label>
                                <input type="date" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" id="tglmulai" placeholder="mulai" name="tglmulai" value="<?= $dt_proposal->mulai; ?>" disabled>
                            </div>
                        </div>
                        <div class="col-sm-1" style="text-align: center; margin-top:36px">
                            <span> - </span>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="tglakhir">(akhir)</label>
                                <input type="date" class="form-control" id="tglakhir" data-inputmask-inputformat="dd/mm/yyyy" placeholder="akhir" name="tglakhir" value="<?= $dt_proposal->akhir; ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <form action="<?= $status->status == 0 ? base_url("C_evaluasi/submitEvaluasi/$idproposal") : base_url("C_evaluasi/editEvaluasi/$idproposal") ?>" method="POST">
                        <input type="hidden" name="skema" value="<?= $kelompok_pengajuan->id_kelompok_pengajuan ?>">
                        <input type="hidden" name="nama_ketua" value="<?= $dt_proposal->nama_ketua ?>">
                        <input type="hidden" name="id_kerjaan" value="<?= $idproposal ?>">
                        <input type="hidden" name="id_pemonev" value="<?= $id_pemonev->id_pemonev ?>">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col" width="30%">Komponen Penilaian</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Bobot<br>(1 - 100)</th>
                                        <th scope="col">Skor<br>(1 - 7)</th>
                                        <th scope="col">Nilai<br>(Bobot x Skor)</th>
                                        <th scope="col">File Laporan</th>
                                        <th scope="col">Kesimpulan</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th scope="col">Luaran Wajib</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Berupa naskah akademik yang dapat berupa policy brief, rekomendasi kebijakan, atau model kebijakan strategis terhadap suatu permasalahan di unit institusi atau instansi lain.</td>
                                        <td><?= $laporan_monev->komponen_keterangan1 ?></td>
                                        <td><?= $laporan_monev->komponen_bobot1 ?></td>
                                        <td><?= $laporan_monev->komponen_skor1 ?></td>
                                        <td><?= $laporan_monev->komponen_nilai1 ?></td>
                                        <?php if (isset($berkas->w_b1)) : ?>
                                            <td><a href="<?php echo base_url("assets/berkas/file_laporan/penelitian/") . $berkas->w_b1 ?>" target="_blank">Unduh</a></td>
                                        <?php else : ?>
                                            <td>Tidak Ada File</td>
                                        <?php endif; ?>
                                        <td>
                                            <?php if (isset($laporan_evaluasi->kesimpulan_wajib1)) : ?>
                                                <span style="text-transform: uppercase">Pilihan Awal:
                                                    <?= $laporan_evaluasi->kesimpulan_wajib1 ?></span>
                                            <?php endif; ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen1" id="sesuaiLuaran1" value="sesuai luaran" required>
                                                <label class="form-check-label" for="sesuaiLuaran">
                                                    Sesuai Luaran
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen1" id="tidakSesuaiLuaran1" value="tidak sesuai">
                                                <label class="form-check-label" for="tidakSesuaiLuaran">
                                                    Tidak Sesuai Luaran
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Satu artikel ilmiah berupa prosiding dari Seminar Internasional Polije (ICoFA atau ICoSHIP) yang diregistrasi di publisher bereputasi baik Institute of Physics (IOP) atau Atlantis Press(AP), atau publisher bereputasi lainnya, atau seminar internasional yang lain bila tidak lolos seleksi pada publisher prosiding ICoFA atau ICoSHIP</td>
                                        <td><?= $laporan_monev->komponen_keterangan2 ?></td>
                                        <td><?= $laporan_monev->komponen_bobot2 ?></td>
                                        <td><?= $laporan_monev->komponen_skor2 ?></td>
                                        <td><?= $laporan_monev->komponen_nilai2 ?></td>
                                        <?php if (isset($berkas->w_b2)) : ?>
                                            <td><a href="<?php echo base_url("assets/berkas/file_laporan/penelitian/") . $berkas->w_b2 ?>" target="_blank">Unduh</a></td>
                                        <?php else : ?>
                                            <td>Tidak Ada File</td>
                                        <?php endif; ?>
                                        <td>
                                            <?php if (isset($laporan_evaluasi->kesimpulan_wajib2)) : ?>
                                                <span style="text-transform: uppercase">Pilihan Awal:
                                                    <?= $laporan_evaluasi->kesimpulan_wajib2 ?></span>
                                            <?php endif; ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen2" id="sesuaiLuaran2" value="sesuai luaran" required>
                                                <label class="form-check-label" for="sesuaiLuaran">
                                                    Sesuai Luaran
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen2" id="tidakSesuaiLuaran2" value="tidak sesuai">
                                                <label class="form-check-label" for="tidakSesuaiLuaran">
                                                    Tidak Sesuai Luaran
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Satu Kekayaan Intelektual berupa Hak Cipta dengan status Granted atas nama Politeknik Negeri Jember</td>
                                        <td><?= $laporan_monev->komponen_keterangan3 ?></td>
                                        <td><?= $laporan_monev->komponen_bobot3 ?></td>
                                        <td><?= $laporan_monev->komponen_skor3 ?></td>
                                        <td><?= $laporan_monev->komponen_nilai3 ?></td>
                                        <?php if (isset($berkas->w_b3)) : ?>
                                            <td><a href="<?php echo base_url("assets/berkas/file_laporan/penelitian/") . $berkas->w_b3 ?>" target="_blank">Unduh</a></td>
                                        <?php else : ?>
                                            <td>Tidak Ada File</td>
                                        <?php endif; ?>
                                        <td>
                                            <?php if (isset($laporan_evaluasi->kesimpulan_wajib3)) : ?>
                                                <span style="text-transform: uppercase">Pilihan Awal:
                                                    <?= $laporan_evaluasi->kesimpulan_wajib3 ?></span>
                                            <?php endif; ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen3" id="sesuaiLuaran3" value="sesuai luaran" required>
                                                <label class="form-check-label" for="sesuaiLuaran">
                                                    Sesuai Luaran
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen3" id="tidakSesuaiLuaran3" value="tidak sesuai">
                                                <label class="form-check-label" for="tidakSesuaiLuaran">
                                                    Tidak Sesuai Luaran
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th scope="col">Luaran Tambahan</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Jurnal Nasional Terakreditasi /Jurnal Internasional / Jurnal Internasional
                                            Bereputasi</td>
                                        <td><?= $laporan_monev->komponen_keterangan_tambahan1 ?></td>
                                        <td><?= $laporan_monev->komponen_bobot_tambahan1 ?></td>
                                        <td><?= $laporan_monev->komponen_skor_tambahan1 ?></td>
                                        <td><?= $laporan_monev->komponen_nilai_tambahan1 ?></td>
                                        <?php if (isset($berkas->t_b1)) : ?>
                                            <td><a href="<?php echo base_url("assets/berkas/file_laporan/penelitian/") . $berkas->t_b1 ?>" target="_blank">Unduh</a></td>
                                        <?php else : ?>
                                            <td>Tidak Ada File</td>
                                        <?php endif; ?>
                                        <td>
                                            <?php if (isset($laporan_evaluasi->kesimpulan_tambahan1)) : ?>
                                                <span style="text-transform: uppercase">Pilihan Awal:
                                                    <?= $laporan_evaluasi->kesimpulan_tambahan1 ?></span>
                                            <?php endif; ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen_tambahan1" id="sesuaiLuaranTambahan1" value="sesuai luaran" required>
                                                <label class="form-check-label" for="sesuaiLuaran">
                                                    Sesuai Luaran
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen_tambahan1" id="tidakSesuaiLuaranTambahan1" value="tidak sesuai">
                                                <label class="form-check-label" for="tidakSesuaiLuaran">
                                                    Tidak Sesuai Luaran
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>HKI berupa Paten, Paten Sederhana, Hak Cipta, Perlindungan Varietas Tanaman,
                                            Desain Tata Letak Sirkuit Terpadu, Naskah kebijakan dengan status Terdaftar
                                        </td>
                                        <td><?= $laporan_monev->komponen_keterangan_tambahan2 ?></td>
                                        <td><?= $laporan_monev->komponen_bobot_tambahan2 ?></td>
                                        <td><?= $laporan_monev->komponen_skor_tambahan2 ?></td>
                                        <td><?= $laporan_monev->komponen_nilai_tambahan2 ?></td>
                                        <?php if (isset($berkas->t_b2)) : ?>
                                            <td><a href="<?php echo base_url("assets/berkas/file_laporan/penelitian/") . $berkas->t_b2 ?>" target="_blank">Unduh</a></td>
                                        <?php else : ?>
                                            <td>Tidak Ada File</td>
                                        <?php endif; ?>
                                        <td>
                                            <?php if (isset($laporan_evaluasi->kesimpulan_tambahan2)) : ?>
                                                <span style="text-transform: uppercase">Pilihan Awal:
                                                    <?= $laporan_evaluasi->kesimpulan_tambahan2 ?></span>
                                            <?php endif; ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen_tambahan2" id="sesuaiLuaranTambahan2" value="sesuai luaran" required>
                                                <label class="form-check-label" for="sesuaiLuaran">
                                                    Sesuai Luaran
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen_tambahan2" id="tidakSesuaiLuaranTambahan2" value="tidak sesuai">
                                                <label class="form-check-label" for="tidakSesuaiLuaran">
                                                    Tidak Sesuai Luaran
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Draft Buku hasil penelitian atau bahan ajar </td>
                                        <td><?= $laporan_monev->komponen_keterangan_tambahan3 ?></td>
                                        <td><?= $laporan_monev->komponen_bobot_tambahan3 ?></td>
                                        <td><?= $laporan_monev->komponen_skor_tambahan3 ?></td>
                                        <td><?= $laporan_monev->komponen_nilai_tambahan3 ?></td>
                                        <?php if (isset($berkas->t_b3)) : ?>
                                            <td><a href="<?php echo base_url("assets/berkas/file_laporan/penelitian/") . $berkas->t_b3 ?>" target="_blank">Unduh</a></td>
                                        <?php else : ?>
                                            <td>Tidak Ada File</td>
                                        <?php endif; ?>
                                        <td>
                                            <?php if (isset($laporan_evaluasi->kesimpulan_tambahan3)) : ?>
                                                <span style="text-transform: uppercase">Pilihan Awal:
                                                    <?= $laporan_evaluasi->kesimpulan_tambahan3 ?></span>
                                            <?php endif; ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen_tambahan3" id="sesuaiLuaranTambahan3" value="sesuai luaran" required>
                                                <label class="form-check-label" for="sesuaiLuaran">
                                                    Sesuai Luaran
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen_tambahan3" id="tidakSesuaiLuaranTambahan3" value="tidak sesuai">
                                                <label class="form-check-label" for="tidakSesuaiLuaran">
                                                    Tidak Sesuai Luaran
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>Book chapter yang diterbitkan oleh penerbit bereputasi dan ber-ISBN</td>
                                        <td><?= $laporan_monev->komponen_keterangan_tambahan4 ?></td>
                                        <td><?= $laporan_monev->komponen_bobot_tambahan4 ?></td>
                                        <td><?= $laporan_monev->komponen_skor_tambahan4 ?></td>
                                        <td><?= $laporan_monev->komponen_nilai_tambahan4 ?></td>
                                        <?php if (isset($berkas->t_b4)) : ?>
                                            <td><a href="<?php echo base_url("assets/berkas/file_laporan/penelitian/") . $berkas->t_b4 ?>" target="_blank">Unduh</a></td>
                                        <?php else : ?>
                                            <td>Tidak Ada File</td>
                                        <?php endif; ?>
                                        <td>
                                            <?php if (isset($laporan_evaluasi->kesimpulan_tambahan4)) : ?>
                                                <span style="text-transform: uppercase">Pilihan Awal:
                                                    <?= $laporan_evaluasi->kesimpulan_tambahan4 ?></span>
                                            <?php endif; ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen_tambahan4" id="sesuaiLuaranTambahan4" value="sesuai luaran" required>
                                                <label class="form-check-label" for="sesuaiLuaran">
                                                    Sesuai Luaran
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen_tambahan4" id="tidakSesuaiLuaranTambahan4" value="tidak sesuai">
                                                <label class="form-check-label" for="tidakSesuaiLuaran">
                                                    Tidak Sesuai Luaran
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">5</th>
                                        <td>Keynote speaker dalam temu ilmiah (internasional, nasional dan lokal)</td>
                                        <td><?= $laporan_monev->komponen_keterangan_tambahan5 ?></td>
                                        <td><?= $laporan_monev->komponen_bobot_tambahan5 ?></td>
                                        <td><?= $laporan_monev->komponen_skor_tambahan5 ?></td>
                                        <td><?= $laporan_monev->komponen_nilai_tambahan5 ?></td>
                                        <?php if (isset($berkas->t_b5)) : ?>
                                            <td><a href="<?php echo base_url("assets/berkas/file_laporan/penelitian/") . $berkas->t_b5 ?>" target="_blank">Unduh</a></td>
                                        <?php else : ?>
                                            <td>Tidak Ada File</td>
                                        <?php endif; ?>
                                        <td>
                                            <?php if (isset($laporan_evaluasi->kesimpulan_tambahan5)) : ?>
                                                <span style="text-transform: uppercase">Pilihan Awal:
                                                    <?= $laporan_evaluasi->kesimpulan_tambahan5 ?></span>
                                            <?php endif; ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen_tambahan5" id="sesuaiLuaranTambahan5" value="sesuai luaran" required>
                                                <label class="form-check-label" for="sesuaiLuaran">
                                                    Sesuai Luaran
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen_tambahan5" id="tidakSesuaiLuaranTambahan5" value="tidak sesuai">
                                                <label class="form-check-label" for="tidakSesuaiLuaran">
                                                    Tidak Sesuai Luaran
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">6</th>
                                        <td>Pembicara kunci/visiting lecturer (internasional)</td>
                                        <td><?= $laporan_monev->komponen_keterangan_tambahan6 ?></td>
                                        <td><?= $laporan_monev->komponen_bobot_tambahan6 ?></td>
                                        <td><?= $laporan_monev->komponen_skor_tambahan6 ?></td>
                                        <td><?= $laporan_monev->komponen_nilai_tambahan6 ?></td>
                                        <?php if (isset($berkas->t_b6)) : ?>
                                            <td><a href="<?php echo base_url("assets/berkas/file_laporan/penelitian/") . $berkas->t_b6 ?>" target="_blank">Unduh</a></td>
                                        <?php else : ?>
                                            <td>Tidak Ada File</td>
                                        <?php endif; ?>
                                        <td>
                                            <?php if (isset($laporan_evaluasi->kesimpulan_tambahan6)) : ?>
                                                <span style="text-transform: uppercase">Pilihan Awal:
                                                    <?= $laporan_evaluasi->kesimpulan_tambahan6 ?></span>
                                            <?php endif; ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen_tambahan6" id="sesuaiLuaranTambahan6" value="sesuai luaran" required>
                                                <label class="form-check-label" for="sesuaiLuaran">
                                                    Sesuai Luaran
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen_tambahan6" id="tidakSesuaiLuaranTambahan6" value="tidak sesuai">
                                                <label class="form-check-label" for="tidakSesuaiLuaran">
                                                    Tidak Sesuai Luaran
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">7</th>
                                        <td>Dokumen feasibility study, business plan</td>
                                        <td><?= $laporan_monev->komponen_keterangan_tambahan7 ?></td>
                                        <td><?= $laporan_monev->komponen_bobot_tambahan7 ?></td>
                                        <td><?= $laporan_monev->komponen_skor_tambahan7 ?></td>
                                        <td><?= $laporan_monev->komponen_nilai_tambahan7 ?></td>
                                        <?php if (isset($berkas->t_b7)) : ?>
                                            <td><a href="<?php echo base_url("assets/berkas/file_laporan/penelitian/") . $berkas->t_b7 ?>" target="_blank">Unduh</a></td>
                                        <?php else : ?>
                                            <td>Tidak Ada File</td>
                                        <?php endif; ?>
                                        <td>
                                            <?php if (isset($laporan_evaluasi->kesimpulan_tambahan7)) : ?>
                                                <span style="text-transform: uppercase">Pilihan Awal:
                                                    <?= $laporan_evaluasi->kesimpulan_tambahan7 ?></span>
                                            <?php endif; ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen_tambahan7" id="sesuaiLuaranTambahan7" value="sesuai luaran" required>
                                                <label class="form-check-label" for="sesuaiLuaran">
                                                    Sesuai Luaran
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen_tambahan7" id="tidakSesuaiLuaranTambahan7" value="tidak sesuai">
                                                <label class="form-check-label" for="tidakSesuaiLuaran">
                                                    Tidak Sesuai Luaran
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">8</th>
                                        <td>Naskah akademik (policy brief, rekomendasi kebijakan atau model kebijakan
                                            strategis)</td>
                                        <td><?= $laporan_monev->komponen_keterangan_tambahan8 ?></td>
                                        <td><?= $laporan_monev->komponen_bobot_tambahan8 ?></td>
                                        <td><?= $laporan_monev->komponen_skor_tambahan8 ?></td>
                                        <td><?= $laporan_monev->komponen_nilai_tambahan8 ?></td>
                                        <?php if (isset($berkas->t_b8)) : ?>
                                            <td><a href="<?php echo base_url("assets/berkas/file_laporan/penelitian/") . $berkas->t_b8 ?>" target="_blank">Unduh</a></td>
                                        <?php else : ?>
                                            <td>Tidak Ada File</td>
                                        <?php endif; ?>
                                        <td>
                                            <?php if (isset($laporan_evaluasi->kesimpulan_tambahan8)) : ?>
                                                <span style="text-transform: uppercase">Pilihan Awal:
                                                    <?= $laporan_evaluasi->kesimpulan_tambahan8 ?></span>
                                            <?php endif; ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen_tambahan8" id="sesuaiLuaranTambahan8" value="sesuai luaran" required>
                                                <label class="form-check-label" for="sesuaiLuaran">
                                                    Sesuai Luaran
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesimpulan_komponen_tambahan8" id="tidakSesuaiLuaranTambahan8" value="tidak sesuai">
                                                <label class="form-check-label" for="tidakSesuaiLuaran">
                                                    Tidak Sesuai Luaran
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th scope="col">Total Nilai Luaran Wajib</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><?= $laporan_monev->total_nilai_wajib ?></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="my-4" style="font-size: 14px">
                                <p style="margin: 0; padding: 0;">Keterangan:</p>
                                <p style="margin: 0; padding: 0;">Skor: 1, 2, 3, 5, 6, 7 (1 = buruk, 2 = sangat kurang,
                                    3 = kurang, 5 = cukup, 6 = baik, 7 = sangat baik) Nilai : bobot × skor</p>
                                <p style="margin: 0; padding: 0;">Skor: 1, 2, 3, 5, 6, 7 (1: tidak ada draft; 3: draft;
                                    5: Submitted/reviewed/editing; 6: Accepted; 7: Terbit)</p>
                                <p style="margin: 0; padding: 0;">Luaran tambahan dinilai lebih lanjut. Kolom diisi
                                    sesuai dengan capaian</p>
                            </div>
                            <div class="form-group my-4">
                                <textarea class="form-control" id="masukan" name="masukan" rows="4" placeholder="Ketik Masukan Disini" required><?php if (isset($masukan->masukan_evaluasi)) : ?><?= $masukan->masukan_evaluasi ?><?php else : ?><?php endif; ?></textarea>
                            </div>
                        </div>
                        <?php if ($status->status == "1") : ?>
                            <button type="submit" class="btn btn-success">Edit Evaluasi</button>
                        <?php else : ?>
                            <button type="submit" class="btn btn-success">Submit Evaluasi</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>