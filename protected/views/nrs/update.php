<div class="panel panel-default">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Nrs' => array('index'),
          $model->id => array('view', 'id' => $model->id),
          'Update',
          );
         * 
         */
        ?>
        <a href="<?php echo Yii::app()->baseUrl . '/nrs/admin'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Daftar</a>
        <a href="<?php echo Yii::app()->baseUrl . '/nrs/create'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>Tambah</a>
        <a href="<?php echo Yii::app()->baseUrl . '/nrs/' . $model->id; ?>" class="btn btn-primary"><i class="fa fa-fw fa-eye"></i>Rincian</a>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>