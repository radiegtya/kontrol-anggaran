<?php

$this->breadcrumbs = array(
    'Nrk Details' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List NrkDetail', 'url' => array('index')),
    array('label' => 'Create NrkDetail', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('nrk-detail-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php

$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'nrk-detail-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'header' => 'No',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        //'id',
        array(
            'name' => 'nrk_register',
            'value' => '$data->nrk_register',
            'filter' => Nrk::model()->getNrkOptions(),
        ),
        array(
            'name' => 'nrk_contract_number',
            'value' => '$data->nrk_contract_number',
            'filter' => Nrk::model()->getNrkNumberOptions(),
        ),
        array(
            'name' => 'termin',
            'value' => '$data->termin',
            'filter' => VEnum::getEnumOptions(new NrkDetail, "termin"),
        ),
        array(
            "name" => "limit_per_termin",
            "value" => 'Yii::app()->format->number($data->limit_per_termin)',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'headerHtmlOptions' => array('style' => 'text-align: right;'),
            'filter' => FALSE,
        ),
//        'created_at',
//        array(
//            'name' => 'created_by',
//            'value' => '$data->createdBy->username',
//            'filter' => User::model()->getOptions(),
//        ),
        /*
          'updated_at',
          array(
          'name'=>'updated_by',
          'value'=>'$data->updatedBy->name',
          'filter'=>UpdatedBy::model()->getOptions(),
          ),
         */
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>
