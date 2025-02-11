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
            </div>
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title title_form">Edit Soal Kriteria</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- /.form-group -->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="jnsSoal">Jenis Soal Kriteria</label>
                                <select class="form-control select2" style="width: 100%;" name="jnsSoal" id="jnsSoal">
                                    <option value="">-Pilih Jenis-</option>
                                    <?php foreach ($jns as $key) { ?>
                                        <option value='<?= $key->id_jenis_soal ?>' <?php if ($key->id_jenis_soal == $dataSoal[0]->id_jenis_soal) {
                                                                                        echo "selected";
                                                                                    } ?>><?= $key->nm_jenis_soal ?> - <?= $key->nm_event ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="err-nim" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="status">Status Kriteria</label>
                                <select class="form-control select2" style="width: 100%;" name="status" id="status">
                                    <option value="1" <?php if ($dataSoal[0]->status == 1) {
                                                            echo "selected";
                                                        } ?>>Aktif</option>
                                    <option value="0" <?php if ($dataSoal[0]->status == 0) {
                                                            echo "selected";
                                                        } ?>>Non-Aktif</option>
                                </select>
                            </div>
                            <div class="err-nim" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="soalangket">Soal Kriteria</label>
                                <textarea class="form-control" id="soal" name="soal1"> <?= $dataSoal[0]->soal ?></textarea>
                            </div>
                            <div class="err-nim" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                    <input type="submit" id="update-kriteria" class="btn btn-primary" value="Update">
                </div>
            </div>
            <!-- /.card -->
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
    $("#update-kriteria").on("click", function(e) {
        e.preventDefault();
        // console.log($("input[name='status']:checked").val());

        $("#overlay").fadeIn(100);
        $.ajax({
            url: `${BASE_URL}C_penilai/update_kriteria`,
            type: "post",
            data: {
                jnsSoal: $("select[name=jnsSoal]").val(),
                status: $("select[name='status']").val(),
                soal: $("textarea[name=soal1]").val(),
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

    $(document).ready(function() {

        var counter = 1;

        $("#addsoal").click(function() {

            // if (counter > 1) {
            //     alert("Cuma Boleh 2 Mahasiswa");
            //     return false;
            // }

            var newSelectDiv = $(document.createElement('div'))
                .attr("id", 'append' + counter);

            newSelectDiv.after().html(`<hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="soalangket">Soal Kriteria ${counter +1}</label>
                                        <textarea class="form-control" id="soal${counter +1}" name="soal${counter +1}" value=""></textarea>
                                    </div>
                                    <div class="err-nim" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div> 
                                </div>
                            </div>
                            <div class="append-group${counter +1}"></div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="mahasiswa1">Pilihan Ganda ${counter +1}</label>
                                        <input type="text" class="form-control" id="nm_mhs${counter +1}" placeholder="Pilihan Ganda" name="nm_mhs${counter +1}" value="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="prodi1">Bobot</label>
                                        <input type="text" class="form-control" id="prodi${counter +1}" placeholder="Bobot" name="prodi${counter +1}" value="">
                                    </div>
                                </div>
                                <div class="col-sm-4" style="margin-top: 31px;">
                                    <input type="button" id="addpilihan" class="btn btn-success" value="+">
                                    <input type="button" id="removepilihan" class="btn btn-danger" value="x">
                                </div>
                            </div>`);

            newSelectDiv.appendTo(".append-group");

            counter++;
        });

        $("#addpilihan").click(function() {

            var newSelectDiv = $(document.createElement('div'))
                .attr("id", 'append' + counter);

            newSelectDiv.after().html(`
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="mahasiswa1">Pilihan Ganda ${counter +1}</label>
                            <input type="text" class="form-control" id="nm_mhs${counter +1}" placeholder="Pilihan Ganda" name="nm_mhs${counter +1}" value="">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="prodi1">Bobot</label>
                            <input type="text" class="form-control" id="prodi${counter +1}" placeholder="Bobot" name="prodi${counter +1}" value="">
                        </div>
                    </div>
                    <div class="col-sm-4" style="margin-top: 31px;">
                        <input type="button" id="addpilihan" class="btn btn-success" value="+">
                        <input type="button" id="removepilihan" class="btn btn-danger" value="x">
                    </div>
                </div>`);

            newSelectDiv.appendTo(".append-group");

            counter++;
        });

        $("#removesoal").click(function() {
            if (counter == 1) {
                alert("Minimal 1 Soal Angket");
                return false;
            }

            counter--;

            $("#append" + counter).remove();

        });
    });
    // data dosen

    $('.select2').select2();

    $('.table-bordered').DataTable();
    $(window).on("load", function() {

        $('#overlay').fadeOut(400);
    });
</script>