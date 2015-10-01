<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Suboutputs' => array('index'),
          $model->name,
          );
         * 
         */
        ?>
        <a href="<?php echo Yii::app()->baseUrl . '/suboutput/index'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Kembali ke Daftar Suboutput</a>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'satker_code',
                    'value' => isset($model->satker->name) ? $model->satker->name : "Not Set",
                ),
                array(
                    'name' => 'activity_code',
                    'value' => isset($model->activity->name) ? $model->activity->name : "Not Set",
                ),
                array(
                    'name' => 'output_code',
                    'value' => isset($model->outputCode->name) ?$model->outputCode->name : "Not Set",
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
