<?php
$this->breadcrumbs=array(
	'Ups',
);

$this->menu=array(
	array('label'=>'Create Up','url'=>array('create')),
	array('label'=>'Manage Up','url'=>array('admin')),
);
?>

<h1>Ups</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
