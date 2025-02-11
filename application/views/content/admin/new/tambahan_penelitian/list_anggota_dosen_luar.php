<link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/dist/css/adminlte.min.css">
  <!-- data tables -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/datatables/dataTables.bootstrap4.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/daterangepicker/daterangepicker.css">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/select2/css/select2.min.css">
  <!-- ui -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/jquery-ui/jquery-ui.css">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs/dist/tf.min.js"> </script> -->


  <script type="text/javascript">
    const BASE_URL = "<?= base_url() ?>";
  </script>

  <script src="<?php echo base_url('assets'); ?>/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo base_url('assets'); ?>/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo base_url('assets'); ?>/plugins/jquery-ui/jquery-ui.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url('assets'); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url('assets'); ?>/plugins/datatables/jquery.dataTables.js"></script>
  <script src="<?php echo base_url('assets'); ?>/plugins/datatables/dataTables.bootstrap4.js"></script>

  <table id="table_list_anggota_dosen_polije" class="table table-bordered table-striped">
    <thead>
        <tr>
        <!-- b.nidn, b.nama,b.sinta,b.scopus,b.unit,b.jenis_unit,b.telepon -->
            <th>No.</th>
            <th>No KTP</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No hp</th>
        </tr>
    </thead>
    <tbody class="bodynya">

        <?php if (!empty($list_anggota)) : ?>
            <?php 
                $no = 1;
                foreach ($list_anggota as $key) : ?>
                <tr>
                    <td><?= $no++ ?>.</td>
                    <td><?= $key->noktp ?></td>
                    <td><?= $key->nama ?></td>
                    <td><?= $key->email ?></td>
                    <td><?= $key->nohp ?></td>
                    <?php if($jenis == "temp") : ?>
                        <td><a href="<?= site_url('C_tambahan_penelitian/delete_temp_luar/'.$key->noktp.'/'.$key->id_list_event) ?>" class="btn btn-xs btn-warning"><i class="fa fa-fw fa-trash"></i></a>
                    <?php else: ?>
                        <td><a href="<?= site_url('C_tambahan_penelitian/delete_not_temp_luar/'.$key->noktp.'/'.$key->id_pengajuan_detail) ?>" class="btn btn-xs btn-warning"><i class="fa fa-fw fa-trash"></i></a>
                    <?php endif; ?>
                    
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>

    </tbody>
</table>