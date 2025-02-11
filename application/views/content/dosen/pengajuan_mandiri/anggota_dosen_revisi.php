
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
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row-m2">
                <div class="col-sm-6">
                    <h1><?= $judul ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?= "" ?></li>
                    </ol>
                </div>
            </div>
        </div>
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
                                <div class="col-12 col-md-6" >
                                   <h3 class="text-left">Data ketua</h3> 

                                <div class="col-md-12">
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
                                                <input type="number" class="form-control" readonly name="sinta1" value="<?= $dosen['ketua'][0]->sinta ?>" id="id_sinta1" onkeydown="return event.keyCode !== 69" name="id_sinta">
                                            
                                            </div>
                                            <div class="err-sinta1" style="display:none;">
                                                <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                            </div>
                                        </div>
                                    </div>  
                                 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="file_cv">File CV</label>
                                            <div>
                                            <a target="_blank" href="<?=base_url('assets/berkas/file_cv/').$dosen['ketua'][0]->file_cv ?>" class="cvnya"><?= $dosen['ketua'][0]->file_cv ?></a>
                                            </div>
                                        </div>
                                    </div>
                                                                    
                                    <!-- <div class="col-12">
                                        <button class="btn btn-success" id="simpan-ketua">Simpan Data Ketua</button>
                                    </div> -->
                                </div>
                                <div class="col-12 col-md-6">
                                   <h3 class="text-left">Data Anggota <span style="color:red; font-size:15px;">(slot anggota = 4)</span></h3>
                                    <a href="#" id="tambah-anggota" class="btn btn-sm btn-primary mt-2 text-lef">Tambahkan Anggota</a>
                                    <div id="list-anggota" >

                                    </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <div class="modal fade" id="add-anggota-modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Data Anggota</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="col-md-12">
                  <div class="form-group">
                      <label for="ketua">1. NIP</label>                         
                      <select class="form-control select2 nm_dosen" style="width: 100%;" id="anggota1" name="nip2">
                          <option value="">-- Cari NIP Dosen --</option>
                          <?php foreach($dosen['dosen'] as $dsn): ?>
                              <option value="<?= $dsn->nidn ?>"><?= $dsn->nidn . " - ". $dsn->nama ?> </option>
                          <?php endforeach; ?>
                      </select>
                      <div class="err-anggota-nip" style="display:none;">
                          <h5 style="font-size: 16px; color: red;" class="text-left"></h5>
                      </div>
                  </div>
              </div>                    
              <div class="col-md-12">
                  <div class="form-group">
                          <label for="nidn">2. NAMA DOSEN</label>
                          <div class="custom-file">
                              <input type="text" class="form-control" id="nama2" name="nama2" value="" disabled>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="jurusan">3. Jurusan</label>
                          <div class="custom-file">
                              <input type="text" class="form-control" id="jurusan2" name="jurusan2" value="" disabled>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="pangkat">4. Pangkat / Jabatan Fungsional</label>
                          <div class="custom-file">
                              <input type="text" class="form-control" id="pangkat2" name="pangkat2" value="" disabled>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="id_sinta">5. ID-Sinta <span style="color:red;">*</span></label>
                          <div class="custom-file">
                              <input type="number" class="form-control" name="sinta1" value="" id="id_sinta2" readonly onkeydown="return event.keyCode !== 69" name="id_sinta">
                                            
                          </div>
                          <div class="err-sinta2" style="display:none;">
                              <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                          </div>
                      </div>
                  </div>  

        

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="button" id="simpan-anggota" class="btn btn-primary">Simpan Data</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      </div>
      <div class="modal fade" id="edit-anggota-modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Data Anggota</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="col-md-12">
                  <div class="form-group">
                      <label for="ketua">1. NIP</label>                         
                      <input class="form-control" type="text" id="nip-edit" value="" disabled  > 
                  </div>
              </div>                    
              <div class="col-md-12">
                  <div class="form-group">
                          <label for="nidn">2. NAMA DOSEN</label>
                          <div class="custom-file">
                              <input type="text" class="form-control" id="nama-edit" value="" disabled>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="jurusan">3. Jurusan</label>
                          <div class="custom-file">
                              <input type="text" class="form-control" id="jurusan-edit"  value="" disabled>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="pangkat">4. Pangkat / Jabatan Fungsional</label>
                          <div class="custom-file">
                              <input type="text" class="form-control" id="pangkat-edit" value="" disabled>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="id_sinta">5. ID-Sinta <span style="color:red;">*</span></label>
                          <div class="custom-file">
                          <input type="hidden" id="id-edit">
                              <input type="number" class="form-control" readonly id="sinta-edit" onkeydown="return event.keyCode !== 69" >
                                            
                          </div>
                          <div class="err-sinta-edit" style="display:none;">
                              <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                          </div>
                      </div>
                  </div>  
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="labelCvAnggota">File CV</label>
                        <div>
                        <a href="#" target="_blank" class="label-cv"></a>
                        </div>
                    </div>
                  </div>
            <div class="modal-footer ">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <!-- <button type="button" id="edit-anggota" class="btn btn-primary">Simpan Data</button> -->
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    </section>
</div>

<script>
    const dosen = <?= json_encode($dosen['dosen']); ?>;
    const find_dosen = (nidn) => {
        const data = dosen.find((el) => el.nidn === nidn);
        return data;
    };
   const regex = /[\/\\]([\w\d\s\.\-\(\)]+)$/;
   const regex2 = new RegExp("(.*?)\.(pdf)$");
    const list_anggota = function(){
        get_anggota().then(res => {
                if(res.data.length >= 5){
                    $("#tambah-anggota").hide();
                }else{
                    $("#tambah-anggota").show();
                 }
                let html = '';
                res.data.forEach(item => {
                    if(item.nip !== "<?= $this->session->userdata('nidn');?>"){
                    html += `
                    <div class="info-box mt-3" style="position:relative;">
                        <div class="" style="position: absolute;top: 0px;right: 5px;">
                        <a style="font-size:15px;" data-id="${item.id_anggota}" class="btn btn-primary lihat-anggota" href="#">Lihat</a>
                        </div> <span class="info-box-icon bg-${item.status == 1 ? 'warning' : 'success'}"><i class="fa ${item.status == 1 ? 'fa-hourglass-half' : 'fa-check-circle'}"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">${item.nip}</span>
                            <span class="info-box-text">${item.nama}</span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>`;
                    }
                });
                $('#list-anggota').html(html);
                return view_anggota();
        });
    };    
    const view_anggota = function(){
        $('a.lihat-anggota').on('click', function(e){
            e.preventDefault();
            const id = $(this).data('id');
            get_anggota(id).then(res => {
                $('#nip-edit').val(res.data[0].nip);
                $('#id-edit').val(id);
                $('#nama-edit').val(res.data[0].nama);
                $('#jurusan-edit').val(res.data[0].unit);
                $('#pangkat-edit').val(res.data[0].jenis_unit);
                $('#sinta-edit').val(res.data[0].sinta);
                $('#edit-cv').val("");
                $('#labelCvEdit').text("");
                if(res.data[0].file_cv ==  "" || res.data[0].file_cv == null){
                    $('.label-cv').attr(`href`,'#');
                    $('.label-cv').attr('target',"_self");
                    $('.label-cv').text(`-`);
                } else{
                    $('.label-cv').text(`${res.data[0].file_cv}`);
                    $('.label-cv').attr('href',`<?= base_url('assets/berkas/file_cv/')?>${res.data[0].file_cv}`);
                }
                $('#edit-anggota-modal').modal('show');
                return edit_anggota();
            });
        });
    };
    const edit_anggota = function(){
        $('button#edit-anggota').one('click',function(e){
            e.preventDefault();
            $('#overlay').fadeIn(100);
            const id_anggota = $('#id-edit').val();
            if(validasi("anggota-edit")){
               const form_data = new FormData();
               form_data.append("id_anggota",id_anggota);
               form_data.append('sinta', $('#sinta-edit').val());
               form_data.append('id_detail', "<?= $id_pengajuan; ?>");
               if($('#cv-edit').val() != '') {
                form_data.append("cv", $('#cv-edit')[0].files[0]);
               }
               return update(form_data).then(res => {
                 if(res.status == "ok"){
                    $('#overlay').fadeOut(500)
                    $('#edit-anggota-modal').modal("hide");
                    return list_anggota();
                 }
               });
            }
        });
    };
   $('select[name="nip2"]').select2();
    const get_anggota = function(id = null){
        let url = `<?= base_url('pengajuan_mandiri/anggota_dosen_revisi/get_anggota_dosen')?>`;
        if(id !== null) url += `/${id}`;
        return new Promise((resolve,reject) => {
            $.ajax({
                url: url, 
                dataType: 'json',
                type: 'GET',
                success: res => resolve(res)
            });
        });
    };
    const insert = function(form_data){
        let url = `<?= base_url('pengajuan_mandiri/anggota_dosen_revisi/store')?>`;
        return new Promise((resolve,reject) => {
            $.ajax({
                url: url,
                dataType: 'json',
                type: 'post',
                processData:false,
                contentType: false,
                data: form_data,
                success: res => resolve(res)
            });
        });
    };
    const update = function(form_data){
        let url = `<?= base_url('pengajuan_mandiri/anggota_dosen_revisi/update')?>`;
        return new Promise((resolve,reject) => {
            $.ajax({
                url: url,
                dataType: 'json',
                type: 'post',
                processData:false,
                contentType: false,
                data: form_data,
                success: res => resolve(res)
            })
        });
    };
    const validasi = function (jenis){
        let status = {nip:false,sinta:true,cv:true};
        if(jenis === 'ketua' || jenis === 'ketua-edit'){
            status.nip = true;
            const id_sinta = $('#id_sinta1').val();
            const cv = $('#cvKetua').val();
            // if(id_sinta === ""){
            //     status.sinta = false;
            //     $('.err-sinta1>h5').text("tidak boleh kosong");
            //     $('.err-sinta1').show();
            // } else { 
            //     const sinta_split = id_sinta.split('');
            //     if(sinta_split.length > 8){
            //         status.sinta = false;
            //         $('.err-sinta1>h5').text("karakter lebih dari 8");
            //         $('.err-sinta1').show();
            //     }else{
            //         status.sinta = true;
            //         $('.err-sinta1').hide();
            //     }
            // }
            // if(jenis === 'ketua-edit'){
            //     status.cv = true;
            // } else {
            //     if(cv === ""){
            //         status.cv = false;
            //         $('.err-cv-ketua>h5').text("harus melampirkan cv");
            //         $('.err-cv-ketua').show();
            //     }else {
            //         status.cv = true;
            //         $('err-cv-ketua').hide();
            //     }
            // }
        } else { 
            let id_sinta = $('#id_sinta2').val();
            let cv = $('#cvAnggota').val();
            let nip = $('#anggota1').val();

            if(jenis === 'anggota-edit'){
                id_sinta = $('#sinta-edit').val();
                nip = $('#nip-edit').val();
                cv = $('#cv-edit').val();
            }

            if(nip === ""){
                status.nip = false;
                $('.err-anggota-nip>h5').text("tidak boleh kosong");
                $('.err-anggota-nip').show();
            }else {
                status.nip = true;
                $('err-anggota-nip').hide();
            }
            // if(id_sinta === ""){
            //     status.sinta = true;
            //     if(jenis === 'anggota-edit'){
            //         $('.err-sinta-edit>h5').text("tidak boleh kosong");
            //         $('.err-sinta-edit').show();
            //     } else { 
            //         $('.err-sinta2>h5').text("tidak boleh kosong");
            //         $('.err-sinta2').show();
            //     }
            // } else { 
            //     const sinta_split = id_sinta.split('');
            //     if(sinta_split.length > 8){
            //         status.sinta = false;
            //         $('.err-sinta2>h5').text("karakter lebih dari 8");
            //         $('.err-sinta2').show();
            //     }else{
            //         status.sinta = true;
            //         $('.err-sinta2').hide();
            //     }
            // }
            // if(jenis === 'anggota-edit'){
            //     status.cv = true;
            // } else {
            //     if(cv === ""){
            //         status.cv = false;
            //         $('.err-cv-anggota>h5').text("harus melampirkan cv");
            //         $('.err-cv-anggota').show();
            //     }else {
            //         status.cv = true;
            //         $('.err-cv-anggota').hide();
            //     }
            // }
        }

        if(status.nip === true && status.sinta === true && status.cv){
            return true;
        } else { 
            return false;
        }
    };
    $('#cvKetua').on('change', function() {
        $('.err-cv-ketua').hide();
        const file = this.files[0];
        const value = $(this).val().toLowerCase();
      

        if(!(regex2.test(value))){
            $('.err-cv-ketua>h5').text("file cv harus PDF");
            $('.err-cv-ketua').show();

            $(this).val('');
            return;
        } else{ 
            $('.err-cv-ketua').hide();
        }

        const fileName = $(this).val();
        $('#labelcvKetua').text(fileName.match(regex)[1]);
   });
   $('#cvAnggota').on('change', function(){
        $('.err-cv-anggota').hide();
        const file = this.files[0];
        const value = $(this).val().toLowerCase();
    

        if(!(regex2.test(value))){
            $('.err-cv-anggota>h5').text("file cv harus PDF");
            $('.err-cv-anggota').show();

            $(this).val('');
            return;
        } else{ 
            $('.err-cv-anggota').hide();
        }

        const fileName = $(this).val();
        $('#labelCvAnggota').text(fileName.match(regex)[1]);   
    });
    $('#cv-edit').on('change',function(){
        console.log('hello') ;
        $('.err-cv-anggota-edit').hide();
        const file = this.files[0];
        const value = $(this).val().toLowerCase();
    

        if(!(regex2.test(value))){
            $('.err-cv-anggota-edit>h5').text("file cv harus PDF");
            $('.err-cv-anggota-edit').show();
            $(this).val('');
            $('#labelCvEdit').text('');   
            return;
        } else{ 
            $('.err-cv-anggota-edit').hide();
        }

        const fileName = $(this).val();
        $('#labelCvEdit').text(fileName.match(regex)[1]);   
    });
   $('select[name="nip2"]').on('change',function(){
        const nip = $(this).val();
        if (nip !== "") {
            const data = find_dosen(nip);
            $("#nama2").val(data.nama);
            $("#jurusan2").val(data.unit);
            $("#pangkat2").val(data.jenis_job);
            $("#id_sinta2").val(data.sinta);
        } else {
            $("#nama2").val("");
            $("#jurusan2").val("");
            $("#pangkat2").val("");
            $("#id_sinta2").val("");
        }
   });
    // $('#simpan-ketua').on('click' ,function(e){
    //     e.preventDefault();
    //     get_anggota().then(res => {
    //         const form_data = new FormData();
    //         form_data.append("sinta", $('#id_sinta1').val());
    //         form_data.append("id_detail", "<?= $id_pengajuan ?>");
    //         if(res.data.length > 0){
    //             if(validasi("ketua-edit")){
    //                 form_data.append("id_anggota",$('#id_anggota_ketua').val());
    //                 if($('#cvKetua').val() != '') {
    //                     form_data.append("cv", $('#cvKetua')[0].files[0]);
    //                 }
    //                 return update(form_data).then(res => {
    //                     if(res.status == 'ok'){
    //                         window.location.reload();
    //                     }
    //                 });
    //             }
    //         } else { 
    //             if(validasi("ketua")){
    //                 form_data.append("cv", $('#cvKetua')[0].files[0]);
    //                 form_data.append("nip", "<?= $this->session->userdata('nidn'); ?>");

    //                 return insert(form_data).then(res => {
    //                     if(res.status == true){
    //                         window.location.reload();
    //                     }
    //                 });
    //             }
    //         }
    //     });
    // });
    $('#simpan-anggota').on('click', function(e){
        e.preventDefault();
        get_anggota().then(res => {
            if(res.data.length < 5){
                if(validasi("anggota'")){
                    const form_data = new FormData();
                    // form_data.append("cv", $("#cvAnggota")[0].files[0]);
                    form_data.append("id_detail", "<?= $id_pengajuan ?>");
                    form_data.append("nip", $('select[name="nip2"]').val());
                    form_data.append("sinta", $('#id_sinta2').val());


                    return insert(form_data).then(res => {
                        list_anggota();
                        $('#add-anggota-modal').modal('hide');
                        window.location.reload();
                        //refresh anggota 
                    });
                }
            }
        });
    });
    $('#tambah-anggota').on('click', function(e){
        $('#add-anggota-modal').modal('show');
        // get_anggota().then(res => {
        //     //saat ketua belum isi data diri dan anggota sudah 4 tidak show modal
        //     if(res.data.length > 0 && res.data.length < 5){
        //         $('#add-anggota-modal').modal('show');
        //     }else{
        //     }
        // })

    });
    list_anggota();
</script>