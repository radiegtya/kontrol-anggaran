<div class="panel panel-default">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Outputs' => array('index'),
          'Create',
          );
         * 
         */
        ?>
        <a href="<?php echo Yii::app()->baseUrl . '/output/admin'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Daftar</a>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>

    </div>
</div>