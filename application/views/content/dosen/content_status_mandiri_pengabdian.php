
<link rel="stylesheet" href="<?= base_url() . CSS_CUSTOM; ?>form_wizard.css?random=<?= uniqid(); ?>">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
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
                        <li class="breadcrumb-item"><?= $brdcrmb; ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->

    <section class="content pb-3">
            <div class="container-fluid">
                <!-- /.card -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">

                                        <h3 class="card-title">Status Pengusulan</h3>
                                    </div>
          

                                </div>
                            </div>
                            <div class="card-body">
                               
                                <?php if($informasi['status'] == 8): ?>
                                    <?php  if($informasi['status_koreksi'] == 0 || $informasi['status_koreksi'] == 2): ?>
                                        <div class="row">
                                            <table id="example1" align="right" class="table table-bordered center">
                                                <thead>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Status Pengusulan</td>
                                                        <td><b>Menunggu Respon  Admin</b></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- <div class="">
                                                    <a href="#" class="btn btn-danger">Batalkan Pengajuan</a>
                                                </div> -->
                                            </div>
                                        </div>                                        

                                    <?php endif; ?>

                                    <?php if($informasi['status_koreksi'] == 2): ?>

                                        

                                    <?php endif; ?>

                                    
                                <?php else: ?>
                                    <?php if($informasi['status'] == 7 && $informasi['status_koreksi'] == 2): ?>
                                    
                                        <div class="row">
                                            <table id="example1" align="right" class="table table-bordered center">
                                                <thead>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Status Pengusulan</td>
                                                        <td><b>Pengajuan Anda Mendapat Revisi</b></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>                                    
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="">
                                                    <a href="<?= site_url('C_pengabdian_dsn_mandiri/mandiri_pengajuan_pengabdian')?>" class="btn btn-warning">Revisi Pengajuan</a>
                                                </div>
                                            </div>
                                        </div>


                                    <?php else:  ?>
                                    <div class="row">
                                        <table id="example1" align="right" class="table table-bordered center">
                                            <thead>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Status Pengusulan</td>
                                                    <td>
                                                        <?= $informasi['status_pengusulan'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Buat</td>
                                                    <td>
                                                    <?= $informasi['create'] ?>
                                                    </td>
                                                </tr>                                            
                                                <tr>
                                                    <td>Terakhir Diubah</td>
                                                    <td>
                                                        <?= $informasi['update'] ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="">
                                            <a href="<?= site_url('C_pengabdian_dsn_mandiri/mandiri_pengajuan_pengabdian')?>" class="btn btn-primary"><?= $informasi['tombol'] == 0 ? 'Tambahkan Pengajuan' : 'Edit/Finalinasi Pengajuan' ?></a>
                                        </div>
                                    </div>
                                  </div>

                                    <?php endif; ?>


                                  
                                <?php endif; ?>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">List Proposal Anda <span class="titelnya"></span></h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item mr-2" style="width: 130px;" ><label>Tahun <input id="select_tahun"  type="text" class="form-control"></label></li>
                </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive">
                                <table id="table-proposal" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="20%">Judul</th>
                                            <th width="20%">Status</th>
                                            <th width="20%">Lihat</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bodynya">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td colspan="4">Menuggu Data..</td>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script>
    const get_data = function(){
        const tahun = $("#select_tahun").val();
        return new Promise(function(resolve,reject){
            $.ajax({
                url: `${BASE_URL}c_pengabdian_dsn_mandiri/list_prop_mpengabdian/${tahun}`,
                type: "get",
                dataType: 'json',
                success: (res) => resolve(res),
            });
        });
    };

    const change_title = function(){
        const tahun = $("#select_tahun").val();

        const text = `Tahun ${tahun}`;
        $(".titelnya").text(text);
    };

    const fill_table = function(){
        $('#table-proposal').DataTable().clear().destroy();
        change_title();
        get_data().then(function(res){
            if(res.length !== 0){
            let no = 1;
            let html = '';

            res.forEach(item => {
                html += `
                <tr>
                    <td>${no}.</td>
                    <td class="text-capitalize">${item.judul}</td>
                    <td class="text-uppercase">${item.status_koreksi == 1 ? 'Pengajuan Diterima' : 'Pengajuan Belum Direspon'}</td>
                    <td><a href="<?= site_url('C_pengabdian_dsn_mandiri/view_pengajuan/')?>${item.id_detail}" class="btn btn-xs btn-danger"> <i class="fa fa-paste"></i></a></td>
                </tr>
                `;
                no++;
            });
                $('.bodynya').html(html);
              
            } 
                $('#table-proposal').DataTable({ "language": {
                "emptyTable": "Tidak Ada Proposal"
                }
            });

    });
    }

    $(document).ready(function(){
        $("#select_tahun").datepicker({
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years",
            orientation: "bottom",
        }).datepicker('setDate',"<?= date('Y'); ?>");

        fill_table();

        $("#select_tahun").on("change",function(){
            fill_table();
        });
    });
    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>