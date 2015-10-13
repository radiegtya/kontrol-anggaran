<?php
$this->breadcrumbs=array(
	'Budgets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Budget','url'=>array('index')),
	array('label'=>'Manage Budget','url'=>array('admin')),
);
?>

<h2>Create Budget</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>