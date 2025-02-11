<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>P3M POLIJE | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
    <link   rel="stylesheet" 
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
        crossorigin="anonymous">

    
    <script type="text/javascript">
        const BASE_URL = "<?= base_url() ?>";
    </script>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?php echo base_url('C_auth'); ?>"><b>P3M</b>POLIJE</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Login untuk masuk ke dashboard</p>

                <form id="form_login" method="post">
                    <div class="input-group mb-3">
                        <input type="text" id="nidn" class="form-control" placeholder="NIP" name="nidn">
                        <div class="input-group-append input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
          <?php   /*    <div class="input-group mb-3">
                        <input type="password" id="password" class="form-control" placeholder="Password" name="password">
                        <div class="input-group-append input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>  */ ?>
                    <div class="form-group">
                        <p class="err text-capitalize" style="color:red;"></p>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <input type="submit" id="submit" value="Lanjutkan" class="btn btn-primary btn-block btn-flat">

                        </div>
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?php echo base_url('assets'); ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url('assets'); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url('assets');?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="<?= base_url().JS_UMUM; ?>login_dosen.js?random=<?= uniqid(); ?>"></script>

</body>

</html>