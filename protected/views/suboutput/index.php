<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Suboutputs' => array('index'),
          'Manage',
          );
         * 
         */
        ?>
        <a href="<?php echo yii::app()->baseUrl; ?>/suboutput/export" class="btn btn-primary"><i class="fa fa fa-download"></i> Export</a>
        <a href="<?php echo yii::app()->baseUrl; ?>/suboutput/import" class="btn btn-primary"><i class="fa fa fa-upload"></i> Import</a>
        <a href="<?php echo yii::app()->baseUrl; ?>/suboutput/clear" onclick="return confirm('Yakin ingin menghapus semua data suboutput?')" class="btn btn-primary"><i class="fa fa fa-trash"></i>Bersihkan Data</a>

    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'suboutput-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                array(
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                ),
                array(
                    'name' => 'satker_code',
                    'value' => 'isset($data->satker->name)?$data->satker->name:"Not set"',
                    'filter' => Satker::model()->getSatkerOptions(),
                ),
                array(
                    'name' => 'activity_code',
                    'value' => 'isset($data->activity->name)?$data->activity->name:"Not set"',
                    'filter' => Activity::model()->getActivityOptions(),
                ),
                array(
                    'name' => 'output_code',
                    'value' => 'isset($data->outputCode->name)?$data->outputCode->name:"Not set"',
                    'filter' => Output::model()->getOutputOptions(),
                ),
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
