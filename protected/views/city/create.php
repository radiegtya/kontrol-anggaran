<div class="panel panle-default">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs=array(
          'Cities'=>array('index'),
          'Create',
          );
         * 
         */
        ?>
        <a href="<?php echo Yii::app()->baseUrl . '/city/admin'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Daftar</a>
        <a href="<?php echo Yii::app()->baseUrl . '/city/import'; ?>" class="btn btn-default"><i class="fa fa-fw fa-upload"></i>Import Excel</a>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>

    </div>
</div>