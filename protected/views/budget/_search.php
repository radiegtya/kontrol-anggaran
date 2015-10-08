<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

        <?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'dipa_id',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'budget_year',array('class'=>'span5','maxlength'=>4)); ?>

        <?php echo $form->textFieldRow($model,'satker_code',array('class'=>'span5','maxlength'=>256)); ?>

        <?php echo $form->textFieldRow($model,'department_code',array('class'=>'span5','maxlength'=>256)); ?>

        <?php echo $form->textFieldRow($model,'unit_code',array('class'=>'span5','maxlength'=>256)); ?>

        <?php echo $form->textFieldRow($model,'program_code',array('class'=>'span5','maxlength'=>256)); ?>

        <?php echo $form->textFieldRow($model,'activity_code',array('class'=>'span5','maxlength'=>256)); ?>

        <?php echo $form->textFieldRow($model,'output_code',array('class'=>'span5','maxlength'=>256)); ?>

        <?php echo $form->textFieldRow($model,'suboutput_code',array('class'=>'span5','maxlength'=>256)); ?>

        <?php echo $form->textFieldRow($model,'component_code',array('class'=>'span5','maxlength'=>256)); ?>

        <?php echo $form->textFieldRow($model,'subcomponent_code',array('class'=>'span5','maxlength'=>256)); ?>

        <?php echo $form->textFieldRow($model,'account_code',array('class'=>'span5','maxlength'=>256)); ?>

        <?php echo $form->textFieldRow($model,'total_budget_limit',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'created_at',array('class'=>'span5')); ?>

        <?php echo $form->dropDownListRow($model, "created_by", User::model()->getOptions(), array("prompt"=>"Please Select", "class"=>"autocomplete")); ?>

        <?php echo $form->textFieldRow($model,'updated_at',array('class'=>'span5')); ?>

        <?php echo $form->dropDownListRow($model, "updated_by", User::model()->getOptions(), array("prompt"=>"Please Select", "class"=>"autocomplete")); ?>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
</div>

<?php $this->endWidget(); ?>
