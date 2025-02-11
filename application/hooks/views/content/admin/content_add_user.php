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
            <div class="card">
                <div class="card-header">
                    <h5>Tambahkan User Dosen/PLP</h5>
                </div>
                <div class="card-body">
                <form action="<?= site_url('C_master_data/insertuser'); ?>" method="POST">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputJudul">1. NIP</label>
                            <div class="err-judul" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                            <input type="text" value="<?= isset($identitas) ? set_value('nip') == true ? set_value('nip') : $identitas->judul : set_value('nip') ?>" class="form-control" placeholder="NIP" name="nip">
                            <?= form_error('nip', '<h5 style="color:red;font-size: 16px;">','</h5>') ;?> 
                        </div>
                    </div>
                </div>                       
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputJudul">2. NAMA LENGKAP</label>
                            <div class="err-judul" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                            <input type="text" value="<?= isset($identitas) ? set_value('nama') == true ? set_value('nama') : $identitas->judul : set_value('nama') ?>" class="form-control" placeholder="Nama Lengkap" name="nama">
                            <?= form_error('nama', '<h5 style="color:red;font-size: 16px;">','</h5>') ;?> 
                        </div>
                    </div>
                </div>                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputJudul">3. EMAIL (@polije.ac.id)</label>
                            <div class="err-judul" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                            <input type="email" value="<?= isset($identitas) ? set_value('email') == true ? set_value('email') : $identitas->judul : set_value('email') ?>" class="form-control" placeholder="Email" name="email">
                            <?= form_error('email', '<h5 style="color:red;font-size: 16px;">','</h5>') ;?> 
                        </div>
                    </div>
                </div>                    
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputJudul">4. BADGE</label>
                            <div class="err-judul" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                            <input type="number" value="<?= isset($identitas) ? set_value('badge') == true ? set_value('badge') : $identitas->judul : set_value('badge') ?>" class="form-control" placeholder="badge" name="badge">
                            <?= form_error('badge', '<h5 style="color:red;font-size: 16px;">','</h5>') ;?> 
                        </div>
                    </div>
                </div>                              
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputJudul">5. JENIS UNIT</label>
                            <div class="err-judul" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                            <select class="form-control" name="jenis_unit">
                                <option value="LABOLATORIUM">LABOLATORIUM</option>
                                <option value="JURUSAN">JURUSAN</option>
                                <option value="PROGRAM STUDI">PROGRAM STUDI</option>
                                <option value="UPT">UPT</option>
                                <option value="PUSAT">PUSAT</option>
                                <option value="UNIT">UNIT</option>
                            </select>
                            <?= form_error('jenis_unit', '<h5 style="color:red;font-size: 16px;">','</h5>') ;?> 
                        </div>
                    </div>
                </div>                              
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputJudul">6. UNIT</label>
                            <div class="err-judul" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                            <input type="text" value="<?= isset($identitas) ? set_value('unit') == true ? set_value('unit') : $identitas->judul : set_value('unit') ?>" class="form-control" placeholder="unit" name="unit">
                            <?= form_error('unit', '<h5 style="color:red;font-size: 16px;">','</h5>') ;?> 
                        </div>
                    </div>
                </div>                      
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputJudul">7. JENIS USER</label>
                            <div class="err-judul" style="display:none;">
                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                            </div>
                            <select class="form-control" name="jenis_user">
                                <option value="dosen">DOSEN</option>
                                <option value="plp">PLP</option>
                            </select>
                            <?= form_error('jenis_user', '<h5 style="color:red;font-size: 16px;">','</h5>') ;?> 
                        </div>
                    </div>
                </div>                              
                <hr>
                <div class="row">
                    <div class="col-6 text-left">
                    <a href="<?= site_url('C_master_data'); ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                    <div class="col-6 text-right">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </section>