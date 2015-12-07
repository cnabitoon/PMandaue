<!DOCTYPE html>
<html>
    <head>
        <title><?= $tab_title ?> | +Mandaue</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('image/icon4.ico') ?>" /> 
        <link href="<?= base_url('assets/css/united.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet" />
        <style type="text/css">
            html, body { height: 100%; margin: 35px 0 0 0; padding: 0; }
            #map { height: 100%; }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top" style="margin-bottom: 0px;">
            <div class="container-fluid">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <div class="navbar-header">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </div>
                </button>
                <a class="navbar-brand"><i class="fa fa-plus"></i> Mandaue</a>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="<?= active_nav_home() ?>"><a href="<?= base_url() ?>">Home</a></li>
                        <li><a href="#">Complaints</a></li>
                        <li><a href="#">Statistics</a></li>

                        <li class="<?= active_nav_2('complaint', 'post') ?>"><a href="<?= base_url('complaint/post') ?>">Post Complaint</a></li>
                        <?php if ($this->session->userdata('type') === 'sa'): ?>
                        <li class="<?= active_nav_2('super-admin', 'complaint') ?>">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                Maintain <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= base_url("super-admin/complaint?type=pending") ?>">Complaints</a></li>
                                <li><a href="<?= base_url("super-admin/account") ?>">Accounts</a></li>
                                <li><a href="<?= base_url("super-admin/miscellaneous") ?>">Miscellaneous</a></li>
                            </ul>
                        </li>
                        <?php elseif ($this->session->userdata('type') === 'g'): ?>
                        <li class="<?= active_nav_2('government', 'complaint') ?>">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                Maintain <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= base_url("government/complaint?type=pending") ?>">Complaints</a></li>
                                <li><a href="<?= base_url("government/miscellaneous") ?>">Miscellaneous</a></li>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (!$this->session->userdata('user_id')): ?>
                        <li class="<?= active_nav_1('register') ?>"><a href="<?= base_url('register') ?>">Register</a></li>
                        <li class="<?= active_nav_1('login') ?>"><a href="<?= base_url('login') ?>">Login</a></li>
                        <?php else: ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname') ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">My Account</a></li>
                                <li><a href="<?= base_url('logout') ?>">Logout</a></li>
                            </ul>
                        </li>

                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <?= $content ?>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
    </body>
</html>