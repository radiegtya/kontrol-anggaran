<div class="panel panel-default">
    <div class="panel-header">
        <a href="<?php echo Yii::app()->baseUrl . '/user/admin'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Daftar</a>
    </div>
    <div class="toolbar">
        <b>USERNAME:</b> <?php echo $model->username; ?>
    </div>
    <div class="panel-body">

        <div class="form">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'user-form',
                'enableAjaxValidation' => false,
            ));
            ?>
            <?php echo $form->errorSummary($model); ?>

            <?php echo $form->labelEx($model, 'group_id'); ?>
            <?php echo $form->dropDownList($model, 'group_id', Group::model()->getOptions(), array('prompt' => 'Please Select')); ?>
            <?php echo $form->error($model, 'group_id'); ?>
            <div>
                <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Submit')); ?>
            </div>

            <?php $this->endWidget(); ?>
        </div>

    </div>
</div>