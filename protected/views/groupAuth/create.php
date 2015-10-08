<?php
/* @var $this GroupAuthController */
/* @var $model GroupAuth */

$this->breadcrumbs=array(
	'Group Auths'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GroupAuth', 'url'=>array('index')),
	array('label'=>'Manage GroupAuth', 'url'=>array('admin')),
);
?>

<h1>Create GroupAuth</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>