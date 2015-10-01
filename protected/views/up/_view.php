<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number_of_letter')); ?>:</b>
	<?php echo CHtml::encode($data->number_of_letter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_of_letter')); ?>:</b>
	<?php echo CHtml::encode($data->date_of_letter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_up')); ?>:</b>
	<?php echo CHtml::encode($data->total_up); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('package_data')); ?>:</b>
	<?php echo CHtml::encode($data->package_data); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('package_limit')); ?>:</b>
	<?php echo CHtml::encode($data->package_limit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_by')); ?>:</b>
	<?php echo CHtml::encode($data->updated_by); ?>
	<br />

	*/ ?>

</div>