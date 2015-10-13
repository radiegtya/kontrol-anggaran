<?php
$this->breadcrumbs = array(
    'Ups' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Up', 'url' => array('index')),
    array('label' => 'Create Up', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('up-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-default">
    <div class="panel-header">
<a href="<?php echo yii::app()->baseUrl; ?>/up/create" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> Tambah</a>
    </div>
    <div class="panel-body">




    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id' => 'up-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => array(
            array(
                'header' => 'No',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            ),
            //'id',
            array(
                'name' => 'number_of_letter',
                'type' => 'raw',
                'value' => 'CHtml::link($data->number_of_letter,array("up/view","id"=>$data->id))',
            ),
            array(
                'name' => 'date_of_letter',
                'value' => 'Yii::app()->dateFormatter->format("dd MMM yyyy", $data->date_of_letter)',
            ),
            array(
                'name' => 'total_up',
                'value' => 'Yii::app()->format->number($data->total_up)',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'filter' => FALSE,
            ),
            array(
                "name" => "realization",
                "value" => 'Yii::app()->format->number($data->getTotal($data->number_of_letter)["realization"])',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'filter' => FALSE,
            ),
            array(
                "name" => "restUp",
                "value" => 'Yii::app()->format->number($data->getTotal($data->number_of_letter)["restUp"])',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'filter' => FALSE,
            ),
            array('name' => 'rateUsingUp',
                'type' => 'raw',
                'filter' => FALSE,
                'headerHtmlOptions' => array('style' => 'text-align: center;'),
                'value' => function($data) {
            $rate = $data->getTotal($data->number_of_letter)['rateUsingUp'];
            return "<div class='slider' data-progress='$rate'><span></span><label></label></div>";
        }
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    ));
    ?>
    </div>
</div>