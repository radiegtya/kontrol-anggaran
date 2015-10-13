<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Dipas' => array('index'),
          $model->id => array('view', 'id' => $model->id),
          'Update',
          );
         * 
         */
        ?>
        <a href="<?php echo Yii::app()->baseUrl . '/dipa/index'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Kembali ke Daftar DIPA/POK</a>
        <a href="<?php echo Yii::app()->baseUrl . '/dipa/' . $model->id; ?>" class="btn btn-primary"><i class="fa fa-fw fa-eye"></i>Rincian DIPA/POK</a>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_formUpdate', array('model' => $model)); ?>
    </div>
</div>