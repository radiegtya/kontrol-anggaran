<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

        <?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'nrk_contract_number',array('class'=>'span5','maxlength'=>256)); ?>

        <?php echo $form->dropDownListRow($model, "termin", VEnum::getEnumOptions($model, "termin"), array("prompt"=>"Please Select", "class"=>"autocomplete")); ?>

        <?php echo $form->textFieldRow($model,'limit_per_termin',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'created_at',array('class'=>'span5')); ?>

        <?php echo $form->dropDownListRow($model, "created_by", CreatedBy::model()->getOptions(), array("prompt"=>"Please Select", "class"=>"autocomplete")); ?>

        <?php echo $form->textFieldRow($model,'updated_at',array('class'=>'span5')); ?>

        <?php echo $form->dropDownListRow($model, "updated_by", UpdatedBy::model()->getOptions(), array("prompt"=>"Please Select", "class"=>"autocomplete")); ?>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
</div>

<?php $this->endWidget(); ?>
