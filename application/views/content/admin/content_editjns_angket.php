<script src="<?php echo base_url('assets'); ?>/plugins/select2/js/select2.full.min.js"></script>
<style>
    .table-condensed>thead>tr>th,
    .table-condensed>tbody>tr>th,
    .table-condensed>tfoot>tr>th,
    .table-condensed>thead>tr>td,
    .table-condensed>tbody>tr>td,
    .table-condensed>tfoot>tr>td {
        padding: 1px;
    }

    .table_morecondensed>thead>tr>th,
    .table_morecondensed>tbody>tr>th,
    .table_morecondensed>tfoot>tr>th,
    .table_morecondensed>thead>tr>td,
    .table_morecondensed>tbody>tr>td,
    .table_morecondensed>tfoot>tr>td {
        padding: 1px;
    }
</style>
<style>
    .select2-selection__rendered {
        line-height: 31px !important;
    }

    .select2-container .select2-selection--single {
        height: 35px !important;
    }

    .select2-selection__arrow {
        height: 34px !important;
    }

    #prevBtn {
        background-color: #dc3545;
    }
</style>
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
            <div class="row notif">
                <!-- <div class="col-12 alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                sukses ya
            </div> -->
            </div>
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title title_form">Edit Jenis Soal Kriteria</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- /.form-group -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="soalangket">Jenis Soal Kriteria</label>
                                    <input type="text" class="form-control" id="jns" placeholder="Pilihan Ganda" name="jns" value="<?= $jns->nm_jenis_soal; ?>">
                                </div>
                                <div class="err-nim" style="display:none;">
                                    <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="bobotjns">Bobot</label>
                                    <input class="form-control" id="bobotjns" name="bobotjns" value="<?= $jns->bobot; ?>"></input>
                                </div>
                                <div class="err-nim" style="display:none;">
                                    <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="status">Status Kriteria</label>
                                    <select class="form-control select2" style="width: 100%;" name="status" id="status">
                                        <option value="1" <?php if ($jns->status == 1) {
                                                                echo "selected";
                                                            } ?>>Aktif</option>
                                        <option value="0" <?php if ($jns->status == 0) {
                                                                echo "selected";
                                                            } ?>>Non-Aktif</option>
                                    </select>
                                </div>
                                <div class="err-nim" style="display:none;">
                                    <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <button type="submit" id="simpan-btn" class="btn btn-block btn-primary">Simpan</button>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<script>
    function swal_alert(title, data, type) {
        Swal.fire({
            title: title,
            text: data,
            type: type,
        });
    }
    var soal = <?= $idSoal; ?>;
    $("#simpan-btn").on("click", function(e) {
        e.preventDefault();
        // console.log($("input[name='status']:checked").val());

        $("#overlay").fadeIn(100);
        $.ajax({
            url: `${BASE_URL}C_penilai/update_jnskriteria`,
            type: "post",
            data: {
                jns: $("input[name=jns]").val(),
                status: $("select[name='status']").val(),
                bobot: $("input[name=bobotjns]").val(),
                id: soal,
            },
            dataType: "json",
            success: function(res) {
                let title = "Berhasil!";
                let status = "success";
                console.log(res);
                if (res.code != 1) {
                    title = "Gagal!";
                    status = "error";
                }
                setTimeout(function() {
                    window.location.replace(`${BASE_URL}C_penilai`);
                }, 400);
                swal_alert(title, res.pesan, status);
            },
        });
    });
    $(window).on("load", function() {

        $('#overlay').fadeOut(400);
    });
</script>