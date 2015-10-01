<?php
$this->breadcrumbs=array(
	'Up Details',
);

$this->menu=array(
	array('label'=>'Create UpDetail','url'=>array('create')),
	array('label'=>'Manage UpDetail','url'=>array('admin')),
);
?>

<h1>Up Details</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
