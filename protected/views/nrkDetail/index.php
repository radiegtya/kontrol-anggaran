<?php
$this->breadcrumbs=array(
	'Nrk Details',
);

$this->menu=array(
	array('label'=>'Create NrkDetail','url'=>array('create')),
	array('label'=>'Manage NrkDetail','url'=>array('admin')),
);
?>

<h1>Nrk Details</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
