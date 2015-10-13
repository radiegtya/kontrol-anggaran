<div class="panel">
    <div class="panel-header">
        <h3>Diagram Penyerapan Anggaran Paket <?php echo $package->name; ?> Per Akun</h3>
    </div>

    <div class="panel-body">
        <div class="charts">
            <?php foreach ($packageAccounts as $packageAccount): ?>
                <?php if (isset($rate[$packageAccount->id])): ?>
                    <div class="chart-items">
                        <div class="chart-item">
                            <a><?php echo $packageAccount->account->name . " [" . $packageAccount->account_code . "]"; ?></a>
                            <div class="bar-chart-container">
                                <div class="bar-chart" data-content="<table><tbody><tr><th><b>Pagu</b></th><th><?php echo number_format($limit[$packageAccount->id], 2); ?></th></tr><tr><th><b>Realisasi<b></th><th><?php echo number_format($realization[$packageAccount->id], 2); ?></th></tr><tr><th><b>Saldo</b></th><th><?php echo number_format($rest[$packageAccount->id], 2); ?></th></tr></tbody></table>" data-toggle="popover" data-placement="top" >
                                    <span style="width: <?php echo isset($rate[$packageAccount->id]) ? number_format($rate[$packageAccount->id] * 100, 2) : 0; ?>%"></span>
                                    <label><?php echo number_format($rate[$packageAccount->id] * 100, 2); ?>%</label>
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