<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
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
            <div class="card">
            <div class="card-header d-flex p-0">
              <h3 class="card-title p-3">List Dosen Pemonev <span class="titelnya"></span></h3>
              <ul class="nav nav-pills ml-auto p-2">
                <li class="nav-item mr-2" style="width: 130px;" ><label>Tahun <input id="select_tahun"  type="text" class="form-control"></label></li>
              </ul>
            </div><!-- /.card-header -->

                <!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive">
                                <table id="tabelevent" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="20%">NIP</th>
                                            <th width="50%">Nama Dosen</th>
                                            <th width="15%">Proposal Direview</th>
                                            <th width="15%">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bodynya">
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
<!-- /.content -->
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script>
    const get_data = function(){
        const tahun = $("#select_tahun").val();
        return new Promise(function(resolve,reject){
            $.ajax({
                url: `${BASE_URL}C_Pemonev/list_dosen_pemonev/${tahun}`,
                type: "get",
                dataType: 'json',
                success: (res) => resolve(res),
            });
        });
    };

    const fill_table = function(){
        $('.table-bordered').DataTable().clear().destroy();
        change_title();
        get_data().then(function(res){
            if(res.length !== 0){
            let no = 1;
            let html = '';

            res.forEach(item => {
                html += `
                <tr>
                    <td>${item.nidn}</td>
                    <td>${item.nama}</td>
                    ${item.total != '0' ? `<td>${item.total}</td><td><a class='btn btn-sm btn-primary' href='<?= base_url('C_Pemonev/proposalPemonev/') ?>${item.id_pemonev}'><i class="fas fa-fw fa-eye"></i></a></td>` : `<td colspan="2">Data Kosong</td>` }
                </tr>
                `;
                no++;
            });

                $('.bodynya').html(html);
            }

                $('.table-bordered').DataTable({ "language": {
                "emptyTable": "Tidak Ada Data"
                }
            });
    });
    }

    const change_title = function(){
        const tahun = $("#select_tahun").val();

        const text = `Tahun ${tahun}`;
        $(".titelnya").text(text);
    };

    $(document).ready(function(){
    $("#select_tahun").datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
    }).datepicker('setDate',"<?= date('Y'); ?>");

        $(".table-bordered").DataTable({
        processing: true,
        language: {
            search: "Cari",
            lengthMenu: "Menampilkan _MENU_ data",
            info: "Menampilkan _PAGE_ sampai _PAGES_ dari _MAX_ data",
            infoFiltered: "(difilter dari _MAX_ data)",
            paginate: {
            previous: "Sebelumnya",
            next: "Selanjutnya",
            },
        },
        lengthMenu: [
            [10, 20, 50],
            [10, 20, 50],
        ],
        initComplete: function(){
        }
        });

        fill_table();

        $("#select_tahun").on('change',function(){
            fill_table();
        });
    });


    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>