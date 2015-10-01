<?php
$this->breadcrumbs = array(
    'Up Details' => array('index'),
    $model->id => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => 'List UpDetail', 'url' => array('index')),
    array('label' => 'Create UpDetail', 'url' => array('create')),
    array('label' => 'View UpDetail', 'url' => array('view', 'id' => $model->id)),
    array('label' => 'Manage UpDetail', 'url' => array('admin')),
);
?>

<h4>Update</h4>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>