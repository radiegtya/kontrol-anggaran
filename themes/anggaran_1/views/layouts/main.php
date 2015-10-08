<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Kontrol Anggaran</title>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/kementrian_pekerjaan_umum.jpg"></link>
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/bower_components/fontawesome/css/font-awesome.min.css" rel="stylesheet"/>
        


        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/table.css" rel="stylesheet"/>


        <!--SUPERFISH-->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/superfish/superfish.css" rel="stylesheet"/>
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/superfish/superfish-vertical.css" rel="stylesheet"/>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/superfish/hoverIntent.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/superfish/superfish.min.js"></script>

        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" rel="stylesheet"/>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/Highcharts-4.0.4/js/highcharts.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/Highcharts-4.0.4/js/modules/exporting.js"></script>

        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/grid-light.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/main.js"></script>
        <script type="text/javascript">
            jQuery.browser = {};
            (function () {
                jQuery.browser.msie = false;
                jQuery.browser.version = 0;
                if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
                    jQuery.browser.msie = true;
                    jQuery.browser.version = RegExp.$1;
                }
            })();
        </script>
    </head>
    <body>
        <?php
        $id = Yii::app()->user->id;
        $user = User::model()->findByPk($id);
        $group = '';
        if ($user) {
            $group = $user->group->name;
        }
        $this->widget('ext.EChosen.EChosen', array(
            'target' => 'select.autocomplete',
        ));
        ?>
        <?php $this->widget('ext.ambiance.VAmbiance'); ?>
        <div class="wrapper">
            <aside class="maximized">
                <div class="main-menu">
                    <header class="header"><a class="logo flex"><i></i><span><div>Kontrol Anggaran</div></span> </a></header>



                    <nav class="menu-container">
                        <ul class=" sf-menu sf-vertical sf-js-enabled sf-arrows">
                            <!--<li><a href="<?php // echo Yii::app()->baseUrl . '/site/index';     ?>"><i class="fa fa-fw fa-home"></i> <span>Home</span></a></li>-->
                            <?php if ($group == 'administrator' || $group == 'operator' || $group == 'eksekutif' || $group == 'super-admin'): ?>
                                <?php
                                $class = '';
                                if (Yii::app()->controller->id == 'dashboard') {
                                    $class = 'active';
                                }
                                ?>
                                <li class="<?php echo $class; ?>"><a href="<?php echo Yii::app()->baseUrl . '/dashboard/mainChart'; ?>" class="sf-with-ul"><i class="fa fa-fw fa-dashboard"></i><span>Dashboard</span></a></li>
                            <?php endif; ?>                         
                            <?php if ($group == 'administrator' || $group == 'super-admin'): ?>                           
                                <?php
                                $class = '';
                                if (Yii::app()->controller->id == 'paymentMethod' || Yii::app()->controller->id == 'paymentType' || Yii::app()->controller->id == 'spmType' || Yii::app()->controller->id == 'ppk' || Yii::app()->controller->id == 'satker' || Yii::app()->controller->id == 'activity' || Yii::app()->controller->id == 'output' || Yii::app()->controller->id == 'province' || Yii::app()->controller->id == 'city' || Yii::app()->controller->id == 'account' || Yii::app()->controller->id == 'suboutput' || Yii::app()->controller->id == 'component' || Yii::app()->controller->id == 'subcomponent') {
                                    $class = 'active';
                                }
                                ?>
                                <li class="<?php echo $class; ?>">
                                    <a><i class="fa fa-fw fa-database"></i><span>Master</span></a>
                                    <ul style="height: 60vh">
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/paymentMethod/admin'; ?>">Sifat Pembayaran</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/paymentType/admin'; ?>">Jenis Pembayaran</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/spmType/admin'; ?>">Jenis SPM</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/ppk/admin'; ?>">PPK</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/satker/admin'; ?>">Satker</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/activity/admin'; ?>">Kegiatan</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/output/admin'; ?>">Output</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/suboutput/admin'; ?>">Suboutput</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/component/admin'; ?>">Komponen</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/subcomponent/admin'; ?>">Subkomponen</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/province/admin'; ?>">Provinsi</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/city/admin'; ?>">Kab/Kota</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/account/admin'; ?>">Akun</a></li>
                                    </ul>
                                </li>
                                <?php
                                $class = '';
                                if (Yii::app()->controller->id == 'dipa') {
                                    $class = 'active';
                                }
                                ?>
                                <li class="<?php echo $class; ?>">
                                    <a href="<?php echo Yii::app()->baseUrl . '/dipa/admin'; ?>"><i class="fa fa-fw fa-upload"></i><span>DIPA/POK</span></a>
                                    <ul>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/dipa/admin'; ?>"><i class="fa fa-fw fa-table"></i><span>Daftar</span></a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/dipa/create'; ?>"><i class="fa fa-fw fa-plus"></i><span>Tambah baru</span></a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if ($group == 'administrator' || $group == 'operator' || $group == 'super-admin'): ?>
                                <?php
                                $class = '';
                                if (Yii::app()->controller->id == 'up') {
                                    $class = 'active';
                                }
                                ?>
                                <li class="<?php echo $class; ?>">
                                    <a href="<?php echo Yii::app()->baseUrl . '/up/admin'; ?>"><i class="fa fa-fw fa-money"></i><span>Uang Persediaan</span></a>
                                    <ul>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/up/admin'; ?>"><i class="fa fa-fw fa-table"></i><span>Daftar</span></a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/up/create'; ?>"><i class="fa fa-fw fa-plus"></i><span>Tambah baru</span></a></li>
                                    </ul>
                                </li>
                                <?php
                                $class = '';
                                if (Yii::app()->controller->id == 'nrs') {
                                    $class = 'active';
                                }
                                ?>
                                <li class="<?php echo $class; ?>">
                                    <a href="<?php echo Yii::app()->baseUrl . '/nrs/admin'; ?>"><i class="fa fa-fw fa-users"></i><span>NRS</span></a>
                                    <ul>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/nrs/admin'; ?>"><i class="fa fa-fw fa-table"></i><span>Daftar</span></a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/nrs/create'; ?>"><i class="fa fa-fw fa-plus"></i><span>Tambah baru</span></a></li>
                                    </ul>
                                </li>
                                <?php
                                $class = '';
                                if (Yii::app()->controller->id == 'nrk') {
                                    $class = 'active';
                                }
                                ?>
                                <li class="<?php echo $class; ?>">
                                    <a href="<?php echo Yii::app()->baseUrl . '/nrk/admin'; ?>"><i class="fa fa-fw fa-file-text"></i><span>NRK</span></a>
                                    <ul>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/nrk/admin'; ?>"><i class="fa fa-fw fa-table"></i><span>Daftar</span></a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/nrk/create'; ?>"><i class="fa fa-fw fa-plus"></i><span>Tambah baru</span></a></li>
                                    </ul>
                                </li>
                                <?php
                                $class = '';
                                if (Yii::app()->controller->id == 'package') {
                                    $class = 'active';
                                }
                                ?>
                                <li class="<?php echo $class; ?>">
                                    <a href="<?php echo Yii::app()->baseUrl . '/package/admin'; ?>"><i class="fa fa-fw fa-book"></i><span>Paket</span></a>
                                    <ul>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/package/admin'; ?>"><i class="fa fa-fw fa-table"></i><span>Daftar</span></a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/package/create'; ?>"><i class="fa fa-fw fa-plus"></i><span>Tambah baru</span></a></li>
                                    </ul>
                                </li>
                                <?php
                                $class = '';
                                if (Yii::app()->controller->id == 'realization') {
                                    $class = 'active';
                                }
                                ?>
                                <li class="<?php echo $class; ?>">
                                    <a href="<?php echo Yii::app()->baseUrl . '/realization/admin'; ?>"><i class="fa fa-fw fa-ticket"></i><span>Realisasi</span></a>
                                    <ul>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/realization/admin'; ?>"><i class="fa fa-fw fa-table"></i><span>Daftar</span></a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/realization/create'; ?>"><i class="fa fa-fw fa-plus"></i><span>Tambah baru</span></a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-fw fa-life-ring"></i> <span>User Guide</span></a></li>
                            <?php endif; ?>
                            <?php if ($group == 'administrator' || $group == 'super-admin'): ?>
                                <?php
                                $class = '';
                                if (Yii::app()->controller->id == 'user') {
                                    $class = 'active';
                                }
                                ?>
                                <li class="<?php echo $class; ?>">
                                    <a href="<?php echo Yii::app()->baseUrl . '/user/admin'; ?>"><i class="fa fa-fw fa-user"></i> <span>User</span></a>
                                    <ul>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/user/admin'; ?>"><i class="fa fa-fw fa-table"></i><span>Daftar</span></a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/user/create'; ?>"><i class="fa fa-fw fa-plus"></i><span>Tambah baru</span></a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>

                            <li><a href="<?php echo Yii::app()->baseUrl . '/site/about'; ?>"><i class="fa fa-fw fa-info-circle"></i> <span>About</span></a></li>
                        </ul>
                    </nav>
                </div>
            </aside>
            <div class="date-container"></div>
            <div class="content">
                <header class="flex">
                    <h1 class="title"><?php echo $this->title; ?></h1>
                    <div class="dropdown">
                        <a class="dropdown-toggle username" data-toggle="dropdown" href="#"><?php echo (Yii::app()->user->isGuest) ? 'Guest' : $user->username; ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu pull-left" role="menu" aria-labelledby="dLabel">
                            <li>
                                <?php if (Yii::app()->user->isGuest): ?>
                                <?php else: ?>
                                    <a href="<?php echo Yii::app()->baseUrl . '/user/profile/' . Yii::app()->user->id; ?>">Profile</a>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if (Yii::app()->user->isGuest): ?>
                                    <a href="<?php echo Yii::app()->baseUrl . '/site/login'; ?>">Sign in</a>
                                <?php else: ?>
                                    <a href="<?php echo Yii::app()->baseUrl . '/site/logout'; ?>">Sign out</a>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </header>

                <div class="post-container padding">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </body>
</html>
