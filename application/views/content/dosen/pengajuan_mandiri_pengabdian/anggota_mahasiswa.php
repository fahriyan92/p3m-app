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

   <!-- Main content -->
   <section class="content">
   <?php  if($this->session->flashdata('key')): ?>
    <div class="alert alert-<?= $this->session->flashdata('key') ?> alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata($this->session->flashdata('key'));?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>  
        
<?php  endif; ?>   
   <?php //print_r($identitas) ?>
   
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <?php //row ?>
                                <form action="<?= $mode === 'tambah' ? site_url('pengajuan_mandiri_pengabdian/anggota_mahasiswa/store') : site_url('pengajuan_mandiri_pengabdian/anggota_mahasiswa/edit')?>" method="post">

                                        

                            <?php //atas row ?>   
                            <h3 class="text-left">Data Mahasiswa 1 <span style="color:red;">*</span></h3>
                            <div class="row">
                                <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputJudul">1. NIM</label>
                                            
                                        <input type="text" value="<?= isset($mahasiswa[0]) ? set_value('nim1') == true ? set_value('nim1') : $mahasiswa[0]->nim : set_value('nim1') ?>"  class="form-control" placeholder="Nomor Induk Mahasiswa" name="nim1">
                                        <?= form_error('nim1', '<h5 style="color:red;font-size: 16px;">','</h5>') ;?> 
                                        
                                </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputJudul">2. Nama</label>
                                        <input type="text" value="<?= isset($mahasiswa[0]) ? set_value('nama1') == true ? set_value('nama1') : $mahasiswa[0]->nama : set_value('nama1') ?>"  class="form-control" id="inputSasaran" placeholder="Nama mahasiswa" name="nama1">
                                    </div>
                                    <?= form_error('nama1', '<h5 style="color:red;font-size: 16px;">','</h5>') ;?> 

                                </div>                                
                            </div>    
                            <?php //batas row ?>       

                            <?php //atas row ?>   
                            <div class="row">
                                <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputJudul">3. Jurusan</label>
                                            
                                        <input type="text" value="<?= isset($mahasiswa[0]) ? set_value('jurusan1') == true ? set_value('jurusan1') : $mahasiswa[0]->jurusan : set_value('jurusan1') ?>"  class="form-control" placeholder="Jurusan" name="jurusan1">
                                        <?= form_error('jurusan1', '<h5 style="color:red;font-size: 16px;">','</h5>') ;?> 
                                        
                                </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputJudul">4. Angkatan</label>
                                        <input type="text" value="<?= isset($mahasiswa[0]) ? set_value('angkatan1') == true ? set_value('angkatan1') : $mahasiswa[0]->angkatan : set_value('angkatan1') ?>"  class="form-control" id="inputSasaran" placeholder="Angkatan" name="angkatan1">
                                    </div>
                                    <?= form_error('angkatan1', '<h5 style="color:red;font-size: 16px;">','</h5>') ;?> 

                                </div>                                
                            </div>    
                            <?php //batas row ?>                                   

                            <hr>

                            <?php //atas row ?>   
                            <h3 class="text-left">Data Mahasiswa 2 <span style="">(Opsional)</span></h3>
                            <div class="row">
                                <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputJudul">1. NIM</label>
                                            
                                        <input type="text" value="<?= isset($mahasiswa[1]) ? set_value('nim2') == true ? set_value('nim2') : $mahasiswa[1]->nim : set_value('nim2') ?>"  class="form-control" placeholder="Nomor Induk Mahasiswa" name="nim2">
                                        <?= form_error('nim2', '<h5 style="color:red;font-size: 16px;">','</h5>') ;?> 
                                        
                                </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputJudul">2. Nama</label>
                                        <input type="text" value="<?= isset($mahasiswa[1]) ? set_value('nama2') == true ? set_value('nama2') : $mahasiswa[1]->nama: set_value('nama2') ?>"  class="form-control" id="inputSasaran" placeholder="Nama mahasiswa" name="nama2">
                                    </div>
                                    <?= form_error('nama2', '<h5 style="color:red;font-size: 16px;">','</h5>') ;?> 

                                </div>                                
                            </div>    
                            <?php //batas row ?>       

                            <?php //atas row ?>   
                            <div class="row">
                                <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputJudul">3. Jurusan</label>
                                            
                                        <input type="text" value="<?= isset($mahasiswa[1]) ? set_value('jurusan2') == true ? set_value('jurusan2') : $mahasiswa[1]->jurusan : set_value('jurusan2') ?>"  class="form-control" placeholder="Jurusan" name="jurusan2">
                                        <?= form_error('jurusan2', '<h5 style="color:red;font-size: 16px;">','</h5>') ;?> 
                                        
                                </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputJudul">4. Angkatan</label>
                                        <input type="text" value="<?= isset($mahasiswa[1]) ? set_value('angkatan2') == true ? set_value('angkatan2') : $mahasiswa[1]->angkatan : set_value('angkatan2') ?>"  class="form-control" id="inputSasaran" placeholder="Angkatan" name="angkatan2">
                                    </div>
                                    <?= form_error('angkatan2', '<h5 style="color:red;font-size: 16px;">','</h5>') ;?> 

                                </div>                                
                            </div>    
                            <?php //batas row ?>                       

                            <div class="row">
                                <div class="col-12 text-right">
                                    <button type="submit" class="btn btn-<?=$mode === 'edit' ? 'warning' : 'success'?>"><?=$mode === 'edit' ? 'Edit' : 'Simpan'?></button>
                                </div>
                            </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
               
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script>

</script>
