<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <a href="<?php echo yii::app()->baseUrl; ?>/province/export" class="btn btn-primary"><i class="fa fa fa-download"></i> Export</a>
        <a href="<?php echo yii::app()->baseUrl; ?>/province/import" class="btn btn-primary"><i class="fa fa fa-upload"></i> Import</a>
        <a href="<?php echo yii::app()->baseUrl; ?>/province/clear" onclick="return confirm('Yakin ingin menghapus semua data provinsi?')" class="btn btn-primary"><i class="fa fa fa-trash"></i>Bersihkan Data</a>

    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'province-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'code',
                'name',
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'template' => '{view}',
                ),
            ),
        ));
        ?>
    </div>
</div>

