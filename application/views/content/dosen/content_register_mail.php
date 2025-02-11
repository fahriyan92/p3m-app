<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Lengkapi Data Diri Anda</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <script>
    const BASE_URL = "<?= base_url() ?>";
  </script>

</head>
<style>
#overlay{	
position: fixed;
background: rgba(0,0,0,0.9);
  bottom: 0;
  height: 100%;
  left: 0;
  right: 0;
  top: 0;
  width: 100%;
  margin: 0 auto;
  overflow-y: hidden;
  overflow-x: hidden; 
  z-index: 9999;  
}
.cv-spinner {
	height: 100%;
	display: flex;
	justify-content: center;
	align-items: center;  
}
.spinner {
	width: 40px;
	height: 40px;
	border: 4px #ddd solid;
	border-top: 4px #2e93e6 solid;
	border-radius: 50%;
	animation: sp-anime 0.8s infinite linear;
}
@keyframes sp-anime {
	100% { 
		transform: rotate(360deg); 
	}
}
.is-hide{
	display:none;
}
</style>
<body class="hold-transition register-page">
<div id="overlay">
    <div class="cv-spinner">
      <span class="spinner"></span>
    </div>
  </div>
<div class="register-box">
  <div class="register-logo">
    <a href="<?= base_url(); ?>"><b>P3M</b>POLIJE</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">

      <form action="../../index.html" method="post">
      <div class="text-center">
          <img class="profile-user-img img-fluid img-circle" src="<?php echo base_url('assets'); ?>/dist/img/default-avatar.png" alt="User profile picture">
      </div>
      <h3 class="profile-username text-center text-capitalize"><?php echo $data->nama ?> </h3>
      <p class="text-muted text-center text-capitalize"><?php echo $data->jenis_job  ?></p>


      <hr>
      <p class="login-box-msg">Lengkapi Data Dibawah<br></p>

        <div class="input-group mb-3">
          <input type="email" required class="form-control" name="email" placeholder="Email" value="">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="err-email" style="display:none;">
           <p style="color:red" >Tidak Boleh Kosong</p>
        </div>
          <!-- /.col -->
          <div class="row">
             <div class="col-6">
              <a href="<?= site_url('/'); ?>" class="btn btn-secondary btn-block">Batal</a>
             </div>
             <div class="col-6">
               <button type="submit" class="btn btn-primary btn-block">Simpan</button>
             </div>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="<?php echo base_url('assets'); ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('assets'); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets'); ?>/dist/js/adminlte.min.js"></script>
</body>
</html>
<script>
  $('#overlay').fadeOut(500);
  const  regist_email = email => {
    return new Promise((resolve,reject) => {
      $.ajax({
      url: `${BASE_URL}/C_register/regist_email`,
      type: 'post',
      dataType: 'json',
      data: {email:email},
      success: res => resolve(res)
    });
    });
  };


  $('button[type="submit"]').on('click', function(e){
    $('#overlay').fadeIn(100);
    e.preventDefault();
    const email = $('input[name="email"]').val();

    let status = true;

    if(email === ''){
      status = false;
      $('.err-email>p').text('Email harus diisi');
      $('.err-email').show();
    } else {
      status = true;
      const domain = email.split('@');
      if(domain[1] !== 'polije.ac.id'){
        status = false;
        $('.err-email>p').text('Email harus @polije.ac.id :)');
        $('.err-email').show();
      }else{ 
        status = true;
        $('.err-email').hide();
      }
    }


    if(status === false){
      $('#overlay').fadeOut(500)
      return ;
    }

    regist_email(email).then(res=> {
      if(res.status == "success"){
        $('.err-email>p').css('color','#056674');
        $('.err-email>p').text('Registrasi Email Berhasil :)');
        $('.err-email').show();
        $('#overlay').fadeOut(500, function(){
          setTimeout(() => {
          window.location.replace("<?= site_url('/'); ?>");
          return;
          }, 2500);
        });
      } else{ 
        $('.err-email>p').text(res.pesan);
        $('.err-email').show();
        $('#overlay').fadeOut(500);
      }
    });

  });
</script>