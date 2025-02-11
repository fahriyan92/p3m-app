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
                        <li class="breadcrumb-item"><?= $brdcrmb; ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    <h5>Penelitian Dosen</h5>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- text input -->
                    <?php if (!empty($dt_proposal)) : ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputJudul">Judul</label>
                                    <input type="text" class="form-control" id="inputJudul" placeholder="Judul Penelitian" value="<?= $dt_proposal->judul; ?>" name="judulPenelitianDosenPNBP" disabled>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="jnsproposal">Jenis Pengajuan Proposal</label><br>
                                    <div class="err-fokus" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div>
                                    <?php foreach ($kelompok as $key) { ?>
                                        <input type="radio" name="jnsproposal" <?= (empty($dt_proposal) !== true ? $key->id_kelompok_pengajuan == $dt_proposal->id_kelompok_pengajuan ? 'checked' : '' : '') ?> value="<?= $key->id_kelompok_pengajuan ?>">
                                        <span class="text-capitalize" for="jnsproposal"><?= $key->nama_kelompok ?></span><br>
                                    <?php } ?>
                                </div>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="tahunPenelitianDosenPNBP">Tahun Usulan</label>
                                    <input type="number" class="form-control" min="1900" max="2099" step="1" value="<?= $dt_proposal->tahun_usulan; ?>" id="tahunPenelitianDosenPNBP" name="tahunPenelitianDosenPNBP" disabled>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="tglmulai">Lama Penelitian (mulai)</label>
                                    <input type="date" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" id="tglmulai" placeholder="mulai" name="tglmulai" value="<?= $dt_proposal->mulai; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-sm-1" style="text-align: center; margin-top:36px">
                                <span> - </span>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="tglakhir">(akhir)</label>
                                    <input type="date" class="form-control" id="tglakhir" data-inputmask-inputformat="dd/mm/yyyy" placeholder="akhir" name="tglakhir" value="<?= $dt_proposal->akhir; ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="biayadiusulkan">Biaya yang diusulkan</label>
                                    <input type="text" class="form-control" id="biayadiusulkan" value="<?= rupiah($dt_proposal->biaya_usulan); ?>" placeholder="Rp.8.500.000,-" name="biayadiusulkan" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="target">10. Target Luaran</label><br>
                                    <div class="err-luaran" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div>
                                    <label for="target">A. Wajib</label><br>
                                    <?php foreach ($luaran as $lr) { ?>
                                        <?php if ($lr->jenis_luaran == 1) : ?>
                                            <input type="checkbox" id="luaran1" name="luaran[]" <?= (empty($dt_proposal) !== true ? (in_array($lr->id_luaran, $luaran_checked) ? 'checked' : '') : '') ?> value="<?= $lr->id_luaran ?>">
                                            <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>
                                        <?php endif; ?>
                                    <?php } ?>

                                    <label for="target">B. Tambahan</label><br>
                                    <?php foreach ($luaran as $lr) { ?>
                                        <?php if ($lr->jenis_luaran == 2) : ?>
                                            <input type="checkbox" id="luaran1" name="luaran[]" <?= (empty($dt_proposal) !== true ? (in_array($lr->id_luaran, $luaran_checked) ? 'checked' : '') : '') ?> value="<?= $lr->id_luaran ?>">
                                            <span for="luaran1"> <?= $lr->judul_luaran ?></span><br>
                                        <?php endif; ?>
                                    <?php } ?>
                                    <?php if ($luaran_tambahan !== null) { ?>
                                        <div class="row" style="padding-left: 8px; padding-top: 8px;">
                                            <input type="checkbox" id="luaran12" name="luaran_tambahan" checked value="">
                                            <span style="padding-top: 5px; padding-left:3px;" for="luaran11"> Lainnya</span><br>
                                            <div class="col-sm-6 tambahan_luaran">
                                                <input type="text" class="form-control" id="luaran12" value="<?= $luaran_tambahan->judul ?>" disabled name="tambahan_luaran">
                                            </div>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="inputJudul">Ketua</label>
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input class="form-control text-capitalize" type="text" value="<?= $dt_proposal->nama_ketua ?>">
                            </div>
                            <div class="form-group">
                                <label for="">NIDN</label>
                                <input class="form-control" type="text" value="<?= $dt_proposal->nidn_ketua ?>">
                            </div>
                        </div>

                        <br>

                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <a data-id-proposal="<?= $dt_proposal->id_pengajuan ?>" data-tmbl="2" href="#" class="btn btn-sm btn-success tombol_terima_mandiri ml-2" style="margin: auto; width:auto; float:right;"> <i class="fa fa-paste"></i> Terima Permintaan</a>
                                <a data-id-proposal="<?= $dt_proposal->id_pengajuan ?>" data-tmbl="0" href="#" class="btn btn-sm btn-danger tombol_tolak_mandiri" style="margin: auto; width:auto; float:right;"> <i class="fa fa-paste"></i> Tolak Permintaan</a>
                            </div>
                        </div>
                    <?php else :  ?>
                        <h3>maaf, proposal tidak ada</h3>
                    <?php endif ?>
                </div>
                <!-- /.row -->
            </div>
            <br>
        </div><!-- /.container-fluid -->
    </section>
</div>
<script>
    $('.table-bordered').DataTable();

    function swal_alert(data) {

        Swal.fire({
            title: 'Data',
            text: data,
            type: 'success'
        });
    }
    $('.tombol_terima_mandiri').on('click', function(e) {
        $('#overlay').fadeIn(300);
        e.preventDefault();


        const idnya = $('.tombol_terima_mandiri').data('id-proposal');
        const status = $('.tombol_terima_mandiri').data('tmbl');
        // console.log(status);

        $.ajax({
            url: `${BASE_URL}C_dashboard/tombol_permintaan_mandiri`,
            method: "POST",
            data: {
                id_proposal: idnya,
                status: status
            },
            dataType: "json",
            success: function(data) {

                console.log(data);

                if (data[1].code === 1) {
                    $('#overlay').fadeOut(400);

                    swal_alert(data[1].pesan);
                    window.location.replace(`${BASE_URL}C_dashboard`);

                } else {
                    $('#overlay').fadeOut(400);

                    swal_alert(data[1].pesan);
                }


            }
        });

    });

    $('.tombol_tolak_mandiri').on('click', function(e) {
        $('#overlay').fadeIn(300);
        e.preventDefault();

        const idnya = $('.tombol_tolak_mandiri').data('id-proposal');
        const status = $('.tombol_tolak_mandiri').data('tmbl');
        // console.log(status);

        $.ajax({
            url: `${BASE_URL}C_dashboard/tombol_permintaan_mandiri`,
            method: "POST",
            data: {
                id_proposal: idnya,
                status: status
            },
            dataType: "json",
            success: function(data) {
                $('#overlay').fadeOut(400);
                console.log(data);

                if (data[1].code === 1) {
                    $('#overlay').fadeOut(400);
                    swal_alert(data[1].pesan);
                    window.location.replace(`${BASE_URL}C_dashboard`);
                } else {
                    $('#overlay').fadeOut(400);
                    swal_alert(data[1].pesan);
                }

            }
        });

    });



    $(window).on("load", function() {
        $('#overlay').fadeOut(400);


    });
</script>
<!-- /.content -->