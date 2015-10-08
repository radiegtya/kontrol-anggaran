<div class="panel">
    <div class="panel-header">
        <h3>Diagram Penyerapan Anggaran Kegiatan <?php echo $activity->name; ?> Per Output</h3>
    </div>

    <div class="panel-body">
        <div class="charts">
            <?php foreach ($outputs as $output): ?>
                <?php if (isset($rate[$output->id])): ?>

                    <div class="chart-items">
                        <div class="chart-item">
                            <a href="<?php echo Yii::app()->baseUrl . '/dashboard/suboutputChart/' . $output->id; ?>"><?php echo $output->name; ?></a>
                            <div class="bar-chart-container">
                                <div class="bar-chart" data-content="<table><tbody><tr><th><b>Pagu</b></th><th><?php echo number_format($limit[$output->id], 2); ?></th></tr><tr><th><b>Realisasi<b></th><th><?php echo number_format($realization[$output->id], 2); ?></th></tr><tr><th><b>Saldo</b></th><th><?php echo number_format($rest[$output->id], 2); ?></th></tr></tbody></table>" data-toggle="popover" data-placement="top" >
                                    <span style="width: <?php echo number_format($rate[$output->id] * 100, 2); ?>%"></span>
                                    <label><?php echo number_format($rate[$output->id] * 100, 2); ?>%</label>
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