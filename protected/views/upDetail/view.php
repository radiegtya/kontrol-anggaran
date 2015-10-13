<?php
$this->breadcrumbs = array(
    'Up Details' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List UpDetail', 'url' => array('index')),
    array('label' => 'Create UpDetail', 'url' => array('create')),
    array('label' => 'Update UpDetail', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete UpDetail', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage UpDetail', 'url' => array('admin')),
);
?>

<h4>Rincian Detail UP</h4>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'up_number_of_letter',
        array(
            'name' => 'package_name',
            'value' => isset($model->budget->subcomponentCode->name) ? $model->package_name . " - " . $model->budget->subcomponentCode->name : $model->package_name,
        ),
        array(
            'name' => 'limit',
            'value' => Yii::app()->format->number($model->limit),
        ),
        array(
            'name' => 'created_at',
            'value' => Yii::app()->dateFormatter->format('dd MMM yyyy', $model->created_at),
        ),
        array(
            'name' => 'created_by',
            'value' => $model->createdBy->username,
        ),
    ),
));
?>
