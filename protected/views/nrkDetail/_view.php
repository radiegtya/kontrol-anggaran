<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nrk_contract_number')); ?>:</b>
	<?php echo CHtml::encode($data->nrk_contract_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('termin')); ?>:</b>
	<?php echo CHtml::encode($data->termin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('limit_per_termin')); ?>:</b>
	<?php echo CHtml::encode($data->limit_per_termin); ?>
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

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_by')); ?>:</b>
	<?php echo CHtml::encode($data->updatedBy->name); ?>
	<br />

	*/ ?>

</div>