<?php

$this->breadcrumbs = array(
    'Up Details' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List UpDetail', 'url' => array('index')),
    array('label' => 'Create UpDetail', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('up-detail-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php

$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'up-detail-grid',
    'dataProvider' => $model->search(),
//    'filter' => $model,
    'columns' => array(
        array(
            'header' => 'No',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        //'id',
        array(
            'name' => 'up_number_of_letter',
            'value' => '$data->up_number_of_letter',
            'filter' => Up::model()->getUpOptions(),
        ),
        'package_code',
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
        ),
    ),
));
?>
