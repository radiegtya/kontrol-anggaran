<?php if ($showContent): ?>
    <?php if ($errors): ?>
        <div class="panel panel-danger" style="color: black">
            <div class="panel-header">
                <h4><i class="fa fa-warning"></i> Error input data.</h4>
            </div>
            <div class="panel-body">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th class="text-center">Kode Akun</th>
                            <th class="text-center">Pagu</th>
                            <th class="text-center">Realisasi Kumulatif</th>
                            <th class="text-center">Sisa Pagu</th>
                            <th class="text-center">Pengajuan Realisasi Baru</th>
                            <th class="text-center">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($errors as $error): ?>
                            <tr class="table-striped">
                                <td class="text-left"><?php echo $error->packageAccount_code; ?></td>
                                <td class="text-right"><?php echo Yii::app()->format->number($limit[$error->packageAccount_code], 2); ?></td>
                                <td class="text-right"><?php echo Yii::app()->format->number($realization[$error->packageAccount_code], 2); ?></td>
                                <td class="text-right"><?php echo Yii::app()->format->number($rest[$error->packageAccount_code], 2); ?></td>
                                <td class="text-right" style="color:red"><?php echo Yii::app()->format->number($error->total_spm, 2); ?></td>
                                <td class="text-justify" style="color: red"><?php echo $error->description; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
    <div class="panel panel-default" style="color: black">
        <div class="panel-header">
            <a href="<?php echo yii::app()->baseUrl; ?>/realization/entry" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> Entry Data</a>
            <a href="<?php echo yii::app()->baseUrl; ?>/realization/export" class="btn btn-primary"><i class="fa fa-fw fa-download"></i> Download Form</a>
            <a href="<?php echo yii::app()->baseUrl; ?>/realization/import" class="btn btn-primary"><i class="fa fa-fw fa-upload"></i> Import Data</a>
            <a href="<?php echo yii::app()->baseUrl; ?>/realization/exportError" class="btn btn-danger"><i class="fa fa-fw fa-print"></i> Export Error</a>
            <a href="<?php echo yii::app()->baseUrl; ?>/realization/clearError" onclick="return confirm('Yakin ingin menghapus semua data error realisasi?')" class="btn btn-danger"><i class="fa fa-fw fa-trash"></i> Hapus Notifikasi Error</a>

        </div>
        <div class="panel-body">
            <?php
            $this->widget('bootstrap.widgets.TbGridView', array(
                'id' => 'realization-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'columns' => array(
                    array(
                        'header' => 'No',
                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    ),
//        'id',
                    array(
                        'name' => 'created_at',
                        'header' => 'Tanggal',
                        'value' => 'Yii::app()->dateFormatter->format("d MMM y", strtotime($data->created_at))',
                    ),
                    'packageAccount_code',
                    array(
                        "name" => "total_spm",
                        "value" => 'Yii::app()->format->number($data->total_spm)',
                        'htmlOptions' => array('style' => 'text-align: right;'),
                        'filter' => FALSE,
                    ),
                    array(
                        'class' => 'bootstrap.widgets.TbButtonColumn',
                        'template' => '{view}{delete}',
                    ),
                ),
            ));
            ?>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info">
        <div class="pull-left">
            <span class="fa-stack fa-lg fa-2x">
                <i class="fa fa-database fa-stack-1x"></i>
                <i class="fa fa-ban fa-stack-2x text-danger"></i>
            </span>
        </div>
        <div class="pull-left">
            <h4>Data informasi paket pekerjaan belum diinput dengan lengkap.</h4>
            <p>Silahkan lengkapi data informasi paket pekerjaan terlebih dahulu.</p>
        </div>
        <div class="clearfix"></div>
    </div>
<?php endif; ?>