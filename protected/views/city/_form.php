<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'city-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>


<?php echo $form->errorSummary($model); ?>


<?php echo $form->dropDownListRow($model, "province_code", Province::model()->getOptionsCodeName(), array("prompt" => "Pilih Provinsi", "class" => "autocomplete")); ?>

<?php echo $form->textFieldRow($model, 'code', array('class' => 'span5', 'maxlength' => 256)); ?>
<?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 256)); ?>


<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Tambah' : 'Simpan',
    ));
    ?>
    <!--<a href="<?php // echo yii::app()->baseUrl; ?>/city/admin" class="btn btn-primary">Batal</a>-->

</div>

<?php $this->endWidget(); ?>
