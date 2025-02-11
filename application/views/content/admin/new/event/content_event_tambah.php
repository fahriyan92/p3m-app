<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

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
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row"> 
                <div class="col-md-12">
               
                <div class="card card-default">
                    <div class="card-header d-flex">
                        <h3>Tambah Data Event</h3>
                    </div>
       

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h4 class="title">Jenis Event</h4> 
                                    <?php  $i = 0 ; ?>
                                    <?php foreach ($jenis_event as $event) { ?>
                                        <input <?= $i == 0 ? "checked" : "" ?> type="radio" name="jenis_event" value="<?= $event->id_event ?>">
                                        <span class="text-capitalize" for="inputJenis"><?= $event->nm_event ?></span><br>
                                    <?php $i++; } ?>
                                    <div class="error-jns col-sm-10 mt-2" style="display: none;">
                                        <h5 style="font-size: 16px; color: red;">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>
                                <h4 class="title">Jadwal per tahapan</h4> 
                                 <div id="mencoba"></div>
                             
                            </div>
                            <div class="col-md-6">
                                <h4 class="title">Skema Pengajuan</h4> 
                                <div class="" id="hot2"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-right">
                                    <a  class="btn btn-primary" href="#" id="simpan">Simpan</a>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </div>
            </div>


        </div>
    </section>
</div>


<script>
    const base_url = '<?= site_url('c_event_new/') ?>';
    let skema;
    let container2;
    let hot2;
    let test2;
    $(document).ready(function(){
        const tahapan = <?php echo json_encode($tahapan); ?>;
        const container = document.getElementById("mencoba");
        const rowPenerimaanReview = [];

        String.prototype.capitalize = function() {
            return this.charAt(0).toUpperCase() + this.slice(1);
        }
        // $("#mencoba");

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        const test = tahapan.map((el,i) => { 
            const arr = [];
            arr.push(el.id_tahapan);
            if(el.nama_tahapan.includes("penerimaan") || el.nama_tahapan.includes("review")){
                rowPenerimaanReview.push(i);
            }
            arr.push(el.nama_tahapan.capitalize());
            arr.push("");
            arr.push("");
            return arr;
        });

    //const container = document.getElementById('example');
            const hot = new Handsontable(container, {
                height: 320,
                startRows: 5,
                startCols: 4,
                minRows: 10,
                minCols: 3,
                maxRows: 100,
                maxCols: 10,
                data: test,
                rowHeaders: true,
                colHeaders: ['id','Tahapan', 'Waktu Mulai', 'Waktu Akhir'],
                columns: [
                {
                    unique: true,
                    type: 'text',

                },
                {
                    unique: true,
                    type: 'text',
                    readOnly: true
                },
                {
                    type: 'date',
                    dateFormat: 'DD-MM-YYYY',
                    correctFormat: true,
                    defaultDate: '<?= date('d-m-Y') ?>',
                        datePickerConfig: {
                            firstDay: 0,
                            showWeekNumber: true,
                            numberOfMonths: 1
                            // disableDayFn(date) {
                            // return date.getDay() === 0 || date.getDay() === 6;
                            // }
                        }
                    },
                    {
                    type: 'date',
                    dateFormat: 'DD-MM-YYYY',
                    correctFormat: true,
                    defaultDate: '<?= date('d-m-Y') ?>',
                        datePickerConfig: {
                            firstDay: 0,
                            showWeekNumber: true,
                            numberOfMonths: 1,
                            // disableDayFn(date) {
                            // return date.getDay() === 0 || date.getDay() === 6;
                            // }
                        }
                    },
            ],
            hiddenColumns: {
                columns: [0]
            },  
            afterChange(changes, source) {
            if (source !== 'loadData') {
                //console.log(changes);
                const datarow = this.getSourceDataAtRow(changes[0][0]);

                if(datarow[2] != '' && datarow[3] != ''){
                    let awal = datarow[2].split('-');
                    let akhir = datarow[3].split('-');
                    const tglawal = new Date(awal[2]+'-'+awal[1]+'-'+awal[0]) ;
                    const tglakhir = new Date(akhir[2]+'-'+akhir[1]+'-'+akhir[0]);

                    if(tglawal > tglakhir){
                        toastr["error"]("Tanggal awal harus lebih kecil dari tanggal akhir");
                        this.setCellMeta(changes[0][0],changes[0][1],'valid',false);
                        this.setCellMeta(changes[0][0],changes[0][1] - 1,'valid',false);
                        this.render();
                    } else { 
                        this.setCellMeta(changes[0][0],changes[0][1],'valid',true);
                        this.setCellMeta(changes[0][0],changes[0][1] - 1,'valid',true);
                        this.render();
                    }
                }
            }
            },        
            contextMenu: true,
            formulas: true,
            currentRowClassName: 'currentRow',
            currentColClassName: 'currentCol',
            autoWrapRow: true,
            sortIndicator: true,
            manualColumnResize: true,
            manualRowResize: true,
            columnSorting: true,
            columnSorting: true,
            licenseKey: 'non-commercial-and-evaluation',
            });

        $('#simpan').on('click', function(e){
            $("#overlay").fadeIn(300);
            e.preventDefault();

            $.ajax({
            url: base_url + "checkRangeDate",
            method: "POST",
            dataType: "JSON",
            data: {jadwal: hot.getData(), skema:hot2.getData(),jenis_event:$('input[name="jenis_event"]:checked').val() },
            success: function(res){
                if(res.status == 'error') {
                    if(res.row != undefined){
                        toastr["error"](res.message);
                        hot.setCellMeta(parseInt(res.row),2,'valid',false);
                        hot.setCellMeta(parseInt(res.row),3,'valid',false);
                        hot.render();
                    }
                    $("#overlay").fadeOut(400);
                    return;
                }
                $("#overlay").fadeOut(400);
                    Swal.fire(
                    'Berhasil!',
                    'Berhasil Membuat Event!',
                    'success'
                ).then((result) => {
                    window.location.href = "<?= site_url('C_event_new') ?>";
                // Reload the Page
                //location.reload();
                });                
            }
        });
            //console.log(hot.getData());
        });

        $('input[name="jenis_event"]').on('change', function(e){
            const jenis = $(this).val();
            getDataSkema(jenis);
        });

        getDataSkema();
    });

    const getDataSkema = function(id_skema)
    {
        $('#hot2').html('tunggu ...');
        if(id_skema == null){
            id_skema = $('input[name="jenis_event"]').val();
        }
        id_skema = id_skema + '';
        $.ajax({
            url: base_url + "get_skema/"+id_skema,
            method: "GET",
            success: function(res){
                $('#hot2').html('');
                $('#hot2').html(res);
            }
        });
    }
    
</script>

