<?php

$this->breadcrumbs = array(
    'Budgets' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Budget', 'url' => array('index')),
    array('label' => 'Create Budget', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('budget-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>




<?php

$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'budget-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'header' => 'No',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        //'id',
        array(
            'name' => 'dipa_id',
            'value' => '$data->dipa->dipa_number',
            'filter' => Dipa::model()->getDipaOptions(),
        ),
        array(
            'name' => 'output_code',
            'value' => 'isset($data->outputCode->name)?$data->outputCode->name:$data->output_code',
            'filter' => Output::model()->getOutputOptions(),
        ),
        array(
            'name' => 'suboutput_code',
            'value' => 'isset($data->suboutputCode->name)?$data->suboutputCode->name:$data->suboutput_code',
            'filter' => Suboutput::model()->getSuboutputOptions(),
        ),
        array(
            'name' => 'component_code',
            'value' => 'isset($data->componentCode->name)?$data->componentCode->name:$data->component_code',
            'filter' => Component::model()->getComponentOptions(),
        ),
        array(
            'name' => 'subcomponent_code',
            'value' => 'isset($data->subcomponentCode->name)?$data->subcomponentCode->name:$data->subcomponent_code',
            'filter' => Subcomponent::model()->getSubcomponentOptions(),
        ),
                'subcomponent_code',
        array(
            'name' => 'account_code',
            'value' => 'isset($data->accountCode->name)?$data->accountCode->name:$data->account_code',
            'filter' => Account::model()->getAccountOptions(),
        ),
        array(
            "name" => "total_budget_limit",
            "value" => 'Yii::app()->format->number($data->total_budget_limit)',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        /*
          'created_at',
          array(
          'name'=>'created_by',
          'value'=>'$data->createdBy->name',
          'filter'=>CreatedBy::model()->getOptions(),
          ),
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
