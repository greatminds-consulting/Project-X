<?php $this->load->view('authentication/includes/head.php'); ?>
<body class="fixed-header login_admin">
<div class="login-wrapper ">
    <!-- START Login Background Pic Wrapper-->
    <div class="bg-pic">
        <!-- START Background Pic-->
        <img src="/assets/images/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg" data-src="/assets/images/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg" data-src-retina="/assets/images/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg" alt="" class="lazy">
        <!-- END Background Pic-->
        <!-- START Background Caption-->
        <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
            <h2 class="semi-bold text-white">
                Pages make it easy to enjoy what matters the most in the life</h2>
            <p class="small">
                images Displayed are solely for representation purposes only, All work copyright of respective owner, otherwise © 2018 Navarra Venues.
            </p>
        </div>
        <!-- END Background Caption-->
    </div>
    <!-- END Login Background Pic Wrapper-->
    <!-- START Login Right Container-->
    <div class="login-container bg-white">
        <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
            <?php get_company_logo(); ?>
            <?php $this->load->view('authentication/includes/alerts'); ?>
            <p class="p-t-35"><?php echo _l('admin_auth_login_heading'); ?></p>
            <!-- START Login Form -->
            <?php echo form_open($this->uri->uri_string(), array('id' => 'form-login')); ?>
            <?php do_action('after_admin_login_form_start'); ?>
                <!-- START Form Control-->
                <div class="form-group form-group-default has-error">
                    <label><?php echo _l('admin_auth_login_email'); ?></label>
                    <div class="controls">
                        <input type="email" id="email" name="email" autofocus="1" placeholder="User Name" class="form-control" required>
                        <?php echo validation_errors('<label id="email-error" class="error" for="email">', '</label>'); ?>

                    </div>
                </div>
                <!-- END Form Control-->
                <!-- START Form Control-->
                <div class="form-group form-group-default">
                    <label><?php echo _l('admin_auth_login_password'); ?></label>
                    <div class="controls">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Credentials" required>
                    </div>
                </div>
                <!-- START Form Control-->
                <div class="row">
                    <div class="col-md-6 no-padding sm-p-l-10">
                        <div class="checkbox ">
                            <input type="checkbox" value="1" id="checkbox1" name="remember">
                            <label for="checkbox1">Keep Me Signed in</label>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-end">
                        <a href="<?php echo site_url('authentication/forgot_password'); ?>" class="text-info small"><?php echo _l('admin_auth_login_fp'); ?></a>
                    </div>
                </div>
                <!-- END Form Control-->
                <button class="btn btn-primary btn-cons m-t-10" type="submit"><?php echo _l('admin_auth_login_button'); ?></button>
            <?php if(get_option('recaptcha_secret_key') != '' && get_option('recaptcha_site_key') != ''){ ?>
                <div class="g-recaptcha" data-sitekey="<?php echo get_option('recaptcha_site_key'); ?>"></div>
            <?php } ?>
            <?php do_action('before_admin_login_form_close'); ?>
            <?php echo form_close(); ?>
            <!--END Login Form-->

        </div>
    </div>
    <!-- END Login Right Container-->
</div>

<script src="/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
<script src="/assets/plugins/jquery_1.11/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="/assets/plugins/modernizr.custom.js" type="text/javascript"></script>
<script src="/assets/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="/assets/plugins/tether/js/tether.min.js" type="text/javascript"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/plugins/jquery_1.11/jquery-easy.js" type="text/javascript"></script>
<script src="/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
<script src="/assets/plugins/jquery-ios-list/jquery.ioslist.min.js" type="text/javascript"></script>
<script src="/assets/plugins/jquery-actual/jquery.actual.min.js"></script>
<script src="/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="/assets/plugins/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<!-- END VENDOR JS -->
<script src="/assets/js/pages.js"></script>
<script>
    $(function()
    {
        $('#form-login').validate()
    })
</script>
</body>
</html>
