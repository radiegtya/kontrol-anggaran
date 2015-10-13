<?php
$this->breadcrumbs=array(
	'Nrs',
);

$this->menu=array(
	array('label'=>'Create Nrs','url'=>array('create')),
	array('label'=>'Manage Nrs','url'=>array('admin')),
);
?>

<h1>Nrs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
