<?php
$this->breadcrumbs=array(
	'Payment Methods',
);

$this->menu=array(
	array('label'=>'Create PaymentMethod','url'=>array('create')),
	array('label'=>'Manage PaymentMethod','url'=>array('admin')),
);
?>





<div class="panel panel-default">
    <div class="panel-header">
        <h4>Payment Methods</h4>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
    </div>
</div>