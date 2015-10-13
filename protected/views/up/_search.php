<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

        <?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'number_of_letter',array('class'=>'span5','maxlength'=>256)); ?>

        <?php echo $form->datepickerRow($model, "date_of_letter", array("prepend" => "<i class='icon-calendar'></i>", "options" => array("format" => "yyyy-mm-dd"))); ?>

        <?php echo $form->textFieldRow($model,'total_up',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'package_data',array('class'=>'span5','maxlength'=>256)); ?>

        <?php echo $form->textFieldRow($model,'package_limit',array('class'=>'span5','maxlength'=>256)); ?>

        <?php echo $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

        <?php echo $form->textFieldRow($model,'created_at',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'created_by',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'updated_at',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'updated_by',array('class'=>'span5')); ?>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
</div>

<?php $this->endWidget(); ?>
