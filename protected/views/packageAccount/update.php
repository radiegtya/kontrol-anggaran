<?php
$this->breadcrumbs=array(
	'Package Accounts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PackageAccount','url'=>array('index')),
	array('label'=>'Create PackageAccount','url'=>array('create')),
	array('label'=>'View PackageAccount','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage PackageAccount','url'=>array('admin')),
);
?>

<h2>Update PackageAccount <?php echo $model->id; ?></h2>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>