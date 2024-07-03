<nav class="main-header navbar navbar-expand-lg navbar-dark bg-success mx-0 h-auto pt-5 pb-5">
    <div class="container px-4 px-lg-6 ">
        <button class="navbar-toggler btn btn-sm" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <a class="navbar-brand" href="./">
        <img src="<?php echo validate_image($_settings->info('logo')) ?>" width="50" height="50" class="d-inline-block align-top mr-5" alt="" loading="lazy">
        </a>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 ml-5">
                <li><a class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover fs-4 ml-5" aria-current="page" href="./">Home</a></li>
                <li><a class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover fs-4 ml-5" href="./?p=about">About</a></li>
                <li><a class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover fs-4 ml-5" href="./?p=contact_us">Contact Us</a></li>

            </ul>
        </div>
        <div>
          <a href="./users" class="text-decoration-none text-reset fs-4"><b>User Login</b></a> | 
          <a href="./admin" class="text-decoration-none text-reset fs-4"><b>Admin Panel</b></a>
        </div>
    </div>
</nav>
<script>
  $(function(){
    $('#login-btn').click(function(){
      uni_modal("","login.php")
    })
    $('#navbarResponsive').on('show.bs.collapse', function () {
        $('#mainNav').addClass('navbar-shrink')
    })
    $('#navbarResponsive').on('hidden.bs.collapse', function () {
        if($('body').offset.top == 0)
          $('#mainNav').removeClass('navbar-shrink')
    })
  })

  $('#search-form').submit(function(e){
    e.preventDefault()
     var sTxt = $('[name="search"]').val()
     if(sTxt != '')
      location.href = './?p=products&search='+sTxt;
  })
</script>