<div class="panel panel-default">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Nrks' => array('index'),
          'Manage',
          );
         * 
         */
        ?>
        <a href="<?php echo yii::app()->baseUrl; ?>/nrk/create" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> Tambah</a>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'nrk-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                array(
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                ),
                array(
                    'name' => 'nrk',
                    'type' => 'raw',
                    'value' => 'CHtml::link($data->nrk,array("nrk/view","id"=>$data->id))',
                ),
                array(
                    'name' => 'contract_number',
                    'type' => 'raw',
                    'value' => 'CHtml::link($data->contract_number,array("nrk/view","id"=>$data->id))',
                ),
                array(
                    'name' => 'contract_date',
                    'value' => 'date("j F Y", strtotime($data->contract_date))',
                    'filter' => FALSE,
                ),
                array(
                    "name" => "limit",
                    "value" => 'Yii::app()->format->number($data->limit)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'headerHtmlOptions' => array('style' => 'text-align: right;'),
                    'filter' => FALSE,
                ),
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                ),
            ),
        ));
        ?>
    </div>
</div>