<?php
$this->breadcrumbs=array(
	'Up Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UpDetail','url'=>array('index')),
	array('label'=>'Manage UpDetail','url'=>array('admin')),
);
?>

<h2>Create UpDetail</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>