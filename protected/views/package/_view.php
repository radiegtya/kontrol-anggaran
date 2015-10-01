<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo CHtml::encode($data->code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('satker_code')); ?>:</b>
	<?php echo CHtml::encode($data->satker_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activity_code')); ?>:</b>
	<?php echo CHtml::encode($data->activity_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('output_code')); ?>:</b>
	<?php echo CHtml::encode($data->output_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('suboutput_code')); ?>:</b>
	<?php echo CHtml::encode($data->suboutput_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('component_code')); ?>:</b>
	<?php echo CHtml::encode($data->component_code); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('subcomponent_name')); ?>:</b>
	<?php echo CHtml::encode($data->subcomponent_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('province_code')); ?>:</b>
	<?php echo CHtml::encode($data->province_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city_code')); ?>:</b>
	<?php echo CHtml::encode($data->city_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ppk_code')); ?>:</b>
	<?php echo CHtml::encode($data->ppk_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('limit')); ?>:</b>
	<?php echo CHtml::encode($data->limit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('up')); ?>:</b>
	<?php echo CHtml::encode($data->up); ?>
	<br />

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