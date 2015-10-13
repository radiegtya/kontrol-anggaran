<div class="dashboard-a">
    <div class="row-fluid">
        <div class="span6">
            <div class="dashboard-a-left">
                <h3>
                    <h3>
                        SATKER                                   <em><?php echo $data->name; ?></em>
                    </h3>

                    <h4>Dana Terserap :</h4>
                    <h2>Rp <?php echo Yii::app()->format->number($realization, 2); ?></h2>
                    <div class="progress progress-striped active">
                        <div class="bar" style="width:<?php echo $rate; ?>%;"></div>
                    </div>
                    <p>Dari total pagu <span>Rp <?php echo Yii::app()->format->number($limit, 2); ?></span></p>
                </h3>
            </div>
        </div>
        <div class="span6">
            <div class="dashboard-a-right">
                <div class="top">
                    <a href="http://bpkonstruksi.pu.go.id/" style="text-decoration: none">
                        <b><br /></b>
                        <i class="fa fa-globe fa-2x"></i>
                    </a>
                    <a href="https://plus.google.com/101592533710582022471/" style="text-decoration: none">
                        <b><br /></b>
                        <i class="fa fa-google-plus fa-2x"></i>
                    </a>
                    <a href="https://www.facebook.com/pusbinkpkPU" style="text-decoration: none">
                        <b><br /></b>
                        <i class="fa fa-facebook fa-3x"></i>
                    </a>
                </div>
                <div class="bottom">
                    <a href="https://twitter.com/pusbinkpk" style="text-decoration: none">
                        <b><br /></b>
                        <i class="fa fa-twitter fa-2x"></i>
                    </a>
                    <a href="https://www.youtube.com/user/pusbinkpkpu" style="text-decoration: none">
                        <b><br /></b>
                        <i class="fa fa-youtube fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($data): ?>
    <?php if ($ppks): ?>
        <div class="row-fluid" style="color:black">
            <?php foreach ($ppks as $ppk): ?>
                <div class="span6 chart-item">
                    <div class="flex">
                        <div class="chart-item-left">
                            <h3>
                                <?php echo $ppk->official_name; ?>
                                <em><?php echo $ppk->ppk_name; ?></em>
                            </h3>

                            <h4>Dana Terserap :</h4>
                            <h2 class="text-info">Rp <?php echo number_format($realizationPpk[$ppk->code], 2); ?></h2>
                            <div class="progress progress-striped active">
                                <div class="bar" style="width:<?php echo number_format($ratePpk[$ppk->code], 2); ?>%;"></div>
                            </div>
                            <p>Dari total pagu <span>Rp <?php echo number_format($limitPpk[$ppk->code], 2); ?></span></p>
                        </div>
                        <div class="chart-item-right">
                            <div class="pie-chart" data-percent="<?php echo number_format($ratePpk[$ppk->code], 2); ?>"><span class="percent"></span></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>