<div class="row-fluid">
    <div class="span5">
        <?php
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'dipa-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
        ?>
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->textFieldRow($model, 'dipa_number', array('class' => 'span12', 'maxlength' => 256)); ?>
        <?php echo $form->datepickerRow($model, "dipa_date", array('class' => 'span12', "prepend" => "<i class='icon-calendar'></i>", "options" => array("format" => "yyyy-mm-dd"))); ?>
        <?php echo $form->dropDownListRow($model, "type", VEnum::getEnumOptions($model, "type"), array('class' => 'span12', "prompt" => "Please Select")); ?>

        </br>
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => $model->isNewRecord ? 'Tambah' : 'Simpan',
        ));
        ?>
        <?php $this->endWidget(); ?>
    </div>
    <div class="span1">&nbsp;</div>
    <div class="span6">
        <div class="alert alert-info">
            <table>
                <tr><h4>Petunjuk Penginputan.</h4></tr>
                <tr>
                <ol>
                    <li>Data dengan tanda <span class="required">*</span> harus diisi.</li>
                    <li>Input data DIPA/POK.</li>
                    <li>Pastikan data sudah diinput dengan benar.</li>
                    <li>Klik simpan untuk menyimpan update data DIPA/POK.</li>
                    <li>Selesai.</li>
                </ol>
                </tr>
        </div>
        </table>
    </div>
</div>

