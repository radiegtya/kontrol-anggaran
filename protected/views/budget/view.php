<?php
$this->breadcrumbs = array(
    'Budgets' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List Budget', 'url' => array('index')),
    array('label' => 'Create Budget', 'url' => array('create')),
    array('label' => 'Update Budget', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Budget', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Budget', 'url' => array('admin')),
);
?>

<h2>View Budget #<?php echo $model->id; ?></h2>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'dipa_id',
        'budget_year',
        'satker_code',
        'department_code',
        'unit_code',
        'program_code',
        'activity_code',
        'output_code',
        'suboutput_code',
        'component_code',
        'subcomponent_code',
        'account_code',
        'total_budget_limit',
        array(
            'name' => 'created_at',
            'value' => Yii::app()->dateFormatter->format('dd MMM yyyy', $model->created_at),
        ),
        array(
            'name' => 'created_by',
            'value' => $model->createdBy->username,
            'source' => User::model()->getOptions(),
        ),
//		'updated_at',
//		array(
//			'name'=>'updated_by',
//			'value'=>$model->updatedBy->name,
//			'editable'=>array(
//				'type'=>'select',
//				'source'=>UpdatedBy::model()->getOptions(),
//			),
//		),
    ),
));
?>
