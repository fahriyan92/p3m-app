
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
           <!-- SELECT2 EXAMPLE -->
           <div class="card">
             <div class="card-header">
               <div class="row">
                 <div class="col-lg-10 col-md-8 col-sm-2">
                   <h3 class="card-title">P3M POLIJE</h3>
                 </div>
                 <div class="col-lg-2 col-md-4 col-sm-1">
                   <a href="<?= base_url('C_event/tambah_event'); ?>" class="btn btn-primary"> <i class="fa fa-plus"></i> TAMBAH EVENT</a>
                 </div>
               </div>
             </div>
             <!-- /.card-header -->
             <div class="card-body">
               <div class="table-responsive">

                 <table id="example1" class="table table-bordered table-striped">
                   <thead>
                     <tr>
                       <th>Judul Event</th>
                       <th>Event dimulai</th>
                       <th>Event ditutup</th>
                       <th>Jenis</th>
                       <th>Aksi</th>
                     </tr>
                   </thead>
                   <tbody>
                    <?php if (!empty($event)): ?>

                        <?php foreach ($event as $key): ?>
                         <tr>
                           <td><?= $key->nama_event ?></td>
                           <td><?= $key->tanggal_mulai ?></td>
                           <td><?= $key->tanggal_selesai ?></td>
                           <td><?= $key->jenis_event ?></td>
                           <td>
<!--                              <a href="<?= base_url('C_event/edit_event/')?><?= $key->id_event ?>" class="btn btn-success">Edit</a> -->
                             <a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal<?= $key->id_event ?>">Edit</a>
                             <a href="#" class="btn btn-danger"> <i class="fa fa-trash"></i></a>
                           </td>
                         </tr>   
                       <!-- Modal -->
                  <div class="modal fade" id="myModal<?= $key->id_event ?>" role="dialog" style="overflow:hidden;">
                      <div class="modal-dialog">

                          <!-- Modal content-->
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h4 class="modal-title">Edit Event</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body">
                                  <form action="<?= base_url('C_event/proses_update/');?><?= $key->id_event ?>" method="post">
                                            <div class="form-group">
                                                <label for="inputJudul">Judul Event</label>
                                           <div class="col-sm-12">
                                                <input type="text" value="<?= $key->nama_event ?>" class="form-control" id="inputJudul" placeholder="Judul Event" name="inputJudul">
                                            </div>

                                            </div>
                                            <div class="form-group">
                                                <label for="inputStart">Tanggal Mulai</label>
                                           <div class="col-sm-12">
                                                <input type="date" value="<?= $key->tanggal_mulai ?>" class="form-control" id="inputStart" name="inputStart">
                                            </div>

                                            </div>
                                         <div class="form-group">
                                                <label for="inputEnd">Tanggal Selesai</label>
                                            <div class="col-sm-12">
                                                <input type="date" value="<?= $key->tanggal_selesai ?>" class="form-control" id="inputEnd" name="inputEnd">
                                            </div>

                                            </div>
                                            <div class="form-group">
                                                <label for="jenisEvent">Jenis Event</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="inputJenis" name="inputJenis">
                                                    <option value="">--Pilih Jenis Event--</option>
                                                    <option value="Penelitian Dosen PNBP" <?php if ($key->jenis_event == "Penelitian Dosen PNBP"){ echo "selected";} ?>>Penelitian Dosen PNBP</option>
                                                    <option value="Penelitian Dosen Mandiri" 
                                                    <?php if ($key->jenis_event == "Penelitian Dosen Mandiri"){ echo "selected";} ?>
                                                    >Penelitian Dosen Mandiri</option>
                                                    <option value="Pengabdian Dosen" 
                                                    <?php if ($key->jenis_event == "Pengabdian Dosen"){ echo "selected";} ?>
                                                    >Pengabdian Dosen</option>
                                                    <option value="Penelitian Teknisi"
                                                     <?php if ($key->jenis_event == "Penelitian Teknisi"){ echo "selected";} ?>
                                                     >Penelitian Teknisi</option>
                                                </select>
                                            </div>

                                            </div>
                                    <br>
                              <div class="modal-footer">
                                  <button type="submit" class="btn btn-success"> Submit</button>
                              </div>
                          </form>
                          </div>

                      </div>
                  </div>               
                        <?php endforeach ?>
 
                    <?php else : ?>
                     <tr>
                       <td colspan="4" style="text-align: center;">Data Masih Kosong</td>
                     </tr> 
                    <?php endif ?>


                     </tr>
                   </tbody>
                   <tfoot>
                     <tr>
                       <th>Judul Event</th>
                       <th>Event dimulai</th>
                       <th>Event ditutup</th>
                       <th>Jenis</th>
                       <th>Aksi</th>
                     </tr>
                   </tfoot>
                 </table>
               </div>
               <!-- /.card-body -->
             </div>
             <!-- /.card -->
           </div><!-- /.container-fluid -->
         </div>
       </section>
       <!-- /.content -->
     </div>
 <?php  
  if ($this->session->flashdata('alert'))
   {
      echo '<div class="flash-alert" data-flashalert="';
      echo $this->session->flashdata('alert');
      echo '"></div>';
  } else if ($this->session->flashdata('success')) {
      echo '<div class="flash-data" data-flashdata="';
      echo $this->session->flashdata('success');
      echo '"></div>';

  }
 ?>
<script type="text/javascript" src="<?= base_url() . JS_UMUM . 'event_edit.js?' . 'random=' . uniqid() ?> "></script>
    <script>
      $('.table-bordered').DataTable();
      $(window).on("load", function() {
    $('#overlay').fadeOut(400);
});
      
    </script>