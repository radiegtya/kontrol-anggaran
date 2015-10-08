<div class="row-fluid">
    <div class="span6">
        <div class="panel panel-default">
            <div class="panel-header">
                <a href="<?php echo yii::app()->baseUrl; ?>/up/update/<?php echo $model->id; ?>" class="btn btn-primary">Update</a>
            </div>
            <div class="panel-body">
                <?php
                $this->widget('bootstrap.widgets.TbDetailView', array(
                    'data' => $model,
                    'attributes' => array(
//		'id',
                        'number_of_letter',
                        array(
                            'name' => 'date_of_letter',
                            'value' => Yii::app()->dateFormatter->format('dd MMM yyyy', $model->date_of_letter),
                        ),
                        array(
                            'name' => 'total_up',
                            'value' => Yii::app()->format->number($model->total_up),
                        ),
                        array(
                            'name' => 'created_at',
                            'value' => Yii::app()->dateFormatter->format('dd MMM yyyy', $model->created_at),
                        ),
                        array(
                            'name' => 'created_by',
                            'value' => $model->user->username,
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="panel panel-default">
            <div class="panel-header">
                Tambah paket alokasi UP/TUP
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial('../upDetail/_form', array('model' => $addDetail)); ?>

            </div>
        </div>
    </div>
</div>



<div class="panel panel-default">
    <div class="panel-header">
        Alokasi UP/TUP
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'up-detail-grid',
            'dataProvider' => $modelDetail->searchDetail($model->number_of_letter),
            'columns' => array(
                array(
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                ),
                //'id',
                'package_code',
                array(
                    'name' => 'package_code',
                    'header' => 'Nama Paket',
                    'value' => 'isset($data->package->name)?$data->package->name:$data->package_code',
                ),
                array(
                    'name' => 'limit',
                    'value' => 'Yii::app()->format->number($data->limit)',
                ),
                array(
                    "name" => "realization",
                    "value" => 'Yii::app()->format->number($data->getTotalDetail($data->package_code,$data->up_number_of_letter)["realization"])',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'filter' => FALSE,
                ),
                array(
                    "name" => "restUp",
                    "value" => 'Yii::app()->format->number($data->getTotalDetail($data->package_code,$data->up_number_of_letter)["restUp"])',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'filter' => FALSE,
                ),
                array('name' => 'rateUpUsing',
                    'type' => 'raw',
                    'filter' => FALSE,
                    'value' => function($data) {
                        $rate = $data->getTotalDetail($data->package_code, $data->up_number_of_letter)['rateUpUsing'];
                        return "<div class='slider' data-progress='$rate'><span></span><label></label></div>";
                    }
                ),
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'template' => '{update}{delete}',
//                    'template' => '{view}{update}{delete}',
                    'buttons' => array(
                        'view' => array(
                            'label' => 'view',
                            'url' => 'Yii::app()->createUrl("upDetail/view", array( "id" => $data->id))',
                        ),
                        'update' => array(
                            'label' => 'update detail',
                            'url' => 'Yii::app()->createUrl("up/updateDetail", array( "id" => $data->id))',
                            'visible' => "$user->group_id=='1'||$user->group_id=='4'",
                        ),
                        'delete' => array(
                            'label' => 'delete',
                            'url' => 'Yii::app()->createUrl("upDetail/delete", array( "id" => $data->id))',
                        ),
                    ),
                ),
            ),
        ));
        ?>

    </div>
</div>
