<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
<?php
require_once('classes/Verification.php');
function login_redirect(){
  echo '<script>window.location.href = "'.$base_url.'users/login.php";</script>';
  exit();
}
$verification=new Verification();
$email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
$password_code = filter_input(INPUT_GET, 'password_code', FILTER_UNSAFE_RAW);
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if ($email === null | $password_code === null | $id === null) 
  login_redirect();

$user = $verification->find_user($password_code, $email);

if (!$user) 
  login_redirect();
?>
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
    <p class="login-box-msg">RESET PASSWORD</p>
    <form id="form" action="" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="email" value="<?= $email ?>">
        <input type="hidden" name="password_code">
        <div class="input-group mb-3">
            <input type="password" class="form-control outline-success" name="password" id="password" autofocus placeholder="New Password">
            <div class="input-group-append">
                <div class="input-group-text">
                <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" class="form-control" name="cpassword" id ="cpassword" placeholder="Confirm Password">
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
                <input type="submit" name="forgot" value="UPDATE" class="btn btn-success btn-block btn-flat btn-sm">
            </div>
            <div class="col-12 text-center">
                <a class="text-success" href="users/register.php">Create an Account</a><br>
            </div>
        </div>
    </form>
        

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
    $('#form').submit(function(e){
        e.preventDefault();
        var _this = $(this)
        $('.err-msg').remove();
        var el = $('<div>')
            el.addClass('alert alert-danger err-msg')
            el.hide()
        if($('#password').val() != $('#cpassword').val()){
            el.text('Password does not match');
            _this.prepend(el)
            el.show('slow')
            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
            return false;
        }
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Users.php?f=save_ruser",
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
                    location.replace(_base_url_+'users/login.php')
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