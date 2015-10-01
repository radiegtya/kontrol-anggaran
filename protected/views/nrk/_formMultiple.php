<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'nrk-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
    <div class="span6">
        <?php echo $form->textFieldRow($model, 'nrk', array('class' => 'span12', 'maxlength' => 256)); ?>

        <?php echo $form->textFieldRow($model, "contract_number", array('class' => 'span12')); ?>

        <?php echo $form->datepickerRow($model, "contract_date", array("prepend" => "<i class='icon-calendar'></i>", "options" => array("format" => "yyyy-mm-dd"),'class' => 'span12')); ?>

        <?php echo $form->textFieldRow($model, "limit", array('class' => 'span12')); ?>
    </div>
    <div class="span6">
        <table class="table table-bordered multiple-input">
            <thead>
                <tr>
                    <th>Termin</th>
                    <th>Pagu Termin</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($models as $i => $model) : ?>    
                    <tr data-row="<?php echo $i; ?>">
                        <td><?php echo $form->dropDownListRow($model, "[$i]termin", VEnum::getEnumOptions($model, "[$i]termin"), array("prompt" => "Pilih Termin", 'labelOptions' => array('label' => false), "style"=>"width: 100%")); ?></td>  
                        <td><?php echo $form->textFieldRow($model, "[$i]limit_per_termin", array('class' => '', 'maxlength' => 256, 'labelOptions' => array('label' => false), "style"=>"width: 100%; box-sizing: border-box; height: 30px")); ?></td>  
                        <td>
                            <button class="btn btn-default add-row" type="button"><i class="icon icon-plus"></i></button>
                            <button class="btn btn-danger remove-row" type="button"><i class="icon icon-white icon-trash"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>






<div class="">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Simpan' : 'Simpan',
    ));
    ?>
    <a href="<?php echo yii::app()->baseUrl; ?>/up/admin" class="btn btn-primary">Batal</a>

</div>

<?php $this->endWidget(); ?>
<script>
    $(function() {
        $('.multiple-input tbody tr:first-child ~ tr').hide();
        $('.multiple-input tbody .add-row').click(function() {
            var tr = $(this).parent().parent().attr('data-row');
            tr = parseInt(tr);
            $('tr[data-row =' + tr + '] + tr').show();
            $('tr[data-row =' + tr + '] + tr .chzn-container').focus();

        });
        $('.multiple-input tbody tr:first-child .remove-row').remove();
        $('.remove-row').click(function() {
            $(this).parent().parent().remove();
        });
    });
</script>