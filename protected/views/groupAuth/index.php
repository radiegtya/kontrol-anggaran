<?php
/* @var $this GroupAuthController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Group Auths',
);

$this->menu=array(
	array('label'=>'Create GroupAuth', 'url'=>array('create')),
	array('label'=>'Manage GroupAuth', 'url'=>array('admin')),
);
?>

<h1>Group Auths</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
