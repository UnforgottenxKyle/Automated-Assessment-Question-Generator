<div class="container">
    <div class="clear-fix my-4"></div>
    <div class="card card-outline card-success rounded-0 shadow">
        <div class="card-body py-5">
            <h3 class="text-center font-weight-bolder">Automated Assessment Paper Generator for Cavite State</h3>
            <center>
                <hr class="border-success bg-success w-25 border-3" style="opacity:1;height:3px;">
            </center>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <dl>
                        <dt><b>Group Name</b></dt>
                        <dd class="pl-3"><?= $_settings->info('company_name') ?></dd>
                        <dt><b>Email</b></dt>
                        <dd class="pl-3"><?= $_settings->info('company_email') ?></dd>
                    </dl>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <dl>
                        <dt><b>Telephone #</b></dt>
                        <dd class="pl-3"><?= $_settings->info('company_tel_no') ?></dd>
                        <dt><b>Mobile #</b></dt>
                        <dd class="pl-3"><?= $_settings->info('company_mobile') ?></dd>
                    </dl>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <dl>
                        <dt><b>Address</b></dt>
                        <dd class="pl-3"><?= $_settings->info('company_address') ?></dd>
                        <dt><b>About</b></dt>
                        <dd class="pl-3"><?= $_settings->info('company_description') ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>