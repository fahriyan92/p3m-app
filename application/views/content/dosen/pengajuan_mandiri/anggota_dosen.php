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
                                    <input type="number" class="form-control" name="sinta1" value="<?= isset($lanjut_dosen) && isset($lanjut_dosen['ketua'][0]) ? $lanjut_dosen['ketua'][0]->id_sinta : '' ?>" id="id_sinta1" onkeydown="return event.keyCode !== 69" name="id_sinta">
                                   
                                </div>
                                <?= form_error('sinta1', '<h5 class="text-left" style="color:red;font-size: 16px;">','</h5>') ;?> 
                                <div class="err-sinta1" style="display:none;">
                                    <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                </div>
                            </div>
                        </div>  

                        <div class="col-md-12">
                        <div class="form-group">
                            <label for="cvKetua">6. Unggah CV Ketua <span style="color:red;">*</span> <?= isset($lanjut_dosen) && isset($lanjut_dosen['ketua']) ? '<span style="color:red;">(Jika tidak ingin mengganti cv bisa dikosongi)</span>' : '' ?></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="cvKetua" name="cv1" hidden="hidden">
                                <label class="custom-file-label" for="cvKetua" id="labelcvKetua">Pilih file</label>
                            </div>
                            <?= form_error('cv1', '<h5  class="text-left" class="text-left" style="color:red;font-size: 16px;">','</h5>') ;?> 
                            <div class="err-cv-ketua" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Harus File PDF!</h5>
                            </div>
                        </div>
                        </div>


                    </div>
                    <hr>

                <h3 class="text-left">Data Anggota 1 <span style="color:red;">*</span></h3>
    
                <div class="row">
                    <div class="col-md-12">
                    <div class="form-group">
                        <label for="anggota1">1. NIP Anggota 1</label>
                        <select class="form-control select2 nm_dosen" style="width: 100%;" id="anggota1" name="nip2">
                            <option value="">-- Cari NIP Dosen --</option>
                            <?php foreach($dosen['dosen'] as $dsn): ?>
                                <option value="<?= $dsn->nidn ?>"><?= $dsn->nidn ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('nip2', '<h5  class="text-left" style="color:red;font-size: 16px;">','</h5>') ;?> 

                        <div class="err-anggota12" style="display:none;">
                            <h5 style="font-size: 16px; color: red;" class="text-left">Harus File PDF!</h5>
                        </div>
                    </div>     

                    </div>                    
                    <div class="col-md-12">
                        <div class="form-group">
                                <label for="nidn">2. NAMA DOSEN</label>
                                <div class="custom-file">
                                    <input type="text" class="form-control" name="nama_dosen" id="nama1" value="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="jurusan">3. Jurusan</label>
                                <div class="custom-file">
                                    <input type="text" class="form-control" name="jurusan" id="jurusan1" value="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="pangkat">4. Pangkat / Jabatan Fungsional</label>
                                <div class="custom-file">
                                    <input type="text" class="form-control" id="pangkat1"  name="pangkat" value="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="id_sinta">5. ID-Sinta <span style="color:red;">*</span></label>
                                <div class="custom-file">
                                    <input type="number" class="form-control" name="sinta2" value="<?= isset($lanjut_dosen) && isset($lanjut_dosen['ketua'][0]) ? $lanjut_dosen['ketua'][0]->id_sinta : '' ?>" id="id_sinta1" onkeydown="return event.keyCode !== 69" name="id_sinta">
                                </div>
                           <?= form_error('sinta2', '<h5  class="text-left" style="color:red;font-size: 16px;">','</h5>') ;?> 

                                <div class="err-sinta1" style="display:none;">
                                    <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                </div>
                            </div>
                        </div>  

                        <div class="col-md-12">
                        <div class="form-group">
                            <label for="cvKetua">6. Unggah CV Anggota 1<span style="color:red;">*</span><?= isset($lanjut_dosen) && isset($lanjut_dosen['ketua']) ? '<span style="color:red;">(Jika tidak ingin mengganti cv bisa dikosongi)</span>' : '' ?></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="cvAnggota1" name="cv2" hidden="hidden">
                                <label class="custom-file-label" for="cvAnggota1" id="labelAnggota1">Pilih file</label>
                            </div>
                           <?= form_error('cv2', '<h5  class="text-left" style="color:red;font-size: 16px;">','</h5>') ;?> 
                            
                            <div class="err-cv-anggota1" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Harus File PDF!</h5>
                            </div>
                        </div>
                        </div>

                        </div>
                        <div class="col-md-12">
                        <div class="form-group">
                            <div class="checkbox">
                                <label for="pakegak">
                                    Apakah Ingin Menambahkan Anggota 2?
                                    <input style="margin-left:5px;" type="checkbox" name="pakegak" <?= $pake_gak ?>>
                                </label>
                            </div>
                        </div>                        

        <hr>
        <div class="form-anggota2" style="display:none;">
        <h3 class="text-left">Data Anggota 2 (Opsional)</h3>
                    <div class="row">
                    <div class="col-md-12">
                    <div class="form-group">
                        <label for="anggota1">1. NIP Anggota 2</label>
                        <select class="form-control select2 nm_dosen" style="width: 100%;" id="anggota2" name="nip3">
                            <option value="">-- Cari NIP Dosen --</option>
                            <?php foreach($dosen['dosen'] as $dsn): ?>
                                <option value="<?= $dsn->nidn ?>"><?= $dsn->nidn ?></option>
                            <?php endforeach; ?>                            
                        </select>
                        <div class="err-anggota1" style="display:none;">
                            <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                        </div>
                    </div>  
                    </div>                    
                    <div class="col-md-12">
                        <div class="form-group">
                                <label for="nidn">2. NAMA DOSEN</label>
                                <div class="custom-file">
                                    <input type="text" class="form-control" name="nama_dosen" id="nama2" value="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="jurusan">3. Jurusan</label>
                                <div class="custom-file">
                                    <input type="text" class="form-control" name="jurusan" id="jurusan2" value="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="pangkat">4. Pangkat / Jabatan Fungsional</label>
                                <div class="custom-file">
                                    <input type="text" class="form-control" id="pangkat2" name="pangkat" value="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="id_sinta">5. ID-Sinta</label>
                                <div class="custom-file">
                                    <input type="number" class="form-control" name="sinta3" value="<?= isset($lanjut_dosen) && isset($lanjut_dosen['ketua'][0]) ? $lanjut_dosen['ketua'][0]->id_sinta : '' ?>" id="id_sinta1" onkeydown="return event.keyCode !== 69" name="id_sinta">
                                </div>
                                <div class="err-sinta1" style="display:none;">
                                    <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                </div>
                            </div>
                        </div>  

                        <div class="col-md-12">
                        <div class="form-group">
                            <label for="cvKetua">6. Unggah CV Anggota 2 <?= isset($lanjut_dosen) && isset($lanjut_dosen['ketua']) ? '<span style="color:red;">(Jika tidak ingin mengganti cv bisa dikosongi)</span>' : '' ?></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="cvAnggota2" name="cv3" hidden="hidden">
                                <label class="custom-file-label" for="cvAnggota2" id="labelAnggota2">Pilih file</label>
                            </div>
                           <?= form_error('cv3', '<h5  class="text-left" style="color:red;font-size: 16px;">','</h5>') ;?> 
                            <div class="err-cv-anggota2" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Harus File PDF!</h5>
                            </div>
                        </div>
                        </div>

                        </div>
                        <hr>
                    </div>
                    

                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-<?=$mode === 'edit' ? 'warning' : 'success'?>"><?=$mode === 'edit' ? 'Edit' : 'Simpan'?></button>
                            </div>
                        </div>
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
   const regex2 = new RegExp("(.*?)\.(pdf)$");
    $('#cvKetua').on('change', function() {
        $('.err-cv-ketua').hide();
        const file = this.files[0];
        const value = $(this).val().toLowerCase();
      

        if(!(regex2.test(value))){
            $('.err-cv-ketua').show();

            $(this).val('');
            return;
        } else{ 
            $('.err-cv-ketua').hide();
        }

        const fileName = $(this).val();
        $('#labelcvKetua').text(fileName.match(regex)[1]);
    });

    $('#cvAnggota1').on('change', function() {
        $('.err-cv-anggota1').hide();
        const file = this.files[0];
        const value = $(this).val().toLowerCase();
        if(!(regex2.test(value))){
            $('.err-cv-anggota1').show();

            $(this).val('');
            return;
        } else{ 
            $('.err-cv-anggota1').hide();
        }

        const fileName2 = $(this).val();
        $('#labelAnggota1').text(fileName2.match(regex)[1]);
    });

    $('#cvAnggota2').on('change', function() {
        $('.err-cv-anggota2').hide();

        const file = this.files[0];
        const value = $(this).val().toLowerCase();
        if(!(regex2.test(value))){
            $('.err-cv-anggota2').show();

            $(this).val('');
            return;
        } else{ 
            $('.err-cv-anggota2').hide();
        }


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