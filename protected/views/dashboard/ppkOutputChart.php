<div class="panel">
    <div class="panel-header">
        <h3>Diagram Penyerapan Anggaran Ppk <?php echo $ppk->official_name; ?> Per Output</h3>
    </div>

    <div class="panel-body">
        <div class="charts">
            <?php for ($i = 0; $i < count($outputLists); $i++): ?>
                <div class="chart-items">
                    <div class="chart-item">
                        <?php echo CHtml::link($outputLists[$i], array("dashboard/ppkSuboutputChart", "id" => $id[$i], "ppkId" => $ppk->id)); ?>
                        <div class="bar-chart-container">
                            <div class="bar-chart" data-content="<table><tbody><tr><th><b>Pagu</b></th><th><?php echo number_format($limits[$i], 2); ?></th></tr><tr><th><b>Realisasi<b></th><th><?php echo number_format($realizations[$i], 2); ?></th></tr><tr><th><b>Saldo</b></th><th><?php echo number_format($rests[$i], 2); ?></th></tr></tbody></table>" data-toggle="popover" data-placement="top" >
                                <span style="width: <?php echo number_format($rates[$i] * 100, 2); ?>%"></span>
                                <label><?php echo number_format($rates[$i] * 100, 2); ?>%</label>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
            <div class="chart-legend">
                <span class="a"><i></i>Realisasi</span>
                <span class="b"><i></i>Saldo</span>
            </div>
        </div>
    </div>
</div>