<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'budget-form',
//    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>


<?php echo $form->errorSummary($model); ?>
<?php
echo 'Import Excel file';
echo '</br>';
?>
<?php echo $form->fileFieldRow($model, 'file', array('class' => 'span5', 'maxlength' => 256, 'labelOptions' => array('label' => false))); ?>

<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Import',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>

