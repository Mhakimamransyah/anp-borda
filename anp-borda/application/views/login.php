<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.4
Version: 3.3.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title><?= $title . ' | ' . $global_title ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/metronic') ?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/metronic') ?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/metronic') ?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/metronic') ?>/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="<?= base_url('assets/metronic') ?>/assets/admin/pages/css/login2.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    <link href="<?= base_url('assets/metronic') ?>/assets/global/css/components-md.css" id="style_components" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/metronic') ?>/assets/global/css/plugins-md.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/metronic') ?>/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/metronic') ?>/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="<?= base_url('assets/metronic') ?>/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css" />
    <!-- END THEME STYLES -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->

<body class="page-md login">
    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
    <div class="menu-toggler sidebar-toggler">
    </div>
    <!-- END SIDEBAR TOGGLER BUTTON -->
    <!-- BEGIN LOGO -->
    <div class="logo">
        <a href="#">
            <h3>Sistem Pendukung Keputusan dengan Analytical Network Process - Borda</h3>
            <h4></h4>
        </a>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN LOGIN -->
    <div class="content">
        <!-- BEGIN LOGIN FORM -->
        <?= form_open('login', ['class' => 'login-form']) ?>
        <div class="form-title">
            <span class="form-title">Selamat datang.</span>
            <span class="form-subtitle">Silahkan login.</span>
        </div>
        <?= $this->session->flashdata('msg') ?>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span>
                Enter any username and password. </span>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Username</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" />
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" />
        </div>
        <input type="hidden" name="submit" value="Login" />
        <div class="form-actions">
            <input type="submit" class="btn btn-primary btn-block uppercase" value="Login" />
        </div>
    </div>
    <div class="copyright hide">
        2014 © Metronic. Admin Dashboard Template.
    </div>
    <!-- END LOGIN -->
    <?= form_close() ?>
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    <!--[if lt IE 9]>
<script src="<?= base_url('assets/metronic') ?>/assets/global/plugins/respond.min.js"></script>
<script src="<?= base_url('assets/metronic') ?>/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
    <script src="<?= base_url('assets/metronic') ?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/metronic') ?>/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/metronic') ?>/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/metronic') ?>/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/metronic') ?>/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/metronic') ?>/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- <script src="<?= base_url('assets/metronic') ?>/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script> -->
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="<?= base_url('assets/metronic') ?>/assets/global/scripts/metronic.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/metronic') ?>/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
    <!-- <script src="<?= base_url('assets/metronic') ?>/assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/metronic') ?>/assets/admin/pages/scripts/login.js" type="text/javascript"></script> -->
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->

</html>