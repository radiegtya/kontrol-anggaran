<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'package-account-form',
	'enableAjaxValidation'=>true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	
        <?php echo $form->textFieldRow($model,'code',array('class'=>'span5','maxlength'=>256)); ?>

	
        <?php echo $form->textFieldRow($model,'satker_code',array('class'=>'span5','maxlength'=>256)); ?>

	
        <?php echo $form->textFieldRow($model,'activity_code',array('class'=>'span5','maxlength'=>256)); ?>

	
        <?php echo $form->textFieldRow($model,'output_code',array('class'=>'span5','maxlength'=>256)); ?>

	
        <?php echo $form->textFieldRow($model,'suboutput_code',array('class'=>'span5','maxlength'=>256)); ?>

	
        <?php echo $form->textFieldRow($model,'component_code',array('class'=>'span5','maxlength'=>256)); ?>

	
        <?php echo $form->textFieldRow($model,'package_code',array('class'=>'span5','maxlength'=>256)); ?>

	
        <?php echo $form->textFieldRow($model,'account_code',array('class'=>'span5','maxlength'=>256)); ?>

	
        <?php echo $form->textFieldRow($model,'budget_code',array('class'=>'span5','maxlength'=>256)); ?>

	
        <?php echo $form->textFieldRow($model,'province_code',array('class'=>'span5')); ?>

	
        <?php echo $form->textFieldRow($model,'city_code',array('class'=>'span5')); ?>

	
        <?php echo $form->textFieldRow($model,'ppk_code',array('class'=>'span5','maxlength'=>256)); ?>

	
        <?php echo $form->textFieldRow($model,'limit',array('class'=>'span5')); ?>

	
        <?php echo $form->dropDownListRow($model, "up", VEnum::getEnumOptions($model, "up"), array("prompt"=>"Please Select", "class"=>"autocomplete")); ?>

	
        <?php echo $form->textFieldRow($model,'created_at',array('class'=>'span5')); ?>

	
        <?php echo $form->dropDownListRow($model, "created_by", CreatedBy::model()->getOptions(), array("prompt"=>"Please Select", "class"=>"autocomplete")); ?>

	
        <?php echo $form->textFieldRow($model,'updated_at',array('class'=>'span5')); ?>

	
        <?php echo $form->dropDownListRow($model, "updated_by", UpdatedBy::model()->getOptions(), array("prompt"=>"Please Select", "class"=>"autocomplete")); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
