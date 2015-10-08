<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dipa_id')); ?>:</b>
	<?php echo CHtml::encode($data->dipa_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('budget_year')); ?>:</b>
	<?php echo CHtml::encode($data->budget_year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('satker_code')); ?>:</b>
	<?php echo CHtml::encode($data->satker_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('department_code')); ?>:</b>
	<?php echo CHtml::encode($data->department_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_code')); ?>:</b>
	<?php echo CHtml::encode($data->unit_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('program_code')); ?>:</b>
	<?php echo CHtml::encode($data->program_code); ?>
	<br />

	<?php /*
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('subcomponent_code')); ?>:</b>
	<?php echo CHtml::encode($data->subcomponent_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_code')); ?>:</b>
	<?php echo CHtml::encode($data->account_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_budget_limit')); ?>:</b>
	<?php echo CHtml::encode($data->total_budget_limit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->createdBy->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_by')); ?>:</b>
	<?php echo CHtml::encode($data->updatedBy->name); ?>
	<br />

	*/ ?>

</div>