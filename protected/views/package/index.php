<?php if ($showContent): ?>
    <div class="panel panel-default" style="color: black">

        <div class="panel-header">
            <?php
            /*
              $this->breadcrumbs = array(
              'Packages' => array('index'),
              'Manage',
              );
             * 
             */
            ?>
            <!--<a href="<?php // echo yii::app()->baseUrl;                     ?>/package/download" class="btn btn-primary"><i class="fa fa-fw fa-download"></i> Download Form Input Paket</a>-->

            <a href="<?php echo yii::app()->baseUrl; ?>/package/entry" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> Entri Data</a>

            <a href="<?php echo yii::app()->baseUrl; ?>/package/clear" onclick="return confirm('Yakin ingin menghapus semua data paket dan akun paket?')" class="btn btn-default"><i class="fa fa fa-trash"></i>Bersihkan Data</a>

        </div>
        <div class="panel-body">
            <?php
            $this->widget('bootstrap.widgets.TbGridView', array(
                'id' => 'package-grid',
                'dataProvider' => $model->search(),
                'filter' => new Package('search'),
                'columns' => array(
                    array(
                        'header' => 'No',
                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    ),
                    array(
                        'name' => 'code',
                        'type' => 'raw',
                        'value' => 'CHtml::link($data->code,array("package/view","id"=>$data->id))',
                    ),
                    array(
                        'name' => 'name',
                        'type' => 'raw',
                        'value' => '$data->name',
                    ),
                    array(
                        'class' => 'bootstrap.widgets.TbEditableColumn',
                        'name' => 'ppk_code',
                        'sortable' => true,
                        'value' => 'isset($data->ppk->official_name)?$data->ppk->official_name:"-"',
                        'filter' => Ppk::model()->getPpkOptions(),
                        'editable' => array(
                            'type' => 'select',
                            'url' => $this->createUrl('editable'),
                            'placement' => 'bottom',
                            'inputclass' => 'span3',
                            'source' => Ppk::model()->getPpkOptions(),
                            'success' => 'js: function(data) {                                   
                                    var arr=JSON.parse(data);
                                    var url=' . CJSON::encode(Yii::app()->baseUrl . "/package/childUpdate") . ';
                                    var packageCode=arr.model["code"];
                                    var ppkCode=arr.model["ppk_code"];
                                    var provinceCode=arr.model["province_code"];
                                    var cityCode=arr.model["city_code"];
                                    $.ajax({
                                    url: url,
                                    dataType: "json",
                                    data: {
                                    code: packageCode,
                                    cityCode: cityCode,
                                    provinceCode: provinceCode,
                                    ppkCode:ppkCode,
                                    },
                                    });
                           }'
                        )
                    ),
                    array(
                        'class' => 'bootstrap.widgets.TbEditableColumn',
                        'name' => 'province_code',
                        'sortable' => false,
                        'value' => 'isset($data->province->name)?$data->province->name:"-"',
                        'filter' => Province::model()->getOptionsCodeName(),
                        'editable' => array(
                            'type' => 'select',
                            'url' => $this->createUrl('editable'),
                            'placement' => 'bottom',
                            'inputclass' => 'span3',
                            'source' => Province::model()->getOptionsCodeName(),
                            'success' => 'js: function(data) {                                   
                                    var arr=JSON.parse(data);
                                    var url=' . CJSON::encode(Yii::app()->baseUrl . "/package/childUpdate") . ';
                                    var packageCode=arr.model["code"];
                                    var ppkCode=arr.model["ppk_code"];
                                    var provinceCode=arr.model["province_code"];
                                    var cityCode=arr.model["city_code"];
                                    $.ajax({
                                    url: url,
                                    dataType: "json",
                                    data: {
                                    code: packageCode,
                                    cityCode: cityCode,
                                    provinceCode: provinceCode,
                                    ppkCode:ppkCode,
                                    },
                                    });
                           }'
                        )
                    ),
                    array(
                        'class' => 'bootstrap.widgets.TbEditableColumn',
                        'name' => 'city_code',
                        'sortable' => true,
                        'value' => 'isset($data->city->name)?$data->city->name:"-"',
                        'filter' => City::model()->getCityOptions(),
                        'editable' => array(
                            'type' => 'select',
                            'url' => $this->createUrl('editable'),
                            'placement' => 'bottom',
                            'inputclass' => 'span3',
                            'source' => City::model()->getCityOptions(),
                            'success' => 'js: function(data) {                                   
                                    var arr=JSON.parse(data);
                                    var url=' . CJSON::encode(Yii::app()->baseUrl . "/package/childUpdate") . ';
                                    var packageCode=arr.model["code"];
                                    var ppkCode=arr.model["ppk_code"];
                                    var provinceCode=arr.model["province_code"];
                                    var cityCode=arr.model["city_code"];
                                    $.ajax({
                                    url: url,
                                    dataType: "json",
                                    data: {
                                    code: packageCode,
                                    cityCode: cityCode,
                                    provinceCode: provinceCode,
                                    ppkCode:ppkCode,
                                    },
                                    });
                           }'
                        )
                    ),
//                    array(
//                        'name' => 'limit',
//                        'header' => 'Realisasi',
//                        'value' => 'Yii::app()->format->number($data->getTotal($data->code)["realization"])',
//                        'filter' => false,
//                    ),
//                    array(
//                        'name' => 'limit',
//                        'header' => 'Sisa Pagu',
//                        'value' => 'Yii::app()->format->number($data->getTotal($data->code)["restMoney"])',
//                        'filter' => false,
//                    ),
//                    array(
//                        'header' => 'Penyerapan',
//                        'name' => 'limit',
//                        'type' => 'raw',
//                        'filter' => false,
//                        'htmlOptions' => array('style' => 'text-align: right;'),
//                        'value' => function($data) {
//                    $rate = $data->getTotal($data->code)['rate'];
//                    return "<div class='slider' data-progress='$rate'><span></span><label></label></div>";
//                }
//                    ),
                    array(
                        'class' => 'bootstrap.widgets.TbButtonColumn',
                        'template' => '{view}'
                    ),
                ),
            ));
            ?>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info">
        <div class="pull-left">
            <span class="fa-stack fa-lg fa-2x">
                <i class="fa fa-database fa-stack-1x"></i>
                <i class="fa fa-ban fa-stack-2x text-danger"></i>
            </span>
        </div>
        <div class="pull-left">
            <h4>Data DIPA belum diinput.</h4>
            <p>Silahkan input DIPA terlebih dahulu.</p>
        </div>
        <div class="clearfix"></div>
    </div>
<?php endif; ?>
