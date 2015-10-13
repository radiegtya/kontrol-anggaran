<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'package-form',
    'enableAjaxValidation' => false,
        ));
?>

<?php echo $form->errorSummary($models); ?>
<?php foreach ($models as $i => $model) : ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'code'); ?>
        <?php echo $form->dropDownList($model, "[$i]code", Subcomponent::model()->getSubcomponentOptions(), array("prompt" => "Pilih Paket")); ?>
        <?php echo $form->error($model, 'code'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'ppk_code'); ?>
        <?php echo $form->dropDownList($model, "[$i]ppk_code", Ppk::model()->getPpkOptions(), array("prompt" => "Pilih PPK")); ?>
        <?php echo $form->error($model, 'ppk_code'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'province_code'); ?>
        <?php echo $form->dropDownList($model, "[$i]province_code", Province::model()->getOptionsCodeName(), array("prompt" => "Pilih Provinsi", 'id' => 'province')); ?>
        <?php echo $form->error($model, 'province_code'); ?>
    </div> 
    <div class="row">
        <?php echo $form->labelEx($model, 'city_code'); ?>
        <?php echo $form->dropDownList($model, "[$i]city_code", City::model()->getOptionsCodeName(), array("prompt" => "Pilih Kota", 'id' => 'city')); ?>
        <?php echo $form->error($model, 'city_code'); ?>
    </div> 
    <hr>
<?php endforeach; ?>

<div class="row buttons">
    <?php echo CHtml::submitButton('Simpan'); ?>
</div>

<?php $this->endWidget(); ?>