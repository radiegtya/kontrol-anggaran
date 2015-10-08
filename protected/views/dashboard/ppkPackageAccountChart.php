<div class="panel">
    <div class="panel-header">
        <h3>Diagram Penyerapan Anggaran Paket <?php echo $package->name; ?> Per Akun dengan PPK <?php echo $package->ppk->official_name; ?></h3>
    </div>

    <div class="panel-body">
        <div class="charts">
            <?php foreach ($packageAccounts as $packageAccount): ?>
                <div class="chart-items">
                    <div class="chart-item">
                        <a><?php echo $packageAccount->account->name . " [" . $packageAccount->account_code . "] "; ?></a>
                        <div class="bar-chart-container">
                            <div class="bar-chart" data-content="<table><tbody><tr><th><b>Pagu</b></th><th><?php echo number_format($packageAccount->limit, 2); ?></th></tr><tr><th><b>Realisasi<b></th><th><?php echo number_format($packageAccount->getTotal($packageAccount->code)['realization'], 2); ?></th></tr><tr><th><b>Saldo</b></th><th><?php echo number_format($packageAccount->getTotal($packageAccount->code)['restMoney'], 2); ?></th></tr></tbody></table>" data-toggle="popover" data-placement="top" >
                                <span style="width: <?php echo number_format(($packageAccount->getTotal($packageAccount->code)['realization'] / $packageAccount->limit ) * 100, 2); ?>%"></span>
                                <label><?php echo number_format(($packageAccount->getTotal($packageAccount->code)['realization'] / $packageAccount->limit ) * 100, 2); ?>%</label>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="chart-legend">
                <span class="a"><i></i>Realisasi</span>
                <span class="b"><i></i>Saldo</span>
            </div>
        </div>
    </div>
</div>