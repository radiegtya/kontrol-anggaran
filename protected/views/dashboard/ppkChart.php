<div class="toolbar">
    <div class="panel">
        <div class="panel-header">
            <h3>Diagram Penyerapan Anggaran Per Ppk</h3>
        </div>

        <div class="panel-body">
            <div class="charts">
                <?php foreach ($models as $model): ?>
                    <?php if (isset($rate[$model->id])): ?>
                        <div class="chart-items">
                            <div class="chart-item">
                                <a href="<?php echo Yii::app()->baseUrl . '/dashboard/ppkActivityChart/' . $model->id; ?>"><?php echo $model->ppk_name . '</br> [ ' . $model->official_name . ' ]'; ?></a>
                                <div class="bar-chart">
                                    <span style="width: <?php echo isset($rate[$model->id]) ? number_format($rate[$model->id] * 100, 2) : 0; ?>%"></span>
                                    <label><?php echo number_format($rate[$model->id] * 100, 2); ?>%</label>
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
</div>