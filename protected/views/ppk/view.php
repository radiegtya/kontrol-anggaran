<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Ppk' => array('admin'),
          $model->official_name,
          );
         * 
         */
        ?>
        <a href="<?php echo Yii::app()->baseUrl . '/ppk/index'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Kembali ke Daftar PPK</a>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                'code',
                'ppk_name',
                'official_name',
                'official_nip',
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
