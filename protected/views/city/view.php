<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Cities' => array('index'),
          $model->name,
          );
         * 
         */
        ?>
        <a href="<?php echo Yii::app()->baseUrl . '/city/admin'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Kembali ke Daftar Kota</a>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
//        'id',
                array(
                    'name' => 'province_code',
                    'value' => $model->province->name,
                    'source' => Province::model()->getOptions(),
                ),
                'code',
                'name',
                array(
                    'name' => 'created_at',
                    'value' => Yii::app()->dateFormatter->format('dd MMM yyyy', $model->created_at),
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