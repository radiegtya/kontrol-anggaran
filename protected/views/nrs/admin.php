<div class="panel panel-default">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Nrs' => array('index'),
          'Manage',
          );
         * 
         */
        ?>
        <a href="<?php echo yii::app()->baseUrl; ?>/nrs/create" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> Tambah</a>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'nrs-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                array(
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                ),
                //'id',
                'nrs',
                'supplier_name',
                'npwp',
                'bank_name',
                'bank_account_number',
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                ),
            ),
        ));
        ?>
    </div>
</div>

