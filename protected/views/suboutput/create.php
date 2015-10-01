<div class="panel panel-default">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Suboutputs' => array('index'),
          'Create',
          );
         * 
         */
        ?>
        <a href="<?php echo Yii::app()->baseUrl . '/suboutput/admin'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Daftar</a>
        <a href="<?php echo Yii::app()->baseUrl . '/suboutput/import'; ?>" class="btn btn-default"><i class="fa fa-fw fa-upload"></i>Import Excel</a>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>

    </div>
</div>