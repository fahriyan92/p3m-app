<!-- Content Wrapper. Contains page content -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="<?php echo base_url('assets'); ?>/dist/img/default-avatar.png" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center"><?php echo $this->session->userdata('nama'); ?> </h3>

                            <p class="text-muted text-center"><?php echo $dosen[0]->jenis_job;  ?></p>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <?php if($dosen[0]->file_cv !== null && $dosen[0]->file_cv !== ""): ?>
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <h3 class="profile-username text-center">Download File CV</h3>

                            <div class="text-center">
                                <a href="<?= base_url('assets/berkas/file_cv/').$dosen[0]->file_cv ?>" target="_blank" style="cursor:pointer;"><i style="font-size:35px;" class="icon fas fa-download"></i></a>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <?php endif; ?>

                    <!-- /.card -->                       

                    <!-- Profile Image -->
                    <div class="card card-primary">
                        <div class="card-body box-profile">
                            <?php if($dosen[0]->file_cv !== null && $dosen[0]->file_cv !== "" && $dosen[0]->nik !== "" && $dosen[0]->nik !== null && $dosen[0]->email !== "" && $dosen[0]->email !== null && $dosen[0]->telepon !== "" && $dosen[0]->telepon !== null && $dosen[0]->link_scopus !== null && $dosen[0]->link_googlescholar !== null): ?>
                            <div class="text-center">
                                <i style="font-size:35px;color:#28a745;" class="icon fas fa-check"></i>
                            </div>

                            <h3 class="profile-username text-center">Data profile sudah lengkap</h3>
                            <?php else:  ?>
                                <div class="text-center">
                                <i style="font-size:35px;color:#ffc107;" class="icon fas fa-exclamation-triangle"></i>
                            </div>

                            <h3 class="profile-username text-center">Data profile belum lengkap</h3>
                            <?php endif; ?>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->                    

                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <h3 class="card-title">Pengaturan Profile</h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                        <?php if($this->session->userdata('insert-status')): ?>
                         <div class="alert alert-<?= $this->session->userdata('insert-status') ?> alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-<?= $this->session->userdata('insert-status') === "success" ? "check" : "ban" ?>"></i> <?= $this->session->userdata('insert-status') === "success" ? "Berhasil" : "Gagal" ?>!</h5>
                            <?= $this->session->userdata('insert-message') ?>
                        </div>                        
                        <?php endif; ?>
                            <div class="tab-content">
                                <div class="tab-pane active" id="settings">
                                <form action="<?= site_url('C_master_data/update_profile') ?>" id="form_profile" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="form_bagian" value="bagian_dosen">
                                 <div class="row">
                                    <div class="col-sm-12">
                                        <h5>Data Personal</h5>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label for="nama-dosen" class=" control-label">Nama</label>
                                                <input type="text" autocomplete="off" class="form-control" id="nama-dosen" name="nama" placeholder="Nama" value="<?= $dosen[0]->nama; ?>">
                                            </div>
                                        </div>                                    
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                            <label for="nik" class=" control-label">No KTP</label>
                                                <input type="text" autocomplete="off" class="form-control" id="nik-dosen" name="nik" placeholder="No KTP Dosen" value="<?= $dosen[0]->nik ?>">
                                            </div>
                                        
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                            <label for="gender-dosen" class=" control-label">Jenis Kelamin</label>

                                                <select class="form-control" name="gender" id="gender-dosen">
                                                    <option <?= $dosen[0]->jenis_kelamin === "laki-laki" ? 'selected' : '' ?> value="laki-laki">Laki-Laki</option>
                                                    <option <?= $dosen[0]->jenis_kelamin === "perempuan" ? 'selected' : '' ?> value="perempuan">Perempuan</option>
                                                </select>

                                            </div>
                                        
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                               <label for="email-dosen" class="control-label">Email</label>

                                                <input type="email" autocomplete="off" class="form-control" id="email-dosen" name="email" placeholder="Email Dosen" value="<?= $dosen[0]->email ?>">
                                                <input type="hidden" name="nip" value="<?= $dosen[0]->nip ?>">
                                                <?php if($this->session->flashdata('email-error')): ?> 
                                                <p style="color:red; "><?= $this->session->flashdata('email-error') ?></p>
                                                <?php endif; ?>
                                            </div>
                                        
                                        </div>
                                    </div>                                    

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                            <label for="telepon-dosen" class=" control-label">No. HP</label>

                                                <input autocomplete="off" type="text" class="form-control" id="telepon-dosen" name="telepon" placeholder="Nomer HP Dosen" value="<?= $dosen[0]->telepon ?>">

                                            </div>
                                        
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                               <label for="alamat-dosen" class=" control-label">Alamat</label>
                                                <textarea class="form-control" id="alamat-dosen" name="alamat" placeholder="Alamat Dosen"><?= $dosen[0]->alamat ?></textarea>
                                            </div>
                                        
                                        </div>
                                        <hr>
                                    </div>

                                   
                                    
                                    <div class="col-sm-12">
                                        <h5>Data Pekerjaan</h5>
                                    </div>


                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label for="NIP" class=" control-label">NIP</label>

                                                <input autocomplete="off" type="NIP" class="form-control" id="NIP-dosen" name="nip" placeholder="NIP Dosen" value="<?= $dosen[0]->nidn; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="nidn-dosen" class=" control-label">NIDN</label>
                                            <input autocomplete="off" type="type" class="form-control" name="nidn" id="nidn-dosen" placeholder="NIDN" value="<?= $dosen[0]->nidn_real; ?>">
                                        </div>
                                    </div>
                                    </div>           
                                    </div>

                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                        <label for="unit" class="control-label">Jenis Unit</label>

                                        <input autocomplete="off" type="unit" class="form-control" id="unit-dosen" placeholder="Unit Dosen" name="jenis_unit" value="<?= $dosen[0]->jenis_unit ?>" readonly>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                        <label for="unit" class="control-label">Unit</label>
                                    <?php //  <input type="unit" class="form-control" id="unit-dosen" placeholder="Unit Dosen" name="unit" value="<?= $dosen[0]->unit " readonly> ?>
                                        <select class="form-control" name="unit" id="unit_select">
                                            <?php foreach($prodi as $prod): ?>
                                                <option <?= trim(strtoupper($dosen[0]->unit))  ===  trim(strtoupper($prod->nama_prodi)) ? "selected" : "" ?> value="<?= trim(strtoupper($prod->nama_prodi)) ?>"><?=  trim(strtoupper($prod->nama_prodi)) ?></option>
                                            <?php endforeach; ?>
                                        </select>                                        
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="row">


                                    </div>
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="pangkat" class=" control-label">Jabatan Fungsional</label>
                                            <select class="form-control" name="pangkat" id="pangkat">
                                                    <option <?= $dosen[0]->pangkat  === "tenaga pengajar" ? "selected" : "" ?> value="tenaga pengajar">Tenaga Pengajar</option>
                                                    <option <?= $dosen[0]->pangkat  === "asisten ahli" ? "selected" : "" ?> value="asisten ahli">Asisten Ahli</option>
                                                    <option <?= $dosen[0]->pangkat  === "lektor" ? "selected" : "" ?> value="lektor">Lektor</option>
                                                    <option <?= $dosen[0]->pangkat  === "lektor kepala" ? "selected" : "" ?> value="lektor kepala">Lektor Kepala</option>
                                                    <option <?= $dosen[0]->pangkat  === "guru besar" ? "selected" : "" ?> value="guru besar">Guru Besar</option>
                                                    <option <?= $dosen[0]->pangkat  === "plp terampil pelaksana" ? "selected" : "" ?> value="plp terampil pelaksana">PLP Terampil Pelaksana</option>
                                                    <option <?= $dosen[0]->pangkat  === "plp terampil pelaksana lanjutan" ? "selected" : "" ?> value="plp terampil pelaksana lanjutan">PLP Terampil Lanjutan</option>
                                                    <option <?= $dosen[0]->pangkat  === "plp terampil penyelia" ? "selected" : "" ?> value="plp terampil penyelia">PLP Terampil Penyelia</option>
                                                    <option <?= $dosen[0]->pangkat  === "plp ahli pertama" ? "selected" : "" ?> value="plp ahli pertama">Guru Besar</option>
                                                    <option <?= $dosen[0]->pangkat  === "plp ahli muda" ? "selected" : "" ?> value="plp ahli muda">PLP Ahli Muda</option>
                                                    <option <?= $dosen[0]->pangkat  === "plp ahli madya" ? "selected" : "" ?> value="plp ahli madya">PLP Ahli Madya</option>
                                                </select>                     

                                        </div>
                                       
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label for="golongan" class=" control-label">Golongan</label>
                                                <select class="form-control" name="golongan" id="golongan">
                                                    <option <?= $dosen[0]->golongan  === "Gol. II/a" ? "selected" : "" ?> value="Gol. II/a">Gol. II/a</option>
                                                    <option <?= $dosen[0]->golongan  === "Gol. II/b" ? "selected" : "" ?> value="Gol. II/b">Gol. II/b</option>
                                                    <option <?= $dosen[0]->golongan  === "Gol. II/c" ? "selected" : "" ?> value="Gol. II/c">Gol. II/c</option>
                                                    <option <?= $dosen[0]->golongan  === "Gol. II/d" ? "selected" : "" ?> value="Gol. II/d">Gol. II/d</option>
                                                    <option <?= $dosen[0]->golongan  === "Gol. III/a" ? "selected" : "" ?> value="Gol. III/a">Gol. III/a</option>
                                                    <option <?= $dosen[0]->golongan  === "Gol. III/b" ? "selected" : "" ?> value="Gol. III/b">Gol. III/b</option>
                                                    <option <?= $dosen[0]->golongan  === "Gol. III/c" ? "selected" : "" ?> value="Gol. III/c">Gol. III/c</option>
                                                    <option <?= $dosen[0]->golongan  === "Gol. III/d" ? "selected" : "" ?> value="Gol. III/d">Gol. III/d</option>
                                                    <option <?= $dosen[0]->golongan  === "Gol. IV/a" ? "selected" : "" ?> value="Gol. IV/a">Gol. IV/a</option>
                                                    <option <?= $dosen[0]->golongan  === "Gol. IV/b" ? "selected" : "" ?> value="Gol. IV/b">Gol. IV/b</option>
                                                    <option <?= $dosen[0]->golongan  === "Gol. IV/c" ? "selected" : "" ?> value="Gol. IV/c">Gol. IV/c</option>
                                                    <option <?= $dosen[0]->golongan  === "Gol. IV/d" ? "selected" : "" ?> value="Gol. IV/d">Gol. IV/d</option>
                                                    <option <?= $dosen[0]->golongan  === "Gol. IV/e" ? "selected" : "" ?> value="Gol. IV/e">Gol. IV/e</option>
                                                </select>                                                
                                                <!-- <input type="text" class="form-control" id="golongan-dosen" name="golongan" placeholder="Golongan Dosen" value="<?= $dosen[0]->golongan ?>"> -->
    
                                            </div>
                                        
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                <label for="sinta-dosen" class=" control-label">SINTA</label>
                                                <input autocomplete="off" type="sinta" class="form-control" id="sinta-dosen" name="sinta" placeholder="ID SINTA" value="<?= $dosen[0]->sinta ?>">
                                                </div>
                                            </div>
                                        </div>   

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                <label for="scopus-dosen" class=" control-label">SCOPUS</label>
                                                <input autocomplete="off" type="sinta" class="form-control" id="scopus-dosen" name="scopus" placeholder="ID SCOPUS" value="<?= $dosen[0]->scopus ?>">
                                                </div>
                                            </div>
                                        </div>                                           

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="hindex" class=" control-label">H Index Scholar</label>
                                                    <input type="text" autocomplete="off" class="form-control" id="hindex" name="hindex" placeholder="H Index Schoolar" value="<?= $dosen[0]->hindex ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="hindex_scopus" class=" control-label">H Index Scopus</label>
                                                    <input type="text" autocomplete="off" class="form-control" id="hindex_scopus" name="hindex_scopus" placeholder="H Index Scopus" value="<?= $dosen[0]->hindex_scopus ?>">
                                                </div>
                                            </div>
                                        </div>               
                                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="link_google_scholar" class=" control-label">Link Google Scholar</label>
                                                    <input type="text" autocomplete="off" class="form-control" id="link_google_scholar" name="link_google_scholar" placeholder="Link Google Scholar" value="<?= $dosen[0]->link_googlescholar ?>">
                                                </div>
                                            </div>
                                        </div>           
                                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="link_scopus" class=" control-label">Link Scopus</label>
                                                    <input type="text" autocomplete="off" class="form-control" id="link_scopus" name="link_scopus" placeholder="Link Scopus" value="<?= $dosen[0]->link_scopus ?>">
                                                </div>
                                            </div>
                                        </div>                                                   

                                        <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label for="bidang_penelitian" class=" control-label">Bidang Penelitian</label>
                                                <select class="form-control" name="bidang_penelitian" id="bidang_penelitian">
                                                    <option <?= $dosen[0]->bidang  === "sosial humaniora" ? "selected" : "" ?> value="sosial humaniora">Sosial Humaniora</option>
                                                    <option <?= $dosen[0]->bidang  === "sains teknologi" ? "selected" : "" ?> value="sains teknologi">Sains Teknologi</option>
                                                </select>                                                
                                             
    
                                            </div>
                                        
                                        </div>
                                    </div>           


                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label for="pendidikan_terakhir" class=" control-label">Pendidikan Terakhir</label>
                                                <select class="form-control" name="pendidikan_terakhir" id="pendidikan_terakhir">
                                                    <?php foreach($pendidikans as $pdk):  ?>
                                                        <option <?= $dosen[0]->pendidikan_terakhir  === $pdk->id ? "selected" : "" ?> value="<?= $pdk->id ?>"><?= strtoupper($pdk->pendidikan) ?></option>
                                                    <?php  endforeach; ?>
                                                </select>                                                
                                             
                                            </div>
                                        
                                        </div>
                                    </div>                                                                       

                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <input id="flag_unggah" name="flag_unggah" hidden="hidden" value="<?= $dosen[0]->file_cv === null || $dosen[0]->file_cv === ""  ? 'N' : 'Y' ?>">

                                                <div class="col-sm-12">
                                                    <label for="cvKetua">Unggah File CV</label>
 <?php if($dosen[0]->file_cv !== null || $dosen[0]->file_cv !== ""): ?><span style="color:red;"> ( *Unggah file jika ingin mengganti / menambahkan cv )</span>
 <?php else:  ?> 
    <span style="color:red;"> ( *wajib unggah file )</span>
 <?php endif; ?>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="fileCv" name="file_cv" hidden="hidden">
                                                        <label class="custom-file-label" for="fileCv" id="labelproposal">Pilih file</label>
                                                    </div>
                                                   
                                                    <div class="err-proposal" style="display:none;">
                                                        <h5 style="font-size: 16px; color: red;" class="text-left">Ekstensi File Tidak Didukung!</h5>
                                                    </div>
                                                  </div>
                                              </div>                                        
                                        </div>
                                    </div>


                                    <div class="form-group mt-3">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button type="submit" class="btn btn-success ganti">Simpan Data</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('.table-bordered').DataTable();

    const regex = /[\/\\]([\w\d\s\.\-\(\)]+)$/;
    $('#fileCv').on('change', function() {
        const regex2 = new RegExp("(.*?)\.(pdf|doc|docx)$");
        $('.err-proposal').hide();
        const file = this.files[0];
        const value = $(this).val().toLowerCase();

        let state = {
            size: false, 
            ext: false
        };

        let message = "";

        if(!(regex2.test(value))){
            $('.err-proposal').find('h5').text("Harus file pdf/doc/docx !");
            $('.err-proposal').show();

            $(this).val('');
            return;
        } else{ 
            if(file.size > 3000000 ){
                $('.err-proposal').find('h5').text("File maximal 3MB !");
                $('.err-proposal').show();

                return;
            } else{
                $('.err-proposal').hide();
            } 
        }          
        const fileName = $(this).val();
        $('#labelproposal').text(fileName.match(regex)[1]);
    });

    const element = {
        ktp: "input[name='nik']",
        email: "input[name='email']",
        telepon: "input[name='telepon']",
        alamat: "textarea[name='alamat']",
        nidn: "input[name='nidn']",
        sinta: "input[name='sinta']",
        scopus: "input[name='scopus']",
        hindex: "input[name='hindex']",
        hindex_scopus: "input[name='hindex_scopus']",
        file_cv: "input[name='file_cv']",
        pendidikan_terakhir: "select[name='pendidikan_terakhir']",
        link_scopus: "input[name='link_scopus']",
        link_scholar: "input[name='link_google_scholar']"
    };

    const validate_number = function(num){
        const z = num  % 1; 
        if(isNaN(z)){
            return false;
        } 
        
        return true;
    };

    const validate_email = function(email) {
        const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    const clear_error = function(){
        $(element.ktp).parent().find('h5').remove();
        $(element.email).parent().find('h5').remove();
        $(element.telepon).parent().find('h5').remove();
        $(element.alamat).parent().find('h5').remove();
        $(element.nidn).parent().find('h5').remove();
        $(element.sinta).parent().find('h5').remove();
        $(element.scopus).parent().find('h5').remove();
        $(element.hindex).parent().find('h5').remove();
        $(element.hindex_scopus).parent().find('h5').remove();
        $(element.link_scopus).parent().find('h5').remove();
        $(element.link_scholar).parent().find('h5').remove();
        // $(element.file_cv).parent().find('h5').remove();
    };

    const validasi = function(){
        clear_error();
        const state = {
            ktp: false,
            email: false,
            telepon: false,
            alamat: false,
            nidn: false,
            sinta: false,
            scopus: false,
            hindex: false,
            hindex_scopus: false,
            link_scopus: false,
            link_scholar: false,
            file_cv: true
          }; 

        const err = function(msg){
            return `<h5 style='color:red;margin-top:2px;font-size:14px;'>${msg}</h5>`;
        };

        if($(element.ktp).val() === ""){
            state.ktp = false;
            $(element.ktp).parent().append(err("tidak boleh kosong"));
        } else {
            if(!validate_number($(element.ktp).val())){
                state.ktp = false;
                $(element.ktp).parent().append(err("karakter harus angka"));
            }else{
                state.ktp = true;
                $(element.ktp).parent().find('h5').remove();
            }
        }

        if($(element.link_scopus).val() === ""){
            state.link_scopus = false;
            $(element.link_scopus).parent().append(err("tidak boleh kosong"));
        } else {
            state.link_scopus = true;
            $(element.link_scopus).parent().find('h5').remove();
        }        

        if($(element.link_scholar).val() === ""){
            state.link_scholar = false;
            $(element.link_scholar).parent().append(err("tidak boleh kosong"));
        } else {
            state.link_scholar = true;
            $(element.link_scholar).parent().find('h5').remove();
        }              

        if($(element.nidn).val() === ""){
            state.nidn = true;
            $(element.nidn).parent().find('h5').remove();
        } else {
            if(!validate_number($(element.nidn).val())){
                state.nidn = false;
                $(element.nidn).parent().append(err("karakter harus angka"));
            }else{
                state.nidn = true;
                $(element.nidn).parent().find('h5').remove();
            }
        }


        if($(element.sinta).val() === ""){
            state.sinta = true;
            $(element.sinta).parent().find('h5').remove();
        } else {
            if(!validate_number($(element.sinta).val())){
                state.sinta = false;
                $(element.sinta).parent().append(err("karakter harus angka"));
            }else{
                if($(element.sinta).val().trim().length > 7){
                  state.sinta = false;
                  $(element.sinta).parent().append(err("maximal 7 karakter"));
                } else {
                    state.sinta = true;
                    $(element.sinta).parent().find('h5').remove();
                }
            }
        }        


        if($(element.scopus).val() === ""){
            state.scopus = true;
            $(element.scopus).parent().find('h5').remove();
        } else {
            if(!validate_number($(element.scopus).val())){
                state.scopus = false;
                $(element.scopus).parent().append(err("karakter harus angka"));
            }else{
                if($(element.scopus).val().trim().length > 11){
                  state.scopus = false;
                  $(element.scopus).parent().append(err("maximal 11 karakter"));
                } else {
                    state.scopus = true;
                    $(element.scopus).parent().find('h5').remove();
                }
            }
        }      

        if($(element.hindex).val() === ""){
            state.hindex = true;
            $(element.hindex).parent().find('h5').remove();
        } else {
            if(!validate_number($(element.hindex).val())){
                state.hindex = false;
                $(element.hindex).parent().append(err("karakter harus angka"));
            }else{
                if($(element.hindex).val().trim().length > 4){
                  state.hindex = false;
                  $(element.hindex).parent().append(err("maximal 4 karakter"));
                } else {
                    state.hindex = true;
                    $(element.hindex).parent().find('h5').remove();
                }                
            }
        } 

        if($(element.hindex_scopus).val() === ""){
            state.hindex_scopus = true;
            $(element.hindex_scopus).parent().find('h5').remove();
        } else {
            if(!validate_number($(element.hindex_scopus).val())){
                state.hindex_scopus = false;
                $(element.hindex_scopus).parent().append(err("karakter harus angka"));
            }else{
                if($(element.hindex_scopus).val().trim().length > 4){
                  state.hindex_scopus = false;
                  $(element.hindex_scopus).parent().append(err("maximal 4 karakter"));
                } else {
                    state.hindex_scopus = true;
                    $(element.hindex_scopus).parent().find('h5').remove();
                }            
            }
        }       

        if($(element.telepon).val() === ""){
            state.telepon = false;
            $(element.telepon).parent().append(err("tidak boleh kosong"));
        } else {
            if(!validate_number($(element.telepon).val())){
                state.telepon = false;
                $(element.telepon).parent().append(err("karakter harus angka"));
            }else{
                if($(element.telepon).val().trim().length > 13){
                  state.telepon = false;
                  $(element.telepon).parent().append(err("maximal 13 karakter"));
                } else {
                    state.telepon = true;
                    $(element.telepon).parent().find('h5').remove();
                }            
            }
        }          

        if($(element.email).val() === ""){
            state.email = false;
            $(element.email).parent().append(err("tidak boleh kosong"));
        } else {
            if(!validate_email($(element.email).val())){
                state.email = false;
                $(element.email).parent().append(err("karakter harus email"));
            }else{
                const mail = $(element.email).val().split('@');
                if(mail[1] != "polije.ac.id"){
                    state.email = false;
                    $(element.email).parent().append(err("email harus @polije.ac.id"));
                } else {
                    state.email = true;
                    $(element.email).parent().find('h5').remove();
                }
            }
        }

        if($(element.alamat).val() === ""){
            state.alamat = false;
            $(element.alamat).parent().append(err("tidak boleh kosong"));
        } else {
            state.alamat = true;
            $(element.alamat).parent().find('h5').remove();
        } 

        if($("#flag_unggah").val() === "N"){
            if($(element.file_cv).val() === ""){
                $('.err-proposal').find('h5').text("Unggah file cv !");
                $('.err-proposal').show();                
                state.file_cv = false;
            } else {
                state.file_cv = true;
                $('.err-proposal').hide();                
            } 
        }               
     
        if(state.ktp === true && state.email === true && state.telepon === true && state.alamat === true && state.nidn === true && state.sinta === true && state.scopus === true && state.hindex === true && state.hindex_scopus === true && state.file_cv === true && state.link_scopus === true && state.link_scholar === true){
            return true;
        }              

        return false;                 
    };

    $(document).ready(function(){
        $("#unit_select").select2();

        $("button[type='submit']").on("click", function(e){
            e.preventDefault();

            if(validasi()){
                $("#form_profile").submit();
            }
        });
    });


    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>