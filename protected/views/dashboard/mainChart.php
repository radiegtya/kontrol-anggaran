<!--<div style="color:Black">
    <h4>Under Maintenance</h4>
</div>-->

<div class="panel" style="color: black">
    <div class="panel-header">
        <h3>Diagram Penyerapan Anggaran Per Satker</h3>
    </div>
    <div class="panel-body">
        <div class="charts">
            <?php foreach ($models as $model): ?>
                <?php if (isset($rate[$model->id])): ?>
                    <div class="chart-items">
                        <div class="chart-item">
                            <a href="<?php echo Yii::app()->baseUrl . '/dashboard/activityChart/' . $model->id; ?>"><?php echo 'SATKER - ' . $model->name; ?></a>
                            <div class="bar-chart-container">
                                <div class="bar-chart" data-content="<table><tbody><tr><th><b>Pagu</b></th><th><?php echo number_format($limit[$model->id], 2); ?></th></tr><tr><th><b>Realisasi<b></th><th><?php echo number_format($realization[$model->id], 2); ?></th></tr><tr><th><b>Saldo</b></th><th><?php echo number_format($rest[$model->id], 2); ?></th></tr></tbody></table>" data-toggle="popover" data-placement="top" >
                                    <span style="width: <?php echo isset($rate[$model->id]) ? number_format($rate[$model->id] * 100, 2) : 0; ?>%"></span>
                                    <label><?php echo number_format($rate[$model->id] * 100, 2) ?>%</label>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if ($legend == TRUE): ?>
                <div class="chart-legend">
                    <span class="a"><i></i>Realisasi</span>
                    <span class="b"><i></i>Saldo</span>
                </div>
            <?php else: ?>
                <p>Data Tidak ditemukan</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
/**
  <div class="panel">
  <div class="panel-header">
  <h3>Diagram Penyerapan Anggaran Per PPK</h3>
  </div>
  <div class="panel-body">
  <div class="charts">
  <?php foreach ($modelPpks as $modelPpk): ?>
  <?php if (isset($ratePpk[$modelPpk->id])): ?>
  <div class="chart-items">
  <div class="chart-item">
  <a href="<?php echo Yii::app()->baseUrl . '/dashboard/ppkActivityChart/' . $modelPpk->id; ?>"><?php echo $modelPpk->official_name; ?></a>
  <!--<a><?php // echo $modelPpk->official_name;   ?></a>-->
  <div class="bar-chart-container">
  <div class="bar-chart" data-content="<table><tbody><tr><th><b>Pagu</b></th><th><?php echo number_format($limitPpk[$modelPpk->id], 2); ?></th></tr><tr><th><b>Realisasi<b></th><th><?php echo number_format($realizationPpk[$modelPpk->id], 2); ?></th></tr><tr><th><b>Saldo</b></th><th><?php echo number_format($restPpk[$modelPpk->id], 2); ?></th></tr></tbody></table>" data-toggle="popover" data-placement="top" >
  <span style="width: <?php echo isset($ratePpk[$modelPpk->id]) ? number_format($ratePpk[$modelPpk->id] * 100, 2) : 0; ?>%"></span>
  <label><?php echo number_format($ratePpk[$modelPpk->id] * 100, 2); ?>%</label>
  </div>
  </div>
  </div>
  </div>
  <?php endif; ?>
  <?php endforeach; ?>
  <?php if ($legendPpk == TRUE): ?>
  <div class="chart-legend">
  <span class="a"><i></i>Realisasi</span>
  <span class="b"><i></i>Saldo</span>
  </div>
  <?php else: ?>
  <p>Data Tidak ditemukan</p>
  <?php endif; ?>
  </div>
  </div>
 *
 */
?>