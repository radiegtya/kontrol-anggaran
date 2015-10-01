<?php
$this->breadcrumbs=array(
	'Budgets',
);

$this->menu=array(
	array('label'=>'Create Budget','url'=>array('create')),
	array('label'=>'Manage Budget','url'=>array('admin')),
);
?>

<h1>Budgets</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
