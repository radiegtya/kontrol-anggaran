<?php
$this->breadcrumbs=array(
	'Package Accounts',
);

$this->menu=array(
	array('label'=>'Create PackageAccount','url'=>array('create')),
	array('label'=>'Manage PackageAccount','url'=>array('admin')),
);
?>

<h1>Package Accounts</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
