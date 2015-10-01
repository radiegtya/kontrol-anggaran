<div class="row-fluid">
    <div class="span6">
        <div class="panel panel-default">
            <div class="panel-header">
                <?php
                /*
                  $this->breadcrumbs = array(
                  'Nrks' => array('index'),
                  $model->id,
                  );
                 * 
                 */
                ?>
                <a href="<?php echo Yii::app()->baseUrl . '/nrk/admin'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Daftar</a>
                <a href="<?php echo Yii::app()->baseUrl . '/nrk/create'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>Tambah</a>
                <a href="<?php echo Yii::app()->baseUrl . '/nrk/update/' . $model->id; ?>" class="btn btn-primary"><i class="fa fa-fw fa-pencil"></i>Update</a>
            </div>
            <div class="panel-body">
                <?php
                $this->widget('bootstrap.widgets.TbDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'nrk',
                        'contract_number',
                        array(
                            'name' => 'contract_date',
                            'value' => Yii::app()->dateFormatter->format('dd MMM yyyy', $model->contract_date),
                        ),
                        array(
                            'name' => 'limit',
                            'value' => Yii::app()->format->number($model->limit),
                        ),
                        array(
                            'name' => 'created_at',
                            'value' => Yii::app()->dateFormatter->format('dd MMM yyyy', $model->created_at),
                        ),
                        array(
                            'name' => 'created_by',
                            'value' => $model->createdBy->username,
                            'source' => User::model()->getOptions(),
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="panel panel-default">
            <div class="panel-header">
                Termin
            </div>
            <div class="panel-body">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Termin</th>
                            <th>Pagu</th>
                            <th></th>
                        </tr>
                    </thead>
                    <!--Form--><?php echo $this->renderPartial('../nrkDetail/_form', array('model' => $addDetail)); ?>
                </table>
                <?php
                $this->widget('bootstrap.widgets.TbGridView', array(
                    'id' => 'nrk-detail-grid',
                    'dataProvider' => $modelDetail->searchDetail($register, $number),
                    'columns' => array(
                        array(
                            'name' => 'termin',
                            'value' => '$data->termin',
                            'htmlOptions' => array('style' => 'text-align: center;'),
                            'headerHtmlOptions' => array('style' => 'text-align: center;'),
                            'filter' => FALSE,
                        ),
                        array(
                            "name" => "limit_per_termin",
                            "value" => 'Yii::app()->format->number($data->limit_per_termin)',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'headerHtmlOptions' => array('style' => 'text-align: right;'),
                            'filter' => FALSE,
                        ),
                        array(
                            'class' => 'bootstrap.widgets.TbButtonColumn',
                            'template' => '{update}{delete}',
                            'buttons' => array(
                                'update' => array('url' => 'CHtml::normalizeUrl(array("updateDetail","id"=>$data->id))'),
                                'delete' => array('url' => 'Yii::app()->createUrl("nrkDetail/delete",array("id"=>"$data->id"))'),
                            ),
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
