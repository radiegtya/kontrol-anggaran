<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'component-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>


<?php echo $form->errorSummary($model); ?>


<?php echo $form->dropDownListRow($model, "output_code", Output::model()->getOutputOptions(), array("prompt" => "Please Select")); ?>


<?php echo $form->dropDownListRow($model, "suboutput_code", Suboutput::model()->getSuboutputOptions(), array("prompt" => "Please Select")); ?>


<?php echo $form->textFieldRow($model, 'code', array('class' => 'span5', 'maxlength' => 256)); ?>


<?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 256)); ?>

<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Insert' : 'Update',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
