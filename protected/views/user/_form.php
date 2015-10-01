<div class="form">

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'nrs-form',
        'enableAjaxValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->labelEx($model, 'username'); ?>
    <?php echo $form->textField($model, 'username', array('class' => 'span3', 'maxlength' => 128)); ?>

    <?php echo $form->labelEx($model, 'password'); ?>
    <?php echo $form->passwordField($model, 'password', array('class' => 'span3', 'size' => 60, 'maxlength' => 256)); ?>

    <?php echo $form->labelEx($model, 'group_id'); ?>
    <?php echo $form->dropDownList($model, 'group_id', Group::model()->getAuthOptions(Yii::app()->user->id), array('class' => 'span3', 'prompt' => 'Pilih')); ?>
    </br>
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Tambah' : 'Simpan',
    ));
    ?>

    <?php $this->endWidget(); ?>

</div><!-- form -->