<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $judul; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?= "" ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <?php if ($this->session->flashdata('key')) : ?>
            <div class="alert alert-<?= $this->session->flashdata('key') ?> alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata($this->session->flashdata('key')); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        <?php endif; ?>
        <?php //print_r($identitas) 
        ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="row">
                                <?php //row 
                                ?>
                                <form action="<?= $mode === 'tambah' ? site_url('pengajuan_mandiri_pengabdian/identitas_usulan/store') : site_url('pengajuan_mandiri_pengabdian/identitas_usulan/edit') ?>" method="post">

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputJudul">1. Bidang Fokus Penelitian</label><br>
                                            <?php foreach ($fokus as $fks) { ?>
                                                <input type="radio" name="fokus_penelitian" value="<?= $fks->id_fokus ?>" <?= set_radio('fokus_penelitian', $fks->id_fokus)  ?> <?= isset($identitas) ? $fks->id_fokus == $identitas->id_fokus ? 'checked' : '' : ''  ?>>
                                                <span class="text-capitalize" for="fokus_penelitian"><?= $fks->bidang_fokus ?></span><br>
                                            <?php } ?>
                                            <?= form_error('fokus_penelitian', '<h5 style="color:red;font-size: 16px;">', '</h5>'); ?>
                                        </div>
                                    </div>
                                    <?php //batas row 
                                    ?>
                            </div>

                            <?php //atas row 
                            ?>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputJudul">2. Tema Penelitian</label>

                                        <input type="text" value="<?= isset($identitas) ? set_value('tema_penelitian') == true ? set_value('tema_penelitian') : $identitas->tema : set_value('tema_penelitian') ?>" class="form-control" placeholder="Tema Penelitian" name="tema_penelitian">
                                        <?= form_error('tema_penelitian', '<h5 style="color:red;font-size: 16px;">', '</h5>'); ?>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputJudul">3. Sasaran Mitra (Jika Ada)</label>
                                        <input type="text" value="<?= isset($identitas) ? set_value('sasaran_penelitian') == true ? set_value('sasaran_penelitian') : $identitas->sasaran : set_value('sasaran_penelitian') ?>" class="form-control" id="inputSasaran" placeholder="Sasaran Penelitian" name="sasaran_penelitian">
                                    </div>
                                </div>
                            </div>
                            <?php //batas row 
                            ?>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputJudul">4. Judul Penelitian</label>
                                        <div class="err-judul" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <input type="text" value="<?= isset($identitas) ? set_value('judul_penelitian') == true ? set_value('judul_penelitian') : $identitas->judul : set_value('judul_penelitian') ?>" class="form-control" placeholder="Judul Penelitian" name="judul_penelitian">
                                        <?= form_error('judul_penelitian', '<h5 style="color:red;font-size: 16px;">', '</h5>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tahunPenelitianDosenPNBP">5. Tahun Usulan</label>
                                        <input type="number" value="<?= isset($identitas) ? set_value('tahun_penelitian') == true ? set_value('tahun_penelitian') : $identitas->tahun : set_value('tahun_penelitian') ?>" class="form-control" min="2020" max="2099" step="1" name="tahun_penelitian">
                                        <?= form_error('tahun_penelitian', '<h5 style="color:red;font-size: 16px;">', '</h5>'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tglmulai">6. Lama Penelitian (mulai)</label>
                                        <input type="date" value="<?= isset($identitas) ? set_value('tgl_mulai') == true ? set_value('tgl_mulai') : $identitas->mulai : set_value('tgl_mulai') ?>" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" placeholder="mulai" name="tgl_mulai">
                                        <?= form_error('tgl_mulai', '<h5 style="color:red;font-size: 16px;">', '</h5>'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-1" style="text-align: center; margin-top:36px">
                                    <span> - </span>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tglakhir">(akhir)</label>
                                        <input type="date" value="<?= isset($identitas) ? set_value('tgl_akhir') == true ? set_value('tgl_akhir') : $identitas->akhir : set_value('tgl_akhir') ?>" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" placeholder="akhir" name="tgl_akhir">
                                        <?= form_error('tgl_akhir', '<h5 style="color:red;font-size: 16px;">', '</h5>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="biaya_usulan">7. Biaya Usulan</label>
                                        <input type="text" value="<?= isset($identitas) ? set_value('biaya_diusulkan') == true ? set_value('biaya_diusulkan') : $identitas->biaya : set_value('biaya_diusulkan') ?>" class="form-control" id="biayadiusulkan" placeholder="100000" name="biaya_diusulkan">
                                        <?= form_error('biaya_diusulkan', '<h5 style="color:red;font-size: 16px;">', '</h5>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="target">8. Target Luaran</label><br>
                                        <div class="err-luaran" style="display:none;">
                                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                        </div>
                                        <label for="target">A. Wajib</label><br>
                                        <?php foreach ($luaran as $lr) { ?>
                                            <?php if ($lr->jenis_luaran == 1) : ?>
                                                <?php if (isset($luaran_checked)) : ?>
                                                    <?php if (isset($luaran_validasi)) :  ?>
                                                        <input type="checkbox" name="luaran[]" value="<?= $lr->id_luaran ?>" <?= isset($luaran_validasi) ? in_array($lr->id_luaran, $luaran_validasi) ? 'checked' : '' : '' ?>>
                                                        <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>
                                                    <?php else : ?>
                                                        <input type="checkbox" name="luaran[]" value="<?= $lr->id_luaran ?>" <?= in_array($lr->id_luaran, $luaran_checked) ? 'checked' : '' ?>>
                                                        <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>

                                                    <?php endif; ?>

                                                <?php else : ?>
                                                    <input type="checkbox" name="luaran[]" value="<?= $lr->id_luaran ?>" <?= isset($luaran_validasi) ? in_array($lr->id_luaran, $luaran_validasi) ? 'checked' : '' : '' ?>>
                                                    <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                        <?php } ?>

                                        <label for="target">B. Tambahan</label><br>
                                        <?php foreach ($luaran as $lr) { ?>
                                            <?php if ($lr->jenis_luaran == 2) : ?>
                                                <?php if (isset($luaran_checked)) : ?>
                                                    <?php if (isset($luaran_validasi)) :  ?>
                                                        <input type="checkbox" name="luaran[]" value="<?= $lr->id_luaran ?>" <?= isset($luaran_validasi) ? in_array($lr->id_luaran, $luaran_validasi) ? 'checked' : '' : '' ?>>
                                                        <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>
                                                    <?php else : ?>
                                                        <input type="checkbox" name="luaran[]" value="<?= $lr->id_luaran ?>" <?= in_array($lr->id_luaran, $luaran_checked) ? 'checked' : '' ?>>
                                                        <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>

                                                    <?php endif; ?>

                                                <?php else : ?>
                                                    <input type="checkbox" name="luaran[]" value="<?= $lr->id_luaran ?>" <?= isset($luaran_validasi) ? in_array($lr->id_luaran, $luaran_validasi) ? 'checked' : '' : '' ?>>
                                                    <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                        <?php } ?>
                                        <?= form_error('luaran', '<h5 style="color:red;font-size: 16px;">', '</h5>'); ?>
                                        <?php if (isset($luaran_tambahan)) { ?>
                                            <div class="row" style="padding-left: 8px; padding-top: 8px;">

                                                <span style="padding-top: 5px; padding-left:3px;" for="luaran11"> Lainnya</span><br>
                                                <div class="col-sm-6 tambahan_luaran">
                                                    <input type="text" class="form-control" id="luaran12" value="<?= $luaran_tambahan->judul_luaran_tambahan ?>" name="tambahan_luaran">
                                                </div>
                                            </div>

                                        <?php } else { ?>
                                            <div class="row" style="padding-left: 8px; padding-top: 4px;">

                                                <div class="col-sm-6 tambahan_luaran">
                                                    <input type="text" value="" class="form-control" id="" placeholder="Lainnya (Opsional)" name="luaran_tambahan">
                                                </div>
                                            </div>

                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="statusTKT">9. Ringkasan Usulan (max. 500 kata)</label>
                                        <?= form_error('ringkasan', '<h5 style="color:red;font-size: 16px;">', '</h5>'); ?>
                                        <textarea value="" class="form-control" id="ringkasan" name="ringkasan" rows="4"><?= isset($dokumen) ? set_value('ringkasan') == true ? set_value('ringkasan') : $dokumen->ringkasan : set_value('ringkasan') ?></textarea>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="statusTKT">10. Tinjauan Pustaka (max. 1000 kata)</label>
                                        <?= form_error('tinjauan', '<h5 style="color:red;font-size: 16px;">', '</h5>'); ?>
                                        <textarea value="" class="form-control" id="tinjauan" name="tinjauan" rows="4"><?= isset($dokumen) ? set_value('tinjauan') == true ? set_value('tinjauan') : $dokumen->tinjauan : set_value('tinjauan') ?></textarea>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="statusTKT">11. Metode (max. 600 kata)</label>
                                        <?= form_error('metode', '<h5 style="color:red;font-size: 16px;">', '</h5>'); ?>
                                        <textarea value="" class="form-control" name="metode" rows="4"><?= isset($dokumen) ? set_value('metode') == true ? set_value('metode') : $dokumen->metode : set_value('metode') ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-right">
                                    <button type="submit" class="btn btn-<?= $mode === 'edit' ? 'warning' : 'success' ?>"><?= $mode === 'edit' ? 'Edit' : 'Simpan' ?></button>
                                </div>
                            </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script>

</script>