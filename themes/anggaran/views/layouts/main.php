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
        <link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/title.png"></link>
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/bower_components/fontawesome/css/font-awesome.min.css" rel="stylesheet"/>



        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/table.css" rel="stylesheet"/>


        <!--SUPERFISH-->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/superfish/superfish.css" rel="stylesheet"/>
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/superfish/superfish-vertical.css" rel="stylesheet"/>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/superfish/hoverIntent.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/superfish/superfish.min.js"></script>

        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/easycharts/dist/jquery.easypiechart.min.js">"></script>

<!--<link rel="stylesheet"type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/easycharts/demo/style.css">-->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" rel="stylesheet"/>

        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/main.js"></script>


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
                            <!--<li><a href="<?php // echo Yii::app()->baseUrl . '/site/index';                                               ?>"><i class="fa fa-fw fa-home"></i> <span>Home</span></a></li>-->
                            <?php if ($group == 'administrator' || $group == 'operator' || $group == 'eksekutif' || $group == 'super-admin'): ?>

                                <?php
                                $class = '';
                                if (Yii::app()->controller->getRoute() == 'dashboard/performanceDashboard') {
                                    $class = 'active';
                                }
                                ?>
                                <li class="<?php echo $class; ?>"><a href="<?php echo Yii::app()->baseUrl . '/dashboard/performanceDashboard'; ?>" class="sf-with-ul"><i class="fa fa-fw fa-dashboard"></i><span>Performance </br>Dashboard</span></a></li>
                                <?php
                                $class = '';
                                if (Yii::app()->controller->getRoute() == 'dashboard/mainChart' || Yii::app()->controller->getRoute() == 'dashboard/accountChart' || Yii::app()->controller->getRoute() == 'dashboard/activityChart') {
                                    $class = 'active';
                                }
                                ?>
                                <li class="<?php echo $class; ?>"><a href="<?php echo Yii::app()->baseUrl . '/dashboard/mainChart'; ?>" class="sf-with-ul"><i class="fa fa-fw fa-dashboard"></i><span>Dashboard</span></a></li>
                            <?php endif; ?> 
                            <?php /**
                              <?php
                              $class = '';
                              if (Yii::app()->controller->getRoute() == 'dashboard/tableReport') {
                              $class = 'active';
                              }
                              ?>
                              <li class="<?php echo $class; ?>"><a href="<?php echo Yii::app()->baseUrl . '/dashboard/tableReport'; ?>" class="sf-with-ul"><i class="fa fa-fw fa-table"></i><span>Tabel</br>Anggaran</span></a></li>
                             */
                            ?>
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
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/activity/index'; ?>">Kegiatan</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/satker/index'; ?>">Satker</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/ppk/index'; ?>">PPK</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/output/index'; ?>">Output</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/suboutput/index'; ?>">Suboutput</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/component/index'; ?>">Komponen</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/subcomponent/index'; ?>">Subkomponen</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/account/index'; ?>">Akun</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/province/index'; ?>">Provinsi</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl . '/city/index'; ?>">Kab/Kota</a></li>
                                    </ul>
                                </li>
                                <?php
                                $class = '';
                                if (Yii::app()->controller->id == 'dipa') {
                                    $class = 'active';
                                }
                                ?>
                                <li class="<?php echo $class; ?>">
                                    <a href="<?php echo Yii::app()->baseUrl . '/dipa/index'; ?>"><i class="fa fa-fw fa-upload"></i><span>DIPA/POK</span></a>
                                </li>
                            <?php endif; ?>
                            <?php if ($group == 'operator' || $group == 'administrator' || $group == 'super-admin'): ?>
                                <?php
                                $class = '';
                                if (Yii::app()->controller->id == 'package') {
                                    $class = 'active';
                                }
                                ?>
                                <li class="<?php echo $class; ?>">
                                    <a href="<?php echo Yii::app()->baseUrl . '/package/index'; ?>"><i class="fa fa-fw fa-book"></i><span>Informasi </br>Paket Pekerjaan</span></a>
                                </li>
                                <?php
                                $class = '';
                                if (Yii::app()->controller->id == 'realization') {
                                    $class = 'active';
                                }
                                ?>
                                <li class="<?php echo $class; ?>">
                                    <a href="<?php echo Yii::app()->baseUrl . '/realization/index'; ?>"><i class="fa fa-fw fa-ticket"></i><span>Realisasi</span></a>
                                </li>
                            <?php endif; ?>
                            <?php
                            $class = '';
                            if (Yii::app()->controller->getRoute() == 'site/report') {
                                $class = 'active';
                            }
                            ?>
                            <li class="<?php echo $class; ?>"><a href="<?php echo Yii::app()->baseUrl . '/site/report'; ?>"  onclick="return confirm('Download laporan pengunaan anggaran?')"><i class="fa fa-fw fa-file-text-o "></i> <span>Laporan</span></a></li>
                            <?php
                            $class = '';
                            if (Yii::app()->controller->getRoute() == 'site/guide') {
                                $class = 'active';
                            }
                            ?>
                            <li class="<?php echo $class; ?>"><a href="<?php echo Yii::app()->baseUrl . '/site/guide'; ?>"><i class="fa fa-fw fa-life-ring "></i> <span>User Guide</span></a></li>
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
                            <?php
                            $class = '';
                            if (Yii::app()->controller->getRoute() == 'site/about') {
                                $class = 'active';
                            }
                            ?>
                            <li class="<?php echo $class; ?>"><a href="<?php echo Yii::app()->baseUrl . '/site/about'; ?>"><i class="fa fa-fw fa-info-circle"></i> <span>About</span></a></li>
                        </ul>
                    </nav>
                </div>
            </aside>
            <div class="date-container"></div>
            <div class="content">
                <header class="flex">
                    <h1 class="title"><b><?php echo $this->title; ?></b></h1>
                    <div class="dropdown">
                        <a style="text-decoration: none" class="dropdown-toggle username" data-toggle="dropdown" href="#"><?php echo (Yii::app()->user->isGuest) ? 'GUEST' : '<i class="fa fa-fw fa-circle"></i>' . strtoupper($user->username); ?> <b class="caret"></b></a>
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
