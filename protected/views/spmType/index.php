<?php
$this->breadcrumbs=array(
	'Spm Types',
);

$this->menu=array(
	array('label'=>'Create SpmType','url'=>array('create')),
	array('label'=>'Manage SpmType','url'=>array('admin')),
);
?>

<h1>Spm Types</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
