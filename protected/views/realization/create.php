<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <a href="<?php echo Yii::app()->baseUrl . '/realization/index'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Kembali ke Daftar Realisasi</a>

    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>