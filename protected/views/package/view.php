<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <a href="<?php echo Yii::app()->baseUrl . '/package/index'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Kembali ke Daftar Paket Pekerjaan</a>
    </div>
    <div class="panel-body">

        <div class="row-fluid">
            <div class="span6">
                <table class="table table-h-border">
                    <tbody>
                        <tr>
                            <td><b>Satker</b></td>
                            <td><?php echo isset($model->satker->name) ? $model->satker->name : '-'; ?></td>
                        </tr>
                        <tr>
                            <td><b>PPK</b></td>
                            <td><?php echo isset($model->ppk->official_name) ? $model->ppk->official_name : '-'; ?></td>
                        </tr>
                        <tr>
                            <td><b>Kegiatan</b></td>
                            <td><?php echo isset($model->activity->name) ? $model->activity->name : '-'; ?></td>
                        </tr>
                        <tr>
                            <td><b>Output</b></td>
                            <td><?php echo isset($model->output->name) ? $model->output->name : '-'; ?></td>
                        </tr>
                        <tr>
                            <td><b>Suboutput</b></td>
                            <td><?php echo isset($model->suboutput->name) ? $model->suboutput->name : '-'; ?></td>
                        </tr>
                        <tr>
                            <td><b>Komponen</b></td>
                            <td><?php echo isset($model->component->name) ? $model->component->name : '-'; ?></td>
                        </tr>
                        <tr>
                            <td><b>Provinsi</b></td>
                            <td><?php echo isset($model->province->name) ? $model->province->name : '-'; ?></td>
                        </tr>
                        <tr>
                            <td><b>Kota</b></td>
                            <td><?php echo isset($model->city->name) ? $model->city->name : '-'; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="span6">
                <div class="table-responsive">
                    <table class="table table-vh-border bordered-table">
                        <tbody>

                            <tr>
                                <td><b>Pagu</b></td>
                                <td>Rp <?php echo Yii::app()->format->number($model->getTotal($model->code)['limit']);   ?></td>
                            </tr>
                            <tr>
                                <td><b>Realisasi</b></td>
                                <td>Rp <?php echo Yii::app()->format->number($model->getTotal($model->code)['realization']);   ?></td>
                            </tr>
                            <tr>
                                <td><b>Sisa</b></td>
                                <td>Rp <?php echo Yii::app()->format->number($model->getTotal($model->code)['restMoney']);   ?></td>
                            </tr>
                            <tr>
                                <td><b>Penyerapan</b></td>
                                <td><?php echo $model->getTotal($model->code)['rate'] * 100;   ?>%</td>
                            </tr>
                            <tr>
                                <td><b>Dibuat</b></td>
                                <td><?php echo Yii::app()->dateFormatter->format('dd MMM yyyy', $model->created_at);
?></td>
                            </tr>
                            <tr>
                                <td><b>Oleh</b></td>
                                <td><?php echo $model->user->username; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <h5><i class="fa fa-fw fa-list"></i>Akun Paket</h5>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'package-account-grid',
            'dataProvider' => $packageAccount->searchPackage($model->code),
            'columns' => array(
                array(
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                ),
                array(
                    'name' => 'account_code',
                    'value' => 'isset($data->account->name) ? "[".$data->account_code."] ".$data->account->name : $data->account_code',
                ),
                array(
                    'name' => 'limit',
                    'value' => 'Yii::app()->format->number($data->limit)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Realisasi',
                    'name' => 'limit',
                    'value' => 'Yii::app()->format->number($data->getTotal($data->code)["realization"])',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Sisa UP',
                    'name' => 'limit',
                    'value' => 'Yii::app()->format->number($data->getTotal($data->code)["restMoney"])',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Penyerapan',
                    'name' => 'limit',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'value' => function($data) {
                $rate = $data->getTotal($data->code)['rate'];
                return "<div class='slider' data-progress='$rate'><span></span><label></label></div>";
            }
                ),
            ),
        ));
        ?>
    </div>
</div>
<?php
/**
 * 
  <div class="panel panel-default" style="color: black">
  <div class="panel-header">
  <h5 class="box"><i class="fa fa-fw fa-history"></i>Riwayat Realisasi</h5>
  </div>
  <div class="panel-body">
  <?php
  $this->widget('bootstrap.widgets.TbGridView', array(
  'id' => 'realization-grid',
  'dataProvider' => $realization->searchPackage($model->code),
  'columns' => array(
  array(
  'header' => 'No',
  'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
  ),
  array(
  'name' => 'created_at',
  'header' => 'Tanggal',
  'value' => 'Yii::app()->dateFormatter->format("d MMM y", strtotime($data->created_at))',
  ),
  array(
  'name' => 'packageAccount_code',
  'value' => '$data->packageAccount->account_code',
  'header' => 'Kode Akun Paket',
  'filter' => FALSE,
  ),
  array(
  'name' => 'packageAccount_code',
  'value' => 'isset($data->packageAccount->package->name)?$data->packageAccount->package->name." - "." [".$data->packageAccount->account_code."] ".$data->packageAccount->account->name:$data->packageAccount_code',
  ),
  array(
  "name" => "use_up",
  "value" => '$data->use_up',
  'filter' => FALSE,
  ),
  array(
  "name" => "total_spm",
  "value" => 'Yii::app()->format->number($data->total_spm)',
  'htmlOptions' => array('style' => 'text-align: right;'),
  'filter' => FALSE,
  ),
  ),
  ));
  ?>
  </div>
  </div>
 */
?>

