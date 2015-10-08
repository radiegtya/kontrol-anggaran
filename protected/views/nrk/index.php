<?php
$this->breadcrumbs=array(
	'Nrks',
);

$this->menu=array(
	array('label'=>'Create Nrk','url'=>array('create')),
	array('label'=>'Manage Nrk','url'=>array('admin')),
);
?>

<h1>Nrks</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
