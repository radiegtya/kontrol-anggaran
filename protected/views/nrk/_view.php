<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nrk')); ?>:</b>
	<?php echo CHtml::encode($data->nrk); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contract_number')); ?>:</b>
	<?php echo CHtml::encode($data->contract_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contract_date')); ?>:</b>
	<?php echo CHtml::encode($data->contract_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('limit')); ?>:</b>
	<?php echo CHtml::encode($data->limit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('term_of_limit')); ?>:</b>
	<?php echo CHtml::encode($data->term_of_limit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<?php /*
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