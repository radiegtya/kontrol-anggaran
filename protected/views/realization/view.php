<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <a href="<?php echo Yii::app()->baseUrl . '/realization/index'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Kembali ke Daftar Realisasi</a>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                'packageAccount_code',
                'package_code',
                array(
                    'name' => 'up_ls',
                    'value' => $model->up_ls,
                ),
                'spm_number',
                'spm_date',
                'total_spm',
                'ppn',
                'pph',
                array(
                    'name' => 'receiver',
                    'value' => $model->receiver,
                ),
                'nrk',
                'nrs',
                array(
                    'name' => 'created_at',
                    'value' => ($model->created_at == '0000-00-00') ? '-' : date("j F Y", strtotime($model->created_at)),
                ),
                array(
                    'name' => 'created_by',
                    'value' => $model->createdBy->username,
                    'source' => User::model()->getOptions(),
                ),
            ),
        ));
        ?>
    </div>
</div>

