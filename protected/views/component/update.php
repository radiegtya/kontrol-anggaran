<div class="panel panel-default">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Components' => array('index'),
          $model->name => array('view', 'id' => $model->id),
          'Update',
          );
         * 
         */
        ?>
        <a href="<?php echo Yii::app()->baseUrl . '/component/admin'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Daftar</a>
        <a href="<?php echo Yii::app()->baseUrl . '/component/create'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>Tambah</a>
        <a href="<?php echo Yii::app()->baseUrl . '/component/import'; ?>" class="btn btn-default"><i class="fa fa-fw fa-upload"></i>Import Excel</a>
        <a href="<?php echo Yii::app()->baseUrl . '/component/' . $model->id; ?>" class="btn btn-primary"><i class="fa fa-fw fa-eye"></i>Rincian</a>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>

    </div>
</div>