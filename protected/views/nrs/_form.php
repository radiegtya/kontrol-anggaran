<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'nrs-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>


<?php echo $form->errorSummary($model); ?>


<?php echo $form->textFieldRow($model, 'nrs', array('class' => 'span5', 'maxlength' => 256)); ?>


<?php echo $form->textFieldRow($model, 'supplier_name', array('class' => 'span5', 'maxlength' => 256)); ?>


<?php echo $form->textFieldRow($model, 'npwp', array('class' => 'span5', 'maxlength' => 256)); ?>


<?php echo $form->textFieldRow($model, 'bank_name', array('class' => 'span5', 'maxlength' => 256)); ?>


<?php echo $form->textFieldRow($model, 'bank_account_number', array('class' => 'span5', 'maxlength' => 256)); ?>

<?php /*
  <?php echo $form->textFieldRow($model,'created_at',array('class'=>'span5')); ?>


  <?php echo $form->textFieldRow($model,'created_by',array('class'=>'span5')); ?>


  <?php echo $form->textFieldRow($model,'updated_at',array('class'=>'span5')); ?>


  <?php echo $form->textFieldRow($model,'updated_by',array('class'=>'span5')); ?>
 */; ?>
</br>
<!--<div class="form-actions">-->
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'label' => $model->isNewRecord ? 'Tambah' : 'Simpan',
));
?>
    <!--<a href="<?php // echo yii::app()->baseUrl;  ?>/nrs/admin" class="btn btn-primary">Batal</a>-->

<!--</div>-->

<?php $this->endWidget(); ?>
