<?php
$this->breadcrumbs=array(
	'Package Accounts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PackageAccount','url'=>array('index')),
	array('label'=>'Manage PackageAccount','url'=>array('admin')),
);
?>

<h2>Create PackageAccount</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>