<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'up-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>


<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
    <div class="span6">
        <?php echo $form->textFieldRow($model, 'number_of_letter', array('class' => 'span12', 'maxlength' => 256)); ?>


        <?php echo $form->datepickerRow($model, "date_of_letter", array("prepend" => "<i class='icon-calendar'></i>", "options" => array("format" => "yyyy-mm-dd"), 'class' => 'span12')); ?>

        <?php if ($detail == FALSE): ?>
            <?php echo $form->textFieldRow($model, 'total_up', array('class' => 'span12')); ?>
        <?php endif; ?>

        <?php // echo $form->dropDownListRow($model, "package_code", Package::model()->getPackageOptions(), array("prompt" => "Pilih Paket")); ?>


        <?php // echo $form->textFieldRow($model, 'up_limit', array('class' => 'span5', 'maxlength' => 256)); ?>


        <?php // echo $form->textAreaRow($model, 'description', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>

        <?php /*
          <?php echo $form->textFieldRow($model,'created_at',array('class'=>'span5')); ?>


          <?php echo $form->textFieldRow($model,'created_by',array('class'=>'span5')); ?>


          <?php echo $form->textFieldRow($model,'updated_at',array('class'=>'span5')); ?>


          <?php echo $form->textFieldRow($model,'updated_by',array('class'=>'span5')); ?>
         */; ?>

        <!--<div class="form-actions">-->
        </br>
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => $model->isNewRecord ? 'Tambah' : 'Simpan',
        ));
        ?>
    </div>
    <div class="span6">

    </div>
</div>

    <!--<a href="<?php // echo yii::app()->baseUrl;      ?>/up/admin" class="btn btn-primary">Batal</a>-->

<!--</div>-->

<?php $this->endWidget(); ?>
