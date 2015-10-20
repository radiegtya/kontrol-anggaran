<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Subcomponents' => array('index'),
          'Manage',
          );
         * 
         */
        ?>
        <a href="<?php echo yii::app()->baseUrl; ?>/subcomponent/export" class="btn btn-primary"><i class="fa fa fa-download"></i> Export</a>
        <a href="<?php echo yii::app()->baseUrl; ?>/subcomponent/import" class="btn btn-primary"><i class="fa fa fa-upload"></i> Import</a>
        <!--<a href="<?php echo yii::app()->baseUrl; ?>/subcomponent/clear" onclick="return confirm('Yakin ingin menghapus semua data subkomponen?')" class="btn btn-primary"><i class="fa fa fa-trash"></i>Bersihkan Data</a>-->

    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'subcomponent-grid',
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
                    'value' => 'isset($data->outputCode->name)?$data->outputCode->name:$data->output_code',
                    'filter' => Output::model()->getOutputOptions(),
                ),
                array(
                    'name' => 'suboutput_code',
                    'value' => 'isset($data->suboutputCode->name)?$data->suboutputCode->name:$data->suboutput_code',
                    'filter' => Suboutput::model()->getSuboutputOptions(),
                ),
                array(
                    'name' => 'component_code',
                    'value' => 'isset($data->componentCode->name)?$data->componentCode->name:$data->component_code',
                    'filter' => Component::model()->getComponentOptions(),
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