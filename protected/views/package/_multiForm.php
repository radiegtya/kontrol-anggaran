<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'package-form',
    'enableAjaxValidation' => false,
        ));
?>
<div class="table">

    <?php
    $this->widget('application.extensions.appendo.JAppendo', array(
        'id' => 'repeateEnum',
        'model' => $model,
        'viewName' => 'package',
        'labelDel' => 'Remove',
            // 'cssFile' => 'css/jquery.appendo2.css'
    ));
    ?>
</div>
<div class="buttons">
    <?php echo CHtml::submitButton('Simpan'); ?>
</div>
<?php $this->endWidget(); ?>