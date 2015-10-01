<div class="panel panel-default">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs=array(
          'Accounts'=>array('index'),
          $model->name=>array('view','id'=>$model->code),
          'Update',
          );
         * 
         */
        ?>
        <a href="<?php echo Yii::app()->baseUrl . '/account/index'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Kembali ke Daftar Akun</a>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>

    </div>
</div>