<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <a href="<?php echo Yii::app()->baseUrl . '/component/index'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Kembali ke Daftar Komponen</a>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'component-form',
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
        ?>


        <?php echo $form->errorSummary($model); ?>
        <?php
        echo 'Import Excel file';
        echo '</br>';
        ?>
        <?php echo $form->fileFieldRow($model, 'file', array('class' => 'span5', 'maxlength' => 256, 'labelOptions' => array('label' => false))); ?>
        <p>File excel yang digunakan adalah file d_kmpnen yang sudah difilter jumlah barisnya</p>

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
    </div>
</div>

