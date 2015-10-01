<?php
$this->widget('ext.dropDownChain.VDropDownChain', array(
    'parentId' => 'province',
    'childId' => 'city',
    'url' => 'package/getCity',
    'valueField' => 'code', //child value field
    'textField' => 'name', //child text field
));
?>
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'package-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>


<?php echo $form->errorSummary($model); ?>
<?php if ($model->isNewRecord): ?>
    <?php echo $form->dropDownList($model, 'code', Subcomponent::model()->getSubcomponentOptions(), array("prompt" => "Pilih Paket")); ?>
<?php endif; ?>
<?php echo $form->dropDownList($model, 'province_code', Province::model()->getOptionsCodeName(), array("prompt" => "Pilih Provinsi", 'id' => 'province')); ?>

<?php echo $form->dropDownList($model, 'city_code', City::model()->getOptionsCodeName(), array("prompt" => "Pilih Kota", 'id' => 'city')); ?>

<?php echo $form->dropDownList($model, 'ppk_code', Ppk::model()->getPpkOptions(), array("prompt" => "Pilih PPK")); ?>


<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Tambah' : 'Simpan',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>