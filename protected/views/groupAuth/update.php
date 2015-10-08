<?php
/* @var $this GroupAuthController */
/* @var $model GroupAuth */

$this->breadcrumbs=array(
	'Group Auths'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GroupAuth', 'url'=>array('index')),
	array('label'=>'Create GroupAuth', 'url'=>array('create')),
	array('label'=>'View GroupAuth', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GroupAuth', 'url'=>array('admin')),
);
?>

<h1>Update GroupAuth <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>