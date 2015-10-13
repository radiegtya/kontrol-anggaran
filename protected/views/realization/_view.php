<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('packageAccount_code')); ?>:</b>
	<?php echo CHtml::encode($data->packageAccount_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('package_code')); ?>:</b>
	<?php echo CHtml::encode($data->package_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('up_ls')); ?>:</b>
	<?php echo CHtml::encode($data->up_ls); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('spm_number')); ?>:</b>
	<?php echo CHtml::encode($data->spm_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('spm_date')); ?>:</b>
	<?php echo CHtml::encode($data->spm_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_spm')); ?>:</b>
	<?php echo CHtml::encode($data->total_spm); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ppn')); ?>:</b>
	<?php echo CHtml::encode($data->ppn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pph')); ?>:</b>
	<?php echo CHtml::encode($data->pph); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receiver')); ?>:</b>
	<?php echo CHtml::encode($data->receiver); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nrk')); ?>:</b>
	<?php echo CHtml::encode($data->nrk); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nrs')); ?>:</b>
	<?php echo CHtml::encode($data->nrs); ?>
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