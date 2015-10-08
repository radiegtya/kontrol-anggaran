<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'up-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>

<div class="row-fluid">
    <div class="span6">
        <?php echo $form->textFieldRow($model, 'number_of_letter', array('class' => 'span12', 'maxlength' => 256)); ?>

        <?php echo $form->datepickerRow($model, "date_of_letter", array("prepend" => "<i class='icon-calendar'></i>", "options" => array("format" => "yyyy-mm-dd",), 'class' => 'span12')); ?>

        <?php echo $form->textFieldRow($model, "total_up", array('class' => 'span12')); ?>
    </div>
    <div class="span6">
        <div class="alert alert-info">
            <h5><i class="fa fa-fw fa-info-circle"></i> Petunjuk</h5>
            <p>Bila UP baru dibuat, maka UP yang sebelumnya diasumsikan sudah tidak dipakai. Bila masih ada sisa, asumsinya adalah dikembalikan uang sisa tersebut.</p>
            <p>UP dapat dialokasikan ke dalam paket-paket. Hal ini dapat dilakukan secara bertahap.</p>
        </div>
    </div>
</div>
<?php echo $form->errorSummary($model); ?>



<!--<table class="table table-bordered multiple-input">
    <thead>
        <tr>
            <th>Paket</th>
            <th>Pagu</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php // foreach ($models as $i => $model) : ?>    
            <tr data-row="<?php // echo $i; ?>">
                <td><?php // echo $form->dropDownListRow($model, "[$i]package_name", Package::model()->getPackageOptions(), array("prompt" => "Pilih Paket", 'labelOptions' => array('label' => false))); ?></td>  
                <td><?php // echo $form->textFieldRow($model, "[$i]limit", array('class' => '', 'maxlength' => 256, 'labelOptions' => array('label' => false))); ?></td>  
                <td>
                    <button class="btn btn-default add-row" type="button"><i class="icon icon-plus"></i></button>
                    <button class="btn btn-danger remove-row" type="button"><i class="icon icon-white icon-trash"></i></button>
                </td>
            </tr>
        <?php // endforeach; ?>
    </tbody>
</table>-->

<!--<div class="form-actions">-->
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'label' => $model->isNewRecord ? 'Simpan' : 'Simpan',
));
?>
    <!--<a href="<?php // echo yii::app()->baseUrl;     ?>/up/admin" class="btn btn-primary">Batal</a>-->

<!--</div>-->

<?php $this->endWidget(); ?>
<!--<script>
    $(function () {
        $('.multiple-input tbody tr:first-child ~ tr').hide();
        $('.multiple-input tbody .add-row').click(function () {
            var tr = $(this).parent().parent().attr('data-row');
            tr = parseInt(tr);
            $('tr[data-row =' + tr + '] + tr').show();
            $('tr[data-row =' + tr + '] + tr .chzn-container').focus();

        });
        $('.multiple-input tbody tr:first-child .remove-row').remove();
        $('.remove-row').click(function () {
            $(this).parent().parent().remove();
        });
    });
</script>-->