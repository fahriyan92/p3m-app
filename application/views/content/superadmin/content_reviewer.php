<script src="<?php echo base_url('assets'); ?>/plugins/select2/js/select2.full.min.js"></script>
<script src="<?= base_url() . JS_UMUM; ?>staff_reviewer.js?random=<?= uniqid(); ?>"></script>
<link rel="stylesheet" href="<?= base_url() . CSS_CUSTOM; ?>cssloader.css?random=<?= uniqid(); ?>">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Reviewer</h1>
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
            <div class="card card-default">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-9 col-md-8 col-sm-2">
                            <h3>Daftar Reviewer</h3>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Tab panes -->
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>NIP</th>
                                    <th>Nama Reviewer</th>
                                    <th>Jurusan</th>
                                    <th>Jumlah Proposal</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($rvwr)) : ?>
                                    <?php foreach ($rvwr->result_array() as $re) : ?>
                                        <tr>
                                            <td><?= $re['nidn'] ?></td>
                                            <td><?= $re['nama'] ?></td>
                                            <td><?= $re['unit'] ?></td>
                                            <td><?= $re['count'] ?></td>
                                            <td>
                                                <a href="<?= base_url("C_reviewer/detailReviewer/") . $re['id_reviewer'] ?>" class="btn btn-success"><i class="fa fa-users"></i></a>
                                            </td>

                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>NIP</th>
                                    <th>Nama Reviewer</th>
                                    <th>Jurusan</th>
                                    <th>Jumlah Proposal</th>
                                    <th>Detail</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" style="overflow:hidden;">
    <div class="modal-dialog">
        <!-- /.Loader -->
        <span id="loading"></span>

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pilih Reviewer</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Judul Proposal</label>
                    <input type="text" class="form-control" id="judul" disabled>
                </div>

                <div class="form-group">
                    <label>NIP Ketua</label>
                    <input type="text" class="form-control" id="ketua" disabled>
                    <input type="hidden" class="form-control" id="id_proposal" disabled>

                </div>
                <hr>
                <br>
                <div class="form-group">
                    <label for="reviewer1">Reviewer 1</label>
                    <select class="form-control select2" style="width: 100%;" id="reviewer1" name="reviewer">
                        <option value="">-- Cari Reviewer --</option>


                        <?php foreach ($dosen->result() as $d) { ?>
                            <option value="<?= $d->NIDSN ?>"><?= $d->nama_dosen ?></option>

                        <?php } ?>
                    </select>
                </div>
                <div class="form-group2">
                    <label for="reviewer2">Reviewer 2</label>
                    <select class="form-control select2" style="width: 100%;" id="reviewer2" name="reviewer">
                        <option value="">-- Cari Reviewer --</option>


                        <?php foreach ($dosen->result() as $d) { ?>
                            <option value="<?= $d->NIDSN ?>"><?= $d->nama_dosen ?></option>

                        <?php } ?>
                    </select>
                </div>
                <div class="append-group"></div>
                <div class="row" style="margin: 20px;">
                    <div class="col-md-6">
                        <input type="button" id="addButton" class="btn btn-success" value="Tambah Reviewer">
                    </div>
                    <div class="col-md-6">
                        <input type="button" id="removeButton" class="btn btn-danger" value="Hapus Reviewer">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-success" id="clicker" value="Submit">
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        var counter = 3;

        $("#addButton").click(function() {

            if (counter > 99) {
                alert("Batas maksimal tercapai!");
                return false;
            }

            var newSelectDiv = $(document.createElement('div'))
                .attr("class", 'form-group' + counter);

            newSelectDiv.after().html('<label>Reviewer ' + counter + '</label>' +
                '<select class="form-control select2" style="width: 100%;" name="review' + counter +
                '" id="mySelect' + counter + '"><option selected="selected">Dosen A</option>' +
                '<option>Dosen B</option>' +
                '<option>Dosen C</option>' +
                '<option>Dosen D</option>' +
                '<option>Dosen E</option>' +
                '</select>');

            newSelectDiv.appendTo(".append-group");


            counter++;
        });

        $("#removeButton").click(function() {
            if (counter == 3) {
                alert("Batas minimum jumlah reviewer tercapai!");
                return false;
            }

            counter--;

            $(".form-group" + counter).remove();

        });
    });

    $('.modal').css('overflow-y', 'auto');
</script>