<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
<?php require_once('inc/header.php') ?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
  $(function(){
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
  })
</script>
<?php endif;?>
  <script>
    start_loader()
  </script>
  <style>
    body{
      background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-size:cover;
      background-repeat:no-repeat;
      backdrop-filter: brightness(.85);
    }
    #page-title{
      color: #fff4f4 !important;
      text-shadow: 3px 3px 7px #000
    }
    #sys-logo{
      height:15rem;
      width:15rem;
      object-fit:cover;
      object-position:center center;
    }
  </style>
  <img src="<?= validate_image($_settings->info('logo')) ?>" alt="" id="sys-logo" class="img-thumbnail img-circle rounded-circle border border-4">
  <h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo $_settings->info('name') ?></b></h1>
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-success my-2 rounded-0 shadow">
    <div class="card-body">
      <p class="login-box-msg">Please enter your credentials</p>
      <form id="rlogin-form" action="" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control outline-success" name="email" autofocus placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control"  name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <a class="text-success" href="<?php echo base_url ?>">Go to Website</a>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-success btn-block btn-flat btn-sm">Sign In</button>
          </div>
          <div class="col-12 text-center">
          
              <div class="btn btn-success btn-block btn-flat btn-sm col-12 text-center mx-auto d-flex justify-content-center align-items-center" style='margin-top:10px; max-width: 70%;'>
                  <div class="google-image mr-auto" style='padding:1px 0px;'> 
                      <img src='../uploads/google.png' style='width: 25px;background-color: white;border-radius: 4px ' />
                  </div>
                  <div class="flex-grow-1">
                                              
                    <?php 
                        $gClient->setRedirectUri(base_url.'classes/Login.php?f=login_ruser');
                        $authUrl = $gClient->createAuthUrl(); 
                    ?>
                    <a href="<?php echo filter_var($authUrl); ?>" class="login-btn" style='color:white !important;'><strong>Sign in with Google</strong></a>
                  </div>
              </div>
              <a class="text-success" href="./register.php">Create an Account</a><br>
              <a style="color: green;" href="../forgotpassword.php" data-toggle="modal" data-dismiss="modal" class="last">Forgot Password ?</a></p>
          </div>
        </div>
      </div>
    </form>
      

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<script>
  $(document).ready(function(){
    end_loader();
    $('#rlogin-form').submit(function(e){
        e.preventDefault();
        var _this = $(this)
        $('.err-msg').remove();
        var el = $('<div>')
            el.addClass('alert alert-danger err-msg')
            el.hide()
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Login.php?f=login_ruser",
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            dataType: 'json',
            error:err=>{
                console.log(err)
                alert_toast("An error occured",'error');
                end_loader();
            },
            success:function(resp){
                if(typeof resp =='object' && resp.status == 'success'){
                    location.replace(_base_url_+'users/')
                }else if(resp.status == 'failed' && !!resp.msg){
                    el.text(resp.msg)
                    _this.prepend(el)
                    el.show('slow')
                }else{
                    el.text("An error occured")
                    _this.prepend(el)
                    el.show('slow')
                }
                $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                end_loader()
            }
        })
    })
  })
</script>
</body>
</html>
