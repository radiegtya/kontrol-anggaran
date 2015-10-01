<?php
$this->breadcrumbs=array(
	'Nrk Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List NrkDetail','url'=>array('index')),
	array('label'=>'Manage NrkDetail','url'=>array('admin')),
);
?>

<h2>Create NrkDetail</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>