<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'satker-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>

<?php echo $form->errorSummary($model); ?>


<?php echo $form->textFieldRow($model, 'code', array('class' => 'span5', 'maxlength' => 256)); ?>


<?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 256)); ?>

<?php /*
  <?php echo $form->textFieldRow($model,'created_at',array('class'=>'span5')); ?>


  <?php echo $form->textFieldRow($model,'created_by',array('class'=>'span5')); ?>


  <?php echo $form->textFieldRow($model,'updated_at',array('class'=>'span5')); ?>


  <?php echo $form->textFieldRow($model,'updated_by',array('class'=>'span5')); ?>
 */ ?>
<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Tambah' : 'Simpan',
    ));
    ?>
    <!--<a href="<?php // echo yii::app()->baseUrl; ?>/satker/admin" class="btn btn-primary">Batal</a>-->
</div>

<?php $this->endWidget(); ?>
