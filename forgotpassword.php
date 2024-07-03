<?php require_once('config.php'); ?>
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
  start_loader()
</script>
<?php endif;?>

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
        <div class="input-group mb-3">
            <input type="email" class="form-control outline-success" name="email" autofocus placeholder="Email">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <a class="text-success" href="<?php echo base_url ?>">Go to Website</a>
            </div>
            <div class="col-4">
                <input type="submit" name="forgot" value="Reset" class="btn btn-success btn-block btn-flat btn-sm">
            </div>
            <div class="col-12 text-center">
                <a class="text-success" href="users/register.php">Create an Account</a><br>
            </div>
            <div class="col-12 text-center">
                <a class="text-success" href="users/login.php">Login</a><br>
            </div>
        </div>
    </form>
        

</div>

<script>
  $(document).ready(function(){
    end_loader();
    $('#form').submit(function(e){
        e.preventDefault();
        var _this = $(this)
        $('.err-msg, .success-msg').remove();
        var errEl = $('<div>')
            errEl.addClass('alert err-msg')
            errEl.hide()
        var successEl = $('<div>')
            successEl.addClass('alert success-msg')
            successEl.hide()
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Verification.php?f=send_changepass_email",
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            dataType: 'json',
            error:err=>{
                console.log(err)
                alert_toast("An error occurred: " + err.statusText, 'error');
                end_loader();
            },
            success:function(resp){
                if(typeof resp =='object' && resp.status == 'success'){
                    successEl.addClass('alert-success'); 
                    successEl.text(resp.msg)
                    _this.prepend(successEl)
                    successEl.show('slow')
                }else if(resp.status == 'failed' && !!resp.msg){
                    errEl.addClass('alert-danger')
                    errEl.text(resp.msg)
                    _this.prepend(errEl)
                    errEl.show('slow')
                }else{
                    errEl.addClass('alert-danger')
                    errEl.text("An error occurred")
                    _this.prepend(errEl)
                    errEl.show('slow')
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