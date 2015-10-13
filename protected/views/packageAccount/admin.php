<?php
$this->breadcrumbs = array(
    'Package Accounts' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List PackageAccount', 'url' => array('index')),
    array('label' => 'Create PackageAccount', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('package-account-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h2>Manage Package Accounts</h2>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'package-account-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'header' => 'No',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        //'id',
        'code',
        'satker_code',
        'activity_code',
        'output_code',
        'suboutput_code',
        'component_code',
        'package_code',
        'account_code',
        'budget_code',
        'province_code',
        'city_code',
        'ppk_code',
        'limit',
        /*
          array(
          'name'=>'up',
          'value'=>'$data->up',
          'filter'=>VEnum::getEnumOptions(new PackageAccount, "up"),
          ),
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
