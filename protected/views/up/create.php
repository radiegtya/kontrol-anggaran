<?php
$this->breadcrumbs = array(
    'Ups' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List Up', 'url' => array('index')),
    array('label' => 'Manage Up', 'url' => array('admin')),
);
?>
<div class="panel panel-default">
    <div class="panel-header">
Tambah UP/TUP
    </div>
    <div class="panel-body">
<?php echo $this->renderPartial('_formMultiple', array('model' => $model)); ?>
<?php // echo $this->renderPartial('_formMultiple', array('model' => $model, 'models' => $models)); ?>
    </div>
</div>