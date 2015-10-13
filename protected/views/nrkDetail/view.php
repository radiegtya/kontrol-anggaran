<?php
$this->breadcrumbs = array(
    'Nrk Details' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List NrkDetail', 'url' => array('index')),
    array('label' => 'Create NrkDetail', 'url' => array('create')),
    array('label' => 'Update NrkDetail', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete NrkDetail', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage NrkDetail', 'url' => array('admin')),
);
?>

<h4>Detail NRK</h4>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'nrk_contract_number',
        array(
            'name' => 'termin',
            'value' => $model->termin,
        ),
        array(
            'name' => 'limit_per_termin',
            'value' => Yii::app()->format->number($model->limit_per_termin),
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
