<div class="panel panel-default">
    <div class="panel-header">
        <a href="<?php echo Yii::app()->baseUrl . '/nrk/admin'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Daftar</a>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'nrk-detail-form',
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
        ?>

        <?php echo $form->errorSummary($model); ?>


        <?php echo $form->dropDownListRow($model, "termin", VEnum::getEnumOptions($model, "termin"), array("prompt" => "Termin Ke", "class" => "autocomplete")); ?>


        <?php echo $form->textFieldRow($model, 'limit_per_termin', array('class' => 'span5')); ?>
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
    </div>
</div>