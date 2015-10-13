
<div class="panel panel-default">
    <div class="panel-header">
        <a href="<?php echo Yii::app()->baseUrl . '/paymentMethod/admin'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Daftar</a>
        <?php
        /*
          $this->breadcrumbs = array(
          'Payment Methods' => array('index'),
          'Create',
          );
         * 
         */
        ?>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>