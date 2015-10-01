<div class="panel panel-default">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Users' => array('index'),
          $model->id => array('view', 'id' => $model->id),
          'Update',
          );
         * 
         */
        ?>
        <a href="<?php echo Yii::app()->baseUrl . '/user/admin'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Daftar</a>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_formUpdate', array('model' => $model)); ?>
    </div>
</div>