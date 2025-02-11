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
                                <select class="form-control select2" style="width: 100%;" name="jnsSoal" id="jnsSoal" disabled>
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
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="soalangket">Soal Kriteria</label>
                                <textarea class="form-control" id="soal" name="soal1" readonly> <?= $dataSoal[0]->soal ?></textarea>
                            </div>
                            <div class="err-nim" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahPilihan"><i class="fa fa-plus"></i> Tambah Pilihan</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="tabelevent" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="10%">Pilihan</th>
                                    <th width="50%">Isi Pilihan</th>
                                    <th width="15%">Bobot</th>
                                    <?php if ($event[0]->id_event == 2) : ?>
                                        <th width="10%">Prosentase</th>
                                    <?php endif; ?>
                                    <th width="10%">Status</th>
                                    <th width="5%">Edit</th>
                                </tr>
                            </thead>
                            <tbody class="bodynya">
                                <?php $no = 1;
                                if ($event[0]->id_event == 2) :
                                    foreach ($pilihan as $key) : ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $key->deskripsi_pilihan; ?></td>
                                            <td><?= $key->score; ?></td>
                                            <td><?= $key->prosentase; ?></td>
                                            <td><?php if ($key->status == 1) {
                                                    echo "<button class='btn btn-success'>aktif</button>";
                                                } else {
                                                    echo "<button class='btn btn-danger'>non-aktif</button>";
                                                } ?></td>
                                            <td><a href="#" id="<?= $key->id_pilihan ?>" class="btn btn-primary detailSoal"><i class="fas fa-fw fa-edit"></i></a></td>
                                        </tr>
                                    <?php $no++;
                                    endforeach;
                                else :
                                    ?>
                                    <?php $no = 1;
                                    foreach ($pilihan as $key) : ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $key->deskripsi_pilihan; ?></td>
                                            <td><?= $key->score; ?></td>
                                            <td><?php if ($key->status == 1) {
                                                    echo "<button class='btn btn-success'>aktif</button>";
                                                } else {
                                                    echo "<button class='btn btn-danger'>non-aktif</button>";
                                                } ?></td>
                                            <td><a href="#" id="<?= $key->id_pilihan ?>" class="btn btn-primary detailSoal"><i class="fas fa-fw fa-edit"></i></a></td>
                                        </tr>
                                <?php $no++;
                                    endforeach;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>


<div class="modal fade" id="modal-edit-detailsoal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="">

                <div class="modal-header">
                    <h4 class="modal-title">Edit Pilihan Soal Kriteria</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pilihan1">Pilihan Ganda</label>
                                <input type="text" class="form-control" id="pilihan1" placeholder="Pilihan Ganda" name="pilihan1" value="">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="id_list">
                                <label for="bobot1">Bobot</label>
                                <input type="text" class="form-control" id="bobot1" placeholder="Bobot" name="bobot1" value="">
                            </div>
                        </div>
                        <?php if ($event[0]->id_event == 2) : ?>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="prosentase">Prosentase</label>
                                    <input type="number" class="form-control" id="prosentase" placeholder="Prosentase(%)" name="prosentase" value="">
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-sm-2" style="margin-top: 20px;">
                            <div class="form-group">
                                <input type="radio" id="male" name="gender" value="1">
                                <label for="male">Aktif</label><br>
                                <input type="radio" id="female" name="gender" value="0">
                                <label for="female">Non-Aktif</label><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" id="simpanpilihan-btn" class="btn btn-primary" value="Simpan">
                </div>

            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalTambahPilihan">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="">

                <div class="modal-header">
                    <h4 class="modal-title">Tambah Pilihan Soal Kriteria</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pilihan1">Pilihan Ganda</label>
                                <input type="text" class="form-control" id="pilihan2" placeholder="Pilihan Ganda" name="pilihan2" value="">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <!-- <input type="hidden" class="form-control" id="id_list"> -->
                                <label for="bobot1">Bobot</label>
                                <input type="text" class="form-control" id="bobot2" placeholder="Bobot" name="bobot2" value="">
                            </div>
                        </div>
                        <?php if ($event[0]->id_event == 2) : ?>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="prosentase2">Prosentase</label>
                                    <input type="number" class="form-control" id="prosentase2" placeholder="Prosentase(%)" name="prosentase2" value="">
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" id="tambahpilihan-btn" class="btn btn-primary" value="Simpan">
                </div>

            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<script>
    const get_by_id = id => new Promise((resolve, reject) => {
        $.ajax({
            url: `${BASE_URL}C_penilai/pilihanById`,
            type: 'POST',
            data: id,
            dataType: 'json',
            success: res => resolve(res)
        })
    });

    $(document).ready(function() {
        $('.detailSoal').on('click', function(e) {
            e.preventDefault();
            get_by_id({
                id: this.id
            }).then(res => {
                siapkanEdit(res);
            })
        });
        const siapkanEdit = function(data) {
            $('#modal-edit-detailsoal').modal('show');
            $(`input[name="pilihan1"]`).val(data.deskripsi_pilihan);
            $('#id_list').val(data.id_pilihan);
            $('input[name="bobot1"]').val(data.score);
            $('input[name="prosentase"]').val(data.prosentase);
            $(`input[type="radio"][value="${data.status}"]`).trigger('click');
        };
    });

    function swal_alert(title, data, type) {
        Swal.fire({
            title: title,
            text: data,
            type: type,
        });
    }
    $("#tambahpilihan-btn").on("click", function(e) {
        var currentUrl = window.location.pathname;

        var pathArray = window.location.pathname.split('/');
        // var idSoal = pathArray[4];
        var idSoal = pathArray[pathArray.length - 1];
        // console.log(idSoal);

        e.preventDefault();
        $("#overlay").fadeIn(100);
        $.ajax({
            url: `${BASE_URL}C_penilai/add_pilihan`,
            type: "post",
            data: {
                pilihan: $("input[name='pilihan2']").val(),
                bobot: $("input[name='bobot2']").val(),
                persen: $("input[name='prosentase2']").val(),
                id: idSoal,
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
                    window.location.replace(currentUrl);
                }, 400);
                swal_alert(title, res.pesan, status);
            },
        });
    });

    $("#simpanpilihan-btn").on("click", function(e) {
        var currentUrl = window.location.pathname;

        var pathArray = window.location.pathname.split('/');
        // var idSoal = pathArray[4];
        var idSoal = pathArray[pathArray.length - 1];
        // console.log(idSoal);

        e.preventDefault();
        $("#overlay").fadeIn(100);
        $.ajax({
            url: `${BASE_URL}C_penilai/update_pilihan`,
            type: "post",
            data: {
                pilihan: $("input[name='pilihan1']").val(),
                bobot: $("input[name='bobot1']").val(),
                persen: $("input[name='prosentase']").val(),
                gender: $("input[name='gender']:checked").val(),
                idSoal: idSoal,
                id: $("#id_list").val(),
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
                    window.location.replace(currentUrl);
                }, 400);
                swal_alert(title, res.pesan, status);
            },
        });
    });
    $('.table-bordered').DataTable();
    $(window).on("load", function() {

        $('#overlay').fadeOut(400);
    });
</script>