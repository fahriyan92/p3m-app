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

                            <h3 class="profile-username text-center"><?php echo $this->session->userdata('nama'); ?> </h3>

                            <p class="text-muted text-center"><?php echo $dosen[0]->jenis_job;  ?></p>

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
                            <div class="tab-content">
                                <div class="tab-pane active" id="settings">
                                <form action="<?= site_url('C_master_data/update_profile') ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="form_bagian" value="bagian_dosen">
                                 <div class="row">
                                    <div class="col-sm-12">
                                        <h5>Data Personal</h5>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                            <label for="nik" class=" control-label">No KTP</label>
                                                <input type="text" class="form-control" id="nik-dosen" name="nik" placeholder="No KTP Dosen" value="<?= $dosen[0]->nik ?>">
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
                                                <!-- <input type="text" class="form-control" id="gender-dosen" name="gender" placeholder="Jenis Kelamin" value="<?= $dosen[0]->jenis_kelamin ?>"> -->

                                            </div>
                                        
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                               <label for="email-dosen" class="control-label">Email</label>

                                                <input type="email" class="form-control" id="email-dosen" name="email" placeholder="Email Dosen" value="<?= $dosen[0]->email ?>">
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

                                                <input type="text" class="form-control" id="telepon-dosen" name="telepon" placeholder="Nomer HP Dosen" value="<?= $dosen[0]->telepon ?>">

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

                                                <input type="NIP" class="form-control" id="NIP-dosen" name="nip" placeholder="NIP Dosen" value="<?= $dosen[0]->nidn; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="nidn-dosen" class=" control-label">NIDN</label>
                                            <input type="type" class="form-control" name="nidn" id="nidn-dosen" placeholder="NIDN" value="<?= $dosen[0]->nidn_real; ?>">
                                        </div>
                                    </div>
                                    </div>           
                                    </div>

                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                        <label for="unit" class="control-label">Jenis Unit</label>

                                        <input type="unit" class="form-control" id="unit-dosen" placeholder="Unit Dosen" name="jenis_unit" value="<?= $dosen[0]->jenis_unit ?>" readonly>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                        <label for="unit" class="control-label">Unit</label>
                                        <input type="unit" class="form-control" id="unit-dosen" placeholder="Unit Dosen" name="unit" value="<?= $dosen[0]->unit ?>" readonly>
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
                                                </select>                     

                                        </div>
                                       
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label for="golongan" class=" control-label">Golongan</label>
                                                <select class="form-control" name="golongan" id="golongan">
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
                                                <input type="sinta" class="form-control" id="sinta-dosen" name="sinta" placeholder="ID Sinta" value="<?= $dosen[0]->sinta ?>">
                                                </div>
                                            </div>
                                        </div>   

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="hindex" class=" control-label">H Index</label>
                                                    <input type="text" class="form-control" id="hindex" name="hindex" placeholder="H Index" value="<?= $dosen[0]->hindex ?>">
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
                                                <!-- <input type="text" class="form-control" id="golongan-dosen" name="golongan" placeholder="Golongan Dosen" value="<?= $dosen[0]->golongan ?>"> -->
    
                                            </div>
                                        
                                        </div>
                                    </div>                                        

                                        <div class="col-sm-6">
                                          <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="cvKetua">Unggah File CV</label>

                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="fileCv" name="file_cv" hidden="hidden">
                                                        <label class="custom-file-label" for="fileCv" id="labelproposal">Pilih file</label>
                                                    </div>
                                                    <span style="color:red;">* Isi Jika ingin mengganti / menambahkan cv </span>
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


<script>
    $('.table-bordered').DataTable();

    const regex = /[\/\\]([\w\d\s\.\-\(\)]+)$/;
    $('#fileCv').on('change', function() {
        const regex2 = new RegExp("(.*?)\.(pdf|doc|docx)$");
        $('.err-proposal').hide();
        const file = this.files[0];
        const value = $(this).val().toLowerCase();
      

        if(!(regex2.test(value))){
            $('.err-proposal').show();

            $(this).val('');
            return;
        } else{ 
            $('.err-proposal').hide();
        }          
        const fileName = $(this).val();
        $('#labelproposal').text(fileName.match(regex)[1]);
    });


    $(window).on("load", function() {
        $('#overlay').fadeOut(400);
    });
</script>