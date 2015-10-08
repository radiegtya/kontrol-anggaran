<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Accounts' => array('index'),
          'Manage',
          );
         * 
         */
        ?>
        <a href="<?php echo yii::app()->baseUrl; ?>/account/export" class="btn btn-primary"><i class="fa fa-fw fa-download"></i> Export</a>
        <a href="<?php echo yii::app()->baseUrl; ?>/account/import" class="btn btn-primary"><i class="fa fa fa-upload"></i> Import</a>
        <a href="<?php echo yii::app()->baseUrl; ?>/account/clear" onclick="return confirm('Yakin ingin menghapus semua data akun?')" class="btn btn-primary"><i class="fa fa fa-trash"></i>Bersihkan Data</a>

    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'account-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                array(
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                ),
                'code',
                'name',
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                ),
            ),
        ));
        ?>
    </div>
</div>