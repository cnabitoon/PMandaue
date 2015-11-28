<!DOCTYPE html>
<html>
    <head>
        <title><?= $tab_title ?> | +Mandaue</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('image/icon4.ico') ?>" /> 
        <link href="<?= base_url('assets/css/custom.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/login-form.css') ?>" />
        <script type="text/javascript" src="<?= base_url('assets/js/jquery-1.11.0.min.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery.leanModal.min.js') ?>"></script>
        <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.min.css') ?>" />
        <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-static-top" style="">
            <div class="container-fluid">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <div class="navbar-header">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </div>
                </button>
                <a class="navbar-brand" href="#" style="color:#fff">+Mandaue</a>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="<?= $this->uri->segment(1) ? '' : 'active'; ?>"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="<?= active_nav2(1, 'complaint', 2, 'view_all') ?>"><a href="<?= base_url('complaint/view_all') ?>">Complaints</a></li>
                        <li><a href="#">Statistics</a></li>
                        <li class="<?= active_nav2(1, 'complaint', 2, 'post') ?>"><a href="<?= base_url('complaint/post') ?>">Post Complaint</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (!$this->session->userdata('user_id')): ?>
                            <li class="<?= active_nav('register') ?>"><a href="<?= base_url('register') ?>"><i class="glyphicon glyphicon-pencil"></i> Register</a></li>
                            <li class="<?= active_nav('login') ?>"><a href="<?= base_url('login') ?>">Login</a></li>
                        <?php else: ?>
                            <li  class="navbar-text" style="color: white; font-weight: bold">Hello, <?= $this->session->userdata('firstname') ?>!</li>
                            <li><a href="<?= base_url('logout') ?>">Logout</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <?= $content ?>
    </body>
</html>