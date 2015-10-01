<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo.png"></link>
        <!-- blueprint CSS framework -->
        <!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/screen.css" media="screen, projection" /> -->
        <!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" media="print" /> -->
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/bower_components/fontawesome/css/font-awesome.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/table.css" />
        
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/main.js"></script>
    </head>

    <body>
        <?php
        $this->widget('ext.EChosen.EChosen', array(
            'target' => 'select.autocomplete',
        ));
        ?>
        <?php $this->widget('ext.ambiance.VAmbiance'); ?>

        <div class="header">
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span3">
                        <div class="logo">
                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/svg/logo.svg"/>
                            <?php echo Yii::app()->name; ?>                
                        </div>
                    </div>
                    <div class="span9">
                        <div class="panel text-right pull-right">
                            <?php
                            $this->widget('bootstrap.widgets.TbMenu', array(
                                'type' => 'list',
                                'items' => array(
                                    array('label' => 'Home', 'url' => array('/site/index')),
                                    array('label' => 'Nominatif', 'url' => array('/recap/admin'), 'visible' => !Yii::app()->user->isGuest),
                                    array('label' => 'Perjalanan Dinas', 'url' => array('/tour/admin'), 'visible' => !Yii::app()->user->isGuest),
//                                    array('label' => 'History Perjalanan Dinas', 'url' => array('/tour/history'), 'visible' => !Yii::app()->user->isGuest),
                                    array('label' => 'Pegawai', 'url' => array('/employee/admin')),
                                    array('label' => 'Standar Biaya Umum', 'url' => array('/standartGeneralExpense/admin')),
                                    array('label' => 'Pagu', 'url' => array('/recapLimit/admin')),
                                    array('label' => 'Master', 'items' => array(
                                            array('label' => 'Kota', 'url' => array('/city/admin')),
                                            array('label' => 'Jabatan', 'url' => array('/employeePosition/admin')),
                                            array('label' => 'Jenis Transportasi', 'url' => array('/vehicle/admin')),
                                        ), 'visible' => !Yii::app()->user->isGuest),
                                    '',
                                    array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                                    array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
                                )
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- header -->       

        <!--        <div class="breadcrumbs">
                    <div class="container">
                        <div id="breadcrumbs">
        <?php // if (isset($this->breadcrumbs)): ?>    
        <?php
//                        $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
//                            'links' => $this->breadcrumbs,
//                        ));
        ?>
        <?php // endif ?>
        
        
                        </div>
                    </div>
                </div>-->



        <!--                    <div class="span3">
                                <div id="mainmenu">
        <?php
//                            $this->widget('bootstrap.widgets.TbMenu', array(
//                                'type' => 'list',
//                                'items' => array(
//                                    array('label' => 'Home', 'url' => array('/site/index')),
//                                    array('label' => 'Tour', 'url' => array('/tour/admin')),
//                                    array('label' => 'Master', 'items' => array(
//                                            array('label' => 'Kota', 'url' => array('/city/admin')),
//                                            array('label' => 'Pegawai', 'url' => array('/employee/admin')),
//                                            array('label' => 'Jabatan', 'url' => array('/employeePosition/admin')),
//                                            array('label' => 'Rekap', 'url' => array('/recap/admin')),
//                                            array('label' => 'Standar Biaya Umum', 'url' => array('/standartGeneralExpense/admin')),
//                                            array('label' => 'Kendaraan', 'url' => array('/vehicle/admin')),
//                                        )),
//                                    '',
//                                    array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
//                                    array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
//                                )
//                            ));
        ?>
                                </div> mainmenu 
                            </div>-->


        <div class="content">
            <?php
//                            $this->widget('bootstrap.widgets.TbButtonGroup', array(
//                                'buttons' => $this->menu,
//                            ));
            ?>     
            <?php echo $content; ?>
            <div class="footer">
                <div class="container">
                    <footer>
                        <div class="pull-left">Copyright &copy; <?php echo date('Y'); ?> by <a href="http://piyiku.biz" target="_blank">Piyiku</a> All Rights Reserved.</div>
                        <div class="pull-right"><a href="<?php echo Yii::app()->baseUrl; ?>/site/page/page?view=about">About</a> | <?php echo Yii::powered(); ?></div>
                        <div class="clearfix"></div>
                    </footer><!-- footer -->            
                </div>

            </div>
        </div>      
    </body>
</html>
