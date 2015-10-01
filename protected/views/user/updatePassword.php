<div class="panel panel-default">
    <div class="panel-header">
        <a href="<?php echo Yii::app()->baseUrl . '/user/admin'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Daftar</a>
        <a href="<?php echo Yii::app()->baseUrl . '/user/profile/' . $model->id; ?>" class="btn btn-primary"><i class="fa fa-fw fa-user"></i>Profile</a>
    </div>
    <div class="panel-body">
        <div class="form">

            <?php
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id' => 'nrs-form',
                'enableAjaxValidation' => true,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
            ));
            ?>


            <?php echo $form->errorSummary($model); ?>

            <?php echo $form->labelEx($model, 'current_password'); ?>
            <?php echo $form->passwordField($model, 'current_password', array('size' => 60, 'maxlength' => 256)); ?>

            <?php echo $form->labelEx($model, 'new_password'); ?>
            <?php echo $form->passwordField($model, 'new_password', array('size' => 60, 'maxlength' => 256)); ?>

            <?php echo $form->labelEx($model, 'confirm_new_password'); ?>
            <?php echo $form->passwordField($model, 'confirm_new_password', array('size' => 60, 'maxlength' => 256)); ?>

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
    </div>
</div>