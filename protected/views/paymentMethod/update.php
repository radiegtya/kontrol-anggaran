
<div class="panel panel-default">
    <div class = "panel-header">
        <a href="<?php echo Yii::app()->baseUrl . '/paymentMethod/admin'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Daftar</a>
        <a href="<?php echo Yii::app()->baseUrl . '/paymentMethod/create'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>Tambah</a>
        <a href="<?php echo Yii::app()->baseUrl . '/paymentMethod/' . $model->id; ?>" class="btn btn-primary"><i class="fa fa-fw fa-eye"></i>Rincian</a>
        <?php
        /*
          $this->breadcrumbs = array(
          'Payment Methods' => array('index'),
          $model->name => array('view', 'id' => $model->id),
          'Update',
          );
         */
        ?>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>