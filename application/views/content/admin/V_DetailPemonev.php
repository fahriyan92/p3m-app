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
<section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title title_form"><?= $propos[0]->rvw; ?></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive">
                                <table id="tabelevent" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">N0</th>
                                            <th width="30%">Judul Proposal</th>
                                            <th width="30%">Ketua</th>
                                            <th width="15%">Tema</th>
                                            <th width="50%">Biaya</th>
                                            <th width="15%">Tahun Usulan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bodynya">
                                        <?php $no = 1;
                                        foreach ($propos as $key) : ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $key->judul ?></td>
                                                <td><?= $key->ketua ?></td>
                                                <td><?= $key->tema ?></td>
                                                <td><?= $key->biaya ?></td>
                                                <td><?= $key->tahun_usulan ?></td>
                                            </tr>
                                        <?php $no++;
                                        endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
</div>
</section>
</div>
<script>
    $('.table-bordered').DataTable();
    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>