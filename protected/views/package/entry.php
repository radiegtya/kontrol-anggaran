<div class="panel panel-default">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Packages' => array('index'),
          'Create',
          );
         * 
         */
        ?>
        <a href="<?php echo Yii::app()->baseUrl . '/package/index'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Kembali ke Daftar Paket Pekerjaan</a>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_multiForm', array('model' => $model)); ?>
    </div>
</div>