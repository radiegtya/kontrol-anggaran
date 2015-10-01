<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'nrk-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>


<?php echo $form->errorSummary($model); ?>


<?php echo $form->textFieldRow($model, 'nrk', array('class' => 'span5', 'maxlength' => 256)); ?>


<?php echo $form->textFieldRow($model, 'contract_number', array('class' => 'span5', 'maxlength' => 256)); ?>


<?php echo $form->datepickerRow($model, "contract_date", array("prepend" => "<i class='icon-calendar'></i>", "options" => array("format" => "yyyy-mm-dd"))); ?>


<?php echo $form->textFieldRow($model, 'limit', array('class' => 'span5')); ?>


<?php // echo $form->textFieldRow($model, 'term_of_limit', array('class' => 'span5')); ?>

<?php /*
  <?php echo $form->textFieldRow($model,'created_at',array('class'=>'span5')); ?>


  <?php echo $form->textFieldRow($model,'created_by',array('class'=>'span5')); ?>


  <?php echo $form->textFieldRow($model,'updated_at',array('class'=>'span5')); ?>


  <?php echo $form->textFieldRow($model,'updated_by',array('class'=>'span5')); ?>
 */; ?>
<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Tambah' : 'Simpan',
    ));
    ?>
    <!--<a href="<?php // echo yii::app()->baseUrl; ?>/nrk/admin" class="btn btn-primary">Batal</a>-->

</div>

<?php $this->endWidget(); ?>
