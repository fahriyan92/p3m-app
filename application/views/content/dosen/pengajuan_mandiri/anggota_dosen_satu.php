<script src="<?php echo base_url('assets'); ?>/plugins/select2/js/select2.full.min.js"></script>
<link rel="stylesheet" href="<?= base_url() . CSS_CUSTOM; ?>form_wizard.css?random=<?= uniqid(); ?>">
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


<section class="content">
   <?php  if($this->session->flashdata('key')): ?>
    <div class="alert alert-<?= $this->session->flashdata('key') ?> alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata($this->session->flashdata('key'));?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>  
        
<?php  endif; ?>   

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <div class="row">
                    <h3 class="text-left">Data Ketua <span style="color:red;">*</span></h3>
                    <div class="col-md-12">
                    <form action="<?= site_url('pengajuan_mandiri/anggota_dosen/store') ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="ketua">1. NIP</label>
                            <input type="text" class="form-control" name="nip1" disabled id="nidn_ketua" value="<?= $dosen['ketua'][0]->nidn ?>">
                        </div>
                    </div>                    
                    <div class="col-md-12">
                        <div class="form-group">
                                <label for="nidn">2. NAMA DOSEN</label>
                                <div class="custom-file">
                                    <input type="text" class="form-control" name="nama_dosen" value="<?= $dosen['ketua'][0]->nama ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="jurusan">3. Jurusan</label>
                                <div class="custom-file">
                                    <input type="text" class="form-control" name="jurusan" value="<?= $dosen['ketua'][0]->unit ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="pangkat">4. Pangkat / Jabatan Fungsional</label>
                                <div class="custom-file">
                                    <input type="text" class="form-control" id="pangkat" name="pangkat" value="<?= $dosen['ketua'][0]->jenis_unit ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="id_sinta">5. ID-Sinta <span style="color:red;">*</span></label>
                                <div class="custom-file">
                                    <input type="number" class="form-control" disabled name="sinta1" value="<?= isset($ketua) ? $ketua->sinta : '' ?>" id="id_sinta1" onkeydown="return event.keyCode !== 69" name="id_sinta">
                                   
                                </div>
                                <?= form_error('sinta1', '<h5 class="text-left" style="color:red;font-size: 16px;">','</h5>') ;?> 
                                <div class="err-sinta1" style="display:none;">
                                    <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                </div>
                            </div>
                        </div>  

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="id_sinta">File CV Ketua</label>
                                <h5 class="text-left"><a href="<?= base_url('assets/berkas/file_cv/').$ketua->file_cv ?>" target="_blank"><?= $ketua->file_cv ?></a></h5>
                            </div>
                        </div>


                    </div>

                <?php if(count($anggota) > 1): ?>
                    <h3 class="text-left">Data Anggota 1 <span style="color:red;">*</span></h3>
                    <h4 class="text-left"><?= $anggota[0]->nip . ' - '. $anggota[0]->nama ?><span style="color:black;"> (Belum merespon)</span></h4>
                    <hr>
                    <h3 class="text-left">Data Anggota 2 <span style="color:red;">*</span></h3>
                    <h4 class="text-left"><?= $anggota[1]->nip . ' - '. $anggota[1]->nama ?><span style="color:black;"> (Belum merespon)</span></h4>
                <?php else:  ?>                    
                    <h3 class="text-left">Data Anggota 1 <span style="color:red;">*</span></h3>
                    <h4 class="text-left"><?= $anggota[0]->nip . ' - '. $anggota[0]->nama ?><span style="color:black;"> (Belum merespon)</span></h4>
                <?php endif; ?>
                <hr>

                           

                    

          
                    </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>


</section>
</div>

<script>
    if($('input[name="pakegak"]').is(':checked')){
        $('.form-anggota2').show();
    } else{ 
        $('.form-anggota2').hide();
    }

   const regex = /[\/\\]([\w\d\s\.\-\(\)]+)$/;

    $('#cvKetua').on('change', function() {
        const fileName = $(this).val();
        $('#labelcvKetua').text(fileName.match(regex)[1]);
    });

    $('#cvAnggota1').on('change', function() {
        const fileName2 = $(this).val();
        $('#labelAnggota1').text(fileName2.match(regex)[1]);
    });

    $('#cvAnggota2').on('change', function() {
        const fileName3 = $(this).val();
        $('#labelAnggota2').text(fileName3.match(regex)[1]);
    });

    const dosen = <?= json_encode($dosen['dosen']); ?>;
    const find_dosen = (nidn) => {
        const data = dosen.find((el) => el.nidn === nidn);
        return data;
    };

    $('#anggota1,#anggota2').select2();

    $('input[name="pakegak"]').on('change', function(){
        
        $('.form-anggota2').toggle();
    });

    $('#anggota1').on('change', function(){
        const nip = $(this).val();
        if (nip !== "") {
            const data = find_dosen(nip);
            $("#nama1").val(data.nama);
            $("#jurusan1").val(data.unit);
            $("#pangkat1").val(data.jenis_job);
        } else {
            $("#nama1").val("");
            $("#jurusan1").val("");
            $("#pangkat1").val("");
        }
    });

    $('#anggota2').on('change', function(){
        const nip = $(this).val();
        if (nip !== "") {
            const data = find_dosen(nip);
            $("#nama2").val(data.nama);
            $("#jurusan2").val(data.unit);
            $("#pangkat2").val(data.jenis_job);
        } else {
            $("#nama2").val("");
            $("#jurusan2").val("");
            $("#pangkat2").val("");
        }
    });    

</script>