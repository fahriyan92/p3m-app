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

                            <h3 class="profile-username text-center text-uppercase"><?php echo $dosen->nama;  ?> </h3>

                            <p class="text-muted text-center text-uppercase"><?php echo $dosen->jenis_job;  ?></p>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <?php if($dosen->file_cv !== null && $dosen->file_cv !== ""): ?>
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <h3 class="profile-username text-center">Download File CV</h3>

                            <div class="text-center">
                                <a href="<?= base_url('assets/berkas/file_cv/').$dosen->file_cv ?>" target="_blank" style="cursor:pointer;"><i style="font-size:35px;" class="icon fas fa-download"></i></a>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <?php endif; ?>                    

                    <!-- Profile Image -->
                    <div class="card card-primary">
                        <div class="card-body box-profile">
                            <?php if($dosen->file_cv !== null && $dosen->file_cv !== "" && $dosen->nik !== "" && $dosen->nik !== null && $dosen->email !== "" && $dosen->email !== null && $dosen->telepon !== "" && $dosen->telepon !== null): ?>
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
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#Ddosen" data-toggle="tab">Data Dosen</a></li>
                                <li class="nav-item"><a class="nav-link" href="#hindex" data-toggle="tab">H-Index Dosen</a></li>
                                <li class="nav-item"><a class="nav-link" href="#histori" data-toggle="tab">Riwayat Pengajuan</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="Ddosen">
                                <?php if($this->session->userdata('insert-status')): ?>
                                <div class="alert alert-<?= $this->session->userdata('insert-status') ?> alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-<?= $this->session->userdata('insert-status') === "success" ? "check" : "ban" ?>"></i> <?= $this->session->userdata('insert-status') === "success" ? "Berhasil" : "Gagal" ?>!</h5>
                                    <?= $this->session->userdata('insert-message') ?>
                                </div>                        
                                <?php endif; ?>                                
                                <form id="form-update" action="<?= site_url('C_master_data/update_profile_admin') ?>" method="post">

                                 <div class="row">
                                     <div class="col-sm-12">
                                            <h5>Data Personal</h5>
                                    </div>

                                    <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                <label for="nik" class=" control-label">No KTP</label>
                                                    <input autocomplete="off" type="text" class="form-control" id="nik-dosen" name="nik" placeholder="No KTP Dosen" value="<?= $dosen->nik ?>">
                                                </div>
                                            
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                            <label for="gender-dosen" class=" control-label">Jenis Kelamin</label>

                                                <select class="form-control" name="gender" id="gender-dosen">
                                                    <option <?= $dosen->jenis_kelamin === "laki-laki" ? 'selected' : '' ?> value="laki-laki">Laki-Laki</option>
                                                    <option <?= $dosen->jenis_kelamin === "perempuan" ? 'selected' : '' ?> value="perempuan">Perempuan</option>
                                                </select>

                                            </div>
                                        
                                        </div>
                                    </div>  
                                      

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                               <label for="email-dosen" class="control-label">Email</label>

                                                <input type="email" autocomplete="off" class="form-control" id="email-dosen" name="email" placeholder="Email Dosen" value="<?= $dosen->email ?>">
                                                <input type="hidden" name="nip_old" value="<?= $dosen->nip ?>">
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

                                                <input type="text" autocomplete="off" class="form-control" id="telepon-dosen" name="telepon" placeholder="Nomer HP Dosen" value="<?= $dosen->telepon ?>">

                                            </div>
                                        
                                        </div>
                                    </div>  

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                               <label for="alamat-dosen" class=" control-label">Alamat</label>
                                                <textarea class="form-control" id="alamat-dosen" name="alamat" placeholder="Alamat Dosen"><?= $dosen->alamat ?></textarea>
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
                                                <label for="nama" class=" control-label">Nama</label>
                                                <input type="text" autocomplete="off" class="form-control" id="nama-dosen" name="nama" placeholder="Nama" value="<?= $dosen->nama; ?>">
                                            </div>
                                        </div>
                                    </div>        

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputJudul">Jenis User</label>
                                            <select class="form-control" name="jenis_job">
                                                <option <?= $dosen->jenis_job == "dosen" ? "selected" : "" ?> value="dosen">DOSEN</option>
                                                <option <?= $dosen->jenis_job == "plp" ? "selected" : "" ?> value="plp">PLP</option>
                                            </select>
                                        </div>                                    
                                    </div>                            

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label for="NIP" class=" control-label">NIP</label>

                                                <input type="NIP" autocomplete="off" class="form-control" id="NIP-dosen" name="nip" placeholder="NIP" value="<?= $dosen->nidn; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="nidn-dosen" class=" control-label">NIDN</label>
                                            <input type="type" class="form-control" name="nidn" id="nidn-dosen" placeholder="NIDN" value="<?= $dosen->nidn_real; ?>">
                                        </div>
                                    </div>
                                    </div>   

                                    </div>

                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                        <label for="unit" class="control-label">Jenis Unit</label>

                                        <input type="unit" class="form-control" id="unit-dosen" placeholder="Unit Dosen" name="jenis_unit" value="<?= $dosen->jenis_unit ?>" readonly>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                        <label for="unit" class="control-label">Unit</label>
                                    <?php //  <input type="unit" class="form-control" id="unit-dosen" placeholder="Unit Dosen" name="unit" value="<?= $dosen->unit " readonly> ?>
                                        <select class="form-control" name="unit" id="unit_select">
                                            <?php foreach($prodi as $prod): ?>
                                                <option <?= trim(strtoupper($dosen->unit))  ===  trim(strtoupper($prod->nama_prodi)) ? "selected" : "" ?> value="<?= trim(strtoupper($prod->nama_prodi)) ?>"><?=  trim(strtoupper($prod->nama_prodi)) ?></option>
                                            <?php endforeach; ?>
                                        </select>                                        
                                        </div>
                                    </div>
                                    </div>
                                                                        
                                    </div>
                                    <div class="row">
                                    <div class="col-sm-6">

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="pangkat" class=" control-label">Jabatan Fungsional</label>
                                            <select class="form-control" name="pangkat" id="pangkat">
                                                    <option <?= $dosen->pangkat  === "tenaga pengajar" ? "selected" : "" ?> value="tenaga pengajar">Tenaga Pengajar</option>
                                                    <option <?= $dosen->pangkat  === "asisten ahli" ? "selected" : "" ?> value="asisten ahli">Asisten Ahli</option>
                                                    <option <?= $dosen->pangkat  === "lektor" ? "selected" : "" ?> value="lektor">Lektor</option>
                                                    <option <?= $dosen->pangkat  === "lektor kepala" ? "selected" : "" ?> value="lektor kepala">Lektor Kepala</option>
                                                    <option <?= $dosen->pangkat  === "guru besar" ? "selected" : "" ?> value="guru besar">Guru Besar</option>
                                                </select>                     

                                        </div>
                                       
                                    </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label for="golongan" class=" control-label">Golongan</label>
                                                <select class="form-control" name="golongan" id="golongan">
                                                    <option <?= $dosen->golongan  === "Gol. III/a" ? "selected" : "" ?> value="Gol. III/a">Gol. III/a</option>
                                                    <option <?= $dosen->golongan  === "Gol. III/b" ? "selected" : "" ?> value="Gol. III/b">Gol. III/b</option>
                                                    <option <?= $dosen->golongan  === "Gol. III/c" ? "selected" : "" ?> value="Gol. III/c">Gol. III/c</option>
                                                    <option <?= $dosen->golongan  === "Gol. III/d" ? "selected" : "" ?> value="Gol. III/d">Gol. III/d</option>
                                                    <option <?= $dosen->golongan  === "Gol. IV/a" ? "selected" : "" ?> value="Gol. IV/a">Gol. IV/a</option>
                                                    <option <?= $dosen->golongan  === "Gol. IV/b" ? "selected" : "" ?> value="Gol. IV/b">Gol. IV/b</option>
                                                    <option <?= $dosen->golongan  === "Gol. IV/c" ? "selected" : "" ?> value="Gol. IV/c">Gol. IV/c</option>
                                                    <option <?= $dosen->golongan  === "Gol. IV/d" ? "selected" : "" ?> value="Gol. IV/d">Gol. IV/d</option>
                                                    <option <?= $dosen->golongan  === "Gol. IV/e" ? "selected" : "" ?> value="Gol. IV/e">Gol. IV/e</option>
                                                </select>                   
    
                                            </div>
                                        
                                        </div>
                                    </div>           

                                    </div>
                                    <div class="row">
                                    <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                <label for="sinta-dosen" class=" control-label">SINTA</label>
                                                <input type="sinta" autocomplete="off" class="form-control" id="sinta-dosen" name="sinta" placeholder="ID SINTA" value="<?= $dosen->sinta ?>">
                                                </div>
                                            </div>
                                        </div>   

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                <label for="scopus-dosen" class=" control-label">SCOPUS</label>
                                                <input type="sinta" autocomplete="off" class="form-control" id="scopus-dosen" name="scopus" placeholder="ID SCOPUS" value="<?= $dosen->scopus ?>">
                                                </div>
                                            </div>
                                        </div>                                                                               

                                    </div>

                                    <div class="row">
                                  
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button type="submit" class="btn btn-success ganti">Simpan Data</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="hindex">
                                    <?php if ($hindex_ketua != null) : ?>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label for="NIP" class="control-label">Hindex Scopus</label>
                                                    <input type="NIP" class="form-control" id="NIP-dosen" placeholder="NIP Dosen" value="<?= $hindex_ketua[0]->h_index_scopus; ?>" readonly>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="NIP" class="control-label">Hindex Schoolar</label>
                                                    <input type="NIP" class="form-control" id="NIP-dosen" placeholder="NIP Dosen" value="<?= $hindex_ketua[0]->h_index_schoolar; ?>" readonly>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
 
                                                <div class="col-sm-6">
                                                    <label for="NIDN" class="control-label">Maks. Pengajuan Sebagai Penelitian</label>
                                                    <input type="NIDN" class="form-control" id="NIDN-dosen" placeholder="NIDN Dosen" value="<?= $hindex_ketua[0]->limit_penelitian; ?> Kali" readonly>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="NIDN" class="control-label">Maks. Pengajuan Sebagai Pengabdian</label>
                                                    <input type="NIDN" class="form-control" id="NIDN-dosen" placeholder="NIDN Dosen" value="<?= $hindex_ketua[0]->limit_pengabdian; ?> Kali" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div>
                                            <h5 style="color: red;">Dosen Belum diberi Limit</h5>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <div class="row">
                                             <div class="col-sm-12">
                                                <label for="NIDN" class="control-label col-sm-2">Link Scopus</label>
                                                <label for="NIDN" class="control-label col-sm-1" >:</label>
                                                <a target="_blank" href="<?=!empty($dosen->link_scopus) ? $dosen->link_scopus : "#" ?>"><?= !empty($dosen->link_scopus) ? $dosen->link_scopus : "-" ?></a>
                                            </div> 
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-12">
                                                <label for="NIDN" class="control-label col-sm-2">Link Google Scholar</label>
                                                <label for="NIDN" class="control-label col-sm-1" >:</label>
                                                <a target="_blank" href="<?=!empty($dosen->link_googlescholar) ? $dosen->link_googlescholar : "#" ?>"><?= !empty($dosen->link_googlescholar) ? $dosen->link_googlescholar : "-" ?></a>
                                            </div> 
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="tab-pane" id="histori">
                                    <div class="col-12 mb-3">
                                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item"><a class="nav-link tablur active" data-status="0" href="#">PNBP</a></li>
                                                <li class="nav-item"><a class="nav-link tablur" data-status="1" href="#">Mandiri</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <input type="hidden" name="nip" value="<?= $id; ?>">
                                    <h5 class="text-center">Riwayat Pengajuan PNBP</h5>
                                    <div class="table-responsive text-nowrap">
                                        <table id="historitb" class="table table-bordered table-striped" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="col-auto">Dibuat</th>
                                                    <th scope="col" class="col-md-auto">Judul</th>
                                                    <th scope="col" class="col-md-auto">Tema</th>
                                                    <th scope="col" class="col-auto">Tahun Pengajuan</th>
                                                    <th scope="col" class="col-md-auto">Jenis</th>
                                                    <th scope="col" class="col-md-auto">Status</th>
                                                    <th scope="col" class="col-md-auto">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="isi_histori">

                                            </tbody>
                                        </table>
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

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    const check_duplicate = function(val,type){
        const nip_old = $("input[name='nip_old']").val();
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: BASE_URL + "C_master_data/check_duplicate",
                type: "GET",
                data: {nip: nip_old, nilai: val, jenis: type},
                success: function(res){
                    resolve(res) 
                }
            })
        });
    };

    const element = {
        ktp: "input[name='nik']",
        email: "input[name='email']",
        telepon: "input[name='telepon']",
        alamat: "textarea[name='alamat']",
        nidn: "input[name='nidn']",
        nip: "input[name='nip']",
        sinta: "input[name='sinta']",
        scopus: "input[name='scopus']"
    }; 

    const validate_email = function(email) {
        const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    };

    const clear_error = function(){
        $(element.ktp).parent().find('h5').remove();
        $(element.email).parent().find('h5').remove();
        $(element.telepon).parent().find('h5').remove();
        $(element.nip).parent().find('h5').remove();
        $(element.alamat).parent().find('h5').remove();
        $(element.nidn).parent().find('h5').remove();
        $(element.sinta).parent().find('h5').remove();
        $(element.scopus).parent().find('h5').remove();
        // $(element.hindex).parent().find('h5').remove();
        // $(element.hindex_scopus).parent().find('h5').remove();
        // $(element.file_cv).parent().find('h5').remove();
    };    

    const validate_number = function(num){
        const z = num  % 1; 
        if(isNaN(z)){
            return false;
        } 
        
        return true;
    };

    const validasi =  function(){
        return new Promise(async function(resolve,reject){
            clear_error();
        const state = {
            ktp: false,
            email: false,
            telepon: false,
            alamat: true,
            nidn: false,
            sinta: false,
            scopus: false,
        }; 

        const err = function(msg){
            return `<h5 class="error-all" style='color:red;margin-top:2px;font-size:14px;'>${msg}</h5>`;
        };

        if($(element.ktp).val() === ""){
            state.ktp = true;  
            $(element.ktp).parent().find('h5').remove();
        }else{
            if(validate_number($(element.ktp).val())){
                ktp_check = await check_duplicate($(element.ktp).val(),"nik")
                    if(!ktp_check){
                        state.ktp = false;        
                        $(element.ktp).parent().append(err("nik duplikat!"));
                    } else{
                        state.ktp = true;        
                        $(element.ktp).parent().find('h5').remove();
                    }
            }else {
                state.ktp = false;
                $(element.ktp).parent().append(err("karakter no ktp harus angka"));
            }

        }     
        
        if($(element.nip).val() === ""){
            state.nip = true;  
            $(element.nip).parent().find('h5').remove();
        }else{
            if(validate_number($(element.nip).val())){
                nip_check = await check_duplicate($(element.nip).val(),"nip")
                console.log(nip_check);
                    if(!nip_check){
                        state.nip = false;  
                        $(element.nip).parent().append(err("nip duplikat!"));
                    } else{ 
                        state.nip = true;  
                        $(element.nip).parent().find('h5').remove();
                    }
            } else{ 
                state.nip = false;
                $(element.nip).parent().append(err("karakter nip harus angka"));
            }

        }             

        if($(element.nidn).val() === ""){
            state.nidn = true;  
            $(element.nidn).parent().find('h5').remove();
        }else{
            if(validate_number($(element.nidn).val())){
                nidn_check = await check_duplicate($(element.nidn).val(),"nidn")
                if(!nidn_check){
                    state.nidn = false;  
                    $(element.nidn).parent().append(err("nidn duplikat!"));
                } else{ 
                    state.nidn = true;  
                    $(element.nidn).parent().find('h5').remove();
                }
            } else{ 
                state.nidn = false;
                $(element.nidn).parent().append(err("karakter nidn harus angka"));
            }
        }        

        if($(element.telepon).val() === ""){
            state.telepon = true;  
            $(element.telepon).parent().find('h5').remove();
        }else{
            if(validate_number($(element.telepon).val())){
                if($(element.telepon).val().trim().length > 13){
                    state.telepon = false;
                    $(element.telepon).parent().append(err("karakter harus angka"));
                }
                telp_check = await check_duplicate($(element.telepon).val(),"telepon")
                    if(!telp_check){
                        state.telepon = false;  
                        $(element.telepon).parent().append(err("telepon duplikat!"));
                    } else{ 
                        state.telepon = true;  
                        $(element.telepon).parent().find('h5').remove();
                    }
            } else{ 
                state.telepon = false;
                $(element.telepon).parent().append(err("karakter telepon harus angka"));
            }
        }    

        if($(element.email).val() === ""){
            state.email = true;  
            $(element.email).parent().find('h5').remove();
        }else{
            if(validate_email($(element.email).val())){
                const mail = $(element.email).val().split('@');
                if(mail[1] == "polije.ac.id"){
                    email_check = await check_duplicate($(element.email).val(),"email")
                        if(!email_check){
                            state.email = false;  
                            $(element.email).parent().append(err("email duplikat!"));
                        } else { 
                            state.email = true;  
                            $(element.email).parent().find('h5').remove();
                        }
                }else{ 
                    state.email = false;
                    $(element.email).parent().append(err("email harus @polije.ac.id"));
                }
            }else{ 
                state.email = false;
                $(element.email).parent().append(err("karakter harus email"));
            }
        }        

        if($(element.sinta).val() === ""){
            state.sinta = true;  
            $(element.sinta).parent().find('h5').remove();
        }else{
            if(validate_number($(element.sinta).val())){
                sinta_check = await check_duplicate($(element.sinta).val(),"sinta");
                    if(!sinta_check){
                        state.sinta = false;  
                        $(element.sinta).parent().append(err("sinta duplikat!"));
                    } else { 
                        state.sinta = true;  
                        $(element.sinta).parent().find('h5').remove();
                    }
            }else {
                state.sinta = false;
                $(element.sinta).parent().append(err("karakter sinta harus angka"));
            } 
        }        

        if($(element.scopus).val() === ""){
            state.scopus = true;  
            $(element.scopus).parent().find('h5').remove();
        }else{
            if(validate_number($(element.scopus).val())){
                scopus_check = await check_duplicate($(element.scopus).val(),"scopus")
                    if(!scopus_check){
                        state.scopus = false;  
                        $(element.scopus).parent().append(err("scopus duplikat!"));
                    } else {
                        state.scopus = true;  
                        $(element.scopus).parent().find('h5').remove();
                    }
            }else{
                state.scopus = false;
                $(element.scopus).parent().append(err("karakter scopus harus angka"));
            }
        }  

        if(state.ktp === true && state.email === true && state.telepon === true && state.sinta === true && state.scopus === true && state.nidn === true){
            console.log(state);
            resolve(true) ;
        } 

            resolve(false);  
        });
       
    }

    $(document).ready(function(){
        $("#unit_select").select2();

        $(".ganti").on('click', function(e){
            e.preventDefault();
            validasi().then(function(res){
                if(res){
                    $("#form-update").submit();
                    return;
                }
            });
        });
    });
</script>
<script type="text/javascript" src="<?= base_url() . JS_UMUM . 'master_detail_user.js?' . 'random=' . uniqid() ?>"></script>
<script>
    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>