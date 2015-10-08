<div class="row-fluid">
    <div class="span6">
        <?php
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'dipa-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
        ?>

        <?php echo $form->errorSummary($model); ?>
        <div class="form-group">
            <?php echo $form->textFieldRow($model, 'budget_year', array('class' => 'span12', 'maxlength' => 4)); ?>
        </div>
        <div class="form-group">
            <?php echo $form->textFieldRow($model, 'dipa_number', array('class' => 'span12', 'maxlength' => 256)); ?>
        </div>
        <div class="form-group">
            <?php echo $form->datepickerRow($model, "dipa_date", array("prepend" => "<i class='icon-calendar'></i>", "options" => array("format" => "yyyy-mm-dd"), 'class' => 'span12')); ?>
        </div>
        <div class="form-group">
            <?php echo $form->dropDownListRow($model, "type", VEnum::getEnumOptions($model, "type"), array("prompt" => "Please Select", 'class' => 'span12')); ?>
        </div>
        <div class="form-group">
            <?php echo $form->label($model, 'file', array('maxlength' => 256)); ?>
            <?php echo $form->fileFieldRow($model, 'file', array('maxlength' => 256, 'labelOptions' => array('label' => false))); ?>
            <p>File excel yang digunakan adalah file <span class="label label-primary">d_item.xls</span> yang sudah dinormalisasi terlebih dahulu</p>
        </div>


        <!--<div class="form-actions">-->
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => $model->isNewRecord ? 'Simpan' : 'Simpan',
        ));
        ?>
        <!--</div>-->

        <?php $this->endWidget(); ?>
    </div>
    <div class="span6">
        <div class="alert alert-info">
            <h5><i class="fa fa-fw fa-info-circle"></i> Petunjuk</h5>
            <p>DIPA/POK yang digunakan sebagai data dalam paket adalah DIPA/POK terbaru.</p>
            <p>File excel yang digunakan adalah file <span class="label label-primary">d_item.xls</span> yang sudah dinormalisasi terlebih dahulu</p>
            <p>Petunjuk normalisasi dapat dilihat <a href="#">disini</a></p>
        </div>
    </div>
</div>