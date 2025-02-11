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
                <form action="<?= site_url('pengajuan_mandiri_pengabdian/unggah_berkas/store') ?>" method="post" enctype="multipart/form-data">

                    <div class="row">
                    <h3 class="text-left">File Proposal <span style="color:red;">*</span></h3>

                    <?php if($dokumen->file_proposal != NULL): ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="id_sinta">File Proposal</label>
                            <input type="hidden" name="proposal_lama" value="<?= $dokumen->file_proposal ?>">
                            <h5 class="text-left"><a href="<?= base_url('assets/berkas/file_proposal/').$dokumen->file_proposal  ?>" target="_blank"><?= $dokumen->file_proposal ?></a></h5>
                        </div>
                    </div>                    
                    <?php endif; ?>
                    
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cvKetua">1. Unggah File Proposal <?= $dokumen->file_proposal != NULL ? '<span style="color:red;">(Jika tidak ingin mengganti cv bisa dikosongi)</span>' : '<span style="color:red;">*</span>' ?> </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="filePrposal" name="file_proposal" hidden="hidden">
                                    <label class="custom-file-label" for="filePrposal" id="labelproposal">Pilih file</label>
                                </div>
                                <?= form_error('file_proposal', '<h5  class="text-left" class="text-left" style="color:red;font-size: 16px;">','</h5>') ;?> 
                                <div class="err-proposal" style="display:none;">
                                    <h5 style="font-size: 16px; color: red;" class="text-left">Ekstensi File Tidak Didukung!</h5>
                                </div>
                            </div>
                        </div>
                        <?php if($dokumen->file_rab != NULL): ?>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="id_sinta">File RAB</label>
                                <input type="hidden" name="rab_lama" value="<?= $dokumen->file_rab ?>">
                                <h5 class="text-left"><a href="<?= base_url('assets/berkas/file_rab/').$dokumen->file_rab  ?>" target="_blank"><?= $dokumen->file_rab ?></a></h5>
                            </div>
                        </div>                    
                     <?php endif; ?>                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cvKetua">2. Unggah File RAB <?= $dokumen->file_rab != NULL ? '<span style="color:red;">(Jika tidak ingin mengganti cv bisa dikosongi)</span>' : '<span style="color:red;">*</span>' ?> </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="fileRab" name="file_rab" hidden="hidden">
                                    <label class="custom-file-label" for="fileRab" id="labelrab">Pilih file</label>
                                </div>
                                <?= form_error('file_rab', '<h5  class="text-left" class="text-left" style="color:red;font-size: 16px;">','</h5>') ;?> 
                                <div class="err-rab" style="display:none;">
                                    <h5 style="font-size: 16px; color: red;" class="text-left">Ekstensi File Tidak Didukung!</h5>
                                </div>
                            </div>
                        </div>                        
                        <hr>   
                        <div class="row">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-<?=$mode === 'edit' ? 'warning' : 'success'?>"><?=$mode === 'edit' ? 'Edit' : 'Simpan'?></button>
                        </div>
                         </div>
                    </form>
                    </div>    
                    

                    </div>
                </div>
            </div>
        </div>
</div>

</section>

 </div>

 <script>
    const regex = /[\/\\]([\w\d\s\.\-\(\)]+)$/;
    $('#filePrposal').on('change', function() {
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

    $('#fileRab').on('change', function() {
        const regex2 = new RegExp("(.*?)\.(xls|xlsx|docx|pdf|doc)$");
        $('.err-rab').hide();
        const file = this.files[0];
        const value = $(this).val().toLowerCase();
      

        if(!(regex2.test(value))){
            $('.err-rab').show();

            $(this).val('');
            return;
        } else{ 
            $('.err-rab').hide();
        }          
        const fileName2 = $(this).val();
        $('#labelrab').text(fileName2.match(regex)[1]);
    });

 </script>