<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Provinces' => array('index'),
          $model->name,
          );
         * 
         */
        ?>
        <a href="<?php echo Yii::app()->baseUrl . '/province/index'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Kembali ke Daftar Provinsi</a>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                'code',
                'name',
                array(
                    'name' => 'created_at',
                    'value' => ($model->created_at == '0000-00-00') ? '-' : date("j F Y", strtotime($model->created_at)),
                ),
                array(
                    'name' => 'created_by',
                    'value' => $model->createdBy->username,
                    'source' => User::model()->getOptions(),
                ),
            ),
        ));
        ?>
    </div>
</div>
