<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Activities' => array('index'),
          'Manage',
          );
         * 
         */
        ?>
        <a href="<?php echo yii::app()->baseUrl; ?>/activity/export" class="btn btn-primary"><i class="fa fa-fw fa-download"></i> Export</a>
        <a href="<?php echo yii::app()->baseUrl; ?>/activity/import" class="btn btn-primary"><i class="fa fa-fw fa-upload"></i> Import</a>
        <a href="<?php echo yii::app()->baseUrl; ?>/activity/clear" onclick="return confirm('Yakin ingin menghapus semua data kegiatan?')" class="btn btn-primary"><i class="fa fa-fw fa-trash"></i> Bersihkan Data</a>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'activity-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'summaryText' => '',
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
                    'name' => 'code',
                    'value' => 'isset($data->code)?str_replace($data->satker_code.".","",$data->code):"Not set"',
//                    'filter' => Activity::model()->getActivityOptions(),
                ),
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

