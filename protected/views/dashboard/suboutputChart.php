<div class="panel">
    <div class="panel-header">
        <h3>Diagram Penyerapan Anggaran Output <?php echo $output->name; ?> Per Suboutput</h3>
    </div>

    <div class="panel-body">
        <div class="charts">
            <?php foreach ($suboutputs as $suboutput): ?>
                <?php if (isset($rate[$suboutput->id])): ?>
                    <div class="chart-items">
                        <div class="chart-item">
                            <a href="<?php echo Yii::app()->baseUrl . '/dashboard/componentChart/' . $suboutput->id; ?>"><?php echo $suboutput->name; ?></a>
                            <div class="bar-chart-container">
                                <div class="bar-chart" data-content="<table><tbody><tr><th><b>Pagu</b></th><th><?php echo number_format($limit[$suboutput->id], 2); ?></th></tr><tr><th><b>Realisasi<b></th><th><?php echo number_format($realization[$suboutput->id], 2); ?></th></tr><tr><th><b>Saldo</b></th><th><?php echo number_format($rest[$suboutput->id], 2); ?></th></tr></tbody></table>" data-toggle="popover" data-placement="top" >
                                    <span style="width: <?php echo isset($rate[$suboutput->id]) ? number_format($rate[$suboutput->id] * 100, 2) : 0; ?>%"></span>
                                    <label><?php echo number_format($rate[$suboutput->id] * 100, 2); ?>%</label>
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