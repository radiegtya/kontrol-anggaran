<div class="panel">
    <div class="panel-header">
        <h3>Diagram Penyerapan Anggaran Satker <?php echo $component->satker->name; ?>  Per Paket</h3>
    </div>
    <div class="panel-body">
        <div class="charts">
            <?php foreach ($subcomponents as $subcomponent): ?>
                <?php if (isset($rate[$subcomponent->id])): ?>
                    <div class="chart-items">
                        <div class="chart-item">
                            <a href="<?php echo Yii::app()->baseUrl . '/dashboard/accountChart/' . $subcomponent->id; ?>"><?php echo $subcomponent->name; ?></a>
                            <div class="bar-chart-container">
                                <div class="bar-chart" data-content="<table><tbody><tr><th><b>Pagu</b></th><th><?php echo number_format($limit[$subcomponent->id], 2); ?></th></tr><tr><th><b>Realisasi<b></th><th><?php echo number_format($realization[$subcomponent->id], 2); ?></th></tr><tr><th><b>Saldo</b></th><th><?php echo number_format($rest[$subcomponent->id], 2); ?></th></tr></tbody></table>" data-toggle="popover" data-placement="top" >
                                    <span style="width: <?php echo number_format($rate[$subcomponent->id] * 100, 2); ?>%"></span>
                                    <label><?php echo number_format($rate[$subcomponent->id] * 100, 2); ?>%</label>
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