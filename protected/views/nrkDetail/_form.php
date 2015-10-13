<?php
$this->widget('ext.dropDownChain.VDropDownChain', array(
    'parentId' => 'nrk',
    'childId' => 'contract',
    'url' => 'nrkDetail/getContractOptions',
    'valueField' => 'contract_number', //child value field
    'textField' => 'contract_number', //child text field
));
?>
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'nrk-detail-form',
//    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>

<tbody>
    <tr>
        <td colspan="3">
            <?php echo $form->errorSummary($model); ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form->dropDownListRow($model, "termin", VEnum::getEnumOptions($model, "termin"), array("prompt" => "Termin Ke", 'labelOptions' => array('label' => false, "class" => "form-control"))); ?></td>
        <td><?php echo $form->textFieldRow($model, 'limit_per_termin', array('class' => 'form-control', 'placeholder' => 'pagu', 'labelOptions' => array('label' => false))); ?></td>
        <td>
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => $model->isNewRecord ? 'simpan' : 'Simpan',
            ));
            ?>
        </td>
    </tr>
</tbody>


<?php // echo $form->dropDownListRow($model, "nrk_register", Nrk::model()->getNrkOptions(), array("prompt" => "Pilih NRK", "id" => "nrk")); ?>

<?php // echo $form->dropDownListRow($model, "nrk_contract_number", Nrk::model()->getNrkNumberOptions(), array("prompt" => "Pilih Nomor Kontrak", "id" => "contract")); ?>


<?php $this->endWidget(); ?>
