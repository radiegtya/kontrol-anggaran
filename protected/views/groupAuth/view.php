<?php
/* @var $this GroupAuthController */
/* @var $model GroupAuth */

$this->breadcrumbs=array(
	'Group Auths'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List GroupAuth', 'url'=>array('index')),
	array('label'=>'Create GroupAuth', 'url'=>array('create')),
	array('label'=>'Update GroupAuth', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GroupAuth', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GroupAuth', 'url'=>array('admin')),
);
?>

<h1>View GroupAuth #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'className',
		'action',
		array(
                    'name'=>'group_id',
                    'value'=>$model->group->name,
                ),
	),
)); ?>
