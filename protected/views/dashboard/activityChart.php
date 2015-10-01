<div class="panel">
    <div class="panel-header">
        <h3>Diagram Penyerapan Anggaran Satker <?php echo $satker->name; ?> Per Kegiatan</h3>
    </div>

    <div class="panel-body">
        <div class="charts">
            <?php foreach ($activities as $activity): ?>
                <?php if (isset($rate[$activity->id])): ?>
                    <div class="chart-items">
                        <div class="chart-item">
                            <?php echo CHtml::link($activity->name, array("dashboard/outputChart", "id" => $activity->id)); ?>
                            <div class="bar-chart-container">
                                <div class="bar-chart" data-content="<table><tbody><tr><th><b>Pagu</b></th><th><?php echo number_format($limit[$activity->id], 2); ?></th></tr><tr><th><b>Realisasi<b></th><th><?php echo number_format($realization[$activity->id], 2); ?></th></tr><tr><th><b>Saldo</b></th><th><?php echo number_format($rest[$activity->id], 2); ?></th></tr></tbody></table>" data-toggle="popover" data-placement="top" >
                                    <span style="width: <?php echo isset($rate[$activity->id]) ? number_format($rate[$activity->id] * 100, 2) : 0; ?>%"></span>
                                    <label><?php echo number_format($rate[$activity->id] * 100, 2); ?>%</label>
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