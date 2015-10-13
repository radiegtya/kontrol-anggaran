<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
        ));
?>

<?php echo $form->textFieldRow($model, 'id', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'code', array('class' => 'span5', 'maxlength' => 256)); ?>

<?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 256)); ?>
<?php /*
  <?php echo $form->textFieldRow($model,'created_at',array('class'=>'span5')); ?>

  <?php echo $form->textFieldRow($model,'created_by',array('class'=>'span5')); ?>

  <?php echo $form->textFieldRow($model,'updated_at',array('class'=>'span5')); ?>

  <?php echo $form->textFieldRow($model,'updated_by',array('class'=>'span5')); ?>
 */
?>
<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Search',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
