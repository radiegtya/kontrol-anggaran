<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <a href="<?php echo yii::app()->baseUrl; ?>/city/export" class="btn btn-primary"><i class="fa fa fa-download"></i> Export</a>
        <a href="<?php echo yii::app()->baseUrl; ?>/city/import" class="btn btn-primary"><i class="fa fa fa-upload"></i> Import</a>
        <a href="<?php echo yii::app()->baseUrl; ?>/city/clear" onclick="return confirm('Yakin ingin menghapus semua data provinsi?')" class="btn btn-primary"><i class="fa fa fa-trash"></i>Bersihkan Data</a>
    </div>
    <div class="pael-body">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'city-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                array(
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                ),
                //'id',
                array(
                    'name' => 'province_code',
                    'value' => 'isset($data->province->name)?$data->province->name:""',
                    'filter' => Province::model()->getOptionsCodeName(),
                ),
                'name',
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                ),
            ),
        ));
        ?>
    </div>
</div>