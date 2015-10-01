<?php
$this->breadcrumbs=array(
	'Nrk Details'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List NrkDetail','url'=>array('index')),
	array('label'=>'Create NrkDetail','url'=>array('create')),
	array('label'=>'View NrkDetail','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage NrkDetail','url'=>array('admin')),
);
?>

<h2>Update NrkDetail <?php echo $model->id; ?></h2>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>