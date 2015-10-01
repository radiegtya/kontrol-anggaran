<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Outputs' => array('index'),
          $model->name,
          );
         */
        ?>
        <a href="<?php echo Yii::app()->baseUrl . '/output/index'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Kembali ke Daftar Output</a>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'satker_code',
                    'value' => isset($model->satker->name) ? $model->satker->name : 'Not Set',
                ),
                array(
                    'name' => 'activity_code',
                    'value' => isset($model->activityCode->name) ? $model->activityCode->name : "Not Set",
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
