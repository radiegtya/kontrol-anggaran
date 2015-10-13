<div class="row-fluid">
    <div class="span5">
        <?php
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'realization-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
        ?>


        <?php echo $form->errorSummary($model); ?>


        <?php echo $form->dropDownListRow($model, "packageAccount_code", PackageAccount::model()->getPackageAccount(), array("prompt" => "Pilih Akun Paket", 'id' => 'package', 'class' => 'span12')); ?>

        <?php echo $form->dropDownListRow($model, "up_ls", VEnum::getEnumOptions($model, "up_ls"), array("prompt" => "Please Select", "class" => "span12")); ?>

        <?php echo $form->textFieldRow($model, 'spm_number', array('class' => 'span12', 'maxlength' => 256)); ?>

        <?php echo $form->datepickerRow($model, "spm_date", array("prepend" => "<i class='icon-calendar'></i>", "options" => array('class' => 'span12', "format" => "yyyy-mm-dd"))); ?>

        <?php echo $form->textFieldRow($model, 'total_spm', array('class' => 'span12')); ?>

        <?php echo $form->textFieldRow($model, 'ppn', array('class' => 'span12')); ?>

        <?php echo $form->textFieldRow($model, 'pph', array('class' => 'span12')); ?>

        <?php echo $form->dropDownListRow($model, "receiver", VEnum::getEnumOptions($model, "receiver"), array("prompt" => "Please Select", "class" => "span12")); ?>

        <?php echo $form->textFieldRow($model, 'nrk', array('class' => 'span12', 'maxlength' => 256)); ?>


        <?php echo $form->textFieldRow($model, 'nrs', array('class' => 'span12', 'maxlength' => 256)); ?>

        <div class="form-actions">
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => $model->isNewRecord ? 'Create' : 'Save',
            ));
            ?>
        </div>
        <?php $this->endWidget(); ?>

    </div>
    <div class="span1">&nbsp;</div>
    <div class="span6">
        <table>
            <tr>
                <th>
            <h4>Petunjuk pengisian</h4>
            </th>
            </tr>
            <tr>
                <td>
                    <ol>
                        <li>step</li>
                        <li>step</li>
                        <li>step</li>
                    </ol>
                </td>
            </tr>
        </table>
    </div>
</div>
