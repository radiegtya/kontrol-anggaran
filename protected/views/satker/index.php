<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <a href="<?php echo yii::app()->baseUrl; ?>/satker/export" class="btn btn-primary"><i class="fa fa fa-download"></i> Export</a>
        <a href="<?php echo yii::app()->baseUrl; ?>/satker/import" class="btn btn-primary"><i class="fa fa fa-upload"></i> Import</a>
        <a href="<?php echo yii::app()->baseUrl; ?>/satker/clear" onclick="return confirm('Yakin ingin menghapus semua data satker?')" class="btn btn-primary"><i class="fa fa-fw fa-trash"></i> Bersihkan Data</a>

    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'satker-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                array(
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                ),
                //'id',
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

