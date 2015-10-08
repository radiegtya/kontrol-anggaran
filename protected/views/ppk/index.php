<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Ppks' => array('index'),
          'Manage',
          );
         * 
         */
        ?>
        <a href="<?php echo yii::app()->baseUrl; ?>/ppk/export" class="btn btn-primary"><i class="fa fa-fw fa-download"></i> export</a>
        <a href="<?php echo yii::app()->baseUrl; ?>/ppk/import" class="btn btn-primary"><i class="fa fa-fw fa-upload"></i> import</a>
        <a href="<?php echo yii::app()->baseUrl; ?>/ppk/clear" onclick="return confirm('Yakin ingin menghapus semua data ppk?')" class="btn btn-primary"><i class="fa fa-fw fa-trash"></i> Bersihkan Data</a>
    </div>
    <div class="panel-body">

        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'ppk-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'code',
                'ppk_name',
                'official_name',
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'template' => '{view}',
                ),
            ),
        ));
        ?>
    </div>
</div>

