<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'up-detail-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>

<?php // echo $form->errorSummary($model); ?>

<div>
    <div ><?php echo $form->dropDownListRow($model, "package_code", Package::model()->getPackageOptions(), array("prompt" => "Pilih Paket", "labelOptions" => array('label' => false), "style" => "display: block; width: 100%")); ?></div>
    <div><?php echo $form->textFieldRow($model, 'limit', array('class' => 'span12', "placeholder" => "Pagu UP", "labelOptions" => array('label' => false))); ?></div>
    <div>
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => $model->isNewRecord ? 'Tambah' : 'Simpan',
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
