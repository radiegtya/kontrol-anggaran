<?php
$this->breadcrumbs=array(
	'Realizations'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Realization','url'=>array('index')),
	array('label'=>'Create Realization','url'=>array('create')),
	array('label'=>'View Realization','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Realization','url'=>array('admin')),
);
?>

<h2>Update Realization <?php echo $model->id; ?></h2>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>