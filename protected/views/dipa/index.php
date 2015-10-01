<?php if ($errors): ?>
    <div class="panel panel-danger" >
        <div class="panel-header" style="color: black">
            <a href="<?php echo yii::app()->baseUrl; ?>/dipa/printError" class="btn btn-primary"><i class="fa fa-fw fa-print"></i> Print Error</a>
        </div>
        <div class="panel-body" style="color: red">
            <h4 style="color: black">Error List</h4>
            <table class="table table-condensed">
                <tr>
                    <td>Kode Akun Paket</td>
                    <td>Tahun Anggaran</td>
                    <td>Kode Satker</td>
                    <td>Kode Kegiatan</td>
                    <td>Kode Output</td>
                    <td>Kode Suboutput</td>
                    <td>Kode Komponen</td>
                    <td>Kode Subkomponen</td>
                    <td>Kode Akun</td>
                    <td>Pagu</td>
                    <td>Keterangan Error</td>
                </tr>
                <?php foreach ($errors as $error): ?>
                    <tr>
                        <td class="text-left"><?php echo $error->code; ?></td>
                        <td class="text-center"><?php echo $error->budget_year; ?></td>
                        <td class="text-center"><?php echo $error->satker_code; ?></td>
                        <td class="text-center"><?php echo $error->activity_code; ?></td>
                        <td class="text-center"><?php echo $error->output_code; ?></td>
                        <td class="text-center"><?php echo $error->suboutput_code; ?></td>
                        <td class="text-center"><?php echo $error->component_code; ?></td>
                        <td class="text-center"><?php echo $error->subcomponent_code; ?></td>
                        <td class="text-center"><?php echo $error->account_code; ?></td>
                        <td class="text-right"><?php echo Yii::app()->format->number($error->total_budget_limit, 2); ?></td>
                        <td class="text-justify"><?php echo $error->description; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
<?php endif; ?>
<?php if ($errorCompleteness): ?>
    <div class="panel panel-default">
        <div class="panel-header">
            <p>Error kelengkapan</p></br>
        </div>
        <div class="panel-body">
            <h4 style="color: black">Total error <?php echo count($errorCompleteness);?> data</h4>
            <table>
                <tr>
                    <td>Kode Akun Paket</td>
                    <td>Keterangan Error</td>
                </tr>
                <?php foreach ($errorCompleteness as $error): ?>
                    <tr>
                        <td><?php echo $error->code; ?></td>
                        <td><?php echo $error->description; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
<?php endif; ?>
<?php if ($showContent): ?>
    <div class="panel panel-default" style="color: black">
        <div class="panel-header">
            <?php
            /*
              $this->breadcrumbs = array(
              'Dipas' => array('index'),
              'Manage',
              );
             * 
             */
            ?>
            <!--<a href="<?php // echo yii::app()->baseUrl;                    ?>/dipa/create" class="btn btn-primary"><i class="fa fa-fw fa-upload"></i> Import DIPA</a>-->
            <a href="<?php echo yii::app()->baseUrl; ?>/dipa/import" class="btn btn-primary"><i class="fa fa-fw fa-upload"></i> Import DIPA</a>
            <a href="<?php echo yii::app()->baseUrl; ?>/dipa/clear" onclick="return confirm('Semua data DIPA, Paket Pekerjaan, dan Realisasi akan dihapus. \n\nYakin ingin membersihkan data?')"class="btn btn-primary"><i class="fa fa-fw fa-trash"></i> Bersihkan Pencatatan Data</a>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <?php
                $this->widget('bootstrap.widgets.TbGridView', array(
                    'id' => 'dipa-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'columns' => array(
                        array(
                            'header' => 'No',
                            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        ),
                        //'id',
                        array(
                            'name' => 'dipa_number',
                            'type' => 'raw',
                            'value' => 'CHtml::link($data->dipa_number,array("dipa/view","id"=>$data->id))',
                        ),
                        array(
                            'name' => 'dipa_date',
                            'value' => 'Yii::app()->dateFormatter->format("d MMM y",strtotime($data->dipa_date))',
                            'filter' => FALSE,
                        ),
                        array(
                            'name' => 'type',
                            'value' => '$data->type',
                            'filter' => VEnum::getEnumOptions(new Dipa, "type"),
                        ),
                        array(
                            'class' => 'bootstrap.widgets.TbButtonColumn',
                            'template' => '{view},{update}'
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="alert alert-info">
        <div class="pull-left">
            <span class="fa-stack fa-lg fa-2x">
                <i class="fa fa-database fa-stack-1x"></i>
                <i class="fa fa-ban fa-stack-2x text-danger"></i>
            </span>
        </div>
        <div class="pull-left">
            <h4>Data Master belum diinput dengan lengkap.</h4>
            <p>Silahkan lengkapi data master terlebih dahulu.</p>
        </div>
        <div class="clearfix"></div>
    </div>
<?php endif; ?>
