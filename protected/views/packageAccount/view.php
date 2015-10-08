<?php
$this->breadcrumbs=array(
	'Package Accounts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PackageAccount','url'=>array('index')),
	array('label'=>'Create PackageAccount','url'=>array('create')),
	array('label'=>'Update PackageAccount','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete PackageAccount','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PackageAccount','url'=>array('admin')),
);
?>

<h2>View PackageAccount #<?php echo $model->id; ?></h2>

<?php $this->widget('bootstrap.widgets.TbEditableDetailView',array(
'url' => $this->createUrl('packageaccount/editable'),
	'data'=>$model,
	'attributes'=>array(
		'id',
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
		array(
			'name'=>'up',
			'value'=>$model->up,
			'editable'=>array(
				'type'=>'select',
				'source'=>VEnum::getEnumOptions($model, "up"),
			),
		),
		'created_at',
		array(
			'name'=>'created_by',
			'value'=>$model->createdBy->name,
			'editable'=>array(
				'type'=>'select',
				'source'=>CreatedBy::model()->getOptions(),
			),
		),
		'updated_at',
		array(
			'name'=>'updated_by',
			'value'=>$model->updatedBy->name,
			'editable'=>array(
				'type'=>'select',
				'source'=>UpdatedBy::model()->getOptions(),
			),
		),
	),
)); ?>
